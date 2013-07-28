<?php
class role_right_model extends IgnitedRecord {
  var $belongs_to = "role";

	function get_roleids($module, $controller, $action){
		$roleid_recs = $this->select('role_id','role_id')
			->where('module',$module)
		     	->where('controller',$controller)
			->where('action',$action)
			->find_all();
		return $roleid_recs;
	}
	
	function add_role_right($role_id,$module_array,$controller_array,$action_array){		
		for($i=0;$i<sizeof($module_array);$i++){
			$new_role_right_rec = $this->new_record();
			$new_role_right_rec->role_id = $role_id;
			$new_role_right_rec->module = $module_array[$i];
			$new_role_right_rec->controller = $controller_array[$i];
			$new_role_right_rec->action = $action_array[$i];
			$new_role_right_rec->save();				
		}
	}
	
	function update_role_right($role_id,$module_array,$controller_array,$action_array) {		
		$role_rights_mapped_DB = $this->find_all_by('role_id' ,$role_id);
				
		// for deleting
		foreach ($role_rights_mapped_DB as $value){
			$delete_row = false;
			for($i=0;$i<sizeof($module_array);$i++){
				if($value->module == $module_array[$i] && $value->controller == $controller_array[$i] && 
					$value->action  == $action_array[$i]){
					$delete_row = false;
					break;
				}
				else{
					$delete_row = true;
				}
			}
				
			if($delete_row){
				$value->delete();
			}
				
		}
		
		// for inserting new rec and updating existing
		$role_rights_mapped_latest_DB = $this->find_all_by('role_id' ,$role_id);
		for($i=0;$i<sizeof($module_array);$i++){
			$does_not_exists = false;
			foreach ($role_rights_mapped_latest_DB as $value){
				if($module_array[$i]==$value->module && $controller_array[$i] == $value->controller &&
				$action_array[$i] == $value->action){
					$does_not_exists = true;
					break;
				}
				else{
					$does_not_exists = false;
				}
				
			}
			
			// if each field is new then insert else update
			if($does_not_exists == false){
				$new_role_right_rec = $this->new_record();
				$new_role_right_rec->role_id = $role_id;
				$new_role_right_rec->module = $module_array[$i];
				$new_role_right_rec->controller = $controller_array[$i];
				$new_role_right_rec->action = $action_array[$i];
				$new_role_right_rec->save();
			}
		}
		
	} // end of function
	
	function delete_role_rights($role_rights){
		foreach ( $role_rights as $value ) {
       			$value->delete();
		}		
	}
}
