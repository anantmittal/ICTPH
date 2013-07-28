$(document).ready(function(){
	
	 //$("#consumable_row_id").val(1);
	$("#consumable_name").local_autocomplete(consumable_list,'consumable_product_id','','consumable_retail_unit','consumable_purchase_unit');
	$("#medication_name").local_autocomplete(medication_list,'medication_product_id','','medication_retail_unit','medication_purchase_unit');
	var fields = ["name","quantity"];
	
	show_hide_consumables();
	
	//Add Consumable details to table
	$('#add_consumable').click(function() {
		if( $.trim($("#consumable_quantity").val())!="" ){
			 var quantity=$('#consumable_quantity').val();
				var bool = /^[0-9]+$/.test(quantity);
				if(!bool)
					return ;			
		 }
		  if($.trim($("#consumable_name").val())=="" || $.trim($("#consumable_quantity").val())=="" ){	
				return;					
			}
		  $('#error_add_row').hide();
		  
		var s = '<tr>';
		var i = parseInt($("#consumable_row_id").val());
	    $("#consumable_row_id").val(i+1);
	    
		for (var k in fields) {
			 var v = $("#consumable_" + fields[k]).val();
		      s += '<td>' + v
		      + '<input type="hidden" id="consumable_' + i + '_' + fields[k] + '" name="selected_[' + i + '][' + fields[k] + ']" value="' + v + '"/>'
		      + '</td>';
		      
		}
		s += '<td>Consumable</td>'
			+'<input type="hidden" name="selected_[' + i +'][product_id]" value="' + $("#consumable_product_id").val()  + '" id="consumable_' + i + '_product_id"/>' 
		+'<td>'+$("#consumable_retail_unit").val() +'</td>'
		+'<td onmousedown="removeRow(this,'+i+')"><a href="#" >Remove</a></td>'
		     + '</tr>';
		$("#consumables").append(s);
		show_hide_consumables();
		$('#consumable_name').val('');
		$('#consumable_quantity').val('');
		$('#consumable_retail_unit').text('');
		$('#consumable_purchase_unit').text('');
	});
	
	//Add Medication details to table
	$('#add_medication').click(function() {
		if( $.trim($("#medication_quantity").val())!="" ){
			 var quantity=$('#medication_quantity').val();
				var bool = /^[0-9]+$/.test(quantity);
				if(!bool)
					return ;			
		 }
		  if($.trim($("#medication_name").val())=="" || $.trim($("#medication_quantity").val())=="" ){	
				return;					
			}
		  $('#error_add_med_row').hide();
		  
		var s = '<tr>';
		var i = parseInt($("#consumable_row_id").val());
	    $("#consumable_row_id").val(i+1);
	    
		for (var k in fields) {
			 var v = $("#medication_" + fields[k]).val();
		      s += '<td>' + v
		      + '<input type="hidden" id="medication_' + i + '_' + fields[k] + '" name="selected_[' + i + '][' + fields[k] + ']" value="' + v + '"/>'
		      + '</td>';
		      
		}
		s += '<td>Medication</td>'
			+'<input type="hidden" name="selected_[' + i +'][product_id]" value="' + $("#medication_product_id").val()  + '" id="medication_' + i + '_product_id"/>' 
		+'<td>'+$("#medication_retail_unit").val() +'</td>'
		+'<td onmousedown="removeRow(this,'+i+')"><a href="#" >Remove</a></td>'
		     + '</tr>';
		$("#consumables").append(s);
		show_hide_consumables();
		$('#medication_name').val('');
		$('#medication_quantity').val('');
		$('#medication_retail_unit').text('');
		$('#medication_purchase_unit').text('');
	});
	
	//Consumable field Changes
	$('#consumable_name').change(function(){
		if($.trim($("#consumable_name").val()) == "" ){
			$('#error_add_drug').show();
			return false;
		}else{
			$('#error_add_drug').hide();
			return true;
		}	
	});
	$('#consumable_quantity').change(function(){
		if($.trim($("#consumable_quantity").val()) == "" ){
			$('#error_add_quantity').show();
			$('#error_numeric_quantity').hide();
			return false;
		}else{
			$('#error_add_quantity').hide();
			var quantity=$('#consumable_quantity').val();
			var bool = /^[0-9]+$/.test(quantity);
			if(!bool){
				$('#error_numeric_quantity').show();
				return false;
			}else{
				$('#error_numeric_quantity').hide();
				return true;
			}
			return true;
		}
	});
	
	//Medication field Changes
	
	$('#medication_name').change(function(){
		if($.trim($("#medication_name").val()) == "" ){
			$('#error_add_med_drug').show();
			return false;
		}else{
			$('#error_add_med_drug').hide();
			return true;
		}	
	});
	$('#medication_quantity').change(function(){
		if($.trim($("#medication_quantity").val()) == "" ){
			$('#error_add_med_quantity').show();
			$('#error_numeric_med_quantity').hide();
			return false;
		}else{
			$('#error_add_med_quantity').hide();
			var quantity=$('#medication_quantity').val();
			var bool = /^[0-9]+$/.test(quantity);
			if(!bool){
				$('#error_numeric_med_quantity').show();
				return false;
			}else{
				$('#error_numeric_med_quantity').hide();
				return true;
			}
			return true;
		}
	});
	
});

function removeRow(row,i) {    
    $(row).parent().remove();
    show_hide_consumables();
}

function show_hide_consumables(){
	var rowCount = $('#consumables tr').length;	
	if(rowCount > 1){		
		$("#consumables").show(500);
	}else{
		$("#consumables").hide(500);
	}
}

function ValidateConsumable(){
	clearAllErrorMessages();
	var retVal = true;
	if($('#service_name').val() == ""){
		
		$('#error_add_service').show();
		retVal = false;
	}
	var val=$('#service_price').val();
	if((val=="") || !/^[0-9.]+$/.test(val)){
		$('#error_add_price').show();
		retVal = false;
	}
	
	return retVal;
}

function clearAllErrorMessages(){
	$('.error').hide();
}


