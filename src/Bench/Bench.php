<?php

namespace Bench;

use Bench\CountryCode;
use Bench\Country;
use Bench\Exceptions\InvalidCountryCodeException;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;

class Bench 
{


	/**
	* create a new TimeZone instance
	*
	* @param string $time
	* @param string|DateTimeZone $timeZoneName
	*
	* @return object Bench\TimeZone
	*/
	public static function createTimeZone(string $time, $timeZoneName) 
	{
		return TimeZone::make(Carbon::parse($timeToUse, $timeZoneName));
	}

	/**
	* get all countries
	*
	* @param string $countryCode - get a specific country.
	*
	* @return array|Bench\Country
	*/
	public static function getCountries(string $countryCode=null) 
	{
		return CountryCode::get($countryCode);
	}

	/**
	* get the time zones
	*
	* @param string $countryCode - A two-letter ISO 3166-1 compatible country code.
	* @param string $time - a valid time string to create date time instance.
	* @param boolean $unqiueOffsetPerCountry - do you want unqiue offsets per country ? no duplicates.
	*
	* @return array
	*/
	public static function getTimezones(string $countryCode=null, string $time="now", bool $unqiueOffsetPerCountry=false)
	{
		if(strlen($countryCode) > 0) {

			if(static::getCountries($countryCode) instanceof Country) {
				return TimeZone::getByCountryCode($countryCode, $time, $unqiueOffsetPerCountry);
			}

			throw new InvalidCountryCodeException(sprintf("Country Code: '%s' not known.", $countryCode));
			

		}

		return TimeZone::all($time, $unqiueOffsetPerCountry);

	}

}