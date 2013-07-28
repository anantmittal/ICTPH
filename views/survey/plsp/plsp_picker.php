<?php $this->load->view('survey/plsp/templateheader',array('title'=>'PISP Picker'));?>
<script type="text/javascript">
$(document).ready(function(){
	var hew = "<?php echo $hew_login ;?>";	
	if(hew)
		$('#go_to_visit').show();
	else
		$('#go_to_visit').hide();
		
});

</script>
<!--Main Page-->
<div id="main">

<div class="hospit_box">

<div class="green_left"><div class="green_right">
<div class="green_middle"><span class="head_box">Pisp Responses</span></div></div></div>
<div class="green_body">

<center><table border="1px" width="60%">
<tr>
	<th> ID</th><th> Date of Interview </th><th> Action</th>
</tr>
	<?php
		foreach($responses as $id =>$payload)
		{
			echo "<tr><td>".$id."</td><td>".$payload[0]."</td><td>"
	?>
<form action = "<?php echo $this->config->item('base_url').'index.php/plsp/report/query_report_by_id/'.$payload[1];?>" method="POST">
 <input type="hidden" name="indi_id" value="<?php echo $id;?>" /input>
<input type="hidden" name="form_id" value="<?php echo $payload[2];?>" /input> 

<input type="radio" name="language" value="english"> English
<input type="radio" name="language" value="tamilcode" checked> Tamil<br>
<input type="submit" value="Get Report"  /input> 
</form>
	<?php
			echo "</td></tr>";
		} 
	?>


<tr>
</tr>

</table></center>
<div style="float: right;">  <a id="go_to_visit" href="<?php echo $this->config->item('base_url').'index.php/opd/visit/add_preconsultation_visit/'.$person_id.'/'.$policy_id ?>">Add Preconsultation</a><br/> </div>
		  
<br class="spacer" /></div>
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div>
<br/>

<div class="hospit_box">

<div class="green_left"><div class="green_right">
<div class="green_middle"><span class="head_box">Available Surveys</span></div></div></div>
<div class="green_body">

<center><table border="1px" width="60%">
<tr>
	<th> Survey name </th><th> Action</th>
</tr>
	<?php
		foreach($forms as $link =>$title)
		{
			echo "<tr><td>".$title.'</td>';
			echo '<td>';
			echo '<form method="post" action="'.$link.'">';
			
			foreach($prefill as $key=>$val)
			{
				echo '<input type="hidden" name="'.$key.'" value="'.$val.'"/>';
			}
			echo '<input type="submit" value="Administer"/>';
			echo '</form>';
			echo '</td></tr>';
		} 
	?>


<tr>
</tr>

</table></center>

		  
<br class="spacer" /></div>
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
