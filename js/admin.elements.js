/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

/** global: OCA */
/** global: fts_admin_settings */
/** global: opensearch_settings */

var opensearch_elements = {
	opensearch_div: null,
	opensearch_host: null,
	opensearch_index: null,
	analyzer_tokenizer: null,
	allow_self_signed_cert: null,
	opensearch_logger_enabled: null,

	init: function () {
		opensearch_elements.opensearch_div = $('#opensearch_search');
		opensearch_elements.opensearch_host = $('#opensearch_host');
		opensearch_elements.opensearch_index = $('#opensearch_index');
		opensearch_elements.analyzer_tokenizer = $('#analyzer_tokenizer');
		opensearch_elements.allow_self_signed_cert = $('#allow_self_signed_cert');
		opensearch_elements.opensearch_logger_enabled = $('#opensearch_logger_enabled');

		opensearch_elements.opensearch_host.on('input', function () {
			fts_admin_settings.tagSettingsAsNotSaved($(this));
		}).blur(function () {
			opensearch_settings.saveSettings();
		});

		opensearch_elements.opensearch_index.on('input', function () {
			fts_admin_settings.tagSettingsAsNotSaved($(this));
		}).blur(function () {
			opensearch_settings.saveSettings();
		});

		opensearch_elements.analyzer_tokenizer.on('input', function () {
			fts_admin_settings.tagSettingsAsNotSaved($(this));
		}).blur(function () {
			opensearch_settings.saveSettings();
		});

		opensearch_elements.allow_self_signed_cert.on('change', function () {
			opensearch_settings.saveSettings();
		});

		opensearch_elements.opensearch_logger_enabled.on('change', function () {
			opensearch_settings.saveSettings();
		});
	}
};
