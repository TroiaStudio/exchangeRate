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

	public $tempDir;

	public function __construct($tempDir = null)
	{
		$this->setTempDir($tempDir);
	}

	public function setTempDir($tempDir)
	{
		if ($tempDir == null) {
			$this->tempDir = __DIR__ . '/temp/';
		} else {
			$this->tempDir = $tempDir;
		}
	}

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

	/**
	 * [getRate description]
	 * @param  [type] $currency [description]
	 * @return [type]           [description]
	 */
	public function getRate($currency)
	{
		return $this->findBy('code', $currency);
	}

	/**
	 * [transferToEuro description]
	 * @param  [type]  $currency [description]
	 * @param  integer $amount   [description]
	 * @param  boolean $round    [description]
	 * @return [type]            [description]
	 */
	public function transferToEuro($currency, $amount = 1, $round = false)
	{
		return $this->transfer($currency, ['code', 'EUR'], $amount, $round);
	}

	/**
	 * [transferToCZK description]
	 * @param  [type]  $currency [description]
	 * @param  integer $amount   [description]
	 * @param  boolean $round    [description]
	 * @return [type]            [description]
	 */
	public function transferToCZK($currency, $amount = 1, $round = false)
	{
		return $this->transfer($currency, ['code', 'CZK'], $amount, $round);
	}

	/**
	 * [getExchange description]
	 * @param  [type] $currency [description]
	 * @param  [type] $value    [description]
	 * @return [type]           [description]
	 */
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

	/**
	 * [transferFrom description]
	 * @param  [type]  $currency [description]
	 * @param  integer $amount   [description]
	 * @param  boolean $round    [description]
	 * @return [type]            [description]
	 */
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

	/**
	 * [transferTo description]
	 * @param  [type]  $currency [description]
	 * @param  integer $amount   [description]
	 * @param  boolean $round    [description]
	 * @return [type]            [description]
	 */
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

	/**
	 * [findBy description]
	 * @param  [type] $index [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function findBy($index = null, $value = null)
	{
		return $this->parser->findBy($index, $value);
	}

	/**
	 * [getAll description]
	 * @return [type] [description]
	 */
	public function getAll()
	{
		return $this->parser->getAll();
	}

	/**
	 * [getFindByValue description]
	 * @param  [type] $currency [description]
	 * @return [type]           [description]
	 */
	public function getFindByValue($currency)
	{
		$by = (is_string($currency) ? 'code' : $currency[0]);
		$value = (is_string($currency) ? $currency : $currency[1]);
		return ['by' => $by, 'value' => $value];
	}

}
