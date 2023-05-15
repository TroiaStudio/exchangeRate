<?php

$container = require __DIR__ . '/../../vendor/autoload.php';

use TroiaStudio\ExchangeRate\ECB\Day;

abstract class ECBTestCase extends Tester\TestCase
{
	/** @var Day */
	public $day;

	/** @var Other */
	public $other;

	public function __construct()
	{
		$this->day = new Day(null, $this->loadFile('eurofxref-daily.xml'));
	}

	private function loadFile($filename)
	{
		$dir = __DIR__ . '/sources/';
		$file = $dir.$filename;

		$handle = fopen('nette.safe://'.$file, 'r');
		$result = fread($handle, filesize($file));
		fclose($handle);

		return $result;
	}

	public function getNewDay()
	{
		return new Day(null, $this->loadFile('eurofxref-daily.xml'));
	}

}
