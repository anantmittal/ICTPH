$(document).ready(function() {
	$('#add_provider_table').hide();                // first time when it gets loaded , provider_table should be hidden
	$("#Clinician").attr("disabled", false);        // let this checkbox be enabled       
 	$("#Lab_Technician").attr("disabled", false);   // let this checkbox be enabled
 	$("#HEW").attr("disabled", false);  			// let this checkbox be enabled   
 	
	$("#Clinician").click(function() {              		// when Clinician checkbox is checked
		$("#Lab_Technician").attr("disabled", false);
		$("#HEW").attr("disabled", false);
		if ($('#Clinician').is(':checked'))	{
			hideAllErrorMessages();
			$('#type_id option').remove();
			$('#type_id').html('<option value="Doctor">Doctor</option><option value="Nurse">Nurse</option><option value="Lab Technician">Lab Technician</option>');
			$("#Lab_Technician").attr("disabled", true);
			$("#HEW").attr("disabled", true);
			$('#add_provider_table').show();			
		}
		else {
			$('#add_provider_table').hide();
		}	
	});
	
	$("#Lab_Technician").click(function() {                   // when Lab Technician checkbox is checked
		$("#Clinician").attr("disabled", false);
		$("#HEW").attr("disabled", false);
		if ($('#Lab_Technician').is(':checked'))	{			
			hideAllErrorMessages();
			$('#type_id option').remove();
			$('#type_id').html('<option value="Doctor">Doctor</option><option value="Nurse">Nurse</option><option value="Lab Technician">Lab Technician</option>');
			$("#Clinician").attr("disabled", true);
			$("#HEW").attr("disabled", true);
			$('#add_provider_table').show();
		}
		else {
			$('#add_provider_table').hide();
		}	
	});
	
	$("#HEW").click(function() {                   			  // when HEW checkbox is checked
		$("#Clinician").attr("disabled", false);
		$("#Lab_Technician").attr("disabled", false);
		if ($('#HEW').is(':checked'))	{
			hideAllErrorMessages();
			$('#type_id option').remove();
			$('#type_id').html('<option value="HEW">HEW</option>');
			$("#Clinician").attr("disabled", true);
			$("#Lab_Technician").attr("disabled", true);
			$('#add_provider_table').show();
		}
		else {
			$('#add_provider_table').hide();
		}	
	});
	
	
	if ($('#Clinician').is(':checked'))	{		
			$('#add_provider_table').show();
			$("#Clinician").attr("disabled", true);
			$("#Lab_Technician").attr("disabled", true);
			$("#HEW").attr("disabled", true);
	}
	if ($('#Lab_Technician').is(':checked')){
			$('#add_provider_table').show();
			$("#Lab_Technician").attr("disabled", true);
			$("#Clinician").attr("disabled", true);
			$("#HEW").attr("disabled", true);
	}
	if ($('#HEW').is(':checked')){
		$('#add_provider_table').show();
		$("#HEW").attr("disabled", true);
		$("#Lab_Technician").attr("disabled", true);
		$("#Clinician").attr("disabled", true);	
}
	

});

function validatePassword(retValue){	
	if($('#new_password1').val()==""){		
		$('#error_password').show();
		retValue = false;
	}
	
	if($('#new_password2').val()==""){		
		$('#error_repeat_password').show();
		retValue = false;
	}
	
	if($('#new_password1').val()!="" && $('#new_password2').val()!=""){
		if($('#new_password1').val() != $('#new_password2').val()){
			alert("Password mismatch");
			retValue = false;
		}
	}
	
	if($('#new_password1').val()!=""){		
		if($('#user_name').val() == $('#new_password1').val()){
			alert("Password is same as Username");
			retValue=false;
		} 
	}
	
	return  retValue;
}

function validateUserForm(retValue) {	
	if($('#fullname').val()==""){		
		$('#error_full_name').show();
		retValue = false;
	}
	
	if($('#contact_number').val()==""){
		$('#error_contact').show();
		retValue = false;
	}
	
	if($('#contact_number').val()!=""){
		if (!$('#contact_number').val().match(/^\s*[a-zA-Z0-9,\s]+\s*$/)) {
			  $('#error_special_char_contact').show();
			  retValue = false;
		}
	}	
	
	if($("input[name='roles[]']:checked").length==0){
    	alert("Please select atleast 1 Role");
 		retValue = false;
     }

     if ($('#Clinician').is(':checked') || $('#Lab_Technician').is(':checked') || $('#HEW').is(':checked')  ){
    	 if($("input[name='provider_locations[]']:checked").length==0){
        	alert("Please select atleast 1 Location");
     		retValue = false;
         }
    	 if($('#street_address').val()==""){		
    			$('#error_street_address').show();
    			retValue = false;
    	}    	
    	
    	if($('#qualification').val()==""){		
    			$('#error_qualification').show();
    			retValue = false;
    	}
    		
    	if($('#registration').val()==""){
    			$('#error_registration').show();
    			retValue = false;
    	}
    	
    	if($('#registration').val()!=""){
    		if (!$('#registration').val().match(/^\s*[a-zA-Z0-9,\s]+\s*$/)) {
    			  $('#error_special_char_regist').show();
    			  retValue = false;
      		}
    	}
     }
     
     if($('#emailid').val() !=""){
    	 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    	 if(!emailReg.test($('#emailid').val())) {
    		 $('#error_email_id').show();
    		 retValue = false;
    	   }
     }     
     
	return  retValue;
}

function validateAddUserForm(){
	var retValue = true;
	hideAllErrorMessages();
	if($('#user_name').val()==""){		
		$('#error_user_name').show();
		retValue = false;
	}
	if($('#user_name').val()!=""){		
		if (!$('#user_name').val().match(/^\s*[a-zA-Z0-9_]+\s*$/)) {
			  $('#error_special_char_user').show();
			  retValue = false;
		}
	}
	retValue = validatePassword(retValue);
	retValue = validateUserForm(retValue);
	
	return retValue;
}

function validateEditUserForm(){
	hideAllErrorMessages();
	var retValue = true;
	retValue = validateUserForm(retValue);
	if($('#new_password1').val()!="" && $('#new_password2').val()!=""){
		if($('#new_password1').val() != $('#new_password2').val()){
			alert("Password mismatch");
			retValue = false;
		}
	}
	if($('#new_password1').val()!=""){		
		if($('#user_name_hidden').val() == $('#new_password1').val()){
			alert("Password is same as Username");
			retValue=false;
		} 
	}
	return retValue;
}

function hideAllErrorMessages(){	
	$('.error').hide();	
}

function validateCreateRoleForm(){
	var retValue = true;
	hideAllErrorMessages();
	if($('#role_name').val()==""){		
		$('#error_role_name').show();
		retValue = false;
	}
	if($('#description').val()==""){		
		$('#error_description').show();
		retValue = false;
	}
	if($('#home_url').val()==""){		
		$('#error_home_url').show();
		retValue = false;
	}
	if($('#home_view').val()==""){		
		$('#error_home_view').show();
		retValue = false;
	}
	return  retValue;
}	

function editRoleValidate(){
	var retVal = true;
	if(document.getElementsByName("module[]").length == 0){
		retVal = false;
	}
	if(document.getElementsByName("controller[]").length == 0){
		retVal = false;
	}
	if(document.getElementsByName("action[]").length == 0){
		retVal = false;
	}
	if(!retVal){
		alert("A role should have atleast one role rights");
	}
	return retVal;
}
