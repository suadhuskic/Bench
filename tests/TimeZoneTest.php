<?php

namespace Tests;

use Bench\TimeZone;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class TimeZoneTest extends TestCase 
{

	public function testDaylightTime() 
	{
		$tz = 'America/Los_Angeles';
		
		$daylight_time_in_hayward_ca = '7/1/17 3:00pm';
		
		$timezone = TimeZone::make(Carbon::parse($daylight_time_in_hayward_ca, $tz));
		
		$this->assertSame('PDT', $timezone->getShortAbbr());
		
		$this->assertSame('Pacific Daylight Time', $timezone->getLongAbbr());
		
	}

	public function testStandardTime() 
	{
		$tz = 'America/Los_Angeles';
		
		$daylight_time_in_hayward_ca = '11/22/17 3:00pm';
		
		$timezone = TimeZone::make(Carbon::parse($daylight_time_in_hayward_ca, $tz));
		
		$this->assertSame('PST', $timezone->getShortAbbr());
		
		$this->assertSame('Pacific Standard Time', $timezone->getLongAbbr());
	}


}

