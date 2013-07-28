<?php 
/**
 * @todo : move all javascript to js file and include that file in header page
 */
$this->load->helper('form');
$this->load->view('common/header'); ?>

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>Backend Claim Entry</title>
<script>
$(document).ready(function(){
	$('#backend_claim_form').validate();
});
</script>

</head>
<body>
<?php $this->load->view('common/header_logo_block'); 
	$this->load->view('common/header_search');
?>

<!-- Body Start -->
<div id="main">
  <!--Preauth Box End-->
  <div class="hospit_box">
    	<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Backend claim entry</span></div></div></div>
          <div class="green_body">
          		<div id="left_col">
                
                    <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Policy details</span></div></div></div>
        <div class="yelo_body" style="padding:8px;">

        <?php $this->load->view('hospitalization/hospitalization_context', $short_context); ?>
      	  
        <br class="spacer" /></div>

      <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
      
  	  </div>                
	  <form method="POST" id="backend_claim_form" name="backend_claim_form" enctype="multipart/form-data">                        
       <div id="right_col">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Backend claim entry</span></div></div></div>
          <div class="blue_body">
          <div class="form_row">
              <div class="form_leftB">Backend Policy Type</div>
              <div class="form_right"><strong> <?php echo $values['backend_policy_type']; ?> </strong></div>
          </div> 
          <div class="form_row">
              <div class="form_leftB">Group policy number</div>
              <div class="form_right"><strong> <?php echo $values['backend_policy_number']; ?> </strong>
              <input type="hidden" name="backend_policy_number" value="<?php echo $values['backend_policy_number']; ?>" /> </div>
          </div>
          <div class="form_row">
              <div class="form_leftB">Backend Member Id </div>
              <div class="form_right"><strong> <?php echo $values['backend_member_id']; ?> </strong> 
              <input type="hidden" name="backend_member_id" value="<?php echo $values['backend_member_id']; ?>" /> </div>
          </div>
          <div class="form_row">
              <div class="form_leftB">Insurer Claim id</div>
	      <?php if ($values['insurer_claim_id'] == '')
		{ ?>
              <div class="form_right"><input type="text" name="insurer_claim_id" /> </div>
		<?php }
		else
		{ ?>
              <div class="form_right"><strong> <?php echo $values['insurer_claim_id']; ?> </strong> 
              <input type="hidden" name="insurer_claim_id" value="<?php echo $values['insurer_claim_id']; ?>" /> </div>
		<?php } ?>
          </div>
          <div class="form_row">
              <div class="form_leftB">Individual policy number</div>
              <div class="form_right"><strong>
              <?php 
              echo "<a href=".$this->config->item('base_url').'index.php/hospitalization/policy_details/show_policy_details/'.$short_context['policy_id'].'>'.$short_context['policy_id'].'</a>';
            // echo $short_context['policy_id']; ?></strong></div>
          </div>

          <div class="form_row">
              <div class="form_leftB">Backend claim form number</div>
              <div class="form_right">
               <input type="text" name="form_number" class="required" size="10" value="<?php echo $values['form_number']; ?>" />
               &nbsp;<?php echo form_error('form_number'); ?>
		  </div>
          </div> 

          <div class="form_row">
              <div class="form_leftB">Backend claim number</div>
              <div class="form_right">
                <input type="text" class="required" name="backend_claim_id" value="<?php echo $values['backend_claim_id']; ?>" size="10"/>
                 &nbsp;<?php echo form_error('backend_claim_id'); ?>
              </div>
          </div>

          <div class="form_row">
              <div class="form_leftB">Backend claim filling date</div>
              <div class="form_right">
  <input name="filling_date" id="filling_date" type="text" value="<?php echo $values['filling_date'];?>" class="datepicker check_dateFormat"  style="width:140px;"  />&nbsp;</div> <div style="font-size:12px;color:red;" id="error_filling_date"> </div>  <br /><div style="padding-left:250px;padding-right:300px;">( eg: DD/MM/YYYY )</div>
            </div>
          &nbsp;

          <div class="form_row">
              <div class="form_leftB">Current Status</div>
              <div class="form_right">
              <?php 
//              	 $status = array('select'=>'------ Select ------','Admitted'=>'Admitted','Discharged' => 'Discharged');
		 if($values['action'] == 'add')
		 {
              	    $status = array('Pending Insurer'=>'Pending Insurer','Pending SIS' => 'Pending SIS','Pending Hospital' => 'Pending Hospital', 'Pending Patient' => 'Pending Patient', 'Settled' => 'Settled');
                    echo form_dropdown('status', $status, $values['status'],'class="required" id="status"');
		 }
		 else
  		 {?>
                    <input type="hidden" name="status" value="<?php echo $values['status']; ?>" />
                 <?php   echo $values['status'];
		 }
                 ?>  
               <?php echo form_error('status'); ?>
              </div>
            </div>

          <div class="form_row">
              <div class="form_leftB">Diagnosis</div>
              <div class="form_right"><strong> <?php echo $values['diagnosis']; ?> </strong> 
              <input type="hidden" name="diagnosis" value="<?php echo $values['diagnosis']; ?>" /> </div>
              <input type="hidden" name="doa" value="<?php echo $values['doa']; ?>" /> 
              <input type="hidden" name="dod" value="<?php echo $values['dod']; ?>" /> 
              <input type="hidden" name="hospital_id" value="<?php echo $values['hospital_id']; ?>" /> 
          </div>

          <div class="form_row">
              <div class="form_leftB">Date of Start of Illness</div>
              <div class="form_right">
  <input name="d_start" id="d_start" type="text" value="<?php echo Date_util::date_display_format($values['doa']);?>" class="datepicker check_dateFormat"  style="width:140px;"  />&nbsp;</div> <div style="font-size:12px;color:red;" id="error_filling_date"> </div>  <br /><div style="padding-left:250px;padding-right:300px;">( eg: DD/MM/YYYY )</div>
            </div>
          &nbsp;

          <div class="form_row">
              <div class="form_leftB">Physician Name</div>
              <div class="form_right"><strong> <?php echo $values['dr_name']; ?> </strong> 
              <input type="hidden" name="dr_name" value="<?php echo $values['dr_name']; ?>" /> </div>
          </div>

          <div class="form_row">
              <div class="form_leftB">Physician Reg No</div>
              <div class="form_right"><strong> <?php echo $values['dr_reg']; ?> </strong> 
              <input type="hidden" name="dr_reg" value="<?php echo $values['dr_reg']; ?>" /> </div>
          </div> 

          <div class="form_row">
              <div class="form_leftB">Physician Qualification</div>
              <div class="form_right"><strong> <?php echo $values['dr_qual']; ?> </strong> 
              <input type="hidden" name="dr_qual" value="<?php echo $values['dr_qual']; ?>" /> </div>
          </div> 


          <div class="form_row">
              <div class="form_leftB">Ward Days   <input type="text" name="ward_days" class="required" value="<?php echo $values['ward_days']; ?>" size="3" />
                  &nbsp;<?php echo form_error('ward_days'); ?> </div>
              <div class="form_rightB">Ward Rate   <input type="text" name="ward_rate" class="required" value="<?php echo $values['ward_rate']; ?>" size="5" />
                  &nbsp;<?php echo form_error('ward_rate'); ?> </div>
          </div> 

          <div class="form_row">
              <div class="form_leftB">ICU Days    <input type="text" name="icu_days"  value="<?php echo $values['icu_days']; ?>" size="3" />
                  &nbsp;<?php echo form_error('icu_days'); ?> </div>
              <div class="form_rightB">ICU Rate    <input type="text" name="icu_rate"  value="<?php echo $values['icu_rate']; ?>" size="5" />
                  &nbsp;<?php echo form_error('icu_rate'); ?> </div>
          </div> 

          <div class="form_row">
              <div class="form_leftB">Human Amount claimed(Rs)</div>
              <div class="form_right">
                  <input type="text" name="human_amount_claimed" class="required" value="<?php echo $values['human_amount_claimed']; ?>" size="10" />
                  &nbsp;<?php echo form_error('human_amount_claimed'); ?>
              </div>
          </div> 

          <div class="form_row">
              <div class="form_leftB">Other Amount claimed(Rs)</div>
              <div class="form_right">
                  <input type="text" name="other_amount_claimed" class="required" value="<?php echo $values['other_amount_claimed']; ?>" size="10" />
                  &nbsp;<?php echo form_error('other_amount_claimed'); ?>
              </div>
          </div> 

          <div class="form_row">
              <div class="form_leftB">Amount claimed(Rs)</div>
              <div class="form_right">
                  <input type="text" name="amount_claimed" class="required" value="<?php echo $values['amount_claimed']; ?>" size="10" />
                  &nbsp;<?php echo form_error('amount_claimed'); ?>
              </div>
          </div> 

          <div class="form_row" style="height:50px">
              <div class="form_leftB">Comments</div>
              <div class="form_right">
             <textarea name="comment" cols="35" class="combo test" id="comment"><?php echo $values['comment'];?></textarea> 
         </div>
         </div>

            <div class="form_row">
            <div class="form_leftB">Entered by</div>
              <div class="form_right">
                <input name="claim_created_by" type="text" size="25" class="required" value="<?php echo $values['claim_created_by']; ?>" />
                  &nbsp;<?php echo form_error('claim_created_by'); ?>
              </div>
          </div>

       <div class="form_row" style="margin-top:20px;">
              <div class="form_leftB">&nbsp;</div>
              <div class="form_right"><input type="submit" name="submit_btn" value="Submit" class="submit" />
       </div>
       </div>
    </div>
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div>
          </form>
          <br class="spacer" /></div>
          <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div>
<br class="spacer" /></div>
<!-- Body End -->

<?php $this->load->view('common/footer'); ?>
