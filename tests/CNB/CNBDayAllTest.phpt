<?php
require_once __DIR__ . '/CNBTestCase.php';
/*
require 'bootstrap.php';
require __DIR__ . '/../../src/Galek/Utils/Exchange/IExchange.php';
require __DIR__ . '/../../src/Galek/Utils/Exchange/CNB/CNB.php';

$basic = new \Galek\Utils\Exchange\CNB\CNB;
*/
use Tester\Assert;
use Galek\Utils\Exchange\CNB\Day;
use Galek\Utils\Exchange\CNB\Other;

class CNBDayAllTest extends CNBTestCase
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

$testCase = new CNBDayAllTest();
$testCase->run();
