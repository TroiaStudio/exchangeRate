<?php
require __DIR__ .'/../../vendor/autoload.php';

use Tracy\Debugger;
use Galek\Utils\Calendar;

Debugger::enable(__DIR__ . '/log');

$basic = new \Galek\Utils\Exchange\CNB\Day;
$basic3 = new \Galek\Utils\Exchange\CNB\Day;
$basic3->setHistory('12.1.2016');

$basic2 = new \Galek\Utils\Exchange\CNB\Other;

//dump($basic->getExchange());
//dump($basic->getExchange(['country', 'Rusko']));
//dump($basic2->getExchange(['country', 'Egypt']));
$t = $basic->getRate('RUB');
dump($t['amount'].' '. $t['code'] .' = '. $t['rate']. ' CZK');

$t2 = $basic2->getRate('EGP');
dump($t2['amount'].' '. $t2['code'] .' = '. $t2['rate']. ' CZK');
echo "transfert 1 EGP to CZK: ". $basic2->transferToCZK('EGP').'<br><hr>';

echo "transfert 142.4 CZK TO EGP: ". $basic2->transfer('CZK', 'EGP', 142.4).'<br><hr>';

echo "transfert 1 CZK to AUD: ". $basic->transferToCZK(['country', 'Austrálie']).'<br>';

echo "Euro: ". $basic->getEuro(). '<br>';
echo "Zlotý: ". $basic->getZloty(). '<br>';

//echo "EGB: ". $basic2->getEGB(). '<br>';
echo "UAH: ". $basic2->findByCountry('Ukrajina')['rate']. '<br>';
echo "Rusko: ". $basic->findBy('country', 'Rusko')['rate']. '<br>';
echo "42.711: ". $basic->findBy('rate', '42.711')['country']. '<br><hr>';

echo "transfer 142.4 CZK to EGP: ". $basic2->transferTo(['code', 'EGP'], 142.4).'<br>';

echo "transfert 10 euro To CZK: ". $basic->transferToCZK('EUR', 10, true).'<br>';
echo "transfert 100 CZK to Euro: ". $basic->transferTo('EUR', 100).'<br>';
echo "transfert 100 EUR TO RUB: ". $basic->transfer('EUR', 'RUB', 100).'<br><hr>';

echo "transfert 10 EUR To CZK by array: ". $basic->transferToCZK(['country', 'EMU'], 10, true).'<br>';
echo "transfert 100 CZK to Euro by array: ". $basic->transferTo(['country', 'EMU'], 100).'<br>';
echo "transfert 100 EUR TO RUB: ". $basic->transfer(['country', 'EMU'], ['country', 'Rusko'], 100).'<br><hr>';

echo "transfert 10 EUR To CZK by array: ". $basic->transferToCZK(['code', 'EUR'], 10, true).'<br>';
echo "transfert 100 CZK to Euro by array: ". $basic->transferTo(['code', 'EUR'], 100).'<br>';
echo "transfert 100 EUR TO RUB: ". $basic->transfer(['code', 'EUR'], ['code', 'RUB'], 100).'<br><hr><strong>History:</strong><br>';

echo "exchange rate RUB: ". $basic3->findBy('code', 'RUB')['rate'].'<br>';
echo "transfert 10 EUR To CZK by array: ". $basic3->transferToCZK(['code', 'EUR'], 10, true).'<br>';
echo "transfert 100 CZK to EUR by array: ". $basic3->transferTo(['code', 'EUR'], 100).'<br>';
echo "transfert 100 EUR TO RUB: ". $basic3->transfer(['code', 'EUR'], ['code', 'RUB'], 100).'<br><hr>';
echo "url: ". $basic3->getUrl().'<br>';
