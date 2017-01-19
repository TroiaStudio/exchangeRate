<?php
namespace Galek\Utils\Exchange;

/**
 * @author Jan Galek
 */
abstract class Exchange implements IExchange
{
	/** @var IParser */
	public $parser;

	/** @var int Spaces to round */
	public $roundspaces = 2;

	public function transferToCZK($currency, $amount = 1, $round = false)
	{
		$by = (is_string($currency) ? 'currency' : $currency[0]);
		$value = (is_string($currency) ? $currency : $currency[1]);

		$m = $this->findBy($by, $value);
		$transfer = $amount * $m['rate'] / $m['amount'];
		if ($round) {
			$transfer = round($transfer);
		} else {
			$transfer = round($transfer, $this->roundspaces);
		}
		return $transfer;
	}

	public function transferToOther($currency, $amount = 1, $round = false)
	{
		$by = (is_string($currency) ? 'currency' : $currency[0]);
		$value = (is_string($currency) ? $currency : $currency[1]);

		$m = $this->findBy($by, $value);
		$transfer = $amount / $m['rate'] * $m['amount'];

		if ($round) {
			$transfer = round($transfer);
		} else {
			$transfer = round($transfer, $this->roundspaces);
		}
		return $transfer;
	}

	/**
	 * Transfer exchange from another then CZK, but USING CZK TO CONVERT!
	 * @param  [type]  $currency1 [description]
	 * @param  [type]  $currency2 [description]
	 * @param  integer $amount    [description]
	 * @param  boolean $round     [description]
	 * @return [type]             [description]
	 */
	public function transfer($currency1, $currency2, $amount = 1, $round = false)
	{
		$transfer1 = $this->transferToCZK($currency1, $amount);
		$transfer2 = $this->transferToOther($currency2, $transfer1, $round);

		return $transfer2;
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
