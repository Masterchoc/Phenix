<?php

class ManagerController extends AppController
{
	public function dashboard()
	{
		$this->setLayout('manager');
		$this->render();
	}

	public function builder()
	{
		$this->setLayout('manager');
		$this->render();
	}
}

?>