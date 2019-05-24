<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * refactor response object
 *
 * @param $resp array response object
 * @param $code int response code
 * @param $message string response message
 *
 * @author sasia
 * @created 2014-04-19
 */
if (function_exists('refactor_response') == false)
{
	function refactor_response($resp, $code, $message = '')
	{
		$resp['code'] = $code;
		$resp['message'] = $message;
		return $resp;
	}
}

/*
 * generate response array
 *
 * common response struct is like as following:
 *   stat : response stat. "ok" or "fail"
 *   code : response code. 0~99 ok, 100~199 fail
 *   message : response message
 *
 * @param $code int response code
 * @param $message string response message
 *
 * @author sasia
 * @created 2014-04-19
 *
 */
if (function_exists('make_response') == false)
{
	function make_response($code, $message = '')
	{
		$resp = array();
		return refactor_response($resp, $code, $message);
	}
}

/*
 * output response string and exit
 *
 * @param $resp array response object
 * @param $format string response format. json or xml, others.
 * @return nothing
 *
 * @author sasia
 * @created 2014-04-19
 */
if (function_exists('ret_response') == false)
{
	function ret_response($resp, $format='json')
	{
		if ($format == 'json')
		{
			echo json_encode($resp);
		}
		else
		{
			print_r($resp);
		}
		exit();
	}
}

if (function_exists('ret_refactor_response') == false)
{
	function ret_refactor_response($resp, $code, $message = '')
	{
		$resp = refactor_response($resp, $code, $message);
		ret_response($resp);
	}
}

/*
 * make response and return that string
 *
 * call make_response and ret_response functions
 *
 * @author sasia
 * @created 2014-04-19
 */
if (function_exists('ret_make_response') == false)
{
	function ret_make_response($code, $message = '')
	{
		$resp = make_response($code, $message);
		ret_response($resp);
	}
}
?>