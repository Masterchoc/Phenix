<?php

class Dispatcher
{
	public
		$db,
		$route,
		$controller,
		$action,
		$model,
		$hooks;

	public function init($route)
	{
		$this->route  = $route;
		$this->db     = SQL::init();
		
		Config::loadRemote();
		Config::loadAppConfig();

		$this->dispatch();
	}

	public function dispatch()
	{
		if($this->route == false)
			Error::fatal('La route n\'a pas été trouvée');
		else
		{ 
			list($this->controller, $this->action) = explode('.', $this->route->callback);
			$model = ucfirst($this->controller);
			$controller = $this->controller.'Controller';

			// $this->getHooks();

			$this->call($controller, $model, $this->action, $this->route->params, $this->route);
		}
	}

	public function call($controller, $model, $action, $params, $route)
	{
		if(class_exists($controller))
			$switch = new $controller($controller, $model, $action, $params, $this->route->url, $this->route->method);
		else
			Error::fatal($controller.' not found.');

		if((int)method_exists($switch, $action))
			return call_user_func_array(array($switch, $action), (array)$params);
		else
			Error::fatal('La méthode '.$action.' du controller '.$controller.' n\'existe pas');
	}

	public function getHooks()
	{
		$hooks = @yaml_parse_file(CONFIG.DS.'Hooks.yml');

		if($hooks)
		{ 
			foreach($hooks as $k => $v)
			{
				list($controller, $action) = explode('.', $v['callback']);
				$model = ucfirst($controller);
				$controller = $controller.'Controller';
				
				$ctrl = new $controller($controller, $model, $action, $v['params'], $this->route->url, $this->route->method);

				if(is_array($v['params']))
					foreach($v['params'] as $i => $val)
						$param = $val;

				if((int)method_exists($ctrl, $action))
					return call_user_func(array($ctrl, $action), $param);
			}
		}
	}
}

?>