<?php

namespace Bench;

use Bench\CountryCode;
use Bench\Country;
use Bench\Exceptions\InvalidCountryCodeException;
use Carbon\Carbon;
use DateTimeZone;
use DateTime;
//use Husky as Collection;

class Bench
{
	//self.
	private static $instance;

	//Collection
	protected $cachedCountries = [];

	//they must use our static public methods.
	protected function __construct()
	{

	}

	/**
	* get the instance of Bench
	*
	* @return Bench
	*/
	protected static function getInstance()
	{
		if (!self::$instance instanceof \Bench\Bench) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	protected function setCachedCountries(array $countries)
	{
		$this->cachedCountries = $countries;
	}

	/*
	* get a country|collection from cached.
	*
	* @param $countryCode string|null
	*
	* @return Country|Collection
	*/
	protected function getCachedCountries($countryCode=null)
	{
		// if($this->cachedCountries->has($countryCode)) {
		// 	return $this->cachedCountries->get($countryCode);
		// }
		if(strlen($countryCode)) {
			foreach($this->cachedCountries as $country) {
				if($country->getCode() == $countryCode) {
					return $country;
				}
			}
		}
		return $this->cachedCountries;
	}


	/**
	* create a new TimeZone instance
	*
	* @param string $time
	* @param string|DateTimeZone $timeZoneName
	*
	* @return object Bench\TimeZone
	*/
	public static function createTimeZone($time, $timeZoneName) 
	{
		return TimeZone::make(Carbon::parse($time, $timeZoneName));
	}

	/**
	* get all countries
	*
	* @param string $countryCode - get a specific country.
	*
	* @return array|Bench\Country
	*/
	public static function getCountries($countryCode=null, $useCache=true) 
	{
		$instance = self::getInstance();

		if (!$useCache || !count($instance->getCachedCountries())) {
			// they dont want cache; so over-write our current cache.
			// or if our cache is empty.
			$instance->setCachedCountries($instance->loadCountries());
		}
		//now return cache.
		return $instance->getCachedCountries($countryCode);

	}

	/*
	* load countries.
	*
	* @return array
	*/
	protected static function loadCountries()
	{
		// return new Collection(CountryCode::get($countryCode), function($key, $value) {
		// 	return $key;
		// });
		return CountryCode::get();
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
	public static function getTimezones($countryCode=null, $time="now", $unqiueOffsetPerCountry=false)
	{
		if(strlen($countryCode) > 0) {

			if(self::getInstance()->getCountries($countryCode) instanceof Country) {
				return TimeZone::getByCountryCode($countryCode, $time, $unqiueOffsetPerCountry);
			}

			throw new InvalidCountryCodeException(sprintf("Country Code: '%s' not known.", $countryCode));
			

		}

		return TimeZone::all($time, $unqiueOffsetPerCountry);

	}

	/**
	* get all abbreviations.
	*
	* @return array
	*/
	public static function getAbbreviations()
	{
		//contains the full abbreviation for all time zones.
		$file =  __DIR__ . '/abbreviation_array.php';
		if(@file_exists($file)) {
			return include $file;
		}
		throw new \Exception("Can not find abbreviation array file.");
	}

}