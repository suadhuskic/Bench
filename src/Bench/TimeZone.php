<?php

namespace Bench;

use Bench\Exceptions\TimeZoneAbbreviationNotFound;
use Carbon\Carbon;
use DateTimeZone;

class TimeZone 
{
	//@var object - Carbon|null
	protected $carbon;

	//@var string
	protected $shortAbbr;

	//@var string
	protected $longAbbr;

	/**
	* get offset for instance.
	*
	* @param string $type - human|hours
	*
	* @return string
	*/
	public function getOffset($type='human')
	{
		if($type == 'human') {
			return self::createHumanOffset($this->carbon);
		} elseif($type == 'hours') {
			return $this->carbon->offsetHours;
		}
		return $this->carbon->getOffSet();
	}

	/**
	* gettter
	*
	* @return string
	*/
	public function getName() 
	{
		return $this->carbon->timezone->getName();
	}

	/**
	* settter
	*
	* @param Carbon\Carbon $carbon
	*
	* @return $this;
	*/
	public function setCarbon(Carbon $carbon)
	{
		$this->carbon = $carbon;

		return $this;
	}

	/**
	* gettter
	*
	* @return Carbon\Carbon
	*/
	public function getCarbon() 
	{
		return $this->carbon;
	}

	/**
	* settter
	*
	* @param string $newData
	*
	* @return $this;	
	*/
	public function setShortAbbr($newData) 
	{
		$this->shortAbbr = $newData;

		return $this;
	}


	/**
	* gettter
	*
	* @return string
	*/
	public function getShortAbbr() 
	{
		return $this->shortAbbr;
	}

	/**
	* settter
	*
	* @param string $newData
	*
	* @return $this;	
	*/
	public function setLongAbbr($newData)
	{
		$this->longAbbr = $newData;

		return $this;
	}

	/**
	* gettter
	*
	* @return string
	*/
	public function getLongAbbr()
	{
		return $this->longAbbr;
	}

	/**
	* gettter
	*
	* @return string - (GMT -07:00) Pacific Daylight Time
	*/
	public function getLongAbbrWithGMTOffset() 
	{
		return sprintf("(GMT %s) %s", self::createHumanOffset($this->carbon), $this->getLongAbbr());
	}


	/**
	* make a new instance.
	*
	* @param Carbon\Carbon $carbon
	*
	* @return Bench\TimeZone
	*/
	public static function make(Carbon $carbon)
	{
		//contains the full abbreviation for all time zones.
		$abbreviation_array = require __DIR__ . '/abbreviation_array.php';

	    //EST, CST
	    //well for some time zones, PHP returns the offset (hours) as the abbrivation.
	    //for this instance abbreviation_array will hold the timezone name as the index.
	    $shortAbbr = $carbon->format('T');

	    //now we need to get our long abbr.
	    //first try using just the short abbr
	    //if that does not work out then combine the short abbr with the offset using a '_'
	    $short_offset_key = $shortAbbr."_".$carbon->offsetHours; //just in case we need it.

	    if(array_key_exists($shortAbbr, $abbreviation_array)) {

	    	$fullAbbr = $abbreviation_array[$shortAbbr]['Name'];

	    } elseif(array_key_exists($short_offset_key, $abbreviation_array)) {

	    	$fullAbbr = $abbreviation_array[$short_offset_key]['Name'];

	    } else {

	    	if(array_key_exists($carbon->timezone->getName(), $abbreviation_array)) {

	    		$shortAbbr = $abbreviation_array[$carbon->timezone->getName()]['Abbr'];
	    		$fullAbbr = $abbreviation_array[$carbon->timezone->getName()]['Name'];

	    	} else {

		    	throw new TimeZoneAbbreviationNotFound(
		    		sprintf("Could not find full time zone abbreviation for timezone: '%s'. We tried: '%s', '%s'",
		    				$carbon->timezone->getName(),
		    				$shortAbbr, 
		    				$short_offset_key
		    		)
		    	);
		    }
	    }

	   $tz = new static;
	   return $tz->setShortAbbr($shortAbbr)
	    ->setLongAbbr($fullAbbr)
	    ->setCarbon($carbon);
	}

	/**
	* get all time zones. but only for the countries that we support.
	*
	* @param string $time
	* @param bool $unqiueOffsetPerCountry
	*
	* @return array
	*/
	public static function all($time, $unqiueOffsetPerCountry) 
	{
		return self::createObjects(DateTimeZone::listIdentifiers(), $time, $unqiueOffsetPerCountry);
	}

	/**
	* get all time zones by country code
	*
	* @param string $countryCode - A two-letter ISO 3166-1 compatible country code.
	* @param string $time
	* @param bool $unqiueOffsetPerCountry
	*
	* @return array
	*/
	public static function getByCountryCode($countryCode, $time, $unqiueOffsetPerCountry) 
	{
		return self::createObjects(DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $countryCode), $time, $unqiueOffsetPerCountry, $countryCode);
	}

	/**
	* create objects from strings
	*
	* @param array $timezones - containg the strings
	* @param string $time - the time to use to start our DateTime instance.
	* @param $unqiueOffsetPerCountry
	* @oaran string $countryCode - if this is set; we dont have to check if the country is valid when checking to see if its supported or not.
	*
	* @return array
	*/
	protected static function createObjects(array $timezones, $time, $unqiueOffsetPerCountry, $countryCode=null) 
	{
		//create DateTimeZone objects for every time zone we got.
		//we need to get the location for each one incase they want unqiue offsets per country.
		$timezones = self::createDateTimeZones($timezones, $countryCode);


		//what we return.
		$return = [];

		//holder in case $unqiueOffsetPerCountry is true.
		$used = [];

		foreach($timezones as $dtz) {

			//create our date time. need this first so we can get the offset for the correct date.
			$carbon = new Carbon($time, $dtz);
		    
		    //now do they want unqiue offsets per country ?
		    //a unqiue offset per country.
			$cc = $dtz->getLocation()['country_code'];

			//make sure we got a index for this country code.
			if(!array_key_exists($cc, $used)) {

				$used[$cc] = [];
			}

		    if($unqiueOffsetPerCountry && in_array($dtz->getOffset($carbon), $used[$cc])) {
	    		continue;
		    }
		    //push to used array
		    array_push($used[$cc], $dtz->getOffset($carbon));

			$return[] = self::make($carbon);

		}
		return $return;
	}

	/**
	* loop through and build DateTimeZone objects. only load the time zones that have countries that we support.
	*
	* @param array $timezones - containing valid time zone strings.
	* @param string $countryCode - the country code that is being used. if set we dont check if the country is supported.
	*
	* @return array
	*/
	protected static function createDateTimeZones(array $timezones, $countryCode=null) 
	{
		$return = [];
		foreach($timezones as $tz) {

			$dt = new DateTimeZone($tz);
			if(is_null($countryCode)) {
				if(static::isTimeZoneSupported($dt)) {
					$return[] = $dt;
				}
			} else {
				//pass every time.
				$return[] = $dt;
			}

		}
		return $return;
	}

	/*
	*
	*/
	protected static function isTimeZoneSupported(DateTimeZone $dt) 
	{
		$location = $dt->getLocation();

		if(array_key_exists('country_code', $location) && Bench::getCountries($location['country_code']) instanceof Country) {

			return true;
		}

		return false;
	}

	/**
	* create a nicely formatted human friendly offset: -9:00
	*
	* @param Carbon\Carbon $dateTime
	*
	* @return float
	*/
	protected static function createHumanOffset(Carbon $dateTime) 
	{
	    $offsetSeconds = $dateTime->getOffset();

	    //divide by 3600 because there are 3600 seconds in 1 hour.
		$offsetHours = $dateTime->getOffset() / 3600;

		//basically is there any seconds left over after we get the full offset in hours.
		//helps us to get the any left minutes.
		$remainder = $dateTime->getOffset() % 3600;

		//now get make it pretty.
		$offsetHours = (int) abs($offsetHours);

		//60 seconds in 1 minute.
		$offsetMinutes = (int) abs($remainder / 60);

		$offsetSign = ($offsetSeconds > 0) ? '+' : '-';		
	
		return $offsetSign.str_pad($offsetHours, 2, '0', STR_PAD_LEFT).':'.str_pad($offsetMinutes,2, '0');

	}

	/**
	* @return string
	*/
	public function __toString() 
	{
		return $this->getLongAbbrWithGMTOffset();
	}

}