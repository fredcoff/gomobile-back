<?php

// Created at 2019-05-13

class Admin_manager extends CI_Model {

	var $idx;
	var $admin_id;

	function __construct() {
		parent::__construct();
		$this->_load_session_data();
	}

	private function _load_session_data() {
		$this->idx		= $this->session->userdata('idx');
		$this->admin_id	= $this->session->userdata('admin_id');
	}

	public function login($admin_id, $admin_password) {
		$this->_destroy_session();

		$this->db->where('admin_id', $admin_id);
		$query = $this->db->get('admin_info', 1);

		if ($query->num_rows() == 1) {
			$admin = $query->row();
			if ($admin->admin_password == $admin_password) {
				$this->idx		= $admin->idx;
				$this->admin_id	= $admin->admin_id;

				$data = array (
							'idx'		=> $this->idx,
							'admin_id'	=> $this->admin_id,
						);

				$this->session->set_userdata($data);

				return true;
			}
		}

		return false;
	}

	public function is_login() {
		if (!isset($this->admin_id) || empty($this->admin_id)) {
			return false;
		}

		return true;
	}

	public function check_login($redirect_url = '') {
		if (!($this->is_login())) {
			$this->session->set_flashdata('notification', 'Please log in now.');
			
			$query = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
			
			$url = $this->config->site_url().$this->uri->uri_string(). $query;
			
			$this->session->set_flashdata('redirect_url', $url);
						
			redirect($redirect_url);
			exit();
		}
	}

	public function logout() {
		$this->_destroy_session();
	}

	private function _destroy_session() {
		$data = array (
					'idx'		=> '',
					'admin_id'	=> '',
				);

		$this->session->unset_userdata($data);
	}

	public function changePassword($curPwd, $newPwd) {
		if ($this->isEqualCurPwd($curPwd) == false) {
			return 0;
		} else {
			$this->db->where('admin_id', $this->admin_id);
			return $this->db->update('admin_info', array('admin_password' => $newPwd));
		}
	}

	public function isEqualCurPwd($curPwd) {
		$this->db->where('admin_id', $this->admin_id);
		$query = $this->db->get('admin_info', 1);

		if ($query->num_rows() == 1) {
			$admin = $query->row();
			if ($admin->admin_password == $curPwd) {
				return true;
			}
		}

		return false;
	}
}