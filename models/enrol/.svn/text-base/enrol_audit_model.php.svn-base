<?php
class enrol_audit_model extends IgnitedRecord {
	var $table="enrol_audit";
	
	function get_status($formid)
	{
		$ret = array('status'=>'not_found', 'supervisor'=>0,'date'=>"");
		
		if($rec = $this->find_by_sql('select * from enrol_audit where enrol_household_id='.(int)$formid))
		{
			foreach($ret as $k=>$v)
				$ret[$k]=$rec->{"$k"};
		}
		return $ret;
	}

	function mark_status($list, $status,$project_id)
	{
		foreach($list as $id)
		{
			if($rec=$this->find_by('enrol_household_id',$id))
			{	
				$rec->status=$status;	
				$rec->date=date("%Y-%m-%d");
				$rec->save();
			}
			else
			{
				$row = array('status'=>$status,'enrol_household_id'=>$id, 'date'=>date("%Y-%m-%d"),'enrol_project_id'=>$project_id);
				$newrec = $this->new_record($row);
				$newrec->save();
			}
		}
		
	}
	function get_hh_for_state($status,$project_id)
	{
		$ret = array();
		if($rec=$this->find_all_by(array('status','enrol_project_id'),array($status,$project_id)))
		{
			foreach($rec as $row)
			{
				$ret[]=$row->enrol_household_id;
			}
		}
		return $ret;
	}
}
?>
