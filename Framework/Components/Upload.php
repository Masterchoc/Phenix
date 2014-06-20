<?php

class Upload
{
	private static 
		$dir,
		$queue,
		$callback;

	public static function process($data)
	{
		$files = [];

		if(count($data->upload->name) > 1)
		{ 
			$i = 0;
			foreach($data->upload as $k => $v)
			{ 
				$files[$i]['name']     = $data->upload->name[$i];
				$files[$i]['tmp_name'] = $data->upload->tmp_name[$i];
				$files[$i]['type']     = $data->upload->type[$i];
				$files[$i]['error']    = $data->upload->error[$i];
				$i++;
			}
		}
		else
		{
			foreach($data->upload as $k => $v)
			{
				$files[0]['name']     = $data->upload->name[0];
				$files[0]['tmp_name'] = $data->upload->tmp_name[0];
				$files[0]['type']     = $data->upload->type[0];
				$files[0]['error']    = $data->upload->error[0];				
			}
		}

		self::$queue = $files;


		print_r(self::$queue);
	}

	private function actions()  {}
	private function getFileType() {}

	private function save($file)
	{

	}
}

?>