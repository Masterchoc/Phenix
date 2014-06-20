<?php

class HomeController extends AppController
{
	public function index()
	{		
		$cache = new Cache(CACHE, 0);

		if(!$cache->read('form_connexion'))
		{ 
			Form::open(['name' => 'upload', 'enctype'=>'multipart/form-data']);
			Form::input(
			'Nom d\'utilisateur',
			[
				'name'=>'username',
				'type'=>'text'
			]);	Form::input(
			'Nom d\'utilisateur',
			[
				'name'=>'username',
				'type'=>'text'
			]);
			Form::input(
			'Confirmation',
			[
				'name' =>'confirm',
				'type' =>'submit',
				'class'=>'button'
			]);
			$form = Form::output();
			$cache->write('form_connexion', $form);
		}
		else
			$form = $cache->read('form_connexion');

		$this->set('form', $form);
		$this->render();
	}
}

?>