<?php 
      $this->load->library('date_util');
	  $this->load->helper('form');
      $this->load->view('common/header');
?>

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/hospitalization.js"; ?>"></script>
<!--<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/validate_date_format.js"; ?>"></script>-->


<title>Hospitalization</title> 
</head>
<body>
     
<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search'); 
    	  
  	  if($action == 'add')
  	  {
  	  		$values['last_preauth_id'] = $pre_auth_object->id;
  	  		$values['hospital_id'] = $pre_auth_object->hospital_id;
  	  	    $values['chief_complaint']=$pre_auth_object->chief_complaint;
  	  	    $values['detail_complaint']=$pre_auth_object->detail_complaint;
      		$values['current_diagnosis']=$pre_auth_object->current_diagnosis;
      		$values['procedure']=$pre_auth_object->procedure;
  	  }
  	  
   	  if($action == 'edit')
  	  {
  	  	$hospialization_date = Date_util::date_display_format($values['hospitalization_date']);
  	  	if($values['discharge_date'] && $values['discharge_date'] != '0000-00-00')
  	  	$discharged_date = Date_util::date_display_format($values['discharge_date']);
  	  	else 
  	  	$discharged_date = '';
  	  }
  	  else 
  	  {
  	  	$hospialization_date = '';
  	  	$discharged_date = '';
  	  }
  	   
 ?>
<form method="POST" id="hospitalization_form" action="" >
<!--Head end-->
<!-- Body Start -->
<div id="main">
  <!--Preauth Box End-->
  <div class="hospit_box">
    	<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">HOSPITALIZATION</span></div></div></div>
          <div class="green_body">
          		<div id="left_col">
               
                <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Preauthorization details</span></div></div></div>
		  <div class="yelo_body" style="padding:8px;">
	<?php 
    $form_action = $this->uri->segment(3);
    if($form_action == 'add')
    	$this->load->view('hospitalization/policy_context', $short_context);
    else
	$this->load->view('hospitalization/hospitalization_context', $short_context); ?>
	<br class="spacer" /></div>
    <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
        
        <br />
        </div>
        <div id="right_col">
            
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">
    	  <?php 

    	  if ($action == 'add') 
    	     	 echo 'ADD HOSPITALIZATION DETAIL'; 
    	        else echo  'EDIT HOSPITALIZATION DETAIL'; ?>
    	  </span></div></div></div>
          <div class="blue_body" style="padding: 10px;">
          
          <?php if(isset($hospitalization_id)) { ?>
          <div class="form_row">
              <div class="form_leftB">Hospitalization ID</div>
              <div class="form_right"> 	<?php echo $hospitalization_id; ?>  </div>
           </div>
          <?php } ?>
          
          <?php if ($action =="add_new")
           { ?>
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
        <option value="<?php echo $person->id; ?>" > <?php echo $person->full_name.', '.$person->gender.', '.$age;?> </option> 
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
                 	   <option value="<?php echo $value['id']; ?>" ><?php echo $value['name'];?> </option> <?php }?>
                </select>
              </div>
            </div>
            <input type="hidden" name="pre_auth_id" value="0" />
                
           <?php }
           else { ?>
            <input type="hidden" name="hospital_id" value="<?php echo $values['hospital_id']; ?>" />
            
            <input type="hidden" name="pre_auth_id" value="<?php echo $values['last_preauth_id']; ?>" />
            <?php } ?>

            <div class="form_row">
              <div class="form_leftB">Status</div>
              <div class="form_right">
              <?php 
//              	 $status = array('select'=>'------ Select ------','Admitted'=>'Admitted','Discharged' => 'Discharged');
              	 $status = array('Admitted'=>'Admitted','Discharged' => 'Discharged');
                 echo form_dropdown('status', $status, $values['status'],'class="required" id="status"');
               ?>  
               <?php echo form_error('status'); ?>
              </div>
            </div>

            <div class="form_row">
              <div class="form_leftB">Chief complaints</div>
              <div class="form_right">
                <input type="text" name="chief_complaint" class="chief_complaint required" id="chief_complaint" value="<?php echo $values['chief_complaint'];?>"  />
	      <div id="chief_complaint_error" style="color:red;" ><?php echo form_error('chief_complaint'); ?></div>
              </div>
            </div>

            <div class="form_row" style="height:50px">
              <div class="form_leftB">Detail complaint from PreAuth</div>
              <div class="form_right">
                <textarea name="detail_complaint" class="combo" id="detail_complaint" cols="35"> <?php echo $values['detail_complaint'];?>  </textarea>
              </div>
            </div>

            <div class="form_row">
              <div class="form_leftB">Primary Diagnosis</div>

              <div class="form_right">
			  <?php 
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
    	 value="<?php echo $current_diagnosis; ?>" class="required" <?php if($current_diagnosis == '') echo 'disabled'; ?>  />
              
           
              </div>
            </div>
            <div class="form_row">

              <div class="form_leftB"><label for="procedure">Procedure (S)</label></div>
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
              value="<?php echo $procedure; ?>"  <?php if($procedure == '') echo 'disabled'; ?> />
            </div>
            </div>
            <div class="form_row">
              <div class="form_leftB">Date of Admission</div>
              <div class="form_right">
			  <input name="hospitalization_date" id="hospitalization_date" type="text" value="<?php echo $hospialization_date;?>" class="datepicker check_dateFormat"  style="width:140px;"  />&nbsp;</div> <div style="font-size:12px;color:red;" id="error_addmission_date"> </div>  <br /><div style="padding-left:250px;padding-right:300px;">( eg: DD/MM/YYYY )</div>
            </div>
          &nbsp;
            
           
            <div class="form_row">
              <div class="form_leftB">Date of Discharge</div>
              <div class="form_right"><input name="discharge_date" id="discharge_date" type="text" value="<?php echo $discharged_date;?>" class="datepicker check_dateFormat" style="width:140px;" />&nbsp;</div><div style="font-size:12px;color:red;" id="error_discharged_date"> </div>
            </div>

            <div class="form_row">
              <div class="form_leftB">Primary Consultant</div>

              <div class="form_right">
                <input name="primary_physician" type="text" value="<?php echo $values['primary_physician'];?>" size="35" /><?php echo form_error('primary_physician'); ?>
              </div>
            </div>

            <div class="form_row">
              <div class="form_leftB">Consultant Reg No</div>
              <div class="form_right">
                <input name="physician_reg_no" type="text" value="<?php echo $values['physician_reg_no'];?>" size="20" /><?php echo form_error('physician_reg_no'); ?>
              </div>
            </div>

            <div class="form_row">
              <div class="form_leftB">Consultant Qualification</div>
              <div class="form_right">
                <input name="physician_qualification" type="text" value="<?php echo $values['physician_qualification'];?>" size="20" /><?php echo form_error('physician_qualification'); ?>
              </div>
            </div>


            <div class="form_row" style="height:50px">
              <div class="form_leftB">Comments</div>
              <div class="form_right">
                <textarea name="comments"  id="comments" cols="35" class="combo" ><?php echo $values['comments'];?></textarea>

              </div>
            </div>

            <div class="form_row">
              <div class="form_leftB">&nbsp;</div>
              <div class="form_right"><input type="submit" class="submit" name="submit" value="submit" />&nbsp;
          <a href="<?php echo $this->config->item('base_url');?>index.php/hospitalization/policy_details/show_policy_details/<?php echo $policy_id; ?>"><input type="button"  class="submit" name="cancel" value="cancel" id="cancel"/></a></div>
            </div>
          </div>

          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    
         </div>
          
          <br class="spacer" /></div>
          <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div>
    
    </form> 
<br class="spacer" /></div>
<!-- Body End -->
<?php $this->load->view('common/footer'); ?>
