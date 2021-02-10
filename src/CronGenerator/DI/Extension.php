<?php declare(strict_types = 1);

namespace Wavevision\CronGenerator\DI;

use hollodotme\CrontabValidator\CrontabValidator;
use Nette;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Wavevision\CronGenerator\Generator;

class Extension extends CompilerExtension
{

	private const TASKS = 'tasks';

	public function loadConfiguration(): void
	{
		/** @var array<mixed> $config */
		$config = $this->getConfig();
		$this->getContainerBuilder()
			->addDefinition('cronGenerator')
			->setFactory(
				Generator::class,
				[
					self::TASKS => $config[self::TASKS],
				]
			);
	}

	public function getConfigSchema(): Nette\Schema\Schema
	{
		$cronTabValidator = new CrontabValidator();
		return Expect::structure(
			[
				self::TASKS => Expect::listOf(
					Expect::structure(
						[
							Generator::COMMAND => Expect::string()->required(),
							Generator::FREQUENCY => Expect::string()->required()->assert(
								fn(string $frequency): bool => $cronTabValidator->isExpressionValid(
									$frequency,
								),
								'Invalid cron expression'
							),
							Generator::OPTIONS => Expect::string(),
							Generator::LOG => Expect::bool(true),
						]
					)->castTo('array')
				),
			]
		)->castTo('array');
	}

}
