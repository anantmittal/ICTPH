<?php
class users_role_model extends IgnitedRecord {
	var $habtm = "users";

	function save_user_roles($user,$role_array) {
		$ur_rec = $this->new_record();
		$ur_rec->user_id = $user->id;
		$ur_rec->role_id = 1;
		if (!$ur_rec->save()) {
			$msg = 'Could not add User ' . $user->id . ' to default role';
			$ur_rec = null;
			return $ur_rec; 
		}
				
		for ($i = 0; $i < sizeof($role_array); $i++) {
			$ur_rec4 = $this->new_record();
			$ur_rec4->user_id = $user->id;
			if ($role_array[$i] != 1) {
				$ur_rec4->role_id = $role_array[$i];
				$ur_rec4->save();
			}
		}
		
		return $ur_rec;		
	}
	
	function get_user_role_ids($user){
		$role_ids_mapped = $this->where('role_id >', '1', true)->find_all_by('user_id', $user->id);
		$role_id = array();
		$i = 0;
		foreach ( $role_ids_mapped as $value ) {
       		$role_id[$i] = $value->role_id;
       		$i++;
		}
		return $role_id;
	}
	
	function delete_role($role_rec_id) {
		$this->delete($role_rec_id);
	}
	
}