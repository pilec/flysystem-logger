<?php

declare(strict_types=1);

namespace FlyLog\Bridges;

use FlyLog\FlyLogger;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use Nette\DI\CompilerExtension;
use Nette\DI\MissingServiceException;


final class FlyLoggerExtension extends CompilerExtension
{

	private $defaults = [
		'logDirectory' => '%logDir%',
	];

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$builder = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		try {
			$builder->getDefinitionByType(AdapterInterface::class);
		} catch (MissingServiceException $exception) {
			throw new MissingServiceException(
				'Please register one of FlySystem Adapter (from site http://flysystem.thephpleague.com) into DI container.'
			);
		}
//
		$builder->addDefinition($this->prefix('flySystem'))
			->setType(Filesystem::class);

		$builder->addDefinition($this->prefix('flyLogger'))
			->setType(FlyLogger::class)
			->setArguments([$config['logDirectory']]);
	}

}
