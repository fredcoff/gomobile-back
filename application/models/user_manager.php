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
}