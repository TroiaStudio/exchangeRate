<?php
require __DIR__ .'/../../vendor/autoload.php';
use Tracy\Debugger;
Debugger::enable(__DIR__ . '/log'); // aktivujeme Laděnku

$basic = new \Galek\Utils\Exchange\CNB\Day;
$basic2 = new \Galek\Utils\Exchange\CNB\DayOther;

echo "Euro: ". $basic->getEuro(). '<br>';
echo "Zlotý: ". $basic->getZloty(). '<br>';

echo "EGB: ". $basic2->getEGB(). '<br>';
echo "UAH: ". $basic2->findByCountry('Ukrajina')['rate']. '<br>';
echo "Rusko: ". $basic->findBy('country', 'Rusko')['rate']. '<br>';
echo "42.711: ". $basic->findBy('rate', '42.711')['country']. '<br>';

echo "transfertToCZK: ". $basic->transfertToCZK('euro', 10, true).'<br>';
