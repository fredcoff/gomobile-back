<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (function_exists('elements_to_url') == false)
{
	function elements_to_url($items, $array)
	{
		$tags = elements($items, $array, '');
		$ret_url = '';
		
		foreach($tags as $key => $val)
		{
			if (empty($val) == false)
			{
				$ret_url .= "/{$key}/{$val}";
			}
		}
		
		return $ret_url;
	}
}

if (function_exists('elements_copy_urldecode') == false)
{
	function elements_copy_urldecode($src)
	{
		$dest = array();
		foreach($src as $key => $val)
		{
			if (empty($val) == false)
			{
				$dest[$key] = urldecode($val);
			}
		}
		
		return $dest;
	}
}

/**
 * get element value with default value
 * 
 * see also element helper function
 * difference is that 
 * 		if array contain empty value with key, element function return empty
 * 		but this function return $default
 * 
 * @author sasia
 * 
 */
if (function_exists('element_val') == false)
{
	function element_val($key, $array, $default)
	{
		$val = element($key, $array, $default);
		
		if ($val == '')
		{
			$val = $default;
		}
		
		return $val;
	}
}
/* End of file element_url_helper.php */
/* Location: ./application/helpers/element_url_helper.php */