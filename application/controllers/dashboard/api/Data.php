<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->auth();
    }

    public function result_get()
	{
        // $theCredential = $this->user_data;

        $this->load->model('test_manager');
		$this->load->model('user_manager');
		$this->load->model('admin_manager');

        $type = $this->get('type');

        $criteria = array(
            'type' => $type
		);

        $start_date = $this->get('dateStart');
		$end_date = $this->get('dateEnd');
        $hour = $this->get('hour');
		$commType = $this->get('commType');
		$carrier = $this->get('carrier');
		$geofencingId = $this->get('geofencingId');
		$blackspot = $this->get('blackspot');

        if ($start_date) {
            $date_pared = date_parse($start_date);
			$date_str = sprintf('%04d-%02d-%02d', $date_pared['year'],
				$date_pared['month'], $date_pared['day']);

            $criteria['start_date'] = $date_str;
        } else {
			$criteria['start_date'] = date('Y-m-d');
		}

		if ($end_date) {
			$date_pared = date_parse($end_date);
			$date_str = sprintf('%04d-%02d-%02d', $date_pared['year'],
				$date_pared['month'], $date_pared['day']);

			$criteria['end_date'] = $date_str;
		} else {
			$criteria['end_date'] = date('Y-m-d');
		}

        if ($hour >= 0 && $hour <= 24) {
        	$criteria['hour'] = $hour;
		} else {
			$criteria['hour'] = -1;
		}

		if ($commType != '' && $commType != -1) {
			$criteria['is_lte'] = ($commType == 1)?1:0;
		}

		if ($carrier && $carrier != '-1') {
			$criteria['carrier'] = $carrier;
		}

		if ($geofencingId && $geofencingId != '-1') {
			$criteria['geofencingId'] = $geofencingId;
		}

		if ($blackspot) {
			$criteria['blackspot'] = 1;
		} else {
			$criteria['blackspot'] = 0;
		}

		$criteria['showMarker'] = 0;
		if ($this->get('showMarker') == 'true') {
			$criteria['showMarker'] = 1;
		}

		$criteria['showCoverage'] = 0;
		if ($this->get('showCoverage') == 'true') {
			$criteria['showCoverage'] = 1;
		}

		$user_id = $this->user_data->id;
		$current_user = $this->admin_manager->get_user_by_id($user_id);

		if ($this->user_manager->is_super($current_user)) {

		} else {
			$criteria['user_id'] = $current_user['idx'];
		}

        $result = $this->test_manager->get_test_data($criteria);
		$knn_result_and_stats = $this->test_manager->knn_line($result, $criteria);

		$propertyOptions = json_decode($this->get('options'), true);

		/*
        $kmlOption = array(
            'type' => $criteria['type'],
            'blackspot' => $criteria['blackspot']
        );

        $lineOption = array(
            'stroke' => 8,
            'transparency' => 0.8
        );

        if ($this->get('stroke')) {
            $lineOption['stroke'] = $this->get('stroke');
        }
        if ($this->get('transparency')) {
            $lineOption['transparency'] = $this->get('transparency');
        }
		*/

		if ($this->get('kml')) {
			$this->load->model('exporter_manager');

			$fileName = $this->exporter_manager->strength_kml_name($criteria);
			$fileName .= '.kml';

			header('Content-Type: text/xml');
			header('Content-Disposition: attachment; filename="' . $fileName . '"');

			ob_start();
			$this->exporter_manager->generate_kml($result, $knn_result_and_stats, $criteria, $propertyOptions);
			ob_end_flush();

		} else if ($this->get('excel')) {
            $this->load->model('exporter_manager');
            $this->exporter_manager->generate_excel($result, $knn_result_and_stats, $criteria, $propertyOptions);
        } else {
			$return_result = array('markers' => $result,
				'lines' => $knn_result_and_stats['dots'],
				'stats' => $knn_result_and_stats['stats']);
			$this->response($return_result, 200);
		}
    }

	public function result_delete()
	{
		$idx = $this->input->get('idx');
		$this->test_manager->delete_test_data_by_idx($idx);
		$this->response(array(), 200);
		// echo 'hello';
	}

	public function fencing_list_get()
	{
		$fencing_list = $this->test_manager->get_fencing_list();
		$this->response(array('fencing_list' => $fencing_list), 200);
	}

	public function fencing_get($fencing_id)
	{
		$fencing = $this->test_manager->get_fencing_by_id($fencing_id);
		$this->response(array('fencing' => $fencing), 200);
	}

	public function fencing_delete($fencing_id)
	{
		$this->test_manager->delete_fencing_by_id($fencing_id);
		$this->response(array('success' => true), 200);
	}

	public function fencing_post()
	{
		/*
		$fencing = array(
			'title' => 'title 1',
			'polygon' => array(
				array('lat' => 0, 'lng' => 0),
				array('lat' => 90, 'lng' => 0),
				array('lat' => 90, 'lng' => 90),
			)
		);
		*/
		$fencing = $this->post('fencing');

		$last_id = $this->test_manager->insert_fencing($fencing);
		$this->response(array('last_id' => $last_id), 200);
	}

	public function fencing_put($fencing_id)
	{
		$fencing = $this->put('fencing');
		$fencing['id'] = $fencing_id;
		$this->test_manager->update_fencing($fencing);
		$this->response(array('success' => true), 200);
	}

	public function dashboard_get(){
    	$this->load->model('test_manager');
		$this->load->model('admin_manager');
		$this->load->model('user_manager');

		$user_id = $this->user_data->id;
		$current_user = $this->admin_manager->get_user_by_id($user_id);

		$criteria = array();
		if ($this->user_manager->is_super($current_user)) {
		    if ($this->get('mine')) {
                $criteria['user_id'] = $current_user['idx'];
            }
		} else {
			$criteria['user_id'] = $current_user['idx'];
		}

		// var_dump($criteria);

    	$total_ss = $this->test_manager->get_stats_ss($criteria);
		$total_ss_spot = $this->test_manager->get_stats_ss_blackspot($criteria);
		$total_npt = $this->test_manager->get_stats_npt($criteria);

    	$dashboard_statistic = array(
    		array('title' => 'Number of Signal Strength markers', 'text' => number_format($total_ss['total_count']), 'value' => $total_ss['total_count']),
			array('title' => 'Number of black spot markers', 'text' => number_format($total_ss_spot['total_count']), 'value' => $total_ss_spot['total_count']),
			array('title' => 'Klms of black spots', 'text' => number_format($total_ss_spot['total_distance']/ 1000, 2).'km', 'value' => $total_ss_spot['total_distance']),
			array('title' => 'Total distance tested', 'text' => number_format($total_ss['total_distance']/ 1000, 2).'km', 'value' => $total_ss['total_distance']),
			array('title' => 'Number of Network Performance Tests', 'text' => number_format($total_npt['total_count']), 'value' => $total_npt['total_count']),
			array('title' => 'Highest speed download', 'text' => '64Mbps', 'value' => '100'),
			array('title' => 'Highest upload speed', 'text' => '9.0Mbps', 'value' => '100'),
			array('title' => 'Time to the internet and back (latency - lower is better)', 'text' => '56ms', 'value' => '56'),
		);
		$this->response($dashboard_statistic, 200);
	}
}
