$(document).ready(function(){

  $('#add_addendum').click(function() {
    $('#edit_addendum_box').show();
  });
  
  $("#datepicker").datepicker({buttonImage: base_url + 'assets/images/common_images/img_datepicker.gif', changeYear: true, yearRange: '2010:2030', dateFormat: 'dd/mm/yy', altField: "#date", altFormat: "yy-mm-dd"});
  // constrainInput: true??
  
  $('#submit').click(function() {
	$("#addenddum-page-loader").show();
    var fields = ["date", "addendum"];
    var data = {};
    for (var k in fields)
      data[fields[k]] = $("#" + fields[k]).val();
    // data = {addendum: "", status: "", start_date: ""};
    if ($('#sendemail').attr('checked')) {
    	  data["ischecked"] = $('#sendemail').attr('checked');
    }
   
    var f1 = function(data, json) {
      // Update the addendum box to add a row for the newly addess
      var result = eval("(" + json + ")");
      error = result["status"] == "error";
      msg = result["msg"];
      addendum_id=result["addendum_id"];
      if (error) {
    	$('#error_block').addClass('error');
    	$("#addenddum-page-loader").hide();
      } else {
    	  var date=data["date"];
    	  var addendum1=data["addendum"];  
		$('#error_block').addClass('success');
		$("#addendums").append('<tr>'
									+'<td colspan=4>'
										+'<form  method="POST" id="addendum_edit_'+addendum_id+'">'
											+'<table width="100%" border="0" cellspacing="2" cellpadding="2">'
												+'<tr>'
													+'<td width="15%" id="edit_date_'+addendum_id+'"><div class="audit_'+addendum_id+'">' + date +'</div>'
											       + '</td><td width="10%">' + username
											       + '</td><td width="65%" id="edit_addendum_'+addendum_id+'"><div class="audit_'+addendum_id+'">' + addendum1+'</div>'
											       + '</td><td width="10%" id="edit_button_'+addendum_id+'" onclick="editAddendum(\''+date+'\',\''+addendum1+'\',\''+addendum_id+'\')"><div class="audit_'+addendum_id+'"><a href="javascript:void(0);" >Edit</a></div>'
											       + '</td>'
												+'</tr>'
											+'</table>'
										+'</form>'
									+'</td>'
								+'</tr>');
	    $('#edit_addendum_box').hide();
      }
      $('#error_block').html(msg);
      $('#error_block').show();
      $("#addenddum-page-loader").hide();
    };

    var f2 = function(data) {
      var f3 = function(xml) {
    	  return f1(data, xml);
      };
      return f3;
    };

    $.post(base_url + "index.php/opd/visit/add_addendum/" + visit_id, data,f2(data));
  });
 });

function editAddendum(date,addendum,addendum_id){
	//alert('sad');
	var date1='<input type="text" id="datepicker_'+addendum_id+'"name="datepicker" value="'+date+'" size="8" readonly="readonly"/><input type="hidden" name="addendum_id" id="addendum_id" value="'+addendum_id+'" />';
	var addendum1='<input type="text" id="edit_addendum" name="edit_addendum" value="'+addendum+'" size="44"/><input type="hidden" name="visit_id" value="'+visit_id+'"/>';
	var edit_button=' <input id="submit_audit" onclick =submitEditedAddendum("'+addendum_id+'") type="button" value="edit" class="submit"/>';
	$('.audit_'+addendum_id).hide();
	$('#edit_date_'+addendum_id).html(date1);
	$('#edit_addendum_'+addendum_id).html(addendum1);
	$('#edit_button_'+addendum_id).html(edit_button);
	$("#datepicker_"+addendum_id).datepicker({buttonImage: base_url + 'assets/images/common_images/img_datepicker.gif', changeYear: true, yearRange: '2010:2030', dateFormat: 'dd/mm/yy', altField: "#date", altFormat: "yy-mm-dd"});
}

function submitEditedAddendum(addendum_id){
	if($.trim($('#datepicker_'+addendum_id).val())!='' && $.trim($('#edit_addendum').val())!=''){
		document.forms["addendum_edit_"+addendum_id].action = base_url+"index.php/opd/visit/edit_addendum/"+policy_id;
		document.forms["addendum_edit_"+addendum_id].submit();
	}
}
