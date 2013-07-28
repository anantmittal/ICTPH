
<div class="blue_left"><div class="blue_right"><div class="blue_middle"><span class="head_box">Physical Exams</span></div></div></div>
    
    <div class="blue_body" style="padding:10px;">
      <table>
	<tr>
	  <td>
	    <table width="100%">
	      <thead>
		<tr>
		  <th>Ab</th>
		  <th>No</th>
		  <th>NA</th>
		  <th/>
		    <th/>
	    </tr>
	  </thead>
	  
	  <tbody>
	    <?php /**/;
	    $i = 0;
	    foreach ($physical_exam_list as $physical_exam) {
	    $i++;
	    // TODO -- Get clean_name out of the picture below. Use the field name as
	    // div / span IDs too
	    $name = $physical_exam->name();
	    $clean_name = $displayer->remove_whitespace($name);
	    ?>
	    
	    <tr class="gridrow">
	      <input type="hidden" name="physical_exam[<?php echo $i; ?>][test]" value="<?php echo $physical_exam->name(); ?>">
	      
	      <td class="gridcell"><input type="radio" name="physical_exam[<?php echo $i; ?>][status]" value="Abnormal" display="horizontal" onClick=javascript:$(<?php echo '"#'.$clean_name.'"';?>).show(); id="<?php echo $clean_name.'_top_Abnormal'; ?>">
	      </td>
	      <!-- TODO - make Normal case like disabled, not hidden -->
	      <td class="gridcell"><input type="radio" name="physical_exam[<?php echo $i; ?>][status]" value="Normal" display="horizontal" onClick=javascript:$(<?php echo '"#'.$clean_name.'"';?>).hide(); id="<?php echo $clean_name.'_top_Normal'; ?>"></td>
	      <td class="gridcell"><input type="radio" name="physical_exam[<?php echo $i; ?>][status]" value="NA" display="horizontal" onClick=javascript:$(<?php echo '"#'.$clean_name.'"';?>).hide(); id="<?php echo $clean_name.'_top_NA'; ?>"></td>
	      
	      <td class="gridcell">
		<?php echo $physical_exam->name(); ?>
	      </td>
	      
	      <td class="gridcell">
		<?php $displayer->display_node($physical_exam->details(), $clean_name, "physical_exam[".$i."][details]"); ?>
				
	      </td>
	    </tr>
	    
	    <?php /**/;
	    } ?>
	    
	  </tbody>
	</table>
      </td>
    </tr>
	<?php
		if(isset($visit_obj))
		{ ?>
    			<script  type="text/javascript">
			$(document).ready(function() {
			<?php foreach($visit_pes as $pes_row)
			{
    				$clean_name = $displayer->remove_whitespace($pes_row->test);
			?>
				document.getElementById(<?php echo '"'.$clean_name.'_top_'.$pes_row->status.'"';?>).click();
			<?php } ?>
				})
				</script>
		<?php } ?>
      </tbody>
      </table>
  
    </div>

   <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    <br/>

