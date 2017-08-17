<?php

namespace Bench;

use Bench\Bench;

class Country 
{

	//@var string - A two-letter ISO 3166-1 compatible country code.
	protected $code;

	//@var string - the full country name.
	protected $name;

	//@var array
	protected $timeZones = [];


	/**
	* gettter
	*
	* @return string
	*/
	public function getCode() 
	{
		return $this->code;
	}

	/**
	* gettter
	*
	* @return string
	*/
	public function getName() 
	{
		return $this->name;
	}

	/**
	* get time zones - lazy loaded.
	*
	* @param string $time - the time to start the DateTime instances.
	* @param boolean $unqiueOffsets - do you want unqiue offsets ?
	*
	* @return array
	*/
	public function getTimezones($time='now', $unqiueOffsets=false)
	{
		if(!count($this->timeZones)) {
			$this->timeZones = Bench::getTimezones($this->code, $time, $unqiueOffsets);
		}
		return $this->timeZones;
	}

	/**
	* new instance.
	*
	* @param string $code
	* @param string $name
	*/
	public function __construct(string $code, $name)
	{
		$this->code = $code;
		$this->name = $name;
	}



}