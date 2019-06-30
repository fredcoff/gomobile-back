<?php $this->load->view('common/header.php'); ?>
<form action="<?php echo site_url('admin/do_modify_admin'); ?>" method="post" onsubmit="return check();">
<table border="0" cellpadding="0" cellspacing="0" align=center style="margin-top:20; margin-bottom:30;" width="900">
	<tbody>
		<tr height="10">
			<td width="10"><img src="<?php echo base_url('images/bx_lt.gif'); ?>" border="0"></td>
			<td width="780" background="<?php echo base_url('images/bx_t.gif'); ?>"></td>
			<td width="10"><img src="<?php echo base_url('images/bx_rt.gif'); ?>" border="0"></td>
		</tr>
		<tr>
			<td background="<?php echo base_url('images/bx_l.gif'); ?>"></td>
			<td bgcolor="#ffffff" style="padding-top: 10px; padding-bottom: 10px;">
				<table align="center" cellpadding="5" cellspacing="1" width="900" border=0>
					<tbody>
						<tr>
							<td><b>Admin Info</b></td>
						</tr>
						<tr>
							<td height="1" background="<?php echo base_url('images/dot.gif'); ?>"></td>
						</tr>
						<tr>
							<td>
								<table style="margin-left: 100px;">
									<tr height="30px">
										<td align=right>Current Password</td>
										<td><input type=text name="curPwd" id="curPwd" /></td>
									</tr>
									<tr height="30px">
										<td align=right>New Password</td>
										<td><input type="text" name="newPwd" id="newPwd" /></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="5" bgcolor="#FFFFFF"></td>
						</tr>
						<tr>
							<td bgcolor="#ffffff">
								<input type="submit" value="Modify" style="margin-left: 335px;"/>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td background="<?php echo base_url('images/bx_r.gif'); ?>"></td>
		</tr>
		<tr height="10">
			<td><img src="<?php echo base_url('images/bx_lb.gif'); ?>" border="0">
			</td>
			<td background="<?php echo base_url('images/bx_b.gif'); ?>"></td>
			<td><img src="<?php echo base_url('images/bx_rb.gif'); ?>" border="0">
			</td>
		</tr>
	</tbody>
</table>
</form>

<script language="javascript">
<!--

	function check()
	{
		if ($('#curPwd').val() == '')
		{
			alert('Please input current admin password.');
			$('#curPwd').focus();
			return false;
		}

		if ($('#newPwd').val() == '')
		{
			alert('Please input new admin password.');
			$('#newPwd').focus();
			return false;
		}

		if (confirm("Do you want to modify admin password?") == false)
		{
			return false;
		}
		return true;
	}

//-->
</script>

<?php $this->load->view('common/footer.php'); ?>