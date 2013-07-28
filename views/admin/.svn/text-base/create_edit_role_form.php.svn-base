<div style="padding-left: 35px;">
	<?php 
	    if($error_server!=''){
	    	echo "<label class=\"error\" id=\"label_server_error\"> $error_server </label> ";
	    }
	?>
</div>

<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="data_table">
    <tr>
    	<td width="40%">Role name<span class="mandatory">*</span></td>
    	<td width="60%"><input type="text" name="name" id="role_name" value="<?php if(isset($edit_role)) echo $edit_role->name; else echo "" ; ?>"  <?php if(isset($disable_field)) echo $disable_field; else echo ""; ?> /><label class="error" id="error_role_name" style="display:none">Role Name field is required.</label>
    	<?php 
    		if(isset($edit_role)){
    			echo "<input type=\"hidden\" name=\"name\" id=\"role_name\" value=$edit_role->name   $disable_field; />";
    			echo "<input type=\"hidden\" name=\"id\" value=$edit_role->id />";
    		}	
    			    			
    	?>
    	
    </tr>
    <tr>
    	<td width="40%">Description<span class="mandatory">*</span></td>
    	<td width="60%"><input type="text" name="rights" id="description" value="<?php if(isset($edit_role)) echo $edit_role->rights; else echo "" ; ?>"/><label class="error" id="error_description" style="display:none">Description field is required.</label></td>
    </tr>
    <tr>
    	<td width="40%">Home URL<span class="mandatory">*</span></td>
    	<td width="60%"><input type="text" name="home_url"/ id="home_url" value="<?php if(isset($edit_role)) echo $edit_role->home_url; else echo "" ; ?>"><label class="error" id="error_home_url" style="display:none">Home URL field is required.</label></td>
    </tr>
    <tr>
    	<td width="40%">Home View file<span class="mandatory">*</span></td>
    	<td width="60%"><input type="text" name="home_view" id="home_view" value="<?php if(isset($edit_role)) echo $edit_role->home_view; else echo "" ; ?>" /><label class="error" id="error_home_view" style="display:none">Home View field is required.</label></td>
    </tr>     
</table>
<br/>
<table width="600" align="center">
	<tr>
	 	<td><strong>Role Rights</strong> </td>
	</tr>
	<tr>
	<td> <b> Module</b><span class="mandatory">*</span>   <input type="text" id="module_text_box" value="" size="16" /> &nbsp;
		<b> Controller</b><span class="mandatory">*</span>  <input type="text"  id="controller_text_box" value="" size="16" /> &nbsp;
		<b> Action </b><span class="mandatory">*</span>  <input type="text" id="action_text_box" value="" size="16" />
		<input type="button" value="Add" name="Add"  id="addButton" title="Adds a row"/> 
	</td>
	</tr>
	<tr>
		<td>
			<label class="error" id="error_mvc" style="display:none">Above fileds cannot be blank.</label>
		</td>
	<tr>
</table>
<table width="600" align="center" id="role_rights_label_tabel" class="data_table" cellspacing="1px" cellpadding="5px">
<tr>
 <th width="150">Module</th>
 <th width="150">Controller</th>
 <th width="150">Action</th>
 <th width="150">&nbsp;</th>
</tr>
<?php
if(isset($mapped_rights)){
	$rowcount = 2;
	foreach ( $mapped_rights as $role_rights ) {
	echo	"<tr id=\"role_div_$rowcount\">" .
			"<td align=\"center\" width=\"150\"><span id=\"module_text_$rowcount\">$role_rights->module</span>
			<input type=\"hidden\" name=\"module[]\" id=\"module_name_$rowcount\" value=\"$role_rights->module\" />
			</td>
			<td align=\"center\" width=\"150\"><span id=\"controller_text_$rowcount\">$role_rights->controller</span>
			<input type=\"hidden\" name=\"controller[]\" id=\"controller_name_$rowcount\" value=\"$role_rights->controller\" />
			</td>
			<td align=\"center\" width=\"150\"><span id=\"action_text_$rowcount\">$role_rights->action</span>
			<input type=\"hidden\" name=\"action[]\" id=\"action_name_$rowcount\" value=\"$role_rights->action\" />
			</td>
			<td align=\"center\" width=\"150\"><input type=\"button\" value=\"Remove\" name=\"remove\"  id=\"removeButton_$rowcount\" title=\"Removes row\" onClick=\"remove_roles($rowcount);\"/></td>
			</tr>";
			$rowcount++;
	}
}
?>
</table>
<table align="center" >
	<tr>
		<td width="600" align="center"><input type="submit" value="submit" name="submit" class="submit"/></td>
 	</tr>
</table>

<script type="text/javascript">
	var intialrowcount = $('#role_rights_label_tabel tr').length;
	if(intialrowcount == 1){
		$('#role_rights_label_tabel').hide();
	}else{
		$('#role_rights_label_tabel').show();
	}

	$('#addButton').click(function(){
		$('#error_mvc').hide();
		if(jQuery.trim($('#module_text_box').val()) == "" ||
				jQuery.trim($('#controller_text_box').val()) == "" ||
					jQuery.trim($('#action_text_box').val()) == ""){
					$('#error_mvc').show();
					return;	
		}
		if($('#role_rights_label_tabel').hide()){
			$('#role_rights_label_tabel').show();
		}
		var rowcount =  $('#role_rights_label_tabel tr').length+1;		
		var htmlcontent = '<tr id="role_div_'+rowcount+'"><td align="center" width="150"><span id="module_text_'+rowcount+'"></span>'+
		'<input type="hidden" name="module[]" id="module_name_'+rowcount+'" value="" />'+
		'</td>'+
		'<td align="center" width="150"><span id="controller_text_'+rowcount+'"></span>'+
		'<input type="hidden" name="controller[]" id="controller_name_'+rowcount+'" value="" />'+
		'</td>'+
		'<td align="center" width="150"><span id="action_text_'+rowcount+'"></span>'+
		'<input type="hidden" name="action[]" id="action_name_'+rowcount+'" value="" />'+
		'</td>'+
		'<td align="center" width="150"><input type="button" value="Remove" name="remove"  id="removeButton_'+rowcount+'" title="Removes row"/></td>'+
		'</tr>';


		$('#role_rights_label_tabel tr:last').after(htmlcontent);
		
		//Add to span element
		$('#module_text_'+rowcount).html($('#module_text_box').val());
		$('#controller_text_'+rowcount).html($('#controller_text_box').val());
		$('#action_text_'+rowcount).html($('#action_text_box').val());
		//Add to hidden element
		$('#module_name_'+rowcount).val($('#module_text_box').val());
		$('#controller_name_'+rowcount).val($('#controller_text_box').val());
		$('#action_name_'+rowcount).val($('#action_text_box').val());
		//Remove link
		//$('#removeLink_'+rowcount).show();
		//$('#removeLink_'+rowcount).attr('onClick',remove_roles);
		$('#module_text_box').val("");
		$('#controller_text_box').val("");
		$('#action_text_box').val("");
		
		$('#removeButton_'+rowcount).click(function() { 	
 			$('#role_div_'+rowcount).remove();
 			var rowcountafter = $('#role_rights_label_tabel tr').length;
			if(rowcountafter == 1){
				$('#role_rights_label_tabel').hide();
			}
  		});
	});

function remove_roles(rowcount){
	$('#role_div_'+rowcount).remove();
 	var rowcountafter = $('#role_rights_label_tabel tr').length;
	if(rowcountafter == 1){
		$('#role_rights_label_tabel').hide();
	}
}  
</script> 