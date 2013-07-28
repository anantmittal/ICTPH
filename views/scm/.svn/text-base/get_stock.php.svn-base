<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>


<title>Stock Status Details</title>
<script type="text/javascript">
var root_url = "<?php echo $this->config->item('base_url') ?>";

var generic_name_list = new Array();      
	generic_name_list = [      
		<?php	
			foreach ($generic_names as $generic_id => $generic_name) {
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
			foreach ($generic_medication_names as $generic_id => $generic_name) {
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
			foreach ($generic_consumable_names as $generic_id => $generic_name) {
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
			foreach ($generic_opd_product_names as $generic_id => $generic_name) {
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
		$("#generic_name").local_autocomplete(generic_name_list, "generic_id","");
		$("#generic_medication_name").local_autocomplete(generic_medication_name_list, "generic_id","");
		$("#generic_consumable_name").local_autocomplete(generic_consumable_name_list, "generic_id","");
		$("#generic_opd_product_name").local_autocomplete(generic_opdprod_name_list, "generic_id","");;
		$("#generic_name").val('');
		$("#generic_medication_name").val('');
		$("#generic_consumable_name").val('');
		$("#generic_opd_product_name").val('');
		$("#generic_id").val("");
		
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
			getStockDetails();
		});
		
		$("#generic_name").keyup(function(event){
			  if(event.keyCode == 13){
				  getStockDetails();
			  }
		});
	});

	function parse_round_number(num) {
		num = parseFloat(num);
		var result = Math.round(num*Math.pow(10,2))/Math.pow(10,2);
		return result;
	}

	function getStockDetails(){
		$("#page-loader").show();
		var location_id = $("#location_id").val();
		var provider_location_type = $("#location_type").val();
		var product_type = $("#product_type").val();
		var generic_name = "";
		//To check and get value of generic name depending on product type.
		if($("#generic_name").is(":visible")){
			generic_name = $("#generic_name").val();
		}else if($("#generic_medication_name").is(":visible")){
			generic_name = $("#generic_medication_name").val();
		}else if($("#generic_consumable_name").is(":visible")){
			generic_name = $("#generic_consumable_name").val();
		}else if($("#generic_opd_product_name").is(":visible")){
			generic_name = $("#generic_opd_product_name").val();
		}
		
		$.ajax({
			type: "POST",
			url: root_url+ "index.php/scm/product/fetch_stock/",
			dataType: "html",
			data: {
	   		 	location_id : location_id,
	   		 	provider_location_type : provider_location_type,
	   		 	product_type : product_type,
	   		 	generic_name : generic_name
			},
			success: function(result) {
				$('#table_grey_border tr:gt(0)').remove();
				$('#table_grey_border tbody:last').append(result);
				$("#page-loader").hide();
			},
			complete :function(jqXHR, textStatus){
				$("#page-loader").hide();
			},
			failure : function(){
				$("#page-loader").hide();
				alert("failed");
			},
			error : function(e){
				$("#page-loader").hide();
				alert("error");
			}
	});
	}

	
</script>
<style type="text/css">
#search_by{
	line-height:22px;
	padding-bottom:10px;
}
#search_by div{
	line-height:22px;
	
}
#search_by .or_div{
	padding-left : 50px;
	padding-right : 50px;
}
#search_by .head{
	padding-left:30px;
	padding-right:5px;
}
#stock_table{
	border-color : #ccc;
	border-collapse : collapse;
	border : 1px solid #ccc
}
#stock_table tr td {
	padding:5px;
}
</style>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block');
$this->load->view ( 'common/header_search' );
?>
<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'><span>$success_message</span><div><a href='".$this->config->item('base_url').$filename."'>A  $filetype file has been created. Click here to download.</a></div> </div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>
<div id="page-loader" style="display: none;">
	<h3>Please wait...</h3>
	<?php echo '<img src="'.base_url().'/assets/images/common_images/loader.gif" alt="loader">';?>
	<p><small id="page-load-content">...Please wait, fetching stock details.</small></p>
</div>
			<div id="main">
				<div class="blue_left">
					<div class="blue_right">
						<div class="blue_middle"><span class="head_box">
							<?php
								echo 'Stock Status for Location: '.$location;
							?>
						</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">
				
				<div id="main">
					
					<div id="search_by">
					

						<div ><form method="post"><div><input type ='submit' value='Download csv' class='submit'><?php if($location_type==="DISTRIBUTION"){?><span style='float:right;padding-right:20px'><b>Expiry Details Report:</b><a href="<?php echo $this->config->item('base_url')."index.php/scm/product/expiry_details/".$location_id;?>" ><input type='button' class='submit' value='Download pdf'></a></span><?php }?></div>
						<div ><strong>Search By</strong></div>
						<div style='float:left' class="head"><strong>Product Type : </strong></div>
						<div style='float:left'><?php
						if(isset($product_selected)){
							$selected=$product_selected;
						}else{
							$selected='ALL';
						}
							$product_type = array('ALL' => '-- Select --','MEDICATION' => 'Medication', 'CONSUMABLES' => 'Consumables', 'OUTPATIENTPRODUCTS' => 'Out Patient Products');			
							echo form_dropdown('product_type', $product_type,$selected,'id="product_type"');
						 ?>
						</div>
						
						<div style='float:left' class="or_div"><strong>OR</strong></div>
						<div style='float:left' class="head"><strong>Generic Name : </strong></div>
						<div style='float:left'><input type="text" value="" id="generic_name" size="30" style="height:20px;">
							<input id="generic_id" type="hidden" name="generic_id"/>
							<input type="hidden" name="location_type" id="location_type" value="<?php echo $location_type; ?>" />
							<input type="text" value="" id="generic_medication_name" size="30" style="height:20px;"> 
							
							<input type="text" value="" id="generic_consumable_name" size="30" style="height:20px;">
						
							<input type="text" value="" id="generic_opd_product_name" size="30" style="height:20px;">
							<input type="hidden" name="location_id" value="<?php echo $location_id; ?>" id="location_id"/>
						</div>
						</form></div>
						<div style="padding-left:5px;"><input type="button" value="Find" id="find" onclick="getStockDetails()" class="submit">
						</div>
					</div>
					<br /><br />
					
						<table border="0" width="98%">
							
							<tr>
								<td><?php if($location_type==="DISTRIBUTION"){?><b><span style="color:#FF0000">* Drugs Expiring within 2 months</span></b><?php }?>
								      <table width="100%" border="1px" id="table_grey_border">
										<tr class="scm_head">
										<td width="2%">SNo</td>
											  <td width="8%">Product Id</td>
											  <td width="20%">Product Name</td>
											 <?php if($location_type==="DISTRIBUTION"){?>
											  	<td width="10%">Batch No</td>
											  	<td width="10%">Expiry Date</td>
											  	<?php }?>
											  <td width="10%">Quantity in Stock</td>
											  <td width="10%">Type</td>
											  <td width="10%">OP Product Type</td>
										</tr>
											<?php
												$i=0;
												for($i=0; $i < $number_items ; $i++)
												{
													$today = date("Y-m-d");
													$newdate = strtotime ( '+2 months' , strtotime($today)) ;
													
													if(isset($order_items[$i]['expiry_date']) && $location_type==="DISTRIBUTION"){
														$date = explode('/',$order_items[$i]['expiry_date']);
    													$change_date = mktime(0,0,0,$date[1],$date[0],$date[2]);
    											    	$date=date('Y-m-d',$change_date);
    											    	if(strtotime($date) < $newdate)	{
															echo '<tr style="color:red" >'."\n";
														}else{
															echo '<tr  >'."\n";
														}
													}else{
														echo '<tr  >'."\n";
													}
													echo '<td>'.($i+1).'</td>'."\n";
													echo '<td>'.$order_items[$i]['product_id'].'</td>'."\n";
											//		echo '<td width="35%">'.$order_items[$i]['brand_name'].'</td>'."\n";
													echo '<td>'.$order_items[$i]['brand_name'].'</td>'."\n";
													if($location_type==="DISTRIBUTION"){
														echo '<td>'.$order_items[$i]['batch_number'].'</td>'."\n";
														if(isset($order_items[$i]['expiry_date'])){
															echo '<td>'.$order_items[$i]['expiry_date'].'</td>'."\n";
														}else{
															echo '<td>-</td>'."\n";
														}
													}
													echo '<td>'.round($order_items[$i]['quantity'],2).'</td>'."\n";
													echo '<td>'.ucfirst(strtolower($order_items[$i]['product_type'])).'</td>'."\n";
													if($order_items[$i]['product_type']==="OUTPATIENTPRODUCTS"){
														echo '<td>'.$order_items[$i]['opd_product_type'].'</td>'."\n";
													}else{
														echo '<td>-</td>'."\n";
													}
													echo '</tr>'."\n";
												}
											?>
											<tr>
												
											</tr>
	      							</table>
      							</td>
							</tr> 
					</table>
				</div>
			</div>
			<div class="bluebtm_left">
				<div class="bluebtm_right">
					<div class="bluebtm_middle" /></div>
				</div>
			</div>
		</div>

<?php
$this->load->view ( 'common/footer' );
?>
