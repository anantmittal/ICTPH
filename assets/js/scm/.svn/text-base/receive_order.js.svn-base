$(document).ready(function(){
	$("#bill_amount").val(0);
	$("#bill_amount_visible").text(0);

	$("#get_total").click(function(){
	  var total = 0.0;
	  var num_items = Number($('#number_items').val());
	  var i = 0;
	  for (i=0; i < num_items; i++)
	  {
		var t_total = 0.0;
		var qty = Number($('#quantity_' + i).val());	
		var rate = Number($('#rate_' + i).val());	
		t_total = Number(qty * rate);
		total =  Number(total +  t_total);
		t_total = t_total.toFixed(0);
		$('#total_' + i).text(t_total);
	  }
          total = total.toFixed(0);
	  $('#bill_amount').val(total);
	  $('#bill_amount_visible').text(total);
	});
	//update_row_total_amount();
	
	//Actuall rate textbox onchange
	$('input[@name^=actual_rate_]').change(function(event){
		update_amount_on_rate_change();
	});
	
	//Actual Quantiy textbox onchange
	$('input[@name^=quantity_]').change(function(event){
		update_amount_on_quantity_change();
	});
	
	//on shipping cost change
	$("#shipping_cost").change(function(){
		populate_details();
	});
	
	//on vat change
	$("#vat_percent").change(function(){
		var vat_val = $("#vat_percent").val();
		if(vat_val == '' || isNaN(vat_val)){
			$("#vat_percent").val(0);
		}
		populate_details();
	});
	
	$('input[@name^=expiry_]').each(function(){
		$(this).datepicker({buttonImage: base_url + 'assets/images/common_images/img_datepicker.gif', changeYear: true, yearRange: '2010:2030', dateFormat: 'dd/mm/yy'});
	});
	
	populate_details();
	
});

function update_amount_on_rate_change(){
	$('input[@name^=actual_rate_]').change(function(event){
		var dom_element = event.target;
		var attr_name = dom_element.name;
		var attr_name_arr = attr_name.split("_");
		var item_quantity = $('input[@name="quantity_'+attr_name_arr[2]+'"]').val();
		var item_value = dom_element.value;
		if(item_value == '' || isNaN(item_value)){
			item_value = 0;
			dom_element.value = item_value;
		}
		$("#total_"+attr_name_arr[2]).html(parse_round_number(parse_round_number(item_quantity)*parse_round_number(item_value))+"");
		populate_details();
		
	});
}

function update_amount_on_quantity_change(){
	$('input[@name^=quantity_]').change(function(event){
		var dom_element =  event.target;
		var attr_name = dom_element.name;
		var attr_name_arr = attr_name.split("_");
		var item_value = $('input[@name="actual_rate_'+attr_name_arr[1]+'"]').val();
		var item_quantity = dom_element.value
		if(item_quantity == '' || isNaN(item_quantity)){
			item_quantity = 0;
			dom_element.value = item_quantity;
		}
		$("#total_"+attr_name_arr[1]).html(parse_round_number(parse_round_number(item_quantity)*parse_round_number(item_value))+"");
		populate_details();
		
	});
}

function populate_details(){
	var total_actual_value = 0; 
	var total_budgeted_value = 0; 
	$.each($('input[@name^=actual_rate_]'), function(index,value){
		//To get Array index
		var attr_name = value.name;
		var attr_name_arr = attr_name.split("_");
		
		//To get actuall value total
		var item_quantity = $('input[@name="quantity_'+attr_name_arr[2]+'"]').val();
		var item_actuall_value = value.value;
		total_actual_value = total_actual_value + (item_quantity * item_actuall_value);
		
		//To get budgeted value total
		var item_budgeted_value = $("#rate_visible_"+attr_name_arr[2]).html();
		total_budgeted_value = total_budgeted_value + (item_quantity * item_budgeted_value)
	});
	
	var shipping_cost = $("#shipping_cost").val();
	if($.trim(shipping_cost) == '' || isNaN(shipping_cost)){
		shipping_cost = 0;
		$("#shipping_cost").val(shipping_cost);
	}
	
	$("#total_actual_value").html(parse_round_number(total_actual_value));
	$("#total_budgeted_value").html(parse_round_number(total_budgeted_value));
	//caluculate vat for actual value considering default value as 4 %
	var vat_value = (parseFloat(total_actual_value) * parseFloat($("#vat_percent").val())) / 100;
	//if($("#vat_percent").val() != '' || !isNaN($("#vat_percent").val()) || $("#vat_percent").val() != 0){
	//	vat_value = parse_round_number($("#vat_percent").val());
	//}
	$("#vat_amount").val(parse_round_number(vat_value,2));
	$("#vat").html(parse_round_number(vat_value,2));
	
	//Calculate Total amount
	var total_amount = parse_round_number(total_actual_value) + parse_round_number(shipping_cost) + vat_value;
	$("#total_amount").html(parse_round_number(total_amount)+"");
	
}

function parse_round_number(num) {
	num = parseFloat(num);
	var result = Math.round(num*Math.pow(10,2))/Math.pow(10,2);
	return result;
}

function brand_selected(index) {
	/*	  alert ("index: "+ index );*/
		  var product_id = $('#product_id_' + index).val();
	/*	  alert ("product_id: " + product_id);*/
		  var stock = $('#stock_' + product_id).val();
		  var rate = $('#rate_' + product_id).val();
		  $('#stock_visible_' + index).text(stock);
		  $('#rate_visible_' + index).text(rate);
		  $('#rate_' + index).val(rate);
		  $('input[@name=actual_rate_'+index+']').val(rate);
		  $('input[@name=actual_rate_'+index+']').trigger('change');
		  return true;
		}

function split_row(index) {
	var total_items = $("#number_items").val();
	var i = parseInt(total_items);
	
	//Brand Name seectbox
	var brand_name_html = '<select style="width:130px" onchange="brand_selected('+i+');" id="product_id_'+i+'" name="product_id_'+i+'">'+$("#product_id_"+index).html()+'</select><input type="hidden" id="visit_id_'+i+'"  name="visit_id_'+i+'" value="'+$("#visit_id_"+index).val()+'"/>';
	brand_name_html = brand_name_html +'<div id=brand_name_new_div_'+i+'></div>';
	$("#brand_name_new_div_"+index).html(brand_name_html);
	
	//Current Stock
	var stock_visible = $("#stock_visible_"+index).text();
	var stock_visible_html ='<div id="stock_visible_'+i+'">'+stock_visible+'</div>';
	stock_visible_html = stock_visible_html + '<div id="current_stock_new_div_'+i+'"></div>';
	$("#current_stock_new_div_"+index).html(stock_visible_html);
	
	//Budgeted Rate
	var rate_visible = $("#rate_visible_"+index).text();
	var rate_visible_html ='<div id="rate_visible_'+i+'">'+rate_visible+'</div>';
	rate_visible_html = rate_visible_html + '<div id="rate_visible_new_div_'+i+'"></div>';
	$("#rate_visible_new_div_"+index).html(rate_visible_html);
	
	//Actuall Rate
	var actuall_rate = $("#actual_rate_"+index).val();
	var actuall_rate_html ='<input style="width: 50px;" type="text" name="actual_rate_'+i+'" id="actual_rate_'+i+'" value="'+actuall_rate+'" size="4"  />';
	actuall_rate_html = actuall_rate_html + '<div id="actuall_rate_new_div_'+i+'"></div>';
	$("#actuall_rate_new_div_"+index).html(actuall_rate_html);
	update_amount_on_rate_change();
	var genericId = $("#generic_id_"+index).val();
	
	//Quantity
	var qty = $("#quantity_"+index).val();
	var qty_html ='<input type="text" style="width: 50px;" name="quantity_'+i+'" id="quantity_'+i+'" value="'+qty+'" class= "quantityforgeneric_'+genericId+'" size="4" />';
	qty_html = qty_html + '<div id="quantity_new_div_'+i+'"></div>';
	$("#quantity_new_div_"+index).html(qty_html);
	update_amount_on_quantity_change();
	//Batch Name
	var batch_name = $("#batch_"+index).val();
	var batch_name_html ='<input type="text" style="width: 80px;" id="batch_'+i+'"  name="batch_'+i+'" size="6" value="'+batch_name+'" />'
						+ '<br /> <label class="error" id="error_batch_'+i+'" style="display:none"> Field required </label>';
	batch_name_html = batch_name_html + '<div id="batch_new_div_'+i+'"></div>';
	$("#batch_new_div_"+index).html(batch_name_html);
	
	//Expiry
	var expiry_date = $("#expiry_date_"+index).val();
	var prod_type = $("#product_type_"+index).val();
	var expiry_date_html ='<input type="text" id="expiry_date_'+i+'" name="expiry_'+i+'" value="'+expiry_date+'" readonly="readonly" style="width:95px;"/><input type="hidden"  name="expiry_'+i+'" value="" /><label class="error" id="error_expiry_'+i+'" style="display:none"> Field required </label>';
	if(prod_type == "Outpatientproducts"){
		expiry_date_html = '<input type="text" id="expiry_date_'+i+'" name="expiry_'+i+'" value="'+expiry_date+'"  style="width:95px;" disabled /><input type="hidden" id="product_type_'+i+'"  name="product_type_'+i+'" value="'+$("#product_type_"+index).val()+'"/>';
	}
	expiry_date_html = expiry_date_html + '<div id="expiry_date_new_div_'+i+'"></div>';
	$("#expiry_date_new_div_"+index).html(expiry_date_html);
	$("#expiry_date_"+i).datepicker({buttonImage: base_url + 'assets/images/common_images/img_datepicker.gif', changeYear: true, yearRange: '2010:2030', dateFormat: 'dd/mm/yy'});
	//Amount
	var total = $("#total_"+index).text();
	var total_div_html ='<div id="total_'+i+'">'+total+'</div>';
	total_div_html = total_div_html + '<div id="total_new_div_'+i+'"></div>';
	$("#total_new_div_"+index).html(total_div_html);
	
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