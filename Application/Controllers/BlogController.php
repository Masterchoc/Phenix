<?php

class BlogController extends AppController
{
	public function index()
	{
		$articles = $this->Blog->getAll();

		$this->set('pages',      $articles['pages']);
		$this->set('featured',   $articles['featured']);
		$this->set('articles',   $articles['result']);
		$this->set('categories', $articles['categories']);

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