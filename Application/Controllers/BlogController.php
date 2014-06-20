<?php

class BlogController extends AppController
{
	public function index()
	{
		$this->query->join     = ['blog_categories'];
		$this->query->order    = 'date.DESC';
		$this->query->paginate = ['model'=>'/blog?page=*', 'perPage'=>1];

		$articles = $this->Blog->find($this->query);

		$this->set('articles', $articles['result']);
		$this->set('pages',    $articles['pages']);

		$this->render();
	}

	public function article()
	{
		$article = $this->Blog->findFirst(['slug' => $this->params->slug]);
		$this->set('article', $article);
		$this->render();
	}
}