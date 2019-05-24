<?php

// Created at 2019-04-11

class Apitest extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		if (DEBUG == true)
		{
			$this->load->view('api/apitest');
		}
	}

	function upload() {
		if (DEBUG == true)
		{
			$this->load->view('api/apitestupload');
		}
	}
}
