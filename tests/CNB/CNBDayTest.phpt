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

class CNBDayTest extends CNBTestCase
{
	public function testTransferCZFormat()
	{
		Assert::equal(27.02, $this->day->transferToCZK('euro'));
		Assert::equal(27.02, $this->day->transferToCZK(['currency', 'euro']));
		Assert::equal(27.02, $this->day->transferToCZK(['country', 'EMU']));
		Assert::equal(27.02, $this->day->transferToCZK(['code', 'EUR']));
		Assert::equal(19.12, $this->day->transferToCZK(['country', 'Austrálie']));
	}

	public function testTransferCZCount()
	{
		Assert::equal(2702.0, $this->day->transferToCZK('euro', 100));
		Assert::equal(270.2, $this->day->transferToCZK('euro', 10));
		Assert::equal(27.02, $this->day->transferToCZK('euro', 1));
		Assert::equal(0.43, $this->day->transferToCZK('rubl', 1));
		Assert::equal(4.27, $this->day->transferToCZK('rubl', 10));
		Assert::equal(42.71, $this->day->transferToCZK('rubl', 100));
	}

	public function testTransferOtherCount()
	{
		Assert::equal(100.0, $this->day->transferToOther('euro', 2702));
		Assert::equal(9.99, $this->day->transferToOther('euro', 270));
		Assert::equal(1.0, $this->day->transferToOther('euro', 27.02));
		Assert::equal(1.01, $this->day->transferToOther('rubl', 0.43));
		Assert::equal(10.0, $this->day->transferToOther('rubl', 4.27));
		Assert::equal(100.0, $this->day->transferToOther('rubl', 42.71));
	}

	public function testTransferBetween()
	{
		Assert::equal(6326.24, $this->day->transfer(['code', 'EUR'], ['code', 'RUB'], 100));
	}

	public function testThrows()
	{
		$ex = 'Wrong index ("badvalue") for search, avaible are "country", "currency", "amount", "code" and "rate". For example: findBy("code", "EUR")';
		Assert::throws(function() {
			$day = $this->getNewDay();
			$day->findBy('badvalue');
		}, 'Exception', $ex);
	}
}

$testCase = new CNBDayTest();
$testCase->run();
