<?php 
	if($block_user->is_user_enable){
		$disabled="disabled";
	}		
	else{
		$disabled="";
	}	
?>

<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="data_table">
    <tr>
    <td width="40%">Username</td>
    <td width="60%"> <input type="text" name="username" id="user_name" value="<?php echo $block_user->username ; ?>"  disabled/>
    <input id="user_id" type="hidden" name="user_id" value="<?php echo $block_user->id ; ?>"/></td>
    </tr>
</table>    
<br/>

<input type="submit" value="Block User" id="block_user" <?php  if(!empty($disabled)) echo ""; else echo "disabled"; ?>  > </input>
<input type="submit" value="Unblock User" id="unblock_user " <?php  if(empty($disabled)) echo ""; else echo "disabled"; ?> > </input>

