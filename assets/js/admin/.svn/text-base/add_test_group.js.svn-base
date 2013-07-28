$(document).ready(function(){
	$("#selected_consumable").local_autocomplete(consumable_list,'consumable_product_id','','consumable_retail_unit','consumable_purchase_unit');
	$("#test_name").local_autocomplete(test_list,'test_id','test_cost');
	
	var fields = ["consumable","quantity_lab","quantity_clinic"];
	var test_fields=["name","cost"];
	show_hide_consumables_tests();
	
	$('#add_consumable').click(function() {
		
		if($.trim($("#selected_quantity_lab").val())!="" ){
			 var quantity_lab=$('#selected_quantity_lab').val();
				var bool = /^[0-9]+$/.test(quantity_lab);
				if(!bool){
					return ;
				}
		 }
		
		if(  $.trim($("#selected_quantity_clinic").val())!=""){
			 
			 var quantity_clinic=$('#selected_quantity_clinic').val();
				var bool = /^[0-9]+$/.test(quantity_clinic);
				if(!bool){
					return ;
				}
		 }
		 
		  if($.trim($("#selected_consumable").val())=="" || $.trim($("#selected_quantity_lab").val())=="" || $.trim($("#selected_quantity_clinic").val())==""){	
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
		show_hide_consumables_tests();
		$('#selected_consumable').val('');
		$('#selected_quantity_lab').val('');
		$('#selected_quantity_clinic').val('');
		$('#consumable_retail_unit').text('');
		$('#consumable_purchase_unit').text('');
	});
	
	$('#add_test').click(function() {
		$('#add_test_error').hide();
		var s = '<tr>';
		var i = parseInt($("#test_row_id").val());
	    $("#test_row_id").val(i+1);
	    
		for (var k in test_fields) {
			 var v = $("#test_" + test_fields[k]).val();
		      s += '<td>' + v
		      + '<input type="hidden" id="test_' + i + '_' + test_fields[k] + '" name="test_[' + i + '][' + test_fields[k] + ']" value="' + v + '"/>'
		      + '</td>';
		      
		}
		s +='<input type="hidden" name="test_[' + i +'][test_id]" value="' + $("#test_id").val()  + '" id="test_' + i + '_test_id"/>' 
			+'<td onmousedown="removeRow(this,'+i+')"><a href="#" >Remove</a></td>'
		     + '</tr>';
		$("#tests").append(s);
		show_hide_consumables_tests();
		
		$('#test_name').val('');
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
	
	$('#test_name').change(function(){
		if($.trim($("#test_name").val()) == "" ){
			$('#error_add_test').show();
			return false;
		}else{
			$('#error_add_test').hide();
			return true;
		}	
	});
	
	$('#selected_quantity_lab').change(function(){
		if($.trim($("#selected_quantity_lab").val()) == "" ){
			$('#error_add_quantity_lab').show();
			$('#error_numeric_quantity_lab').hide();
			return false;
		}else{
			$('#error_add_quantity_lab').hide();
			var quantity=$('#selected_quantity_lab').val();
			var bool = /^[0-9]+$/.test(quantity);
			if(!bool){
				$('#error_numeric_quantity_lab').show();
				return false;
			}else{
				$('#error_numeric_quantity_lab').hide();
				return true;
			}
			return true;
		}
	});
	$('#selected_quantity_clinic').change(function(){
		if($.trim($("#selected_quantity_clinic").val()) == "" ){
			$('#error_add_quantity_clinic').show();
			$('#error_numeric_quantity_clinic').hide();
			return false;
		}else{
			$('#error_add_quantity_clinic').hide();
			var quantity=$('#selected_quantity_clinic').val();
			var bool = /^[0-9]+$/.test(quantity);
			if(!bool){
				$('#error_numeric_quantity_clinic').show();
				return false;
			}else{
				$('#error_numeric_quantity_clinic').hide();
				return true;
			}
			return true;
		}
	});
	
});

function show_hide_consumables_tests(){
	var rowCount = $('#consumables tr').length;	
	var rowCountTest = $('#tests tr').length;	
	if(rowCount > 1){		
		$("#consumables").show(500);
	}else{
		$("#consumables").hide(500);
		
	}
	if(rowCountTest > 1){
		$("#tests").show(500);
	}else{
		$("#tests").hide(500);
	}
}
function ValidateTestGroup(){
	clearAllErrorMessages();
	var retVal = true;
	var rowCount = $('#consumables tr').length;	
	var rowCountTest = $('#tests tr').length;
	if(rowCount ==1){		
		$('#error_add_row').show();
		retVal = false;		
	}
	if(rowCountTest ==1){
		$('#add_test_error').show();
		retVal = false;
	}
	if($('#test_group_name').val() == ""){
		
		$('#error_add_test_group').show();
		retVal = false;
	}
	return retVal;
}

function clearAllErrorMessages(){
	$('.error').hide();
}

function removeRow(row,i) {    
    $(row).parent().remove();
    show_hide_consumables_tests();
}