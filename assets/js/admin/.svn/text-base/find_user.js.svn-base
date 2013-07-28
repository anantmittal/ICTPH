$(document).ready(function(){	
  //   users_list = [ {id: '101', name:'Para kdjhfkjsdhfk/sdkjhfksjhfksd/sdjfh'}, {id:'102', name: 'Pare sdkjhfsk/ skjhdfksd ()'},{id:'103',name:'Sty'}, ];
  
	$("#user_name").user_autocomplete(user_list, "user_id");	
});

function onFindUserSubmit(baseUrl){
	var userExists = validateUsername();
	if(!userExists)
		return;
	
	var userId = $('#user_id').val();
	if(userId.length==0){
		var userName = $('#user_name').val();
		var submitUrl = baseUrl + 'index.php/admin/user_management/edit_user_no_user_id/';	
		submitUrl = submitUrl + userName	
		$('#find_user_form').attr('action', submitUrl);
	}
	else{
		var submitUrl = baseUrl + 'index.php/admin/user_management/edit_user/';	
		submitUrl = submitUrl + userId	
		$('#find_user_form').attr('action', submitUrl);
	}		
}

function onFindUserSubmitBlock(baseUrl){
	var userExists = validateUsername();
	if(!userExists)
		return;
	var userId = $('#user_id').val();
	if(userId.length==0){
		var userName = $('#user_name').val();
		var submitUrl = baseUrl + 'index.php/admin/user_management/block_user_no_user_id/';	
		submitUrl = submitUrl + userName;			
		$('#find_user_form_block').attr('action', submitUrl);
	}else{
		var submitUrl = baseUrl + 'index.php/admin/user_management/block_user/';		
		submitUrl = submitUrl + userId;
		$('#find_user_form_block').attr('action', submitUrl);
	}
}

function validateUsername(){
	var userExists = false;	
	var username= $('#user_name').val();	
	for(i=0;i<user_list.length;i++){
		if(user_list[i].name.toLowerCase() == username.toLowerCase()){
			userExists = true;
			break;
		}		
	}	
	return userExists;
}