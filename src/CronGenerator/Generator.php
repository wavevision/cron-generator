<?php declare(strict_types = 1);

namespace Wavevision\CronGenerator;

use Nette\SmartObject;
use Nette\Utils\Arrays;
use Nette\Utils\Strings;
use function array_filter;
use function implode;
use function is_null;
use function sprintf;
use const PHP_EOL;

class Generator
{

	use SmartObject;

	public const COMMAND = 'command';

	public const FREQUENCY = 'frequency';

	public const LOG = 'log';

	public const OPTIONS = 'options';

	/**
	 * @var array<mixed>
	 */
	private array $tasks;

	/**
	 * @param array<mixed> $tasks
	 */
	public function __construct(array $tasks)
	{
		$this->tasks = $tasks;
	}

	public function generateConfig(string $user, string $consoleBin, string $logDir): string
	{
		return implode(
			PHP_EOL,
			Arrays::map(
				$this->tasks,
				fn(array $task): string => implode(
					' ',
					array_filter(
						[
							$task[self::FREQUENCY],
							$user,
							$consoleBin,
							$task[self::COMMAND],
							$task[self::OPTIONS] ?? null,
							$task[self::LOG] ? sprintf(
								">> %s",
								$logDir . '/' . $this->logFile($task[self::COMMAND]),
							) : '> /dev/null',
							'2>&1',
						],
						fn($item) => !is_null($item)
					)
				)
			)
		) . PHP_EOL;
	}

	private function logFile(string $command): string
	{
		return Strings::webalize($command) . '.log';
	}

}
