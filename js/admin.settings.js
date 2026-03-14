/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

/** global: OC */
/** global: opensearch_elements */
/** global: fts_admin_settings */

var opensearch_settings = {

	config: null,

	refreshSettingPage: function () {
		$.ajax({
			method: 'GET',
			url: OC.generateUrl('/apps/fulltextsearch_opensearch/admin/settings')
		}).done(function (res) {
			opensearch_settings.updateSettingPage(res);
		});
	},

	updateSettingPage: function (result) {
		opensearch_elements.opensearch_host.val(result.opensearch_host);
		opensearch_elements.opensearch_index.val(result.opensearch_index);
		opensearch_elements.analyzer_tokenizer.val(result.analyzer_tokenizer);
		opensearch_elements.allow_self_signed_cert.prop('checked', result.allow_self_signed_cert);
		opensearch_elements.opensearch_logger_enabled.prop('checked', result.opensearch_logger_enabled);

		fts_admin_settings.tagSettingsAsSaved(opensearch_elements.opensearch_div);
	},

	saveSettings: function () {
		var data = {
			opensearch_host: opensearch_elements.opensearch_host.val(),
			opensearch_index: opensearch_elements.opensearch_index.val(),
			analyzer_tokenizer: opensearch_elements.analyzer_tokenizer.val(),
			allow_self_signed_cert: opensearch_elements.allow_self_signed_cert.is(':checked'),
			opensearch_logger_enabled: opensearch_elements.opensearch_logger_enabled.is(':checked')
		};

		$.ajax({
			method: 'POST',
			url: OC.generateUrl('/apps/fulltextsearch_opensearch/admin/settings'),
			data: {
				data: data
			}
		}).done(function (res) {
			opensearch_settings.updateSettingPage(res);
		});
	}
};
