<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/retail_op_product.js"; ?>"></script>
<script  type="text/javascript">
// Have to assign the medications_list while inline - it should be
// be available on document load


var order_opd_products_list = new Array();      
order_opd_products_list = [      
<?php
foreach ($gx_list_opdproducts as $gx) {
	//$product=$this->product->where('id',$gx)->find();
	if($gx->product_type==='OUTPATIENTPRODUCTS'){
	  $name = $gx->name.' - '.$gx->form.'-'.$gx->strength.' '.$gx->strength_unit.' - '.$gx->capacity.' '.$gx->purchase_unit;
	  $retail_unit=$gx->retail_unit;
	  $purchase_unit=$gx->purchase_unit;
	  $mrp=$gx->mrp;
	  if($gx->capacity == 1)
		  $rate = $gx->retail_price*10;
	  else
		  $rate = $gx->retail_price;		
	?>
	{id: '<?php echo $gx->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>', retail_unit: '<?php echo $retail_unit; ?>', order_type: '<?php echo $gx->product_order_type;?>', purchase_unit: '<?php echo $purchase_unit; ?>', mrp:'<?php echo $mrp; ?>'},
	<?php
	}
	}
?>
];


</script>

<title>  Retail OP Product
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
							 Retail OP Product
								
							</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">
				<form method="post"  onSubmit="return ValidateForm()">
					<table align="center" id="table_grey_border">
						<tr>
			     			<td><b>Date</b></td>
			    			 <td >
			       				<input name="date" id="date" readonly="readonly" type="text" value="<?php echo $date; ?>" class="datepicker check_dateFormat"  style="width:100px;"  />
			     			</td>
						</tr>
						
						<tr>
						   <td>  <b> Location </b> </td>
						   <td>  <b> <?php echo $scm_orgs[$from_id];?> </b> </td>
						</tr>
						   
						<tr>
						<td><b>Type</b></td>
						<td >
						
						<b> OPD Product </b> </td>
						</tr>

						<tr>
						  <td Colspan="2">
						  	 
							
							
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
											
										  <div class="consumable_style" ><label class="error" id="error_add_opd_quantity" style="display:none"> Please enter OPD Product quantity  </label></div>
										 <div class="consumable_style" > <label class="error" id="error_numeric_opd_quantity" style="display:none">OPD Product quantity should be numeric  </label></div>
										</div>
								      </div>
								      
								      <div class="form_row">
										<div class="form_left">Product given out</div>
										<div class="form_right">
										  <input name="opd_product_order_type"  type="checkbox"  id="product_given_out"  id="visit_id_enable" />
										</div>
										
										<div class="consumable_style_opd" ><b>Ret Unit:</b></div><div  class="consumable_style_opd" id="opd_product_retail_unit" ></div>
										<div  class="consumable_style_opd" >&nbsp;&nbsp;&nbsp;<b>Purc Unit:</b></div><div  class="consumable_style_opd" id="opd_product_purchase_unit"  ></div>
										<div  class="consumable_style_opd" >&nbsp;&nbsp;&nbsp;<b>MRP:</b></div><div  class="consumable_style_opd" id="opd_product_mrp"  ></div>
										
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
										  
										    <input id="add_opd_product" type="button" value="Add" onclick="add()" />
							    			  
							    			  </div>
										</div>
								    </div>
								     </fieldset>	
							    </div>
							    
							<input id="medication_row_id" type="hidden" value="1"/>
						  </td>
						</tr>
						<tr>
						  <td colspan = "2"> <label class="error" id="error_add_row" style="display:none"> Please add atleast 1 Product  </label>  </td>
						</tr>
						<tr>
							<td colspan="2">
						      <table id="medications" cellspacing="2">
								<tr class="scm_head">
								  <td width="50%">OPD products</td>
								  <td width="10%">Qty</td>
								  <td width="11%">Type</td>
								  <td width="10%">Visit Id</td>
								  <td width="8%">Rate</td>
								  <td width="8%">Total</td>
								  <td width="10%">Remove</td>
								</tr>
							  </table>
							</td>
						</tr> 
						
						<tr> 
			     			<td colspan="2">
     				  			<div style="float:right " >
	     				  			<div style="float:left"><b>Total Retail Amount: </b>&nbsp;</div>
	         						<input type="hidden" name="bill_amount" id="bill_amount" />
	         						<div style="float:left"  id="bill_amount_visible"></div>
	         					</div>
			     				  		
			     			</td>
						</tr>
			
						<tr align=right>
							<td colspan="4">
								
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
