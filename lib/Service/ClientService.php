<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Service;

use OCA\FullTextSearch_OpenSearch\ConfigLexicon;
use OCA\FullTextSearch_OpenSearch\Exceptions\ClientException;
use OCA\FullTextSearch_OpenSearch\Exceptions\ConfigurationException;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Client;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\ClientBuilder;
use OCP\AppFramework\Services\IAppConfig;
use Psr\Log\LoggerInterface;

class ClientService {
	private ?Client $client = null;

	public function __construct(
		private readonly IAppConfig $appConfig,
		private ConfigService $configService,
		private LoggerInterface $logger,
	) {
	}

	/**
	 * @throws ConfigurationException
	 */
	public function getClient(): Client {
		if ($this->client === null) {
			$this->client = $this->buildClient();
		}

		return $this->client;
	}

	public function resetClient(): void {
		$this->client = null;
	}

	/**
	 * @throws ConfigurationException
	 */
	private function buildClient(): Client {
		$hosts = $this->configService->getOpenSearchHost();
		$hosts = array_map(fn(string $h) => $this->cleanHost($h), $hosts);

		$cb = ClientBuilder::create();
		$cb->setHosts($hosts)
		   ->setRetries(3);

		if ($this->appConfig->getAppValueBool(ConfigLexicon::OPENSEARCH_LOGGER_ENABLED)) {
			$cb->setLogger($this->logger);
		}

		$cb->setSSLVerification(!$this->appConfig->getAppValueBool(ConfigLexicon::ALLOW_SELF_SIGNED_CERT));
		$this->configureAuthentication($cb, $hosts);

		return $cb->build();
	}

	private function configureAuthentication(ClientBuilder $cb, array $hosts): void {
		foreach ($hosts as $host) {
			$user = parse_url($host, PHP_URL_USER) ?? '';
			$pass = parse_url($host, PHP_URL_PASS) ?? '';

			if ($user !== '' || $pass !== '') {
				$cb->setBasicAuthentication($user, $pass);
				return;
			}
		}
	}

	private function cleanHost(string $host): string {
		if ($host === '/') {
			return $host;
		}

		return trim(rtrim($host, '/'));
	}
}
