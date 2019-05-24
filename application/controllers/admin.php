<?php

// Created at 2019-04-11

class Admin extends CI_Controller {

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
		redirect('admin/modify_admin');
	}

	public function modify_admin() {
		$this->load->view('admin/modify_admin');
	}

	public function do_modify_admin() {
		$curPwd = $this->input->post('curPwd');
		$newPwd = $this->input->post('newPwd');

		if ($this->admin_manager->changePassword($curPwd, $newPwd) == 0) {
			$this->session->set_flashdata('notification', "Current password is incorrect.");
			redirect('admin/modify_admin');
		} else {
			$this->session->set_flashdata('notification', "The password has been modified successfully. Please log in again now.");
			$this->admin_manager->logout();
			redirect('login');
		}
	}
}
