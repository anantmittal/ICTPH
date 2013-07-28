<?php $this->load->view('common/templateheader',array('title'=>'Create Vouchers and ID cards'));?>
<div id="main">
<div class="hospit_box">

<div class="green_left"><div class="green_right">
<div class="green_middle"><span class="head_box">Create Voucher</span></div></div></div>
<div class="green_body">
<form enctype="multipart/form-data" method="POST">
<center><table border="1px" width="60%">
<tr><td>
	
	<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
	<b>Choose picture file</b>: (Note that the picture file should be of the aspect ratio 575x320 like <a href="<?php echo base_url();?>/assets/images/common_images/voucher.png"/>this example</a>.)</td><td> <input name="uploadedfile" type="file" /><br />
	
	
</td></tr>
<tr>
	<td>Start number:</td>
	<td><input type="text" name="start_num"/></td>
</tr>
<tr>
	<td>End number:</td>
	<td><input type="text" name="end_num"/></td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="Create Vouchers" />
</td>
</tr>
</table></center>
</form>

</div>
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
</div>
</div>
<?php $this->load->view('common/footer.php'); ?>
