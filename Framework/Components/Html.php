<?php

class Html
{
 	protected static $doctypes =
 	[
        '5'             => '<!DOCTYPE html>',
        'html'          => '<!DOCTYPE html>',
        'xml'           => '<?xml version="1.0" encoding="utf-8" ?>',
        'default'       => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
        'transitional'  => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
        'strict'        => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
        'frameset'      => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">',
        '1.1'           => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
        'basic'         => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">',
        'mobile'        => '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.2//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">'
    ];

	public static function paginate($actuel, $nbEntity, $linkModel, $nbEntityPerPage = 15)
	{
		if(!isset($actuel))
			$actuel = 1;
		$nbPage = ceil($nbEntity / $nbEntityPerPage);
		if($actuel > $nbPage) $actuel = $nbPage;
		if($actuel <= 0) $actuel = 1;

		$xhtml = ''; $i = 1;
		if($actuel > 1)
			$xhtml .= '<li><a href="'.str_replace('*', $actuel - 1, $linkModel).'">«</a></li>';
		while($i <= $nbPage)
		{
			if(($i < 5) || ($i > $nbPage - 5) || (($i < $actuel + 5) && ($i > $actuel - 5)))
			{
				if($i == $actuel)
					$xhtml .= ' <li class="current"><a href="#">'.$i.'</a></li>';
				else
					$xhtml .= '<li><a href="'.str_replace('*', $i, $linkModel).'">'.$i.'</a></li>';
			}
			else
			{
				$xhtml = substr($xhtml, 0, strlen($xhtml)-2);
				if($i >= 2 && $i <= $actuel - 2)
					$i = $actuel - 2;
				elseif($i >= $actuel + 2 && $i <= $nbPage - 2)
					$i = $nbPage - 2;
				$xhtml .= '<li><a href="#" onclick="var goToPage = prompt(\''.str_replace('%n', $nbPage, 'Aller à la page : ').'\', 1); if(goToPage != null && goToPage &gt;= 1 && goToPage &lt;= '.$nbPage.' && !isNaN(goToPage)) document.location.href = \''.str_replace('*', '\'+goToPage+\'', $linkModel).'\'; return false;">...</a></li>';
			}

			if($i == $nbPage)
				$xhtml = substr($xhtml, 0, strlen($xhtml)-2);
			$i++;
		}

		if($actuel < $nbPage)
			$xhtml .= '</li><li><a href="'.str_replace('*', $actuel + 1, $linkModel).'">»</a></li>';

		return array(
			'nbPage' => $nbPage,
			'actuel' => $actuel,
			'nbItems' => $nbEntity,
			'xhtml' => '<li><a href="#" onclick="var goToPage = prompt(\''.str_replace('%n', $nbPage, 'Aller à la page : ').'\', 1); if(goToPage != null && goToPage &gt;= 1 && goToPage &lt;= '.$nbPage.' && !isNaN(goToPage)) document.location.href = \''.str_replace('*', '\'+goToPage+\'', $linkModel).'\'; return false;">Pages</a></li> '.$xhtml,
			'limit' => $nbEntityPerPage.' OFFSET '.(($actuel - 1) * $nbEntityPerPage),
			'sub'  => array('end' => $nbEntityPerPage, 'start' => (($actuel - 1) * $nbEntityPerPage))
		);
	}


	public function doctype($doc)
	{
		if(isset(self::$doctypes[$doc]))
			return self::$doctypes[$doc]."\n";
	}

	public function brand($ul_class, $li_class)
	{
		if(!empty($ul_class) && !empty($li_class))
		{
			return $output =
			'<ul class="'.$ul_class.'">
				<li class="'.$li_class.'">
					<h1 '.(!empty(Config::$remote->appSubName) ? 'class="fix"' : '').'>
					<a href="/">'.Config::$remote->appName.'<br>'.Config::$remote->appSubName.'</a>
					</h1>
				</li>
			</ul>';
		}
	}

	public function menu($section_class, $ul_class)
	{
		$menu = new Menu();
		return $menu->get($section_class, $ul_class);
	}

	public static function title($title = null)
	{
		if(is_null($title))
			return '<title>'.Config::$remote->appName.'</title>';
		else
			return '<title>'.$title.'</title>';
	}

	public static function meta($name, $content = null)
	{
		if(is_null($content))
		{
			switch ($name)
			{
				case 'viewport':
					$out = '<meta name="'.$name.'" content="width=device-width, initial-scale=1.0">';
					break;
				
				case 'charset':
					$out = '<meta charset="utf-8">';
					break;
			}

			return $out."\n";
		}
		else
			return '<meta name="'.$name.'" content="'.$content.'">'."\n"; 
	}

	public static function css($href, $rel = null)
	{
		return '<link rel="'.(!is_null($rel) ? $rel : 'stylesheet').'" href="/css/'.$href.'">'."\n";
	}

	public static function script($href, $type = null)
	{
		return '<script type="'.(!is_null($type) ? $type : 'text/javascript').'" src="/js/'.$href.'"></script>'."\n";
	}
}
?>