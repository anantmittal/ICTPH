$(document).ready(function(){
  $("#chief_complaint").change(function() {
     if ($("#chief_complaint").val() == "Other") {
       $("#chief_complaint_other").removeAttr("disabled");
     } else {
       $("#chief_complaint_other").attr("disabled", "disabled");
     }
  });
});

function phychechboxOnChange(value) {
	alert(value);
	if(event.checked == true){
		$("#"+value).show();
	}else{
		$("#"+value).hide();
	}
} 