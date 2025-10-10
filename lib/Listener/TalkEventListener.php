<?php
declare(strict_types=1);

namespace OCA\TalkXMPPBridge\Listener;

use OCA\Talk\Events\ChatMessageSentEvent;
use OCA\TalkXMPPBridge\Service\XMPPService;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IConfig;
use OCP\IUserManager;

class TalkEventListener implements IEventListener {
    private XMPPService $xmppService;
    private IConfig $config;
    private IUserManager $userManager;

    public function __construct(XMPPService $xmppService, IConfig $config, IUserManager $userManager) {
        $this->xmppService = $xmppService;
        $this->config = $config;
        $this->userManager = $userManager;
    }

    public function handle(Event $event): void {
        if (!$event instanceof ChatMessageSentEvent) {
            return;
        }

        $message = $event->getMessage();
        $conversation = $event->getConversation();
        $author = $this->userManager->get($message->getActorId());

        // Prevent loops: check if the author is the bot
        $botUserId = $this->config->getAppValue('talk_xmpp_bridge', 'bot_user_id');
        if ($author !== null && $author->getUID() === $botUserId) {
            return;
        }

        $messageText = $message->getMessage();
        // In Talk API, conversation type 1 is group, 0 is one-on-one
        $isGroup = ($conversation->getType() === 1);

        if ($isGroup) {
            $roomName = $conversation->getDisplayName();
            $conferenceServer = $this->config->getAppValue('talk_xmpp_bridge', 'conference_server');
            if (empty($roomName) || empty($conferenceServer)) {
                return;
            }
            $jidNode = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $roomName));
            $recipientJid = $jidNode . '@' . $conferenceServer;
            $this->xmppService->sendMessage($recipientJid, $messageText, true);
        } else { // 1-to-1 chat
            foreach ($conversation->getParticipants() as $participant) {
                if ($participant->getActorId() !== $author->getUID()) {
                    $recipientUser = $this->userManager->get($participant->getActorId());
                    if ($recipientUser === null) {
                        continue;
                    }

                    $xmppDomain = $this->config->getAppValue('talk_xmpp_bridge', 'xmpp_domain');
                    if (empty($xmppDomain)) {
                        return;
                    }
                    $recipientJid = $recipientUser->getUID() . '@' . $xmppDomain;
                    $this->xmppService->sendMessage($recipientJid, $messageText, false);
                    break; // Sent to the first non-author participant
                }
            }
        }
    }
}
