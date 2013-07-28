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

<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>


    
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/report/report.js"; ?>"></script>




<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>




<script type="text/javascript">

var base_url = "<?php echo $this->config->item('base_url');?>";

var generic_name_list = new Array();  
generic_name_list = [      
		<?php	
			foreach ($generic_names_all_list as $generic_id => $generic_name) {
		?>
		{id: '<?php echo $generic_id; ?>', name: '<?php echo $generic_name; ?>'},
		<?php	
		}
		?>
	];
//medication
var generic_medication_name_list = new Array();      
generic_medication_name_list = [      
	<?php	
		foreach ($generic_names_medication_list as $generic_id => $generic_name) {
	?>
	{id: '<?php echo $generic_id; ?>', name: '<?php echo $generic_name; ?>'},
	<?php	
	}
	?>
];
//consumable
var generic_consumable_name_list = new Array();      
generic_consumable_name_list = [      
	<?php	
		foreach ($generic_names_consumables_list as $generic_id => $generic_name) {
	?>
	{id: '<?php echo $generic_id; ?>', name: '<?php echo $generic_name; ?>'},
	<?php	
	}
	?>
];
//opd products
var generic_opdprod_name_list = new Array();      
generic_opdprod_name_list = [      
	<?php	
		foreach ($generic_names_opd_products_list as $generic_id => $generic_name) {
	?>
	{id: '<?php echo $generic_id; ?>', name: '<?php echo $generic_name; ?>'},
	<?php	
	}
	?>
];



$(document).ready(function(){
	//Load generic names
	$("#generic_name").show();
	$("#generic_medication_name").hide();
	$("#generic_consumable_name").hide();
	$("#generic_opd_product_name").hide();
	$("#generic_name").user_autocomplete(generic_name_list, "generic_id");
	$("#generic_medication_name").user_autocomplete(generic_medication_name_list, "generic_id");
	$("#generic_consumable_name").user_autocomplete(generic_consumable_name_list, "generic_id");
	$("#generic_opd_product_name").user_autocomplete(generic_opdprod_name_list, "generic_id");
	$("#generic_name").val('');
	$("#generic_medication_name").val('');
	$("#generic_consumable_name").val('');
	$("#generic_opd_product_name").val('');
	$("#generic_id").val("");
	
	/*$("#rep_options_id").click(function()
	{
		$("#generic_name").user_autocomplete("search","");
    	});
	*/
	$("#product_type").change(function(){
		$("#generic_name").val('');
		$("#generic_medication_name").val('');
		$("#generic_consumable_name").val('');
		$("#generic_opd_product_name").val('');
		//$("#generic_name").val("");
		$("#generic_id").val("");
		if($('#product_type :selected').val()=="MEDICATION"){
			$("#generic_name").hide();
			$("#generic_medication_name").show();
			$("#generic_consumable_name").hide();
			$("#generic_opd_product_name").hide();
			
			
		}else if($('#product_type :selected').val()=="CONSUMABLES"){
			$("#generic_name").hide();
			$("#generic_medication_name").hide();
			$("#generic_consumable_name").show();
			$("#generic_opd_product_name").hide();
			
		}else if($('#product_type :selected').val()=="OUTPATIENTPRODUCTS"){
			$("#generic_name").hide();
			$("#generic_medication_name").hide();
			$("#generic_consumable_name").hide();
			$("#generic_opd_product_name").show();
		}else{
			$("#generic_name").show();
			$("#generic_medication_name").hide();
			$("#generic_consumable_name").hide();
			$("#generic_opd_product_name").hide();
		}
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
			<?php echo form_dropdown ( 'location_id', $locations,$location_id,'id="location_id" style="width:130px"' );?>
	
			<b>From </b>
			<input name="from_date" id="from_date" type="text" readonly="readonly" value="<?php echo $from_date; ?>" class="datepicker check_dateFormat"  style="width:75px;"/>
	
			<b>To </b>
			<input name="to_date" id="to_date" type="text" readonly="readonly" value="<?php echo $to_date; ?>" class="datepicker check_dateFormat" style="width:75px;"/>
	
			<b>Email Address</b>
     			<input type="text" id="email_address" name="email_address" size=50 style="width:100px;" /> 
     			
     			<b>Features </b>
			<?php
			if(isset($product_selected))
			{
				$selected=$product_selected;
			}
			else
			{
				$selected='ALL';
			}
			$product_type = array('ALL' => 'All','MEDICATION' => 'Medication', 'CONSUMABLES' => 'Consumables', 'OUTPATIENTPRODUCTS' => 'Out Patient Products');			
			echo form_dropdown('product_type', $product_type,$selected,'id="product_type" style="width:110px"');
			?>
			<b>Options</b>
			<form class="button_wrapper">
				<input type="text" value="" id="generic_name" size="30" style="width:110px;">
				<input id="generic_id" type="hidden" name="generic_id"/>
				<input type="text" value="" id="generic_medication_name" size="30" style="width:110px;"> 
				<input type="text" value="" id="generic_consumable_name" size="30" style="width:110px;">
				<input type="text" value="" id="generic_opd_product_name" size="30" style="width:110px;">
		
			</form>
			<center>
     			<a href="javascript: void(0);" onclick="inventory_consumed_chart_ajax()">Create Report</a>
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
    
    
  
    

 


