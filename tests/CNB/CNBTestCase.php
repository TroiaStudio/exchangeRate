<?php

$container = require __DIR__ . '/../../vendor/autoload.php';

use Galek\Utils\Exchange\CNB\Day;
use Galek\Utils\Exchange\CNB\Other;

abstract class CNBTestCase extends Tester\TestCase
{
	/** @var Day */
	public $day;

	/** @var Other */
	public $other;

	public function __construct()
	{
		$this->day = new Day($this->loadFile('denni_kurz.txt'));
		$this->other = new Other($this->loadFile('kurzy.txt'));
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
		return new Day($this->loadFile('denni_kurz.txt'));
	}

	public function getNewOther()
	{
		return new Other($this->loadFile('kurzy.txt'));
	}
}
