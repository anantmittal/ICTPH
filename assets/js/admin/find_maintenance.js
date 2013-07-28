$(document).ready(function(){
		$("#search_maintenance").user_autocomplete(maintenance_list,'maintenance_id');
		
	});

function onFindMaintenanceSubmit(baseUrl){
	
	var maintenanceExists = validateMaintenancename();
	
	if(!maintenanceExists)
		return;
	
	var maintenanceId = $('#maintenance_id').val();
	if(maintenanceId.length==0){
		
		var maintenanceName = $('#search_maintenance').val();
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/edit_typed_maintenance/';	
		submitUrl = submitUrl + maintenanceName	
		$('#find_maintenance_form').attr('action', submitUrl);
	}
	else{
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/edit_maintenance/';
		submitUrl = submitUrl + maintenanceId	
		$('#find_maintenance_form').attr('action', submitUrl);
	}		
}

function onFindMaintenanceSubmitBlock(baseUrl){
	var maintenanceExists = validateMaintenancename();
	
	if(!maintenanceExists)
		return;
	
	var maintenanceId = $('#maintenance_id').val();
	if(maintenanceId.length==0){
		
		var maintenanceName = $('#search_maintenance').val();
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/block_typed_maintenance/';	
		submitUrl = submitUrl + maintenanceName	
		$('#find_maintenance_form_block').attr('action', submitUrl);
	}
	else{
		var submitUrl = baseUrl + 'index.php/admin/consumables_configuration/block_maintenance/';
		submitUrl = submitUrl + maintenanceId	
		
		$('#find_maintenance_form_block').attr('action', submitUrl);
	}		
}

function validateMaintenancename(){
	var maintenanceExists = false;	
	var maintenanceName= $('#search_maintenance').val();	
	for(i=0;i<maintenance_list.length;i++){
		if(maintenance_list[i].name.toLowerCase() == maintenanceName.toLowerCase()){
			maintenanceExists = true;
			break;
		}		
	}	
	return maintenanceExists;
}