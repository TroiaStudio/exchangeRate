<?php
namespace TroiaStudio\ExchangeRate\CNB;

final class Day extends CNB implements \TroiaStudio\ExchangeRate\IExchange
{
	/**
	 * [$url_absolute description]
	 * @var string
	 */
	private $url_absolute = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";

	/**
	 * [$url description]
	 * @var string
	 */
	public $url = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";

	/**
	 * [$freq description]
	 * @var string
	 */
	public $freq = "d";

	/**
	 * [$currency description]
	 * @var string
	 */
	public $currency = "CZK";

	/**
	 * [getEuro description]
	 * @return [type] [description]
	 */
	public function getEuro()
	{
		return $this->parser->findBy('currency', 'euro')['rate'];
	}

	/**
	 * [getZloty description]
	 * @return [type] [description]
	 */
	public function getZloty()
	{
		return $this->parser->findBy('code', 'PLN')['rate'];
	}

}
