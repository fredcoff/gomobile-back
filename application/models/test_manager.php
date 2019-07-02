<?php


// Created at 2019-04-11
require_once APPPATH . '/libraries/geo/Bounds.php';
require_once APPPATH . '/libraries/geo/Cluster.php';
require_once APPPATH . '/libraries/geo/Clusterer.php';
require_once APPPATH . '/libraries/geo/Coordinate.php';
require_once APPPATH . '/libraries/geo/Geo.php';

use \MatthiasMullie\Geo;
// Created at 2019-05-18

class Test_manager extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	/**
	 * 
	 */
	function get_testResultList($search_option) {
		$sql = "SELECT	*
				FROM	test_result_info
				WHERE	type = ".$search_option['type'];
		$sql .= " ORDER BY idx DESC ";
		$sql .= " LIMIT ".$search_option['start']." , ".$search_option['count']." ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/**
	 * 
	 */
	function get_testResultCount($type) {
		$sql = "SELECT	COUNT(*) as cnt
				FROM	test_result_info
				WHERE	type = $type ";
		$query = $this->db->query($sql);
		return $query->row()->cnt;
	}

	/**
	 * get test data
	 * 
	 * @param $criteria array 
	 * 	type integer data type
	 */
	function get_test_data($criteria) {
		$where_clauses = ' AND _tblname.type = '.$criteria['type'];
		// $this->db->from('test_result_info')->where('type', $criteria['type']);

		if (array_key_exists('start_date', $criteria)) {
			$where_clauses .= ' AND DATE_FORMAT(_tblname.register_date,\'%Y-%m-%d\') >= \''.$criteria['start_date'].'\'';
			// $this->db->where("DATE_FORMAT(reg_date,'%Y-%m-%d') > '{$criteria['date']}'",NULL,FALSE);
			// $this->db->where("DATE_FORMAT(register_date,'%Y-%m-%d') >= '{$criteria['start_date']}'",NULL,FALSE);
		}
		if (array_key_exists('end_date', $criteria)) {
			$where_clauses .= ' AND DATE_FORMAT(_tblname.register_date,\'%Y-%m-%d\') <= \''.$criteria['end_date'].'\'';
			// $this->db->where("DATE_FORMAT(register_date,'%Y-%m-%d') <= '{$criteria['end_date']}'",NULL,FALSE);
		}

		if (array_key_exists('hour', $criteria) && $criteria['hour'] != -1) {
			$where_clauses .= ' AND HOUR(_tblname.register_date) = \''.$criteria['hour'].'\'';
			// $this->db->where("HOUR(register_date) = '{$criteria['hour']}'",NULL,FALSE);
		}

		if ($criteria['type'] == 0 && array_key_exists('is_lte', $criteria)) {
			$where_clauses .= ' AND _tblname.is_lte = '.$criteria['is_lte'];
			// $this->db->where("is_lte",$criteria['is_lte']);
		}

		if (array_key_exists('carrier', $criteria)) {
			if ($criteria['carrier'] == 'Optus') {
				$criteria['carrier'] = 'amaysim';
				$where_clauses .= ' AND (_tblname.carrier = \'YES OPTUS\' OR _tblname.carrier = \'amaysim\') ';
			}
			else {
				$where_clauses .= ' AND _tblname.carrier = \''.$criteria['carrier'].'\'';
			}

			// $this->db->where("carrier",$criteria['carrier']);
		}

		if ($criteria['type'] == 0) {
			// $where_clauses .= ' AND _tblname.distance < 100 ';
		}

		if (@$criteria['user_id']) {
			$where_clauses .= ' AND _tblname.user_id = '.$criteria['user_id'];
		}

		$a_where_clauses = str_replace('_tblname', 'A', $where_clauses);
		$b_where_clauses = str_replace('_tblname', 'B', $where_clauses);
		// echo $a_where_clauses;


		// $this->db->order_by('idx', 'ASC');
		// $this->db->limit(200);
		// $query = $this->db->get();
		// return $query->result_array();
		$distance = 0.0008;

		// 0.000008998719243599958

		/*
		$sql_query = "
		select A.idx, A.user_email, A.type, A.test_result, A.is_lte, A.carrier, A.ss_val, A.lat_point, A.long_point, A.register_date,
			(
				select avg(ss_val)
				from test_result_info B
				where
					B.idx between A.idx -10 and A.idx + 10 AND B.ss_val >= 0
					AND
						B.lat_point between A.lat_point - ({$distance} / 111.045) AND A.lat_point + ({$distance} / 111.045)
					AND
						B.long_point between A.long_point - ({$distance} / 111.045) AND A.long_point + ({$distance} / 111.045)
					{$b_where_clauses}
			) as avg_ss_val
			from test_result_info A
			where
					1 = 1 {$a_where_clauses}
			  order by A.register_date ASC
			limit 1000
		";
		*/


		/*
select A.*,  B.user_email, B.type, B.test_result, B.reg_date, B.register_date, B.is_lte, B.carrier, B.ss_val, B.lat_point, B.long_point
from (
	select A.idx,
	SUM(CASE WHEN carrier  = 'Telstra' THEN avg_ss_val ELSE 0 END) AS 'telstra_ss',
	SUM(CASE WHEN carrier  = 'Vodafone AU' THEN avg_ss_val ELSE 0 END) AS 'vodafone_ss',
	SUM(CASE WHEN carrier  = 'amaysim' THEN avg_ss_val ELSE 0 END) AS 'optus_ss'
	From
	(
	select A.idx, C.carrier, avg(A.ss_val) as avg_ss_val
	from

	(test_result_info A  join geo_fencing C on (C.id = 7 AND ST_CONTAINS(C.fencing_polygon , A.test_point)))

	left join test_result_info B on (ST_Distance_Sphere(A.test_point, B.test_point) < 100)

	where 1 = 1 AND A.type = 0 AND DATE_FORMAT(A.register_date,'%Y-%m-%d') >= '2019-05-25' AND DATE_FORMAT(A.register_date,'%Y-%m-%d') <= '2019-06-04'

	group by A.idx, C.carrier
	) A
	group by A.idx
) A left join test_result_info B on A.idx = B.idx
order by A.idx ASC

		 */

		$from_clauses = "from test_result_info A";
		if (array_key_exists('geofencingId', $criteria)) {
			$from_clauses .= "  join geo_fencing C on (C.id = {$criteria['geofencingId']} AND ST_CONTAINS(C.fencing_polygon , A.test_point)) ";
		}
/*
		if (array_key_exists('blackspot', $criteria) && $criteria['blackspot'] > 0 ) {
			$sql_query = "
			select A.*,  B.user_email, B.type, B.test_result, B.reg_date, B.register_date, B.is_lte, B.carrier, B.ss_val, B.lat_point, B.long_point, B.batch_no
from (
	select A.idx,
	SUM(CASE WHEN carrier  = 'Telstra' THEN avg_ss_val ELSE 0 END) AS 'telstra_ss',
	SUM(CASE WHEN carrier  = 'Vodafone AU' THEN avg_ss_val ELSE 0 END) AS 'vodafone_ss',
	SUM(CASE WHEN carrier  = 'amaysim' THEN avg_ss_val ELSE 0 END) AS 'optus_ss'
	From
	(
	select A.idx, B.carrier, avg(B.ss_val) as avg_ss_val
	
	{$from_clauses}

	left join test_result_info B on (1=1 {$b_where_clauses} AND ST_Distance(A.test_point, B.test_point) < {$distance})

	where 1 = 1 {$a_where_clauses}

	group by A.idx, B.carrier
	) A
	group by A.idx
) A left join test_result_info B on A.idx = B.idx
order by  B.lat_point ASC, B.long_point ASC
			";
		} else */{
			$sql_query = "
				select A.idx, A.user_email, A.type, A.test_result, A.is_lte, A.carrier, A.ss_val, A.lat_point, A.long_point, A.register_date, A.distance,
					ss_val as avg_ss_val, ss_val as telstra_ss,  ss_val as optus_ss,  ss_val as vodafone_ss , A.batch_no
					{$from_clauses}
					where
							1 = 1 {$a_where_clauses}
					  order by  A.lat_point ASC, A.long_point ASC
				";

		}

		// echo $sql_query;
		$query = $this->db->query($sql_query);
		// var_dump($query->result_array());
		return $query->result_array();
	}

	function delete_test_data_by_idx($idx) {
		$this->db->where('idx', $idx)->delete('test_result_info');
	}

	function polygon_to_sql($polygon_json) {
		$polygon_points = array();
		foreach($polygon_json as $point) {
			$polygon_points[] = "{$point['lng']} {$point['lat']}";
		}
		// add first point in the last of the polygon
		$point = $polygon_json[0];
		$polygon_points[] = "{$point['lng']} {$point['lat']}";

		$polygon_str = implode(',', $polygon_points);
		return "PolyFromText('POLYGON(({$polygon_str}))', 0)";
	}

	function insert_fencing($fencing) {
		$polygon_sql_str = $this->polygon_to_sql($fencing['polygon']);

		$register_date = date(DEFAULT_DATEFORMAT, time());
		$sql = "INSERT INTO geo_fencing(title, fencing_polygon, register_date) VALUES (
				'{$fencing['title']}', {$polygon_sql_str}, '{$register_date}'
				)";
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	function update_fencing($fencing) {
		$polygon_sql_str = $this->polygon_to_sql($fencing['polygon']);
		$sql = "UPDATE geo_fencing set
				title = '{$fencing['title']}', fencing_polygon = {$polygon_sql_str} where id = {$fencing['id']}";
		$this->db->query($sql);
	}



	function get_fencing_list() {
		$sql = "SELECT id, title, register_date from geo_fencing";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function delete_fencing_by_id($fencing_id) {
		$this->db->delete('geo_fencing', array('id' => $fencing_id));
		return;
	}

	function get_fencing_by_id($fencing_id) {
		$sql = "SELECT id, title, ST_AsText(fencing_polygon) as fencing_polygon, register_date from geo_fencing where id = {$fencing_id}";
		$query = $this->db->query($sql);
		$fencing = $query->row_array();

		if ($fencing) {
			$polygon_str = $fencing['fencing_polygon'];

			$polygon_data = array();
			$polygon_str = substr($polygon_str, 9, -2);
			$polygons = explode(',', $polygon_str);
			// delete last polygon
			unset($polygons[count($polygons) - 1]);

			foreach($polygons as $polygon) {
				$latlng_tokens = explode(' ', $polygon);
				$polygon_data[] = array(
					'lat' => floatval($latlng_tokens[1]), 'lng' => floatval($latlng_tokens[0])
				);
			}

			unset($fencing['fencing_polygon']);

			$fencing['polygon'] = $polygon_data;
		}

		return $fencing;
	}

	public function get_stats_ss($criteria) {
		$sql = "select count(*) as total_count, sum(distance) as total_distance from test_result_info where type = 0 ";
		if (@$criteria['user_id']) {
			$sql .= " AND user_id = {$criteria['user_id']} ";
		}
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function get_stats_ss_blackspot($criteria) {
		$sql = "select count(*) as total_count, sum(distance) as total_distance from test_result_info where type = 0 and ss_val <= 3 ";
		if (@$criteria['user_id']) {
			$sql .= " AND user_id = {$criteria['user_id']} ";
		}
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	public function get_stats_npt($criteria) {
		$sql = "select count(*) as total_count from test_result_info where type = 1 ";
		if (@$criteria['user_id']) {
			$sql .= " AND user_id = {$criteria['user_id']} ";
		}
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function get_home_stats() {
	    $stats = array();
	    for ($i = 0; $i < 3; $i++) {
            $sql = "select count(*) as total_count from test_result_info where type = {$i}";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            $stats[] = $result['total_count'];
        }
	    return $stats;
    }

	public function knn_line($marker_list, $criteria) {

		$clusterer = new Geo\Clusterer(
		// your viewport: in this case an approximation of bounding box around Belgium

			new Geo\Bounds(
				new Geo\Coordinate(-9.0882278, 168.2249543),
				new Geo\Coordinate(-55.3228175, 72.2460938)
			)

		);

// create a matrix of about 12 cells (this may differ from 12, depending on
// the exact measurements of the bounding box)
		$clusterer->setNumberOfClusters(12);

// start clustering after 2 locations in the same cell
		$clusterer->setMinClusterLocations(2);

		$clusterer->setSaveCoordinates(true);

// add locations to clusterer

		foreach ($marker_list as $marker) {
		    $ss_val = $marker['ss_val'];
		    if ($ss_val < 0)
		        $ss_val = 0;
		    if ($marker['is_lte']) {
		        if ($ss_val > 63) $ss_val = 63;
            } else { // GSM
                if ($ss_val > 31) $ss_val = 31;

                $ss_val = $ss_val * 2;
            }
			$clusterer->addCoordinate(new Geo\Coordinate($marker['lat_point'], $marker['long_point'],
				array('carrier' => $marker['carrier'], 'ss_val' => $ss_val, 'distance' => $marker['distance'])));
		}

		$cluster_info = $clusterer->getClusters();

		$cluster_data = array();

		$stats_data = array();

		$blackspot_max_ss_val = 3;

		$stats_data['total_count'] = 0;
		$stats_data['total_distance'] = 0;
		$stats_data['total_blackspot_count'] = 0;
		$stats_data['total_blackspot_distance'] = 0;

		$stats_data['carrier_distance'] = array();
		for($i = 0; $i <= 7; $i++) {
			$stats_data['carrier_distance'][$i] = 0;
		}
		$total_distances = 0;

		foreach ($cluster_info as $each_cluster) {
			$new_data = array(
				'center' => $each_cluster->center,
			);

			if ($criteria['blackspot'] == 0) {
				$ss_val = 0;
				$distance = 0;
				foreach ($each_cluster->coordinates as $coordinate) {
					$ss_val += floatval($coordinate->data['ss_val']);
					$distance += floatval($coordinate->data['distance']);
				}
				$ss_val = $ss_val / $each_cluster->total;

				$new_data['ss_val'] = $ss_val;

				$stats_data['total_count']++;
				$stats_data['total_distance']+=$distance;
				if ($ss_val <= $blackspot_max_ss_val) {
					$stats_data['total_blackspot_count']++;
					$stats_data['total_blackspot_distance']+=$distance;
				}

			} else {
				$each_stats = array(
					0 => array('count' => 0, 'ss_val' => 0), // telstra
					1 => array('count' => 0, 'ss_val' => 0), // voda
					2 => array('count' => 0, 'ss_val' => 0), // optus
					3 => array('count' => 0, 'ss_val' => 0), // other
				);
				$distance = 0;
				foreach ($each_cluster->coordinates as $coordinate) {
					$carrier_id = $this->get_carrier_id($coordinate->data['carrier']);
					$carrier_stat = $each_stats[$carrier_id];
					$carrier_stat['count']++;
					$carrier_stat['ss_val']+= $coordinate->data['ss_val'];
					$each_stats[$carrier_id] = $carrier_stat;
					$distance += floatval($coordinate->data['distance']);
					$total_distances+= floatval($coordinate->data['distance']);
				}

				$new_data['telstra_ss'] = $each_stats[0]['count']?$each_stats[0]['ss_val']/$each_stats[0]['count']:0;
				$new_data['vodafone_ss'] = $each_stats[1]['count']?$each_stats[1]['ss_val']/$each_stats[1]['count']:0;
				$new_data['optus_ss'] = $each_stats[2]['count']?$each_stats[2]['ss_val']/$each_stats[2]['count']:0;
				// $new_data['other_ss'] = $each_stats[3]['count']?$each_stats[3]['ss_val']/$each_stats[3]['count']:0;

				$telstra_flag = ($new_data['telstra_ss'] > $blackspot_max_ss_val)?1:0;
				$vodafone_flag = ($new_data['vodafone_ss'] > $blackspot_max_ss_val)?1:0;
				$optus_flag = ($new_data['optus_ss'] > $blackspot_max_ss_val)?1:0;

				$stats_data['carrier_distance'][($telstra_flag << 2) + ($vodafone_flag << 1) + $optus_flag] += $distance;
			}

			$cluster_data[] = $new_data;
		}

		// stats
		$stats_list = array();
		if ($criteria['blackspot'] == 0) {
			$stats_list[] = array(
				'title' => 'Number of Signal Strength markers',
				'text' => number_format($stats_data['total_count'])
			);
			$stats_list[] = array(
				'title' => 'Number of black spot markers',
				'text' => number_format($stats_data['total_blackspot_count'])
			);
			$stats_list[] = array(
				'title' => 'Total distance tested',
				'text' => number_format($stats_data['total_distance'] / 1000, 2).'klms'
			);
			$stats_list[] = array(
				'title' => 'Klms of black spots',
				'text' => number_format($stats_data['total_blackspot_distance'] / 1000, 2).'klms'
			);
		} else {
			$titles = array(
				'Black - no signal for Telstra, Optus and Vodafone',
				'Purple - Telstra and Vodafone have no signal - Optus has signal',
				'Green - Telstra and Optus have no signal - Vodafone has signal',
				'Blue - No Telstra signal - Optus and Vodafone have signal',
				'Orange - Optus and Vodafone have no signal - Telstra has signal',
				'Red - No Vodafone signal - Telstra and Optus have signal',
				'Yellow - No Optus signal - Telstra and Vodafone have signal',
				'White - coverage from all three carriers'
			);
			if ($total_distances > 0) {
				$carrier_distances = 0;

				foreach ($stats_data['carrier_distance'] as $idx => $distance) {
					$carrier_distances+=$distance;
					$stats_list[] = array(
						'title' => $titles[$idx],
						'klms' => number_format($distance / 1000, 2),
						'percent' => number_format(($distance * 100 / $total_distances), 2),
					);
				}

				$stats_list[] = array(
					'title' => 'Total',
					'klms' => number_format($carrier_distances / 1000, 2),
					'percent' => number_format($carrier_distances * 100 / $total_distances, 2),
				);
			}
		}

		return array('dots' => $cluster_data, 'stats' => $stats_list);
	}

	public function get_carrier_id($carrier) {
		if (stripos($carrier, 'elstra') !== false) {
			return 0;
		} else if (stripos($carrier, 'odafone') !== false) {
			return 1;
		} else if (stripos($carrier, 'amaysim') !== false || stripos($carrier, 'optus') !== false) {
			return 2;
		}
		return 3; //
	}
}
