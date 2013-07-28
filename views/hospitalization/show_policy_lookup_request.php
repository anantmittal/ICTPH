<?php $this->load->view('common/header'); ?>
<title>Policy Lookup Request</title>
</head>
<body>
<?php $this->load->view('common/header_logo_block');
 $this->load->view('common/header_search'); ?>

<script>
$(document).ready(function(){
 	$("#frm_policy_request").validate();
  });

</script>
 <form id="frm_policy_request" name="frm_policy_request" id="frm_policy_request" action="<?php echo $this->config->item('base_url');?>index.php" method="GET" >
 <div id="main">
<div class="hospit_box">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">policy lookup request</span></div></div></div>

          <div class="blue_body">
          
          	<div class="form_row">
          	<input type="hidden" name="d" value="hospitalization" >
			<input type="hidden" name="c" value="policy_details" >
			<input type="hidden" name="m" value="index">
            	<div class="form_leftB">Policy Number</div>
                <div class="form_right"><input type="text" name="policy_id" value="SSP-LUR-R-01-000038" class="required"></div>
            </div>

            <div class="form_row">
              <div class="form_leftB">&nbsp;</div>
              <div class="form_right"><input type="submit" name="button" id="button" value="Get Policy Details" class="submit"/></div>

            </div>
            
</div>
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
</div>          
</div>
</form>
<?php $this->load->view('common/footer'); ?>
