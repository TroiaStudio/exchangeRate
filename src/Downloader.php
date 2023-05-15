<?php
namespace TroiaStudio\ExchangeRate;

use Nette\Utils\DateTime;
use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;

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
		if ($url !== null && $tempDir !== null) {
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
		$now = new DateTime();
		$d = $now->format('d');
		$m = $now->format('m');
		$Y = $now->format('Y');
		$t = $now->format('t');

		$day = ($this->validate[0] === "d" ? $d : $t);

		$invalidTime = new DateTime($day.'.'.$m.'.'.$Y.' '.$this->validate[1]);
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

    private function getFileName($url): string
    {
        return md5($url) . '.txt';
    }

    private function getFilePath($url): string
    {
        return $this->tempDir . '/' . $this->getFileName($url);
    }

	/**
	 * Save to file, for next unavaible connect
	 * @param  string $url  [description]
	 * @param  [type] $data [description]
	 */
	private function saveToFile($url, $data)
	{
		$filename = $this->getFilePath($url);
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
		$filename = $this->getFilePath($url);

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
