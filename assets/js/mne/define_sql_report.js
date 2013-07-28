$(document).ready(function(){
  // Following is required because refresh page refresh may not clear this
  // hidden variable
  //$("#variable_row_id").val(1);

  $('#show_variable_box').click(function() {
    $('#edit_variable_box').show();
				  });
  
  $('#add_variable').click(function() {
  if($("#variable_name").val() !='')
  {
    var i = parseInt($("#variable_row_id").val());
    $("#variable_row_id").val(i+1);

      var v_name = $("#variable_name").val();
      var v_alias= $("#variable_alias").val();
      var v_type = $("#variable_type").val();
      $("#name_"+i).val(v_name);
      $("#alias_"+i).val(v_alias);
      $("#type_"+i).val(v_type);
      s = '<tr>' 
	+ '<td>' + i 
	+ '</td>'
	+ '<td>' + v_name
	+ '</td>'
	+ '<td>' + v_alias
	+ '</td>'
	+ '<td>' + v_type
	+ '</td>'
        + '<td onmousedown="removeRow(this)"><a href="#">Remove</a></td>'
        + '</tr>';
 
    $("#variables").append(s);
    $('#edit_variable_box').hide();
   }
   else
   {	
//	 "Please enter Variable name" ;
  	$("#variable_name").val('Enter Variable name');
   }
			     });
		  });

function removeRow(col) {	
//	$(row).parent().remove();
//	var j = row.parentNode.parentNode.rowIndex;
//	var j = $(row).parent().index();
	var row = col.parentNode;
	var j = Number(row.rowIndex);
//	var sn_col = row.getElementsByTagName("td")[0];
	var sn_col = row.cells[0];
	var index = sn_col.innerHTML;
//	alert("j = " + j + " sn_col = " + sn_col + " index = " + index);
        $("#name_" + index).val('');
        $("#alias_" + index).val('');
        $("#type_" + index).val('');
	document.getElementById('variables').deleteRow(j);
}

