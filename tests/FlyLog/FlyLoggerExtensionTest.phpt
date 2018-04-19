<?php

declare(strict_types=1);

namespace FlyLog;

require_once __DIR__ . '/../bootstrap.php';

use FlyLog\Bridges\FlyLoggerExtension;
use FlyLog\DI\TestExtension;
use Nette\DI\Compiler;
use Nette\DI\ContainerLoader;
use Tester\Assert;
use Tester\TestCase;
use Tracy\Bridges\Nette\TracyExtension;

final class FlyLoggerExtensionTest extends TestCase
{

	public function testBuild(): void
	{
		Assert::noError(function () {
			$loader = new ContainerLoader(__DIR__ . '/temp');

			$loader->load(function (Compiler $compiler) {
				$compiler->loadConfig(__DIR__ . '/config/config.test.neon');
				$compiler->addExtension('tracy', new TracyExtension());
				$compiler->addExtension('test', new TestExtension());
				$compiler->addExtension('flyLogger', new FlyLoggerExtension());
			});
		});

	}
}


(new FlyLoggerExtensionTest())->run();
