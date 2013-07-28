<?php 
	$this->load->helper('form');
        $this->load->library('date_util');
        $this->load->view('common/header.php');
	$this->load->view('common/header_logo_block');
	$this->load->view('common/header_search');	  
?>
    
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/report.css" rel="stylesheet" type="text/css">
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery-ui-1.7.2.custom.css";?>" rel="stylesheet" type="text/css"/>
    
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/report/report.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
    
</head>
<body>

<div id="main">
	
	<div id="report_details_box"> 

		<div class="blue_left">
	    		<div class="blue_right">
	      			<div class="blue_middle"><span class="head_box">Report Details</span></div>
	    		</div>
	  	</div>

	 	<div class="blue_body" style="padding:8px;">
	  
	  		<div id="form_id" class="form_row" align="center">

			<b>Location </b>
			<?php echo form_dropdown ( 'location_id', $locations,$location_id,'id="location_id"' );?>
	
			<b>From </b>
			<input name="from_date" id="from_date" type="text" readonly="readonly" value="<?php echo $from_date; ?>" class="datepicker check_dateFormat"  style="width:90px;"/>
	
			<b>To </b>
			<input name="to_date" id="to_date" type="text" readonly="readonly" value="<?php echo $to_date; ?>" class="datepicker check_dateFormat" style="width:90px;"/>
	
			<b>Email Address</b>
     			<input type="text" id="email_address" name="email_address" size=50 style="width:140px;" /> 
     	
     			<input type="button" onclick="number_patients_by_doctor_chart_ajax()" name="get_report" value="Create Report"> 
     			
     			</div>
   		</div>
		<div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
	</div>
     	
     	
	<div id="rep_link" align="center"></div>
	<div id="mail_status" align="center"></div>
	<div id="rep_main">
		<div id="rep_leftcol"><div id="chart_div" ></div>
	  	</div>
	    	<div id="rep_rightcol"><div id="table_div" ></div>
	    	</div>
	</div>
</div>
    
<?php $this->load->view('common/footer.php'); ?>
    
    
  
    

 


