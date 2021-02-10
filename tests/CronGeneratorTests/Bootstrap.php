<?php declare(strict_types = 1);

namespace Wavevision\CronGeneratorTests;

use Nette\Configurator;
use Nette\StaticClass;

class Bootstrap
{

	use StaticClass;

	public static function boot(): Configurator
	{
		$configurator = new Configurator();
		$configurator->addConfig(__DIR__ . '/../config/cronGenerator.neon');
		$configurator->setTempDirectory(__DIR__ . '/../../temp');
		return $configurator;
	}

}
