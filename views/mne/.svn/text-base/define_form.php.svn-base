<?php
/**
 * @todo : move all datatype and form_input type values to config file as array
 */


?>
<script type="text/javascript"
src='<?php echo $this->config->item("base_url")."assets/js/jquery-1.3.2.min.js"; ?>'>
</script>

<script type="text/javascript">
var cnt = 0;

$(document).ready(function(){

	$('#form_input_type').change(function(){
		var input_type = $(this).val();
//		alert(input_type);
		var supported_datatype = new Array();
		if(input_type == 'text') {
			supported_datatype = ["varchar","text", "int", "float", "date","label"];
		} else if(input_type == 'textarea') {
			supported_datatype = ["varchar","text"];
		} else if(input_type == 'select') {
			supported_datatype = ["enum"];
		} else if(input_type == 'radio') {
			supported_datatype = ["enum"];
		} else if(input_type == 'checkbox') {
			supported_datatype = ["set"];
		} else if(input_type == 'table') {
			supported_datatype = ["table"];
		} else if(input_type == 'sub_form') {
			supported_datatype = ["table"];
		} else if(input_type == 'password') {
			supported_datatype = ["varchar"];
		}
		var i = 0;
		var arr_len = supported_datatype.length;
		var options = '';
		for(i=0; i < arr_len; i ++) {
			options += '<option value="'+supported_datatype[i]+'">'+supported_datatype[i]+'</option>';
		}
		$('#datatype').html(options).change();
		$('#datatype').change();
	});


	$('#datatype').change(function(){
		var datatype = $(this).val();
//		$('#length_value_tr').show();
		if(datatype == 'set' || datatype =='enum') {
			$('#form_input_values').show();
			$('#tr_min_size').hide();
			$('#tr_max_size').hide();
			$('#tr_no_of_vals').show();
			$('#tr_var_name').show();
			$('#tr_table_name').hide();
		} 
		else if(datatype == 'label') {
			$('#form_input_values').hide();
			$('#tr_min_size').hide();
			$('#tr_max_size').hide();
			$('#tr_no_of_vals').hide();
			$('#tr_var_name').hide();
			$('#tr_table_name').hide();
		}
		else if(datatype == 'date') {
			$('#form_input_values').hide();
			$('#tr_min_size').hide();
			$('#tr_max_size').hide();
			$('#tr_no_of_vals').hide();
			$('#tr_var_name').show();
			$('#tr_table_name').hide();
		}
		else if(datatype == 'table') {
			$('#form_input_values').show();
			$('#tr_min_size').hide();
			$('#tr_max_size').hide();
			$('#tr_no_of_vals').show();
			$('#tr_var_name').show();
			$('#tr_table_name').show();
		}
		else 
		{
			$('#form_input_values').hide();
			$('#tr_min_size').show();
			$('#tr_max_size').show();
			$('#tr_no_of_vals').hide();
			$('#tr_var_name').show();
			$('#tr_table_name').hide();
		}
/*
		if(datatype == 'text' || datatype == 'date' || datatype == 'datetime' || datatype == 'timestamp' || datatype == 'enum') {
			$('#length_value').attr('disabled', 'disabled');
		} else {
			$('#length_value').removeAttr('disabled');
		}*/
	});


	$('#btn').click(function() {

		var field = $('#field').val();
		var datatype       = $('#datatype').val();

		if(datatype != 'label' && datatype != 'table' && field == '') {
			$('#lbl_field').html('Field should not be blank');
			alert('Field should not be blank');
			return;
		}
		result = field.indexOf(" ");
		if(datatype != 'label' && datatype != 'table' && result != -1) {
			alert('Space is not allowed in Field Name');
			return;
		}
		result = field.indexOf(".");
		if(datatype != 'label' && datatype != 'table' && result != -1) {
			alert('dot is not allowed in Field Name');
			return;
		}

		var unique = true;
		var sn = 0;
		for(i=0; i<cnt; i++)
		{
			if(field == $('#field_'+i).val())
			{
				sn = i;	
				unique = false;
			}
		}

		if(datatype != 'label' && datatype != 'table' && !unique) {
			alert('Variable Name should be unique. SN '+(sn+1)+' has same variable name as proposed');
			return;
		}

		//code START is for taking form input values
		var display_row = '';
		var hidden_row  = '';
		var val_cnt = 0;
		var td_cnt = 0;
		var input_val_cnt = 0;

		$('#input_value_table tr').each(function(){

			var rows = $(this).children('td');

			$(rows).each(function(){
				if(val_cnt != 0 && td_cnt != 0)
					display_row += $(this).html();

				if(td_cnt == 1 && val_cnt != 0) {
//		hidden_row += '<input type="hidden" name="form_data['+cnt+'][form_input_values]['+input_val_cnt+'][value]" value="'+$(this).html()+'">';
					display_row += ' | ';
				}
//				alert('cnt :'+cnt+'  td_cnt:'+td_cnt+'  value'+$(this).html())	;
				if(td_cnt == 2 && val_cnt != 0) {
//		hidden_row += '<input type="hidden" name="form_data['+cnt+'][form_input_values]['+input_val_cnt+'][label]" value="'+$(this).html()+'"> ';
					display_row += '<br>';
				}
				td_cnt ++;
			});

			if(val_cnt != 0)
				$(this).remove();
			td_cnt = 0;
			input_val_cnt ++;
			val_cnt ++;
		});
		//code END is for taking form input values

		if(display_row == '')
			display_row = '&nbsp;';

	    var row = '<tr>';

	    row += '<td>'+(cnt+1)+'.</td>';
	    $('#description_'+cnt).val($('#description').val());
	    row += '<td>'+$('#description').val()+'</td>';
	    $('#form_input_type_'+cnt).val($('#form_input_type').val());
	    row += '<td>'+$('#form_input_type').val()+'</td>';
	    $('#label_'+cnt).val($('#label').val());
	    row += '<td>'+$('#label').val()+'</td>';
	    $('#form_input_values_'+cnt).val(display_row);
	    row += '<td>'+display_row + '</td>';
	    if(display_row == '&nbsp;')
	    {
		$('#min_size_'+cnt).val($('#min_size').val());
	    	$('#length_value_'+cnt).val($('#length_value').val());
	    	row += '<td>'+$('#min_size').val()+'/'+$('#length_value').val()+'</td>';
	    }
	    else
	    {
	    	$('#length_value_'+cnt).val($('#no_of_values').val());
	    	row += '<td>'+$('#no_of_values').val()+'</td>';
	    	if(datatype =='table')
	    	{
		    $('#min_size_'+cnt).val($('#table_name').val());
	    	}
	    }
	    $('#field_'+cnt).val($('#field').val());
	    row += '<td>'+$('#field').val()+'</td>';
	    $('#datatype_'+cnt).val($('#datatype').val());
	    row += '<td>'+$('#datatype').val()+'</td>';
//	    row += '<td class="removeRow" id="removeRow" align="center"><input type="checkbox"></td>';
	    row += '<td onmousedown="removeRow(this,'+cnt+')"><a href="#">Remove</a></td>'

/*
	    row += '<td>'+(cnt+1)+'.</td>';
	    row += '<td><input type="hidden" name="form_input_type_'+cnt+'" value="'+$('#form_input_type').val()+'">'+$('#form_input_type').val()+'</td>';
	    row += '<td><input type="hidden" name="label_'+cnt+'" value="'+ $('#label').val()+'">'+$('#label').val()+'</td>';
	    row += '<td>'+display_row + hidden_row + '</td>';
	    row += '<td><input type="hidden" name="length_value_'+cnt+'" value="'+$('#length_value').val()+ '">'+$('#length_value').val()+'</td>';
	    row += '<td><input type="hidden" name="field_'+cnt+'"  value="'+$('#field').val()+'">'+$('#field').val()+'</td>';
	    row += '<td><input type="hidden" name="datatype_'+cnt+'" value="'+ $('#datatype').val() +'">'+$('#datatype').val()+'</td>';
	    row += '<td class="removeRow" id="removeRow" align="center"><input type="checkbox"></td>';
*/
	    row += '</tr>';

		$('#datatable tr:last').after(row);
		cnt ++;
	    $('#no_of_vars').val(cnt);

	    $('#description').val('');
	    $('#form_input_type').val('text');
	    $('#form_input_type').change();
	    $('#label').val('');
	    $('#min_size').val('');
	    $('#length_value').val('');
	    $('#no_of_values').val('');
	    $('#field').val('');
	    $('#datatype').val('varchar');
	    $('#datatype').change();
$('#form_input_values').hide();
$('#tr_table_name').hide();
$('#tr_no_of_vals').hide();
	});



	$('#add_value_btn').click(function() {

		if($('#input_value').val() == '' || $('#input_label').val() == '') {
			alert('value or label fields are required.');
			return;
		}

	    var row = '<tr>';
//	    row += '<td class="removeRow" align="center"><input type="checkbox"></td>';
	    row += '<td onmousedown="removeVLRow(this)"><a href="#">Remove</a></td>'
	    row += '<td>'+$('#input_value').val()+'</td>';
	    row += '<td>'+$('#input_label').val()+'</td>';
	    row += '</tr>';
		$('#input_value_table tr:last').after(row);
	    	$('#input_value').val('');
	    	$('#input_label').val('');
	});

/*	$('.removeRow').click(function(){
		$(this).parent().remove();
		});*/

$('#tr_table_name').hide();
$('#form_input_values').hide();
$('#tr_no_of_vals').hide();
});
function removeRow(row,cnt){
//	alert ('to remove '+row +' count ' + cnt +' form ' + $('#form_input_type_'+cnt).val());
	$('#form_input_type_'+cnt).val('null');
//	alert ('after ' + $('#form_input_type_'+cnt).val());
	$(row).parent().remove();
	var i = row.parentNode.parentNode.rowIndex;
       	document.getElementById('datatable').deleteRow(i);
}

function removeVLRow(row){
//	alert ('to remove '+row);
	$(row).parent().remove();
	var i = row.parentNode.parentNode.rowIndex;
       	document.getElementById('input_value_table').deleteRow(i);
}

</script>

<table align="center" border="1" width="100%">

	<tr>
		<td>
	    	<input type="hidden" name="no_of_vars" id="no_of_vars"/>
				<?php for($i=0; $i <500; $i++) { ?>
	  			<input name="description_<?php echo $i;?>" id="description_<?php echo $i;?>" type="hidden" />
	  			<input name="label_<?php echo $i;?>" id="label_<?php echo $i;?>" type="hidden" />
	  			<input name="field_<?php echo $i;?>" id="field_<?php echo $i;?>" type="hidden" />
	  			<input name="min_size_<?php echo $i;?>" id="min_size_<?php echo $i;?>" type="hidden" />
	  			<input name="length_value_<?php echo $i;?>" id="length_value_<?php echo $i;?>" type="hidden" />
	  			<input name="form_input_type_<?php echo $i;?>" id="form_input_type_<?php echo $i;?>" type="hidden" />
	  			<input name="form_input_values_<?php echo $i;?>" id="form_input_values_<?php echo $i;?>" type="hidden" />
	  			<input name="datatype_<?php echo $i;?>" id="datatype_<?php echo $i;?>" type="hidden" />
				<?php } ?>
		<table id="datatable" align="center" border="1" width="100%">
			<tr>
<!--				<td><b>Max Count & Min Count</b></td> -->
				<td><b>SN</b></td>
				<td><b>Description</b></td>
				<td><b>Form Input type</b></td>
				<td><b>Form Label</b></td>
				<td><b>Form Input Values</b></td>
				<td><b>Min/Max Length</b></td>
				<td><b>Data Field Name</b></td>
				<td><b>Data Type</b></td>
				<td><b>Remove</b></td>
<!--				<td><b>Validation Rules</b></td>-->
			</tr>
		</table>

		<!--<input type="submit" value="Submit">
		</form>-->
		</td>
	</tr>
	<tr>
		<td>
		<table align="left" border="1" width="100%">
			<tr>
				<td><b>Form Label</b></td>
				<td><input type="text" id="label"></td>
				<td><label id="lbl_label"> </label>Name to be displayed on the HTML Form next to the input box</td>
			</tr>
			<tr>
				<td><b>Form Input type</b></td>
				<td>
				<select id="form_input_type">
					<option value="text">Textbox</option>
					<option value="textarea">Textarea</option>
					<option value="select">Dropdown</option>
					<option value="radio">Radio</option>
					<option value="checkbox">Checkbox</option>
					<option value="table">Table</option>
					<option value="sub_form">Sub Form</option>
					<option value="password">Password</option>
				</select></td>
				<td><label id="lbl_form_input_type">
				</label>
				Input Type wanted on the HTML file during data entry
				</td>
			</tr>
			<tr>
				<td><b>Description</b></td>
				<td><input type="text" id="description"></td>
				<td><label id="lbl_description"> </label>Description of the Field</td>
			</tr>
			
			<tr>
				<td><b>Data Type</b></td>
				<td><select id="datatype">
					<option value="varchar">varchar</option>
					<option value="text">text</option>
					<option value="int">int</option>
					<option value="float">float</option>
					<option value="date">date</option>
					<option value="label">label</option>
				</select></td>

				<td><label id="lbl_datatype"> </label>Data Type in the MYSQL database / for storage in the database</td>
			</tr>
			<tr id="tr_var_name">
				<td width="40px"><b>Variable Name</b></td>
				<td width="90px"><input type="text" id="field"></td>
				<td><label id="lbl_field"> </label>Name of variable in the database (not seen by data entry operator).<br> Do not use special characters and spaces</td>
			</tr>
			<tr id="tr_table_name">
				<td width="40px"><b>Table Name</b></td>
				<td width="90px">
				<?php 
				echo form_dropdown ( 'variable_name', $modules,'','id="table_name" ' );
				?>
				</td>
				<td><label id="lbl_field"> </label>Select Name of module / table in the database (not seen by data entry operator)</td>
			</tr>
			<tr id="tr_min_size">
				<td><b>Min Size</b></td>
				<td><input type="text" id="min_size"></td>
				<td><label id="lbl_min_size"> </label>Minimum Size of the Field</td>
			</tr>
			<tr id="tr_max_size">
				<td><b>Max Size</b></td>
				<td><input type="text" id="length_value"></td>
				<td><label id="lbl_length_value"> </label>For Textbox, Textarea, Password: Maximum size of input field </td>
			</tr>
			<tr id="tr_no_of_vals">
				<td><b>No of Values</b></td>
				<td><input type="text" id="no_of_values"></td>
				<td><label id="lbl_length_value"> </label>For Dropdown,Radio and Checkbox: Number of Value-Label pairs </td>
			</tr>
			<tr id="form_input_values">
				<td valign="top" align="left"><b>Form input values</b></td>
				<td>
				<table id="input_value_table" width="" align="center" border="1">
					<tr>
						<td><b>Remove</b></td>
						<td align="center"><b>Value</b></td>
						<td align="center"><b>Label</b></td>
					</tr>
				</table>
				<br>
				<table width="" align="center">
					<tr>
						<td>Value :<input type="text" id="input_value" size="20"></td>
						<td>Label :<input type="text" id="input_label" size="20"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right"><input type="button" id="add_value_btn"
							value="Add Entry"></td>
					</tr>
				</table>
				</td>
				<td><label id="lbl_value_label"> </label>'Value' is what is stored in database;<br> 'Label' is what is seen on screen.<br>Dont give spaces in 'Value'  </td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td><input type="button" id="btn" class="addrow" value="Add Field"></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
