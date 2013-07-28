$(function(){
	$('#submit').click(function(){
		$("#payment_request_form").validate({
			errorPlacement: function(error, element) {
				error.appendTo(element.parent("div").next("div") );
			},
			debug:true
		});
		if (Date.parse($("#start_date").val()) > Date.parse($("#end_date").val()))
		{
			$('#diff_error').html("End Date cannot be less than Start Date.");
			$('#diff_error').addClass('error');
			return false;
		}
		if($("#payment_request_form").valid() == false)
			return;
		document.payment_request_form.submit();
	});
});