<?php
namespace Galek\Utils\Exchange;

interface IExchange
{
	public function transfer($currency1, $currency2, $amount, $round);
}
