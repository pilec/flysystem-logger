<?php

declare(strict_types=1);

namespace FlyLog;

use League\Flysystem\Filesystem;
use Tracy\BlueScreen;
use Tracy\Logger;

final class FlyLogger extends Logger
{

	/**
	 * @var Filesystem
	 */
	private $filesystem;


	public function __construct(
		$directory,
		$email = null,
		BlueScreen $blueScreen = null,
		Filesystem $filesystem
	)
	{
		parent::__construct($directory, $email, $blueScreen);
		$this->filesystem = $filesystem;
	}


	public function log($value, $priority = self::INFO)
	{
		$log = parent::log($value, $priority);

		if ($value instanceof \Throwable) {
			$fileName = $this->getExceptionFile($value);
			$file = new \SplFileInfo($fileName);

			if (is_file($fileName)) {
				$this->filesystem->put($file->getBasename(), file_get_contents($file->getRealPath()));
			}
		} else {
			$fileName = sprintf('%s.log', $priority);
			$file = new \SplFileInfo($fileName);

			$this->filesystem->put($file->getBasename(), $value);
		}

		return $log;
	}
}
