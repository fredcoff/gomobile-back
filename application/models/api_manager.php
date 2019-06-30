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
		$this->db->set('user_email', $params['user_email']);
		$this->db->set('type', $params['type']);
		$this->db->set('test_result', $params['test_result']);
		$this->db->set('reg_date', $params['reg_date']);
		$this->db->set('register_date', $params['register_date']);
		$this->db->set('is_lte', $params['is_lte']);
		$this->db->set('ss_val', $params['ss_val']);
		$this->db->set('lat_point', $params['lat_point']);
		$this->db->set('carrier', $params['carrier']);
		$this->db->set('long_point', $params['long_point']);
		$this->db->set('batch_no', $params['batch_no']);
		$this->db->set('distance', $params['distance']);
		$this->db->set('user_id', $params['user_id']);


		$this->db->set('test_point', "geomfromtext(\"POINT({$params['long_point']} {$params['lat_point']})\")", false);

		$this->db->insert('test_result_info');
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
		$sql = "SELECT	idx, user_email, `type`, test_result, reg_date, register_date, is_lte, carrier, ss_val
				FROM	test_result_info ";
		$sql .= " ORDER BY idx DESC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
