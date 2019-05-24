<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if (function_exists('fileDelete') == false)
{
	function fileDelete($filePath)
	{
		if (file_exists($filePath) == true)
		{
			unlink($filePath);
		}
	}
}

if (function_exists('getTempFileName') == false)
{
	function getTempFileName($dir, $keyword)
	{
		$photoFileName = '';
		$dir = $_SERVER['DOCUMENT_ROOT'].ROOT_PREFIX.$dir;
		$dh = @opendir($dir);
		if ($dh)
		{
			while (($file = readdir($dh)) !== false)
			{
				if ($file == "." || $file == "..")
				{
					continue;
				}
				if (strpos($file, $keyword) !== false)
				{
					$photoFileName = $file;
					break;
				}
			}
			closedir($dh);
		}
		return $photoFileName;
	}
}

if (function_exists('getExtensionFromFilename') == false)
{
	function getExtensionFromFilename($fileName)
	{
		$list = explode(".", $fileName);
		if (count($list) > 1)
		{
			return ".".$list[count($list) - 1];
		}
		return '';
	}
}

if (function_exists('clearTempFiles') == false)
{
	function clearTempFiles($type)
	{
		if ($type == 'IMAGE')
		{
			$photoTempName = getTempFileName(IMAGE_DIR, IMAGE_TEMP);
			if ($photoTempName != '')
			{
				fileDelete($_SERVER['DOCUMENT_ROOT'].ROOT_PREFIX.IMAGE_DIR.$photoTempName);
			}
		}
	}
}

if (function_exists('mySubString') == false)
{
	function mySubString($orig, $len = SHOW_LYRIC_LENGTH)
	{
		if (strlen($orig) < $len)
		{
			return $orig;
		}
		return substr($orig, 0, $len) . " ...";
	}
}

if (function_exists('ReplaceSpace') == false)
{
	function ReplaceSpace($orig)
	{
		$array = explode(" ", $orig);
		$result = "";
		for ($i=0; $i<count($array); $i++)
		{
			$result .= $array[$i];
			if ($i < count($array) - 1)
			{
				$result .= "_";
			}
		}
		return $result;
	}
}

?>