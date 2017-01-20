<?php
namespace Galek\Utils\Exchange\ECB;

use Galek\Utils\Exchange\Downloader;

final class Day extends ECB implements \Galek\Utils\Exchange\IExchange
{
	private $url_absolute = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

	public $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

	public $freq = "d";

	public $currency = "EUR";

	public function getZloty()
	{
		return $this->parser->findBy('code', 'PLN')['rate'];
	}

}
