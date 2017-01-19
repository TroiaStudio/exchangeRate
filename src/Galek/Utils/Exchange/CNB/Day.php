<?php
namespace Galek\Utils\Exchange\CNB;

use Galek\Utils\Exchange\Downloader;

final class Day extends CNB implements \Galek\Utils\Exchange\IExchange
{
	private $url_absolute = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";

	public $url = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";

	public $freq = "d";

	public function getEuro()
	{
		return $this->parser->findBy('currency', 'euro')['rate'];
	}

	public function getZloty()
	{
		return $this->parser->findBy('code', 'PLN')['rate'];
	}

}
