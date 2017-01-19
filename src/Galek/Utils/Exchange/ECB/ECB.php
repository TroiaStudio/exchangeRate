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

}
