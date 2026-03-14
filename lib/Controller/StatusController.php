<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FullTextSearch_OpenSearch\Controller;

use OCA\FullTextSearch_OpenSearch\AppInfo\Application;
use OCA\FullTextSearch_OpenSearch\Service\StatusService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class StatusController extends Controller {
	public function __construct(
		IRequest $request,
		private StatusService $statusService,
	) {
		parent::__construct(Application::APP_NAME, $request);
	}

	public function getStatus(): DataResponse {
		return new DataResponse($this->statusService->getStatus(), Http::STATUS_OK);
	}
}
