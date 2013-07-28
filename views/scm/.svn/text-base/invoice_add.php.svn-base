<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.5.2.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<title>Generate Invoice / Goods Movement Note</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>

<script type="text/javascript">
var sc_licence_list = new Array();      
sc_licence_list = [      
<?php
foreach ($scm_with_license_list as $key => $license_no){
?>
{id: '<?php echo $key; ?>', license_no: '<?php echo $license_no; ?>'},
<?php
}
?>
];
$(document).ready(function(){
	$("#bill_amount_visible").text(0);

	$("#get_total").click(function(){
	  var num_items = Number($('#number_items').val());
	  var total = 0.0;
	  var i = 0;
	  for (i=0; i < num_items; i++)
	  {
		var t_total = 0.0;
		var qty = Number($('#quantity_' + i).val());	
		var rate = Number($('#rate_' + i).val());	
		if(qty != 0)
			t_total = Number(qty * rate);
		else
			t_total = 0.0;
		total =  Number(total +  t_total);
		t_total = t_total.toFixed(0);
		$('#total_' + i).text(t_total);
	  }
	  total = total.toFixed(0);
	  $('#bill_amount').val(total);
	  $('#bill_amount_visible').text(total);
	});

	$('#from_id').change(function(){		
		var to_id = $('#to_id').val();
		var from_id = $('#from_id').val();	
		$('#from_id option[value="'+to_id+'"]').remove();
		var str= "";
		for(var i=0; i<sc_licence_list.length;i++){
			var licence_obj = sc_licence_list[i];
			if(licence_obj.id == from_id){
				str = licence_obj.license_no;
				break;
			}
		}
		$("#reg_id").text(str);
		
	});
	$('#from_id').change();
	
	

	//populate change quantity
	$("input[type='text'][name^='quantity_']").change(function(event){
		updateTotals();
	});
	//populate_details();
	$("input[type='text'][name^='quantity_']").change();
});

function updateTotals(){
	$("input[type='text'][name^='quantity_']").each(function(event){
		//var dom_element =  event.target;
		var attr_name = $(this).attr("name");
		var attr_name_arr = attr_name.split("_");
		var product_id = $('#product_id_' + attr_name_arr[1]).val();
		var item_rate = $('#rate_' + product_id).val();
		//var item_value = $('[input[type="hidden"][name="rate_'+attr_name_arr[1]+'"]').val();
		var item_quantity = $(this).val();
		if(item_quantity == '' || isNaN(item_quantity)){
			item_quantity = 0;
			var tempValue = $(this).val();
			tempValue = item_quantity;
		}
		var total_amount = parse_round_number(parse_round_number(item_quantity)*parse_round_number(item_rate));
		if(total_amount == '' || isNaN(total_amount)){
			total_amount=0;
		}
		$("#amount_div_"+attr_name_arr[1]).html(total_amount+"");
	});
	populate_details();
}


function validateInvoiceForm(){
	clearAllErrorMessages();
	var retValue = true;
	//get entered date
	var entered_date=$('#date').val();
	var entered_split_date=entered_date.split("/");
	var formatted_entered_date=Date.parse(entered_split_date[1]+"/"+entered_split_date[0]+"/"+entered_split_date[2]);

	//get today date
	var today_date=$('#today_date').val();
	var today_split_date=today_date.split("/");
	var formatted_today_date=Date.parse(today_split_date[1]+"/"+today_split_date[0]+"/"+today_split_date[2]);

	//get order date
	var order_date=$('#order_date').val();
	var order_split_date=order_date.split("-");
	var formatted_order_date=Date.parse(order_split_date[1]+"/"+order_split_date[2]+"/"+order_split_date[0]);
	//alert(formatted_entered_date+"--"+formatted_today_date+"-"+formatted_order_date);
	
	if(formatted_entered_date>formatted_today_date){
		$('#future_date').show();
		retValue = false;
	}

	if(formatted_entered_date<formatted_order_date){
		$('#order_date_error').show();
		retValue = false;
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
			alert("Invoiced qty is greater than ordered qty!");
		}
	});
	
	return retValue;
}
function clearAllErrorMessages(){
	$('.error').hide();
}

function parse_round_number(num) {
	num = parseFloat(num);
	var result = Math.round(num*Math.pow(10,2))/Math.pow(10,2);
	return result;
}

function populate_details(){
	var total_value = 0; 
	$.each($("input[type='text'][name^='quantity_']"), function(index,value){
		
		var attr_name = value.name;
		var attr_name_arr = attr_name.split("_");
		var product_id = $('#product_id_' + attr_name_arr[1]).val();
		var item_rate = $('#rate_' + product_id).val();
		if(item_rate == '' || isNaN(item_rate)){
			item_rate=0;
		}
		var item_actuall_value = value.value;
		//alert(item_actuall_value);
		total_value = total_value + (item_rate * item_actuall_value);
		//alert(total_value);
	});
	$("#total_invoice").html(parse_round_number(total_value)+"");
}

function brand_selected(index) {
  	var product_id = $('#product_id_' + index).val();
  	var stock = $('#stock_' + product_id).val();
  	
  	var rate = $('#rate_' + product_id).val();
  	//$('#stock_visible_' + index).text(stock);
  	$('#rate_visible_' + index).text(rate);
  	$('#rate_' + index).val(rate);
  	update_batch_wise_stock(index,product_id);
	return true;
}

function batch_change(index){
	var product_id = $('#product_id_' + index).val();
	var batch_number = $('#batch_number_' + index +' option:selected').text();
	update_batch_wise_stock(index,product_id,batch_number);
	
}

function update_batch_wise_stock(index,product_id,batch_number) {
	if(batch_number == null || batch_number == undefined){
		batch_number = "";
	}
	var from_id = $("#from_id").val();
	$.ajax({
		type: "POST",
		url: "<?php echo $this->config->item('base_url').'index.php/scm/order/get_batch_numbers/';?>",
		dataType: "json",
		data: {
   		 	product_id:product_id,
   		 	batch_number:batch_number,
   		 	from_id:from_id
		},
		success: function(result) {
			//Clear batch stock and expiry
			$('#batch_expiry_display_'+index).text("Empty");
			$('#batch_stock_display_'+index).text("0");
			//Clear Hidden fields values
			$('#batch_stock_visible_'+index).val("0");
			$('#batch_expiry_visible_'+index).val("");
			var select = $('#batch_number_' + index);
			if(select.prop) {
				var options = select.prop('options');
			}else {
				var options = select.attr('options');
			}
			if(batch_number == undefined || batch_number == ""){
				$('option', select).remove();
			}
			var obj = jQuery.parseJSON(result);
			var i = 0;
			var selectedValue = "";
			$.each(obj.data,function(key,value){
				if(batch_number == undefined  || batch_number == ""){
					options[options.length] = new Option(value.batch_number, value.batch_number);
				}
				if(i == 0){
					//update batch stock and expiry
					$('#batch_stock_display_'+index).text(value.stock);
					$('#batch_expiry_display_'+index).text(value.expiry);
					//upate Hidden fields values
					$('#batch_stock_visible_'+index).val(value.stock);
					$('#batch_expiry_visible_'+index).val(value.expiry);
				}
				i++;
			});
			//$("input[type='text'][name^='quantity_']").change();
			updateTotals();
			var stock_in_batch = $('#batch_stock_visible_' + index).val();
		  	var invoiced_qty = $('#actuall_quantity_' + index).val();
		  	if(parseInt(stock_in_batch) < parseInt(invoiced_qty)){
		  		$('#quantity_visible_txt_' + index).val(stock_in_batch);
		  	}else{
		  		$('#quantity_visible_txt_' + index).val(invoiced_qty);
		  	}
		},
		failure : function(){
			alert("failed");
		},
		error : function(e){
			alert("error");
		}
	});
}

function split_row(index) {
	
	var total_items = $("#number_items").val();
	var i = parseInt(total_items);
	var table = $("#table_grey_border");
	//Brand Name seectbox
	var brand_name_html = '<select style="width:140px" onchange="brand_selected('+i+');" id="product_id_'+i+'" name="product_id_'+i+'">'+$("#product_id_"+index).html()+'</select><input type="hidden" id="visit_id_'+i+'"  name="visit_id_'+i+'" value="'+$("#visit_id_"+index).val()+'"/>';
	brand_name_html = brand_name_html +'<div id=brand_new_row_'+i+'></div>';
	$("#brand_new_row_"+index).html(brand_name_html);

/*	//Total Stock
	var total_stock_visible = $("#stock_visible_"+index).text();
	total_stock_visible = '<div id="stock_visible_'+i+'">'+total_stock_visible+'</div><div id="total_stock_new_row_'+i+'"></div>';
	$("#total_stock_new_row_"+index).html(total_stock_visible);*/
	batch_change(i);
	//Batch name
	var batch_name_html = '<select style="width:90px" onchange="batch_change('+i+');" id="batch_number_'+i+'" name="batch_name_'+i+'">'+$("#batch_number_"+index).html()+'</select>';
	batch_name_html = batch_name_html +'<div id=batch_name_new_row_'+i+'></div>';
	$("#batch_name_new_row_"+index).html(batch_name_html);
	
	//Stock for batch
	var batch_stock_visible = $("#batch_stock_visible_"+index).val();
	var batch_stock_visible_html ='<span id="batch_stock_display_'+i+'">'+batch_stock_visible+'</span><input type="hidden" id="batch_stock_visible_'+i+'" name="batch_stock_'+i+'" value = "'+batch_stock_visible+'" />';
	batch_stock_visible_html = batch_stock_visible_html + '<div id="batch_stock_new_'+i+'"></div>';
	$("#batch_stock_new_"+index).html(batch_stock_visible_html);

	//Batch expiry
	var batch_expiry_visible = $("#batch_expiry_visible_"+index).val();
	var batch_expiry_visible_html ='<span id="batch_expiry_display_'+i+'">'+batch_expiry_visible+'</span><input type="hidden" id="batch_expiry_visible_'+i+'" name="batch_expiry_'+i+'" value = "'+batch_expiry_visible+'" />';
	batch_expiry_visible_html = batch_expiry_visible_html + '<div id="batch_expiry_new_'+i+'"></div>';
	$("#batch_expiry_new_"+index).html(batch_expiry_visible_html);

	//Rate
	var existing_rate = $("#rate_visible_"+index).text();
	var rate_html = '<div id="rate_visible_'+i+'">'+existing_rate+'</div><div id="rate_visible_new_'+i+'"></div>';
	$("#rate_visible_new_"+index).html(rate_html);

	
	var genericId = $("#generic_id_"+index).val();
	//Quantity invoiced
	var actuall_qty = $("#actuall_quantity_"+index).val();
	var qty_invoiced = $("#quantity_visible_txt_"+index).val();
	var remaing_qty = actuall_qty - qty_invoiced;
	var qty_invoice_html = '<input type="text" name="quantity_'+i+'" id="quantity_visible_txt_'+i+'" class= "quantityforgeneric_'+genericId+'" value="'+remaing_qty+'" size="3" />';
	qty_invoice_html = qty_invoice_html + '<input type="hidden" id="actuall_quantity_'+i+'" value="'+remaing_qty+'" size="3" />';
	qty_invoice_html = qty_invoice_html + '<div id="quantity_visible_new_'+i+'"></div>';
	$("#quantity_visible_new_"+index).html(qty_invoice_html);
	$("#quantity_visible_txt_"+i).change(function(event) {
		updateTotals();
	});
	//Amount
	var amount = $("#amount_div_"+index).text();
	var amount_html = '<div id="amount_div_'+i+'">'+amount+'</div><div id="total_new_'+i+'"></div>';
	$("#total_new_"+index).html(amount_html);

	//Split row
	$("#split_td_old_"+index).html("");
	var split_html = '<div id="split_td_old_'+i+'"><a href="javascript:void(0);" onclick="split_row('+i+')">Split</a></div><div id="split_td_new_'+i+'"></div>';
	$("#split_td_new_"+index).html(split_html);

	//Generic ID
	
	var generic_id_html = '<input type="hidden" name="generic_id_'+i+'" id="generic_id_'+i+'" value="'+genericId+'"/>'+"\n";
	generic_id_html = generic_id_html + '<div id="new_generic_id_div_'+i+'"></div>';
	$("#new_generic_id_div_"+index).html(generic_id_html);
	
	$("#number_items").val(i+1);
	populate_details();
	
}
</script>

<div id="main">
	<table width="100%" align="center">
		<tr>
			<td>
				<div class="blue_left">
					<div class="blue_right">
						<div class="blue_middle">
							<span class="head_box">
								<?php
									echo 'Processing Order No: '.$order_id.' placed on '.$order_date;
								?>
							</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">
					<form method="post" onSubmit="return validateInvoiceForm()">
						<table border="0" align="" width="100%" cellspacing="5" cellpadding="0">
							<tr>
								<td valign="top" align="left">
									<table cellpadding="7">
										<tr valign="top">
										     <td><b>Date</b> </td>
										     <td>
										       <input name="date" id="date" type="text" value="<?php echo $date; ?>" class="datepicker check_dateFormat" readonly="readonly" size="8"/>
												 <input name="today_date" id="today_date" type="hidden" value="<?php echo $today_date; ?>" />
												 <input name="order_date" id="order_date" type="hidden" value="<?php echo $order_date; ?>" />
												 <?php
													$date_format = explode("-", $order_date);
													$new_date=$date_format[2].'/'.$date_format[1].'/'.$date_format[0];
												?>
												<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
												<label class="error" id="future_date" style="display:none"> Date cannot be set in future</label>
												<label class="error" id="order_date_error" style="display:none"> Date selected should not be before <?php echo $new_date; ?></label>
										     </td>
						     			</tr>
										<tr valign="top">
											<td><b>Invoice From</b></td>
											<td>
												<input type="hidden" id="from_id" name="from_id" value="<?php echo $order_to_id;?>" /> <b><?php echo $scm_orgs[$order_to_id];	?></b>
											</td>
										</tr>
										<tr valign="top">	
											<td><b>Invoice To</b></td>
											<td>
											<input type="hidden" id="to_id" name="to_id" value="<?php echo $order_from_id;?>" /> <b><?php echo $scm_orgs[$order_from_id];	?></b>
												<?php 
												//echo form_dropdown ( 'to_id', $scm_orgs,$order_from_id, 'id="to_id" style="width:260px"');
												?>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top" align="left" width="40%">
									<div><strong>Details</strong></div>
									<table id="details" style="border-left: 1px solid; padding: 3px" cellpadding="5">
										
										<tr>
											<td>
												<b>Registration Id</b>
											</td>
											<td> <b>:<b> </td>
											<td id ="reg_id"></td>
										</tr>
										
										<tr>
											<td>
												<b>Type of Node</b>
											</td>
											<td> <b>:<b> </td>
											<td>
												<input type="text" name="type" style="display:none" value="Goods Sent">Goods Sent</input>
							     			</td>
										</tr>
										<tr>
											<td>
												<b>Total Invoice Amount</b>
											</td>
											<td> <b>:<b> </td>
											<td id ="total_invoice"></td>
										</tr>
									</table>
								 </td>
						    </tr>
							<tr><td colspan ="4">
							    <table width="100%" id="table_grey_border" class="invoice_table">
									<tr class="scm_head">
									  <td width="2%">SN</td>
									  <td width="30%">Generic Name</td>
									  <td width="3%">Qty Ordered</td>
									  <td width="5%">Total Stock</td>
									  <td width="4%">Visit Id</td>
									  <td width="15%">Brand Name</td>
									  <td width="10%">Batch Number</td>
									  <td width="3%">Stock<br />in<br />Batch</td>
									  <td width="7%">Expiry</td>
									  <td width="3%">Rate</td>
									  <td width="7%">Qty Invoiced</td>
									  <td width="5%">Amount</td>
									  <td width="5%">Action </td>
									</tr>
									<?php
										if(sizeof($order_items) === 0){
											echo '<tr>'."\n";
											echo '<td valign="top" colspan = "10" align="center"><strong>No Items Found</strong></td>'."\n";
										}else{
											$i=0;
											echo '<input type="hidden" name="number_items" id="number_items" value="'.$number_items.'" />'."\n";
											for($i=0; $i < $number_items ; $i++)
											{
												echo '<tr id="row_'.$order_items[$i]['generic_id'].'">'."\n";
												echo '<td valign="top"><div>'.($i+1).'</div></td>'."\n";
												echo '<td valign="top" id="generic_name_'.$i.'"><span>'.$order_items[$i]['generic_name'].' - '.$order_items[$i]['strength'].'</span></td>'."\n";
												echo '<td valign="top" id="quantity_'.$i.'"><span>'.$order_items[$i]['quantity'].' '.$order_items[$i]['unit'].'(s)'.'</span><input type="hidden" id="orderd_qty_'.$order_items[$i]['generic_id'].'" value="'.$order_items[$i]['quantity'].'" /></td>'."\n";
												$default_brand_id = $order_items[$i]['d_brand_id'];
												echo '<td valign="top"><div id="stock_visible_'.$i.'">'.$order_items[$i]['total_qty_in_place'].' '.$order_items[$i]['unit'].'(s)'.
												'</div><div id="total_stock_new_row_'.$i.'"></div></td>'."\n";
												$visit_url=$this->config->item('base_url').$visit_link_url.$order_items[$i]['visit_id'];
												echo '<td valign="top"><a href="'.$visit_url.'">'.$order_items[$i]['visit_id'].'</a></td>'."\n";
												echo '<td valign="top" id="product_id_select_'.$i.'"><input type="hidden" id="visit_id_'.$i.'" name="visit_id_'.$i.'" value="'.$order_items[$i]["visit_id"].'"/>';
												$js = 'id="product_id_'.$i.'" onchange="brand_selected('.$i.');" style="width:140px"';
												
												echo form_dropdown ( 'product_id_'.$i, $order_items[$i]['brand_names'],$default_brand_id , $js);
												echo '<div id="brand_new_row_'.$i.'"></div></td>'."\n";
												for($j=0; $j < $order_items[$i]['num_brands'] ; $j++){
													$brand_id = $order_items[$i]['brand_ids'][$j];
													echo '<input type="hidden" id="stock_'.$brand_id.'" name="stock_'.$brand_id.'" value="'.$order_items[$i]['stocks'][$brand_id].'"/>'."\n";
													echo '<input type="hidden" id="rate_'.$brand_id.'" name="rate_'.$brand_id.'" value="'.$order_items[$i]['rates'][$brand_id].'"/>'."\n";
												}
												
												$js = 'style="width:90px" id="batch_number_'.$i.'" onchange="batch_change('.$i.');"';
												echo '<td valign="top" id="batch_number_td_'.$i.'">'.
														form_dropdown ( 'batch_name_'.$i, $order_items[$i]['d_batch_names'],"",$js).
														'<div id="batch_name_new_row_'.$i.'"></div></td>'."\n";
												echo '<td valign="top" id="batch_stock_'.$i.'">'.
														'<span id="batch_stock_display_'.$i.'">'.$order_items[$i]['d_batch_stock'].'</span>'.
														'<input type="hidden" id="batch_stock_visible_'.$i.'" name="batch_stock_'.$i.'" value = "'.$order_items[$i]['d_batch_stock'].'" />'.
														'<div id="batch_stock_new_'.$i.'"></div></td>'."\n";
												echo '<td valign="top" id="batch_expiry_'.$i.'">'.
														'<span id="batch_expiry_display_'.$i.'">'.$order_items[$i]['d_batch_expiry'].'</span>'.
														'<input type="hidden" name="batch_expiry_'.$i.'" id="batch_expiry_visible_'.$i.'" value = "'.$order_items[$i]['d_batch_expiry'].'" />'.
														'<div id="batch_expiry_new_'.$i.'"></div></td>'."\n";
												echo '<td valign="top"><div id="rate_visible_'.$i.'" name="rate_visible_'.$i.'">'.
														$order_items[$i]['rates'][$default_brand_id].
														'</div><div id="rate_visible_new_'.$i.'"></div></td>'."\n";
												if($order_items[$i]['total_qty_in_place']!=0){
													if($order_items[$i]['d_batch_stock'] >$order_items[$i]['quantity']){
														echo '<td valign="top" id="quantity_visible_'.$i.'">
															<input type="text" name="quantity_'.$i.'" id="quantity_visible_txt_'.$i.'" value="'.$order_items[$i]['quantity'].'" class="quantityforgeneric_'.$order_items[$i]['generic_id'].'" size="3" />
															<input type="hidden" id="actuall_quantity_'.$i.'" value="'.$order_items[$i]['quantity'].'" size="3" />
															<div id="quantity_visible_new_'.$i.'"></div></td>'."\n";
													}else{
														echo '<td valign="top" id="quantity_visible_'.$i.'">
															<input type="text" name="quantity_'.$i.'" id="quantity_visible_txt_'.$i.'" value="'.$order_items[$i]['d_batch_stock'].'" class="quantityforgeneric_'.$order_items[$i]['generic_id'].'" size="3" />
															<input type="hidden" id="actuall_quantity_'.$i.'" value="'.$order_items[$i]['quantity'].'" size="3" />
															<div id="quantity_visible_new_'.$i.'"></div></td>'."\n";
													}
												}else{
													echo '<td valign="top" id="quantity_visible_'.$i.'">
														<input type="text" name="quantity_'.$i.'" id="quantity_visible_txt_'.$i.'" value="0" class="quantityforgeneric_'.$order_items[$i]['generic_id'].'" size="3" readonly/></td>'."\n";
												}
												echo '<td valign="top" id="total_'.$i.'" >
														<div id="amount_div_'.$i.'">'.$order_items[$i]['rates'][$default_brand_id]*$order_items[$i]['quantity'].'</div>
														<div id="total_new_'.$i.'"></div></td>'."\n";
												if($order_items[$i]['total_qty_in_place']!=0){
													echo '<td valign="top" id="split_td_'.$i.'" ><div id="split_td_old_'.$i.'"><a href="javascript:void(0);" onclick="split_row('.$i.')">Split</a>
														</div><div id="split_td_new_'.$i.'"></div></td>'."\n";
												}else{
													echo '<td valign="top" id="split_td_'.$i.'" ><div id="split_td_old_'.$i.'">Split
														</div></td>'."\n";
												}
												echo '</tr>'."\n";
												echo '<input type="hidden" name="rate_'.$i.'" id="rate_'.$i.'" value="'.$order_items[$i]['rates'][$default_brand_id].'"/>'."\n";
												echo '<input type="hidden" name="generic_id_'.$i.'" id="generic_id_'.$i.'" value="'.$order_items[$i]['generic_id'].'"/>'."\n";
												echo '<div id="new_generic_id_div_'.$i.'"></div>'."\n";
												echo '<div><input type="hidden" name="only_generic_id_'.$i.'" value="'.$order_items[$i]['generic_id'].'" /></div>'."\n";
											}
										}
									?>
							      </table>
							     </td>
							  </tr> 
							  <tr>
									<td colspan="4" align="right">
										<?php if(sizeof($order_items) > 0) {?>
											<b>Comment</b>
											<input type=text size=50 name="comment"/>
											<!-- <b>Order Status</b> -->
											<?php 
											//$option_arr = array ('Pending' => 'Keep Open', 'Closed' => 'Closed');
											//echo form_dropdown ( 'order_status', $option_arr,'Pending' );
											?>
											<input type="submit" class="submit" value="Create Invoice" id="button"/>
										<?php }?>
									</td>
						       </tr> 
						</table>
					</form>
				</div>
				<div>
			  		<div class="bluebtm_left"> 
			  			<div class="bluebtm_right">
			  				<div class="bluebtm_middle" /></div>
			 			</div>
			 		</div>
	         	</div>
			</td>
		</tr>
	</table>
</div>
<?php
$this->load->view ( 'common/footer' );
?>
