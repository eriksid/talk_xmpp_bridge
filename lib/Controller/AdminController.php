<?php
declare(strict_types=1);

namespace OCA\TalkXMPPBridge\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IConfig;
use OCP\IRequest;

class AdminController extends Controller {
    private IConfig $config;

    public function __construct(string $appName, IRequest $request, IConfig $config) {
        parent::__construct($appName, $request);
        $this->config = $config;
    }

    /**
     * @NoCSRFRequired // For simplicity in this prototype. A real app should handle CSRF.
     */
    public function saveSettings(
        string $xmpp_jid,
        string $xmpp_password,
        string $xmpp_host,
        int $xmpp_port,
        string $bot_user_id,
        string $xmpp_domain,
        string $conference_server
    ): JSONResponse {
        $this->config->setAppValue($this->appName, 'xmpp_jid', $xmpp_jid);
        $this->config->setAppValue($this->appName, 'xmpp_password', $xmpp_password);
        $this->config->setAppValue($this->appName, 'xmpp_host', $xmpp_host);
        $this->config->setAppValue($this->appName, 'xmpp_port', $xmpp_port);
        $this->config->setAppValue($this->appName, 'bot_user_id', $bot_user_id);
        $this->config->setAppValue($this->appName, 'xmpp_domain', $xmpp_domain);
        $this->config->setAppValue($this->appName, 'conference_server', $conference_server);

        return new JSONResponse(['status' => 'success']);
    }
}
