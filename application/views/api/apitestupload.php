<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>GoMobile File Uploader Test</title>

		<meta name="Generator" content="EditPlus" />
		<meta name="Author" content="" />
		<meta name="Keywords" content="" />
		<meta name="Description" content="" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<script type="text/javascript" src="<?php echo base_url('/javascript/jquery-1.6.4.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('/javascript/json2.js'); ?>"></script>
	</head>

	<style type="text/css">
		* {font-size: 15px;}
	</style>   

	<body>
 		<div id="left" style="float: left;width: 350px" >
   			<ul>
   			</ul>
		</div>

		<div style="float: left">
			Add Video<br/>
 	 		<?php echo form_open_multipart('/api/addVideo'); ?>
			Upload Video : <?php echo form_upload(VIDEO_FIELD); ?> <br />
			DIR : <?php echo form_input('dir', VIDEO_DIR, "required class='intext'"); ?> <br />
			File Name : <?php echo form_input('file_name', "test.mp4", "required class='intext'"); ?> <br />
			Field : <?php echo form_input('field', VIDEO_FIELD, "required class='intext'"); ?> <br />
			<?php echo form_submit('upload', "Upload Image", "class='gray_btn'"); ?>
			<?php echo form_close(); ?>		
		</div>
	</body>
</html>
