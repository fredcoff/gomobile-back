<?php



class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->admin_manager->check_login();

		if (isset($_SERVER['HTTP_REFERER'])) {
			$this->session->set_userdata('previous_page', $_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_userdata('previous_page', site_url('/'));
		}
	}

	public function index() {
		redirect('admin/modify_admin');
	}

	public function kml() {
		$this->load->model('test_manager');
		$this->load->model('exporter_manager');
		$criteria = array(
			'type' => 2,
			'blackspot' => 0,
			'start_date' => '2019-06-02',
			'end_date' => '2019-07-02',
			'hour' => -1,
			'showMarker' => 'true',
			'showCoverage' => 'true',
		);
		$propertyOptions = json_decode(
			'{"marker":{"fillColor":"#9b5b19","fillOpacity":0.5,"strokeWeight":3,"strokeColor":"#0558E3"},"coverage":{"fillColor":"","strokeColor":"","fillOpacity":0.5,"strokeWeight":3,"strokeOpacity":1,"radius":12},"geofencing":{"fillColor":"#9b5b19","fillOpacity":0.5,"strokeWeight":3,"strokeColor":"#0558E3"}}', true);

		$result = $this->test_manager->get_test_data($criteria);

		$knn_result_and_stats = $this->test_manager->knn_line($result, $criteria);
		$this->load->model('exporter_manager');


		ob_start();
		$this->exporter_manager->generate_excel($result, $knn_result_and_stats, $criteria, $propertyOptions);
		ob_end_flush();

		// var_dump($knn_result);
		// $this->exporter_manager->strength_kml($result, $criteria);
	}

	public function migration() {
		$this->admin_manager->migration();
	}

	public function modify_admin() {
		$this->load->view('admin/modify_admin');
	}

	public function do_modify_admin() {
		$curPwd = $this->input->post('curPwd');
		$newPwd = $this->input->post('newPwd');

		if ($this->admin_manager->changePassword($curPwd, $newPwd) == 0) {
			$this->session->set_flashdata('notification', "Current password is incorrect.");
			redirect('admin/modify_admin');
		} else {
			$this->session->set_flashdata('notification', "The password has been modified successfully. Please log in again now.");
			$this->admin_manager->logout();
			redirect('login');
		}
	}
}
