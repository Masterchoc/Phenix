<?php

class Config extends Dispatcher
{
	public static $default = 
	[
		'host'     => 'localhost',
		'user'     => 'root',
		'password' => 'laridja',
		'database' => 'phenix'
	];

	public static $remote;
	public static $app;

	public function loadRemote()
	{
		$config = SQL::query('SELECT * FROM config;')->fetchAll();
		$c = new Object();

		foreach($config as $k => $v)
			$c->{$v->keys} = $v->values;

		self::$remote = $c;
	}

	public function loadAppConfig()
	{
		$obj = new Object();
		$conf = yaml_parse_file(CONFIG.DS.'Parameters.yml');

		if($conf)
			self::$app = $obj->convert($conf);
	}
}
