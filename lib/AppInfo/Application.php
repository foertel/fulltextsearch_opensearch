<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\AppInfo;

use OCA\FullTextSearch_OpenSearch\ConfigLexicon;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap {
	public const APP_NAME = 'fulltextsearch_opensearch';

	public function __construct(array $params = []) {
		parent::__construct(self::APP_NAME, $params);
		require_once __DIR__ . '/../vendor_autoload.php';
	}

	public function register(IRegistrationContext $context): void {
		$context->registerConfigLexicon(ConfigLexicon::class);
	}

	public function boot(IBootContext $context): void {
	}
}
