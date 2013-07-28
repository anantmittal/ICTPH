$(document).ready(function(){
	$("#report_type").change(function(){
		var type;
		type = this.value;
		type = type.replace(' ','_');
		$('.to_hide').hide();
		$('#'+type).show();
		
	});
	
	$(".datepicker").datepicker({dateFormat: 'dd/mm/yy',
	showOn: 'button',
	buttonImage: base_url+'/assets/images/common_images/img_datepicker.gif',
	buttonImageOnly: true,
	onClose:function(dateTxt){
		$('.report_date').val(dateTxt);
	 }
	});
   
	//diagnostic_type   Lab Test      Lab_Test   Diagnostic_Type_other
	$('#diagnostic_type').change(function(){
		if(this.value != 'Lab Test'){
			$('#Diagnostic_Type_other').hide();
			$('#Lab_Test').show();
		}
		else{
			$('#Diagnostic_Type_other').show();
			$('#Lab_Test').hide();
		}
	})

 /* js code for hospital record entry trough ajax */
 /*
 	var url=base_url+"index.php/hospitalization/hospitalization/test";
	$('#hospital_record_form').validate();

	$(".button").click(function() {

		// validate and process form here

		if($("#report_type").val() == "note")
		{
			var dataString = 'date='+$("#report_date").val() + '&report_type=' + $("#report_type").val() + '&note_type='+$("#note_type").val() + '&test='+$("#test").val() + '&written_by='+$("#written_by").val() ;
		}
		else if($("#report_type").val() == "diagnostic report")
		{
			if($("#diagnostic_type").val() == "Lab Test")
			{
				var dataString = 'date='+$("#report_date").val() + '&report_type=' + $("#report_type").val() + '&diagnostic_type='+$("#diagnostic_type").val() + '& lab_test_text='+$("#lab_test_text").val() + '&lab_name='+$("#lab_name").val() + '&upload_scan_image='+$("#upload_scan_image").val();
			}
			else
			{
				var dataString = 'date='+$("#report_date").val() + '&report_type=' + $("#report_type").val() +  '&diagnostic_type='+$("#diagnostic_type").val() + '&diagnostic_type_text='+$("#diagnostic_type_text").val() + '&value='+$("#value").val() + '&conducted_by='+$("#conducted_by").val();
			}
		}
		else if($("#report_type").val()=="vital signs")
		{
			var dataString = 'date = '+$("#report_date").val() + '&report_type=' + $("#report_type").val() + '&min_pulse = '+$("#min_pulse").val() + '&systolic ='+$("#systolic").val() + '&diastolic = '+$("#diastolic").val() + '&respiratory_rate ='+$("#respiratory_rate").val() + '&temperature = '+$("#temperature").val() + '&ox_pulse = '+$("#ox_pulse").val() + '&capillary_refill = '+$("input[name='capillary_refill']:checked").val() + '&recorded_by = '+$("#recorded_by").val();
		}
		else if($("#report_type").val()=="medication administration")
		{
			var dataString = 'date='+$("#report_date").val() + '&report_type=' + $("#report_type").val() + '&medication_type='+$("#medication_type").val() + '&name_of_medicine='+$("#name_of_medicine").val() + '&amount='+$("#amount").val() + '&unit='+$("#unit").val() + '&frequency='+$("#frequency").val() + '&route_of_administration='+$("#route_of_administration").val() +  '&duration='+$("#duration").val() +  '&duration_format='+$("#duration_format").val();
		}
		else
		{
			var dataString = 'date='+$("#report_date").val() + '&report_type=' + $("#report_type").val() + '&other_medication_type='+$("#other_medication_type").val() + '&madication_file_upload='+ $("#madication_file_upload").val();
		}
		$.ajax({
			type: "POST",
			url: url,
			data: dataString,
			success: function(response)
			{
				alert(response);
			}
		});
		return false;
	});*/
});




 // CODE WAS IN CLAIM.JS FILE
 //CODE START
 
function remove_file_row(row_id){
	$(row_id).remove();
}
	
var flag = false;
var note_file_cnt = 1;
var diagnostic_report_file_cnt = 1;
var other_file_cnt = 1;
$(document).ready(function(){
		
	document.getElementById('post_response').onload = function(event) {
		var result;
		var result_arr;
		if(flag)
		{
			if(this.contentWindow) {			
				result = this.contentWindow.document.body.innerHTML;				
				result_arr = result.split('|');
//				alert(result_arr[0]);
				if(result_arr[0] == 0) {
		 			$('#error_block').addClass('success');		 			
				}
				else {					
		 			$('#error_block').addClass('error');		 			
				}

				$('html, body').animate({ scrollTop: $('#error_block').offset().top }, 1000);
				$('#error_block').html(result_arr[1]);
	 			$('#error_block').show(1000);
			}
			else { //for ie
				result = this.contentDocument.document.body.innerHTML;			
				result_arr = result.split('|');
				if(result_arr[0] == 0) {
		 			$('#error_block').addClass('success');		 			
				}
				else {					
		 			$('#error_block').addClass('error');		 			
				}

				$('html, body').animate({ scrollTop: $('#error_block').offset().top }, 1000);
				$('#error_block').html(result_arr[1]);
	 			$('#error_block').show(1000);
			}
		}
	};
	
	$('#note_add_file').click(function(){		
        var func = "remove_file_row('" + "#note_file_row" + note_file_cnt + "')";        
		$('#note_files_table tr:last').after('<tr id="note_file_row'+ note_file_cnt +'"><td><input type="file" name="note_report_file'+note_file_cnt+'" id="note_report_file'+note_file_cnt+'"/></td><td><a href="#" onclick="'+ func  +'">remove</a> </td></tr>');
		note_file_cnt++;
	});
	
	$('#diagnostic_report_add_file').click(function(){
        var func = "remove_file_row('" + "#diagnostic_report_row" + diagnostic_report_file_cnt + "')";        
		$('#diagnostic_report_table tr:last').after('<tr id="diagnostic_report_row'+ diagnostic_report_file_cnt +'"><td><input type="file" name="diagnostic_report_file'+diagnostic_report_file_cnt+'" id="note_report_file'+diagnostic_report_file_cnt+'"/></td><td><a href="#" onclick="'+ func  +'">remove</a> </td></tr>');
		diagnostic_report_file_cnt++;
	});
	
	
	$('#other_add_file').click(function(){
        var func = "remove_file_row('" + "#other_file_row" + other_file_cnt + "')";        
		$('#other_file_table tr:last').after('<tr id="other_file_row'+ other_file_cnt +'"><td><input type="file" name="other_file'+diagnostic_report_file_cnt+'" id="note_report_file'+other_file_cnt+'"/></td><td><a href="#" onclick="'+ func  +'">remove</a> </td></tr>');
		other_file_cnt++;
	});	
		 
});
 //CODE END