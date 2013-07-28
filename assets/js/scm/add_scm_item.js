var products_ordered_arr = new Array();
$(document).ready(function(){
  // Following is required because refresh page refresh may not clear this
  // hidden variable
  $("#medication_row_id").val(1);
  $("#bill_amount").val(0);
  $("#bill_amount_visible").text(0);


  $('#show_medication_box').click(function() {
	  $('#edit_medication_box').show();
 });

  //medications_list = [ {id: '101', name:'Para kdjhfkjsdhfk/sdkjhfksjhfksd/sdjfh'}, {id:'102', name: 'Pare sdkjhfsk/ skjhdfksd ()'},{id:'103',name:'Sty'}, ];
  $("#medication_name").local_autocomplete(order_medications_list, "medication_product_id","medication_rate","medication_retail_unit","medication_purchase_unit");
  $("#consumable_name").local_autocomplete(order_consumables_list, "consumable_product_id","consumable_rate","consumable_retail_unit","consumable_purchase_unit");
  $("#opd_product_name").local_autocomplete(order_opd_products_list, "opd_product_id","opd_product_rate","opd_product_retail_unit","opd_product_purchase_unit");
  
  
  	$(".form_data1").hide();
	$(".form_data2").hide();
	$('#medication_name').change(function(){
		if($.trim($("#medication_name").val()) == "" ){
			$('#error_add_drug').show();
			return false;
		}else{
			$('#error_add_drug').hide();
			return true;
		}	
	});
	$('#medication_quantity').change(function(){
		if($.trim($("#medication_quantity").val()) == "" ){
			$('#error_add_quantity').show();
			$('#error_numeric_quantity').hide();
			return false;
		}else{
			$('#error_add_quantity').hide();
			var quantity=$('#medication_quantity').val();
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
	
	$('#consumable_name').change(function(){
		if($.trim($("#consumable_name").val()) == "" ){
			$('#error_add_consumable').show();
			return false;
		}else{
			$('#error_add_consumable').hide();
			return true;
		}	
	});
	$('#consumable_quantity').change(function(){
		if($.trim($("#consumable_quantity").val()) == "" ){
			$('#error_add_consumable_quantity').show();
			$('#error_numeric_consumable_quantity').hide();
			return false;
		}else{
			$('#error_add_consumable_quantity').hide();
			var quantity=$('#consumable_quantity').val();
			var bool = /^[0-9]+$/.test(quantity);
			if(!bool){
				$('#error_numeric_consumable_quantity').show();
				return false;
			}else{
				$('#error_numeric_consumable_quantity').hide();
				return true;
			}
			return true;
		}
	});
	
	$('#opd_product_name').change(function(){
		if($.trim($("#opd_product_name").val()) == "" ){
			$('#error_add_opd_product').show();
			return false;
		}else{
			$('#error_add_opd_product').hide();
			return true;
		}	
	});
	$('#opd_product_quantity').change(function(){
		if($.trim($("#opd_product_quantity").val()) == "" ){
			$('#error_add_opd_quantity').show();
			$('#error_numeric_opd_quantity').hide();
			return false;
		}else{
			$('#error_add_opd_quantity').hide();
			var quantity=$('#opd_product_quantity').val();
			var bool = /^[0-9]+$/.test(quantity);
			if(!bool){
				$('#error_numeric_opd_quantity').show();
				return false;
			}else{
				$('#error_numeric_opd_quantity').hide();
				return true;
			}
			return true;
		}
	});
	
	$('#type').change(function(){
		var val=$('#type').val();
		if(val=="1"){//medication
			$(".form_data").show(500);
			$(".form_data1").hide(500);
			$(".form_data2").hide(500);
			
		}if(val=="2"){//consumable
			$(".form_data1").show(500);
			$(".form_data").hide(500);
			$(".form_data2").hide(500);
			
		}if(val=="3"){//opd products
			$(".form_data2").show(500);
			$(".form_data").hide(500);
			$(".form_data1").hide(500);
			
		}
		$("#medication_name").val('');
		$("#medication_quantity").val('');
		$('#medication_retail_unit').text("");
		$('#medication_purchase_unit').text("");
		$("#consumable_name").val('');
		$("#consumable_quantity").val('');
		$('#consumable_retail_unit').text("");
		$('#consumable_purchase_unit').text("");
		$("#opd_product_name").val('');
		$("#opd_product_quantity").val('');
		$("#opd_visit_id").val('');
		$('#opd_product_retail_unit').text('');
		$('#opd_product_purchase_unit').text('');
		
	});
	$('#type').change();
  
  
	show_hide_medications();
  //add medication
  var fields = ["name", "quantity"];
  
  $('#add_medication').click(function() {
	 if($.inArray($("#medication_product_id").val(),products_ordered_arr) !== -1){
		 alert("Ooops! Product already queued for order");
		 return;
	 }
	 if( $.trim($("#medication_quantity").val())!="" ){
		 var quantity=$('#medication_quantity').val();
			var bool = /^[0-9]+$/.test(quantity);
			if(!bool)
				return ;			
	 }
	  if($.trim($("#medication_name").val())=="" || $.trim($("#medication_quantity").val())=="" ){	
			return;					
		}
	  $('#error_add_row').hide();

    var s = '<tr>';
    var total = Number($("#medication_rate").val() * $("#medication_quantity").val());
    var bill_amount = Number($("#bill_amount").val());
    var new_bill_amount = Number(total + bill_amount);
    var i = parseInt($("#medication_row_id").val());
    $("#medication_row_id").val(i+1);

    for (var k in fields) {
      var v = $("#medication_" + fields[k]).val();
      s += '<td>' + v
      + '<input type="hidden" id="medication_' + i + '_' + fields[k] + '" name="medication[' + i + '][' + fields[k] + ']" value="' + v + '"/>'
      + '</td>';
    }
    s += '<input type="hidden" name="medication[' + i +'][product_id]" value="' + $("#medication_product_id").val()  + '" id="medication_' + i + '_product_id"/>'
      + '<input type="hidden" name="medication[' + i +'][rate]" value="' + $("#medication_rate").val()  + '" id="medication_' + i + '_rate"/>'
      + '<input type="hidden" name="medication[' + i +'][index]" value="' + i + '"/>'
      + '<td>Medication<input type="hidden" id="medication_' + i + '_type" name="medication[' + i + '][type]" value="Medication"/></td>'
      +'<td>--</td>'
      + '<td>' + $("#medication_rate").val()  + '</td>'
      + '<td>' + parse_round_number($("#medication_rate").val() * $("#medication_quantity").val())  + '</td>'
      + '<td onmousedown="removeRow(this,'+i+')"><a href="#" >Remove</a></td>'
      + '</tr>';
 
    //	compute_bill_amount();
    $("#bill_amount").val(parse_round_number(new_bill_amount));
    $("#bill_amount_visible").text(parse_round_number(new_bill_amount));
    $("#medications").append(s);
    $('#edit_medication_box').hide();
    show_hide_medications();
    $("#medication_name").val('');
    $("#medication_quantity").val('');
    $('#medication_retail_unit').text("");
	$('#medication_purchase_unit').text("");
	products_ordered_arr.push($("#medication_product_id").val());
  });
  
  
  //add consumables
  $('#add_consumable').click(function() {
	  if($.inArray($("#consumable_product_id").val(),products_ordered_arr) !== -1){
			 alert("Ooops! Product already queued for order");
			 return;
		}
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

	    var t = '<tr>';
	    var total = Number($("#consumable_rate").val() * $("#consumable_quantity").val());
	    var bill_amount = Number($("#bill_amount").val());
	    var new_bill_amount = Number(total + bill_amount);
	    var i = parseInt($("#medication_row_id").val());
	    $("#medication_row_id").val(i+1);

	    for (var k in fields) {
	      var v = $("#consumable_" + fields[k]).val();
	      t += '<td>' + v
	      + '<input type="hidden" id="medication_' + i + '_' + fields[k] + '" name="medication[' + i + '][' + fields[k] + ']" value="' + v + '"/>'
	      + '</td>';
	    }
	    t += '<input type="hidden" name="medication[' + i +'][product_id]" value="' + $("#consumable_product_id").val()  + '" id="medication_' + i + '_product_id"/>'
	      + '<input type="hidden" name="medication[' + i +'][rate]" value="' + $("#consumable_rate").val()  + '" id="medication_' + i + '_rate"/>'
	      + '<input type="hidden" name="medication[' + i +'][index]" value="' + i + '"/>'
	      + '<td>Consumable<input type="hidden" id="medication_' + i + '_type" name="medication[' + i + '][type]" value="Consumable"/></td>'
	      +'<td>--</td>'
	      + '<td>' + $("#consumable_rate").val()  + '</td>'
	      + '<td>' + parse_round_number($("#consumable_rate").val() * $("#consumable_quantity").val() ) + '</td>'
	      + '<td onmousedown="removeRow(this,'+i+')"><a href="#" >Remove</a></td>'
	      + '</tr>';
	 
	    //	compute_bill_amount();
	    $("#bill_amount").val(parse_round_number(new_bill_amount));
	    $("#bill_amount_visible").text(parse_round_number(new_bill_amount));
	    $("#medications").append(t);
	    $('#edit_medication_box').hide();
	    show_hide_medications();
	    $("#consumable_name").val('');
	    $("#consumable_quantity").val('');
	    $('#consumable_retail_unit').text("");
		$('#consumable_purchase_unit').text("");
		products_ordered_arr.push($("#medication_product_id").val());
	 });
  
  
  	//add opd products
  	$('#add_opd_product').click(function() {
  		 if($.inArray($("#opd_product_id").val(),products_ordered_arr) !== -1){
			 alert("Ooops! Product already queued for order");
			 return;
		}
		 if( $.trim($("#opd_product_quantity").val())!="" ){
			 var quantity=$('#opd_product_quantity').val();
				var bool = /^[0-9]+$/.test(quantity);
				if(!bool)
					return ;			
		 }
		 
		  if($.trim($("#opd_product_name").val())=="" || $.trim($("#opd_product_quantity").val())=="" ){	
				return;					
			}
		  $('#error_add_row').hide();

	    var m = '<tr>';
	    var total = Number($("#opd_product_rate").val() * $("#opd_product_quantity").val());
	    var bill_amount = Number($("#bill_amount").val());
	    var new_bill_amount = Number(total + bill_amount);
	    var i = parseInt($("#medication_row_id").val());
	    $("#medication_row_id").val(i+1);

	    for (var k in fields) {
	      var v = $("#opd_product_" + fields[k]).val();
	      m += '<td>' + v
	      + '<input type="hidden" id="medication_' + i + '_' + fields[k] + '" name="medication[' + i + '][' + fields[k] + ']" value="' + v + '"/>'
	      + '</td>';
	    }
	    m += '<input type="hidden" name="medication[' + i +'][product_id]" value="' + $("#opd_product_id").val()  + '" id="medication_' + i + '_product_id"/>'
	      + '<input type="hidden" name="medication[' + i +'][rate]" value="' + $("#opd_product_rate").val()  + '" id="medication_' + i + '_rate"/>'
	      + '<input type="hidden" name="medication[' + i +'][index]" value="' + i + '"/>'
	      + '<td>Opd Product<input type="hidden" id="medication_' + i + '_type" name="medication[' + i + '][type]" value="Opd Product"/></td>'
	      + '<td>'+$("#opd_visit_id").val() +'<input type="hidden" id="medication_' + i + '_visit_id" name="medication[' + i + '][visit_id]" value="'  + $("#opd_visit_id").val()  + '"/></td>'
	      + '<td>' + $("#opd_product_rate").val()  + '</td>'
	      + '<td>' + parse_round_number($("#opd_product_rate").val() * $("#opd_product_quantity").val())  + '</td>'
	      + '<td onmousedown="removeRow(this,'+i+')"><a href="#" >Remove</a></td>'
	      + '</tr>';
	 
	    //	compute_bill_amount();
	    $("#bill_amount").val(parse_round_number(new_bill_amount));
	    $("#bill_amount_visible").text(parse_round_number(new_bill_amount));
	    $("#medications").append(m);
	    $('#edit_medication_box').hide();
	    show_hide_medications();
	    $("#opd_product_name").val('');
	    $("#opd_product_quantity").val('');
	    $("#opd_visit_id").val('');
	    $('#opd_product_retail_unit').text('');
		$('#opd_product_purchase_unit').text('');
		products_ordered_arr.push($("#medication_product_id").val());
	 });

  
    var compute_bill_amount = function() {
    var rows = parseInt($("#medication_row_id").val());
    total = 0.0;
    for (var i = 0; i < 200; i++) {
      var name = $("#medication_" + i + "_name").val();
      if (name != "") {
	var qty =  Number($("#medication_" + i + "_quantity").val());
	var rate = Number($("#medication_" + i + "_rate").val());
	var cost = qty * rate;

	total += cost;
      }
    }
    $("#bill_amount_visible").text(parse_round_number(total));
    $("#bill_amount").val(parse_round_number(total));
  };

  //From list box change
  $('#from_id').change(function(){
		$('#to_id option').remove();
		$('#to_id').html($('#hidden_to_id').html());
		var selected_value = $('#from_id :selected').val();
		$('#to_id option[value="'+selected_value+'"]').remove();
	});
	$('#from_id').change();	 
     
 	// When location is selected i.e. (by clicking on Choose Location) , this code handles to-list-box 
	var selected_value = $('#from_loc_id').val();
 	$('#to_id option[value="'+selected_value+'"]').remove();

});


function removeRow(row,i) {
    var total = Number(Number($("#medication_"+i+"_rate").val()) * Number($("#medication_"+i+"_quantity").val()));
    var bill_amount = Number($("#bill_amount").val());
    var new_bill_amount = Number(bill_amount - total);
    $("#bill_amount").val(parse_round_number(new_bill_amount));
    $("#bill_amount_visible").text(parse_round_number(new_bill_amount));
    $(row).parent().remove();
    show_hide_medications();
    //Remove from ordered queued array
    products_ordered_arr.splice( $.inArray($("#medication_"+i+"_product_id").val(), products_ordered_arr), 1 );
}




function ValidateForm(){
	clearAllErrorMessages();
	var retVal = true;
	var rowCount = $('#medications tr').length;	
	if(rowCount ==1){		
		$('#error_add_row').show();
		retVal = false;		
	}
	return retVal;
}

function clearAllErrorMessages(){
	$('.error').hide();
}

function parse_round_number(num) {
	num = parseFloat(num);
	var result = Math.round(num*Math.pow(10,2))/Math.pow(10,2);
	return result;
}

function show_hide_medications(){
	var rowCount = $('#medications tr').length;	
	if(rowCount > 1){		
		$("#medications").show(500);
	}else{
		$("#medications").hide(500);
	}
}

//Adding pending opd products
function addRow(row, j) {
	var fields = ["name", "quantity"];
	var m = '<tr>';
    var total = Number($("#opd_"+j+"_product_rate").val() * $("#opd_"+j+"_product_quantity").val());
    var bill_amount = Number($("#bill_amount").val());
    var new_bill_amount = Number(total + bill_amount);
    var i = parseInt($("#medication_row_id").val());
    $("#medication_row_id").val(i+1);
    var prod=1;
    for (var k in fields) {
      var v = $("#opd_"+j+"_product_" + fields[k]).val();
      if(prod==1){
	      m += '<td><span style="color:#FF0000">*</span>' + v
	      + '<input type="hidden" id="medication_' + i + '_' + fields[k] + '" name="medication[' + i + '][' + fields[k] + ']" value="' + v + '"/>'
	      + '</td>';
      }else{
    	  m += '<td>' + v
	      + '<input type="hidden" id="medication_' + i + '_' + fields[k] + '" name="medication[' + i + '][' + fields[k] + ']" value="' + v + '"/>'
	      + '</td>';
      }
      prod=prod+1;
    }
    m += '<input type="hidden" name="medication[' + i +'][product_id]" value="' + $("#opd_"+j+"_product_id").val()  + '" id="medication_' + i + '_product_id"/>'
      + '<input type="hidden" name="medication[' + i +'][rate]" value="' + $("#opd_"+j+"_product_rate").val()  + '" id="medication_' + i + '_rate"/>'
      + '<input type="hidden" name="medication[' + i +'][pending_queue_id]" value="' + $("#opd_"+j+"_pending_queue_id").val()  + '" id="medication_' + i + '_pending_queue_id"/>'
      + '<input type="hidden" name="medication[' + i +'][index]" value="' + i + '"/>'
      + '<td>Opd Product<input type="hidden" id="medication_' + i + '_type" name="medication[' + i + '][type]" value="Opd Product"/></td>'
      + '<td>'+$("#opd_"+j+"_visit_id").val() +'<input type="hidden" id="medication_' + i + '_visit_id" name="medication[' + i + '][visit_id]" value="'  + $("#opd_"+j+"_visit_id").val()  + '"/></td>'
      + '<td>' + $("#opd_"+j+"_product_rate").val()  + '</td>'
      + '<td>' +  parse_round_number($("#opd_"+j+"_product_rate").val() * $("#opd_"+j+"_product_quantity").val())  + '</td>'
      + '<td onmousedown="moveFromOrderToPending(this,'+j+','+i+')"><a href="javascript:void(0);" >Remove</a></td>'
      + '</tr>';
 
    //	compute_bill_amount();
    $("#bill_amount").val( parse_round_number(new_bill_amount));
    $("#bill_amount_visible").text( parse_round_number(new_bill_amount));
    $("#medications").append(m);
    $('#edit_medication_box').hide();
    show_hide_medications();
    $("#pending_order_row_"+j).hide();
    products_ordered_arr.push($("#opd_"+j+"_product_id").val());
    //$(row).parent().remove();
	}

function moveFromOrderToPending(element, rowId,i) {
	$("#pending_order_row_"+rowId).show();
	var total = Number(Number($("#medication_"+i+"_rate").val()) * Number($("#medication_"+i+"_quantity").val()));
    var bill_amount = Number($("#bill_amount").val());
    var new_bill_amount = Number(bill_amount - total);
    $("#bill_amount").val(parse_round_number(new_bill_amount));
    $("#bill_amount_visible").text(parse_round_number(new_bill_amount));
	$(element).parent().remove();
    show_hide_medications();
  //Remove from ordered queued array
    products_ordered_arr.splice( $.inArray($("#medication_"+i+"_product_id").val(), products_ordered_arr), 1 );
}