<?php
require_once __DIR__ . '/CNBTestCase.php';

use Tester\Assert;

class CNBDayTest extends CNBTestCase
{
	public function testTransferCZFormat()
	{
		Assert::equal(27.02, $this->day->transferToCZK('EUR'));
		Assert::equal(27.02, $this->day->transferToCZK(['currency', 'euro']));
		Assert::equal(27.02, $this->day->transferToCZK(['country', 'EMU']));
		Assert::equal(27.02, $this->day->transferToCZK(['code', 'EUR']));
		Assert::equal(19.12, $this->day->transferToCZK(['country', 'Austrálie']));
	}

	public function testTransferCZCount()
	{
		Assert::equal(2702.0, $this->day->transferToCZK('EUR', 100));
		Assert::equal(270.2, $this->day->transferToCZK('EUR', 10));
		Assert::equal(27.02, $this->day->transferToCZK('EUR', 1));
		Assert::equal(0.43, $this->day->transferToCZK('RUB', 1));
		Assert::equal(4.27, $this->day->transferToCZK('RUB', 10));
		Assert::equal(42.71, $this->day->transferToCZK('RUB', 100));
	}

	public function testTransferOtherCount()
	{
		Assert::equal(100.0, $this->day->transferTo('EUR', 2702));
		Assert::equal(9.99, $this->day->transferTo('EUR', 270));
		Assert::equal(1.0, $this->day->transferTo('EUR', 27.02));
		Assert::equal(1.01, $this->day->transferTo('RUB', 0.43));
		Assert::equal(10.0, $this->day->transferTo('RUB', 4.27));
		Assert::equal(100.0, $this->day->transferTo('RUB', 42.71));
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
