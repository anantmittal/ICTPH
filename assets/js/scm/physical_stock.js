$(document).ready(function(){
	//Load generic names
	$("#generic_name").show();
	$("#generic_medication_name").hide();
	$("#generic_consumable_name").hide();
	$("#generic_opd_product_name").hide();
	$("#generic_name").local_autocomplete(generic_name_list, "generic_id","");
	$("#generic_medication_name").local_autocomplete(generic_medication_name_list, "generic_id","");
	$("#generic_consumable_name").local_autocomplete(generic_consumable_name_list, "generic_id","");
	$("#generic_opd_product_name").local_autocomplete(generic_opdprod_name_list, "generic_id","");
	update_total();
	
	
	$("#product_type").change(function(){
		//$("#generic_name").val("");
		//$("#generic_id").val("");
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

function update_total(){
	$("#bill_amount").val(0);
	$("#bill_amount_visible").text(0);
	var total = 0.0;
	var num_items = Number($('#number_items').val());
	var i = 0;
	for (i=0; i < num_items; i++){
		var t_total = 0.0;
		var qty = Number($('#quantity_' + i).val());
		qty=parse_round_number(qty);
		if(isNaN(qty)){
			qty = 0;
	     }	
		var rate = Number($('#rate_' + i).text());	
		t_total = Number(qty * rate);
		total =  Number(total +  t_total);
		//t_total = t_total.toFixed(2);
		$('#total_' + i).text(t_total.toFixed(2));
		
		//
		$('#quantity_' + i).val(qty);
	 }
     //total = total.toFixed(2);
     if(isNaN(total)){
    	 total = 0;
     }
	 $('#bill_amount').val(total.toFixed(2));
	 $('#bill_amount_visible').text(total.toFixed(2));
}

function parse_round_number(num) {
	num = parseFloat(num);
	var result = Math.round(num*Math.pow(10,2))/Math.pow(10,2);
	return result;
}

function getStockDetails(){
	$("#page-loader").show();
	var location_id = $("#location_id").val();
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
		url: root_url+ "index.php/scm/stock/fetch_physical_stock/",
		dataType: "html",
		data: {
   		 	location_id : location_id,
   		 	product_type : product_type,
   		 	generic_name : generic_name
		},
		success: function(result) {
			$('#table_grey_border tr:gt(0)').remove();
			$('#table_grey_border tbody:last').append(result);
			update_total();
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