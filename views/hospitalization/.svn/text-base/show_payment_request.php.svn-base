<?php $this->load->helper('form');
      $this->load->view('common/header');         
 ?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/show_payment_request.js"; ?>"></script>

<title>Payment Request</title> 

</head>
<body > 
<?php $this->load->view('common/header_logo_block');
	  $this->load->view('common/header_search');
	  if (isset($_POST['export_as'])) {	  	
	  	$export_as = $_POST['export_as'];	  	
	  }
	  else {
	  	$export_as = '';
	  }
?>

<!--Head end-->
<!-- Body Start -->
<div id="main">
  <!--Preauth Box End-->
<form action="" name='payment_request_form' method="POST" id="payment_request_form">
<div class="hospit_box">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Hospital / Patient / Backend insurer payments request</span></div></div></div>

          <div class="blue_body">
          
          	<div class="form_row">
              <div class="form_left">Type</div>
              <div class="form_right">
                <select name="payment_type" id="payment_type">
                  <option value="hospital">Hospital</option>
                  <option value="patient">Patient</option>
                  <option value="backend_insurer">Backend insurer</option>
                </select>
                &nbsp;</div>
            </div>
            <div class="form_row">
              <div class="form_left">Start Date</div>
              <div class="form_right">
               <input name="start_date" id="start_date" class="datepicker" type="text" 
				value="<?php if (isset($_POST['start_date'])) echo $_POST['start_date'];?>" size="15" />                
             </div>
             <div><?php echo form_error('start_date'); ?></div>
            </div>
            <div class="form_row">

              <div class="form_left">End Date</div>
              <div class="form_right">
                <input name="end_date" id="end_date" class="datepicker" type="text" 
				value="<?php if (isset($_POST['end_date'])) echo $_POST['end_date'];?>" size="15"/>                
                <?php echo form_error('end_date'); ?>
              </div>
              <label id="diff_error"></label>
            </div>
            <div class="form_row">
              <div class="form_left">Export as</div>
              <div class="form_right">
                <input name="export_as" type="radio" <?php if ($export_as == 'csv' || $export_as == '') echo 'checked="checked"'; ?>value="csv" />
                &nbsp;CSV&nbsp;&nbsp;&nbsp;
                <input name="export_as" type="radio"  <?php if ($export_as == 'html') echo 'checked="checked"'; ?> value="html" />
                &nbsp; HTML</div>
            </div>
            <div class="form_row">
              <div class="form_left">&nbsp;</div>
              <div class="form_right">
               <input type="image" src="<?php echo base_url(); ?>assets/images/common_images/btn_submit.gif" alt="Submit button" width="86" height="23" border="0" class="btn_submitm" id="submit"/>
               <!--<input type="submit" class="submit">-->
              </div>
            </div>
            <br><br>
           <?php         
           if (isset($containts)){ ?> 
           <div style="padding-left:50px;" >
           <?php 
           $payment_type = $_POST['payment_type'];

           if ($payment_type == 'hospital')
	           $msg = 'Hospital Payment Dues';
           elseif ($payment_type == 'patient')
    	       $msg = 'Patient Payment Dues';
           elseif ($payment_type == 'backend_insurer')
        	   $msg = 'Backend insurer Payment Dues';
        	   
           echo "<h3> $msg </h3>"; ?>
           </div>
           <table border="0" width="90%" align="center">
           <?php  
           $top = true;
           foreach ($containts as $row){
           	if ($top == true)
           		echo '<tr class="head">';
           	else
           		echo '<tr class="grey_bg">';
           	$top = false;

           	foreach ($row as $value){
           		echo '<td>'.$value.'</td>';
           	}
           	echo '</tr>';
           }
           ?>
           </table>           
           <?php } ?>
    </div>    
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div>
  </form>   
<br class="spacer" /></div>
<!-- Body End -->
<?php $this->load->view('common/footer'); ?>
