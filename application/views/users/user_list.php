<?php $this->load->view('common/header.php'); ?>

<form action="<?php echo site_url(''); ?>" method="post" onsubmit="return check();">
<table border="0" cellpadding="0" cellspacing="0" align=center style="margin-top:50" width="1500">
	<tbody>
		<tr height="10">
			<td width="10"><img src="<?php echo site_url('images/bx_lt.gif'); ?>"></td>
			<td width="880" background="<?php echo site_url('images/bx_t.gif'); ?>"></td>
			<td width="10"><img src="<?php echo site_url('images/bx_rt.gif'); ?>"></td>
		</tr>
		<tr>
			<td background="<?php echo site_url('images/bx_l.gif'); ?>"></td>
			<td bgcolor="#ffffff" style="padding-bottom: 10px;">
				<table align="center" cellpadding="5" cellspacing="1" width="1400">
					<tbody>
						<tr height=50>
							<td>
								<b>User List (Count : <?php echo $this->pagination->total_rows;?>) </b>
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
											<col width="3%">
											<col width="27%">
											<col width="25%">
											<col width="25%">
											<col width="20%">
										</colgroup>
										<tr align="center">
											<th>No</th>
											<th>Email</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Reg. Date</th>
										</tr>
										<?php
											$i = 0;
											foreach($user_list as $user) :
												$i++;
										?>
										<tr>
											<td align="center"><?php echo $i; ?></td>
											<td align="center"><?php echo $user['email']; ?></td>
											<td align="center"><?php echo $user['first_name']; ?></td>
											<td align="center"><?php echo $user['last_name']; ?></td>
											<td align="center"><?php echo $user['reg_date']; ?></td>
										</tr>
										<?php endforeach; ?>
										<tr class="tr_padding">
											<td colspan="5" align="center">&nbsp;</td>
										</tr>
										<tr class="tr_padding">
											<td colspan="5" align="center">
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