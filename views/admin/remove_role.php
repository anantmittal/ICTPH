<?php 
	if(isset($role_mapped)){
		if(sizeof($role_mapped) > 0 ){
			$disabled="disabled";
		}
		else{
			$disabled="";
		}
		
		
	}	
?>

<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="data_table">
    <tr>
    <td width="40%">Role name</td>
    <td width="60%"> <input type="text" name="name" id="role_name" value="<?php echo $role_name->name ; ?>"  disabled/>
    <input id="id" type="hidden" name="role_id" value="<?php echo $role_name->id ; ?>"/></td>
    </tr>
</table>    
<br/>

<div ><input type="submit" value="Delete Role" id="delete_role " <?php  if(empty($disabled)) echo ""; else echo "disabled"; ?> > </input></div>
<?php if(!empty($disabled)) echo "<div style='color:#736F6E;line-height:20px'>(This role is used by one or more users)</div>";  ?>

