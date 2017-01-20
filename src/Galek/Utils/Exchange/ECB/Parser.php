<?php
namespace Galek\Utils\Exchange\ECB;

use Galek\Utils\Exchange\IParser;

class Parser implements IParser
{
	/** @var string */
	public $file;

	/** @var array */
	private $exchanges;

	private $adi = [
		'USD' => [
			'country' => 'USA',
			'currency' => 'dolar'
		],
		'JPY' => [
			'country' => 'Japonsko',
			'currency' => 'jen'
		],
		'BGN' => [
			'country' => 'Bulharsko',
			'currency' => 'lev'
		],
		'CZK' => [
			'country' => 'Česká republika',
			'currency' => 'koruna'
		],
		'DKK' => [
			'country' => 'Dánsko',
			'currency' => 'koruna'
		],
		'GBP' => [
			'country' => 'Velká Británie',
			'currency' => 'libra'
		],
		'HUF' => [
			'country' => 'Maďarsko',
			'currency' => 'forint'
		],
		'PLN' => [
			'country' => 'Polsko',
			'currency' => 'zlotý'
		],
		'RON' => [
			'country' => 'Rumunsko',
			'currency' => 'nové leu'
		],
		'SEK' => [
			'country' => 'Švédsko',
			'currency' => 'koruna'
		],
		'CHF' => [
			'country' => 'Švýcarsko',
			'currency' => 'frank'
		],
		'NOK' => [
			'country' => 'Norsko',
			'currency' => 'koruna'
		],
		'HRK' => [
			'country' => 'Chorvatsko',
			'currency' => 'kuna'
		],
		'RUB' => [
			'country' => 'Rusko',
			'currency' => 'rubl'
		],
		'TRY' => [
			'country' => 'Turecko',
			'currency' => 'lira'
		],
		'AUD' => [
			'country' => 'Austrálie',
			'currency' => 'dolar'
		],
		'BRL' => [
			'country' => 'Brazílie',
			'currency' => 'real'
		],
		'CAD' => [
			'country' => 'Kanada',
			'currency' => 'dolar'
		],
		'CNY' => [
			'country' => 'Čína',
			'currency' => 'renminbi'
		],
		'HKD' => [
			'country' => 'Hongkong',
			'currency' => 'dolar'
		],
		'IDR' => [
			'country' => 'Indonesie',
			'currency' => 'rupie'
		],
		'ILS' => [
			'country' => 'Izrael',
			'currency' => 'šekel'
		],
		'INR' => [
			'country' => 'Indie',
			'currency' => 'rupie'
		],
		'KRW' => [
			'country' => 'Jižní Korea',
			'currency' => 'won'
		],
		'MXN' => [
			'country' => 'Mexiko',
			'currency' => 'peso'
		],
		'MYR' => [
			'country' => 'Malajsie',
			'currency' => 'ringgit'
		],
		'NZD' => [
			'country' => 'Nový Zéland',
			'currency' => 'dolar'
		],
		'PHP' => [
			'country' => 'Filipíny',
			'currency' => 'peso'
		],
		'SGD' => [
			'country' => 'Singapur',
			'currency' => 'dolar'
		],
		'THB' => [
			'country' => 'Thajsko',
			'currency' => 'baht'
		],
		'ZAR' => [
			'country' => 'Jihoafrická rep.',
			'currency' => 'rand'
		],
	];

	/**
	 * [__construct description]
	 * @param [type] $file [description]
	 */
	public function __construct($file = null)
	{
		$this->file = $file;
		if ($file !== null) {
			$this->setExchanges();
		}
	}

	public function setFile($file)
	{
		$this->file = $file;
		$this->setExchanges();
	}

	private function object2array($object) {
		return json_decode(json_encode($object), 1);
	}

	private function loadFileLines()
	{
		$t = simplexml_load_string($this->file, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS);
		$te = $this->object2array($t)["Cube"]["Cube"];
		return $te;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return new \DateTime($this->loadFileLines()["@attributes"]['time']);
	}

	private function setExchanges()
	{
		foreach ($this->loadFileLines()["Cube"] as $index => $line) {
			$data = $line["@attributes"];
			$code = $data['currency'];
			$adi = $this->adi[$code];

			$this->exchanges[strtolower($code)] = [
				'country' => $adi['country'],
				'currency' => $adi['currency'],
				'amount' => 1,
				'code' => $code,
				'rate' => $data['rate'],
			];
		}

		$this->exchanges['emu'] = [
			'country' => 'EMU',
			'currency' => 'euro',
			'amount' => 1,
			'code' => 'EUR',
			'rate' => 1.0,
		];

	}

	private function convertToUTF8($text)
	{
		return iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
	}

	public function getAll()
	{
		return $this->exchanges;
	}

	public function findBy($by = null, $value = null)
	{
		if ($by === null || $value === null) {
			throw new \Exception('Wrong index ("'.$by.'") for search, avaible are "country", "currency", "code" and "rate". For example: findBy("code", "USD")');
		}

		foreach ($this->exchanges as $index => $data) {
			if (isset($data[$by])) {
				if ($data[$by] == $value) {
					return $this->exchanges[$index];
				} else {
				}
			} else {
				throw new \Exception('Wrong index ("'.$by.'") for search, avaible are "country", "currency", "code" and "rate". For example: findBy("code", "USD")');
			}
		}
	}

	public function getSpecificLine($country)
	{
		$country = strtolower($country);

		if (isset($this->exchanges[$country])) {
			return $this->exchanges[$country];
		} else {
			throw new \Exception('Bad Country');
		}
	}

}
