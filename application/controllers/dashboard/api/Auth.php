<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Auth extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('user_manager');
		$this->load->model('admin_manager');

    }

    public function logout_get() {

    }
    public function login_post()
    {
        $u = $this->post('email'); //Username Posted
        $p = /*sha1*/($this->post('password')); //Pasword Posted
        $q = array('email' => $u); //For where query condition
        $kunci = $this->config->item('thekey');
        $invalidLogin = ['status' => 'Invalid Login']; //Respon if login invalid

        $val = $this->user_manager->get_user($q)->row(); //Model to get single data row from database base on username

        if($this->user_manager->get_user($q)->num_rows() == 0){$this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);}

        $match = $val->password;   //Get password for user from database

        if($p == $match){  //Condition if password matched
        	$role = $this->admin_manager->get_role_by_role_id($val->role);

        	$token['id'] = $val->idx;  //From here

            $token['email'] = $u;
            // $date = new DateTime();
            $token['iat'] = time();
			$token['exp'] = time() + 24 * 3600; //To here is to generate token
            $jwtToken = JWT::encode($token,$kunci ); //This is the output token
            $output['user'] = array(
                'first_name'=> $val->first_name,
                'last_name'=> $val->last_name,
                'username' => $val->first_name.' '.$val->last_name,
                'email' => $token['email'],
				'role' => $role,
				'token' => $jwtToken
            );

            $this->set_response($output, REST_Controller::HTTP_OK); //This is the respon if success
        }
        else {
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND); //This is the respon if failed
        }
    }

    public function upload_kml_post() {

    	$ret_data = array(
    		'status' => 'success',
			'message' => '',
			'filePath' => 'abc',
		);

		$config = array(
			'upload_path' => __DIR__."/../../../../uploads/",
			'allowed_types' => "kml",
			'overwrite' => TRUE,
			'max_size' => "204800000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'encrypt_name' => true,
		);
		// $config['file_name'] = 'image001';

		$this->load->library('upload', $config);
		if($this->upload->do_upload('file'))
		{
			$data = array('upload_data' => $this->upload->data());
			$ret_data['message'] = $data;
			$ret_data['filePath'] = base_url('uploads/'.$data['upload_data']['file_name']);
			$this->set_response($ret_data, REST_Controller::HTTP_OK);
		} else {
			$ret_data['message'] = $this->upload->display_errors();
			$this->set_response($ret_data, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
		}

	}

}
