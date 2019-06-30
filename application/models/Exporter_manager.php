<?php
/**
 * Created by IntelliJ IDEA.
 * User: xiong
 * Date: 2019/6/11
 * Time: 5:42 PM
 */


class Exporter_manager extends CI_Model {


	var  $gradeColorDatas = [
	'#000000',
	'#554012',
	'#aa7f23',
	'#ffbf35',
	'#ffffff',
	'#ffffff',
	'#ffffff',
	'#ffffff',
	'#aaec9d',
	'#55df4e',
	'#00d200',
	'#009155',
	'#004faa',
	'#000eff',
	'#000eff',
	'#000eff',
	];
	var $colorDatas = array(
	'000000',
	'0c0003',
	'180005',
	'240008',
	'31000b',
	'3d000d',
	'490010',
	'550013',
	'610015',
	'6d0018',
	'79001b',
	'86001d',
	'920020',
	'9e0023',
	'aa0025',
	'b60028',
	'c2002b',
	'ce002d',
	'db0030',
	'e70033',
	'f30035',
	'ff0038',
	'f4070e',
	'e9091a',
	'de0c26',
	'd30f32',
	'c8113e',
	'bd144a',
	'b21756',
	'a71962',
	'9c1c6e',
	'911f7a',
	'862187',
	'7b2493',
	'70279f',
	'6529ab',
	'5a2cb7',
	'4f2fc3',
	'4431cf',
	'3934db',
	'2e37e7',
	'2339f3',
	'183cff',
	'101bff',
	'0f26f5',
	'0e31eb',
	'0e3ce1',
	'0d46d7',
	'0c51cd',
	'0b5cc4',
	'0b67ba',
	'0a72b0',
	'097da6',
	'08889c',
	'089292',
	'079d88',
	'06a87e',
	'05b374',
	'05be6a',
	'04c961',
	'03d457',
	'02de4d',
	'02e943',
	'01f439',
	'00ff2f',
	);


	var $blackspotColors = [[['000000', '800080'], ['008000', '0000ff']], [['FFA500', 'ff0000'], ['FFFF00', 'ffffff']]];

	public function getKMLBasicDescription($test_result) {
		return "<![CDATA[<table width=400><tr><td><strong>MST Data</strong><hr/>".
			"Access Mode : " . ($test_result['bIsMobile'] ? "Mobile" : "WiFi") . "<br/>".
			"Place : " . $test_result['strPlace'] . "<br/>".
			"Carrier : " . $test_result['strCarrier'] . "<br/>".
			"Device : " . $test_result['strDevice'] . "<br/>";
	}

	public function strength_kml($result, $knn_result,
								 $kmlOption = array('type' => 0, 'blackspot' => 0) ,
								 $options = array()) {
		$this->load->model('test_manager');

		$marker_list_data = $result;
		$stats_data = $knn_result['stats'];
		// write xml header
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo '<kml xmlns="http://earth.google.com/kml/2.0"> <Document>';

		$previousItem = null;
		$previousPoint = null;
		$type = $kmlOption['type'];

		// if ($type >= 1) {
		$this->writeIconHeader($type);
		// }

		// echo "<Folder><name>Markers</name>";

		foreach($marker_list_data as $marker_data) {
			$test_result = json_decode($marker_data['test_result'], true);
			if ($type == 0) {
				$sb = "";
				$sb .= "<Placemark>";
				$sb .= "<name />";
				$sb .= "<description>";
				$sb .= $this->getKMLBasicDescription($test_result);
				if ($test_result['bIsMobile']) {
					$sb .= "<br/>Signal<br/>" .
						// "isLte : {$test_result['bIsLte']} <br/>".
						"GSM SS (0-31) : {$test_result['nGsmSS']} <br/>".
						"GSM SS (dBm) : {$test_result['nGsmDbm']}<br/>".
						"LTE SS (0-64) : {$test_result['nLteSS']}<br/>".
						"LTE SS (dBm) : {$test_result['nLteDbm']} <br/>";
				} else {
					$sb .= "<br/>Network<br/>" .
						"Strength (0-31) : {$test_result['nWifiSS']} <br/>".
						"IP : {$test_result['strIP']}<br/>".
						"MAC : {$test_result['strMAC']}<br/>".
						"SSID : {$test_result['strSSID']} <br/>".
						"Link Speed : {$test_result['strLinkSpeed']} <br/>";
				}
				$sb .= "<br/>Comments : {$test_result['strComments']}  <br/>Tested At : {$test_result['strDateTime']}";

				$sb .= "</td></tr></table>]]></description>";
				$sb .= "<styleUrl>";
				$signalLevel = 0;
				if ($test_result['bIsMobile']) {
					$signalLevel = $marker_data['ss_val'];

					if ($test_result['bIsLte']) {
						// $signalLevel = $test_result['nLteSS'];
						if ($signalLevel > 63) {
							$signalLevel = 63;
						} else if ($signalLevel < 0) {
							$signalLevel = 0;
						}
					} else {
						// $signalLevel = $test_result['nGsmSS'];
						if ($signalLevel > 31) {
							$signalLevel = 31;
						} else if ($signalLevel < 0) {
							$signalLevel = 0;
						}
					}

				} else {
					$signalLevel = $test_result['nWifiSS'];
				}

				$isLte = false;
				if ($test_result['bIsLte']) {
					$isLte = true;
				}
				$carrier_type = $this->test_manager->get_carrier_id($marker_data['carrier']);
				$kmlSignalLevel = ($isLte? 1000:0) + $carrier_type * 100 + $signalLevel;

				$sb .= "#signalLevel{$kmlSignalLevel}";
				$sb .= "</styleUrl>";
				$sb .= "<Point>";
				$sb .= "<coordinates>";
				$sb .= "{$test_result['nLongitude']},{$test_result['nLatitude']},{$test_result['nAltitude']}";
				$sb .= "</coordinates>";
				$sb .= "</Point>";
				$sb .= "</Placemark>";
				echo $sb;
			} else {
				echo $this->getKMLNetworkPerformDescription($type, $test_result, 1);
				echo $this->getKMLNetworkPerformDescription($type, $test_result, 0);
				echo $this->getKMLNetworkPerformDescription($type, $test_result, -1);
			}
		}
		// echo "</Folder>";
		/*
		foreach($marker_data as $item) {

			$test_result = json_decode($item['test_result'], true);
			$point = array(
				'lat' => $test_result['nLatitude'],
				'lng' => $test_result['nLongitude'],
			);

			$storePrevious = true;

			if ($type >= 1) {
				if ($type == 1)
					$nLatency = $this->getPingGrade($test_result['nLatency']);
				else
					$nLatency = $test_result['nLatency'];
				echo "<Placemark><name /><description><![CDATA[111]]></description><styleUrl>#signalLevel{$nLatency}</styleUrl><Point><coordinates>{$point['lng']},{$point['lat']},0.</coordinates></Point></Placemark>";

				continue;
			}

			if ($previousPoint) {

				$isConnectable = false;
				$diff_distance = $this->point_distance_kilometer($previousPoint, $point);

				if ($type == 0) {
					if ($item['batch_no'] > 0 && $item['batch_no'] == $previousItem['batch_no']) { // same batch no
						if ($diff_distance < 0.5) {
							$isConnectable = true;
						} else {
							$storePrevious = false;
						}
					} else if ($item['batch_no'] == 0 && $diff_distance < 0.1) {
						$isConnectable = true;
					}
				}

				if ($isConnectable) {
					$connLineOption = $lineOption;
					$connLineOption['color'] = $this->getLineColor($previousItem, $item, $kmlOption);
					$this->connect_point_strength_kml($previousPoint, $point, $connLineOption);
				}
			}

			if ($storePrevious) {
				$previousItem = $item;
				$previousPoint = $point;
			}
		}
		*/


		// write footer
		echo '</Document> </kml>';
	}

	public function strength_kml_name($criteria) {
		$file_str = 'KML';
		$type_str = 'UNKNOWN';
		switch ($criteria['type']) {
			case 0: $type_str = 'SS'; break;
			case 1: $type_str = 'NPT'; break;
			case 2: $type_str = 'TST'; break;
			case 3: $type_str = 'ETS'; break;
			case 4: $type_str = 'ext TS'; break;
			default: break;
		}

		$comm_type = 'ALL';
		if (array_key_exists('is_lte', $criteria)) {
			if ($criteria['is_lte']) {
				$comm_type = 'LTE';
			} else {
				$comm_type = 'GSM';
			}
		}

		$carrier = 'ALL';
		if (array_key_exists('carrier', $criteria)) {
			$carrier_id = $this->test_manager->get_carrier_id($criteria['carrier']);
			if ($carrier_id == 0) {
				$carrier = 'Tel';
			} else if ($carrier_id == 1) {
				$carrier = 'Vod';
			} else if ($carrier_id == 2) {
				$carrier = 'Opt';
			}
		}

		return "{$file_str}_{$type_str}_{$comm_type}_{$carrier}_{$criteria['start_date']}_{$criteria['end_date']}.kml";
	}

	private function getKMLNetworkPerformDescription($type, $test_info, $nOffset) {
		$sb = '';
		$sb .= '<Placemark>';
		$sb .= '<name />';
		$sb .= '<description>';
		$sb .= $this->getKMLBasicDescription($test_info);
		$sb .= "<br />Test Result<br />" .
			"Latency : " . number_format($test_info['nLatency']) . ' ms <br />'.
			'Download (raw) : ' . number_format($test_info['nDownloadRate']) . ' bit/s <br />'.
			'Download (Mbps) : ' . number_format($test_info['nDownloadRate'] / (1024 * 1024), 2) . ' Mbps <br />'.
			'Upload (raw) : ' . number_format($test_info['nUploadRate']) . ' bit/s <br />'.
			'Upload (Mbps) : ' . number_format($test_info['nUploadRate'] / (1024 * 1024), 2) . ' Mbps <br />';

		if ($type == 2 || $type == 3) {
			$sb .= '<br />Average<br />'.
				'Ping (ms) : ' . $test_info['strAvgPings'] . '<br />'.
				'Download (Mbps) : ' . $test_info['strAvgDownloadRates'] . '<br />'.
				'Upload (Mbps) : ' . $test_info['strAvgUploadRates']. '<br />';
		}
		$sb .= '<br />Comments : '.$test_info['strComments'];
		if ($type == 2 || $type == 3) {
			$sb .= '<br />Start : ' . $test_info['strDateTime'];
			$sb .= '<br />End : ' . $test_info['strEndDateTime'];
		} else {
			$sb .= '<br />Tested At : '.$test_info['strDateTime'];
		}

		$sb .= '</td></tr></table>]]></description>';
		$sb .= '<styleUrl>';
		if ($nOffset == 1) {
			$sb .= '#signalLevel'. $this->getPingGrade($test_info['nLatency']);
		} else if ($nOffset == -1) {
			$sb .= '#signalLevel'. $this->getUploadGrade($test_info['nUploadRate']);
		} else {
			$sb .= '#signalLevel'. $this->getDownloadGrade($test_info['nDownloadRate']);
		}
		$sb .= '</styleUrl>';
		$sb .= '<Point>';
		$sb .= '<coordinates>';
		$sb .= (floatval($test_info['nLongitude']) + 0.0001 * $nOffset) . ',' . $test_info['nLatitude'].','.$test_info['nAltitude'];
		$sb .= '</coordinates>';
		$sb .= '</Point>';
		$sb .= '</Placemark>';
		return $sb;
	}

	private function getPingGrade($latency) {
		$nGrade = 0;
		if ($latency <= 0) {
			$nGrade = 0;
		} else if ($latency >= 2000) {
			$nGrade = 1;
		} else if ($latency >= 1500) {
			$nGrade = 2;
		} else if ($latency >= 1200) {
			$nGrade = 3;
		} else if ($latency >= 1000) {
			$nGrade = 4;
		} else if ($latency >= 800) {
			$nGrade = 5;
		} else if ($latency >= 600) {
			$nGrade = 6;
		} else if ($latency >= 500) {
			$nGrade = 7;
		} else if ($latency >= 300) {
			$nGrade = 8;
		} else if ($latency >= 200) {
			$nGrade = 9;
		} else if ($latency >= 100) {
			$nGrade = 10;
		} else if ($latency >= 75) {
			$nGrade = 11;
		} else if ($latency >= 50) {
			$nGrade = 12;
		} else if ($latency >= 30) {
			$nGrade = 13;
		} else if ($latency >= 20) {
			$nGrade = 14;
		} else {
			$nGrade = 15;
		}
		return $nGrade;
	}

	public function getUploadGrade($nUploadRate) {
		$nUploadMbps = $nUploadRate / 1024 / 1024;
		$nGrade = 0;
		if ($nUploadMbps <= 0)
			$nGrade = 0;
		else if ($nUploadMbps < 0.25)
			$nGrade = 1;
		else if ($nUploadMbps < 0.50)
			$nGrade = 2;
		else if ($nUploadMbps < 0.75)
			$nGrade = 3;
		else if ($nUploadMbps < 1)
			$nGrade = 4;
		else if ($nUploadMbps < 2)
			$nGrade = 5;
		else if ($nUploadMbps < 2.5)
			$nGrade = 6;
		else if ($nUploadMbps < 5)
			$nGrade = 7;
		else if ($nUploadMbps < 7.5)
			$nGrade = 8;
		else if ($nUploadMbps < 10)
			$nGrade = 9;
		else if ($nUploadMbps < 15)
			$nGrade = 10;
		else if ($nUploadMbps < 20)
			$nGrade = 11;
		else if ($nUploadMbps < 30)
			$nGrade = 12;
		else if ($nUploadMbps < 40)
			$nGrade = 13;
		else if ($nUploadMbps < 50)
			$nGrade = 14;
		else
			$nGrade = 15;
		return $nGrade;
	}

	public function getDownloadGrade($nDownloadRate) {
		$nDownloadMbps = $nDownloadRate / 1024 / 1024;	// Mbps unit
		$nGrade = 0;
		if ($nDownloadMbps <= 0)
			$nGrade = 0;
		else if ($nDownloadMbps < 0.25)
			$nGrade = 1;
		else if ($nDownloadMbps < 0.50)
			$nGrade = 2;
		else if ($nDownloadMbps < 1)
			$nGrade = 3;
		else if ($nDownloadMbps < 2)
			$nGrade = 4;
		else if ($nDownloadMbps < 3)
			$nGrade = 5;
		else if ($nDownloadMbps < 4)
			$nGrade = 6;
		else if ($nDownloadMbps < 5)
			$nGrade = 7;
		else if ($nDownloadMbps < 10)
			$nGrade = 8;
		else if ($nDownloadMbps < 20)
			$nGrade = 9;
		else if ($nDownloadMbps < 50)
			$nGrade = 10;
		else if ($nDownloadMbps < 75)
			$nGrade = 11;
		else if ($nDownloadMbps < 100)
			$nGrade = 12;
		else if ($nDownloadMbps < 125)
			$nGrade = 13;
		else if ($nDownloadMbps < 150)
			$nGrade = 14;
		else
			$nGrade = 15;
		return $nGrade;
	}
	private function getStrengthColor($strength) {
		if ($strength == 0) {
			$r = 0;
			$g = 0;
			$b = 0;
		} else if ($strength <= 10) {
			$r = intval(255 * ($strength / 10.0));
			$g = 0;
			$b = 0;
		} else if ($strength <= 20) {
			$r = 0;
			$g = 0;
			$b = intval(255 * (($strength - 10) / 10.0));
		} else {
			$r = 0;
			$g = intval (255 * (($strength - 20) / 11));
			$b = 0;
		}

		$r += 70;
		$g += 70;
		$b += 70;

		if ($r > 255) $r = 255;
		if ($g > 255) $g = 255;
		if ($b > 255) $b = 255;

		$pinColor = sprintf("%02x%02x%02x", $r, $g, $b);

		if (($r + $g + $b) > 110 * 3 && $g > $r && $g > $b) {
			$textColor = "000000";
		} else {
			$textColor = "FFFFFF";
		}
		return array('pinColor' => $pinColor, 'textColor' => $textColor);
	}
	private function writeIconHeader($type) {
		if ($type == 0 || $type == 1) {
			$sb = "";
			for ($i = 0; $i < 64; $i++) {

				if ($type == 0) {
					$telecomStringList = array('gsm', 'lte');
					for ($k = 0; $k < 2; $k++) { // $k = 0 is gsm, $k = 1 is lte
						$separator = '';
						if ($k == 1) {
							$separator = '_';
						}

						$carrierColorStringList = array("blue", "red", "yellow");
						for ($j = 0; $j < 3; $j++) {

							$pinIndex = $k * 1000 + $j * 100 + $i;
							// $pinURL = "http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|{$pinIndex}|{$pinColor}|{$textColor}|{$starColorString}";
							$pinURL = "http://degconsult.com.au/GoMobile2/images/pins/pin_{$telecomStringList[$k]}_{$carrierColorStringList[$j]}{$separator}{$i}.png";
							$sb .= "<Style id=\"signalLevel{$pinIndex}\">";
							$sb .= "<IconStyle>";
							$sb .= "<Icon>";
							$sb .= "<href>";
							$sb .= $pinURL;
							$sb .= "</href>";
							$sb .= "</Icon>";
							$sb .= "</IconStyle>";
							$sb .= "<BalloonStyle><text>$[description]</text></BalloonStyle>";
							$sb .= "</Style>";
						}
					}
					echo $sb;
				} else {
					$strengthColorInfo = $this->getStrengthColor($i);

					$pinColor = $strengthColorInfo['pinColor'];
					$textColor = $strengthColorInfo['textColor'];
					$starColorStringList = array("0000FF", "FF0000", "FFFF00");
					for ($j = 0; $j < 3; $j++) {
						$starColorString = $starColorStringList[$j];
						$pinIndex = $j * 100 + $i;
						$pinURL = "http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|{$pinIndex}|{$pinColor}|{$textColor}|{$starColorString}";
						// $pinURL = "http://degconsult.com.au/GoMobile2/images/pins/pin_{$telecomStringList[$k]}_{$carrierColorStringList[$j]}{$separator}{$i}.png";
						$sb .= "<Style id=\"signalLevel{$pinIndex}\">";
						$sb .= "<IconStyle>";
						$sb .= "<Icon>";
						$sb .= "<href>";
						$sb .= $pinURL;
						$sb .= "</href>";
						$sb .= "</Icon>";
						$sb .= "</IconStyle>";
						$sb .= "<BalloonStyle><text>$[description]</text></BalloonStyle>";
						$sb .= "</Style>";
					}
				}

			}
		} else {
			echo
			'<Style id="signalLevel0"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|0|464646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel1"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|1|5F4646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel2"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|2|794646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel3"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|3|924646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel4"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|4|AC4646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel5"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|5|C54646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel6"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|6|DF4646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel7"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|7|F84646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel8"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|8|FF4646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel9"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|9|FF4646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel10"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|10|FF4646|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel11"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|11|46465F|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel12"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|12|464679|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel13"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|13|464692|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel14"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|14|4646AC|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel15"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|15|4646C5|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel16"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|16|4646DF|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel17"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|17|4646F8|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel18"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|18|4646FF|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel19"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|19|4646FF|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel20"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|20|4646FF|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel21"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|21|465D46|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel22"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|22|467446|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel23"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|23|468B46|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel24"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|24|46A246|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel25"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|25|46B946|FFFFFF|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel26"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|26|46D146|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel27"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|27|46E846|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel28"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|28|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel29"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|29|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel30"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|30|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel31"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|31|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel32"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|32|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel33"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|33|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel34"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|34|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel35"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|35|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel36"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|36|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel37"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|37|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel38"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|38|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel39"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|39|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel40"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|40|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel41"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|41|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel42"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|42|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel43"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|43|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel44"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|44|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel45"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|45|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel46"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|46|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel47"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|47|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel48"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|48|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel49"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|49|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel50"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|50|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel51"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|51|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel52"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|52|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel53"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|53|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel54"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|54|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel55"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|55|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel56"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|56|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel57"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|57|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel58"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|58|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel59"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|59|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel60"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|60|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel61"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|61|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel62"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|62|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style><Style id="signalLevel63"><IconStyle><Icon><href>http://www.google.com/chart?chst=d_map_xpin_letter&amp;chld=pin_star|63|46FF46|000000|0000FF</href></Icon></IconStyle><BalloonStyle><text>$[description]</text></BalloonStyle></Style>';
		}
	}

	private function getLineColor($prevItem, $currItem, $kmlOption) {
		$type = $kmlOption['type'];
		$blackspot = $kmlOption['blackspot'];
		if ($type == 0) {
			if ($blackspot > 0) {
				$telstra_flag = 1;
				if ($prevItem['telstra_ss'] <= 3) {
					$telstra_flag = 0;
				}
				$vodafone_flag = 1;
				if ($prevItem['vodafone_ss'] <= 3) {
					$vodafone_flag = 0;
				}
				$optus_flag = 1;
				if ($prevItem['optus_ss'] <= 3) {
					$optus_flag = 0;
				}

				echo 'here';
        		return $this->blackspotColors[$telstra_flag][$vodafone_flag][$optus_flag];
      		} else {
				$prevSSVal = $prevItem['ss_val'];
				$nextSSVal = $currItem['ss_val'];
				$colorStep = floor((floatval($prevSSVal) + floatval($nextSSVal)) / 2);
				if ($colorStep < 0) {
					$colorStep = 0;
				} else if ($colorStep > 63) {
					$colorStep = 63;
				}
				// echo "---$colorStep---";
        		return $this->colorDatas[$colorStep];
      		}
		} else if ($type == 1 || $type == 2 || $type == 3) {
			$prevTestResultData = json_decode($prevItem['test_result'], true);
			$nextTestResultData = json_decode($currItem['test_result'], true);

			$prevGrade = $this->getItemGrade($prevTestResultData);
			$nextGrade = $this->getItemGrade($nextTestResultData);

			$avgGrade = floor(($prevGrade + $nextGrade) / 2);

			return $this->gradeColorDatas[$avgGrade];
		}
	}

	private function getItemGrade($resultData) {
		return 1;
	}
	private function getKMLColor($htmlColor) {
		return substr($htmlColor, 4, 2).substr($htmlColor, 2, 2).substr($htmlColor, 0, 2);
	}

	public function connect_point_strength_kml($prevPt, $currPt, $strokeOption =
		array('stroke' => 8, 'transparency' => 0.8, 'color' => '#9e0023')) {

		$transVal = dechex(floor($strokeOption['transparency'] * 255));
		$transVal = str_pad($transVal, 2, "0", STR_PAD_LEFT);

		$colorVal = $transVal.$this->getKMLColor($strokeOption['color']);

		// echo $colorVal;
		echo "<Placemark>";
		echo "<LineString>";
        echo "    <coordinates>".PHP_EOL;
		echo "{$prevPt['lng']},{$prevPt['lat']},0".PHP_EOL;
		echo "{$currPt['lng']},{$currPt['lat']},0".PHP_EOL;
		echo "</coordinates>";
        // echo "    <altitudeMode>absolute</altitudeMode>";
        echo "</LineString>";
        echo "<Style>";
        echo "    <LineStyle>";
        echo "        <color>{$colorVal}</color>";
        echo "        <width>{$strokeOption['stroke']}</width>";
        echo "    </LineStyle>";
        echo "</Style>";
    	echo "</Placemark>";

		return;

	}

	private function point_distance_kilometer($prevPt, $currPt) {
		return $this->vincentyGreatCircleDistance($prevPt['lat'], $prevPt['lng'], $currPt['lat'], $currPt['lng']) / 1000.0;
	}

	/**
	 * https://stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php
	 *
	 * Calculates the great-circle distance between two points, with
	 * the Vincenty formula.
	 * @param float $latitudeFrom Latitude of start point in [deg decimal]
	 * @param float $longitudeFrom Longitude of start point in [deg decimal]
	 * @param float $latitudeTo Latitude of target point in [deg decimal]
	 * @param float $longitudeTo Longitude of target point in [deg decimal]
	 * @param float $earthRadius Mean earth radius in [m]
	 * @return float Distance between points in [m] (same as earthRadius)
	 */
	public  function vincentyGreatCircleDistance(
		$latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$lonDelta = $lonTo - $lonFrom;
		$a = pow(cos($latTo) * sin($lonDelta), 2) +
			pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		$angle = atan2(sqrt($a), $b);
		return $angle * $earthRadius;
	}
}
