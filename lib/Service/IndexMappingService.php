<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Service;

use OCA\FullTextSearch_OpenSearch\ConfigLexicon;
use OCA\FullTextSearch_OpenSearch\Exceptions\AccessIsEmptyException;
use OCA\FullTextSearch_OpenSearch\Exceptions\ConfigurationException;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Client;
use OCP\AppFramework\Services\IAppConfig;
use OCP\FullTextSearch\Model\IIndexDocument;

class IndexMappingService {
	public function __construct(
		private ConfigService $configService,
		private readonly IAppConfig $appConfig,
	) {
	}

	/**
	 * @throws AccessIsEmptyException
	 * @throws ConfigurationException
	 */
	public function indexDocumentNew(Client $client, IIndexDocument $document): array {
		$index = [
			'index' => $this->configService->getOpenSearchIndex(),
			'id' => $document->getProviderId() . ':' . $document->getId(),
			'body' => $this->generateIndexBody($document),
		];

		$this->onIndexingDocument($document, $index);

		return $client->index($index);
	}

	/**
	 * @throws AccessIsEmptyException
	 * @throws ConfigurationException
	 */
	public function indexDocumentUpdate(Client $client, IIndexDocument $document): array {
		$index = [
			'index' => $this->configService->getOpenSearchIndex(),
			'id' => $document->getProviderId() . ':' . $document->getId(),
			'body' => ['doc' => $this->generateIndexBody($document)],
		];

		$this->onIndexingDocument($document, $index);
		try {
			return $client->update($index);
		} catch (\Exception $e) {
			return $this->indexDocumentNew($client, $document);
		}
	}

	/**
	 * @throws ConfigurationException
	 */
	public function indexDocumentRemove(Client $client, string $providerId, string $documentId): void {
		$params = [
			'index' => $this->configService->getOpenSearchIndex(),
			'id' => $providerId . ':' . $documentId,
		];

		try {
			$client->delete($params);
		} catch (\Exception $e) {
			// Document may already be deleted
		}
	}

	public function onIndexingDocument(IIndexDocument $document, array &$params): void {
		if ($document->getContent() !== ''
			&& $document->isContentEncoded() === IIndexDocument::ENCODED_BASE64) {
			$params['pipeline'] = 'attachment';
		}
	}

	/**
	 * @throws AccessIsEmptyException
	 */
	public function generateIndexBody(IIndexDocument $document): array {
		$access = $document->getAccess();

		$body = [
			'owner' => $access->getOwnerId(),
			'users' => $access->getUsers(),
			'groups' => $access->getGroups(),
			'circles' => $access->getCircles(),
			'links' => $access->getLinks(),
			'metatags' => $document->getMetaTags(),
			'subtags' => $document->getSubTags(true),
			'tags' => $document->getTags(),
			'hash' => $document->getHash(),
			'provider' => $document->getProviderId(),
			'lastModified' => $document->getModifiedTime(),
			'source' => $document->getSource(),
			'title' => $document->getTitle(),
			'parts' => $document->getParts(),
			'combined' => '',
			'content' => $document->getContent(),
		];

		return array_merge($document->getInfoAll(), $body);
	}

	/**
	 * @throws ConfigurationException
	 */
	public function generateGlobalMap(bool $complete = true): array {
		$params = [
			'index' => $this->configService->getOpenSearchIndex(),
		];

		if (!$complete) {
			return $params;
		}

		$params['body'] = [
			'settings' => [
				'index.mapping.total_fields.limit' => $this->appConfig->getAppValueInt(ConfigLexicon::FIELDS_LIMIT),
				'analysis' => [
					'filter' => [
						'shingle' => [
							'type' => 'shingle',
						],
					],
					'char_filter' => [
						'pre_negs' => [
							'type' => 'pattern_replace',
							'pattern' => '(\\w+)\\s+((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))\\b',
							'replacement' => '~$1 $2',
						],
						'post_negs' => [
							'type' => 'pattern_replace',
							'pattern' => '\\b((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))\\s+(\\w+)',
							'replacement' => '$1 ~$2',
						],
					],
					'analyzer' => [
						'analyzer' => [
							'type' => 'custom',
							'tokenizer' => $this->appConfig->getAppValueString(ConfigLexicon::ANALYZER_TOKENIZER),
							'filter' => ['lowercase', 'stop', 'kstem'],
						],
					],
				],
			],
			'mappings' => [
				'dynamic' => true,
				'properties' => [
					'source' => [
						'type' => 'keyword',
					],
					'title' => [
						'type' => 'text',
						'analyzer' => 'keyword',
						'term_vector' => 'with_positions_offsets',
						'copy_to' => 'combined',
					],
					'provider' => [
						'type' => 'keyword',
					],
					'lastModified' => [
						'type' => 'integer',
					],
					'tags' => [
						'type' => 'keyword',
					],
					'metatags' => [
						'type' => 'keyword',
					],
					'subtags' => [
						'type' => 'keyword',
					],
					'content' => [
						'type' => 'text',
						'analyzer' => 'analyzer',
						'term_vector' => 'with_positions_offsets',
						'copy_to' => 'combined',
					],
					'owner' => [
						'type' => 'keyword',
						'fields' => [
							'keyword' => ['type' => 'keyword'],
						],
					],
					'users' => [
						'type' => 'keyword',
						'fields' => [
							'keyword' => ['type' => 'keyword'],
						],
					],
					'groups' => [
						'type' => 'keyword',
						'fields' => [
							'keyword' => ['type' => 'keyword'],
						],
					],
					'circles' => [
						'type' => 'keyword',
						'fields' => [
							'keyword' => ['type' => 'keyword'],
						],
					],
					'links' => [
						'type' => 'keyword',
					],
					'hash' => [
						'type' => 'keyword',
					],
					'combined' => [
						'type' => 'text',
						'analyzer' => 'analyzer',
						'term_vector' => 'with_positions_offsets',
					],
				],
			],
		];

		return $params;
	}

	public function generateGlobalIngest(bool $complete = true): array {
		$params = ['id' => 'attachment'];

		if (!$complete) {
			return $params;
		}

		$params['body'] = [
			'description' => 'attachment',
			'processors' => [
				[
					'attachment' => [
						'remove_binary' => true,
						'field' => 'content',
						'indexed_chars' => -1,
					],
				],
				[
					'convert' => [
						'field' => 'attachment.content',
						'type' => 'string',
						'target_field' => 'content',
						'ignore_failure' => true,
					],
				],
				[
					'remove' => [
						'field' => 'attachment.content',
						'ignore_failure' => true,
					],
				],
			],
		];

		return $params;
	}

	/**
	 * @throws ConfigurationException
	 */
	public function generateDeleteQuery(string $providerId): array {
		return [
			'index' => $this->configService->getOpenSearchIndex(),
			'body' => [
				'query' => [
					'match' => ['provider' => $providerId],
				],
			],
		];
	}
}
