<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Platform;

use Exception;
use InvalidArgumentException;
use OCA\FullTextSearch_OpenSearch\ConfigLexicon;
use OCA\FullTextSearch_OpenSearch\Exceptions\AccessIsEmptyException;
use OCA\FullTextSearch_OpenSearch\Exceptions\ClientException;
use OCA\FullTextSearch_OpenSearch\Exceptions\ConfigurationException;
use OCA\FullTextSearch_OpenSearch\Service\ClientService;
use OCA\FullTextSearch_OpenSearch\Service\ConfigService;
use OCA\FullTextSearch_OpenSearch\Service\IndexService;
use OCA\FullTextSearch_OpenSearch\Service\SearchService;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Common\Exceptions\NoNodesAvailableException;
use OCP\FullTextSearch\Exceptions\PlatformTemporaryException;
use OCP\FullTextSearch\IFullTextSearchPlatform;
use OCP\FullTextSearch\Model\IDocumentAccess;
use OCP\FullTextSearch\Model\IIndex;
use OCP\FullTextSearch\Model\IIndexDocument;
use OCP\FullTextSearch\Model\IRunner;
use OCP\FullTextSearch\Model\ISearchResult;
use Psr\Log\LoggerInterface;

class OpenSearchPlatform implements IFullTextSearchPlatform {
	private ?IRunner $runner = null;

	public function __construct(
		private ClientService $clientService,
		private ConfigService $configService,
		private IndexService $indexService,
		private SearchService $searchService,
		private LoggerInterface $logger,
	) {
	}

	public function getId(): string {
		return 'opensearch';
	}

	public function getName(): string {
		return 'OpenSearch';
	}

	/**
	 * @throws ConfigurationException
	 */
	public function getConfiguration(): array {
		$result = $this->configService->getConfig();

		$sanitizedHosts = [];
		$hosts = $this->configService->getOpenSearchHost();
		foreach ($hosts as $host) {
			$parsedHost = parse_url($host);
			$safeHost = ($parsedHost['scheme'] ?? 'http') . '://';
			if (isset($parsedHost['user'])) {
				$safeHost .= $parsedHost['user'] . ':********@';
			}
			$safeHost .= $parsedHost['host'] ?? 'localhost';
			if (isset($parsedHost['port'])) {
				$safeHost .= ':' . $parsedHost['port'];
			}
			$sanitizedHosts[] = $safeHost;
		}

		$result[ConfigLexicon::OPENSEARCH_HOST] = $sanitizedHosts;

		return $result;
	}

	public function setRunner(IRunner $runner): void {
		$this->runner = $runner;
	}

	/**
	 * @throws ConfigurationException
	 */
	public function loadPlatform(): void {
		$this->clientService->getClient();
	}

	public function testPlatform(): bool {
		try {
			$result = $this->clientService->getClient()->ping();
			return (bool)$result;
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * @throws ConfigurationException
	 */
	public function initializeIndex(): void {
		$this->indexService->initializeIndex($this->clientService->getClient());
	}

	/**
	 * @throws ConfigurationException
	 */
	public function resetIndex(string $providerId): void {
		$client = $this->clientService->getClient();
		if ($providerId === 'all') {
			$this->indexService->resetIndexAll($client);
		} else {
			$this->indexService->resetIndex($client, $providerId);
		}
	}

	public function indexDocument(IIndexDocument $document): IIndex {
		$document->initHash();
		try {
			$result = $this->indexService->indexDocument($this->clientService->getClient(), $document);
			$index = $this->indexService->parseIndexResult($document->getIndex(), $result);

			$this->updateNewIndexResult(
				$document->getIndex(), json_encode($result), 'ok',
				IRunner::RESULT_TYPE_SUCCESS
			);

			return $index;
		} catch (NoNodesAvailableException $e) {
			throw new PlatformTemporaryException();
		} catch (Exception $e) {
			$this->manageIndexErrorException($document, $e);
		}

		try {
			$result = $this->indexDocumentError($document, $e);
			$index = $this->indexService->parseIndexResult($document->getIndex(), $result);

			$this->updateNewIndexResult(
				$document->getIndex(), json_encode($result), 'ok',
				IRunner::RESULT_TYPE_WARNING
			);

			return $index;
		} catch (Exception $e) {
			$this->updateNewIndexResult(
				$document->getIndex(), '', 'fail',
				IRunner::RESULT_TYPE_FAIL
			);
			$this->manageIndexErrorException($document, $e);
		}

		return $document->getIndex();
	}

	/**
	 * @throws AccessIsEmptyException
	 * @throws ConfigurationException
	 */
	private function indexDocumentError(IIndexDocument $document, Exception $e): array {
		$this->updateRunnerAction('indexDocumentWithoutContent', true);
		$document->setContent('');

		return $this->indexService->indexDocument($this->clientService->getClient(), $document);
	}

	private function manageIndexErrorException(IIndexDocument $document, Exception $e): void {
		[$level, $message, $status] = $this->parseIndexErrorException($e);
		switch ($level) {
			case 'error':
				$document->getIndex()
						 ->addError($message, get_class($e), IIndex::ERROR_SEV_3);
				$this->updateNewIndexError(
					$document->getIndex(), $message, get_class($e), IIndex::ERROR_SEV_3
				);
				break;

			case 'notice':
				$this->updateNewIndexResult(
					$document->getIndex(), $message, $status,
					IRunner::RESULT_TYPE_WARNING
				);
				break;
		}
	}

	private function parseIndexErrorException(Exception $e): array {
		$arr = json_decode($e->getMessage(), true);
		if (!is_array($arr)) {
			return ['error', $e->getMessage(), ''];
		}

		$error = $arr['error'] ?? [];
		if (empty($error)) {
			return ['error', $e->getMessage(), ''];
		}

		try {
			return $this->parseCausedBy($error);
		} catch (InvalidArgumentException $ex) {
		}

		$cause = $error['root_cause'] ?? [];
		if (!empty($cause) && ($cause[0]['reason'] ?? '') !== '') {
			return ['error', $cause[0]['reason'], $cause[0]['type'] ?? ''];
		}

		return ['error', $e->getMessage(), ''];
	}

	/**
	 * @throws InvalidArgumentException
	 */
	private function parseCausedBy(array $error): array {
		$causedBy = $error['caused_by']['caused_by'] ?? ($error['caused_by'] ?? []);

		if (empty($causedBy)) {
			if (($error['reason'] ?? '') === '') {
				throw new InvalidArgumentException('Unable to parse given response structure');
			}

			return ['error', $error['reason'], $error['type'] ?? ''];
		}

		$warnings = [
			'encrypted_document_exception',
			'invalid_password_exception',
		];

		$level = in_array($causedBy['type'] ?? '', $warnings) ? 'notice' : 'error';

		return [$level, $causedBy['reason'] ?? '', $causedBy['type'] ?? ''];
	}

	public function deleteIndexes(array $indexes): void {
		foreach ($indexes as $index) {
			try {
				$this->indexService->deleteIndex($this->clientService->getClient(), $index);
				$this->updateNewIndexResult($index, 'index deleted', 'success', IRunner::RESULT_TYPE_SUCCESS);
			} catch (Exception $e) {
				$this->updateNewIndexResult(
					$index, 'index not deleted', 'issue while deleting index', IRunner::RESULT_TYPE_WARNING
				);
			}
		}
	}

	/**
	 * @throws Exception
	 */
	public function searchRequest(ISearchResult $result, IDocumentAccess $access): void {
		$this->searchService->searchRequest($this->clientService->getClient(), $result, $access);
	}

	/**
	 * @throws ConfigurationException
	 */
	public function getDocument(string $providerId, string $documentId): IIndexDocument {
		return $this->searchService->getDocument($this->clientService->getClient(), $providerId, $documentId);
	}

	private function updateRunnerAction(string $action, bool $force = false): void {
		if ($this->runner === null) {
			return;
		}

		$this->runner->updateAction($action, $force);
	}

	private function updateNewIndexError(IIndex $index, string $message, string $exception, int $sev): void {
		if ($this->runner === null) {
			return;
		}

		$this->runner->newIndexError($index, $message, $exception, $sev);
	}

	private function updateNewIndexResult(IIndex $index, string $message, string $status, int $type): void {
		if ($this->runner === null) {
			return;
		}

		$this->runner->newIndexResult($index, $message, $status, $type);
	}
}
