<?php

class Utils
{
	public static function get_args_names($function)
	{
		$rc   = new ReflectionClass($function);
		$ctor = $rc->getConstructor();

		$r = [];
		foreach($ctor->getParameters() as $rp)
			$r[] = $rp->getName();

		return $r;
	}
}

?>