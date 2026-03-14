/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

/** global: OC */

var opensearch_status = {
	pollInterval: null,
	_currentRate: 0,
	POLL_RATE_ACTIVE: 3000,
	POLL_RATE_IDLE: 30000,

	startPolling: function () {
		opensearch_status.fetchStatus();
		opensearch_status._currentRate = opensearch_status.POLL_RATE_IDLE;
		opensearch_status.pollInterval = setInterval(
			opensearch_status.fetchStatus,
			opensearch_status.POLL_RATE_IDLE
		);
	},

	fetchStatus: function () {
		$.ajax({
			method: 'GET',
			url: OC.generateUrl('/apps/fulltextsearch_opensearch/admin/status')
		}).done(function (res) {
			opensearch_status.updatePanel(res);
		}).fail(function () {
			$('#os_cluster_badge').text('unavailable').attr('class', 'status-badge status-red');
		});
	},

	updatePanel: function (status) {
		var panel = $('#opensearch_status');
		panel.show();

		// Cluster health
		var clusterStatus = (status.cluster && status.cluster.status) || 'unavailable';
		var clusterClass = 'status-' + (clusterStatus === 'green' ? 'green' :
										clusterStatus === 'yellow' ? 'yellow' : 'red');
		$('#os_cluster_badge').text(clusterStatus).attr('class', 'status-badge ' + clusterClass);

		// Index info
		if (status.index && status.index.exists) {
			$('#os_index_name').text(status.index.name);
			$('#os_index_docs').text(status.index.documentCount.toLocaleString());
			$('#os_index_size').text(status.index.sizeBytes);
			$('#os_index_info').show();
		} else {
			$('#os_index_info').hide();
		}

		// Runner
		var running = status.runner && status.runner.running;
		$('#os_runner_badge').text(running ? 'running' : 'idle')
			.attr('class', 'status-badge ' + (running ? 'status-green' : 'status-grey'));
		$('#os_runner_action').text(running ? status.runner.action : '');
		$('#os_runner_source').text(running ? '(' + status.runner.source + ')' : '');

		// Adaptive poll rate
		var desiredRate = running ?
			opensearch_status.POLL_RATE_ACTIVE : opensearch_status.POLL_RATE_IDLE;
		if (opensearch_status._currentRate !== desiredRate) {
			clearInterval(opensearch_status.pollInterval);
			opensearch_status.pollInterval = setInterval(
				opensearch_status.fetchStatus, desiredRate
			);
			opensearch_status._currentRate = desiredRate;
		}

		// Progress bar
		var queue = status.queue || {};
		if (queue.total > 0) {
			$('#os_progress_container').show();
			$('#os_progress_bar').css('width', queue.progress + '%');
			$('#os_progress_text').text(
				queue.progress + '% (' + queue.indexed.toLocaleString() +
				' / ' + queue.total.toLocaleString() + ')'
			);
		} else {
			$('#os_progress_container').hide();
		}

		// Queue counts
		$('#os_queue_total').text((queue.total || 0).toLocaleString());
		$('#os_queue_indexed').text((queue.indexed || 0).toLocaleString());
		$('#os_queue_pending').text((queue.pending || 0).toLocaleString());
		$('#os_queue_errors').text((queue.errors || 0).toLocaleString());

		var errEl = $('#os_queue_errors');
		if ((queue.errors || 0) > 0) {
			errEl.addClass('status-text-red');
		} else {
			errEl.removeClass('status-text-red');
		}
	}
};
