<?php
declare(strict_types=1);

namespace OCA\TalkXMPPBridge\Tests\Unit\Service;

use OCA\Talk\Api\IChatManager;
use OCA\Talk\Manager;
use OCA\TalkXMPPBridge\Service\XMPPService;
use OCP\IConfig;
use OCP\IUserManager;
use OCP\Security\IKeyStore;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;

class XMPPServiceTest extends TestCase {
	private XMPPService $service;
	private IConfig $config;
	private IKeyStore $keyStore;
	private LoggerInterface $logger;
	private IChatManager $chatManager;
	private Manager $talkManager;
	private IUserManager $userManager;

	protected function setUp(): void {
		parent::setUp();

		$this->config = $this->createMock(IConfig::class);
		$this->keyStore = $this->createMock(IKeyStore::class);
		$this->logger = $this->createMock(LoggerInterface::class);
		$this->chatManager = $this->createMock(IChatManager::class);
		$this->talkManager = $this->createMock(Manager::class);
		$this->userManager = $this->createMock(IUserManager::class);

		$this->service = new XMPPService(
			$this->config,
			$this->logger,
			$this->chatManager,
			$this->talkManager,
			$this->userManager,
			$this->keyStore
		);
	}

	public function testConnectNotConfigured(): void {
		$this->config->method('getAppValue')->willReturn('');
		$this->assertFalse($this->service->connect());
	}
}