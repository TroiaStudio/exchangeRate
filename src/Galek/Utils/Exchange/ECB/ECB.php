<?php
namespace Galek\Utils\Exchange\ECB;

use Galek\Utils\Exchange\Downloader;

abstract class ECB extends \Galek\Utils\Exchange\Exchange implements \Galek\Utils\Exchange\IExchange
{
	/** @var string */
	private $url_absolute = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

	/** @var string */
	public $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

	/** @var \DateTime | null */
	public $history = null;

	/** @var time H:i */
	public $validate = '16:30';

	/** @var string Bank currency */
	public $currency = "EUR";

	/** @var Downloader */
	public $downloader;

	/** @var Downloader */
	public $downloader2;

	/** @var Parser */
	public $parser;

	/** @var string */
	public $text;

	/**
	 * [__construct description]
	 * @param string $text For testing
	 */
	public function __construct($text = null)
	{
		$this->text = $text;
		$this->setup();
	}


	private function setup()
	{
		if ($this->text === null) {
			$this->downloader = new Downloader([$this->freq, $this->validate], $this->url);
			$this->parser = new Parser($this->downloader->getFile());
		} else {
			$this->parser = new Parser($this->text);
		}
	}

	/**
	 * [findByCountry description]
	 * @param  [type] $country [description]
	 * @return [type]          [description]
	 */
	public function findByCountry($country)
	{
		return $this->parser->findBy('country', $country);
	}

	/**
	 * [getDay description]
	 * @return [type] [description]
	 */
	public function getDay()
	{
		return $this->parser->getDate()->format('d.m.Y');
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function transferToEuro($currency, $amount = 1, $round = false)
	{
		$v = $this->getFindByValue($currency);
		$m = $this->findBy($v['by'], $v['value']);

		$transfer = $amount / $m['rate'] * $m['amount'];
		if ($round) {
			$transfer = round($transfer);
		} else {
			$transfer = round($transfer, $this->roundspaces);
		}
		return $transfer;
	}

	public function transferToCZK($currency, $amount = 1, $round = false)
	{
		return $this->transfer($currency, ['code', 'CZK'], $amount, $round);
	}

	public function transfer($currency1, $currency2, $amount = 1, $round = false)
	{
		$v = $this->getFindByValue($currency1);
		$m = $this->findBy($v['by'], $v['value']);

		$transfer = $m['rate'] * $m['amount'];

		$v2 = $this->getFindByValue($currency2);
		$m2 = $this->findBy($v2['by'], $v2['value']);

		$transfer = $m2['rate'] * $amount / $transfer;

		if ($round) {
			$transfer = round($transfer);
		} else {
			$transfer = round($transfer, $this->roundspaces);
		}

		return $transfer;
	}

	public function transferTo($currency, $amount = 1, $round = false)
	{
		return $this->transfer($this->currency, $currency, $amount, $round);
	}

}
