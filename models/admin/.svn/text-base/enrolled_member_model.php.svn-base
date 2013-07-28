<?php
class enrolled_member_model extends IgnitedRecord {
	
	function get_members_by_policy_id($policy_id) {
		$result =&  $this->select(array('id','full_name', 'gender','age', 'date_of_birth','image_name'))
					 ->from('persons')
					 ->where('enrolled_members.person_id','persons.id',false)
					 ->find_all_by('policy_id', $policy_id);
		return $result;			 
	}

	function family_size($policy_id) {
		$size = $this->where('policy_id', $policy_id)->count();
		return $size;
	}

	function is_name($key) {
		$recs = $this->from('persons')
				 ->where('enrolled_members.person_id','persons.id',false)
				 ->like('persons.full_name',$key,'both')
				 ->count();
		if($recs > 0)
		{return true;}
		else
		{return false;}
	}				
}
