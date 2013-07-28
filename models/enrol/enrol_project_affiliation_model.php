<?php
class enrol_project_affiliation_model extends IgnitedRecord {
	var $table="enrol_project_affiliation";
	
	function get_current_project($username)
	{
		$proj_id = NULL;
		if($row = $this->find_by('user', $username))
		{
			$proj_id = $row->current_project;
		}
		return $proj_id;		
	}
	function set_current_project($username, $project_id)
	{
		if($row = $this->find_by('user',$username))
		{
			$row->current_project=$project_id;
			$row->save();
		}
		else
		{
			$new = $this->new_record(array('user'=>$username,'current_project'=>$project_id));
			$new->save();
		}
	}
}
?>
