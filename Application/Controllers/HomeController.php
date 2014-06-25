<?php

class HomeController extends AppController
{
	public function index()
	{		
		$this->setLayout('workspace');
		$this->render();
	}
}

?>