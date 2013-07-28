$(document).ready(function(){ 
	$("#role_name").user_autocomplete(role_list, "role_id");	
});

function onFindRole(baseUrl){
	var roleExists = validateRolename();
	if(!roleExists)
		return;
	var roleId = $('#role_id').val();	
	if(roleId.length==0){
		var roleName = $('#role_name').val();		
		var submitUrl = baseUrl + 'index.php/admin/user_management/edit_role_no_role_id/';	
		submitUrl = submitUrl + roleName;			
		$('#find_role_form').attr('action', submitUrl);
	}else{
		var submitUrl = baseUrl + 'index.php/admin/user_management/edit_role/';		
		submitUrl = submitUrl + roleId;
		$('#find_role_form').attr('action', submitUrl);
	}
	
}

function onFindRoleForDelete(baseUrl){
	var roleExists = validateRolename();
	if(!roleExists)
		return;
	var roleId = $('#role_id').val();
	if(roleId.length==0){
		var roleName = $('#role_name').val();		
		var submitUrl = baseUrl + 'index.php/admin/user_management/delete_role_no_role_id/';	
		submitUrl = submitUrl + roleName;			
		$('#find_role_form').attr('action', submitUrl);
	}else{
		var submitUrl = baseUrl + 'index.php/admin/user_management/delete_role/';		
		submitUrl = submitUrl + roleId;
		$('#find_role_form').attr('action', submitUrl);
	}
	
}

function validateRolename(){
	var roleExists = false;	
	var roleName= $('#role_name').val();	
	for(i=0;i<role_list.length;i++){
		if(role_list[i].name == roleName ){
			roleExists = true;
			break;
		}		
	}
	
	return roleExists;
}