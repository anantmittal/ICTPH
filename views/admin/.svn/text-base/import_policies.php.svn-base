<?php $this->load->view('common/templateheader',array('title'=>'Policy import'));?>
<div id="main">
<div class="hospit_box">

<div class="green_left"><div class="green_right">
<div class="green_middle"><span class="head_box">Result of import - Step 3 of 3</span></div></div></div>
<div class="green_body">
<center><table border="1px" width="60%">
<tr><td colspan="2"><h4>Result of the import</h4></td></tr>
<tr><td>
	Successfully imported policies<?php echo " (".count($created_policies).")";?>
</td>
<td>

	<?php
		if(isset($created_policies))
		{ 
			foreach($created_policies as $p)
			{
				echo $p.", ";
			}
		}
	?>
</td>
</tr>
<tr><td>
	Policies not created due to unknown errors <?php echo " (".count($aborted_policies).")";?>
</td>
<td>
	<?php 
		if(isset($aborted_policies))
		{ 
			foreach($aborted_policies as $p)
			{
				echo $p.", ";
			}
		}
	?>
</td>
</tr>

<tr><td>
	Policies already existing in the database <?php echo " (".count($existing_policies).")";?>
</td>
<td>
	<?php 
		if(isset($existing_policies))
		{ 
			foreach($existing_policies as $p)
			{
				echo $p.", ";
			}
		}
	?>
</td>
</tr>

<tr><td>
	Policies not created due to missing village<?php echo " (".count($village_not_exist).")";?>
</td>
<td>
	<?php 
		if(isset($village_not_exist))
		{ 
			foreach($village_not_exist as $p)
			{
				echo $p.", ";
			}
		}
	?>
</td>
</tr>
	
</table></center>

</div>
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
</div>
</div>
<?php $this->load->view('common/footer.php'); ?>
