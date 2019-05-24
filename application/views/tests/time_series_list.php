<?php $this->load->view('common/header.php'); ?>

<form action="<?php echo site_url(''); ?>" method="post" onsubmit="return check();">
<table border="0" cellpadding="0" cellspacing="0" align=center style="margin-top:50" width="1650">
	<tbody>
		<tr height="10">
			<td width="10"><img src="<?php echo site_url('images/bx_lt.gif'); ?>"></td>
			<td width="880" background="<?php echo site_url('images/bx_t.gif'); ?>"></td>
			<td width="10"><img src="<?php echo site_url('images/bx_rt.gif'); ?>"></td>
		</tr>
		<tr>
			<td background="<?php echo site_url('images/bx_l.gif'); ?>"></td>
			<td bgcolor="#ffffff" style="padding-bottom: 10px;">
				<table align="center" cellpadding="5" cellspacing="1" width="1600">
					<tbody>
						<tr height=50>
							<td>
								<b>Time Series (Count : <?php echo $this->pagination->total_rows;?>) </b>
							</td>
						</tr>
						<tr>
							<td height="1" background="<?php echo site_url('images/dot.gif'); ?>"></td>
						</tr>
						<tr>
							<td style="padding: 2px;">
								<table align="left" width="100%" class="list_table">
									<tbody>
										<colgroup>
											<col width="2%">
											<col width="12%">
											<col width="15%">
											<col width="15%">
											<col width="20%">
											<col width="22%">
											<col width="14%">
										</colgroup>
										<tr align="center">
											<th>No</th>
											<th>User</th>
											<th>Basic Info</th>
											<th>Location</th>
											<th>Test Result</th>
											<th>Average</th>
											<th>Date</th>
										</tr>
										<?php
											$i = 0;
											foreach($test_list as $test) :
												$json = json_decode($test['test_result'], true);
												$i++;
										?>
										<tr>
											<td align="center"><?php echo $i; ?></td>
											<td align="center"><?php echo $test['user_email']; ?></td>
											<td align="left">
												<p>Access Mode : <b><?php echo $json['bIsMobile'] ? "Mobile" : "WiFi"; ?></b></p>
												<p>Place : <b><?php echo $json['strPlace']; ?></b></p>
												<p>Carrier : <b><?php echo $json['strCarrier']; ?></b></p>
												<p>Device : <b><?php echo $json['strDevice']; ?></b></p>
												<p>Comment : <b><?php echo $json['strComments']; ?></b></p>
											</td>
											<td align="left">
												<a href="<?php echo 'http://maps.google.com/maps?q='.$json['nLatitude'].','.$json['nLongitude']; ?>" target="_blank">
													<p>Latitude : <b><?php echo $json['nLatitude']; ?></b></p>
													<p>Longitude : <b><?php echo $json['nLongitude']; ?></b></p>
													<p>Altitude : <b><?php echo $json['nAltitude']; ?></b></p>
												</a>
											</td>
											<td align="left">
												<p>Latency (ms) : <b><?php echo $json['nLatency']; ?> ms</b></p>
												<p>Download (raw) : <b><?php echo number_format((float)$json['nDownloadRate'], 2, '.', ''); ?> bit/s</b></p>
												<p>Download (Mbps) : <b><?php echo number_format((float)($json['nDownloadRate'] / 1000 / 1000), 2, '.', ''); ?> Mbps</b></p>
												<p>Upload (raw) : <b><?php echo number_format((float)$json['nUploadRate'], 2, '.', ''); ?> bit/s</b></p>
												<p>Upload (Mbps) : <b><?php echo number_format((float)($json['nUploadRate'] / 1000 / 1000), 2, '.', ''); ?> Mbps</b></p>
											</td>
											<td align="left">
												<p>Ping (ms) : <b><?php echo $json['strAvgPings']; ?></b></p>
												<p>Download (Mbps) : <b><?php echo $json['strAvgDownloadRates']; ?></b></p>
												<p>Upload (Mbps) : <b><?php echo $json['strAvgUploadRates']; ?></b></p>
											</td>
											<td align="left">
												<p>Start At :</p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $json['strDateTime']; ?></b></p>
												<p>End At :</p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $json['strEndDateTime']; ?></b></p>
												<p>Uploaded At :</p>
												<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $json['strDateTime']; ?></b></p>
											</td>
										</tr>
										<?php endforeach; ?>
										<tr class="tr_padding">
											<td colspan="6" align="center">&nbsp;</td>
										</tr>
										<tr class="tr_padding">
											<td colspan="6" align="center">
												<?php echo $this->pagination->create_links(); ?>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td height="5" bgcolor="#FFFFFF"></td>
						</tr>
					</tbody>
				</table>
			</td>
			<td background="<?php echo site_url('images/bx_r.gif'); ?>"></td>
		</tr>
		<tr height="10">
			<td><img src="<?php echo site_url('images/bx_lb.gif'); ?>" border="0"></td>
			<td background="<?php echo site_url('images/bx_b.gif'); ?>"></td>
			<td><img src="<?php echo site_url('images/bx_rb.gif'); ?>" border="0"></td>
		</tr>
	</tbody>
</table>
</form>

<?php $this->load->view('common/footer.php'); ?>