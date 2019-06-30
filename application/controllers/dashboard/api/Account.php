<?php
/**
 * Created by IntelliJ IDEA.
 * User: Daniel
 * Date: 2019/6/10
 * Time: 4:57 PM
 */


defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Account
 *
 * account api
 */
class Account extends BD_Controller
{
	var $current_user;

	function __construct()
	{
		// Construct the parent class
		parent::__construct();

		$this->auth();

		$this->load->model('admin_manager');
		$this->load->model('user_manager');

		// load current user information
		$user_id = $this->user_data->id;
		$this->current_user = $this->admin_manager->get_user_by_id($user_id);
	}

	function roles_get() {
		$role_list = $this->admin_manager->get_role_list();
		$this->response($role_list, 200);
	}

	/**
	 * get user list
	 *
	 */
	function users_get() {
		$criteria = array();

		try {
			$user_list = $this->user_manager->get_users_list($criteria, $this->current_user);

			$this->response($user_list, 200);
		} catch (Exception $e) {
			$this->response(array('error' => $e->getMessage()), 400);
		}
	}

	function users_post() {
		$new_user = $this->post();
		try {
			$success = $this->user_manager->add_user($new_user, $this->current_user);

			if ($success) {
				$this->response($success, 201);
			} else {
				$this->response($success, 500);
			}

		} catch (Exception $e) {
			$this->response(array('error' => $e->getMessage()), 400);
		}
	}

	/**
	 * get user
	 *
	 * @param $user_id
	 */
	function user_get($user_id) {

		try {
			$user = $this->user_manager->get_user_by_id($user_id, $this->current_user);

			$this->response($user, 200);

		} catch (Exception $e) {
			$this->response($e->getMessage(), 400);
		}
	}

	function user_put($user_id) {
		$new_user = $this->put('account');

		$new_user = elements(array('idx', 'first_name', 'last_name', 'expire_date',
			'geo_fencing_id', 'parent_id', 'role'
		), $new_user);


		$new_user['idx'] = $user_id;
		try {
			$success = $this->user_manager->update_user($new_user, $this->current_user);

			if ($success) {
				$this->response($success, 201);
			} else {
				$this->response($success, 500);
			}

		} catch (Exception $e) {
			$this->response(array('error' => $e->getMessage()), 400);
		}
	}

	function user_delete($user_id) {
		try {
			$success = $this->user_manager->delete_user($user_id, $this->current_user);

			if ($success) {
				$this->response($success, 200);
			} else {
				$this->response($success, 500);
			}

		} catch (Exception $e) {
			$this->response(array('error' => $e->getMessage()), 400);
		}
	}

}
