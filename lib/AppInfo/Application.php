<?php
declare(strict_types=1);

namespace OCA\TalkXMPPBridge\AppInfo;

use OCA\Talk\Api\IChatManager;
use OCA\Talk\Events\ChatMessageSentEvent;
use OCA\Talk\Manager;
use OCA\TalkXMPPBridge\Cron\XMPPListenerJob;
use OCA\TalkXMPPBridge\Listener\TalkEventListener;
use OCA\TalkXMPPBridge\Service\XMPPService;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\IConfig;
use OCP\IUserManager;
use Psr\Log\LoggerInterface;

class Application extends App implements IBootstrap {
    public const APP_ID = 'talk_xmpp_bridge';

    public function __construct() {
        parent::__construct(self::APP_ID);
    }

    public function register(IRegistrationContext $context): void {
        // Register the XMPP Service
        $context->registerService(XMPPService::class, function ($c) {
            return new XMPPService(
                $c->get(IConfig::class),
                $c->get(LoggerInterface::class),
                $c->get(IChatManager::class),
                $c->get(Manager::class),
                $c->get(IUserManager::class)
            );
        });

        // Register the Event Listener
        $context->registerService(TalkEventListener::class, function ($c) {
            return new TalkEventListener(
                $c->get(XMPPService::class),
                $c->get(IConfig::class),
                $c->get(IUserManager::class)
            );
        });

        // Subscribe to the Talk event
        $context->getEventDispatcher()->addServiceListener(
            ChatMessageSentEvent::class,
            TalkEventListener::class
        );

        // Register the Cron Job
        $context->registerService(XMPPListenerJob::class, function ($c) {
            return new XMPPListenerJob(
                $c->get(XMPPService::class)
            );
        });
        $context->getCronManager()->addJob(XMPPListenerJob::class);
    }

    public function boot(IBootContext $context): void {
        // Run code after registration and booting of all apps is complete
    }
}
