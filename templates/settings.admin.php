<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

use OCA\FullTextSearch_OpenSearch\AppInfo\Application;
use OCP\Util;

Util::addScript(Application::APP_NAME, 'admin.elements');
Util::addScript(Application::APP_NAME, 'admin.settings');
Util::addScript(Application::APP_NAME, 'admin.status');
Util::addScript(Application::APP_NAME, 'admin');

Util::addStyle(Application::APP_NAME, 'admin');

?>

<div id="opensearch_search" class="section" style="display: none;">
	<h2><?php p($l->t('OpenSearch')) ?></h2>

	<!-- Status Panel -->
	<div id="opensearch_status" class="opensearch-status-panel">
		<h3><?php p($l->t('Status')); ?></h3>

		<div id="os_cluster_health" class="status-row">
			<span class="status-label"><?php p($l->t('Cluster')); ?>:</span>
			<span id="os_cluster_badge" class="status-badge"></span>
		</div>

		<div id="os_index_info" class="status-row" style="display: none;">
			<span class="status-label"><?php p($l->t('Index')); ?>:</span>
			<span id="os_index_name"></span>
			&mdash; <span id="os_index_docs"></span> <?php p($l->t('docs')); ?>
			(<span id="os_index_size"></span>)
		</div>

		<div id="os_runner_status" class="status-row">
			<span class="status-label"><?php p($l->t('Indexing')); ?>:</span>
			<span id="os_runner_badge" class="status-badge"></span>
			<span id="os_runner_action"></span>
			<span id="os_runner_source"></span>
		</div>

		<div id="os_progress_container" class="status-row" style="display: none;">
			<span class="status-label"><?php p($l->t('Progress')); ?>:</span>
			<div class="progress-bar-outer">
				<div id="os_progress_bar" class="progress-bar-inner"></div>
			</div>
			<span id="os_progress_text"></span>
		</div>

		<div id="os_queue_info" class="status-row">
			<span class="status-label"><?php p($l->t('Queue')); ?>:</span>
			<span id="os_queue_indexed"></span> <?php p($l->t('indexed')); ?>,
			<span id="os_queue_pending"></span> <?php p($l->t('pending')); ?>,
			<span id="os_queue_errors" class="status-errors"></span> <?php p($l->t('errors')); ?>
			/ <span id="os_queue_total"></span> <?php p($l->t('total')); ?>
		</div>
	</div>

	<!-- Settings -->
	<div class="div-table">

		<div class="div-table-row">
			<div class="div-table-col div-table-col-left">
				<span class="leftcol"><?php p($l->t('Address of the Servlet')); ?>:</span>
				<br/>
				<em><?php p($l->t('Include your credential in case authentication is required.')); ?></em>
			</div>
			<div class="div-table-col">
				<input type="text" id="opensearch_host"
					   placeholder="http://username:password@localhost:9200/"/>
			</div>
		</div>

		<div class="div-table-row">
			<div class="div-table-col div-table-col-left">
				<span class="leftcol"><?php p($l->t('Index')); ?>:</span>
				<br/>
				<em><?php p($l->t('Name of your index.')); ?></em>
			</div>
			<div class="div-table-col">
				<input type="text" id="opensearch_index" placeholder="my_index"/>
			</div>
		</div>

		<div class="div-table-row">
			<div class="div-table-col div-table-col-left">
				<span class="leftcol"><?php p($l->t('[Advanced] Analyzer tokenizer')); ?>:</span>
				<br/>
				<em><?php p($l->t('Some language might need a specific tokenizer.')); ?></em>
			</div>
			<div class="div-table-col">
				<input type="text" id="analyzer_tokenizer" />
			</div>
		</div>

		<div class="div-table-row">
			<div class="div-table-col div-table-col-left">
				<span class="leftcol"><?php p($l->t('Allow self-signed certificates')); ?>:</span>
				<br/>
				<em><?php p($l->t('Skip SSL verification for self-signed certificates.')); ?></em>
			</div>
			<div class="div-table-col">
				<input type="checkbox" id="allow_self_signed_cert" />
			</div>
		</div>

		<div class="div-table-row">
			<div class="div-table-col div-table-col-left">
				<span class="leftcol"><?php p($l->t('Enable client logging')); ?>:</span>
				<br/>
				<em><?php p($l->t('Log OpenSearch client requests to the Nextcloud log. Warning: credentials may appear in debug logs.')); ?></em>
			</div>
			<div class="div-table-col">
				<input type="checkbox" id="opensearch_logger_enabled" />
			</div>
		</div>

	</div>

</div>
