<?php
namespace Galek\Utils\Exchange;

use Galek\Utils\Calendar\Day;
use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;
use Galek\Utils\Calendar\Calendar;

final class Downloader
{
	/** @var string */
	public $url;

	/** @var array */
	public $validate;

	/** @var Cache */
	private $cache;

	private $tempDir;

	/**
	 * [__construct description]
	 * @param [type] $validate [description]
	 * @param string $tempDir
	 * @param [type] $url      [description]
	 */
	public function __construct($validate, $tempDir, $url = null)
	{
		$this->validate = $validate;
		$this->tempDir = $tempDir;
		$this->url = $url;
		if ($url !== null) {
			$this->cacheData();
		}
	}

	public function setTempDir($tempDir)
	{
		$this->tempDir = $tempDir;
	}

	/**
	 * [setUrl description]
	 * @param [type] $url [description]
	 */
	public function setUrl($url)
	{
		$this->url = $url;
		$this->cacheData();
	}

	/**
	 * [getFile description]
	 * @return [type] [description]
	 */
	public function getFile()
	{
		return $this->cacheData();
	}

	/**
	 * [validateTime description]
	 * @return [type] [description]
	 */
	private function validateTime()
	{
		$now = new Calendar();
		$d = $now->format('d');
		$m = $now->format('m');
		$Y = $now->format('Y');
		$t = $now->format('t');

		$day = ($this->validate[0] === "d" ? $d : $t);

		$invalidTime = new Calendar($day.'.'.$m.'.'.$Y.' '.$this->validate[1]);
		$invalidTime->add(date_interval_create_from_date_string('5 minutes'));

		$diff = strtotime($invalidTime->format('Y-m-d H:i:s')) - strtotime($now->format('Y-m-d H:i:s'));
		if ($diff < 0) {
			$invalidTime->add(date_interval_create_from_date_string('1 days'));
			$diff = strtotime($invalidTime->format('Y-m-d H:i:s')) - strtotime($now->format('Y-m-d H:i:s'));
		}

		return $diff;
	}

	/**
	 * [cacheData description]
	 * @return [type] [description]
	 */
	public function cacheData()
	{
		if (!$this->getCache()->load($this->url)) {
			$this->download($this->url, $this->validateTime());
		}
		return $this->getCache()->load($this->url);
	}

	/**
	 * [download description]
	 * @param  [type] $url         [description]
	 * @param  [type] $invalidTime [description]
	 * @return [type]              [description]
	 */
	private function download($url, $invalidTime)
	{
		$status = false;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		if (($data = curl_exec($ch)) !== false) {
			if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
				$status = true;
			}
		}
		curl_close($ch);

		if ($status === true) {
			$this->saveToFile($url, $data);
		} else {
			$data = $this->loadToFile($url);
		}

		$this->getCache()->save($url, $data, [Cache::EXPIRE => $invalidTime]);
	}

	/**
	 * Save to file, for next unavaible connect
	 * @param  string $url  [description]
	 * @param  [type] $data [description]
	 */
	private function saveToFile($url, $data)
	{
		$filename = $this->tempDir . md5($url).'.txt';
		$handle = fopen('nette.safe://'.$filename, 'w');
		fwrite($handle, $data);
		fclose($handle);
	}

	/**
	 * Save to file, for next unavaible connect
	 * @param  string $url  [description]
	 * @param  [type] $data [description]
	 */
	private function loadToFile($url)
	{
		$filename = $this->tempDir . md5($url).'.txt';

		$handle = fopen('nette.safe://'.$filename, 'r');
		$result = fread($handle, filesize($filename));
		fclose($handle);
		return $result;
	}

	/**
	 * [getCache description]
	 * @return [type] [description]
	 */
	private function getCache()
	{
		if (!$this->cache) {
			$storage = new FileStorage($this->tempDir);
			$this->cache = new Cache($storage);
		}
		return $this->cache;
	}

}
