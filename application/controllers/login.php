<?php

// Created at 2019-04-11

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		if ($this->admin_manager->is_login()) {
			redirect('users/user_list');
			exit();
		}
		$this->load->view('login');
	}

	public function login_do() {
		$this->session->set_flashdata('admin_id', $this->input->post('admin_id'));

		if ($this->input->post('redirect_url')) {
			$this->session->set_flashdata('redirect_url', $this->input->post('redirect_url'));
		}

		$admin_id = $this->input->post('admin_id');
		$admin_password = $this->input->post('admin_password');

		if ($this->admin_manager->login($admin_id, $admin_password) == false) {
			$this->session->set_flashdata('notification', 'Invalid account.');
			redirect('login');
		} else {
			if ($this->input->post('redirect_url')) {
				redirect($this->input->post('redirect_url'));
			} else {
				redirect('users/user_list');
			}
		}
	}

	public function logout() {
		$this->admin_manager->logout();
		redirect('login');
	}
}
