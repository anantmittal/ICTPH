<?php
class role_model extends IgnitedRecord {
  var $habtm = "users";
  var $has_many = "role_rights";

  function get_names() {
    $records = $this->where('id >', '1', true)->order_by('name','ASC')->find_all();
	$names = array();
    foreach ($records as $record)
      $names[$record->id] = $record->name;
  return $names;
  }

  function create_new_role($new_role_rec){
  	$new_role = $this->new_record($new_role_rec);
  	$new_role->save();
  	return $new_role; 
  }
  
  function update_role($role_description,$home_url,$home_view,$role_id) {
  	 $role = $this->find_by('id', $role_id);
  	 $role->rights = $role_description;
  	 $role->home_url = $home_url;
  	 $role->home_view = $home_view;
  	 $role->save();
  	 return $role; 	 
  }	
  
  function validate_role($rolename){
		$msg="";
		//duplicate role check
		$role_check = $this->find_by('name', $rolename);
		if($role_check) {
			$msg="Role already exists";
			return $msg;
		}
		else{
			return $msg;
		}
	}
}
