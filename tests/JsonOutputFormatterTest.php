<?php

declare(strict_types=1);

namespace Tests\HPT;

use HPT\JsonOutputFormatter;
use HPT\StolenData;
use PHPUnit\Framework\TestCase;

final class JsonOutputFormatterTest extends TestCase
{

	public function testCanFormatOutputToJson(): void
	{
		$formatter = new JsonOutputFormatter();
		$formatter->addData(new StolenData('a', 'b', 1));
		$formatter->addData(new StolenData('c', 'd', 2));

		self::assertSame(
			'{"a":{"price":1,"manufacturer_code":"b"},"c":{"price":2,"manufacturer_code":"d"}}',
			$formatter->getJson()
		);
	}
}
