<?php declare(strict_types = 1);

namespace Wavevision\CronGenerator;

trait InjectCronGenerator
{

	private Generator $cronGenerator;

	public function injectCronGenerator(Generator $cronGenerator): void
	{
		$this->cronGenerator = $cronGenerator;
	}

}
