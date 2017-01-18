<?php
namespace Galek\Utils\Exchange;

use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;

final class Downloader
{
	/** @var string */
	public $url;

	/** @var array */
	public $validate;

	/** @var string */
	private $file;

	/** @var Cache */
	private $cache;

	public function __construct($validate, $url = null)
	{
		$this->validate = $validate;
		$this->url = $url;
		if ($url !== null) {
			$this->cacheData();
		}
	}

	public function setUrl($url)
	{
		$this->url = $url;
		$this->cacheData();
	}

	public function getFile()
	{
		return $this->cacheData();
	}

	private function validateTime()
	{
		$now = new \DateTime();
		$d = $now->format('d');
		$m = $now->format('m');
		$Y = $now->format('Y');
		$s = $now->format('s');
		$invalidTime = new \DateTime($d.'.'.$m.'.'.$Y.' '.$this->validate[1]);
		$invalidTime->add(date_interval_create_from_date_string('5 minutes'));

		$diff = strtotime($invalidTime->format('Y-m-d H:i:s')) - strtotime($now->format('Y-m-d H:i:s'));
		if ($diff < 0) {
			$invalidTime->add(date_interval_create_from_date_string('1 days'));
			$diff = strtotime($invalidTime->format('Y-m-d H:i:s')) - strtotime($now->format('Y-m-d H:i:s'));
		}

		return $diff;
	}

	public function cacheData()
	{
		if (!$this->getCache()->load($this->url)) {
			$this->download($this->url, $this->validateTime());
		}
		return $this->getCache()->load($this->url);
	}

	private function download($url, $invalidTime)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		if (($data = curl_exec($ch)) !== false) {
			if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
				$this->getCache()->save($url, $data, [Cache::EXPIRE => $invalidTime]);
			}
		}
		curl_close($ch);
	}

	private function getCache()
	{
		if (!$this->cache) {
			$storage = new FileStorage(__DIR__ . '/temp');
			$this->cache = new Cache($storage);
		}
		return $this->cache;
	}

}
