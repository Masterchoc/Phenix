<?php

class Router
{
	public static $request, $routes;

	public static function loadRoute($request)
	{
		self::$request = $request;
		self::$routes = yaml_parse_file(CONFIG.DS.'Routes.yml');


			if(!empty(self::$request->query_string))
    			self::$request->request_uri = str_replace('?'.self::$request->query_string, '', self::$request->request_uri);

		foreach(self::$routes as &$route)
		{
			$route['url'] = preg_replace('`\:([a-zA-Z0-9_]+)`', '(?P<$1>.+)', $route['url']);
			$route['url'] = '`^'.$route['url'].'$`';
		}

		return self::parse();
	}

	private function parse()
	{
		$vars = [];
		foreach(self::$routes as $route)
		{
			if(preg_match($route['url'], self::$request->request_uri, $vars))
			{
				foreach($vars as $k => $v)
					if(is_numeric($k))
						unset($vars[$k]);

				$r = new Object();

				$r->url      = $route['url'];
				$r->method   = $route['method'];
				$r->callback = $route['callback'];
				$r->params   = $r->convert($vars);

				return $r;
			}
		}
	}

	public static function redirect($url, $status = 302, $https = false)
	{	
		if($https == true)
			$location = 'https://'.self::$request->http_host.$url;
		else
			$location = 'http://'.self::$request->http_host.$url;

		header('Location: '.$location, TRUE, $status);
		exit;
	}

	public static function cleanRoute($route)
	{
		$route = str_replace('`', '', $route);
		$route = str_replace('^', '', $route);
		$route = str_replace('$', '', $route);
		return $route;
	}
}