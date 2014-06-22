<?php

class HomeController extends AppController
{
	public function index()
	{		
		$this->setLayout('default');
		$this->render();
	}
}

?>