<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<link rel="stylesheet" href="<?php echo site_url('css/common.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo site_url('css/jquery-ui.css'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo site_url('css/admin.css'); ?>" type="text/css" />
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<?php if (isset($map)) echo $map['js']; ?>
</HEAD>
<script type="text/javascript" src="<?php echo site_url('/js/jquery-latest.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/js/jquery.form.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/js/global.js'); ?>"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<title>GoMobile</title>

<body topmargin="0" leftmargin="0" bgcolor="#C3C3C3">

<table border=0 cellpadding=0 cellspacing=0 width=100%>
	<tr>
		<td height=52 background="<?php echo site_url('images/header_bg.png'); ?>"> 
			<a href="#"><img src="<?php echo site_url('images/logo2.png'); ?>" border=0></a> 
		</td>
		<td height=50 background="<?php echo site_url('images/header_bg.png'); ?>" align=right style='padding-right:20px;'>
			<font style='line-height:18px;'>
				<font style='font-size:14px;color:#FFFFFF'>ID : <b><?php echo $this->admin_manager->admin_id; ?></b></font>
				<br>
				<a href="<?php echo site_url('login/logout'); ?>" style="text-decoration: none;"><font style='font-size:14px;font-weight:bold;color:#F8BCE0'><u>Log Out</u></font></a>
			</font>
		</td>
	</tr>
</table>

<table border=0 cellpadding=0 cellspacing=0 width=100% height=28 background="<?php echo site_url('images/menu_bg.png'); ?>" >
	<tr>
		<td style='padding-left:200px;'>

			<a href="<?php echo site_url('users/user_list');?>" style="text-decoration: none;" Onmouseover="check_menu(1)"><font style='font-size:16px;font-weight:bold;color:#ffffff;'>User</font></a>
			<font style='font-size:20px;color:#f4f4ff;'>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</font>
			<a href="<?php echo site_url('tests/signal_strength_list');?>" style="text-decoration: none;" Onmouseover="check_menu(2)"><font style='font-size:16px;font-weight:bold;color:#ffffff;'>Test Result</font></a>
			<font style='font-size:20px;color:#f4f4ff;'>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</font>
			<a href="<?php echo site_url('admin/modify_admin');?>" style="text-decoration: none;" Onmouseover="check_menu(3)"><font style='font-size:16px;font-weight:bold;color:#ffffff;'>System</font></a>
		</td>
	</tr>
</table>

<div id="Out1" style='position:absolute;left:195px;top:80px;display:none;'>
	<table border=0 cellpadding="3" cellspacing="0" width="120" bgcolor=#e3ecee style='border:solid 1px #b5b5b5;' Onmouseout="check_out(1);" Onmouseover="check_over(1);">
		<tr><td height=3></td></tr>
		<tr>
			<td>
				<a href="<?php echo site_url('users/user_list');?>" style="text-decoration: none; padding-left: 10px;"><font style='font-size:12px;color:#000000;'>User List</font></a>
			</td>
		</tr>
		<tr><td height=2></td></tr>
	</table> 		
</div>

<div id="Out2" style='position:absolute;left:270px;top:80px;display:none;'>
	<table border=0 cellpadding="3" cellspacing="0" width="120" bgcolor=#e3ecee style='border:solid 1px #b5b5b5;' Onmouseout="check_out(2);" Onmouseover="check_over(2);">
		<tr><td height=3></td></tr>
		<tr>
			<td>
				<a href="<?php echo site_url('tests/signal_strength_list');?>" style="text-decoration: none; padding-left: 10px;"><font style='font-size:12px;color:#000000;'>Signal Strength</font></a>
			</td>
		</tr>
		<tr><td height=2></td></tr>
		<tr>
			<td>
				<a href="<?php echo site_url('tests/network_perform_list');?>" style="text-decoration: none; padding-left: 10px;"><font style='font-size:12px;color:#000000;'>Network Perform</font></a>
			</td>
		</tr>
		<tr><td height=2></td></tr>
		<tr>
			<td>
				<a href="<?php echo site_url('tests/time_series_list');?>" style="text-decoration: none; padding-left: 10px;"><font style='font-size:12px;color:#000000;'>Time Series</font></a>
			</td>
		</tr>
		<tr><td height=2></td></tr>
		<tr>
			<td>
				<a href="<?php echo site_url('tests/ext_npt_list');?>" style="text-decoration: none; padding-left: 10px;"><font style='font-size:12px;color:#000000;'>Ext NPT</font></a>
			</td>
		</tr>
		<tr><td height=2></td></tr>
		<tr>
			<td>
				<a href="<?php echo site_url('tests/call_drop_list');?>" style="text-decoration: none; padding-left: 10px;"><font style='font-size:12px;color:#000000;'>Call Drop</font></a>
			</td>
		</tr>
		<tr><td height=2></td></tr>
	</table> 		
</div>

<div id="Out3" style='position:absolute;left:380px;top:80px;display:none;'>
	<table border=0 cellpadding="3" cellspacing="0" width="120" bgcolor=#e3ecee style='border:solid 1px #b5b5b5;' Onmouseout="check_out(3);" Onmouseover="check_over(3);">
		<tr><td height=3></td></tr>
		<tr>
			<td>
				<a href="<?php echo site_url('admin/modify_admin');?>" style="text-decoration: none; padding-left: 10px;"><font style='font-size:12px;color:#000000;'>Modify Admin</font></a>
			</td>
		</tr>
		<tr><td height=2></td></tr>
	</table> 		
</div>

<script language="JavaScript"> 
<!--
	function check_menu(n)
	{
		for (k=1; k<=3; k++)
		{
			if (n==k)
			{
				j = eval("document.all.Out"+k);
				j.style.display = "block";
			}
			else
			{
				j = eval("document.all.Out"+k);
				j.style.display = "none";
			}
		}
	}

	function check_out(n)
	{
		j = eval("document.all.Out"+n);
		j.style.display = "none";
	}

	function check_over(n)
	{
		j=eval("document.all.Out"+n);
		j.style.display = "block";
	}
//-->
</script>

<div id="wrapper">