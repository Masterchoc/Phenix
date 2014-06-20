<?php

class Form
{
	public static
		$output,
		$attributes,
		$parameters =
		[
			'form' =>
			[ 
				'method'      => 'POST',
				'action'      => '#',
				'row'         => '<div class="row collapse">',
				'labelColumn' => '<div class="small-3 large-2 columns">',
				'label'       => '<span class="prefix">',
				'inputColumn' => '<div class="small-9 large-10 columns">',
				'endiv'       => '</div>',
				'endspan'     => '</span>'
			],
			'input'=>
			[ 
				'needclose' => ['textarea', 'select'],
				'close' => '',
				'start' => ''
			],
			'tags' =>
			[
				'open'  => '<',
				'close' => '>'
			]		
		];

	public static function open($attrs = null)
	{
		$tool = new Object();
		self::$parameters = $tool->convert(self::$parameters);

		if(empty($attrs['method']))
			$attrs['method'] = self::$parameters->form->method;
		if(empty($attrs['action']))
			$attrs['action'] = self::$parameters->form->action;

		$args = self::extractArgs('form', $attrs);

		self::$output .=
		self::$parameters->tags->open.'form'.$args.
		self::$parameters->tags->close;
	}

	public static function input($label, $attrs, $error = null)
	{
		$args = self::extractArgs('input', $attrs);
		$args = $args.
			(!empty(self::$parameters->input->close)
			? self::$parameters->input->close
			: '/'.self::$parameters->tags->close);

		self::$output .= 
		$attrs['type'] == 'submit'
		?
			self::$parameters->form->row.
			$args.
			self::$parameters->form->endiv
		:
			self::$parameters->form->row.
			self::$parameters->form->labelColumn.
			self::$parameters->form->label.$label.
			self::$parameters->form->endspan.
			self::$parameters->form->endiv.

			self::$parameters->form->inputColumn.$args.
			self::$parameters->form->endiv.

			self::$parameters->form->endiv;
	}

	private function extractArgs($type, $args)
	{
		$tool = new Object();
		$args = $tool->convert($args);

		if($type == 'input')
		{ 
			if(in_array($args->type, self::$parameters->input->needclose))
			{
				self::$parameters->input->close =
				self::$parameters->tags->close.
				self::$parameters->tags->open.'/'.$args->type.
				self::$parameters->tags->close;
			}
			else
				self::$parameters->input->close = '/'.self::$parameters->tags->close;

			$tag = (self::$parameters->input->close != '/'.self::$parameters->tags->close)
			? self::$parameters->tags->open.$args->type.' '
			: self::$parameters->tags->open.$type; 
		}
		else
			$tag = '';

		$out = '';
		foreach($args as $k => $v)
			$out .= ' '.$k.'="'.$v.'"';

		return $tag.$out;
	}

	public static function output()
	{
		return
			self::$output.
			self::$parameters->tags->open.'/form'.
			self::$parameters->tags->close;
	}
}
?>