<?php
namespace TroiaStudio\ExchangeRate\CNB;

use TroiaStudio\ExchangeRate\IExchange;

final class Other extends CNB implements IExchange
{
	/**
	 * [$url description]
	 * @var string
	 */
	private $url_absolute = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_ostatnich_men/kurzy.txt";

	/**
	 * [$url description]
	 * @var string
	 */
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

	/**
	 * [$currency description]
	 * @var string
	 */
	public $currency = "CZK";

}
