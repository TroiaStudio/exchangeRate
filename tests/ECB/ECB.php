<?php
require __DIR__ .'/../../vendor/autoload.php';

use Tracy\Debugger;

Debugger::enable(__DIR__ . '/log');

$basic = new \TroiaStudio\ExchangeRate\ECB\Day;

//Assert::equal(6358.02, $this->day->transferTo('RUB', 100));

$t2 = $basic->getRate('RUB');
dump($t2['amount'].' '. $t2['code'] .' = '. $t2['rate']. ' EUR');

echo "transfert 100 EUR to RUB: ". $basic->transferTo('RUB', 100).'<br><hr>';

echo "transfert 1 AUD to CZK: ". $basic->transfer('AUD', 'CZK', 1).'<br><hr>';

echo "transfert 1 AUD to CZK: ". $basic->transferToCZK('AUD', 1).'<br><hr>';
