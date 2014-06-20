<?php

define('PLUGIN_EXT', '.zip');

class AppManager
{
	public $app, $plugins;

	private static $plugins_files =
	[
		'Application/',
		'Application/Controllers/',
		'Application/Models/',
		'Application/Views/',
		'Config/'
	];

	public static function setConfig($config)
	{
		//Make config if not exists
	}

	public static function loadPlugin($plugin)
	{
		if(file_exists(PLUGINS.DS.$plugin.PLUGIN_EXT))
		{
			if(file_exists(CONTROLLERS.DS.$plugin.'Controller.php'))
				exit('Plugin <strong>'.$plugin.PLUGIN_EXT.'</strong> already exists');

			$count = 0;
			$zip   = new ZipArchive;
			$zip->open(PLUGINS.DS.$plugin.PLUGIN_EXT);

			for($i = 0; $i < $zip->numFiles; $i++)
				if(in_array($zip->statIndex($i)['name'], self::$plugins_files))
					$count++;


			if(count(self::$plugins_files) == $count)
			{
				$zip->extractTo(ROOT);
				exit('Plugin <strong>'.$plugin.PLUGIN_EXT.'</strong> loaded');
			}
			else
				exit('Missing required file for import plugin.');
		}
		else
			exit('Plugin <strong>'.$plugin.PLUGIN_EXT.'</strong> doesn\'t exists');
	}

	private function make($type)
	{
		switch ($type)
		{
			case 'Extension':
				#Load Models, Controllers & view Package.
			break;
		}
	}

	private function compile($app)
	{

	}
}

?>