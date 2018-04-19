# Flysystem logger
Would you like to use [nette/tracy](https://github.com/nette/tracy) but on stateless server? Or in the cloud?

Then you may noticed, you cannot use local storage as a place for your logs.

But don't worry, there is a solution!

This logger is based on [flystem](http://flysystem.thephpleague.com) and it allows you to log your files anywhere,
where flysystem has adapters (S3, Azure, Dropbox, Rackspace, ...).

## Installation

```bash
composer require pilec/flysystem-logger
```

## Usage
```php
$localAdapter = new Local($this->pathToTestLog);
$this->flySystem = new Filesystem($localAdapter);

$this->logger = new FlyLogger(__DIR__ . '/log', null, null, $this->flySystem);
```

or even easier with optional dependency on [nette/di](https://github.com/nette/di)
```
# in your neon file
services:
	- S3Client # needs to be installed separately

extensions:
	FlyLog\Bridges\FlyLoggerExtension
```

and your brand new logger is registered and ready to use.

Happy coding!
