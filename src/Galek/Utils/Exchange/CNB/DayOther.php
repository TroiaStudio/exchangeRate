<?php
namespace Galek\Utils\Exchange\CNB;

use Galek\Utils\Exchange\Downloader;

final class DayOther extends CNB implements \Galek\Utils\Exchange\IExchange
{
	public $url = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_ostatnich_men/kurzy.txt";

	public function getEGB()
	{
		return $this->parser->getSpecificLine('Egypt')['rate'];
	}
}
