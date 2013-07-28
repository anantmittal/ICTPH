 $(document).ready(function(){
 	$("#hospitalization_form").validate();
 	

 	$(".presenting_complaints").keyup(function(){
 		$("#presenting_complaints_error").hide();
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
 	
 	$(".submit").click(function()
 	{
 		 		
 		if($("#status").val() == 'Admitted' && ($("#hospitalization_date").val() == ""||$("#hospitalization_date").val() == "0000-00-00"))
 		{
 			$("#error_addmission_date").html("Please enter addmission date");
 			return false;
 		}
 		if($("#status").val() == 'Discharged' && ($("#discharge_date").val() == ""))
 		{
 			$("#error_discharged_date").html("Please enter discharge date");
 			return false;
  		}
  		if($("#status").val() == 'Discharged' || $("#discharge_date").val() == "0000-00-00")
  		{
  			hospitalization_date = ($("#hospitalization_date").val()).split('/');
			discharge_date = ($("#discharge_date").val()).split('/');
			temp=discharge_date[0];
			discharge_date[0]=discharge_date[1];
			discharge_date[1]=temp;
			
			temp=hospitalization_date[0];
			hospitalization_date[0]=hospitalization_date[1];
			hospitalization_date[1]=temp;
			
			hospitalization_date=new Date(hospitalization_date.join('/'));
			discharge_date=new Date(discharge_date.join('/'));
			
			
		  
  			if(hospitalization_date > discharge_date)
  			{
  				$("#error_discharged_date").html("Discharge date must be greater than addmission date");
  				return false;
  			}
  		}
 	});
});
