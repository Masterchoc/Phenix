<?php

class Stats
{
	public static $startTime, $executionTime;

	public static function start()
	{
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];

		return self::$startTime = $time;
	}

	public static  function getExecutionTime($round = 0)
	{
		$mtime   = microtime();
		$mtime   = explode(' ',$mtime);
		$mtime   = $mtime[1] + $mtime[0];
		$endtime = $mtime;

		return
			self::$executionTime = 
			round($endtime - self::$startTime, $round);
	}

}