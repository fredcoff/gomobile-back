<?php

// Created at 2019-05-08

class Users extends CI_Controller {

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
		redirect('users/user_list');
	}

	public function user_list() {
		$params =  elements_copy_urldecode($this->uri->uri_to_assoc());
		$options['start'] = element_val('page', $params, 0);
		$options['count'] = COUNT_PER_PAGE;

		$user_list = $this->user_manager->get_userList($options);

		$config['total_rows'] = $this->user_manager->get_userCount();

		$config['cur_page'] = $options['start'];
		$config['per_page'] = $options['count'];
		$config['base_url'] = site_url('users/user_list').elements_to_url("", $options).'/page';

		$this->pagination->initialize($config);

		$data = array();
		$data['user_list'] = $user_list;
		$data['options']	= $options;

		$this->load->view('users/user_list', $data);
	}
}