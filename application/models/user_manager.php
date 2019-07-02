<?php

// Created at 2019-05-13

class User_manager extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_userList($search_option = NULL) {
		$sql = "SELECT	*
				FROM	user_info ";
		$sql .= " ORDER BY idx DESC ";

		if ($search_option != NULL) {
			$sql .= " LIMIT ".$search_option['start']." , ".$search_option['count']." ";
		}

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_userCount() {
		$sql = "SELECT	COUNT(*) as cnt
				FROM	user_info ";
		$sql .= " ORDER BY idx DESC ";

		$query = $this->db->query($sql);
		return $query->row()->cnt;
	}

	function get_user($criteria) {
		return $this->db->get_where('user_info', $criteria);
	}

	/**
	 * get user child
	 *
	 * @param $current_user
	 * @return bool
	 */
	function is_user_child($current_user) {
		return ($current_user['role'] == 3 || $current_user['role'] == 4); // region child or account child
	}

	function is_parent($current_user) {
		return ($current_user['role'] == 1 || $current_user['role'] == 2); // region child or account child
	}

	function is_individual($current_user) {
		return ($current_user['role'] == 10);
	}

	function is_super($current_user) {
		return ($current_user['role'] == 100);
	}

	/**
	 *
	 */
	function add_criteria($old_criteria, $current_user) {
		$criteria = $old_criteria;
		if ($this->is_parent($current_user)) { // filter by parent id
			$criteria['A.parent_id'] = $current_user['idx'];
			$criteria['A.role'] = $current_user['role'] + 1;
		}
		return $criteria;
	}

	function check_manage_users($current_user) {
		// row check
		if ($this->is_user_child($current_user)) {
			throw new Exception("Bad Permission");
		}

		if ($this->is_individual($current_user)) {
			throw new Exception("Bad Permission");
		}
		return true;
	}

	/**
	 * @param $criteria
	 * @param $current_user
	 * @return
	 * @throws Exception
	 */
	function get_users_list($criteria, $current_user) {
		$this->check_manage_users($current_user);

		$criteria = $this->add_criteria($criteria, $current_user);

		$this->db->from('user_info A');
		$this->db->join('user_info B', 'A.parent_id = B.idx', 'left');
		$this->db->join('geo_fencing C', 'A.geo_fencing_id = C.id', 'left');
		$this->db->select('A.*, concat(B.first_name," ", B.last_name) as parent_name, C.title as region_title');

		$query = $this->db->where($criteria)->get();

		return $query->result_array();
	}

	/**
	 * @param $new_user
	 * @param $current_user
	 * @return bool
	 * @throws Exception
	 */
	function add_user($new_user, $current_user) {
		$this->check_manage_users($current_user);

		if ($this->is_super($current_user)) {

			if ($new_user['role'] == 1) { // region user
				if (@$new_user['geo_fencing_id']) {

				} else {
					throw new Exception("Require geo fencing");
				}
			}
		} else if ($this->is_parent($current_user)) {
			$new_user['role'] = $current_user['role'] + 1;
			$new_user['parent_id'] = $current_user['idx'];

		}

		$new_user['reg_date'] = date(DEFAULT_DATEFORMAT, time());

		$this->db->db_debug = false;

		$this->db->insert('user_info', $new_user);

		$error = $this->db->error();
		if (@$error['message']) {
			throw new Exception($error['message']);
		}
		$this->db->db_debug = true;

		if($this->db->affected_rows() > 0)
		{
			$new_user['idx'] = $this->db->insert_id();

			// Code here after successful insert
			return $new_user; // to the controller
		}
		return false;
	}

	function get_user_by_id($user_id, $current_user) {
		$this->check_manage_users($current_user);

		$criteria['idx'] = $user_id;
		$criteria = $this->add_criteria($criteria, $current_user);

		$query = $this->db->from('user_info A')->where($criteria)->get();

		return $query->row_array();
	}

	function update_user($new_user, $current_user) {
		$this->check_manage_users($current_user);

		$criteria = array('idx' => $new_user['idx']);
		$criteria = $this->add_criteria($criteria, $current_user);

		if ($this->is_super($current_user)) {

		} else if ($this->is_parent($current_user)) {
			$new_user['role'] = $current_user['role'] + 1;
			$new_user['parent_id'] = $current_user['idx'];
		}

		// $new_user['reg_date'] = date(DEFAULT_DATEFORMAT, time());

		$this->db->db_debug = false;

		// $this->db->where('idx', $new_user['idx']);
		$this->db->where($criteria);
		$this->db->update('user_info A', $new_user);

		$error = $this->db->error();
		if ($error['code']) {
			throw new Exception($error['message']);
		}

		if($this->db->affected_rows() > 0)
		{
			// Code here after successful insert
			return true; // to the controller
		}
		return false;
	}

	function delete_user($user_id, $current_user) {
		$this->db->where('idx', $user_id);
		$this->db->delete('user_info');
		return true;
	}
}
