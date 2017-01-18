<?php
namespace Galek\Utils\Exchange\CNB;

use Galek\Utils\Exchange\Downloader;

final class Day extends CNB implements \Galek\Utils\Exchange\IExchange
{
	public $url = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";

}
