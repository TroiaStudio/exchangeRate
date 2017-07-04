# exchangeRate

[![Travis](https://travis-ci.org/JanGalek/exchangeRate.svg?branch=master)](https://travis-ci.org/JanGalek/exchangeRate)
[![Total Downloads](https://poser.pugx.org/galek/exchange-rate/downloads)](https://packagist.org/packages/galek/exchange-rate)
[![Latest Stable Version](https://poser.pugx.org/galek/exchange-rate/v/stable)](https://packagist.org/packages/galek/exchange-rate)
[![License](https://poser.pugx.org/galek/exchange-rate/license)](https://packagist.org/packages/galek/exchange-rate)
[![Monthly Downloads](https://poser.pugx.org/galek/exchange-rate/d/monthly)](https://packagist.org/packages/galek/exchange-rate)


Package Installation
-------------------

The best way to install Exchange Rate is using [Composer](http://getcomposer.org/):

```sh
$ composer require galek/exchange-rate
```

[Packagist - Versions](https://packagist.org/packages/galek/exchange-rate)

or manual edit composer.json in your project

```json
"require": {
    "galek/exchange-rate": "^0.2.8"
}
```

Usage
----

ČNB - Česká Národní Banka / CNB - Czech National Bank
-----------------------------------------------------

You can use exchange rate of ČNB

Daily exchange rate ([#avaible countries](https://github.com/JanGalek/exchangeRate/wiki/%C4%8CNB---Daily-countries))
-------------------
```php
$cnb = new \Galek\Utils\Exchange\CNB\Day;
```

Monthly exchange rate ([#Exotic country](https://github.com/JanGalek/exchangeRate/wiki/%C4%8CNB---Exotic-countries)))
--------------------------------------
```php
$cnb = new \Galek\Utils\Exchange\CNB\Day;
```

TODO
----
- Universal calculatator for transfer between exchanges
- Add Raiffeisenbank
- Add Česká spořitelna
- Add ČSOB
- Add MoneyBank
- Add ... (write to issue if you want add some else)
