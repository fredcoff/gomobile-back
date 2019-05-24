<?php

// Created at 2019-05-18

class Test_manager extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_testResultList($search_option) {
		$sql = "SELECT	*
				FROM	test_result_info
				WHERE	type = ".$search_option['type'];
		$sql .= " ORDER BY idx DESC ";
		$sql .= " LIMIT ".$search_option['start']." , ".$search_option['count']." ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function get_testResultCount($type) {
		$sql = "SELECT	COUNT(*) as cnt
				FROM	test_result_info
				WHERE	type = $type ";
		$query = $this->db->query($sql);
		return $query->row()->cnt;
	}
}