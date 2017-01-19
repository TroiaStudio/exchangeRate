<?php
require __DIR__ .'/../../vendor/autoload.php';

use Tracy\Debugger;
use Galek\Utils\Calendar;

Debugger::enable(__DIR__ . '/log');

$basic = new \Galek\Utils\Exchange\ECB\Day;

echo "transfert From CZK to AUD: ". $basic->transferToCZK(['country', 'Austrálie']).'<br>';

echo "Euro: ". $basic->getEuro(). '<br>';
echo "Zlotý: ". $basic->getZloty(). '<br>';

echo "Rusko: ". $basic->findBy('country', 'Rusko')['rate']. '<br>';
echo "42.711: ". $basic->findBy('rate', '42.711')['country']. '<br><hr>';

echo "transfert To CZK: ". $basic->transferToCZK('euro', 10, true).'<br>';
echo "transfert From CZK to Euro: ". $basic->transferToOther('euro', 100).'<br>';
echo "transfert EUR TO RUB: ". $basic->transfer('euro', 'rubl', 100).'<br><hr>';

echo "transfert To CZK by array: ". $basic->transferToCZK(['country', 'EMU'], 10, true).'<br>';
echo "transfert From CZK to Euro by array: ". $basic->transferToOther(['country', 'EMU'], 100).'<br>';
echo "transfert EUR TO RUB: ". $basic->transfer(['country', 'EMU'], ['country', 'Rusko'], 100).'<br><hr>';

echo "transfert To CZK by array: ". $basic->transferToCZK(['code', 'EUR'], 10, true).'<br>';
echo "transfert From CZK to Euro by array: ". $basic->transferToOther(['code', 'EUR'], 100).'<br>';
echo "transfert EUR TO RUB: ". $basic->transfer(['code', 'EUR'], ['code', 'RUB'], 100).'<br><hr><strong>History:</strong><br>';
