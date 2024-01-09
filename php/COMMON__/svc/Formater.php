<?php

namespace COMMON__\svc;

abstract class Formater
{
	
	private static function floatStringTo ($val, $trim, $decimals, $decimal_separator, $thousand_separator)
	{
		if(!isset($val))
		{
			return "";
		}
		
		$res = number_format(floatval($val), $decimals, $decimal_separator, $thousand_separator);
		if($trim === true)
		{
			$res = rtrim(rtrim($res, '0'), $decimal_separator);
		}
		return $res;
	}
	
	public static function floatStringToDisplay ($val, $trim=true)
	{
		return static::floatStringTo ($val, $trim, 2, ",", " ");
	}
	
	public static function floatStringToPriceDisplay ($val)
	{
		$res = static::floatStringToDisplay ($val, false);
		if(!empty($res))
			$res .= " €";
		return $res;
	}
	
	public static function floatStringToValue ($val)
	{
		return static::floatStringTo ($val, true, 5, ".", "");
	}
	
	
	const TIME_FORMAT = "H:i:s";
	const SQL_DATE_FORMAT = "Y-m-d";
	const DISPLAY_DATE_FORMAT = "d/m/Y";
	const SQL_DATETIME_FORMAT = self::SQL_DATE_FORMAT . " " . self::TIME_FORMAT;
	const DISPLAY_DATETIME_FORMAT = self::DISPLAY_DATE_FORMAT . " " . self::TIME_FORMAT;
	
	public static function sqlDateStringToDisplay ($val)
	{
		if(!isset($val))
		{
			return "";
		}
		$d = \DateTime::createFromFormat(self::SQL_DATETIME_FORMAT, $val);
		return $d->format(self::DISPLAY_DATETIME_FORMAT);
	}
	
	
	public static function durationSecondsToDisplay ($seconds)
	{
		$tz = new \DateTimeZone("gmt");
		if($seconds !== null)
		{
			$dt = \DateTime::createFromFormat("U", $seconds ?? 0, $tz);
			$res = $dt->format(Formater::TIME_FORMAT);
		}
		else
		{
			$res = null;
		}
		return $res;
	}
	
	public static function durationDisplayToSeconds ($display)
	{
		if(\preg_match("|^(\d{2}):(\d{2})$|", $display)) // lacks seconds in input (chrome bug)
			$display .= ":00";
			$tz = new \DateTimeZone("gmt");
			$dt = \DateTime::createFromFormat(Formater::SQL_DATETIME_FORMAT, "1970-01-01 $display", $tz);
			$res = $dt->format("U");
			return $res;
	}
	
}
