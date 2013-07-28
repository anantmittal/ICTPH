<?php 
/**
 * @todo : move all javascript to js file and include that file in header page
 */
$this->load->helper('form');
$this->load->view('common/header'); ?>

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>Backend Claim Settlement Entry</title>
<!-- <script> $(document).ready(function(){	$('#backend_claim_form').validate();}); </script> -->

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
    	  <div class="green_middle"><span class="head_box">Backend claim Settlement entry</span></div></div></div>
          <div class="green_body">
          		<div id="left_col">
                
                    <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Policy details</span></div></div></div>
        <div class="yelo_body" style="padding:8px;">

        <?php $this->load->view('hospitalization/hospitalization_context', $short_context); ?>
      	  
        <br class="spacer" /></div>

      <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
      
  	  </div>                
  	  <form method="POST" id="backend_claim_form">
       <div id="right_col">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Backend claim Settlement entry</span></div></div></div>
          <div class="blue_body">
          <div class="form_row">
              <div class="form_leftB">Backend Policy Type</div>
              <div class="form_right"><strong> <?php echo $values['backend_policy_type']; ?> </strong></div>
          </div> 
          <div class="form_row">
              <div class="form_leftB">Group policy number</div>
              <div class="form_right"><strong> <?php echo $values['backend_policy_number']; ?> </strong></div>
          </div>
          <div class="form_row">
              <div class="form_leftB">Backend Member Id </div>
              <div class="form_right"><strong> <?php echo $values['backend_member_id']; ?> </strong> 
          </div>
          </div>
          <div class="form_row">
              <div class="form_leftB">Backend Claim Id </div>
              <div class="form_right"><strong> <?php echo $values['backend_claim_id']; ?> </strong> 
              <input type="hidden" name="backend_member_id" value="<?php echo $values['backend_claim_id']; ?>" /> </div>
          </div>

          <div class="form_row">
              <div class="form_leftB">Backend claim form number</div>
              <div class="form_right">
               <?php echo $values['form_number']; ?>
		  </div>
          </div> 



          <div class="form_row">
              <div class="form_leftB">Current Status</div>
              <div class="form_right">
              <?php 
//              	 $status = array('select'=>'------ Select ------','Admitted'=>'Admitted','Discharged' => 'Discharged');
              	    $status = array('Approved'=>'Approved','Rejected' => 'Rejected');
                    echo form_dropdown('status', $status, $values['status'],'class="required" id="status"');
                echo form_error('status'); ?>
              </div>
            </div>

          <div class="form_row">
              <div class="form_leftB">Amount claimed(Rs)</div>
              <div class="form_right">
                  <?php echo $values['amount_claimed']; ?>
              </div>
          </div> 

          <div class="form_row">
              <div class="form_leftB">Amount Settled(Rs)</div>
              <div class="form_right">
                  <input type="text" name="amount_settled" class="required" value="<?php echo $values['amount_settled']; ?>" size="10" />
                  &nbsp;<?php echo form_error('amount_settled'); ?>
              </div>
          </div> 

          <div class="form_row">
              <div class="form_leftB">Payment Receipt date</div>
              <div class="form_right">
  <input name="payment_received_date" id="payment_received_date" type="text" value="<?php echo $values['payment_received_date'];?>" class="datepicker check_dateFormat"  style="width:140px;"  />&nbsp;</div> <div style="font-size:12px;color:red;" id="error_payment_received_date"> </div>  <br /><div style="padding-left:250px;padding-right:300px;">( eg: DD/MM/YYYY )</div>
            </div>
	&nbsp;

          <div class="form_row" style="height:50px">
              <div class="form_leftB">Payment Receipt Details</div>
              <div class="form_right">
             <textarea name="payment_received_details" cols="35" class="combo test" id="comment"><?php echo $values['payment_received_details'];?></textarea> 
         </div>
         </div>

            <div class="form_row">
            <div class="form_leftB">Settled by</div>
              <div class="form_right">
                <input name="settled_by" type="text" size="25" class="required" value="<?php echo $values['settled_by']; ?>" />
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
