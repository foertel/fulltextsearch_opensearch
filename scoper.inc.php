<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

use Isolated\Symfony\Component\Finder\Finder;

return [
	'prefix' => 'OCA\\FullTextSearch_OpenSearch\\Vendor',
	'finders' => [
		Finder::create()->files()->in('vendor/opensearch-project')->name('*.php'),
		Finder::create()->files()->in('vendor/guzzlehttp')->name('*.php'),
		Finder::create()->files()->in('vendor/ezimuel')->name('*.php'),
		Finder::create()->files()->in('vendor/react')->name('*.php'),
		Finder::create()->files()->in('vendor/psr')->name('*.php'),
		Finder::create()->files()->in('vendor/php-http')->name('*.php'),
		Finder::create()->files()->in('vendor/ralouphie')->name('*.php'),
		Finder::create()->files()->in('vendor/symfony/deprecation-contracts')->name('*.php'),
	],
	'patchers' => [],
	'exclude-namespaces' => [
		'OCA\\FullTextSearch_OpenSearch',
		'OCP',
		'OC',
		'Symfony\\Component\\Console',
	],
	'exclude-classes' => [],
	'exclude-functions' => [],
	'exclude-constants' => [],
	'expose-global-constants' => false,
	'expose-global-classes' => false,
	'expose-global-functions' => false,
];
