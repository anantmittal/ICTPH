<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/scm/add_scm_item.js"; ?>"></script>


<script  type="text/javascript">
// Have to assign the medications_list while inline - it should be
// be available on document load
var order_medications_list = new Array();      
order_medications_list = [      
<?php
foreach ($gx_list_medication as $gx) {
  $name = $gx->generic_name.' - '.$gx->form.'-'.$gx->strength.' '.$gx->strength_unit.' - '.$gx->capacity.' '.$gx->purchase_unit;
  $retail_unit=$gx->retail_unit;
  $purchase_unit=$gx->purchase_unit;
  if($gx->capacity == 1)
	  $rate = $gx->retail_price*10;
  else
	  $rate = $gx->retail_price;		
?>
{id: '<?php echo $gx->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>', retail_unit: '<?php echo $retail_unit; ?>', purchase_unit: '<?php echo $purchase_unit; ?>'},
<?php
}
?>
];

var order_opd_products_list = new Array();      
order_opd_products_list = [      
<?php
foreach ($gx_list_opdproducts as $gx) {
  $name = $gx->generic_name.' - '.$gx->form.'-'.$gx->strength.' '.$gx->strength_unit.' - '.$gx->capacity.' '.$gx->purchase_unit;
  $retail_unit=$gx->retail_unit;
  $purchase_unit=$gx->purchase_unit;
  if($gx->capacity == 1)
	  $rate = $gx->retail_price*10;
  else
	  $rate = $gx->retail_price;		
?>
{id: '<?php echo $gx->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>', retail_unit: '<?php echo $retail_unit; ?>', purchase_unit: '<?php echo $purchase_unit; ?>'},
<?php
}
?>
];

var order_consumables_list = new Array();      
order_consumables_list = [      
<?php
foreach ($gx_list_consumables as $gx) {
  $name = $gx->generic_name.' - '.$gx->form.'-'.$gx->strength.' '.$gx->strength_unit.' - '.$gx->capacity.' '.$gx->purchase_unit;
  $retail_unit=$gx->retail_unit;
  $purchase_unit=$gx->purchase_unit;
  if($gx->capacity == 1)
	  $rate = $gx->retail_price*10;
  else
	  $rate = $gx->retail_price;		
?>
{id: '<?php echo $gx->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>', retail_unit: '<?php echo $retail_unit; ?>', purchase_unit: '<?php echo $purchase_unit; ?>'},
<?php
}
?>
];



</script>


<title><?php
if (isset ( $id ))
	echo 'Edit Order Details';
else
	echo 'Add Order Details';
?></title>
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
								<?php
									if (isset ( $id ))
										echo 'Edit Order No: '.$id;
									else
										echo 'Add Order Details';
								?> 
							</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">
				<form method="post"  onSubmit="return ValidateForm()">
					<table align="center" id="table_grey_border">
						<tr>
			     			<td><b>Date</b></td>
			    			 <td colspan="3">
			       				<input name="date" id="date" readonly="readonly" type="text" value="<?php echo $date; ?>" class="datepicker check_dateFormat"  style="width:100px;"  />
			     			</td>
						</tr>
						
						<tr>
							<td><b>Order From</b></td>
							<td>
								<?php 
								if($this->session->userdata('location_id'))
								{ ?>
								<input type="hidden" name="from_id" value="<?php echo $from_id;?>" id="from_loc_id"/>
								<?php echo $scm_orgs[$from_id];
								//unset($internal_scm_orgs[$from_id]);
								}
								else
								{
								echo form_dropdown ( 'from_id', $internal_scm_orgs,$from_id, 'id=from_id' );
								}
								?>
							</td>
							<td><b>Order To</b></td>
							<td>
								<?php 
								echo form_dropdown ( 'to_id', $scm_orgs,$to_id, 'id=to_id' );
								?>
							</td>
						</tr>
						
						<tr>
						<td><b>Type</b></td>
						<td colspan="3">
							<?php
							//@todo : Remove this array and put it in to config file
							$type_enums = array ('1' => 'Medication', '2' => 'Consumable', '3' => 'OPD Product');
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
							<div class="form_data2">
								    <fieldset>
								      <legend>Details</legend>
					
								      <div class="form_row" style="margin-top:10px;">
										<div class="form_left">OPD Product Name<span style="color:#FF0000">*</span></div>
										<div class="form_right">
											<input id="opd_product_name" type="text" value="" size="35" class="required" />
											<input id="opd_product_id" type="hidden"/> 
											<input id="opd_product_rate" type="hidden" />
											<label class="error" id="error_add_opd_product" style="display:none"> Please enter OPD Product name  </label>
										</div>
								      </div>
							
								      <div class="form_row">
										<div class="form_left">Quantity<span style="color:#FF0000">*</span></div>
										<div class="form_right">
										  <div style="float:left"><input name="opd_product_quantity" id="opd_product_quantity" type="text" size="5" class="required" /></div>
											<div class="consumable_style" ><b>Ret Unit:</b></div><div  class="consumable_style" id="opd_product_retail_unit" ></div>
											<div  class="consumable_style" >&nbsp;&nbsp;&nbsp;<b>Purc Unit:</b></div><div  class="consumable_style" id="opd_product_purchase_unit"  ></div>
										  <div class="consumable_style" ><label class="error" id="error_add_opd_quantity" style="display:none"> Please enter OPD Product quantity  </label></div>
										 <div class="consumable_style" > <label class="error" id="error_numeric_opd_quantity" style="display:none">OPD Product quantity should be numeric  </label></div>
										</div>
								      </div>
								      
								      <div class="form_row">
										<div class="form_left">Visit Id</div>
										<div class="form_right">
										  <input name="opd_product_visit_id" id="opd_visit_id" type="text" size="5"  />
										</div>
								      </div>
								      
								    <div class="form_row">
										<div class="form_right">
										  <div class="form_newbtn" align="left">
										    <input id="add_opd_product" type="button" value="Add" />
										    
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
						
						<tr> 
			     			<td colspan="4">
     				  			<div style="float:right " >
	     				  			<div style="float:left"><b>Total Order Value: </b>&nbsp;</div>
	         						<input type="hidden" name="bill_amount" id="bill_amount" />
	         						<div style="float:left"  id="bill_amount_visible"></div>
	         					</div>
			     				  		
			     			</td>
						</tr>
			
						<tr>
						
							<td colspan="4">
							
						<div class="form_left">Pending OPD Products</div>
						      <table id="pending_orders" width="100%" cellspacing="2" cellpadding="2" style="border:1px solid;">
								<tr class="scm_head">
								  <td width="50%">Product name</td>
								  <td width="10%">Qty</td>
								  <td width="10%">Visit Id</td>
								  <td width="20%">Location</td>
								  <td width="10%">Add</td>
								</tr>
								
								<?php 
								  for ($i=0; $i < $total_results; $i++) {
								  ?>
								  <tr class="row" id="pending_order_row_<?php echo $i; ?>">
								    <td> <?php echo $values[$i]['product_name']; ?> 
								    	<input id="opd_<?php echo $i; ?>_product_name" type="hidden" value=" <?php echo $values[$i]['product_name']; ?>"  ></input>
											<input id="opd_<?php echo $i; ?>_product_id" type="hidden" value="<?php echo  $values[$i]['generic_id']; ?>"></hidden> 
											<input id="opd_<?php echo $i; ?>_product_rate" type="hidden" value="<?php echo $values[$i]['cost']; ?>"></hidden>
											<input id="opd_<?php echo $i; ?>_pending_queue_id" type="hidden" value="<?php echo $values[$i]['pending_queue_id']; ?>"></hidden>
								    </td>
								    <td>  <?php echo $values[$i]['quantity']; ?>
								    		<input name="opd_product_quantity" id="opd_<?php echo $i; ?>_product_quantity"  type="hidden" value="<?php echo $values[$i]['quantity']; ?>"></input>
								     </td>
								    <td> <?php echo $values[$i]['visit_id']; ?>
											<input name="opd_product_visit_id" id="opd_<?php echo $i; ?>_visit_id" type="hidden" value="<?php echo $values[$i]['visit_id']; ?>"  />
									</td>
								    <td> <?php echo $values[$i]['location']; ?> </td>
								    <td onclick="addRow(this,<?php echo $i; ?>)"> <a href="javascript:void(0);" >Add</a> </td>
								  </tr>
								<?php  } ?>
							  </table>
							  <div class="form_left"><span style="color:#FF0000"> * Pending OPD Product</span></div>
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
