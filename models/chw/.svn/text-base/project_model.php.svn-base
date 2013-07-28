<?php
class project_model extends IgnitedRecord {

	function get_name($id)
	{
		$proj = $this->find($id);
		if($proj)
		{ return $proj->name;}
		else return false;
	}

	function is_name($text) {
	  $projects = $this->like('name',$text,'both')->find_all();

	  if($projects)
	  	return $projects;
	  else return false;	
	}
}
