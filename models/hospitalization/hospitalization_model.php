<?php 
class hospitalization_model extends IgnitedRecord  
{
	var $belongs_to = "hospital";
	var $has_many = 'pre_authorizations';
		
	function get_all_hospitalization($policy_id)
	{
		$this->join_related('hospital', 'name');
		return $this->find_all_by('policy_id',$policy_id);
	}
}
