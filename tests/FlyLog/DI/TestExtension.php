<?php

declare(strict_types=1);

namespace FlyLog\DI;

use League\Flysystem\Adapter\Local;
use Nette\DI\CompilerExtension;

final class TestExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('adapter'))
			->setType(Local::class)
			->setArguments([
				__DIR__
			]);
	}
}
