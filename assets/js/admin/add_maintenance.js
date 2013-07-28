$(document).ready(function(){
	
	 //$("#consumable_row_id").val(1);
	$("#selected_consumable").local_autocomplete(consumable_list,'consumable_product_id','','consumable_retail_unit','consumable_purchase_unit');
	var fields = ["consumable","quantity"];
	
	show_hide_consumables();
	//$('#consumables').hide();
	$('#add_consumable').click(function() {
		//$('#consumables').show(25);
		if( $.trim($("#selected_quantity").val())!="" ){
			 var quantity=$('#selected_quantity').val();
				var bool = /^[0-9]+$/.test(quantity);
				if(!bool)
					return ;			
		 }
		  if($.trim($("#selected_consumable").val())=="" || $.trim($("#selected_quantity").val())=="" ){	
				return;					
			}
		  $('#error_add_row').hide();
		  
		var s = '<tr>';
		var i = parseInt($("#consumable_row_id").val());
	    $("#consumable_row_id").val(i+1);
	    
		for (var k in fields) {
			 var v = $("#selected_" + fields[k]).val();
			 //alert(i+"--"+v);
		      s += '<td>' + v
		      + '<input type="hidden" id="selected_' + i + '_' + fields[k] + '" name="selected_[' + i + '][' + fields[k] + ']" value="' + v + '"/>'
		      + '</td>';
		      
		}
		s += '<input type="hidden" name="selected_[' + i +'][product_id]" value="' + $("#consumable_product_id").val()  + '" id="selected_' + i + '_product_id"/>' 
		+'<td>'+$("#consumable_retail_unit").val() +'</td>' 
		+'<td onmousedown="removeRow(this,'+i+')"><a href="#" >Remove</a></td>'
		     + '</tr>';
		$("#consumables").append(s);
		show_hide_consumables();
		$('#selected_consumable').val('');
		$('#selected_quantity').val('');
		$('#consumable_retail_unit').text('');
		$('#consumable_purchase_unit').text('');
	});
	
	$('#selected_consumable').change(function(){
		if($.trim($("#selected_consumable").val()) == "" ){
			$('#error_add_drug').show();
			return false;
		}else{
			$('#error_add_drug').hide();
			return true;
		}	
	});
	$('#selected_quantity').change(function(){
		if($.trim($("#selected_quantity").val()) == "" ){
			$('#error_add_quantity').show();
			$('#error_numeric_quantity').hide();
			return false;
		}else{
			$('#error_add_quantity').hide();
			var quantity=$('#selected_quantity').val();
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
	if($('#maintenance_name').val() == ""){
		
		$('#error_add_maintenance').show();
		retVal = false;
	}
	return retVal;
}

function clearAllErrorMessages(){
	$('.error').hide();
}


