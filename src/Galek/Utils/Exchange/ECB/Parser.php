<?php
namespace Galek\Utils\Exchange\ECB;

use Galek\Utils\Exchange\IParser;

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

	public function setFile($file)
	{
		$this->file = $file;
		$this->setExchanges();
	}

	private function loadFileLines()
	{
		return simplexml_load_string($this->file)->Cube->Cube;
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
		dump($this->loadFileLines());
		exit;
		foreach ($this->loadFileLines()['Cube'] as $index => $line) {
			if ($index > 1 && $line != '') {
				$cut = explode('|', $line);
				$country = $this->convertToUTF8($cut[0]);

				$this->exchanges[strtolower($country)] = [
					'country' => $country,
					'currency' => $cut[1],
					'amount' => $cut[2],
					'code' => $cut[3],
					'rate' => str_replace(',', '.', $cut[4]),
				];
			}
		}
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
