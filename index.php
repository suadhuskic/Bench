<?php

require __DIR__ . '/vendor/autoload.php';

use Bench\Bench;

//tests to write:
//create a TimeZone instance with date of Feb 26, 2018 9:0AM
//make sure:
// 	we get a instance of TimeZone
// 	check if Carbon dates match up with what we passed to use.


//get countries
//make sure we get an array and greater then 0.


//get time zones for a specific country using bench
//get timezones using country::gettimezones and compare results

//start a new time zone instance and set the time to user during day light 
//then check if the abbrivations match up with daylight or not.



// //returns
// Bench\Country;
// 	->name
// 	->timezones => Bench\TimeZones; // lazy load.

$countries = Bench::getCountries();

echo count($countries);
exit();

$country = $countries[0];

print_r($country->getTimeZones());

echo $country->getTimeZones()[0]."\n";

// foreach(Bench::getTimezones('US', 'now', true) as $tz) {

// //	echo $tz->name()." - ".$tz->offset()."\n";

// 	echo "name: ".$tz->getName()."\n";
// 	echo "offset: ".$tz->getOffset()."\n";
// 	echo "long abbr: ".$tz->getLongAbbr()."\n";
// 	echo "for humans: ".$tz."\n";

// 	echo "------------\n";

// }

// //now make our own time zone from saved string.
// $saved_time_zone_from_db = "America/Los_Angeles";

// echo "loading from database: "."\n";
// echo "found tz from db: ".$saved_time_zone_from_db."\n";

// echo "bench returned: ".Bench::createTimeZone('now', $saved_time_zone_from_db)."\n";
