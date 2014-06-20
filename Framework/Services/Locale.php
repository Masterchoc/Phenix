<?php

class Locale
{
	public static
		$lang     = 'fr_FR.utf8',
		$filename = 'default';

	public static function init()
	{
		putenv('LC_ALL = '.$this->lang);
		setlocale(LC_ALL, $lang);
		bindtextdomain($filename, './locale');
		bind_textdomain_codeset($filename, "UTF-8");
		textdomain($filename);
	}

	public function translate($str)
	{

	}
}

?>