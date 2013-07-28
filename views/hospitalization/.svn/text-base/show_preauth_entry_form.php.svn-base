<?php $this->load->helper('form');
      $this->load->view('common/header');
      $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/pre_auth.js";?>"></script>
<!-- Body Start -->

<title>Preautherization / Reautherization Entry Form</title>
</head>
<body>

<form method="POST" name="pre_auth_entry" id="pre_auth_entry" action="">
<!--Head end-->
<!-- Body Start -->
<div id="main">
  <!--Preauth Box End-->
  <div class="hospit_box">
    	<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Preautherization / Reautherization</span></div></div></div>
          <div class="green_body">
          		<div id="left_col">
                
                    <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Policy details</span></div></div></div>
<div class="yelo_body" style="padding:8px;">

<?php 
$short_context['short_context'] = &$short_context;
$this->load->view('hospitalization/policy_context', $short_context); ?>
 
      <br class="spacer" /></div>
      <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
        
        <br />
       
                   </div>
          		<div id="right_col">
              
    
    <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">
    	   <input type="hidden" name="hospital_id" value="<?php echo $values['hospital_id'] ?>" />
    	   <?php if($action == 'reauth'){ ?>
    	     <input type="hidden" name="person_id" value="<?php echo $values['person_id'] ?>" />
    	   	<?php }?>
    	   <?php     	  
    	   if ($pre_auth_id != 0 && $action == "edit")
    	   {
    	   	echo "Edit Preautherization";
    	   }
    	   elseif ($pre_auth_id != 0 && $action == "reauth")
    	   {
    	   	echo "ReAuth Entry";
    	  	?><input type="hidden" name="preauth_form_number" value="<?php echo $values['preauth_form_number']; ?>" />
    	  <?php 
    	   }   else echo "Preautherization Entry"; 
    	 ?>
    	  </span></div></div></div>
          <div class="blue_body" style="padding: 10px;">

          <?php if ($pre_auth_id == 0 || $action == 'edit' )  { ?>
          	<div class="form_row">
              <div class="form_leftB">Preautherization Form Number</div>
              <div class="form_right">
              <input name="preauth_form_number" type="text" class="required alphanum"
    	 value="<?php echo $values['preauth_form_number'];?>" />
              </div>
            </div>
           
            <div class="form_row">
              <div class="form_leftB">Patient Name</div>
              <div class="form_right">
               <select name="person_id" id="person_id">
        <?php     
        foreach ($person_obj as $person)
        {
        	//$age = $person->age;
        	if($person->age == 0)
        	{
        		$today = date('m/d/Y');
        		$dob = date('m/d/Y',strtotime($person->date_of_birth));
        		$date_parts1=explode("/", $dob);
        		$date_parts2=explode("/", $today);
        		$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
        		$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
        		$age =round(($end_date - $start_date)/365);
        	}
        	else
        	$age = $person->age;
         ?>
        <option value="<?php echo $person->id; ?>" <?php if($person->id == $values['person_id']) echo 'selected'; ?> > <?php echo $person->full_name.', '.$person->gender.', '.$age;?> </option> 
   <?php }?>
        </select>
              </div>
            </div>

            <div class="form_row">
              <div class="form_leftB">Hospital</div>
              <div class="form_right">
                <select name="hospital_id">
               <?php $hospital = $hospital_obj->find_all_complete();               
              
               		   foreach ($hospital as $rec)
               		   {
               		   	$hospital_arr[] = $rec->get_data();
               		   }
                	   foreach ($hospital_arr as $value) { ?>
                 	   <option value="<?php echo $value['id']; ?>" <?php if($value['id'] == $values['hospital_id']) echo 'selected'; ?>><?php echo $value['name'];?> </option> <?php }?>
                </select>
              </div>
            </div>
            <?php } ?>
            
            <div class="form_row" style="margin-top: 20px;">
              <div class="form_leftB">Chief Complaint</div>
              <div class="form_right">
   
              
		  <?php 
			$chief_complaint = '';
			$selected_value = '';
			
			if(isset($values['chief_complaint'])) {
				$is_exist = array_key_exists($values['chief_complaint'], $this->config->item('chief_complaint'));

				if ($is_exist == true) {
					$selected_value = $values['chief_complaint'];
				}
				else {
					$selected_value = 'Other';					
					$chief_complaint = $values['chief_complaint'];
				}
		   }
		   else $selected_value = '';
		   
		   echo form_dropdown('chief_complaint',$this->config->item('chief_complaint'), $selected_value,'id="chief_complaint"');
		?> 
             <input name="chief_complaint_other" id="chief_complaint_other" type="chief_complaint_other" value="<?php if($chief_complaint != '') echo $chief_complaint; ?>" class="required" <?php if( $action == 'reauth' || $action == 'edit')if($chief_complaint == '') echo 'disabled'; ?>  />
              </div>
            </div>

            <div class="form_row">
              <div class="form_leftB">Detail complaints</div>
              <div class="form_right">

                <input name="detail_complaint" type="text" value="<?php  echo $values['detail_complaint'];?>" />

              </div>
            </div>
            <div class="form_row" style="height:50px">
              <div class="form_leftB">History of Present Illness</div>
              <div class="form_right">
            
              
                <textarea name="present_illness_history" cols="35" class="combo present_illness_history" id="present_illness_history"><?php echo $values['present_illness_history'];?></textarea> 
              </div> <!--<p style="float: left; margin-left:10px;">The History of present illness field is required.</p>-->
             <div id="present_illness_history_error" style="color:red;" ><label> <?php echo form_error('present_illness_history'); ?></label></div>
            </div>
            <div class="form_row">
              <div class="form_leftB">Associated Illnesses</div>
              <div class="form_right">
                <input name="associated_illness" type="text" value="<?php echo $values['associated_illness'];?>" />
              </div>
            </div>
            <div class="form_row" style="margin-top: 20px;">
              <div class="form_leftB">Current Diagnosis</div>
              <div class="form_right">
            <?php 
			/*$current_diagnosis = '';
			if(isset($values['current_diagnosis']))
			{
				$is_exist = array_key_exists($values['current_diagnosis'], $this->config->item('current_diagnosis'));

				if ($is_exist == true)
				{
					echo form_dropdown('current_diagnosis',$this->config->item('current_diagnosis'), $values['current_diagnosis'],'id="current_diagnosis"');
				}
				else
				{
					echo form_dropdown('current_diagnosis',$this->config->item('current_diagnosis'), 'Other','id="current_diagnosis"');
					$current_diagnosis = $values['current_diagnosis'];
				}
		   }
		   else
		   echo form_dropdown('current_diagnosis',$this->config->item('current_diagnosis'),'','id="current_diagnosis"');
		*/ 
			$current_diagnosis = '';
			$selected_value = '';
			
			if(isset($values['current_diagnosis']))	{
				$is_exist = array_key_exists($values['current_diagnosis'], $this->config->item('current_diagnosis'));

				if ($is_exist == true) {
					$selected_value = $values['current_diagnosis'];
				}
				else {
					$selected_value = 'Other';
					$current_diagnosis = $values['current_diagnosis'];
				}
		   }
		   else {
		   			$selected_value = '';
		   }
		   
		   echo form_dropdown('current_diagnosis',$this->config->item('current_diagnosis'), $selected_value, 'id="current_diagnosis"');
			?> 
		 &nbsp;
                <input name="current_diagnosis_other" type="text" id="current_diagnosis_other"
    	 value="<?php echo $current_diagnosis; ?>" class="required" <?php if( $action == 'reauth' || $action == 'edit')if($current_diagnosis == '') echo 'disabled'; ?>  />
              </div>	             

            </div>
            <div class="form_row">
              <div class="form_leftB">Procedure</div>
              <div class="form_right">
              
              <?php           
			$procedure = '';
			$selected_value = '';						
			if(isset($values['procedure']))	{
				$is_exist = array_key_exists($values['procedure'], $this->config->item('procedure'));

				if ($is_exist == true) {
					$selected_value = $values['procedure'];
				}
				else {
					$selected_value = 'Other';					
					$procedure = $values['procedure'];
				}
		   }
		   else {
		   			$selected_value = '';
		   }
		   echo form_dropdown('procedure',$this->config->item('procedure'), $selected_value,'id="procedure"');
		   
		?>  	 &nbsp;
                <input name="procedure_other" type="text" id="procedure_other" class="required"
              value="<?php echo $procedure; ?>"  <?php if( $action == 'reauth' || $action == 'edit') if($procedure == '') echo 'disabled'; ?> />
              </div>
            </div>
            <div class="form_row">
              <div class="form_leftB">Day Care</div>
              <div class="form_right">
               <input name="day_care" type="radio" class="radio" value="yes" <?php if( $action == 'reauth' || $action == 'edit'){ if($values['day_care'] == 'yes'){?> checked="checked" <?php }}?> />&nbsp;Yes
               <input name="day_care" type="radio" class="radio" value="no" <?php if( $action == 'reauth' || $action == 'edit'  ){ if($values['day_care'] == 'no'){?> checked="checked" <?php }} else ?>checked="checked" />&nbsp;No
              </div>
            </div>
            <div class="form_row" >
              <div class="form_leftB"><label for="expected_stay_duration">Expected duration of stay(days)</label></div>
              <div class="form_right">
              
                <input name="expected_stay_duration" type="text"  id="expected_stay_duration" class="required digits minlength"
              value="<?php if( $action == 'reauth' || $action == 'edit'){ if($values['day_care'] != 'yes') echo $values['expected_stay_duration']; else { $values['expected_stay_duration'] = 0; echo $values['expected_stay_duration']; }} ?>"  <?php if( $action == 'reauth' || $action == 'edit')if($values['expected_stay_duration'] == 0){ ?> disabled <?php } ?> size="2" class="required digits" /> 
              </div><div id="stay_duration_length" style="color:red;font-size:12px;"></div>
              
            </div>
            <div class="form_row" style="height:50px">
              <div class="form_leftB">Comments</div>
              <div class="form_right">
                <textarea name="comments" cols="35" class="combo"><?php echo $values['comments'];?></textarea>
              </div>
            </div>
            <div class="form_row" style="height:10px">
              <div class="form_leftB">Doctor's name</div>
              <div class="form_right">
                <input name="doctor_name" type="text" class="required"
              value="<?php echo $values['doctor_name'];?>" />
              </div>
            </div>
            <div class="form_row" style="margin-top: 20px;">
              <div class="form_leftB">Expected cost (Rs)</div>
              <div class="form_right">
                <input name="expected_cost" id="expected_cost" type="text" class="required digits cost_length"
              value="<?php echo $values['expected_cost'];?>" />
              </div><div id="cost_length" style="color:red;font-size:12px;"> <?php echo form_error('expected_cost'); ?> </div>
            </div>
            <div class="form_row" style="height:50px">
              <div class="form_leftB">More comments for the cost</div>
              <div class="form_right">
                <textarea name="cost_comment" id="cost_comment" cols="35" class="combo cost_comment" ><?php  echo $values['cost_comment'];?></textarea><div id="cost_comment_error" ><?php echo form_error('cost_comment'); ?></div>
              </div>
            </div>
            
       <?php if ($pre_auth_id == 0 || $action == "edit" || $action == "reauth")  { ?>      
            <div class="form_row" style="margin-top: 20px;">
              <div class="form_leftB">Network Facilitator </div>
              <div class="form_right">
            
               <select name="network_facilator_id" id="network_facilator_id">
       		   <?php   
        				$nf_detail = $nf_obj->find_all_by('type','nf');       
        					
      					foreach ($nf_detail as $nf){ 	?>
	  	  		        <option value="<?php echo $nf->id;  ?>" 
      					<?php if($action == 'edit')if($nf->id == $values['network_facilator_id']) echo 'selected';  ?> ><?php  echo $nf->name;?> </option> 
  				<?php } ?>
        </select>
               
               
              </div>
            </div>
         <?php } ?>   
            <div class="form_row">
              <div class="form_leftB">&nbsp;</div>
              <div class="form_right">
              <input type="image" name="submit" value="submit"  src="<?php echo "{$this->config->item('base_url')}"?>assets/images/common_images/btn_submit.gif" alt="" width="86" height="23" border="0" class="btn_submit" />&nbsp;
              <a href="<?php echo $this->config->item('base_url');?>index.php/hospitalization/policy_details/show_policy_details/<?php echo $policy_id; ?>"><input type="image" src="<?php echo "{$this->config->item('base_url')}"?>assets/images/common_images/btn_cancel.gif" alt="" width="86" height="23" border="0" class="btn_submit" value="cancel" name="cancel" /></a></div>
            </div>
          </div>
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div>
      </div></div>
          </div>
          
          <br class="spacer" /></div>
          <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div>
    
    </form> 
<br class="spacer" /></div>
<!-- Body End -->
<?php $this->load->view('common/footer'); ?>

