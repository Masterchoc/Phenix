<?php

class BlogController extends AppController
{
	public function index()
	{
		$articles = $this->Blog->getAll();

		$this->set('articles', $articles['result']);
		$this->set('pages',    $articles['pages']);
		$this->setLayout('blog');
		
		$this->render();
	}

	public function article()
	{
		$article = $this->Blog->findFirst(['slug' => $this->params->slug]);
		$this->set('article', $article);
		$this->render();
	}
}