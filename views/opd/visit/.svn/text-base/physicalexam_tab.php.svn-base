<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/visit/physicalexam_tab.js"; ?>"></script>


<script type="text/javascript">
$(document).ready(function(){
	$("#height_cm").change(function(){
	  var wt = $('#weight_kg').val();
	  var ht_mt = $('#height_cm').val()/100;
	  var bmi_cal = Math.round(wt/(ht_mt*ht_mt)*100)/100;
	  $("#bmi").text(bmi_cal);
	  $("#bmi").val(bmi_cal);
	});

	$("#weight_kg").change(function(){
	  var wt = $('#weight_kg').val();
	  var ht_mt = $('#height_cm').val()/100;
	  var bmi_cal = Math.round(wt/(ht_mt*ht_mt)*100)/100;
	  $("#bmi").text(bmi_cal);
	  $("#bmi").val(bmi_cal);
	});

	$("#hip_cm").change(function(){
	  var wst = $('#waist_cm').val();
	  var hip = $('#hip_cm').val();
	  var whr_cal = Math.round(wst*100/hip)/100;
	  $("#whr").text(whr_cal);
	  $("#whr").val(whr_cal);
	});

	$("#waist_cm").change(function(){
	  var wst = $('#waist_cm').val();
	  var hip = $('#hip_cm').val();
	  var whr_cal = Math.round(wst*100/hip)/100;
	  $("#whr").text(whr_cal);
	  $("#whr").val(whr_cal);
	});


	$('#pregnant_y').click(function(){
		$('#waist_cm').val('');
		$('#hip_cm').val('');
		$('#wh_row').hide();			
	});
	//$('#pregnant_y').click(); Removed to prevent empty values for hip and waist text boxes after pisp

	$('#pregnant_n').click(function(){
		$('#wh_row').show();
	});
	$('#pregnant_n').click();
		
		var hew = "<?php echo $hew_login;?>";
		if(hew){
			$('#physical_start').hide();
		}	
		var person_age ="<?php echo $person_age; ?>";
		
		
		if(person_age > <?php echo $infant_threshold_age ;?>)
			$('#infant_row').hide();
		if(person_age < <?php echo $wh_threshold_age ;?>)
			$('#wh_row').hide();
		if(person_age < <?php echo $bp_threshold_age ;?>)
			$('#bp_row').hide();			
		
		if(person_age < <?php echo $vision_threshold_age ;?>){
			$('#vision_block').hide();
			$('#vision_heading').hide();
			$('#vision_end').hide();
		}

		var gender = "<?php echo $person->gender ; ?>" ;
		if(gender == "F" && person_age > <?php echo $pregnant_threshold_age ;?> )
			$('#pregnancy_row').show();
		else
			$('#pregnancy_row').hide();

		
		
		var isPregnant = "<?php if(isset($is_pregnant)) echo $is_pregnant; else echo ""?>";		
		if(isPregnant == 1){
			$('#pregnant_y').attr('checked' , true);
			$('#pregnant_y').click();
		}

});
</script>
<?php
	if(isset($pisp))
	{
		$respiratory_rate = $pisp->getRespiratoryRate();
		$systole = $pisp->getBpSystolic();
		$diastole = $pisp->getBpDiastolic();
		$wc = $pisp->getWaist();
		$hip = $pisp->getHip();
		$weight = $pisp->getWeight();
		$height = $pisp->getHeight();
		$muac = $pisp->getUpperArm();
		$head = $pisp->getHead();
		$temp = $pisp->getTemperature();
		$pulse = $pisp->getPulse();		
		$vision_exam_consent = $pisp->getVisionExamConsent();
		
		$via_vili_consent = $pisp->getViaViliConsent();	
		
		$va_distance_r = $pisp->getVisionRight();
		$va_distance_l = $pisp->getVisionLeft();
		$va_near = $pisp->getNearVision();
		$va_cataract = $pisp->getCataract();
	}
	if(isset($vision_within_6_months) && isset($vision_within_6_months->va_distance_r))
	{
		$va_distance_r = $vision_within_6_months->va_distance_r;
		$va_distance_l = $vision_within_6_months->va_distance_l;
		$va_near = $vision_within_6_months->va_near;
		$va_cataract = $vision_within_6_months->va_cataract;
		$wc = $vital_within_6_months->waist_cm;
		$hip = $vital_within_6_months->hip_cm;
	}
	if (isset($person_height))
	$height = $person_height;
?>
<?php if(!isset($visit_pes)){?>
<div class="blue_left">
  <div class="blue_right"><div class="blue_middle"><span class="head_box">Vital Signs</span></div></div>
</div>
<div class="blue_body" style="padding:10px;">

  <table>
    <tr>
      <td>Temperature (F)</td>
      <td><input name="temperature_f" id="temperature_f" type="text" value="<?php if(isset($temp) && $temp!=0)echo $temp;?>" size="5"/></td>
      <td>Pulse</td>
      <td><input name="pulse" id="pulse" type="text" value="<?php if(isset($pulse) && $pulse!=0)echo $pulse;?>" size="5"/> </td>
      <td>Respiratory Rate</td>
      <td><input name="respiratory_rate" id="respiratory_rate" type="text" value="<?php if(isset($respiratory_rate) && $respiratory_rate!=0)echo $respiratory_rate;?>" size="5"/></td>
    </tr>

     <tr id="pregnancy_row">
      <td>Currently Pregnant:</td>
      <td><input type="radio" name="pregnant" value="Y" id="pregnant_y" >Yes</input></td>
      <td><input type="radio" name="pregnant" value="N" id="pregnant_n" >No</input></td>
     </tr>
        
    <tr id="bp_row">
      <td colspan="2"><b><u>Blood Pressure</u></b></td>
      <td>Systolic</td>
      <td><input name="bp_systolic" id="bp_systolic" type="text" value="<?php if(isset($systole))echo $systole;?>" size="5"/></td>
      <td>Diastolic</td>
      <td><input name="bp_diastolic" id="bp_diastolic" type="text" value="<?php if(isset($diastole))echo $diastole;?>" size="5"/></td>
    </tr>
    
    <tr>
<!--  <td><input id="get_bmi" type="button" class="submit" value="Get BMI"></input></td>-->
      <td><b><u>BMI</u></b></td>
      <td id="bmi" ></td>
      <td>Weight(kg)</td>
      <td><input name="weight_kg" id="weight_kg" type="text" value="<?php if(isset($weight))echo $weight;?>"size="5"/></td>
      <td>Height(cm)</td>
      <td><input name="height_cm" id="height_cm" type="text" value="<?php if(isset($height))echo $height;?>" size="5"/></td>
    </tr>

    <tr id="wh_row">
<!--  <td><input id="get_whr" type="button" class="submit" value="Get W/H Ratio"></input></td>-->
      <td><b><u>W/H Ratio</u></b></td>
      <td id="whr"></td>
      <td>Waist(cm)</td>
      <td><input name="waist_cm" id="waist_cm" type="text" value="<?php if(isset($wc))echo $wc;?>" size="5"/></td>
      <td>Hip(cm)</td>
      <td><input name="hip_cm" id="hip_cm" type="text" value="<?php if(isset($hip))echo $hip;?>" size="5"/></td>
    </tr>

    <tr id="infant_row">
<!--  Row for Head and Upper Arm Circumference (Only for infants)-->
      <td><b><u>Infant Measurements</u></b></td>
      <td id="v_infant"></td>
      <td>Head(cm)</td>
      <td><input name="head_circumference_cm" id="head_circumference_cm" type="text" value="<?php if(isset($head))echo $head;?>" size="5"/></td>
      <td>Upper Arm(cm)</td>
      <td><input name="arm_circumference_cm" id="arm_circumference_cm" type="text" value="<?php if(isset($muac))echo $muac;?>" size="5"/></td>
    </tr>

  </table>
</div>

<div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
<br/>
<?php if(!$hew_login) {?>
<!-- Start of Auscultation section -->
<div class="blue_left" id="ausculation_heading">
  <div class="blue_right"><div class="blue_middle"><span class="head_box">Auscultation</span></div></div>
</div>
<div class="blue_body" style="padding:10px;" width="100%" id="ausculation_block">
	<table width="100%">
		<tr>
			<td width="30%" valign = "top">Heart Sounds</td>
			<td><table>
				<tr><td> S1 :
					<input type="radio" name="heart_s1" value="1"> Yes
					<input type="radio" name="heart_s1" value="0"> No </td></tr>
				<tr><td>S2 :
					<input type="radio" name="heart_s2" value="1"> Yes
					<input type="radio" name="heart_s2" value="0"> No </td></tr>
				<tr><td>Murmurs (if any):<input type="text" id="heart_murmur" name="heart_murmur" /><br /></td></tr>
			</table></td>
		</tr>
	</table>
	<br/>
	<table width="100%">
		<tr>
			<td width="30%" valign = "top">Lung Sounds</td>
			<td><table>
				<tr><td>NVBS</td><td><input type="radio" name="lung_nvbs" value="1" > Yes
					<input type="radio" name="lung_nvbs" value="0" > No </td></tr>
				<tr><td>Wheeze</td><td><input type="radio" name="lung_wheeze" value="1"> Yes
					<input type="radio" name="lung_wheeze" value="0"> No </td></tr>
				<tr><td>Crackle</td><td><input type="radio" name="lung_crackle" value="1"> Yes
					<input type="radio" name="lung_crackle" value="0"> No </td></tr>
				<tr><td>Stridor</td><td><input type="radio" name="lung_stridor" value="1"> Yes
					<input type="radio" name="lung_stridor" value="0"> No </td></tr>
				<tr><td>Pleural Rub</td><td><input type="radio" name="lung_pleural_rub" value="1"> Yes
					<input type="radio" name="lung_pleural_rub" value="0"> No </td></tr>
			</table></td>
		</tr>
	</table>
</div>
<div class="bluebtm_left" id ="end_ausculation"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
<br/>

<!-- End of Auscultation section -->
<?php }?>
<!-- Start of Vision section -->

<div class="blue_left" id="vision_heading">
  <div class="blue_right"><div class="blue_middle"><span class="head_box">Vision</span></div></div>
</div>
<div class="blue_body" style="padding:10px;" width="100%" id="vision_block">
	<table width="100%">
		<tr>
			<td>Distance (Right) Measured by HEW</td><td><select name="va_distance_r" id="va_distance_r" >
				<?php
					$vals = array(0=>'Not Measured', 1=>'&lt;6/60' , 2=>'6/60', 3=>'6/24',4=>'6/12',5=>'6/6');
					foreach($vals as $k=>$v)
					{
						$adjunct = '';
						if(isset($va_distance_r))
						{
							if($va_distance_r == $k)
								$adjunct='selected ="selected" ';
						}
						echo '<option value="'.$k.'" '.$adjunct.'>'.$v.'</option>';
					}
				?>
			</select></td>
		</tr>
		<tr>
			<td>Distance (Left) Measured by HEW </td><td><select name="va_distance_l" id="va_distance_l" >
				<?php
					$vals = array(0=>'Not Measured', 1=>'&lt;6/60' , 2=>'6/60', 3=>'6/24',4=>'6/12',5=>'6/6');
					foreach($vals as $k=>$v)
					{
						$adjunct = '';
						if(isset($va_distance_l))
						{
							if($va_distance_l == $k)
								$adjunct='selected ="selected" ';
						}
						echo '<option value="'.$k.'" '.$adjunct.'>'.$v.'</option>';
					}
				?>
			</select></td>
		</tr>

		<tr> <td>Near vision Measured by HEW</td><td><select name="va_near" id="va_near" >
				<?php
					$vals = array(0=>'Not Measured', 1=>'Good' , 2=>'&lt;+1.0', 3=>'&lt;+2.0',4=>'&lt;+3.0',5=>'&gt;+3.0');
					foreach($vals as $k=>$v)
					{
						$adjunct = '';
						if(isset($va_near))
						{
							if($va_near == $k)
								$adjunct='selected ="selected" ';
						}
						echo '<option value="'.$k.'" '.$adjunct.'>'.$v.'</option>';
					}
				?>
		
		</select></td></tr>

		<tr> <td>Cataract</td><td><select name="va_cataract" id="va_cataract" >
				<?php
					$vals = array(0=>'Not Measured', 1=>'Yes' , 2=>'No');
					foreach($vals as $k=>$v)
					{
						$adjunct = '';
						if(isset($va_cataract))
						{
							if($va_cataract == $k)
								$adjunct='selected ="selected" ';
						}
						echo '<option value="'.$k.'" '.$adjunct.'>'.$v.'</option>';
					}
				?>
		</select></td></tr>
		<tr> 
			<td><b>Do you want your eye power to be checked by the Physician ?</b>
			</td>
			<td>&nbsp &nbsp<input name="vision_exam_consent"
						type="checkbox" value="y"
						<?php if(isset($vision_exam_consent)) 
						{ if($vision_exam_consent == 'y') { echo "checked";} }
													
							?>><b> YES </b>
			</td>
		</tr>
	</table>
</div>
<div class="bluebtm_left" id="vision_end"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>

<br/>

<!-- End of Vision section -->

<!-- Start of Vision Prescription section -->
<?php if(!$hew_login) {?>
<div class="blue_left" id="vision_heading">
  <div class="blue_right"><div class="blue_middle"><span class="head_box">Vision Prescription</span></div></div>
</div>
<div class="blue_body" style="padding:10px;" width="100%" id="vision_block">
	<table>
		
		
	    <tr>
	     	 <td><b>Distance Vision </b></td>
	      
	    </tr>
	
	     <tr>
		     <td></td>
		      <td>Spherical</td>
		      <td>Cylindrical</td>
		      <td>Axial</td>
		      <td>Visual Acuity</td>
	     </tr>
	        
	    <tr >
		      <td>Right Eye</td>
		      <td><input name="dist_sph_r" id="dist_sph_r" type="text" value="" size="15"/></td>
		      <td><input name="dist_cyl_r" id="dist_cyl_r" type="text" value="" size="15"/></td>
		      <td><input name="dist_axial_r" id="dist_axial_r" type="text" value="" size="15"/></td>
		      <td>
		      		<select name="dist_va_r" id="dist_va_r" >
						<?php
							$vals = array(0=>'Not Measured', 1=> '6/6', 2=>'6/12', 3=>'6/24',4=>'6/60',5=>'&lt;6/60');
							foreach($vals as $k=>$v)
							{
								$adjunct = '';
								echo '<option value="'.$k.'" '.$adjunct.'>'.$v.'</option>';
							}
						?>
					</select>
		      </td>
	    </tr>
	    
	    <tr >
		      <td>Left Eye</td>
		      <td><input name="dist_sph_l" id="dist_sph_l" type="text" value="" size="15"/></td>
		      <td><input name="dist_cyl_l" id="dist_cyl_l" type="text" value="" size="15"/></td>
		      <td><input name="dist_axial_l" id="dist_axial_l" type="text" value="" size="15"/></td>
		      <td>
		      		<select name="dist_va_l" id="dist_va_l" >
						<?php
							$vals = array(0=>'Not Measured', 1=> '6/6', 2=>'6/12', 3=>'6/24',4=>'6/60',5=>'&lt;6/60');
							foreach($vals as $k=>$v)
							{
								$adjunct = '';
								echo '<option value="'.$k.'" '.$adjunct.'>'.$v.'</option>';
							}
						?>
					</select>
		      
		      </td>
	    </tr>
	    <tr></tr>
	    <tr>
	     	 <td><b>Near Vision</b></td>
	      
	    </tr>
	
	     <tr>
		     <td></td>
		      <td>Spherical</td>
		      <td>Cylindrical</td>
		      <td>Axial</td>
		      <td>Visual Acuity(BE)</td>
	     </tr>
	        
	    <tr >
		      <td>Right Eye</td>
		      <td><input name="near_sph_r" id="near_sph_r" type="text" value="" size="15"/></td>
		      <td><input name="near_cyl_r" id="near_cyl_r" type="text" value="" size="15"/></td>
		      <td><input name="near_axial_r" id="near_axial_r" type="text" value="" size="15"/></td>
		      <td rowspan='2'>
		      		<select name="near_va" id="near_va" >
						<?php
							$vals = array(0=>'Not Measured', 1=> 'N6', 2=>'N12', 3=>'N24',4=>'N60');
							foreach($vals as $k=>$v)
							{
								$adjunct = '';
								echo '<option value="'.$k.'" '.$adjunct.'>'.$v.'</option>';
							}
						?>
					</select>
		      </td>
	    </tr>
	    
	    <tr >
		      <td>Left Eye</td>
		      <td><input name="near_sph_l" id="near_sph_l" type="text" value="" size="15"/></td>
		      <td><input name="near_cyl_l" id="near_cyl_l" type="text" value="" size="15"/></td>
		      <td><input name="near_axial_l" id="near_axial_l" type="text" value="" size="15"/></td>
		      <td>
		      		
		      
		      </td>
	    </tr>
   
  </table>

</div>
<div class="bluebtm_left" id="vision_end"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
<?php }?>
<br/>
<?php }?>
<!-- End of Vision Prescription section -->


<div id="physical_start">
<div class="blue_left" id="physical_heading"><div class="blue_right"><div class="blue_middle"><span class="head_box">Physical Exams</span></div></div></div>
    
    <div class="blue_body" style="padding:10px;" id="physical_block">
  	
    <table>
  
  	
	<tr>
	  <td>
	  	 	
		  <div class='gridcellheader'>Ab</div>
		  <div class='gridcellheader'>No</div>
		  <div class='gridcellheader'>NA</div>
	  </td>
	</tr>
	<tr>
	  <td>  
	  <?php /**/;
	  	$jt = $physical_exam_tree;
	  	$i = 0;
	  	$is_abnormal=false;
	  	$is_normal=false;
	  	$details="";
	  	$visible_elements = array();
	  	// All first level nodes will have parent Node as _head which is
	  	// equal to -1
				foreach ($physical_exam_tree->getRootParents() as $node) {
			  		$clean_name = "phy_".remove_whitespace1($node->getValue());
			  		if(isset($visit_pes)){
			  			$is_abnormal = node_exists($node->getValue(),$visit_pes);
			  			$is_normal = normal_node($node->getValue(),$visit_pes);
			  			
			  		}
			  		if($node->getParent() != -1){
			    		$clean_name = "phy_".remove_whitespace1($node->getValue())."_".$node->getParent();
			  		}
			  		$nameparser = "physical_exam[$i]";
			  		echo "<div class='gridrow'>";
			  		echo "<div>";
			  		echo "<div class='gridcell'>";
			  		$radio1 = array(
			  		    'name'        => "$nameparser"."[status]",
			  		    'id'          => "{$clean_name}_top_Ab",
			  		    'value'       => 'Abnormal',
			  		    'style'		  => 'display:horizontal',     
			  		);
			  		echo " <input type='hidden' name='{$nameparser}[test]' value='{$node->getValue()}'> ";
			  		$js1 = "onclick='javascript:$(&quot;#{$clean_name}&quot;).show(500);'";
			  		echo form_radio($radio1,'',$is_abnormal,$js1);
					if($is_abnormal){
						array_push($visible_elements,$clean_name);
					}
			  		echo "</div>";
				

			  		echo "<div class='gridcell'>";
			  		$radio2 = array (
			  			'name'        => "$nameparser"."[status]",
			  			'id'          => "{$clean_name}_top_No",
			  			'value'       => 'Normal',
			  		);
			  		echo " <input type='hidden' name='{$nameparser}[test]' value='{$node->getValue()}'> ";
			  		$js2 = "onclick='javascript:$(&quot;#{$clean_name}&quot;).hide(500);'";
			  		echo form_radio($radio2,'',$is_normal,$js2);
			  		echo "</div>";

			  		echo "<div class='gridcell'>";
			  		$radio3 = array (
			  			'name'        => "$nameparser"."[status]",
			  			'id'          => "{$clean_name}_top_NA",
			  			'value'       => 'NA',
			  		);
			  		$js3 = "onclick='javascript:$(&quot;#{$clean_name}&quot;).hide(500);'";
			  		echo form_radio($radio3,'','',$js3);
			  		echo "</div>";
			  		if(isset($visit_pes)){
			  			$details = get_child($node->getValue(),$visit_pes);
			  		}
			    	printNode($node, $physical_exam_tree,$nameparser,'',$details,$visible_elements);
			    	echo "</div><div class='clear'></div>";
			    	 $i++;
				}
				
									
			
		    function printNode ($node, $physical_exam_tree,$nameparser,$j=0,$details,$visible_elements) {
		    	$clean_name = "phy_".remove_whitespace1($node->getValue());
		    	if($node->getParent() != -1){
		    		$clean_name = "phy_".remove_whitespace1($node->getValue())."_".$node->getParent();
		    		$nameparser = $nameparser."[$j]";
		    		
		    	}
			    if($node->getType() == 'CHECKBOX' && $node->getParent() != -1){
			    	$pos = strpos($details,strtolower($node->getValue()));
			    	$is_checked = false;
				    if($pos === false) {
					 $is_checked = false;
					}
					else {
					 $is_checked = true;
					}
					$checkBox = array (
						'name'        => "{$nameparser}"."[value]",
						'value'       => "{$node->getValue()}",
						'id'          => "{$clean_name}"."_id",
					);
					
					$jsCB = "onclick='javascript:checkbox_onclick(&quot;#{$clean_name}&quot;);'";
					echo  form_checkbox($checkBox,'',$is_checked,$jsCB);
					echo ucwords($node->getValue())."<br />";
				}else if($node->getType() == 'RADIO' && $node->getParent() != -1 ){
					$radio_array = explode(",",($node->getDetails()));							
					for ($i = 0; $i < sizeof($radio_array); $i++) {
						$pos = strpos($details,strtolower($radio_array[$i]));
						
				    	$is_checked = false;
					    if($pos === false) {
						 $is_checked = false;
						}else {
						 $is_checked = true;
						}
						$radio_value = $radio_array[$i];
						$radio = array (
											'name'        => "{$nameparser}",
											'value'       => "{$radio_value}",
										);
						$jsR = "onclick='javascript:$(&quot;#{$clean_name}&quot;).show(500);'";
						echo  form_radio($radio,'',$is_checked,$jsR);
						echo ucwords($radio_value);
					}
					echo "<br />";
				}else if($node->getType() == 'SELECT' && $node->getParent() != -1 ){
					$select_array = explode(",",($node->getDetails()));
					$select_values_array = array();
					$selected_value = "";
					foreach ($select_array as $key => $value){
						$select_values_array[$value.",".$node->getValue()] = $value;
						$pos=strpos($details,$value.",".$node->getValue());	
				    	if($pos === false) {
							 //$selected_value = "";
						}else {
						 	 $selected_value = $value.",".$node->getValue();
						 	 
						}
					}

					//echo $selected_value;
					//$jsR = "onclick='javascript:$(&quot;#{$clean_name}&quot;).show();'";
					echo ucwords($node->getValue());
					echo  form_dropdown("{$nameparser}",$select_values_array,$selected_value);
					echo "<br />";
					
				}else if($node->getType() == 'TEXTBOX' && $node->getParent() != -1 ){
					$val="";
					if($details !== ''){
						$json_object = json_decode($details);
						if(isset($json_object->name)){
							$val = ucwords($json_object->name);							
						}
					}
					$text = array (
						'name'        => "{$nameparser}",
						'size'        => '20',
					    'value'		  => "$val",
					);
					echo ucwords($node->getValue());
					echo  form_input($text,$val);
					echo "<br />";
				}else if($node->getType() == 'TEXT' && $node->getParent() != -1 ){
					echo  form_label(ucwords($node->getValue()),"{$nameparser}");
					echo "<br />";
				}else{
					echo "<div class='gridcell'>".ucwords($node->getValue())."</div></div></br>";
				}
				
		    	$children = $node->getChildren();
		    	if(!empty($children)){
		    		$j=0;
		    		if($node->getType() == 'TEXT' && $node->getParent() != -1){
		    			echo "<div class='griddropdown' id = '{$clean_name}'><span>";
		    		}else{
		    			echo "<div class='griddropdown' id = '{$clean_name}' style='display:none;'><span>";
		    		}	
		    		$child_details = "";						
		    		foreach ($children as $childUid) {
		    			$childnode = $physical_exam_tree->getNode($childUid);
		    			$child_details = get_sub_child_value($childnode,$details);
		    			//echo $child_details;
		    			printNode($childnode, $physical_exam_tree,$nameparser,$j,$child_details,$visible_elements);
		    			$j++;
		    		}
		    		echo "</span></div>";
		    	}
		   	
			}
			
			echo '<script language=javascript>';
			foreach ($visible_elements as $elements) {
				echo "$('#$elements').show(500);";
			}
			echo '</script>'
	  ?>
	  <div class="clear"></div>
     </td>
  	</tr>

  </table>
  	<?php
	
		function node_exists($value,$visit_pes){							
			$ret_val = false;
			if(isset($visit_pes)){ 
				foreach($visit_pes as $pes_row){
					if(ucwords($pes_row->test) == ucwords($value) && ucwords($pes_row->status)=='Abnormal'){
						$ret_val = true;
						break;
					}
				}
			 }
			 return $ret_val;
		}
		function normal_node($value,$visit_pes){							
			$ret_val = false;
			if(isset($visit_pes)){ 
				foreach($visit_pes as $pes_row){
					if(ucwords($pes_row->test) == ucwords($value) && ucwords($pes_row->status)=='Normal'){
						$ret_val = true;
						break;
					}
				}
			 }
			 return $ret_val;
		}
		
		function get_child($value,$visit_pes){							
			$ret_val = false;
			if(isset($visit_pes)){ 
				foreach($visit_pes as $pes_row){
					if(ucwords($pes_row->test) == ucwords($value)){
						return $pes_row->details;
					}
				}
			 }
			 return $ret_val;
		}
		
		function get_sub_child_value($value,$details){						
			$ret_val = "";
			if(empty($details)){
				return $ret_val;
			}
			$parent_json = json_decode($details);
			if(!isset($parent_json)){
				return $details;
			}
			if(isset($parent_json->children)){
				$childern_json_array = $parent_json->children;
			    for ($i = 0; $i < sizeof($childern_json_array); $i++) {
			    	$json_object = $childern_json_array[$i];
			    	if($json_object->name == '' && isset($json_object->children)){
			    		$ret_val = json_encode($childern_json_array[$i]);
			    		break;
			    	}else if($json_object->name == strtolower($value->getValue())){
			    		$ret_val = json_encode($childern_json_array[$i]);
			    		break;
			    	}else if(($value->getType() == 'RADIO' || $value->getType() == 'SELECT') 
			    				&& strpos($details,strtolower($json_object->name))){
			    		$ret_val = json_encode($childern_json_array[$i]);
			    		break;
			    	}else if($value->getType() == 'TEXTBOX'){
			    		$ret_val = json_encode($childern_json_array[$i]);
			    		break;
			    	}
			    }
			}
				return $ret_val;
		}
		 ?>
    </div>

   <div class="bluebtm_left" id ="physical_end"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    <br/>
   </div>
