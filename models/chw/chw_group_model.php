<?php
class chw_group_model extends IgnitedRecord {

	function get_name($id)
	{
		$chwg= $this->find($id);
		if($chwg)
		{ return $chwg->name;}
		else return false;
	}

	function is_name($text) {
	  $groups= $this->like('name',$text,'both')->find_all();

	  if($groups)
	  	return $groups;
	  else return false;	
	}
}
