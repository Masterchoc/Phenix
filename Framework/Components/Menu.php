<?php

Class Menu extends AppModel
{
	private $main, $sub;

	public function __construct()
	{
		$this->main = SQL::query('SELECT id, name, linkpath, sublinks FROM menus;')->fetchAll();
	}

	public function get($section_class = null, $ul_class = null)
	{
		$items = [];

		foreach($this->main as $row)
		{
			$path = $row->linkpath;
			$link = $this->link($row->name, $path === 'NULL' ? NULL : $path);

			if($row->sublinks > 0) $link = $this->submenu($row->id);
			$items[] = $link;
		}

		return '<section '.(!is_null($section_class) ? 'class="'.$section_class.'"' : '').'>'.$this->lists(array_filter($items), $ul_class).'</section>';
	}

	public function submenu($id)
	{

		$submenu = SQL::query('SELECT id, parent_id, name, linkpath FROM sub_menus WHERE parent_id = '.abs((int)$id))->fetchAll();

		$sub = [];

		foreach($submenu as $row)
			$sub[] = $this->link($row->name, $row->linkpath);

		return $this->lists(array_filter($sub));
	}

	private function link($content, $href)
	{
		return '<a '.($href != 'NULL' ? 'href="'.$href.'"' : '').' title="'.$content.'">'.$content.'</a>';
	}

	private function lists(array $items, $class = null)
	{
		if(!$items) return null;
		return '<ul '.(!is_null($class) ? 'class="'.$class.'"' : '').'><li>'.implode("</li>\r\n<li>", $items).'</li></ul>';
	}
}

?>