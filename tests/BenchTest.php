<?php

namespace Tests;

use Bench\Bench;
use Bench\Country;
use Bench\TimeZone;

use PHPUnit\Framework\TestCase;

class BenchTest extends Testcase 
{
	
	//basically create a instance using bench and make sure we get the correct one back.
	public function testCreateTimeZoneInstance() 
	{
		$tz = 'America/Los_Angeles';

		$instance = Bench::createTimeZone('now', $tz);

		$this->assertInstanceOf(TimeZone::class, $instance);

		$this->assertSame($tz, $instance->getName());

	}

	//make sure we can get the countries.
	public function testGetCountrires() 
	{
		$countries = Bench::getCountries();

		$this->assertSame(true, is_array($countries));

		$this->assertGreaterThanOrEqual(1, count($countries));

	}

	//
	public function testGetCountryByCode() 
	{
		$country_code = 'US';

		$country = Bench::getCountries($country_code);

		$this->assertInstanceOf(Country::class, $country);

		$this->assertSame($country_code, $country->getCode());
	}

	//get all time zones.
	public function testGetTimezones() 
	{
		$timzones = Bench::getTimezones();

		$this->assertSame(true, is_array($timzones));

		$this->assertGreaterThanOrEqual(1, count($timzones));

	}

	//now first get all countries, then get all time zones for each country and make sure each country has unique offsets.
	public function testGetUniqueTimezonesByCountryCode() 
	{
		$countries = Bench::getCountries();

		$time = 'now';

		//load all countries.
		foreach($countries as $country) {

			$offsets = [];

			//grab all time zones for that country.
			$timezones = Bench::getTimezones($country->getCode(), $time, true);

			//make sure we get an array for each country of timee zones.
			$this->assertSame(true, is_array($timezones));

			//loop through time zones to get offset.
			foreach($timezones as $tz) {

				//push offset.
				array_push($offsets, $tz->getOffset());

			}

			//now makes sure its still the same after we apply array_unique
			$this->assertSame($offsets, array_unique($offsets));

			$this->assertEquals($offsets, array_unique($offsets));



		}

	}

}