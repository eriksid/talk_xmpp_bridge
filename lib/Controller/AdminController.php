<?php
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
declare(strict_types=1);

namespace OCA\TalkXMPPBridge\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\IConfig;
use OCP\IRequest;
use OCP\Security\IKeyStore;
use OCP\AppFramework\Utility\ITimeFactory;

class AdminController extends Controller {
	private IConfig $config;
	private IKeyStore $keyStore;
	private ITimeFactory $timeFactory;

	public function __construct(string $appName, IRequest $request, IConfig $config, IKeyStore $keyStore, ITimeFactory $timeFactory) {
		parent::__construct($appName, $request);
		$this->config = $config;
		$this->keyStore = $keyStore;
		$this->timeFactory = $timeFactory;
	}

	/**
	 * @param string $xmppJid
	 * @param string $xmppPassword
	 * @param string $xmppHost
	 * @param int $xmppPort
	 * @param string $botUserId
	 * @param string $xmppDomain
	 * @param string $conferenceServer
	 * @return DataResponse
	 */
	public function saveSettings(
		string $xmppJid,
		string $xmppPassword,
		string $xmppHost,
		int $xmppPort,
		string $botUserId,
		string $xmppDomain,
		string $conferenceServer
	): DataResponse {
		$this->config->setAppValue($this->appName, 'xmpp_jid', $xmppJid);
		$this->keyStore->set('xmpp_password', $xmppPassword);
		$this->config->setAppValue($this->appName, 'xmpp_host', $xmppHost);
		$this->config->setAppValue($this->appName, 'xmpp_port', $xmppPort);
		$this->config->setAppValue($this->appName, 'bot_user_id', $botUserId);
		$this->config->setAppValue($this->appName, 'xmpp_domain', $xmppDomain);
		$this->config->setAppValue($this->appName, 'conference_server', $conferenceServer);

		return new DataResponse(['status' => 'success']);
	}
}