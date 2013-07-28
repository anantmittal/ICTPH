<?php
class opd_diagnosis_model extends IgnitedRecord {
	
	var $table = "opd_diagnosis";
	function check_duplicate($value, $system_name) 
	{
		return $opd_diagnosis_rec = $this->find_by_sql("SELECT * from opd_diagnosis where system_name=\"$system_name\" and value=\"$value\"");
		
	}

	function save_value($addedValue1, $systemName) 
	{
		$value = $this->new_record();
		$value->value = strtolower($addedValue1);
		$value->system_name = $systemName;
		return $value->save();
	}
	
	function save_system($systemName) 
	{
		$value = $this->new_record();
		$value->system_name = $systemName;
		return $value->save();
	}
	
	function get_list_diagnosis()
	{
		$records=$this->find_all();
		$list_diagnosis = array();
		foreach($records as $r)
		{
			$list_diagnosis[] = $r->value;
		}			
		return $list_diagnosis;
	}
	function get_list_eye_diagnosis()
	{
		$records=$this->where('system_name','eye')->find_all();
		$list_eye_diagnosis = array();
		foreach($records as $r)
		{
			$list_eye_diagnosis{$r->value} = 0;
			
		}	
		
		return $list_eye_diagnosis;
		
	}
	
	//This method returns all the system names there can be of any diagnosis
	function get_list_system_name()
	{
		$records=$this->group_by('system_name')->find_all();
		$list_system_name = array();
		foreach($records as $r)
		{
			$list_system_name{$r->system_name} = 0;
			
		}
		return $list_system_name;
	}
}
