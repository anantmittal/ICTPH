<?php
class hospital_model extends  IgnitedRecord
{
	var $belongs_to = "district";
	function find_all_complete()
	{
		$this->join_related('district', 'name');
		return  $this->find_all();
	}
	
	function get_all_cashless() {
	  $cashless_hosps =	$this->select('name')->where('type','cashless')->find_all();
	  
	  if($cashless_hosps)
	  	return $cashless_hosps;
	  else return false;	
	}

	function is_name($text) {
	  $hosps = $this->like('name',$text,'both')->find_all();

	  if($hosps)
	  	return $hosps;
	  else return false;	
	}
}
