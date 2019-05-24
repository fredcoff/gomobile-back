<?php

// Created at 2019-05-19

class Tests extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->admin_manager->check_login();

		if (isset($_SERVER['HTTP_REFERER'])) {
			$this->session->set_userdata('previous_page', $_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_userdata('previous_page', base_url());
		}
	}

	public function index() {
		redirect('tests/signal_strength_list');
	}

	public function signal_strength_list() {
		$params =  elements_copy_urldecode($this->uri->uri_to_assoc());
		$options['type'] = 0;
		$options['start'] = element_val('page', $params, 0);
		$options['count'] = COUNT_PER_PAGE;

		$test_list = $this->test_manager->get_testResultList($options);

		$config['total_rows'] = $this->test_manager->get_testResultCount(0);

		$config['cur_page'] = $options['start'];
		$config['per_page'] = $options['count'];
		$config['base_url'] = site_url('tests/signal_strength_list').elements_to_url("", $options).'/page';

		$this->pagination->initialize($config);

		$data = array();
		$data['test_list'] = $test_list;
		$data['options']	= $options;

		$this->load->view('tests/signal_strength_list', $data);
	}

	public function network_perform_list() {
		$params =  elements_copy_urldecode($this->uri->uri_to_assoc());
		$options['type'] = 1;
		$options['start'] = element_val('page', $params, 0);
		$options['count'] = COUNT_PER_PAGE;

		$test_list = $this->test_manager->get_testResultList($options);

		$config['total_rows'] = $this->test_manager->get_testResultCount(1);

		$config['cur_page'] = $options['start'];
		$config['per_page'] = $options['count'];
		$config['base_url'] = site_url('tests/network_perform_list').elements_to_url("", $options).'/page';

		$this->pagination->initialize($config);

		$data = array();
		$data['test_list'] = $test_list;
		$data['options']	= $options;

		$this->load->view('tests/network_perform_list', $data);
	}

	public function time_series_list() {
		$params =  elements_copy_urldecode($this->uri->uri_to_assoc());
		$options['type'] = 2;
		$options['start'] = element_val('page', $params, 0);
		$options['count'] = COUNT_PER_PAGE;

		$test_list = $this->test_manager->get_testResultList($options);

		$config['total_rows'] = $this->test_manager->get_testResultCount(2);

		$config['cur_page'] = $options['start'];
		$config['per_page'] = $options['count'];
		$config['base_url'] = site_url('tests/time_series_list').elements_to_url("", $options).'/page';

		$this->pagination->initialize($config);

		$data = array();
		$data['test_list'] = $test_list;
		$data['options']	= $options;

		$this->load->view('tests/time_series_list', $data);
	}

	public function ext_npt_list() {
		$params =  elements_copy_urldecode($this->uri->uri_to_assoc());
		$options['type'] = 3;
		$options['start'] = element_val('page', $params, 0);
		$options['count'] = COUNT_PER_PAGE;

		$test_list = $this->test_manager->get_testResultList($options);

		$config['total_rows'] = $this->test_manager->get_testResultCount(3);

		$config['cur_page'] = $options['start'];
		$config['per_page'] = $options['count'];
		$config['base_url'] = site_url('tests/ext_npt_list').elements_to_url("", $options).'/page';

		$this->pagination->initialize($config);

		$data = array();
		$data['test_list'] = $test_list;
		$data['options']	= $options;

		$this->load->view('tests/ext_npt_list', $data);
	}

	public function call_drop_list() {
		$params =  elements_copy_urldecode($this->uri->uri_to_assoc());
		$options['type'] = 4;
		$options['start'] = element_val('page', $params, 0);
		$options['count'] = COUNT_PER_PAGE;

		$test_list = $this->test_manager->get_testResultList($options);

		$config['total_rows'] = $this->test_manager->get_testResultCount(4);

		$config['cur_page'] = $options['start'];
		$config['per_page'] = $options['count'];
		$config['base_url'] = site_url('tests/call_drop_list').elements_to_url("", $options).'/page';

		$this->pagination->initialize($config);

		$data = array();
		$data['test_list'] = $test_list;
		$data['options']	= $options;

		$this->load->view('tests/call_drop_list', $data);
	}
}