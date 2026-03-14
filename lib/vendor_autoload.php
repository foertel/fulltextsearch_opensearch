<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 *
 * PSR-4 autoloader for scoped vendor dependencies.
 */

spl_autoload_register(function (string $class): void {
	$prefix = 'OCA\\FullTextSearch_OpenSearch\\Vendor\\';

	if (!str_starts_with($class, $prefix)) {
		return;
	}

	$relative = substr($class, strlen($prefix));

	// Map scoped namespace prefixes to their directory paths.
	// More specific prefixes must come before less specific ones.
	$vendorDir = __DIR__ . '/Vendor';

	$map = [
		'OpenSearch\\' => [$vendorDir . '/opensearch-project/opensearch-php/src/OpenSearch/'],
		'GuzzleHttp\\Ring\\' => [$vendorDir . '/ezimuel/ringphp/src/'],
		'GuzzleHttp\\Stream\\' => [$vendorDir . '/ezimuel/guzzlestreams/src/'],
		'GuzzleHttp\\Psr7\\' => [$vendorDir . '/guzzlehttp/psr7/src/'],
		'GuzzleHttp\\Promise\\' => [$vendorDir . '/guzzlehttp/promises/src/'],
		'GuzzleHttp\\' => [$vendorDir . '/guzzlehttp/guzzle/src/'],
		'React\\Promise\\' => [$vendorDir . '/react/promise/src/'],
		'Psr\\Log\\' => [$vendorDir . '/psr/log/src/'],
		'Psr\\Http\\Message\\' => [
			$vendorDir . '/psr/http-message/src/',
			$vendorDir . '/psr/http-factory/src/',
		],
		'Psr\\Http\\Client\\' => [$vendorDir . '/psr/http-client/src/'],
		'Http\\Discovery\\' => [$vendorDir . '/php-http/discovery/src/'],
	];

	foreach ($map as $nsPrefix => $dirs) {
		if (str_starts_with($relative, $nsPrefix)) {
			$relPath = str_replace('\\', '/', substr($relative, strlen($nsPrefix))) . '.php';
			foreach ($dirs as $dir) {
				$file = $dir . $relPath;
				if (file_exists($file)) {
					require $file;
					return;
				}
			}
			return;
		}
	}
});

// Load function files
$vendorDir = __DIR__ . '/Vendor';
$functionFiles = [
	$vendorDir . '/guzzlehttp/guzzle/src/functions_include.php',
	$vendorDir . '/guzzlehttp/promises/src/functions_include.php',
	$vendorDir . '/ralouphie/getallheaders/src/getallheaders.php',
	$vendorDir . '/react/promise/src/functions_include.php',
	$vendorDir . '/symfony/deprecation-contracts/function.php',
];

foreach ($functionFiles as $file) {
	if (file_exists($file)) {
		require_once $file;
	}
}
