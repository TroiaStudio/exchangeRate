<?php
namespace Galek\Utils\Exchange\CNB;

use Galek\Utils\Exchange\Downloader;

abstract class CNB extends \Galek\Utils\Exchange\Exchange implements \Galek\Utils\Exchange\IExchange
{
	/** @var string */
	public $url = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";

	/** @var time H:i */
	public $validate = '14:30';

	/** @var Downloader */
	public $downloader;

	/** @var Downloader */
	public $downloader2;

	/** @var Parser */
	public $parser;

	public function __construct()
	{
		$this->downloader = new Downloader(['d', $this->validate], $this->url);
		$this->parser = new Parser($this->downloader->getFile());
	}

	public function findByCountry($country)
	{
		return $this->parser->findBy('country', $country);
	}

	public function getDay()
	{
		return $this->parser->getDate()->format('d.m.Y');
	}

	public function getEuro()
	{
		return $this->parser->findBy('currency', 'euro')['rate'];
	}

	public function getZloty()
	{
		return $this->parser->findBy('code', 'PLN')['rate'];
	}

}
