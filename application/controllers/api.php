<?php

// Created at 2019-04-11

class Api extends CI_Controller {

	var $apiKey = "";

	public function __construct() {
		parent::__construct();

		$this->apiKey = $this->input->post('apiKey');
		$this->load->library('email');

		if ($this->apiKey) {
			session_id($this->apiKey);
		}
		@session_start();
	}

	private function session_check() {
		if (!trim($this->apiKey)) {
			ret_make_response(11, "Your api key is not exist.");
		} else {
			if (!isset($_SESSION['user_idx'])) {
				ret_make_response(12, "You did not log in yet.");
			}
		}
	}

	public function registerUser() {
		$params = array();
		$params['email'] = $this->input->post('email');
		$params['first_name'] = $this->input->post('first_name');
		$params['last_name'] = $this->input->post('last_name');
		$params['password'] = $this->input->post('password');
		$params['device_id'] = $this->input->post('device_id');
		$params['product_id'] = $this->input->post('product_id');
		$params['wifi_product_id'] = $this->input->post('wifi_product_id');
		$params['activated'] = $this->input->post('activated');
		$params['reg_date'] = date(DEFAULT_DATEFORMAT, time());

		$user_idx = $this->api_manager->register_user($params);

		if ($user_idx > 0) {
			$ret_resp = make_response(0, '');
			$ret_resp['user_info'] = $this->api_manager->get_userInfo($user_idx);
			ret_response($ret_resp);
		} else {
			ret_make_response(-2, 'This email address is already registered.');
		}
	}

	public function loginUser() {
		$params = array();
		$params['email'] = $this->input->post('email');
		$params['password'] = $this->input->post('password');

		$user_idx = $this->api_manager->login_user($params);

		if ($user_idx > 0) {
			$ret_resp = make_response(0, '');
			$ret_resp['user_info'] = $this->api_manager->get_userInfo($user_idx);
			ret_response($ret_resp);
		} else if ($user_idx == -1) {
			ret_make_response(-1, 'Invalid password.');
		} else if ($user_idx == -2) {
			ret_make_response(-2, 'This user does not exist.');
		}
	}

	public function getVerifyCode() {
		$email = $this->input->post('email');
		$is_exist = $this->api_manager->isExist_cur_user($email);
		if ($is_exist > 0) {
			$verify_code = mt_rand(100000, 999999);
			$result = $this->send_email($email, $verify_code);
//			$result = 1;
			if ($result == 1) {
				$ret_resp = make_response(0, '');
				$ret_resp['verify_code'] = $verify_code;
				ret_response($ret_resp);
			} else {
				ret_make_response(-2, 'Unable to send verify email.');
			}
		} else {
			ret_make_response(-1, 'This email address does not exist.');
		}
	}

	private function send_email($mail_to, $verify_code) {
		$from_email = "admin@gomobile.com"; 
		$to_email = $mail_to;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from($from_email, 'GoMobile'); 
		$this->email->to($to_email);
		$this->email->subject('Verify for GoMobile'); 
		$this->email->message('Verify Code for Password Recovery:  '.'<br>'.'<h1 style =" text-align: center; width:100%">'.$verify_code.'</h1>'); 
		if ($this->email->send())
			return 1;
		else 
			return 0; 
	}

	public function resetPassword() {
		$params = array();
		$params['email'] = $this->input->post('email');
		$params['password'] = $this->input->post('password');

		if ($this->api_manager->reset_password($params) == 0) {
			ret_make_response(-1, 'This email address does not exist.');
		}
		else
		{
			$ret_resp = make_response(0, '');
			ret_response($ret_resp);
		}
	}


	public function uploadTestResult() {
		$test_result = file_get_contents('php://input');
		$json = json_decode($test_result, true);

		$params = array();

		$params['user_email'] = $json['strUser'];
		$params['user_id'] = $this->admin_manager->get_user_id($params['user_email']);
		$params['type'] = $json['nType'];

		$params['test_result'] = $test_result;
		$params['reg_date'] = date(TEST_RESULT_DATEFORMAT, time());
		$params['register_date'] = date(DEFAULT_DATEFORMAT, time());

		// $test_result = json_decode($params['test_result'], true);
		if ($params['type'] == 0) {
			if ($json['bIsLte']) {
				$params['is_lte'] = 1;
				$params['ss_val'] = $json['nLteSS'];
			} else {
				$params['is_lte'] = 0;
				$params['ss_val'] = $json['nGsmSS'];
			}
			$params['carrier'] = $json['strCarrier'];
		} else {
			if ($json['bIsLte']) {
				$params['is_lte'] = 1;
			} else {
				$params['is_lte'] = 0;
			}
			$params['ss_val'] = 0;
		}
		$params['carrier'] = $json['strCarrier'];
		$params['lat_point'] = $json['nLatitude'];
		$params['long_point'] = $json['nLongitude'];
		$params['batch_no'] = @$json['nTestIdx'];
		$params['distance'] = @$json['strDistFrom'];

		$idx = $this->api_manager->add_testResultInfo($params);

		if ($idx > 0) {
			$ret_resp = make_response(0, '');
			ret_response($ret_resp);
		} else {
			ret_make_response(-2, 'Failed to upload test result.');
		}
	}

	public function getList() {
		$ret_resp = make_response(0, '');
		$ret_resp['admin_list'] = $this->api_manager->get_adminList();
		$ret_resp['user_list'] = $this->api_manager->get_userList();
		$ret_resp['test_result_list'] = $this->api_manager->get_testResultist();
		ret_response($ret_resp);
	}

	public function getTestResultList() {
		$ret_resp = make_response(0, '');
		$ret_resp['test_result_list'] = $this->api_manager->get_testResultist();
		ret_response($ret_resp);
	}
}
