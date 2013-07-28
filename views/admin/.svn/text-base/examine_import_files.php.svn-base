<?php $this->load->view('common/templateheader',array('title'=>'Examining import files'));?>
<div id="main">
<div class="hospit_box">

<div class="green_left"><div class="green_right">
<div class="green_middle"><span class="head_box">Import - Step 2 of 3</span></div></div></div>
<div class="green_body">
<form method="POST" action="<?php echo $target;?>">
<input type="hidden" name="hfilepath" value="<?php echo $hfilepath;?>">
<input type="hidden" name="ifilepath" value="<?php echo $ifilepath;?>">
<input type="hidden" name="taluka_id" value="<?php echo $taluka_id;?>">
<input type="hidden" name="rmhc_code" value="<?php echo $rmhc_code;?>">
<center><table border="1px" width="60%">
<tr><td colspan="2"><h4>Result of the examining the import files</h4></td></tr>
<tr><td>
	Attempting to create these households<?php echo " (".count($hhmap).")";?>
</td>
<td>

	<?php
		if(isset($hhmap))
		{ 
			foreach($hhmap as $h=>$i)
			{
				echo $h.", ";
			}
		}
	?>
</td>
</tr>
<tr><td>
	Individuals with no associated households <?php echo " (".count($orphan_individuals).")";?>
</td>
<td>
	<?php 
		if(isset($orphan_individuals))
		{ 
			foreach($orphan_individuals as $p)
			{
				echo $p.", ";
			}
		}
	?>
</td>
</tr>

<tr><td>
	Households mentioned in the persons file but not present in the household file <?php echo " (".count($missing_hh).")";?>
</td>
<td>
	<?php 
		if(isset($missing_hh))
		{ 
			foreach($missing_hh as $p)
			{
				echo $p.", ";
			}
		}
	?>
</td>
</tr>

<tr><td colspan="2">
	<input type="submit" value="Create households">
	</td>
</tr>
	
</table></center>
</form>

</div>
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
</div>
</div>
<?php $this->load->view('common/footer.php'); ?>
