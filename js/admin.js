/**
 *
 * @copyright Copyright (c) 2024, Nextcloud GmbH
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

(function(window, $, OC) {
	'use strict';

	const appName = 'talk_xmpp_bridge';

	$(() => {
		const form = $('#xmpp-bridge-form');
		if (!form.length) {
			return;
		}

		// Also, load current values
		const inputs = form[0].elements;
		OC.AppConfig.getValue(appName, 'xmpp_jid', (val) => (inputs.xmpp_jid.value = val || ''));
		OC.AppConfig.getValue(appName, 'xmpp_host', (val) => (inputs.xmpp_host.value = val || ''));
		OC.AppConfig.getValue(appName, 'xmpp_port', (val) => (inputs.xmpp_port.value = val || '5222'));
		OC.AppConfig.getValue(appName, 'bot_user_id', (val) => (inputs.bot_user_id.value = val || ''));
		OC.AppConfig.getValue(appName, 'xmpp_domain', (val) => (inputs.xmpp_domain.value = val || ''));
		OC.AppConfig.getValue(appName, 'conference_server', (val) => (inputs.conference_server.value = val || ''));
		// Password is not loaded for security reasons

		form.on('submit', (event) => {
			event.preventDefault();

			const url = OC.generateUrl(`/apps/${appName}/settings`);
			const formData = new FormData(form[0]);
			const params = new URLSearchParams();
			for (const pair of formData) {
				params.append(pair[0], pair[1]);
			}

			$.ajax({
				method: 'POST',
				url,
				data: params.toString(),
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					requesttoken: OC.requestToken,
				},
			}).done((data) => {
				if (data.status === 'success') {
					OC.Notification.show(t(appName, 'Settings saved successfully'), { type: 'success' });
				} else {
					OC.Notification.show(t(appName, 'Failed to save settings'), { type: 'error' });
				}
			}).fail((error) => {
				console.error('Error saving settings:', error);
				OC.Notification.show(t(appName, 'An error occurred while saving settings'), { type: 'error' });
			});
		});
	});
})(window, jQuery, OC);