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
		/*
		if (!isset($this->admin_id) || empty($this->admin_id)) {
			return false;
		}
		*/

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

	/**
	 * get user id from user email
	 *
	 * @param $user_email string user email
	 * @return int
	 */
	public function get_user_id($user_email) {
		$query = $this->db->get_where('user_info', array('email' => $user_email));
		$ret = $query->row_array();
		if ($ret) {
			return $ret['idx'];
		}
		return 0;
	}

	/**
	 * get user information by id
	 *
	 * @param $user_id int user id
	 * @return array user information
	 */
	public function get_user_by_id($user_id) {
		$query = $this->db->get_where('user_info', array('idx' => $user_id));
		return $query->row_array();
	}

	/**
	 * get role list
	 *
	 * @param array $criteria
	 * @return array role list
	 */
	public function get_role_list($criteria = array('type' => 0)) {
		$this->db->from('roles');
		if (@$criteria['type'] > 0) {
			$this->db->where('type', $criteria['type']);
		}
		$this->db->order_by('order_no', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * get role by role id
	 *
	 * @param $role_id int role id
	 * @return array role record information
	 */
	public function get_role_by_role_id($role_id) {
		$query = $this->db->get_where('roles', array('role_id' => $role_id));
		return $query->row_array();
	}

	public function migration() {
		// migration data
		$query = $this->db->from('test_result_info')->select('idx,test_result,lat_point, long_point, user_email')
			->where('user_id', 0)->limit(500)->get();
		$result = $query->result_array();
		foreach($result as $row) {

			// $test_result = json_decode($row['test_result'], true);

//			$batch_no = 0;
//			$distance = 0;
//			if (@$test_result['nTestIdx']) {
//				$batch_no = $test_result['nTestIdx'];
//			}
//
//			if (@$test_result['strDistFrom']) {
//				$distance = floatval($test_result['strDistFrom']);
//			}
			// $this->db->set('batch_no', $batch_no);
			// $this->db->set('distance', $distance);
			$user_id = $this->admin_manager->get_user_id($row['user_email']);
			$this->db->set('user_id', $user_id);

			/*
			 *if ($row['type'] == 0) {
				if ($test_result['bIsLte']) {
					$row['is_lte'] = 1;
					$row['ss_val'] = $test_result['nLteSS'];
				} else {
					$row['is_lte'] = 0;
					$row['ss_val'] = $test_result['nGsmSS'];
				}

				$this->db->set('is_lte', $row['is_lte']);
				$this->db->set('ss_val', $row['ss_val']);
			}

			$row['geo_point'] = "POINT({$test_result['nLongitude']},{$test_result['nLatitude']})";

			$this->db->set('geo_point', $row['geo_point'], false);
			$this->db->set('lat_point', $test_result['nLatitude']);
			$this->db->set('long_point', $test_result['nLongitude']);

			// $row['carrier'] = $test_result['strCarrier'];
			$this->db->where('idx', $row['idx']);
			$this->db->update('test_result_info');
			*/

			// $this->db->set('test_point', "POINT({$row['long_point']},{$row['lat_point']})", false);
			// $this->db->set('carrier', $test_result['strCarrier']);
			$this->db->where('idx', $row['idx']);
			$this->db->update('test_result_info');
		}
	}
}
