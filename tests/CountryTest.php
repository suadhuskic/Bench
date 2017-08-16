<?php

namespace Tests;

use Bench\Bench;
use Bench\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase 
{

	public function testGetTimeZones() 
	{
		$countryCode = 'US';

		$country = new Country($countryCode, 'United States');

		//now get all time zones for that country zone.
		$timezones = $country->getTimeZones();
		
		$this->assertSame(true, is_array($timezones));

		$this->assertGreaterThanOrEqual(1, count($timezones));

	}

}

