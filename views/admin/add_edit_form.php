<div style="padding-left: 35px;">
	<?php 
	    if($error_server!=''){
	    	echo "<label class=\"error\" id=\"label_server_error\"> $error_server </label> ";
	    }			    
	?>			
</div>
		
<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="data_table">
    <tr>
    <td width="40%">Username<span class="mandatory">*</span></td>
    <td width="60%"><input type="text" name="username" id="user_name" value="<?php if($edit_user!=null) echo $edit_user->username; else echo "" ; ?>" <?php echo $disable_field?> /><label class="error" id="error_user_name" style="display:none">Name field is required.</label>
    <label class="error" id="error_special_char_user" style="display:none">Special characters are not allowed.</label>
    <?php if($edit_user!=null){
    	echo "<input type='hidden' name='username' id='user_name_hidden' value='$edit_user->username' />";
    }?>
    <input id="user_id" type="hidden"  name="id" value="<?php if($edit_user!=null) echo $edit_user->id; else echo "" ; ?>" /></td>
    </tr>
    <tr>
    <td width="40%">New Password<?php if($edit_user==null) echo "<span class=\"mandatory\">*</span>"; ?></td>
    <td width="60%"><input type="password" name="new_password1" id="new_password1"/><label class="error" id="error_password" style="display:none">Password field is required.</label></td>
    </tr>
    <tr>
    <td width="40%">Repeat New Password<?php if($edit_user==null) echo "<span class=\"mandatory\">*</span>"; ?></td>
    <td width="60%"><input type="password" name="new_password2"/ id="new_password2"><label class="error" id="error_repeat_password" style="display:none">Repeat Password field is required.</label></td>
    </tr>
    <tr>
    <td width="40%">Full Name<span class="mandatory">*</span></td>
    <td width="60%"><input type="text" name="full_name" id="fullname" value="<?php if($edit_user!=null) echo $edit_user->name; else echo "" ; ?>" /><label class="error" id="error_full_name" style="display:none">Full Name field is required.</label></td>
    </tr>
    <tr>
    <td width="40%">Contact Number<span class="mandatory">*</span></td>
    <td width="60%"><input type="text" name="contact" id="contact_number" value="<?php if($edit_user!=null) echo $edit_user->contact_number; else echo "" ; ?>" /><label class="error" id="error_contact" style="display:none">Contact Number field is required.</label><label class="error" id="error_special_char_contact" style="display:none">Special characters are not allowed.</label></td>
    </tr>
    <tr>
    <td width="40%">Email id</td>
    <td width="60%"><input type="text" name="emailid" id="emailid" value="<?php if($edit_user!=null) echo $edit_user->email_id; else echo "" ; ?>" /><label class="error" id="error_email_id" style="display:none">Not a valid email id.</label></td>
    </tr>
     
     <tr>
    <td width="40%">Roles<span class="mandatory">*</span></td>
    <td width="60%">&nbsp;</td>
    </tr>
</table>
<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="data_table">
     <?php
     $j = 0;
     $k = 0;
     	foreach($roles as $key => $role){
     		$checked="";
     		$disabled="";
     		$hidden_field="";
     		
     		if(isset($mapped_roles)){
     				foreach ( $mapped_roles as $key_userId => $value_roleId ) {
       				if($key == $value_roleId->role_id){
       					$checked="checked";
       						if($value_roleId->role_id == 7 || $value_roleId->role_id == 15 || $value_roleId->role_id == 17){
     							$disabled="disabled";
     						}

       				}
				}
     		}	
     			     		
     			
     		$clean_name = $displayer->remove_whitespace($roles[$key]);
     		$r_name=ucwords($roles[$key]);
     		if(!empty($disabled)){
    			$hidden_field = "<input type= 'hidden' id=$clean_name name=\"roles[]\"  value= $key $checked/>"; 			
     		}
     		
     		if($j%4 == 0){
     			$k = 0;  			
     			echo "<tr>";
     		}
    		echo "<td> <input type= 'checkbox' id=$clean_name name=\"roles[]\"  value= $key $checked $disabled /> $r_name $hidden_field </td> ";
    		if($k == 3){
    			echo "</tr>";
    		}
    		$j++;
    		$k++;
        }
     ?>
     
     <?php $this->load->view('opd/provider_add_for_clinician_and_technician.php'); ?>
     
     
</table>
<br/>
<table align="center" >
<tr>
<td width="50%" align="center">
<td width="50%" align="center"><input type="submit" value="submit" name="submit" class="submit"/></td>
 </tr>
</table>