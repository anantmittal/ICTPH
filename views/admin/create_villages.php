<?php $this->load->view('common/templateheader',array('title'=>'Create Villages'));?>
<div id="main">
<div class="hospit_box">

<div class="green_left"><div class="green_right">
<div class="green_middle"><span class="head_box">Create Villages - Step 1 of 3</span></div></div></div>
<div class="green_body">
<form method="POST" action="<?php echo $target;?>">
<input type="hidden" name="hfilepath" value="<?php echo $hfilepath;?>">
<input type="hidden" name="ifilepath" value="<?php echo $ifilepath;?>">
<input type="hidden" name="s_taluka" value="<?php echo $taluka_id;?>">
<input type="hidden" name="rmhc_code" value="<?php echo $rmhc_code;?>">
<center><table border="1px" width="60%">
<tr><td colspan="2"><h4>Villages in the import set</h4></td></tr>
<tr><td>
	Villages already present
</td>
<td>

	<?php
		if(isset($present))
		{ 
			foreach($present as $present_village)
			{
				echo $present_village."<br/>";
			}
		}
	?>
</td>
</tr>
<tr><td>
	Villages to be created
</td>
<td>
	<?php 
		if(isset($new))
		{ 
			foreach($new as $new_village)
			{
				echo $new_village."<br/>";
			}
		}
	?>
</td>
</tr>
	<td colspan="2">
	<input type="submit" value="Create villages and proceed">
	</td>
<tr>
</table></center>
</form>

</div>
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
</div>
</div>
<?php $this->load->view('common/footer.php'); ?>
