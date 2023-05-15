<?php
require_once __DIR__ . '/ECBTestCase.php';

use Tester\Assert;
use TroiaStudio\ExchangeRate\ECB\Day;

class ECBDayTest extends ECBTestCase
{
	/*public function testTransferCZFormat()
	{
		Assert::equal(1.0, $this->day->transferToEuro('EUR'));
		Assert::equal(27.02, $this->day->transferToCZK('EUR'));
		Assert::equal(27.02, $this->day->transferToCZK(['currency', 'euro']));
		Assert::equal(27.02, $this->day->transferToCZK(['country', 'EMU']));
		Assert::equal(27.02, $this->day->transferToCZK(['code', 'EUR']));
		Assert::equal(19.15, $this->day->transferToCZK(['country', 'Austrálie']));
	}

	public function testTransferCZCount()
	{
		Assert::equal(2702.1, $this->day->transferToCZK('EUR', 100));
		Assert::equal(270.21, $this->day->transferToCZK('EUR', 10));
		Assert::equal(27.02, $this->day->transferToCZK('EUR', 1));
		Assert::equal(0.42, $this->day->transferToCZK('RUB', 1));
		Assert::equal(4.25, $this->day->transferToCZK('RUB', 10));
		Assert::equal(42.5, $this->day->transferToCZK('RUB', 100));
	}

	public function testTransferOtherCount()
	{
		Assert::equal(2702.0, $this->day->transferTo('EUR', 2702));
		Assert::equal(73010.74, $this->day->transferTo(['code', 'CZK'], 2702));
		Assert::equal(7295.67, $this->day->transferTo(['code', 'CZK'], 270));
		Assert::equal(730.11, $this->day->transferTo(['code', 'CZK'], 27.02));
		Assert::equal(4042.43, $this->day->transferTo('RUB', 63.58));
		Assert::equal(40424.29, $this->day->transferTo('RUB', 635.8));
		Assert::equal(404244.18, $this->day->transferTo('RUB', 6358.02));
	}

	public function testTransferBetween()
	{
		Assert::equal(100.0, $this->day->transferTo('EUR', 100));
		Assert::equal(6358.02, $this->day->transferTo('RUB', 100));

		Assert::equal(6358.02, $this->day->transfer(['code', 'EUR'], ['code', 'RUB'], 100));
	}*/
}
/*
$testCase = new ECBDayTest();
$testCase->run();
*/