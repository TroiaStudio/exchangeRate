<?php
namespace TroiaStudio\ExchangeRate;

interface IExchange
{
	public function transfer($currency1, $currency2, $amount, $round);
}
