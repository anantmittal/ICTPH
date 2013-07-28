<?php 
class member_policy_detail_model extends IgnitedRecord  
{
	var $belongs_to = "pre_autherization";	
	
	function get_all_policy_detail()
	{
		$this->join_related('pre_autherization', 'policy_id');
		return $this->find_all();
	}
	
}