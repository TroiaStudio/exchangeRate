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

	/** @var string Bank currency */
	public $currency = "EUR";

	public function transferBasicCurrency($currency, $amount = 1, $round = false)
	{
		$v = $this->getFindByValue($currency);
		$m = $this->findBy($v['by'], $v['value']);

		$transfer = $amount * $m['rate'] / $m['amount'];
		if ($round) {
			$transfer = round($transfer);
		} else {
			$transfer = round($transfer, $this->roundspaces);
		}
		return $transfer;
	}

	public function getRate($currency)
	{
		return $this->findBy('code', $currency);
	}

	public function transferToEuro($currency, $amount = 1, $round = false)
	{
		return $this->transfer($currency, ['code', 'EUR'], $amount, $round);
	}

	public function transferToCZK($currency, $amount = 1, $round = false)
	{
		return $this->transfer($currency, ['code', 'CZK'], $amount, $round);
	}

	public function getExchange($currency = null, $value = null)
	{
		$by = $currency;
		if (is_array($currency)) {
			$by = $currency[0];
			if ($value === null && isset($currency[1])) {
				$value = $currency[1];
			}
		}
		return ($currency === null ? $this->getAll() : $this->parser->findBy($by, $value));
	}

	public function transferFrom($currency, $amount = 1, $round = false)
	{
		$v = $this->getFindByValue($currency);
		$m = $this->findBy($v['by'], $v['value']);

		$transfer = ($amount * $m['rate'] / $m['amount']);
		if ($round) {
			$transfer = round($transfer);
		} else {
			$transfer = round($transfer, $this->roundspaces);
		}

		return $transfer;
	}

	public function transferTo($currency, $amount = 1, $round = false)
	{
		$v = $this->getFindByValue($currency);
		$m = $this->findBy($v['by'], $v['value']);

		$transfer = ($amount / $m['rate'] * $m['amount']);
		if ($round) {
			$transfer = round($transfer);
		} else {
			$transfer = round($transfer, $this->roundspaces);
		}

		return $transfer;
	}

	public function findBy($index = null, $value = null)
	{
		return $this->parser->findBy($index, $value);
	}

	public function getAll()
	{
		return $this->parser->getAll();
	}

	public function getFindByValue($currency)
	{
		$by = (is_string($currency) ? 'code' : $currency[0]);
		$value = (is_string($currency) ? $currency : $currency[1]);
		return ['by' => $by, 'value' => $value];
	}

}
