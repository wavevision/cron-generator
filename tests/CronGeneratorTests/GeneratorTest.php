<?php declare(strict_types = 1);

namespace Wavevision\CronGeneratorTests;

use Wavevision\CronGenerator\InjectCronGenerator;
use Wavevision\NetteTests\TestCases\DIContainerTestCase;
use function implode;
use const PHP_EOL;

class GeneratorTest extends DIContainerTestCase
{

	use InjectCronGenerator;

	public function test(): void
	{
		$this->assertEquals(
			implode(
				PHP_EOL,
				[
					'0 0 * * * uu php bin/console app:hello-there -f >> log/app-hello-there.log 2>&1',
					'0 1 * * * uu php bin/console app:kenobi > /dev/null 2>&1',
				]
			) . PHP_EOL,
			$this->cronGenerator->generateConfig('uu', 'php bin/console', 'log')
		);
	}

}
