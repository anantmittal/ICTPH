<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/visit/lab_tab.js"; ?>"></script>
<!-- Strip tests section Starts -->
    <script>
    var barcode_url="<?php echo $this->config->item('base_url').'index.php/opd/visit/check_duplicate_barcode/' ;?>"


    </script>
    <div class="blue_left">
      <div class="blue_right"><div class="blue_middle"><span class="head_box">Tests and Procedures Conducted</span></div></div>
    </div>
    <div class="blue_body" style="padding:10px;">
      <table>
	<thead>
	  <tr>
	    <th>Done</th>
	    <th>N/A</th>
	    <th/><th/>
	  </tr>
	</thead>

	<tbody>
	  <?php $i = 0;
	  foreach ($test_types as $t) {
	  if($t->type =='Strip' || $t->type=='Procedure')
	  {
	    $i++;
	    $name = $t->name;
	    $clean_name = $displayer->remove_whitespace($name);

	  ?>

	  <tr>
	    <td>
	      <input type="radio" id="tests_<?php echo $i; ?>_status_done" name="tests[<?php echo $i; ?>][status]" value="Done" onClick='javascript:$(<?php echo '"#'.$clean_name.'"';?>).show();javascript:$(tests_<?php echo $i; ?>_result).focus();'>
	    </td>
	    <td>
	      <input type="radio" id="tests_<?php echo $i; ?>_status_na" name="tests[<?php echo $i; ?>][status]" value="NA" onClick='javascript:$(<?php echo '"#'.$clean_name.'"';?>).hide(); javascript:$(<?php echo '"#tests_'.$i.'_error"';?>).hide();' >
	     </td>
	     
	    <td>
	      <?php echo $name; ?>
	      <input type="hidden" id="tests_<?php echo $i; ?>_id" name="tests[<?php echo $i; ?>][test_type_id]" value="<?php echo $t->id; ?>">
	      <input type="hidden" id="tests_<?php echo $i; ?>_name" name="tests[<?php echo $i; ?>][name]" value="<?php echo $name; ?>">
	      <input type="hidden" id="tests_<?php echo $i; ?>_index" name="tests[<?php echo $i; ?>][index]" value="<?php echo $i;?>">
	      <input type="hidden" id="tests_<?php echo $i; ?>_cost" name="tests[<?php echo $i; ?>][cost]" value="<?php echo $t->cost; ?>">
	     
	    </td>
		
	    <td>
	      <span id="<?php echo $clean_name; ?>" style="display: none;">
		<?php if ($t->result_type == 'Boolean') { ?>
		<input type="radio" id="tests_<?php echo $i; ?>_result" name="tests[<?php echo $i; ?>][result]" value="Positive" checked="checked">Positive
		<input type="radio" id="tests_<?php echo $i; ?>_result" name="tests[<?php echo $i; ?>][result]" value="Negative">Negative
		<input type="hidden" id="tests_<?php echo $i; ?>_test_type" name="tests_type" value="radio"/>
		<?php } ?>
		<?php if ($t->result_type == 'Number') { ?>
		<div style="float:left"><input type="text" id="tests_<?php echo $i; ?>_result" name="tests[<?php echo $i; ?>][result]" onChange='check_text(<?php echo $i; ?>)' onblur="check_text(<?php echo $i; ?>)"></div><div style="float:left"><label class="error" id="tests_<?php echo $i;?>_error" style="display:none"> Values Required  </label></div>
		<?php } ?>

	      </span>

	    </td>
	  </tr>
	  <?php }
	  } ?>
	    <input type="hidden" id="tests_number" name="tests_number" value="<?php echo $i;?>"/>
	</tbody>
      </table>
    </div>

    <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>

<!-- Strip tests section Ends -->

<!-- Sample Collection section Starts -->
    <div class="blue_left">
      <div class="blue_right"><div class="blue_middle"><span class="head_box">Samples collected</span></div></div>
    </div>
    

    <div class="blue_body" style="padding:10px;">
      <table border=1>
	  <tr>
	    <td><b>SN</b></td>
	    <td><b>Bar Code ID</b></td>
	    <td><b>Location to send to</b></td>
	  </tr>
<? 
	for ($j=0; $j < 5; $j++)
	{ ?>
	<tr>
	  <td> <?php echo ($j+1).'.';?>
	  </td>
	  <td>
		<input type="text" id="barcode_<?php echo $j;?>" name="barcode_<?php echo $j;?>" onChange='check_duplicate_barcode(<?php echo $j; ?>)' />
	  </td>
	  <td>
	  <?php $js = " id=location_".$j." onChange=check_duplicate_barcode('".$j."')";?>
		<?php echo form_dropdown('location_'.$j,$labs,'',$js); ?>
	  </td>
         </tr>
	  <tr>
	  </tr>
	  <tr>
	  </tr>
	<?php } ?>
	<input type="hidden" id="bar_code_number" name="bar_code_number" value="<?php echo $j;?>"/>
      </table>
<br> <br>
 <b>Select Parameters to be Tested</b>
      <table>
		<thead>
	  	<tr>
	    		<th>Yes</th>
	    		<th>No</th>
	    		<th>Parameter Name<th/>
	  	</tr>
		</thead>
		<tbody>
		<input type="hidden" id="test_start_number" name="test_start_number" value="<?php echo $i+1;?>"/>
	 	<?php
	  	foreach ($test_types as $t) {
	  	if($t->type !='Strip' && $t->type!='Procedure')
	  	{
	    		$i++;
	    		$name = $t->name;
	    		$clean_name = $displayer->remove_whitespace($name);

	  	?>
		<tr>
	    	<td>
	      		<input type="radio" id="tests_<?php echo $i; ?>_status_done" name="tests[<?php echo $i; ?>][status]" value="Done" >
	    	</td>
	    	<td>
	      		<input type="radio" id="tests_<?php echo $i; ?>_status_na" name="tests[<?php echo $i; ?>][status]" value="NA" >
	     	</td>
	     
	    	<td>
	      		<?php echo $name; ?>
	      <input type="hidden" id="tests_<?php echo $i; ?>_id" name="tests[<?php echo $i; ?>][test_type_id]" value="<?php echo $t->id; ?>">
	      <input type="hidden" id="tests_<?php echo $i; ?>_name" name="tests[<?php echo $i; ?>][name]" value="<?php echo $name; ?>">
	      <input type="hidden" id="tests_<?php echo $i; ?>_index" name="tests[<?php echo $i; ?>][index]" value="<?php echo $i;?>">
	      <input type="hidden" id="tests_<?php echo $i; ?>_cost" name="tests[<?php echo $i; ?>][cost]" value="<?php echo $t->cost; ?>">
	    	</td>
		
	    	<td>
	      		<span id="<?php echo $clean_name; ?>" style="display: none;">
	      		</span>

	    	</td>
	  	</tr>
	  <?php }
	  } ?>
		<input type="hidden" id="test_end_number" name="test_end_number" value="<?php echo $i;?>"/>
	</tbody>
	</table>
	  <?php //		      foreach ($test_types as $t) {
		//		if($t->type !='Strip') {
				?>
<!--				<input name="sample_<?php echo $j;?>[]" TYPE="CHECKBOX" VALUE="<?php echo $t->id;?>"><?php echo $t->name;?><BR>-->
	  		<?php // }} ?>
    </div>

    <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>

<!-- Sample Collection section Ends-->

