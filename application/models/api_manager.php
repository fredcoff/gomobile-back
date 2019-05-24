<?php

// Created at 2019-05-13

class Api_manager extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function isExist_cur_user($email) {
		$this->db->select('count(*) as cnt');
		$this->db->from('user_info');
		$this->db->where('email', $email);
		$query = $this->db->get();
		return $query->row()->cnt;
	}

	public function register_user($params) {
		if ($this->isExist_cur_user($params['email']) == 0) {
			$this->db->insert('user_info', $params);
			return $this->db->insert_id();
		} else {
			return -1;
		}
	}

	public function login_user($params) {
		$this->db->where('email', $params['email']);
		$query = $this->db->get('user_info', 1);

		if ($query->num_rows() == 1) {
			$result = $query->row();
			if ($result->password != $params['password']) {
				return -1;
			}
			return $result->idx;
		}
		return -2;
	}

	public function reset_password($params) {
		if ($this->isExist_cur_user($params['email']) == 0) {
			return 0;
		} else {
			$this->db->where('email', $params['email']);
			$this->db->update('user_info', $params);
			return 1;
		}
	}

	public function get_userInfo($user_idx) {
		$sql = "SELECT	*
				FROM	user_info
				WHERE	idx = $user_idx ";
		$query = $this->db->query($sql);
		$result = $query->row();
		if ($result == null) {
			return null;
		}
		return $result;
	}

	public function add_testResultInfo($params) {
		$this->db->insert('test_result_info', $params);
		return $this->db->insert_id();
	}

	public function get_adminList() {
		$sql = "SELECT	*
				FROM	admin_info ";
		$sql .= " ORDER BY idx DESC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_userList() {
		$sql = "SELECT	*
				FROM	user_info ";
		$sql .= " ORDER BY idx DESC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_testResultist() {
		$sql = "SELECT	*
				FROM	test_result_info ";
		$sql .= " ORDER BY idx DESC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}