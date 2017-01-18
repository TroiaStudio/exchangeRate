<?php
namespace Galek\Utils\Exchange;

/**
 * @author Jan Galek
 */
abstract class Exchange implements IExchange
{
	/** @var IParser */
	public $parser;

	public function __construct()
	{

	}

	public function transfertToCZK($currency, $amount = 1, $round = false)
	{
		$m = $this->findBy('currency', $currency);
		$transfer = $amount * $m['rate'];
		if ($round) {
			$transfer = round($transfer);
		}
		return $transfer;
	}

	public function transfer($currency1, $currency2, $amount = 1, $round = false)
	{
		$m1 = $this->findBy('currency', $currency1);
		$m2 = $this->findBy('currency', $currency2);

		//$transfer = $

	}

	public function findBy($index = null, $value = null)
	{
		return $this->parser->findBy($index, $value);
	}

	public function getAll()
	{
		return $this->parser->getAll();
	}

}
