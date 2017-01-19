<?php
require_once __DIR__ . '/CNBTestCase.php';

use Tester\Assert;
use Galek\Utils\Exchange\CNB\Day;
use Galek\Utils\Exchange\CNB\Other;

class ECBDayAllTest extends CNBTestCase
{
	public function testGetAll()
	{
		$s = [
			"usa" => [
				"country" => "USA",
				"currency" => "dolar",
				"amount" => "1",
				"code" => "USD",
				"rate" => "25.335"
			]
		];
		$all = $this->day->getAll();

		Assert::same($s['usa'], $all['usa']);
	}
}

$testCase = new ECBDayAllTest();
$testCase->run();
