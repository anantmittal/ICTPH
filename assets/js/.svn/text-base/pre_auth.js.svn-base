$(document).ready(function(){
	$("#pre_auth_entry").validate();
	$(".minlength").keyup(function(){
		$("#stay_duration_length").hide();
		if($("#expected_stay_duration").val().length >= 3)
		{
			$("#stay_duration_length").show();
			$("#stay_duration_length").html("Please enter Two digits duration");
		}
				
	});
	$(".cost_length").keyup(function(){
		$("#cost_length").hide();
		if($("#expected_cost").val().length >= 6)
		{
			$("#cost_length").show();
			$("#cost_length").html("Please enter appropriate cost");
		}
	});
	
	
	$('#chief_complaint').change(function(){
	if(this.value == 'Other')
		$("#chief_complaint_other").removeAttr("disabled"); 
	else
		$("#chief_complaint_other").attr("disabled", "disabled");
	});
	
	$('#current_diagnosis').change(function(){
	if(this.value == 'Other')
		$("#current_diagnosis_other").removeAttr("disabled"); 
	else
		$("#current_diagnosis_other").attr("disabled", "disabled");
	});
	
	$('#procedure').change(function(){
	if(this.value == 'Other')
		$("#procedure_other").removeAttr("disabled"); 
	else
		$("#procedure_other").attr("disabled", "disabled");
	});
	
	
	
	$(".radio").click(function() {
		if(this.value == 'yes')
        	$("#expected_stay_duration").attr('disabled', true);
        else
         	$("#expected_stay_duration").attr('disabled', false);
     });

     $(".present_illness_history").focus(function(){
      $("#present_illness_history_error").hide();
     });
     
     $(".cost_comment").focus(function(){
      $("#cost_comment_error").hide();
     });
});
