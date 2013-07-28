<?php 
/**
 * @todo : move all javascript to js file and include that file in header page
 */
$this->load->helper('form');
$this->load->view('common/header'); ?>
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
    	  <div class="green_middle"><span class="head_box">Backend claim status</span></div></div></div>
          <div class="green_body">
          		<div id="left_col">
                
                    <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Policy details</span></div></div></div>
        <div class="yelo_body" style="padding:8px;">

        <?php $this->load->view('hospitalization/hospitalization_context', $short_context); ?>
      	  
        <br class="spacer" /></div>

      <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
      
  	  </div>                
<form method="POST" id="backend_claim_form" action="<?php echo $this->config->item('base_url').'index.php/hospitalization/backend_claim/save_status/'.$values['backend_claim_id'];?>">
       <div id="right_col">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Backend claim status update</span></div></div></div>
          <div class="blue_body">

          <div class="form_row">
              <div class="form_leftB">Backend Claim Id</div>
              <div class="form_right"><strong> <?php echo $values['backend_claim_id']; ?> </strong></div>
          </div>

          <div class="form_row">
              <div class="form_leftB">Backend Member Id </div>
              <div class="form_right"><strong> <?php echo $values['backend_member_id']; ?> </strong>  </div>
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
               <?php echo $values['form_number']; ?>
		  </div>
          </div> 

          <div class="form_row">
              <div class="form_leftB">Backend claim filling date</div>
              <div class="form_right">
                    <?php echo $values['filling_date'];?> </div>
            </div>

          <div class="form_row">
              <div class="form_leftB">Status</div>
              <div class="form_right">
              <?php 
//              	 $status = array('select'=>'------ Select ------','Admitted'=>'Admitted','Discharged' => 'Discharged');
              	    $status = array('Pending Insurer'=>'Pending Insurer','Pending SIS' => 'Pending SIS','Pending Hospital' => 'Pending Hospital', 'Pending Patient' => 'Pending Patient', 'Settled' => 'Settled');
                    echo form_dropdown('status', $status, $values['status'],'class="required" id="status"');
                 ?>  
               <?php echo form_error('status'); ?>
              </div>
            </div>

          <div class="form_row">
              <div class="form_leftB">Amount claimed(Rs)</div>
              <div class="form_right">
                  <?php echo $values['amount_claimed']; ?>
              </div>
          </div> 

          <div class="form_row" style="height:50px">
              <div class="form_leftB"> Previous Comment</div>
              <div class="form_right">
             <?php echo $values['comment'];?> 
         </div>
         </div>

          <div class="form_row" style="height:50px">
              <div class="form_leftB"> Last Reviewer</div>
              <div class="form_right">
             <?php echo $values['claim_reviewed_by'];?> 
         </div>
         </div>


          <div class="form_row" style="height:50px">
              <div class="form_leftB"> Comment</div>
              <div class="form_right">
             <textarea name="comment" cols="35" class="combo test" id="comment"></textarea> 
         </div>
         </div>

            <div class="form_row">
            <div class="form_leftB">Status Reviewed by</div>
              <div class="form_right">
                <input name="claim_reviewed_by" type="text" value="" size="15" class="required" />
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
