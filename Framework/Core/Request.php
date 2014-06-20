<?php

class Request
{
	public 
		$route,
		$headers,
		$hooks = [],
		$request,
		$response;

	//////////////////////////////////////////////////////////
	// 
	// Contruct the class, init headers and create gateway.
	// 
	//////////////////////////////////////////////////////////

	public function __construct()
	{
		Stats::start();
		$this->headers  = $this->getHeaders();
		$this->request  = $this->createGateway();
	}

	//////////////////////////////////////////////////////////
	// 
	// Create a new gateway, parsing the route and dispatch it.
	// 
	// Parse new route with static method loadRoute;
	// Execute request and extract parameters with Dispatcher class
	// 
	//////////////////////////////////////////////////////////

	private function createGateway()
	{
		$this->route = Router::loadRoute($this);
		$dispatcher  = new Dispatcher();
		$dispatcher->init($this->route);
	}

	//////////////////////////////////////////////////////////
	// 
	// Extract headers informations and format them.
	// 
	// No parameters needed, just $_SERVER var not empty
	// 
	//////////////////////////////////////////////////////////

	private function getHeaders()
	{
		if(!empty($_SERVER))
			foreach($_SERVER as $i => $v)
				if(!empty($i) && !empty($v) && $i = strtolower($i))
					$this->$i = $v;
	}
}
