<?php

class Blog extends AppModel
{
	public function getAll()
	{
		$this->query = new Object;
		$this->query->join     = ['blog_categories'];
		$this->query->order    = 'date.DESC';
		$this->query->paginate = ['model'=>'/blog?page=*', 'perPage'=> 15];

		$data       = $this->find($this->query);
		$categories = [];
		$featured = '';

		foreach($data['result'] as $k => $v)
		{
			if(!empty($v->parent_id))
				$categories[] = array('name' => $v->name);

			if(!empty($v->featured) && $v->featured == 1)
				$featured = [(array)$v];

			$categories = @array_unique($categories);
		}

		$data['featured']   = $featured;
		$data['categories'] = $categories;

		return $data;
	}
}

?>