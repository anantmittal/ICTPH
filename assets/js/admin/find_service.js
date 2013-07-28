$(document).ready(function(){
		$("#search_service").user_autocomplete(service_list,'service_id');
		
	});

function onFindServiceSubmit(baseUrl){
	
	var serviceExists = validateServicename();
	
	if(!serviceExists)
		return;
	
	var serviceId = $('#service_id').val();
	if(serviceId.length==0){
		
		var serviceName = $('#search_service').val();
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/edit_typed_service/';	
		submitUrl = submitUrl + serviceName	
		$('#find_service_form').attr('action', submitUrl);
	}
	else{
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/edit_service/';
		submitUrl = submitUrl + serviceId	
		//alert(submitUrl);
		$('#find_service_form').attr('action', submitUrl);
	}		
}

function onFindServiceSubmitBlock(baseUrl){
	var serviceExists = validateServicename();
	
	if(!serviceExists)
		return;
	
	var serviceId = $('#service_id').val();
	if(serviceId.length==0){
		
		var serviceName = $('#search_service').val();
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/block_typed_service/';	
		submitUrl = submitUrl + serviceName	
		$('#find_service_form_block').attr('action', submitUrl);
	}
	else{
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/block_service/';
		submitUrl = submitUrl + serviceId	
		
		$('#find_service_form_block').attr('action', submitUrl);
	}		
}

function validateServicename(){
	var serviceExists = false;	
	var servicename= $('#search_service').val();	
	for(i=0;i<service_list.length;i++){
		if(service_list[i].name.toLowerCase() == servicename.toLowerCase()){
			serviceExists = true;
			break;
		}		
	}	
	return serviceExists;
}