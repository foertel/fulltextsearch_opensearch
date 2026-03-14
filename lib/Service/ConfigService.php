<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Service;

use OCA\FullTextSearch_OpenSearch\ConfigLexicon;
use OCA\FullTextSearch_OpenSearch\Exceptions\ConfigurationException;
use OCP\AppFramework\Services\IAppConfig;

class ConfigService {
	public function __construct(
		private readonly IAppConfig $appConfig,
	) {
	}

	public function getConfig(): array {
		return [
			ConfigLexicon::OPENSEARCH_HOST => $this->appConfig->getAppValueString(ConfigLexicon::OPENSEARCH_HOST),
			ConfigLexicon::OPENSEARCH_INDEX => $this->appConfig->getAppValueString(ConfigLexicon::OPENSEARCH_INDEX),
			ConfigLexicon::FIELDS_LIMIT => $this->appConfig->getAppValueInt(ConfigLexicon::FIELDS_LIMIT),
			ConfigLexicon::ANALYZER_TOKENIZER => $this->appConfig->getAppValueString(ConfigLexicon::ANALYZER_TOKENIZER),
			ConfigLexicon::ALLOW_SELF_SIGNED_CERT => $this->appConfig->getAppValueBool(ConfigLexicon::ALLOW_SELF_SIGNED_CERT),
			ConfigLexicon::OPENSEARCH_LOGGER_ENABLED => $this->appConfig->getAppValueBool(ConfigLexicon::OPENSEARCH_LOGGER_ENABLED),
		];
	}

	public function setConfig(array $save): void {
		foreach (array_keys($save) as $k) {
			switch ($k) {
				case ConfigLexicon::FIELDS_LIMIT:
					$this->appConfig->setAppValueInt($k, (int)$save[$k]);
					break;

				case ConfigLexicon::OPENSEARCH_HOST:
				case ConfigLexicon::OPENSEARCH_INDEX:
				case ConfigLexicon::ANALYZER_TOKENIZER:
					$this->appConfig->setAppValueString($k, (string)$save[$k]);
					break;

				case ConfigLexicon::ALLOW_SELF_SIGNED_CERT:
				case ConfigLexicon::OPENSEARCH_LOGGER_ENABLED:
					$this->appConfig->setAppValueBool($k, (bool)$save[$k]);
					break;
			}
		}
	}

	/**
	 * @throws ConfigurationException
	 */
	public function getOpenSearchHost(): array {
		$strHost = $this->appConfig->getAppValueString(ConfigLexicon::OPENSEARCH_HOST);
		if ($strHost === '') {
			throw new ConfigurationException('OpenSearch host is not configured');
		}

		return array_map('trim', explode(',', $strHost));
	}

	/**
	 * @throws ConfigurationException
	 */
	public function getOpenSearchIndex(): string {
		$index = $this->appConfig->getAppValueString(ConfigLexicon::OPENSEARCH_INDEX);
		if ($index === '') {
			throw new ConfigurationException('OpenSearch index name is not configured');
		}

		return $index;
	}

	public function checkConfig(array $data): bool {
		if (isset($data[ConfigLexicon::OPENSEARCH_HOST]) && trim($data[ConfigLexicon::OPENSEARCH_HOST]) === '') {
			return false;
		}
		if (isset($data[ConfigLexicon::OPENSEARCH_INDEX]) && trim($data[ConfigLexicon::OPENSEARCH_INDEX]) === '') {
			return false;
		}
		return true;
	}
}
