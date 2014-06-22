<?php

class Blog extends AppModel
{
	public function getAll()
	{
		$this->query = new Object;
		$this->query->join     = ['blog_categories'];
		$this->query->order    = 'date.DESC';
		$this->query->paginate = ['model'=>'/blog?page=*', 'perPage'=>1];
		return $this->find($this->query);
	}
}

?>