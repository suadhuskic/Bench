[Bench]
===========

## Bench yo' time zones! 
You shouldn't be scared of time zones and you shouldn't present `America/Los_Angeles` as an option to the user.

Just to get your attention, heres an example:
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Bench\Bench;
	
//get all the countries in the united states.
//A two-letter ISO 3166-1 compatible country code,
//the time to use when starting the instance. Carbon\Carbon will be used.
//true/false - do you want unique offsets per country.
$us_time_zones = Bench::getTimezones('US', 'now', true);

foreach($us_time_zones as $tz) {
	echo $tz->getName()."\n";
	echo $tz->getShortAbbr()."\n";
	echo $tz->getLongAbbr()."\n";
	echo $tz->getOffset()."\n";
	echo $tz."\n";
	echo "----------------------------\n";

}

```
The answer is YES. I do take Daylight/Standard into consideration. The abbreviations are generated after starting the Carbon instance using the `$time` you passed.

The code above will output:
```php

// America/Adak
// HDT
// Hawaii-Aleutian Daylight Time
// -09:00
// (GMT -09:00) Hawaii-Aleutian Daylight Time
// ----------------------------
// America/Anchorage
// AKDT
// Alaska Daylight Time
// -08:00
// (GMT -08:00) Alaska Daylight Time
// ----------------------------
// America/Boise
// MDT
// Mountain Daylight Time
// -06:00
// (GMT -06:00) Mountain Daylight Time
// ----------------------------
// America/Chicago
// CDT
// Central Daylight Time
// -05:00
// (GMT -05:00) Central Daylight Time
// ----------------------------
// America/Detroit
// EDT
// Eastern Daylight Time
// -04:00
// (GMT -04:00) Eastern Daylight Time
// ----------------------------
// America/Los_Angeles
// PDT
// Pacific Daylight Time
// -07:00
// (GMT -07:00) Pacific Daylight Time
// ----------------------------
// Pacific/Honolulu
// HST
// Hawaii Standard Time
// -10:00
// (GMT -10:00) Hawaii Standard Time
// ----------------------------

```

## Installation

### With Composer

```
$ composer require suadhuskic/bench
```
Getting an array of countries:
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Bench\Bench;

//get the countries. time zones are lazy-loaded per country. they dont get loaded until you call the getter the first time.
$countries = Bench::getCountries();
print_r($countries[0]);

// Bench\Country Object
// (
//     [code:protected] => AF
//     [name:protected] => Afghanistan
//     [timeZones:protected] => Array
//         (
//         )
// 
// )
```
Or get a specific country. don't forget timezones are lazy-loaded.
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Bench\Bench;

$country = Bench::getCountries('FR');
print_r($country);
// Bench\Country Object
// (
//     [code:protected] => FR
//     [name:protected] => France
//     [timeZones:protected] => Array
//         (
//         )
// 
// )
```
Now if you want the time zones for a country; call the getter:
```php
print_r($country->getTimezones());
// Array
// (
//     [0] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-17 01:42:33.593773
//                     [timezone_type] => 3
//                     [timezone] => Europe/Paris
//                 )
// 
//             [shortAbbr:protected] => CEST
//             [longAbbr:protected] => Central European Summer Time
//         )
// 
// )


```
getters for `Bench\Country`:
 - `getCode` - A two-letter ISO 3166-1 compatible country code.
 - `getName` - the full country name
 - `getTimezones(string $time='now', bool $unqiueOffsets=false)` - get all time zones.
 
 
 ---
 
 We want to use Bench\Bench as the factory. Getting a `Bench\TimeZone` instance:

 ```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Bench\Bench;

$timezone = Bench::createTimeZone('now', 'America/Los_Angeles');

print_r($timezone);
// Bench\TimeZone Object
// (
//     [carbon:protected] => Carbon\Carbon Object
//         (
//             [date] => 2017-08-16 16:46:18.410848
//             [timezone_type] => 3
//             [timezone] => America/Los_Angeles
//         )
// 
//     [shortAbbr:protected] => PDT
//     [longAbbr:protected] => Pacific Daylight Time
// ) 
 
 ```
 getters for `Bench\TimeZone`:
 - `getName` - America/Los_Angeles
 - `getShortAbbr` - PDT
 - `getLongAbbr` - Pacific Daylight Time
 - `getLongAbbrWithGMTOffset` - (GMT -07:00) Pacific Daylight Time
 - `getOffset(string $type='human')` - human=-07:00, hours=-7, *=-25200
 
 
 ---

 
