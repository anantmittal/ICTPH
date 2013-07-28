
<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/scm/consumable_expire.js"; ?>"></script>
<script  type="text/javascript">
// Have to assign the medications_list while inline - it should be
// be available on document load


var order_medications_list = new Array();      
order_medications_list = [      
<?php
foreach ($product_batchwise_list as $product) {
	$product_id=$product;
	$product_r =$this->product->where('id',$product_id)->find();
	if($product_r->product_type=='MEDICATION'){
		$name = $product_r->name;
		$rate = $product_r->purchase_price;
		?>
		{id: '<?php echo $product_r->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>'},
		<?php
		}
	}
?>
];


var order_consumables_list = new Array();      
order_consumables_list = [      
<?php
foreach ($product_batchwise_list as $product) {
	$product_id=$product;
	$product_r =$this->product->where('id',$product_id)->find();
	if($product_r->product_type=='CONSUMABLES'){
		$name = $product_r->name;
		$rate = $product_r->purchase_price;
		?>
		{id: '<?php echo $product_r->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>'},
		<?php
		}
	}
?>
];
</script>

<title> Remove Expired  Drugs
</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
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
<div id="main">
	<table width="100%" align="center">
		<tr>
			<td>

				<div class="blue_left">
					<div class="blue_right">
						<div class="blue_middle">
							<span class="head_box"> 
								Remove Expired  Drug
							</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">
				<form method="post"  onSubmit="return ValidateForm()">
					<table align="center" id="table_grey_border">
						<tr>
			     			<td><b>Date</b></td>
			    			<td>
			       				 <input name="date" id="date" readonly="readonly" type="text" value="<?php echo $date; ?>" class="datepicker check_dateFormat"  style="width:100px;"  /> 
			     			</td>
			     			<td><b>Total Order Value</b></td>
			         		<input type="hidden" name="bill_amount" id="bill_amount" />
			         		<td id="bill_amount_visible"></td>
						</tr>
						
						<tr>
						<td><b>Type</b></td>
						<td colspan="3">
							<?php
							//@todo : Remove this array and put it in to config file
							$type_enums = array ('1' => 'Medication', '2' => 'Consumable');
								$selected = 'Medication';
							
							echo form_dropdown ( 'type', $type_enums, $selected,'id="type"' );
							?>
						</td>
					</tr>
						<tr>
						  <td colspan = "4">
						  	 <div class="form_data">
								    <fieldset>
								      <legend>Details</legend>
							
								      <div class="form_row" style="margin-top:10px;">
										<div class="form_left">Name of medicine<span style="color:#FF0000">*</span></div>
										<div class="form_right">
											<input id="medication_name" type="text" value="" size="35" class="required" />
											<input id="medication_product_id" type="hidden"/> 
											<input id="medication_rate" type="hidden" />
											<label class="error" id="error_add_drug" style="display:none"> Please enter Drug name  </label>
										</div>
								      </div>
							
								      <div class="form_row">
										<div class="form_left">Quantity<span style="color:#FF0000">*</span></div>
										<div class="form_right">
										  <div style="float:left"><input name="medication_quantity" id="medication_quantity" type="text" size="5" class="required" /></div>
											<div class="consumable_style" ><b>Ret Unit:</b></div><div  class="consumable_style" id="medication_retail_unit" ></div>
											<div  class="consumable_style" >&nbsp;&nbsp;&nbsp;<b>Purc Unit:</b></div><div  class="consumable_style" id="medication_purchase_unit"  ></div>
										  <div class="consumable_style" ><label class="error" id="error_add_quantity" style="display:none"> Please enter Drug quantity  </label></div>
										 <div class="consumable_style" > <label class="error" id="error_numeric_quantity" style="display:none">Drug quantity should be numeric  </label></div>
										</div>
								      </div>
								      
								    <div class="form_row">
										<div class="form_right">
										  <div class="form_newbtn" align="left">
										    <input id="add_medication" type="button" value="Add" />
										  </div>
										</div>
								    </div>
								   </fieldset>
							</div>
							<div class="form_data1">
								    <fieldset>
								      <legend>Details</legend>
							
								      <div class="form_row" style="margin-top:10px;">
										<div class="form_left">Consumable Name<span style="color:#FF0000">*</span></div>
										<div class="form_right">
											<input id="consumable_name" type="text" value="" size="35" class="required" />
											<input id="consumable_product_id" type="hidden"/> 
											<input id="consumable_rate" type="hidden" />
											<label class="error" id="error_add_consumable" style="display:none"> Please enter Consumble name  </label>
										</div>
								      </div>
							
								      <div class="form_row">
										<div class="form_left">Quantity<span style="color:#FF0000">*</span></div>
										<div class="form_right">
										 <div style="float:left"> <input name="consumable_quantity" id="consumable_quantity" type="text" size="5" class="required" /></div>
										<div class="consumable_style" ><b>Ret Unit:</b></div><div  class="consumable_style" id="consumable_retail_unit" ></div>
										<div  class="consumable_style" >&nbsp;&nbsp;&nbsp;<b>Purc Unit:</b></div><div  class="consumable_style" id="consumable_purchase_unit"  ></div>
										  <div class="consumable_style" ><label class="error" id="error_add_consumable_quantity" style="display:none"> Please enter Consumble quantity  </label></div>
										  <div class="consumable_style" ><label class="error" id="error_numeric_consumable_quantity" style="display:none">Consumble quantity should be numeric  </label></div>
										</div>
								      </div>
								      
								    <div class="form_row">
										<div class="form_right">
										  <div class="form_newbtn" align="left">
										    <input id="add_consumable" type="button" value="Add" />
										  </div>
										</div>
								    </div>
								   </fieldset>
							</div>
							
							<input id="medication_row_id" type="hidden" value="1"/>
						  </td>
						</tr>
						<tr>
						  <td colspan = "4"> <label class="error" id="error_add_row" style="display:none"> Please add atleast 1 Drug  </label>  </td>
						</tr>
						<tr>
							<td colspan="4">
						      <table id="medications" cellspacing="2">
								<tr class="scm_head">
								  <td width="50%">Medications/OPD products/Consumables</td>
								  <td width="10%">Qty</td>
								  <td width="11%">Type</td>
								  <td width="10%">Visit Id</td>
								  <td width="8%">Rate</td>
								  <td width="8%">Total</td>
								  <td width="10%">Remove</a></td>
								</tr>
							  </table>
							</td>
						</tr> 
						
						<tr align=right>
							<td colspan="4">
								<b>Comment</b>
								<input type=text size=50 name="comment"/>
								<input type="submit" class="submit" value="Add">
							</td>
						</tr>
					</table>
					</form>	
				</div>
				<div class="bluebtm_left">
					<div class="bluebtm_right">
						<div class="bluebtm_middle" /></div>
					</div>
				</div>			
			</td>
		</tr>
	</table>
</div>
<div id="hidden_to_scrm" style="display:none;"><?php echo form_dropdown ( 'hidden_to_id', $scm_orgs,$to_id, 'id=hidden_to_id' );?></div>
<?php
$this->load->view ( 'common/footer' );
?>
