<?php
namespace Galek\Utils\Exchange\CNB;

use Galek\Utils\Exchange\Downloader;

final class Other extends CNB implements \Galek\Utils\Exchange\IExchange
{
	/**
	 * [$url description]
	 * @var string
	 */
	private $url_absolute = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_ostatnich_men/kurzy.txt";

   	public $url = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_ostatnich_men/kurzy.txt";

	/**
	 * [$validate description]
	 * @var string
	 */
	public $validate = '23:40';

	/**
	 * [$freq description]
	 * @var string
	 */
	public $freq = "m";

	public $currency = "CZK";

}
