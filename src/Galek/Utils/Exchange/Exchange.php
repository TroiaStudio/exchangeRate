<?php
namespace Galek\Utils\Exchange;

/**
 * @author Jan Galek
 */
abstract class Exchange implements IExchange
{
	public $currency = 'CZK';

	public function transfertToCZK($currency, $amount = 1, $round = false)
	{
		$m = $this->findBy('currency', $currency);
		$transfer = $amount * $m['rate'];
		if ($round) {
			$transfer = round($transfer);
		}
		return $transfer;
	}

	public function findBy($index, $value)
	{
		return $this->parser->findBy($index, $value);
	}
	
}
