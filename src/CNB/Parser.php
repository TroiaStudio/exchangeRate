<?php
namespace TroiaStudio\ExchangeRate\CNB;

use TroiaStudio\ExchangeRate\IParser;

class Parser implements IParser
{
	/** @var string */
	public $file;

	/** @var array */
	private $exchanges;

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

	/**
	 * [setFile description]
	 * @param [type] $file [description]
	 */
	public function setFile($file)
	{
		$this->file = $file;
		$this->setExchanges();
	}

	/**
	 * [loadFileLines description]
	 * @return [type] [description]
	 */
	private function loadFileLines()
	{
		return explode(chr(0x0A), $this->file);
	}

	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return new \DateTime(preg_replace('/(.*) #(.*)/', '$1', $this->loadFileLines()[0]));
	}

	/**
	 * [setExchanges description]
	 */
	private function setExchanges()
	{
		foreach ($this->loadFileLines() as $index => $line) {
			if ($index > 1 && $line != '') {
				$cut = explode('|', $line);
				$country = $this->convertToUTF8($cut[0]);

				$this->exchanges[strtolower($country)] = [
					'country' => $country,
					'currency' => $cut[1],
					'amount' => $cut[2],
					'code' => $cut[3],
					'rate' => str_replace(',', '.', $cut[4])
				];
			}
		}
		$this->exchanges['ceska republika'] = [
			'country' => 'Česká republika',
			'currency' => 'koruna',
			'amount' => 1,
			'code' => 'CZK',
			'rate' => 1.0
		];
	}

	/**
	 * [convertToUTF8 description]
	 * @param  [type] $text [description]
	 * @return [type]       [description]
	 */
	private function convertToUTF8($text)
	{
		return iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
	}

	/**
	 * [getAll description]
	 * @return [type] [description]
	 */
	public function getAll()
	{
		return $this->exchanges;
	}

	/**
	 * [findBy description]
	 * @param  [type] $by    [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function findBy($by = null, $value = null)
	{
		if ($by === null || $value === null) {
			throw new \Exception('Wrong index ("'.$by.'") for search, avaible are "country", "currency", "amount", "code" and "rate". For example: findBy("code", "EUR")');
		}
		foreach ($this->exchanges as $index => $data) {
			if (isset($data[$by])) {
				if ($data[$by] === $value) {
					return $this->exchanges[$index];
				}
			} else {
				throw new \Exception('Wrong index ("'.$by.'") for search, avaible are "country", "currency", "amount", "code" and "rate". For example: findBy("code", "EUR")');
			}
		}
	}

	/**
	 * [getSpecificLine description]
	 * @param  [type] $country [description]
	 * @return [type]          [description]
	 */
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
