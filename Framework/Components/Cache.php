<?php
class Cache
{
	public
		$dirname,
		$encryptKey,
		$config,
		$duration;

	public function __construct($dirname, $duration)
	{
		$this->dirname = $dirname;
		$this->duration = $duration;
	}

	public function write($filename, $content)
	{
		return file_put_contents($this->dirname.DS.md5($filename), serialize($content));
	}

	public function read($filename) 
	{
		$file = $this->dirname.DS.md5($filename);

		$lifetime = (time() - @filemtime($file)) / 60;

		if(!file_exists($file))
			return false;

		if($lifetime > $this->duration)
			return false;

		return unserialize(file_get_contents($file));
	}

	public function delete($filename)
	{
		$file = $this->dirname.DS.md5($filename);
		if(file_exists($file))
			unlink($file);
	}

	public function clear()
	{
		$files = glob($this->dirname.DS.'*');
		foreach($files as $file)
			unlink($file);
	}
}
