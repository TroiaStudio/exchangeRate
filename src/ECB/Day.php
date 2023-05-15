<?php
namespace TroiaStudio\ExchangeRate\ECB;

use TroiaStudio\ExchangeRate\IExchange;

final class Day extends ECB implements IExchange
{
	/**
	 * [$url_absolute description]
	 * @var string
	 */
	private $url_absolute = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

	/**
	 * [$url description]
	 * @var string
	 */
	public $url = "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";

	/**
	 * [$freq description]
	 * @var string
	 */
	public $freq = "d";

	/**
	 * [$currency description]
	 * @var string
	 */
	public $currency = "EUR";

	/**
	 * [getZloty description]
	 * @return [type] [description]
	 */
	public function getZloty()
	{
		return $this->parser->findBy('code', 'PLN')['rate'];
	}

}
