<?php
class Template
{
	public $index;

	function displayVar($name, $filter = null, $param = null)
	{

		if(isset($this->data[$name]))
		{
			 trim($this->data[$name]);

			if($filter == 'raw')
				echo $this->data[$name];
			elseif(!is_null($filter))
				echo $this->_filter($this->data[$name], $filter, $param);
			else
				echo htmlspecialchars($this->data[$name]);
		}
		else
			echo '{'.$name.'}';
	}


	function wrap($element)
	{

		$this->stack[] = $this->data;

		foreach ($element as $k => $v)
		{
			if(is_array($v))
				exit('array detected');

			$this->data[$k] = $v;
		}
	}

	function unwrap()
	{ $this->data = array_pop($this->stack); }

	function run()
	{
		ob_start();
		eval(func_get_arg(0));
		return ob_get_clean();
	}

	function mapMethod($method)
	{

		if(preg_match('`\"`', $method))
		{
			$parts = array_filter(explode('"', $method));
			$args  = array_filter(explode(' ', $parts[0]));

			return Html::$args[0]($args[1], $parts[1]);
		}
		else
		{ 
			$args = explode(' ', $method);

			if(count($args) == 2)
				return Html::$args[0]($args[1]);
			elseif(count($args) == 3)
			{
				if(preg_match('`\$`', $args[2]))
				{ 
					$var = str_replace('$', '', $args[2]);

					if($this->data[$var])
						$args[2] = $this->data[$var];

					return Html::$args[0]($args[1], $args[2]);
				}
				else
					return Html::$args[0]($args[1], $args[2]);
			}
		}
	}

	function process($template, $data)
	{
		$this->data = $data;
		$this->stack = array();

		$template = preg_replace('/\{\@([\w\.\/\-\!\"\$ ]+)\}/siu', '<?php echo $this->mapMethod(\'$1\'); ?>', $template);
		$template = preg_replace('/\{(\w+)\}/', '<?php $this->displayVar(\'$1\'); ?>', $template);
		$template = preg_replace('/\{(\w+)\|(\w+)\}/', '<?php $this->displayVar(\'$1\', \'$2\'); ?>', $template);
		$template = preg_replace('/\{(\w+)\|(\w+)\s(\w+)}/', '<?php $this->displayVar(\'$1\', \'$2\', \'$3\'); ?>',
			$template);
		$template = preg_replace('~\{FOR:(\w+)\}~', '<?php foreach($this->data[\'$1\'] as $ELEMENT): $this->wrap($ELEMENT); ?>', $template);

		/*print_r($template);
		exit;*/
		$template = preg_replace('~\{END:}~', '<?php $this->unwrap(); endforeach; ?>', $template);
		$template = preg_replace('/\{IF:(.+?)\}/i', '<?php if($1){ ?>', $template);
		$template = str_replace('{ENDIF:}', '<?php } ?>', $template);
		$template = str_replace('{ELSE:}', '<?php } else { ?>', $template);
		$template = '?>' . $template;
		return $this->run($template);
	}

	public function _filter($str, $filter, $param = null)
	{
		if(!empty($str) && !empty($filter))
		{
			switch($filter)
			{
				case 'capitalize': return strtoupper($str);
				break;

				case 'ucfirst': return ucfirst($str);
				break;

				case 'lower': return strtolower($str);
				break;

				case 'clean': return mysql_real_escape_string($str);
				break;

				case 'count_char': return count(str_split($str));
				break;

				case 'count': return count($str);
				break;

				case 'date_format': return $this->date_format($str, $param);
				break;

				case 'AffDate': return $this->AffDate($str);
				break;

				case 'nl2br': return nl2br($str);
				break;

				case 'cut': return $this->cutString($str, $param);
				break;

				case 'indent': return $this->indent($str, $param);
				break;

				case 'md5': return md5($str);
				break;

				case 'debug': return var_dump($str);
				break;

				case 'slugify': return $this->slugify($str);
				break;

				default: return $str;
				break;
			}
		}
	}
	 public function slugify($text)
	{
			$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
			$text = trim($text, '-');
			$text = $this->withoutAccents($text);
			$text = strtolower($text);
			$text = preg_replace('~[^-\w]+~', '', $text);

			if(empty($text))
				return 'n-a';

			return $text;
	}

	public function indent($str, $param)
	{
		$sym = '&nbsp;';

		for($i = 0; $i < $param; $i++)
			$sym .= $sym;

		return $sym.$str;
	}

	public function cutString($str, $param)
	{
		if(strlen($str) <= $param)
			return $str;
		else
		  return substr($str, 0, $param).'...';
	}

	public function AffDate($Time)
	{
		$date = new DateTime($Time);
		$Time = $date->getTimestamp();

		$t = time() - $Time;
		if($t < 0)
			return;
		$Seconds = $t;
		$Minutes = round($t / 60);
		$Hours 	 = round($t / 3600);
		$Days    = round($t / 86400);
		$Weeks 	 = round($t / 604800);
		$Months  = round($t / 2419200);
		$Years   = round($t / 29030400);

		if( $Seconds==0 )
			return 'Maintenant';
		elseif($Seconds < 60)
			return 'il y a '.$Seconds.' seconde'.($Seconds>1 ? 's' : '');
		elseif($Minutes < 60)
			return 'il y a '.$Minutes.' minute'.($Minutes>1 ? 's' : '');
		elseif($Hours < 24)
			return 'il y a '.$Hours.' heure'.($Hours>1 ? 's' : '');
		elseif($Days == 1)
			return 'Hier';
		elseif($Days < 7)
			return 'il y a '.$Days.' jour'.($Days>1 ? 's' : '');
		elseif($Weeks < 4)
			return 'il y a '.$Weeks.' semaine'.($Weeks>1 ? 's' : '');
		elseif($Months < 12)
			return 'il y a '.$Months.' mois';
		elseif($Years > 1)
			return 'il y a '.$Years.' an'.($Years>1 ? 's' : '');
	}


public function date_format($date, $full = false)
{

	date_default_timezone_set('Europe/Paris');

	$listMonths = array
		(
			'01' => 'janvier',
			'02' => 'février',
			'03' => 'mars',
			'04' => 'avril',
			'05' => 'mai',
			'06' => 'juin',
			'07' => 'juillet',
			'08' => 'août',
			'09' => 'Septembre',
			'10' => 'octobre',
			'11' => 'novembre',
			'12' => 'décembre'
		 );

		$listDays = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");

		$items = explode(' ', $date);

		$a = $items[0];
		$b = $items[1];

		$days = explode('-', $a);

		$y = $days[0];
		$m = $days[1];
		$d = $days[2];

		$hours = explode(':', $b);

		$h = $hours[0];
		$mi = $hours[1];
		$s = $hours[2];


		$timestamp = mktime(0, 0, 0, $m, $d, $y);

		$wd = date("w", $timestamp);

		$strDay = $listDays[$wd];

		if(date('d') == $d && date('m') == $m && date('Y') == $y)
			return 'à '.(int) $h.':'.$mi;
		elseif(((int)date('d')) == (int)$d && date('m') == $m && date('Y') == $y)
			return 'hier à '. (int)$h.':'.$mi;
		elseif(date('Y') == $y && date('m') == $m && (int)date('d') !== $d)
			return $strDay.' '.(int) $d.' '.$listMonths[$m];
		elseif($full == true)
			return (int) $d.' '.$listMonths[$m].' '.$y;
		else
			return $strDay.' '.(int) $d.' '.$listMonths[$m];
}



}
?>
