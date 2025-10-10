<?php
declare(strict_types=1);

namespace OCA\TalkXMPPBridge\Cron;

use OCA\TalkXMPPBridge\Service\XMPPService;
use OCP\Cron\IJob;

class XMPPListenerJob extends IJob {
    private XMPPService $xmppService;

    public function __construct(XMPPService $xmppService) {
        $this->xmppService = $xmppService;
    }

    /**
     * This job will run in the background, listening for XMPP messages.
     * Note: This creates a long-running process. The Nextcloud cron execution
     * needs to be configured to handle this (e.g., running it via system cron
     * instead of webcron, and without a timeout).
     */
    public function run($argument): void {
        // This will start the blocking listener loop.
        $this->xmppService->listen();
    }
}
