<?php

class HomeController extends AppController
{
	public function index()
	{		
		$this->setLayout('feed');
		$this->render();
	}
}

?>