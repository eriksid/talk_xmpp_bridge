<?php
declare(strict_types=1);

namespace OCA\TalkXMPPBridge\Service;

use OCA\Talk\Api\IChatManager;
use OCA\Talk\Manager;
use OCP\IConfig;
use OCP\IUserManager;
use Psr\Log\LoggerInterface;
use Xmppo\Client;
use Xmppo\Protocol\Message;
use Xmppo\Protocol\Presence;

class XMPPService {
    private IConfig $config;
    private LoggerInterface $logger;
    private ?Client $client = null;
    private IChatManager $chatManager;
    private Manager $talkManager;
    private IUserManager $userManager;

    public function __construct(
        IConfig $config,
        LoggerInterface $logger,
        IChatManager $chatManager,
        Manager $talkManager,
        IUserManager $userManager
    ) {
        $this->config = $config;
        $this->logger = $logger;
        $this->chatManager = $chatManager;
        $this->talkManager = $talkManager;
        $this->userManager = $userManager;
    }

    public function connect(): bool {
        if ($this->client && $this->client->isConnected()) {
            return true;
        }

        $jid = $this->config->getAppValue('talk_xmpp_bridge', 'xmpp_jid');
        $password = $this->config->getAppValue('talk_xmpp_bridge', 'xmpp_password');
        $host = $this->config->getAppValue('talk_xmpp_bridge', 'xmpp_host');
        $port = (int)$this->config->getAppValue('talk_xmpp_bridge', 'xmpp_port', 5222);

        if (empty($jid) || empty($password) || empty($host)) {
            $this->logger->warning('XMPP Bridge is not configured.', ['app' => 'talk_xmpp_bridge']);
            return false;
        }

        try {
            $this->client = new Client(
                $jid,
                $password,
                $host,
                $port,
                function (Message $message) {
                    $this->handleIncomingMessage($message);
                },
                $this->logger
            );

            $this->client->connect();

            $presence = new Presence();
            $this->client->send($presence);

            $this->logger->info('XMPP client connected successfully using xmppo/xmpp-php.', ['app' => 'talk_xmpp_bridge']);
            return true;
        } catch (\Exception $e) {
            $this->logger->error('XMPP connection failed: ' . $e->getMessage(), ['app' => 'talk_xmpp_bridge']);
            $this->client = null;
            return false;
        }
    }

    public function listen(): void {
        if ($this->connect()) {
            $this->logger->info('Starting XMPP listener loop.', ['app' => 'talk_xmpp_bridge']);
            try {
                $this->client->processUntilDisconnect();
            } catch (\Exception $e) {
                $this->logger->error('XMPP listener loop failed: ' . $e->getMessage(), ['app' => 'talk_xmpp_bridge']);
            }
        } else {
            $this->logger->error('Could not start XMPP listener: connection failed.', ['app' => 'talk_xmpp_bridge']);
        }
    }

    public function sendMessage(string $to, string $body, bool $isGroup = false): void {
        if (!$this->connect()) {
            $this->logger->error('Cannot send XMPP message: client is not connected.', ['app' => 'talk_xmpp_bridge']);
            return;
        }

        try {
            $message = new Message();
            $message->setTo($to)->setBody($body);
            $message->setType($isGroup ? Message::TYPE_GROUPCHAT : Message::TYPE_CHAT);

            $this->client->send($message);
        } catch (\Exception $e) {
            $this->logger->error('Failed to send XMPP message to ' . $to . ': ' . $e->getMessage(), ['app' => 'talk_xmpp_bridge']);
        }
    }

    public function handleIncomingMessage(Message $message): void {
        $from = $message->getFrom();
        $body = $message->getBody();
        $botJid = $this->config->getAppValue('talk_xmpp_bridge', 'xmpp_jid');

        if (empty($body) || strpos($from, $botJid) === 0) {
            return;
        }

        $this->logger->info('Received XMPP message from ' . $from, ['app' => 'talk_xmpp_bridge']);
        $botUserId = $this->config->getAppValue('talk_xmpp_bridge', 'bot_user_id');
        $conversation = null;

        try {
            if ($message->getType() === Message::TYPE_GROUPCHAT) {
                $roomName = explode('@', $from)[0];
                $rooms = $this->talkManager->getListedRoomsForUser($botUserId, $roomName);
                foreach ($rooms as $room) {
                    if ($room->getDisplayName() === $roomName) {
                        $conversation = $room;
                        break;
                    }
                }
            } else { // 1-to-1 chat
                $senderUsername = explode('@', $from)[0];
                if ($this->userManager->userExists($senderUsername)) {
                    $conversation = $this->talkManager->getOne2OneRoom($senderUsername, $botUserId);
                }
            }
        } catch (\Exception $e) {
            $this->logger->warning('Could not find a matching conversation for JID ' . $from . ': ' . $e->getMessage(), ['app' => 'talk_xmpp_bridge']);
            return;
        }

        if ($conversation) {
            $actorId = $botUserId;
            if ($message->getType() !== Message::TYPE_GROUPCHAT) {
                 $senderUsername = explode('@', $from)[0];
                 if ($this->userManager->userExists($senderUsername)) {
                     $actorId = $senderUsername;
                 }
            }

            $finalMessage = $body;
            if ($message->getType() === Message::TYPE_GROUPCHAT) {
                $senderNode = explode('/', $from)[1] ?? explode('@', $from)[0];
                $finalMessage = '[' . $senderNode . ']: ' . $body;
            }

            $this->chatManager->sendMessage($conversation->getToken(), $finalMessage, $actorId);
        } else {
            $this->logger->warning('No matching Talk conversation found for XMPP message from ' . $from, ['app' => 'talk_xmpp_bridge']);
        }
    }

    public function __destruct() {
        if ($this->client && $this->client->isConnected()) {
            $this->client->disconnect();
        }
    }
}
