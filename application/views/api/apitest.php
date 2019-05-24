<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>GoMobile API</title>
  <meta name="Generator" content="EditPlus" />
  <meta name="Author" content="" />
  <meta name="Keywords" content="" />
  <meta name="Description" content="" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script type="text/javascript" src="<?php echo base_url('/js/jquery-latest.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('/js/json2.js'); ?>"></script>
 </head>

<style type="text/css">
* {font-size: 15px;}
</style>
   
<body>
<div id="left" style="float: left;width: 350px" >
	<ul>
		<li><a href="#" class="api_link" url="<?php echo site_url('/api/loginUser'); ?>" data="{'email':'test1@test.com', 'password':'test1test1'}" method="post">1. loginUser</a></li>
		<li><a href="#" class="api_link" url="<?php echo site_url('/api/registerUser'); ?>" data="{'email':'test1@test.com', 'first_name':'Test1', 'last_name':'Test1', 'password':'test1test1', 'product_id':'1', 'wifi_product_id':'1', 'activated':'1'}" method="post">2. registerUser</a></li>
	</ul>
</div>
 <div style="float: left">
	url&nbsp;&nbsp; : <input type="text" name="url" id="url" size="100" value="<?php echo site_url('/api/loginUser'); ?>" /><br />
	api key : <input type="text" id="apiKey" size="100" value="" /><br />
	data : <input type="text" name="data" id="data" size="100" value="{'email':'test1@test.com', 'password':'test1test1'}" /><br />
	<input type="radio" name="method" value="get" id="rd_get" /><label for="rd_get">get</label>
	<input type="radio" name="method" value="post" id="rd_post" checked="checked" /><label for="rd_post">post</label><br />
	result : <textarea id="result" rows="20" cols="90"></textarea><br />
	<button id="btn_send">send</button>
</div>
	<script>
	  
	  // handling returned json data
	  function success_handling(data) {
		  // alert(data);
		  if (data.apiKey) {
			  $("#apiKey").val(data.apiKey);
		  }
		  $("#result").val(JSON.stringify(data));
	  }
	  
	  // error handling for http 400 response code
	  function error_handling(xhr, ajaxOptions, thrownError) {
		  
		  alert("error");
		  
		  $("#result").val(xhr.responseText);
		 
		  /* for android tablet */
		  var errMsgObj = eval('(' + xhr.responseText + ')');
		  alert(errMsgObj.retMessage);
	  }
	  
	  // click event
	  $("#btn_send").click(function(){

		  var req_obj = null;
		  if ($("#data").val() != '')
		  {
			req_obj = eval("("+$("#data").val()+")");
		  }
		  if ($('#apiKey').val() != '')
		  {
			  req_obj.apiKey = $('#apiKey').val();
		  }
		  if ('get' == $('input[name=method]:radio:checked').val())
		  {
			  $.getJSON($("#url").val(),req_obj, success_handling).error(error_handling);
		  }
		  else
		  {
			  $.post($("#url").val(),req_obj, success_handling, "json").error(error_handling);
		  }

	  });

	  $(".api_link").each(function(i, obj){
		$(obj).click(function(){
			$("#result").val("");
			$("#url").val($(obj).attr('url'));
			$("#data").val($(obj).attr('data'));
			if ($(obj).attr('method') == "post")
			{
			  $("#rd_post").attr("checked", "checked");
			  $("#rd_get").attr("checked", "");
			}
			else
			{
			  $("#rd_get").attr("checked", "checked");
			  $("#rd_post").attr("checked", "");
			}
			return false;
		});
		
	  });

	</script>
 </body>
</html>
