[Bench]
===========

### Benching time zones ! You shouldn't be scared of time zones and you shouldnt present `America/Los_Angeles`  to the user neither. Yikes...that would of scared my co-worker.


Lets display a set of countries for that user to auto-complete on or simply select from.




```php
use Bench\Bench;

//get all countries.
$countries = Bench::getCountries();

//we get this:
//not time zones are lazy-loaded. when you call the getter we load them and cache them.
print_r($countries)
// [0] => Bench\Country Object
// 	(
// 	    [code:protected] => TZ
// 	    [name:protected] => Tanzania
// 	    [timeZones:protected] => Array
// 	        (
// 	        )
// 	
// 	)
// [1] => Bench\Country Object
//     (
//         [code:protected] => TH
//         [name:protected] => Thailand
//         [timeZones:protected] => Array
//             (
//             )
// 
//     )
```

## now lets get a specific country and get the time zones for that country.
```php

use Bench\Bench;

$country = Bench::getCountries('US');

//last arg is to only return unqiue offsets with in those countries.
print_r($country->getTimezones('now', true));
// Array
// (
//     [0] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 13:29:23.331822
//                     [timezone_type] => 3
//                     [timezone] => America/Adak
//                 )
// 
//             [shortAbbr:protected] => HDT
//             [longAbbr:protected] => Hawaii-Aleutian Daylight Time
//         )
// 
//     [1] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 14:29:23.332176
//                     [timezone_type] => 3
//                     [timezone] => America/Anchorage
//                 )
// 
//             [shortAbbr:protected] => AKDT
//             [longAbbr:protected] => Alaska Daylight Time
//         )
// 
//     [2] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 16:29:23.332473
//                     [timezone_type] => 3
//                     [timezone] => America/Boise
//                 )
// 
//             [shortAbbr:protected] => MDT
//             [longAbbr:protected] => Mountain Daylight Time
//         )
// 
//     [3] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 17:29:23.332771
//                     [timezone_type] => 3
//                     [timezone] => America/Chicago
//                 )
// 
//             [shortAbbr:protected] => CDT
//             [longAbbr:protected] => Central Daylight Time
//         )
// 
//     [4] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 18:29:23.333074
//                     [timezone_type] => 3
//                     [timezone] => America/Detroit
//                 )
// 
//             [shortAbbr:protected] => EDT
//             [longAbbr:protected] => Eastern Daylight Time
//         )
// 
//     [5] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 15:29:23.333459
//                     [timezone_type] => 3
//                     [timezone] => America/Los_Angeles
//                 )
// 
//             [shortAbbr:protected] => PDT
//             [longAbbr:protected] => Pacific Daylight Time
//         )
// 
//     [6] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 12:29:23.333879
//                     [timezone_type] => 3
//                     [timezone] => Pacific/Honolulu
//                 )
// 
//             [shortAbbr:protected] => HST
//             [longAbbr:protected] => Hawaii Standard Time
//         )
// 
// )
```

## Or we could of actually just done this:
```php

$us_time_zones = Bench::getTimezones('US', 'now', true);
print_r($us_time_zones);
// Array
// (
//     [0] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 13:31:34.267558
//                     [timezone_type] => 3
//                     [timezone] => America/Adak
//                 )
// 
//             [shortAbbr:protected] => HDT
//             [longAbbr:protected] => Hawaii-Aleutian Daylight Time
//         )
// 
//     [1] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 14:31:34.267905
//                     [timezone_type] => 3
//                     [timezone] => America/Anchorage
//                 )
// 
//             [shortAbbr:protected] => AKDT
//             [longAbbr:protected] => Alaska Daylight Time
//         )
// 
//     [2] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 16:31:34.268201
//                     [timezone_type] => 3
//                     [timezone] => America/Boise
//                 )
// 
//             [shortAbbr:protected] => MDT
//             [longAbbr:protected] => Mountain Daylight Time
//         )
// 
//     [3] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 17:31:34.268492
//                     [timezone_type] => 3
//                     [timezone] => America/Chicago
//                 )
// 
//             [shortAbbr:protected] => CDT
//             [longAbbr:protected] => Central Daylight Time
//         )
// 
//     [4] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 18:31:34.268810
//                     [timezone_type] => 3
//                     [timezone] => America/Detroit
//                 )
// 
//             [shortAbbr:protected] => EDT
//             [longAbbr:protected] => Eastern Daylight Time
//         )
// 
//     [5] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 15:31:34.269195
//                     [timezone_type] => 3
//                     [timezone] => America/Los_Angeles
//                 )
// 
//             [shortAbbr:protected] => PDT
//             [longAbbr:protected] => Pacific Daylight Time
//         )
// 
//     [6] => Bench\TimeZone Object
//         (
//             [carbon:protected] => Carbon\Carbon Object
//                 (
//                     [date] => 2017-08-16 12:31:34.269571
//                     [timezone_type] => 3
//                     [timezone] => Pacific/Honolulu
//                 )
// 
//             [shortAbbr:protected] => HST
//             [longAbbr:protected] => Hawaii Standard Time
//         )
// 
// )       
```
