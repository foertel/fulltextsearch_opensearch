<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch;

use OCP\Config\Lexicon\Entry;
use OCP\Config\Lexicon\ILexicon;
use OCP\Config\Lexicon\Strictness;
use OCP\Config\ValueType;

class ConfigLexicon implements ILexicon {
	public const OPENSEARCH_HOST = 'opensearch_host';
	public const OPENSEARCH_INDEX = 'opensearch_index';
	public const FIELDS_LIMIT = 'fields_limit';
	public const ANALYZER_TOKENIZER = 'analyzer_tokenizer';
	public const ALLOW_SELF_SIGNED_CERT = 'allow_self_signed_cert';
	public const OPENSEARCH_LOGGER_ENABLED = 'opensearch_logger_enabled';

	public function getStrictness(): Strictness {
		return Strictness::NOTICE;
	}

	public function getAppConfigs(): array {
		return [
			new Entry(
				key: self::OPENSEARCH_HOST,
				type: ValueType::STRING,
				defaultRaw: 'http://nextcloud-aio-opensearch:9200',
				definition: 'Comma-separated OpenSearch host URLs (e.g. https://user:pass@localhost:9200)',
				lazy: true,
			),
			new Entry(
				key: self::OPENSEARCH_INDEX,
				type: ValueType::STRING,
				defaultRaw: 'nextcloud-aio',
				definition: 'Name of the index on OpenSearch',
				lazy: true,
			),
			new Entry(
				key: self::FIELDS_LIMIT,
				type: ValueType::INT,
				defaultRaw: 10000,
				definition: 'Maximum number of fields in the index mapping (index.mapping.total_fields.limit)',
				lazy: true,
			),
			new Entry(
				key: self::ANALYZER_TOKENIZER,
				type: ValueType::STRING,
				defaultRaw: 'standard',
				definition: 'Analyzer tokenizer used for the custom analyzer',
				lazy: true,
			),
			new Entry(
				key: self::ALLOW_SELF_SIGNED_CERT,
				type: ValueType::BOOL,
				defaultRaw: false,
				definition: 'Allow self-signed SSL certificates',
				lazy: true,
			),
			new Entry(
				key: self::OPENSEARCH_LOGGER_ENABLED,
				type: ValueType::BOOL,
				defaultRaw: false,
				definition: 'Log OpenSearch client requests to the Nextcloud log',
				lazy: true,
				note: 'If your Nextcloud log level is set to DEBUG (0), credentials may appear in logs',
			),
		];
	}

	public function getUserConfigs(): array {
		return [];
	}
}
