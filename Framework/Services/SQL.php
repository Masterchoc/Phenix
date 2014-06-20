<?php

class SQL extends PDO
{
	public static $config, $connection, $nbQueries = 0;

	public static function init()
	{
		if(empty(Config::$default['host'])
		|| empty(Config::$default['user'])
		|| empty(Config::$default['password'])
		|| empty(Config::$default['database']))
			Error::fatal('Missing sql credentials');

		self::$config = new Object();

		foreach(Config::$default as $k => $v)
				self::$config->$k = $v;

		return self::connect();
	}

	private function connect()
	{
		try
		{ 
			return self::$connection =
			new PDO
			(
				'mysql:host='.self::$config->host.';
				dbname='.self::$config->database,
				self::$config->user,
				self::$config->password,
				[
					PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
				]
			);
		}
		catch(Exception $e)
		{ Error::fatal($e->getMessage()); }
	}

	public function query($q)
	{
		self::$nbQueries++;
		return self::$connection->query($q);
	}
}

?>