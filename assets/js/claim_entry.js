function removeRow(row) {	
	$(row).parent().remove();
	
	var total_cost = $(row).prev().prev().prev().html();
	var claim_amount = $(row).prev().prev().html();

	
	var totalcost =Number($('#total_cost').val()) - Number(total_cost) ;
	var total_claimed_cost = Number($('#total_claimed_cost').val()) - Number(claim_amount);
	$('#total_cost').val(totalcost);
	$('#total_claimed_cost').val(total_claimed_cost);
    
	show_total_row(totalcost, total_claimed_cost);
}


function show_total_row(totalcost, total_claimed_cost){
        $('#tot_claim_cost').html('Total Claimed Cost : '+total_claimed_cost);        
        $('#tot_cost').html('Total cost : '+totalcost);
}

$(function(){	
	var isValidForm = true;
	$('#item_type').change(function(){
		var option_values = '';
		if(this.value == 'Administrative'){		
			$('#subtype').show();
			$('#subtype').removeAttr("disabled");
			$('#subtype_txt').hide();
			$('#subtype_txt').attr('disabled','disabled');
			
			option_values = '<option value="Registration">Registration</option>';		
			$('#subtype').html(option_values);
		}	
		else if(this.value == 'Ward'){
			$('#subtype').show();
			$('#subtype').removeAttr("disabled");
			$('#subtype_txt').hide();
			$('#subtype_txt').attr('disabled','disabled');
			
			option_values = '<option value="General">General</option> <option value="Semi Private">Semi Private </option> <option value="Private">Private</option> <option value="ICU">ICU</option> <option value="PICU">PICU</option>  <option value="ICCU">ICCU</option> <option value="Nursing Charges">Nursing Charges</option> <option value="RMO Charges">RMO Charges</option>';	
			$('#subtype').html(option_values);
		}		
		else if(this.value == 'Consultation'){
			$('#subtype').show();
			$('#subtype').removeAttr("disabled");
			$('#subtype_txt').hide();
			$('#subtype_txt').attr('disabled','disabled');
			
			option_values = '<option value="Primary Consultant">Primary Consultant</option>  <option value="Specialist consultant">Specialist Consultant</option> <option value="Super Specialist Consultant">Super Specialist Consultant</option>';  
			$('#subtype').html(option_values);
		}		
		else if(this.value == 'Medications'){
			$('#subtype').show();
			$('#subtype').removeAttr("disabled");
			$('#subtype_txt').hide();
			$('#subtype_txt').attr('disabled','disabled');
			
			option_values = '<option value="Inhouse">Inhouse</option>  <option value="Outside">Outside</option>';  
			$('#subtype').html(option_values);
		}		
		else if(this.value == 'Procedure'){
			$('#subtype').show();
			$('#subtype').removeAttr("disabled");
			$('#subtype_txt').hide();
			$('#subtype_txt').attr('disabled','disabled');
			
			option_values = '<option value="Procedure Fees(lump sum)">Procedure Fees(lump sum)</option><option value="Surgeon Charges">Surgeon Charges</option>';
			option_values = option_values + '<option value="Anesthesist charge">Anesthesist charge</option> <option value="Anaesthesia Charge">Anaesthesia Charge</option> <option value="OT charge">OT charge</option>';
			$('#subtype').html(option_values);
		}
		else {	
			$('#subtype').hide();
			$('#subtype').attr('disabled','disabled');		    
			$('#subtype_txt').show();
			$('#subtype_txt').removeAttr("disabled");
		}
	})

	
	  $('#claim_amount').blur(function(){
	  	
	  		if(isNaN($('#claim_amount').val())){	  			
				$('#error_claim_amount').html(' Claim-amount should be number.');			
				$('#error_claim_amount').show();
				isValidForm = false;				
			}
			else {
				if($("#claim_amount").val().length > 6)	{
					$('#error_claim_amount').html(' Claim amount should not exceed 6 digit limit.');			
					$('#error_claim_amount').show();
					isValidForm = false;
				}
				else{
			   		$('#error_claim_amount').hide();
			   		isValidForm = true;
				}	
			}   
	  });

	$('.to_calc').blur(function(){
		var number_of_times;
		var rate;
	//	var flag = true;
		
		if(isNaN($('#number_of_times').val())){
			$('#error_num_of_times').html('  Number-of-times field should be Number');
			$('#error_num_of_times').show();			
			isValidForm = false;			
		}
		else{
				if($("#number_of_times").val().length > 6)
				{
					$('#error_num_of_times').html('  Number-of-times should not exceed 6 digit limit.');			
					$('#error_num_of_times').show();			
					isValidForm = false;
				}
				else{
				    number_of_times = Number($('#number_of_times').val());
				    $('#error_num_of_times').hide();
				    isValidForm = true;
				}
		}    


		if(isNaN($('#rate').val())){
			$('#error_rate').html('Rate shold be number');
			$('#error_rate').show();
			isValidForm = false;
		}
		else {
			if($("#rate").val().length > 6)
			{
				$('#error_rate').html('Rate should not exceed 6 digit limit.');
				$('#error_rate').show();
				isValidForm = false;
			}
			else{
				rate = Number($('#rate').val());				
				$('#error_rate').hide();
				isValidForm = true;
			}
		}			
			
		if(isValidForm == true){
			var total = number_of_times * rate;
			$('.total').html('Rs. ' + total);
		}
		else $('.total').html('Rs. 0');
	});


	
	$('#addrow').click(function() {
		if($('#rate').val() == '' ) {
			$('#error_rate').html('"Rate" field is REQUIRED.');
			$('#error_rate').show();
			isValidForm = false;
		}
		
		if($('#number_of_times').val() == '' ){
			$('#error_num_of_times').html('  "Number-of-times" field is REQUIRED.');			
			$('#error_num_of_times').show();			
			isValidForm = false;			
		}
		
		if($('#claim_amount').val() == '') {
			$('#error_claim_amount').html(' "Claim amount" field is REQUIRED.');			
			$('#error_claim_amount').show();
			isValidForm = false;
		}
		
		if(isValidForm == false)
		return;
			
		
		var subtype;
		var comment = $('#comment').val();
		comment = comment.replace(/\|/g, ' ');
		comment = comment.replace(/\~/g, ' ');
		//alert(comment);

		var total = Number($('#number_of_times').val()) * Number($('#rate').val());
		
		if($('#subtype').css('display') == 'none')
			subtype = $('#subtype_txt').val();
		else
			subtype = $('#subtype').val();		
        var row = '<tr class="approve">';
        
		row += '<td>' + $('#item_type').val()       + '</td>';
		row += '<td>' + subtype 					+ '</td>';
		row += '<td>' + $('#item_name').val()       + '</td>'; 					+ '</td>';
		row += '<td>' + $('#number_of_times').val() + '</td>';
		row += '<td>' + $('#rate').val() 			+ '</td>';
		row += '<td>' + total 						+ '</td>';
		row += '<td>' + $('#claim_amount').val() 	+ '</td>';
		row += '<td>' + $('#comment').val() 		+ '</td>';
		row += '<td onmousedown="removeRow(this)"><a href="#">Remove</a></td>';
		row += '</tr>';
		
		$('#claimItemTable tr:last').after(row);
		$('#add_claim').hide(2000);

		var totalcost = Number($('#total_cost').val()) + Number($('#number_of_times').val() * $('#rate').val());
		var total_claimed_cost = Number($('#total_claimed_cost').val()) + Number($('#claim_amount').val());

		$('#total_cost').val(totalcost);
		$('#total_claimed_cost').val(total_claimed_cost);		
		show_total_row(totalcost, total_claimed_cost);	
	});

	
	
	$('#submit_form_data').click(function(){
		var row_data="";
		var cnt = 0;
		$('#claimItemTable tr').each(function(){
			var rows = $(this).children('td');

			$(rows).each(function(){
				if(cnt != 0)
				row_data += '|'+$(this).html();
			});
			if(cnt != 0)
			row_data += '~';

			cnt++;
		});
		$('#form_rows_data').val('');
		$('#form_rows_data').val(row_data);
	});
          
});

//jquery auto complete code start here

var actual_val;
$().ready(function() 
{
	function findValueCallback(event, data, formatted) 
	{			
		//$("<li>").html(!data ? "No match!" : "Marathi name: " + formatted+" English name: " + data[1]).appendTo("#result");
	}

	function formatResult(row) 
	{		
		return row[0].replace(/(<.+?>)/gi, '');
	}
	$(":text").result(findValueCallback).next().click(function() 
	{		
		$(this).prev().search();
	});

    $(".memname").autocomplete( base_url + "index.php/hospitalization/common/claim_subtype_autocomplete",{	width: 260,	selectFirst: false});
//    $(".memname").autocomplete('http://google.com',{	width: 260,	selectFirst: false});

	$(".memname").result (
	    function(event, data, formatted) 
	    {	if (data)
		     $(this).parent().next().find("input").val(data[1]);
	    });   
    
    $("#add_new_claim").click(function() {
		$("#add_claim").toggle(1000);	 
		$('html, body').animate({ scrollTop: $('#add_claim').offset().top }, 3000);		
		$('#item_name').val('');
		$('#rate').val('');
		$('#number_of_times').val('');
		$('#claim_amount').val('');
		$('#comment').val('');
		$('.total').html('Rs.0');
	});
	
	$("#claim_entry_form").validate();
	
  });

