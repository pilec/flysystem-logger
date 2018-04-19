<?php

declare(strict_types=1);

namespace FlyLog;

require_once __DIR__ . '/../bootstrap.php';

use League\Flysystem\Adapter\Local;
use League\Flysystem\File;
use League\Flysystem\Filesystem;
use Tester\Assert;
use Tester\TestCase;

final class FlySystemLoggerTest extends TestCase
{

	/**
	 * @var string
	 */
	private $pathToTestLog;

	/**
	 * @var FlyLogger
	 */
	private $logger;

	/**
	 * @var Filesystem
	 */
	private $flySystem;


	protected function setUp()
	{
		parent::setUp();

		$this->pathToTestLog = __DIR__ . '/testLog';

		$localAdapter = new Local($this->pathToTestLog);
		$this->flySystem = new Filesystem($localAdapter);

		$this->logger = new FlyLogger(__DIR__ . '/log', null, null, $this->flySystem);
	}


	public function testLogIntoFile(): void
	{
		$testLogValue = 'testLogValue';

		$this->logger->log($testLogValue, FlyLogger::ERROR);

		$errorLogPath = sprintf('%s/error.log', $this->pathToTestLog);
		$contentOfFile = file_get_contents($errorLogPath);

		Assert::same($testLogValue, $contentOfFile);
	}


	public function testLogException(): void
	{
		Assert::noError(function () {
			$this->logger->log(new \LogicException('Test exception'));
		});
	}


	protected function tearDown()
	{
		parent::tearDown();
		$this->flySystem->deleteDir($this->pathToTestLog);

		$this->flySystem->createDir($this->pathToTestLog);
		$this->flySystem->write($this->pathToTestLog . '/.gitkeep', '');
	}

}


(new FlySystemLoggerTest())->run();
