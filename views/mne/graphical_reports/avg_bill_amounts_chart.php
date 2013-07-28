<?php 
	$this->load->helper('form');
        $this->load->library('date_util');
        $this->load->view('common/header.php');
	$this->load->view('common/header_logo_block');
	$this->load->view('common/header_search');	  
?>
    
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/report.css" rel="stylesheet" type="text/css">

<link href="<?php echo "{$this->config->item('base_url')}assets/js/jquery/development-bundle/themes/base/jquery.ui.all.css";?>" rel="stylesheet" type="text/css"/>



<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery/development-bundle/jquery-1.7.2.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery/development-bundle/ui/jquery.ui.core.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery/development-bundle/ui/jquery.ui.widget.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery/development-bundle/ui/jquery.ui.position.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery/development-bundle/ui/jquery.ui.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery/development-bundle/ui/jquery.ui.datepicker.js"; ?>"></script>

    
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/report/report.js"; ?>"></script>









<script type="text/javascript">

var base_url = "<?php echo $this->config->item('base_url');?>";

/*map_filers will appear in the map-details box drop-down menu items*/

var report_filters = {
					"diagnosis":<?php echo json_encode($opd_diagnosis_list);?>,
					"None":{"":""}
					
				  };
				  
$(document).ready(function(){
	$("#from_date").datepicker({buttonImage: base_url+'assets/images/common_images/img_datepicker.gif',buttonImageOnly:'true', showOn:'both',changeYear: true, yearRange: '2010:2030', dateFormat: 'dd/mm/yy'});
	$("#to_date").datepicker({buttonImage: base_url+'assets/images/common_images/img_datepicker.gif',buttonImageOnly:'true',showOn:'both',changeYear: true, yearRange: '2010:2030', dateFormat: 'dd/mm/yy'});
	$("#rep_features").blur(function() {
	var feature = $('#rep_features').val();
	var options = [];
	
	for (var i in report_filters[feature])
	{
		options.push(i);
	}
	$('#rep_options').autocomplete("destroy");
	$('#rep_options').autocomplete({source:options, minLength:0});
	$("#rep_options_id").click(function(){
    	$("#rep_options").autocomplete("search","");
    });
    
	});

	var feature_options = [];
	var first_feature = false;

	for (var m in report_filters) {
		if (!first_feature)
			first_feature = m;
		feature_options.push(m);
	}
    $('#rep_features').autocomplete({source:feature_options, minLength:0});
     $("#rep_features_id").click(function(){
    	$("#rep_features").autocomplete( "search","");
    });  
   
});

</script>



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
	  
	  		<div id="form_id" class="form_row_report" align="left">

			<b>Location </b>
			<?php echo form_dropdown ( 'location_id', $locations,$location_id,'id="location_id" style="width:110px"' );?>
	
			<b>From </b>
			<input name="from_date" id="from_date" type="text" readonly="readonly" value="<?php echo $from_date; ?>" class="datepicker check_dateFormat"  style="width:75px;"/>
	
			<b>To </b>
			<input name="to_date" id="to_date" type="text" readonly="readonly" value="<?php echo $to_date; ?>" class="datepicker check_dateFormat" style="width:75px;"/>
	
			<b>Email Address</b>
     			<input type="text" id="email_address" name="email_address" size=50 style="width:100px;" /> 
     			
     			<b>Features </b>
			<form class="button_wrapper">
				<input id="rep_features" name="rep_features" style="width:100px;">
				<img src="<?php echo "{$this->config->item('base_url')}assets/images/common_images/small_down_arrow.gif"; ?>" id="rep_features_id"/>
			</form>
			<b>Options</b>
				<form class="button_wrapper">
				<input id="rep_options" name="rep_options" style="width:100px;">
				<img src="<?php echo "{$this->config->item('base_url')}assets/images/common_images/small_down_arrow.gif"; ?>" id="rep_options_id"/>
			</form>
			<center>
     			<a href="javascript: void(0);" onclick="avg_bill_amounts_chart_ajax()">Create Report</a>
     			</center>
     			
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
    
    
  
    

 


