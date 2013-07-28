//THIS FILE IS NOT IN USE. NEED TO DELETE
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
//				alert(this.contentWindow.document.body.innerHTML);
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
			else { //@todo : (FOR Internet Explorer) replicate upper code below with "this.contentDocument.document.body.innerHTML" response
				alert(this.contentDocument.document.body.innerHTML);
//				jsonObj = eval(this.contentDocument.document.body.innerHTML);
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