<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Service;

use Exception;
use OC\FullTextSearch\Model\DocumentAccess;
use OC\FullTextSearch\Model\IndexDocument;
use OCA\FullTextSearch_OpenSearch\Exceptions\ConfigurationException;
use OCA\FullTextSearch_OpenSearch\Exceptions\SearchQueryGenerationException;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Client;
use OCP\FullTextSearch\Model\IDocumentAccess;
use OCP\FullTextSearch\Model\IIndexDocument;
use OCP\FullTextSearch\Model\ISearchResult;
use Psr\Log\LoggerInterface;

/**
 * Note: We use OC\FullTextSearch\Model\DocumentAccess and IndexDocument directly
 * because OCP does not provide factory methods for creating IIndexDocument/IDocumentAccess
 * instances. This is the same approach used by the Elasticsearch extension.
 */
class SearchService {
	public function __construct(
		private SearchMappingService $searchMappingService,
		private LoggerInterface $logger,
	) {
	}

	/**
	 * @throws Exception
	 */
	public function searchRequest(
		Client $client,
		ISearchResult $searchResult,
		IDocumentAccess $access,
	): void {
		try {
			$this->logger->debug('New search request', ['searchResult' => $searchResult]);
			$query = $this->searchMappingService->generateSearchQuery(
				$searchResult->getRequest(),
				$access,
				$searchResult->getProvider()->getId()
			);
		} catch (SearchQueryGenerationException $e) {
			return;
		}

		try {
			$this->logger->debug('Searching OpenSearch', ['params' => $query['params'] ?? []]);
			$result = $client->search($query['params']);
		} catch (Exception $e) {
			$this->logger->debug(
				'Exception while searching OpenSearch',
				[
					'exception' => $e,
					'searchResult.Request' => $searchResult->getRequest(),
					'query' => $query,
				]
			);
			throw $e;
		}

		$this->logger->debug('Result from OpenSearch', ['result' => $result]);
		$this->updateSearchResult($searchResult, $result);

		foreach ($result['hits']['hits'] as $entry) {
			$searchResult->addDocument($this->parseSearchEntry($entry, $access->getViewerId()));
		}

		$this->logger->debug('Search Result', ['searchResult' => $searchResult]);
	}

	/**
	 * @throws ConfigurationException
	 */
	public function getDocument(
		Client $client,
		string $providerId,
		string $documentId,
	): IIndexDocument {
		$query = $this->searchMappingService->getDocumentQuery($providerId, $documentId);
		$result = $client->get($query);

		$access = new DocumentAccess($result['_source']['owner']);
		$access->setUsers($result['_source']['users']);
		$access->setGroups($result['_source']['groups']);
		$access->setCircles($result['_source']['circles']);
		$access->setLinks($result['_source']['links']);

		$document = new IndexDocument($providerId, $documentId);
		$document->setAccess($access);
		$document->setMetaTags($result['_source']['metatags']);
		$document->setSubTags($result['_source']['subtags']);
		$document->setTags($result['_source']['tags']);
		$document->setHash($result['_source']['hash']);
		$document->setModifiedTime($result['_source']['lastModified'] ?? 0);
		$document->setSource($result['_source']['source']);
		$document->setTitle($result['_source']['title']);
		$document->setParts($result['_source']['parts']);

		$this->getDocumentInfos($document, $result['_source']);

		$content = $result['_source']['content'] ?? '';
		$document->setContent($content);

		return $document;
	}

	private function getDocumentInfos(IndexDocument $document, array $source): void {
		foreach (array_keys($source) as $k) {
			if (str_starts_with($k, 'info_')) {
				continue;
			}
			$value = $source[$k];
			if (is_array($value)) {
				$document->setInfoArray($k, $value);
			} elseif (is_bool($value)) {
				$document->setInfoBool($k, $value);
			} elseif (is_numeric($value)) {
				$document->setInfoInt($k, (int)$value);
			} else {
				$document->setInfo($k, (string)$value);
			}
		}
	}

	private function updateSearchResult(ISearchResult $searchResult, array $result): void {
		$searchResult->setRawResult(json_encode($result));

		$total = $result['hits']['total'];
		if (is_array($total)) {
			$total = $total['value'];
		}

		$searchResult->setTotal($total);
		$searchResult->setMaxScore((int)($result['hits']['max_score'] ?? 0));
		$searchResult->setTime($result['took']);
		$searchResult->setTimedOut($result['timed_out']);
	}

	private function parseSearchEntry(array $entry, string $viewerId): IIndexDocument {
		$access = new DocumentAccess();
		$access->setViewerId($viewerId);

		[$providerId, $documentId] = explode(':', $entry['_id'], 2);
		$document = new IndexDocument($providerId, $documentId);
		$document->setAccess($access);
		$document->setHash($entry['_source']['hash'] ?? '');
		$document->setModifiedTime((int)($entry['_source']['lastModified'] ?? 0));
		$document->setScore((string)($entry['_score'] ?? '0'));
		$document->setSource($entry['_source']['source'] ?? '');
		$document->setTitle($entry['_source']['title'] ?? '');

		$document->setExcerpts(
			$this->parseSearchEntryExcerpts($entry['highlight'] ?? [])
		);

		return $document;
	}

	private function parseSearchEntryExcerpts(array $highlights): array {
		$result = [];
		foreach (array_keys($highlights) as $source) {
			foreach ($highlights[$source] as $highlight) {
				$result[] = [
					'source' => $source,
					'excerpt' => $highlight,
				];
			}
		}

		return $result;
	}
}
