</div>
<script language="javascript">
<!--
	$(document).ready(function(){
		<?php if ($notification = $this->session->flashdata('notification')):?>
		alert('<?php echo $notification;?>');
		<?php endif; ?>
		
	});
//-->
</script>
</body>

</html>