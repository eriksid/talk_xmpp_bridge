<?php
declare(strict_types=1);

namespace OCA\TalkXMPPBridge\Tests\Unit\Controller;

use OCA\TalkXMPPBridge\Controller\AdminController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IConfig;
use OCP\IRequest;
use OCP\Security\IKeyStore;
use PHPUnit\Framework\TestCase;

class AdminControllerTest extends TestCase {
	private AdminController $controller;
	private IConfig $config;
	private IKeyStore $keyStore;

	protected function setUp(): void {
		parent::setUp();

		$this->config = $this->createMock(IConfig::class);
		$this->keyStore = $this->createMock(IKeyStore::class);
		$request = $this->createMock(IRequest::class);
		$this->controller = new AdminController(
			'talk_xmpp_bridge',
			$request,
			$this->config,
			$this->keyStore
		);
	}

	public function testSaveSettings(): void {
		$this->config->expects($this->exactly(5))
			->method('setAppValue');
		$this->keyStore->expects($this->once())
			->method('set')
			->with('xmpp_password', 'password');

		$response = $this->controller->saveSettings(
			'jid',
			'password',
			'host',
			5222,
			'bot',
			'domain',
			'conference'
		);

		$this->assertInstanceOf(DataResponse::class, $response);
		$this->assertEquals(['status' => 'success'], $response->getData());
	}
}