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
			<?php echo form_dropdown ( 'location_id', $locations,$location_id,'id="location_id" style="width:140px;"' );?>
			
			
			
			
			
			<b>From </b>
			<input name="from_date" id="from_date" type="text" readonly="readonly" value="<?php echo $from_date; ?>" class="datepicker check_dateFormat"  style="width:120px;"/>
	
			<b>To </b>
			<input name="to_date" id="to_date" type="text" readonly="readonly" value="<?php echo $to_date; ?>" class="datepicker check_dateFormat" style="width:120px;"/>
			
			<b>Email Address</b>
     			<input type="text" id="email_address" name="email_address" size=50 style="width:140px;" /> </br>
		
     			
     			</div>
     			<div id="risk_id" class="risk_row" align="center">
	     			<b>Risk Factors</b>
				Age<input type="checkbox"  name="risk_factor[]" value="1" id="1" />
				BMI<input type="checkbox"  name="risk_factor[]" value="2" id="2" />
				WHR<input type="checkbox"  name="risk_factor[]" value="3" id="3" />
		Tobacco Consumption<input type="checkbox"  name="risk_factor[]" value="4" id="4" />
	      		    High BP<input type="checkbox"  name="risk_factor[]" value="5" id="5" />
		   Personal History<input type="checkbox"  name="risk_factor[]" value="6" id="6" />
		            	   <input type="button" onclick="risk_factor_combination_chart_ajax()" name="get_report" value="Create Report"> 
			</div>
   		</div>
   		
		<div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
	</div>
     	
     	
	<div id="rep_link" align="center"></div>
	<div id="mail_status" align="center"></div>
	<div id = "table_report_risk">
	   <div class="blue_left">
	    <div class="blue_right"><div class="blue_middle"><span class="head_box">Table</span></div></div>
	  </div>

	  <div id="blue_table" class="blue_body" style="padding:10px;">
	  <div id="table_status" align="center"></div>
 	  </div>
	  
	  <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br /> 
	  </div>
	
	
</div>
    
<?php $this->load->view('common/footer.php'); ?>
    
    
  
    

 


