<?php
declare(strict_types=1);

namespace OCA\TalkXMPPBridge\Settings;

use OCP\IURLGenerator;
use OCP\Settings\ISettings;
use OCP\Template;

class AdminSettings implements ISettings {

    public function __construct() {
        // We can inject services here later if needed
    }

    public function getPanel(): Template {
        // Here we can pass variables to the template if needed
        $template = new Template('talk_xmpp_bridge', 'admin');
        $template->assign('app_name', 'Talk XMPP Bridge');
        return $template;
    }

    public function getSectionID(): string {
        // This will place our settings under the "Administration" -> "Talk" section
        return 'spreed';
    }

    public function getPriority(): int {
        return 10;
    }
}
