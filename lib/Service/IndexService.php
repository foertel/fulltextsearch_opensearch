<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Service;

use OCA\FullTextSearch_OpenSearch\Exceptions\AccessIsEmptyException;
use OCA\FullTextSearch_OpenSearch\Exceptions\ConfigurationException;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Client;
use OCP\FullTextSearch\Model\IIndex;
use OCP\FullTextSearch\Model\IIndexDocument;
use Psr\Log\LoggerInterface;

class IndexService {
	public function __construct(
		private IndexMappingService $indexMappingService,
		private LoggerInterface $logger,
	) {
	}

	/**
	 * @throws ConfigurationException
	 */
	public function initializeIndex(Client $client): void {
		try {
			$exists = $client->indices()->exists($this->indexMappingService->generateGlobalMap(false));
			if ($exists) {
				return;
			}
		} catch (\Exception $e) {
			$this->logger->error($e->getMessage(), ['exception' => $e]);
		}

		try {
			$client->indices()->create($this->indexMappingService->generateGlobalMap());
		} catch (\Exception $e) {
			$this->logger->error('Failed to create index, resetting', ['exception' => $e]);
			$this->resetIndexAll($client);
		}

		try {
			$client->ingest()->putPipeline($this->indexMappingService->generateGlobalIngest());
		} catch (\Exception $e) {
			$this->logger->error('Failed to create ingest pipeline, resetting', ['exception' => $e]);
			$this->resetIndexAll($client);
		}
	}

	/**
	 * @throws ConfigurationException
	 */
	public function resetIndex(Client $client, string $providerId): void {
		try {
			$client->deleteByQuery($this->indexMappingService->generateDeleteQuery($providerId));
		} catch (\Exception $e) {
			$this->logger->error('Failed to reset index for provider: ' . $providerId, ['exception' => $e]);
		}
	}

	/**
	 * @throws ConfigurationException
	 */
	public function resetIndexAll(Client $client): void {
		try {
			$client->ingest()->deletePipeline($this->indexMappingService->generateGlobalIngest(false));
		} catch (\Exception $e) {
			$this->logger->warning($e->getMessage(), ['exception' => $e]);
		}

		try {
			$client->indices()->delete($this->indexMappingService->generateGlobalMap(false));
		} catch (\Exception $e) {
			$this->logger->warning($e->getMessage(), ['exception' => $e]);
		}
	}

	/**
	 * @throws ConfigurationException
	 */
	public function deleteIndex(Client $client, IIndex $index): void {
		$this->indexMappingService->indexDocumentRemove(
			$client,
			$index->getProviderId(),
			$index->getDocumentId()
		);
	}

	/**
	 * @throws ConfigurationException
	 * @throws AccessIsEmptyException
	 */
	public function indexDocument(Client $client, IIndexDocument $document): array {
		$result = [];
		$index = $document->getIndex();

		if ($index->isStatus(IIndex::INDEX_REMOVE)) {
			$this->indexMappingService->indexDocumentRemove(
				$client, $document->getProviderId(), $document->getId()
			);
		} elseif ($index->isStatus(IIndex::INDEX_OK)
				  && !$index->isStatus(IIndex::INDEX_CONTENT)
				  && !$index->isStatus(IIndex::INDEX_META)) {
			$result = $this->indexMappingService->indexDocumentUpdate($client, $document);
		} else {
			$result = $this->indexMappingService->indexDocumentNew($client, $document);
		}

		return $result;
	}

	public function parseIndexResult(IIndex $index, array $result): IIndex {
		$index->setLastIndex();

		if (array_key_exists('exception', $result)) {
			$index->setStatus(IIndex::INDEX_FAILED);
			$index->addError(
				$result['message'] ?? $result['exception'],
				'',
				IIndex::ERROR_SEV_3
			);

			return $index;
		}

		if ($index->getErrorCount() === 0) {
			$index->setStatus(IIndex::INDEX_DONE);
		}

		return $index;
	}
}
