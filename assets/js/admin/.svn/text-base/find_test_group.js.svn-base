$(document).ready(function(){
		$("#search_test_group").user_autocomplete(test_group_list,'test_group_id');
		
});

function onTestGroupServiceSubmit(baseUrl){
	
	var testGroupExists = validateTestGroupname();
	
	if(!testGroupExists)
		return;
	
	var testGroupId = $('#test_group_id').val();
	if(testGroupId.length==0){
		
		var testGroupName = $('#search_test_group').val();
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/edit_typed_test_group/';	
		submitUrl = submitUrl + testGroupName	
		$('#find_test_group_form').attr('action', submitUrl);
	}
	else{
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/edit_test_group/';
		submitUrl = submitUrl + testGroupId	
		//alert(submitUrl);
		$('#find_test_group_form').attr('action', submitUrl);
	}		
}

function onTestGroupServiceSubmitDelete(baseUrl){
	
	var testGroupExists = validateTestGroupname();
	
	if(!testGroupExists)
		return;
	
	var testGroupId = $('#test_group_id').val();
	if(testGroupId.length==0){
		
		var testGroupName = $('#search_test_group').val();
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/block_typed_test_group/';	
		submitUrl = submitUrl + testGroupName	
		$('#find_test_group_form_block').attr('action', submitUrl);
	}
	else{
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/find_test_group_to_remove/';
		submitUrl = submitUrl + testGroupId	
		//alert(submitUrl);
		$('#find_test_group_form_block').attr('action', submitUrl);
	}		
}
function validateTestGroupname(){
	var testGroupExists = false;	
	var testGroupName= $('#search_test_group').val();	
	for(i=0;i<test_group_list.length;i++){
		if(test_group_list[i].name.toLowerCase() == testGroupName.toLowerCase()){
			testGroupExists = true;
			break;
		}		
	}	
	return testGroupExists;
}