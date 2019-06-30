<html>
<head>
<title>GoMobile</title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">

<script type="text/javascript" src="<?php echo base_url('js/jquery-latest.js'); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" title="no title">
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' type='text/css'>

<style type="text/css">
input[type=text],input[type=password], input[type=email] {
	width:99.5%;
	padding: 10px;
	margin-top: 8px;
	border: 1px solid #ccc;
	padding-left: 5px;
	font-size: 16px;
	font-family:raleway;
}

input[type=submit] {
	width: 100%;
	background-color:#ED1B2F;
	color: white;
	border: 2px solid #ED2B2F;
	padding: 10px;
	font-size:20px;
	cursor:pointer;
	border-radius: 5px;
	margin-bottom: 15px;
}

.jumbotron {
	color: white;
	position:fixed;
	overflow:hidden;
	width: 100%;
	height: 100%;
}
</style>

<script language="javascript">
	function check()
	{
		if ($('#admin_id').val() == '')
		{
			alert('Please input admin ID.');
			$('#admin_id').focus();
			return false;
		}

		if ($('#admin_password').val() == '')
		{
			alert('Please input admin password.');
			$('#admin_password').focus();
			return false;
		}

		return true;
	}

</script>

</head>

<body>
	<div class="jumbotron">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="" style="text-align: center;">
				<img align=center src="<?php echo base_url('images/logo.png'); ?>" />
				<br/><br/>
			</div>
			<div class="container">
				<div class="login-panel panel panel-success">
					<div class="panel-heading">
						<h3 style="text-align: center;"><b> Admin Login </b></h3>
					</div>
					<div class="panel-body">
						<form name=login method=post action="<?php echo site_url('login/login_do'); ?>" onSubmit="return check();">
							<?php if ($redirect_url = $this->session->flashdata('redirect_url')) { ?>
								<input type="hidden" name="redirect_url" value="<?php echo $redirect_url;?>" />
							<?php } ?>
							<?php if ($notification = $this->session->flashdata('notification')) { ?>
							<div class="alert alert-danger">
								<?php echo '<p class="statusMsg">'.$notification.'</p>'; ?>
							</div>
							<?php } ?>

							<div class="form-group has-feedback">
								<input type="text" class="form-control" name="admin_id" id="admin_id" value="" />
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="admin_password" id="admin_password" value="" />
							</div>
							<div class="form-group" align="center">
								<input type="submit" name="loginSubmit" class="btn-primary" value="Login"/>
							</div>
						</form>  
						<div class="form-group"></div> 
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>