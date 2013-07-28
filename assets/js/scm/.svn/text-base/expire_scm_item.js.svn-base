$(document).ready(function(){
  // Following is required because refresh page refresh may not clear this
  // hidden variable
  $("#medication_row_id").val(1);
  $("#bill_amount").val(0);
  $("#bill_amount_visible").text(0);

 
  //medications_list = [ {id: '101', name:'Para kdjhfkjsdhfk/sdkjhfksjhfksd/sdjfh'}, {id:'102', name: 'Pare sdkjhfsk/ skjhdfksd ()'},{id:'103',name:'Sty'}, ];
  $("#medication_name").local_autocomplete(order_medications_list, "medication_product_id","medication_rate");
  $("#consumable_name").local_autocomplete(order_consumable_list, "consumable_product_id","consumable_rate");
  
	$('#medication_name').change(function(){
		if($.trim($("#medication_name").val()) == "" ){
			$('#error_add_drug').show();
			return false;
		}else{
			$('#error_add_drug').hide();
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
	
	var compute_bill_amount = function() {
	    var rows = parseInt($("#medication_row_id").val());
	    total = 0.0;
	    for (var i = 0; i < 200; i++) {
	      var name = $("#medications_" + i + "_name").val();
	      if (name != "") {
		var qty =  Number($("#medications_" + i + "_quantity").val());
		var rate = Number($("#medications_" + i + "_rate").val());
		var cost = qty * rate;

		total += cost;
	      }
	    }
	    $("#bill_amount_visible").text(parse_round_number(total));
	    $("#bill_amount").val(parse_round_number(total));
	  };
	show_hide_medications();
	
	
	$('#type').change(function(){
		var val=$('#type').val();
		if(val=="1"){//medication
			$("#drug_id").show(500);
			$("#consumable_id").hide(500);
			
		}if(val=="2"){//consumable
			$("#consumable_id").show(500);
			$("#drug_id").hide(500);	
		}
		$('#medication_name').val(''); 
	    $('#consumable_name').val('');
	    $('#error_add_drug').hide();
	    $('#error_add_consumable').hide();
		
	});
	$('#type').change();
});

function load_ajax(product_id,from_id,ajax_url){
	var today_date=$('#today_date').val();
	var today_split_date=today_date.split("/");
	var formatted_today_date=Date.parse(today_split_date[1]+"/"+today_split_date[0]+"/"+today_split_date[2]);
	//alert(today_date+"--"+today_split_date[1]+"/"+today_split_date[0]+"/"+today_split_date[2]);
	
	$.ajax({
		type: "POST",
		url: ajax_url,
		dataType: "json",
		data: {
			product_ids: product_id,
			from_ids: from_id
		},
		success: function(result) {
			//alert(result);
			var obj = jQuery.parseJSON(result);
			
			$('#medications').find("tr:gt(0)").remove();
			$.each(obj.product_data,function(key,value){
				//alert($('#today_date').val()+'--'+formatted_today_date);
				var expire_date=value.expiry;
				var expire_split_date=expire_date.split("-");
				var formatted_expire_date=Date.parse(expire_split_date[1]+"/"+expire_split_date[2]+"/"+expire_split_date[0]);
				//alert(formatted_expire_date+'--'+formatted_today_date);
				var s
				if(formatted_expire_date>formatted_today_date){
					 s = '<tr>';
				}else{
					 s= '<tr id="expire_row_color">';
				}
				

			      s += '<td>' + value.product_name+ '<input type="hidden" id="medications_' + key + '_name" name="medications[' + key + '][name]" value="' + value.product_name + '"/></td>'
			  		+'<td>' + value.location+ '<input type="hidden" id="medications_' + key + '_location" name="medications[' + key + '][location]" value="' + value.location + '"/></td>'
			      	+'<td>' + value.batch+ '<input type="hidden" id="medications_' + key + '_batch" name="medications[' + key + '][batch]" value="' + value.batch + '"/></td>'
			      	+'<td>' + value.expiry+ '<input type="hidden" id="medications_' + key + '_expiry" name="medications[' + key + '][expiry]" value="' + value.expiry + '"/></td>'
			      	+'<td>' + value.quantity+ '<input type="hidden" id="medications_' + key + '_quantity" name="medications[' + key + '][quantity]" value="' + value.quantity + '"/></td>'
			    	+ '<input type="hidden" name="medications[' + key +'][product_id]" value="' +  value.product_id  + '" id="medications_' + key + '_product_id"/>'
			    	+ '<input type="hidden" name="medications[' + key +'][rate]" value="' + $('#medication_rate').val()  + '" id="medications_' + key + '_rate"/>'
    			      +'<input type="hidden" name="medications[' + key +'][product_batch_id]" value="' +  value.product_batch_id  + '" id="medications_' + key + '_product_batch_id"/>';
			      if(formatted_expire_date>formatted_today_date){
			      	s+= '<td id="hide_' + key + '_remove" onmousedown="addToExpire(this,'+key+')"><a href="javascript:void(0);" >Add to Expire</a></td>';
			      }else{
			    	  s+= '<td class="remove_expire_row" id="hide_' + key + '_remove" onmousedown="addToExpire(this,'+key+')"><a href="javascript:void(0);" >Add to Expire</a></td>';
			      }
			      
			       + '</tr>';
			    $("#medications").append(s);
			    $('#medication_name').val(''); 
			    $('#consumable_name').val('');
			   
					
			});
			var rowCount = $('#medications tr').length;
			if(rowCount > 1){		
				$("#medications").show(500);
			}else{
				$("#medications").hide(500);
			}
			 $("#page-loader").hide();
     	},
     	complete :function(){
     		$("#page-loader").hide();
     	},
		failure : function(){
			alert("failed");
			$("#page-loader").hide();
		},
		error : function(e){
			alert("error");
			$("#page-loader").hide();
		}
	});
	
}

var k=0;
function addToExpire(row, j) {
	var c=1;

	count=k;
	for(c=0;c<count;c++){
		//to prevent same drugs to show up in add expiry screen
		if($('#medications_' + j + '_product_batch_id').val()==$('#medication_' + c + '_product_batch_id').val()){
			alert("Drug already selected to be expired. Please select another Drug");
			return;
		}	
	}
		 var total = Number($("#medications_" + j + "_rate").val() * $("#medications_" + j +"_quantity").val());
		 var bill_amount = Number($("#bill_amount").val());
		 var new_bill_amount = Number(total + bill_amount);
	var m = '<tr>';
    m += '<td>' + $('#medications_' + j + '_name').val()+ '<input type="hidden" id="medication_' + count + '_name" name="medication[' + count + '][name]" value="' + $('#medications_' + j + '_name').val() + '"/></td>'
		+'<td>' + $('#medications_' + j + '_location').val()+ '<input type="hidden" id="medication_' + count + '_location" name="medication[' + count + '][location]" value="' + $('#medications_' + j + '_location').val() + '"/></td>'
      	+'<td>' + $('#medications_' + j + '_batch').val()+ '<input type="hidden" id="medication_' + count + '_batch" name="medication[' + count + '][batch]" value="' + $('#medications_' + j + '_batch').val()+ '"/></td>'
      	+'<td>' + $('#medications_' + j + '_expiry').val()+ '<input type="hidden" id="medication_' + count + '_expiry" name="medication[' + count + '][expiry]" value="' + $('#medications_' + j + '_expiry').val() + '"/></td>'
      	+'<td>' + $('#medications_' + j + '_quantity').val()+ '<input type="hidden" id="medication_' + count + '_quantity" name="medication[' + count + '][quantity]" value="' + $('#medications_' + j + '_quantity').val() + '"/></td>'
    	+ '<input type="hidden" name="medication[' + count +'][product_id]" value="' + $('#medications_' + j + '_product_id').val()  + '" id="medication_' + count + '_product_id"/>'
    	+ '<input type="hidden" name="medication[' + count +'][rate]" value="' + $('#medications_' + j + '_rate').val()  + '" id="medication_' + count + '_rate"/>'
    	+ '<input type="hidden" name="medication[' + count +'][index]" value="' + count + '"/>'
    	+'<input type="hidden" name="medication[' + count +'][product_batch_id]" value="' +  $('#medications_' + j + '_product_batch_id').val()  + '" id="medication_' + count + '_product_batch_id"/>'
      + '<td onmousedown="removeRows(this,'+count+')"><a href="#" >Remove</a></td>'
      + '</tr>';
    
    
    $("#bill_amount").val(parse_round_number(new_bill_amount));
    $("#bill_amount_visible").text(parse_round_number(new_bill_amount));
    $("#expire_medications").append(m);
    $('#error_add_row').hide();
    k=k+1;
	}

	


function removeRows(row,i) {
	var total = Number(Number($("#medication_"+i+"_rate").val()) * Number($("#medication_"+i+"_quantity").val()));
    var bill_amount = Number($("#bill_amount").val());
    var new_bill_amount = Number(bill_amount - total);
    $("#bill_amount").val(parse_round_number(new_bill_amount));
    $("#bill_amount_visible").text(parse_round_number(new_bill_amount));
    $(row).parent().remove();
    show_hide_medications();
}

function ValidateForm(){
	clearAllErrorMessages();
	var retVal = true;
	var rowCount = $('#expire_medications tr').length;	
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

