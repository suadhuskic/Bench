[Bench]
===========

## Bench yo' time zones! 
You shouldn't be scared of time zones and you shouldn't present `America/Los_Angeles` as an option to the user.

Just to get your attention. Scroll down to get more details and documentation.
```php

use Bench\Bench;
	
//get all the countries in the united states.
//A two-letter ISO 3166-1 compatible country code.
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
Above will out the following:
`
America/Adak
HDT
Hawaii-Aleutian Daylight Time
-09:00
(GMT -09:00) Hawaii-Aleutian Daylight Time
----------------------------
America/Anchorage
AKDT
Alaska Daylight Time
-08:00
(GMT -08:00) Alaska Daylight Time
----------------------------
America/Boise
MDT
Mountain Daylight Time
-06:00
(GMT -06:00) Mountain Daylight Time
----------------------------
America/Chicago
CDT
Central Daylight Time
-05:00
(GMT -05:00) Central Daylight Time
----------------------------
America/Detroit
EDT
Eastern Daylight Time
-04:00
(GMT -04:00) Eastern Daylight Time
----------------------------
America/Los_Angeles
PDT
Pacific Daylight Time
-07:00
(GMT -07:00) Pacific Daylight Time
----------------------------
Pacific/Honolulu
HST
Hawaii Standard Time
-10:00
(GMT -10:00) Hawaii Standard Time
----------------------------

`