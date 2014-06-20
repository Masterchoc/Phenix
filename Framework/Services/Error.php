<?php

class Error
{
	public static function fatal($message)
	{ echo 'Fatal Error: '.$message; exit;}

	public static function debug($var)
	{
		echo '<pre><code data-language="php">';
		print_r($var);
		echo'</code></pre>';
	}
}