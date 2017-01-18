<?php
namespace Galek\Utils\Exchange\CNB;

use Galek\Utils\Exchange\IParser;

class Parser implements IParser
{
	/** @var string */
	public $file;

	/** @var array */
	private $exchanges;

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
		return explode(chr(0x0A), $this->file);
	}

	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return new \DateTime(preg_replace('/(.*) #(.*)/', '$1', $this->loadFileLines()[0]));
	}

	private function setExchanges()
	{
		foreach ($this->loadFileLines() as $index => $line) {
			if ($index > 1 && $line != '') {
				$cut = explode('|', $line);
				$this->exchanges[strtolower($cut[0])] = [
					'country' => $cut[0],
					'currency' => $cut[1],
					'amount' => $cut[2],
					'code' => $cut[3],
					'rate' => str_replace(',', '.', $cut[4]),
				];
			}
		}
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
