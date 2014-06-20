<?php

class Object
{
	public function __construct()
	{ return new stdClass(); }

	public function convert($array)
	{ return json_decode(json_encode($array), false); }
}