<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/scm/receive_order.js"; ?>"></script>
<title>Receive Order</title>
<script type="text/javascript">
function validateReceiveForm(){
	var retValue = true;
	hideErrorMessages();
	var x=$('#date1').val();
	var date3 = /^[0-9]{2}[\/ ]?[0-9]{2}[\/ ]?[0-9]{4}$/;
	if(date3.test(x)){
	}else{
		$('#date234').show();
		retValue = false;
	}

	var invoice_number = $("#invoicenumber").val();
	if(invoice_number == ""){
		$("#invoice_number_error").show();
		retValue = false;
	}
	
	$('input[@name^=quantity_]').each(function(){
		var attr_name = $(this).attr("name");
		var attr_name_arr = attr_name.split("_");
		var index = attr_name_arr[1];
		var qty = $("#quantity_"+index).val();
		if(qty > 0){
			var batch_number = $("#batch_"+index).val();
			if(batch_number == ""){
				$('#error_batch_'+index).show();
			 	retValue = false;
			}
			var expiry_date = $("#expiry_date_"+index).val();
			var prod_type = $("#product_type_"+index).val();
			if(prod_type != "Outpatientproducts"){
				if(expiry_date == "DD/MM/YYYY"){
					$("#error_expiry_"+index).show();
					retValue = false;
				}
			}
		}
	});
	if(!retValue){
		alert("Please fill the mandatory fields!");
	}
	$("input[type='hidden'][name^='only_generic_id_']").each(function(event){
		var className = "quantityforgeneric_"+$(this).val();
		var totalValue = 0;
		var ordered_qty = parseInt($("#orderd_qty_"+$(this).val()).val());
		$("#row_"+$(this).val()).toggleClass("invoice_table_error", false);
		$("."+className).each(function(event) {
			var value = parseInt($(this).val());
			totalValue = value + totalValue;
		});
		if(totalValue > ordered_qty){
			$("#row_"+$(this).val()).toggleClass("invoice_table_error", true);
			retValue = false;
			alert("Received qty is greater than ordered qty!");
		}
	});
	
	return retValue;
}

function hideErrorMessages(){
	$('.error').hide();
}

</script>
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
							<span class="head_box"> <?php
							echo 'Receiving Order No: '.$order_id.' placed on '.$order_date;
							?> </span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">

					<form method="post" onSubmit="return validateReceiveForm()">
						<table border="0" align="center" cellpadding="5px" cellspacing="5px">
						<tr>
							<td valign="top" align="left">
								<table cellpadding="5">
									<tr valign="top">
										<td><b>Date</b></td>
										<td><input name="date" id="date" type="text"
										value="<?php echo $date; ?>"
										class="datepicker check_dateFormat" style="width: 100px;" readonly="readonly" /> <input
										type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
										</td>
									</tr>
									<tr valign="top">
										<td><b>Order From</b>
										</td>
										<td><input type="hidden" name="from_id"
										value="<?php echo $order_from_id;?>" /> <?php echo $scm_orgs[$order_from_id];	?>
										</td>
									</tr>
									<tr valign="top">
										<td><b>Order To</b></td>
										<td><input type="hidden" name="to_id"
										value="<?php echo $order_to_id;?>" /> <?php echo $scm_orgs[$order_to_id];	?>
										<?php
										//		echo form_dropdown ( 'to_id', $scm_orgs,$order_from_id );
										?>
										</td>
									</tr>
									
								</table>
							</td>
							<td valign="top" align="left">
								<div><strong>Details</strong></div>
								<table id="details" style="border-left: 1px solid; padding: 3px" cellpadding="5">
									<tr>
												<td><b>Invoice number <span style="color:#FF0000">*</span></b></td>
												<td><b>:<b>
												
												</td>
												<td td width="300px"><input type="text" name="invoicenumber" id="invoicenumber"
													value="" size="10"><label class="error" id="invoice_number_error" style="display:none"> Field required </label>
												</td>
											</tr>
											
                                         
											<tr>
												<td><b>Invoice date <span style="color:#FF0000">*</span></b></td>
												<td><b>:<b>
												
												</td>
												<td><input id="date1" type="text"  name="invoicedate" value="DD/MM/YYYY" class="datepicker check_dateFormat" readonly="readonly"  style="width: 100px;" >
												<label class="error" id="date234" style="display:none"> Field required </label> 
												</td>
									</tr>
									
									<tr>
										<td>
											<b>Type of Node</b>
											</td>
											<td> <b>:<b> </td>
											<td>
												<?php if(isset($is_external)) echo "Purchase"; else echo "Goods Received";  ?>
												<input type="hidden" name="type_of_good" value = "<?php if(isset($is_external)) echo "Purchase"; else echo "Goods Received";  ?>">
												
											</td>
										</tr>
										<tr>
											<td>
												<b>Total Budget Rate</b>
											</td>
											<td> <b>:<b> </td>
											<td id="total_budgeted_value">
												
											</td>
										</tr>
										<tr>
											<td>
												<b>Total Actual Rate</b>
											</td>
											<td> <b>:<b> </td>
											<td id="total_actual_value">
												
											</td>
										</tr>
										<tr>
										<?php if(isset($is_external))
										 echo "	<td>
												<b>VAT</b>
											</td>
											<td> <b>:<b> </td>
											<td>
												<input type=\"text\" size=\"5\" name=\"vat_percent\" value=\"4\" id=\"vat_percent\" /> <span style=\"font-size:10px;\">%&nbsp;&nbsp;&nbsp;&nbsp;</span><b>VAT Amount &nbsp;&nbsp;:</b>&nbsp;&nbsp;<span id=\"vat\" style=\"align:left\"></span>
												<input type=\"hidden\" name=\"vat\" id=\"vat_amount\" size=\"6\"> 
											</td> "
										?>
										</tr>
										<tr>
										<?php if(isset($is_external))
										 echo "<td>
												<b>Shipping Cost</b>
											</td>
											<td> <b>:<b> </td>
											<td>
												<input type=\"text\" size=\"5\" name=\"shipping_cost\" value =\"0\" id=\"shipping_cost\">
											</td> "
										?>	
										</tr>
										<tr>
										<?php if(isset($is_external))
										 echo "<td>
												<b>Total Invoice Value</b>
											</td>
											<td> <b>:<b> </td>
											<td id=\"total_amount\">
											</td>
											<input type=\"hidden\" name=\"bill_amount\" id=\"bill_amount\" size=\"6\"> "
										?>	
										</tr>
									</table>
								</td>
							</tr>			
							
							<tr>
								<td colspan="2">
									<table width="100%" id="table_grey_border" class="invoice_table">
										<tr class="scm_head">
											<td width="5%">SN</td>
											<td width="20%">Generic Name</td>
											<td width="5%">Qty Ordered</td>
											<td width="7%">Product/<br />Type</td>
											<td width="10%">Visit Id</td>
											<td width="5%">Brand Name</td>
											<td width="5%">Current Stock</td>
											<td width="5%">Budgeted Rate</td>
											<td width="5%">Actual Rate</td>
											<td width="5%">Qty Received</td>
											<td width="5%">Batch No<span style="color:#FF0000">*</span></td>
											<td width="13%">Expiry<span style="color:#FF0000">*</span></td>
											<td width="5%">Amount</td>
											<td width="5%">Action</td>
										</tr>
										<?php
										$i=0;
										echo '<input type="hidden" name="number_items" id="number_items" value="'.$number_items.'" />'."\n";
										for($i=0; $i < $number_items ; $i++)
										{
											echo '<tr id="row_'.$order_items[$i]['generic_id'].'">'."\n";
											echo '<td valign="top">'.($i+1).'</td>'."\n";
											echo '<td valign="top" width="11%">'.$order_items[$i]['generic_name'].' - '.$order_items[$i]['strength'].'</td>'."\n";
											echo '<td valign="top">'.$order_items[$i]['quantity'].' '.$order_items[$i]['unit'].'(s)'.'<input type="hidden" id="orderd_qty_'.$order_items[$i]['generic_id'].'" value="'.$order_items[$i]['quantity'].'" /></td>'."\n";
											echo '<td valign="top" id="type_'.$i.'">'.$order_items[$i]['type'].'<br />'.$order_items[$i]['opd_type'].'</td>'."\n";
											$visit_url=$this->config->item('base_url').$visit_link_url.$order_items[$i]['visit_id'];
											echo '<td valign="top" ><a href="'.$visit_url.'">'.$order_items[$i]["visit_id"].'</a></td>'."\n";
											echo '<td valign="top"><input type="hidden" id="visit_id_'.$i.'" name="visit_id_'.$i.'" value="'.$order_items[$i]["visit_id"].'"/>';
											$js = 'id="product_id_'.$i.'" onchange="brand_selected('.$i.');" style="width:130px"';
											$default_brand_id = $order_items[$i]['d_brand_id'];
											echo form_dropdown ( 'product_id_'.$i, $order_items[$i]['brand_names'],$default_brand_id , $js);
											echo '';
											echo '<div id="brand_name_new_div_'.$i.'"></div></td>'."\n";
											for($j=0; $j < $order_items[$i]['num_brands'] ; $j++)
											{
											$brand_id = $order_items[$i]['brand_ids'][$j];
											echo '<input type="hidden" id="stock_'.$brand_id.'" name="stock_'.$brand_id.'" value="'.$order_items[$i]['stocks'][$brand_id].'"/>'."\n";
											echo '<input type="hidden" id="rate_'.$brand_id.'" name="rate_'.$brand_id.'" value="'.$order_items[$i]['rates'][$brand_id].'"/>'."\n";
											}
											echo '<td valign="top">'
													.'<div id="stock_visible_'.$i.'">'.$order_items[$i]['stocks'][$default_brand_id].'</div>'
												.'<div id="current_stock_new_div_'.$i.'"></div></td>'."\n";
											echo '<td valign="top">'
													.'<div  id="rate_visible_'.$i.'">'.$order_items[$i]['rates'][$default_brand_id].'</div>'.
												 '<div id="rate_visible_new_div_'.$i.'"></div></td>'."\n";
											echo '<td valign="top"><input style="width: 50px;" type="text" name="actual_rate_'.$i.'" id="actual_rate_'.$i.'" value="'.$order_items[$i]['rates'][$default_brand_id].'" size="4"  />
													<div id="actuall_rate_new_div_'.$i.'"></div></td>'."\n";
											echo '<td valign="top">
													<input type="text" style="width: 50px;" name="quantity_'.$i.'" id="quantity_'.$i.'" value="'.$order_items[$i]['quantity'].'" class="quantityforgeneric_'.$order_items[$i]['generic_id'].'" size="4" />
													<div id="quantity_new_div_'.$i.'"></div></td>'."\n";
											echo '<td valign="top">
													<input type="text" style="width: 80px;" id="batch_'.$i.'"  name="batch_'.$i.'" size="6" value="'.$order_items[$i]['d_batch_no'].'" />  <br /> <label class="error" id="error_batch_'.$i.'" style="display:none"> Field required </label> 
													<div id="batch_new_div_'.$i.'"></div></td> '."\n";
											if($order_items[$i]["type"]=="Outpatientproducts"){
												echo '<td valign="top"><input type="text" id="expiry_date_'.$i.'" name="expiry_'.$i.'" value="'.$order_items[$i]['d_expiry'].'"  style="width:95px;" disabled />'."\n";
												echo '<input type="hidden"  name="expiry_'.$i.'" value="" /><input type="hidden"  id="product_type_'.$i.'" value="'.$order_items[$i]["type"].'" />
													  <div id="expiry_date_new_div_'.$i.'"></div>
													</td>'."\n";
											}else{
												echo '<td valign="top">
													<input type="text" id="expiry_date_'.$i.'" name="expiry_'.$i.'" value="'.$order_items[$i]['d_expiry'].'" readonly="readonly" style="width:95px;"/>
													<br /> <label class="error" id="error_expiry_'.$i.'" style="display:none"> Field required </label> <div id="expiry_date_new_div_'.$i.'"></div>
													</td>'."\n";
											}
											//echo '<input type="hidden" name="rate_'.$i.'" id="rate_'.$i.'" value="'.$order_items[$i]['rates'][$default_brand_id].'"/>'."\n";
											echo '<td valign="top">'
													.'<div id="total_'.$i.'">'.$order_items[$i]['rates'][$default_brand_id] * $order_items[$i]['quantity'].'</div>
													<div id="total_new_div_'.$i.'"></div></td>'."\n";
											echo '<td valign="top" id="split_td_'.$i.'" >
													<div id="split_td_old_'.$i.'"><a href="javascript:void(0);" onclick="split_row('.$i.')">Split</a></div>
													<div id="split_td_new_'.$i.'"></div></td>'."\n";
											echo '</tr>'."\n";
											echo '<input type="hidden" name="generic_id_'.$i.'" id="generic_id_'.$i.'" value="'.$order_items[$i]['generic_id'].'"/>'."\n";
											echo '<div id="new_generic_id_div_'.$i.'"></div>';
											echo '<div><input type="hidden" name="only_generic_id_'.$i.'" value="'.$order_items[$i]['generic_id'].'" /></div>'."\n";
										}
										?>
	
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<table width="100%">
										<tr>
											<td align="right">
												<b>Comment</b> <input type=text size=50 name="comment" /> 
											</td>
											<td align="right">
												<input type="submit" class="submit" value="Confirm Order Receipt" />
											</td>
										</tr>
									</table>
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
	<?php
	$this->load->view ( 'common/footer' );
	?>