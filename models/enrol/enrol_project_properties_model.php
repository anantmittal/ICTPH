<?php
class enrol_project_properties_model extends IgnitedRecord {
	var $table="enrol_project_properties";
	var $cols = array("enrol_project_id","start_date","target_end_date","actual_end_date","target_enrolments","agents","villages");
	
	function store_record($data)
	{
		
		//Need to convert agents and villages
		$agentstr = "";
		foreach($data['tables']['agents'] as $agent)
		{
			if($agentstr != "")
				$agentstr.=",";
			$agentstr.=$agent[0].":".$agent[1].":".$agent[2];
		}
		$data['agents']=$agentstr;

		$villagestr = "";
		foreach($data['tables']['villages'] as $village)
		{
			if($villagestr != "")
				$villagestr.=",";
			$villagestr.=$village[0].":".$village[1].":".$village[2];
		}
		$data['villages']=$villagestr;
		if($rec = $this->find_by('enrol_project_id',$data['enrol_project_id']))
		{	
			foreach($this->cols as $col)
			{	
				if(array_key_exists($col, $data))
				{
					$rec->{"$col"}=$data{$col};
				}
				
			}
			$rec->save();			
		}
		else
		{
			$new = $this->new_record($data);
			$new->save();
		}
		
	}
		
	function update_record($id,$arr)
	{
		foreach($arr as $rec)
		{	
			
			if($row = $this->find_by(array('enrol_project_id'), array($id)))
			{
				
				
				foreach($this->cols as $col)
				{
					if(array_key_exists($col, $rec))
					{
						$row->{"$col"}=$rec[$col];
					}
				}
					
				$row->save();
				
			}
			else
			{
				$new = $this->new_record($rec);
				$new->save();
			}
		}
	}
	function __array_from_serialized_str($str)
	{
		$ret = array();
		$outerarr = explode(',', $str);
		foreach($outerarr as $village)
		{
			$ret[]= explode(':',$village);
		}
		return $ret;
	}

	function __serialized_str_to_map($project_id, $field, $key_index, $value_index)
	{
		$ret = array();	
		if($row = $this->find_by('enrol_project_id', $project_id))
		{
			$temp_arr = $this->__array_from_serialized_str($row->{$field});
			foreach($temp_arr as $snippets)
				$ret[$snippets[$key_index]]=$snippets[$value_index];
		}
		return $ret;
	}
	function get_projected_hh($project_id)
	{
		return $this->__serialized_str_to_map($project_id, 'villages', 0, 1);
	}
	function get_agents_list($project_id)
	{
		return $this->__serialized_str_to_map($project_id, 'agents', 0, 1);
	}
	
	function get_agents_devices($project_id)
	{
		return $this->__serialized_str_to_map($project_id, 'agents', 2, 1);
	}

	function get_street_fields($project_id)
	{
		$ret = array();	
		if($row = $this->find_by('enrol_project_id', $project_id))
		{
			$temp_arr = $this->__array_from_serialized_str($row->villages);
			foreach($temp_arr as $village_details)
				$ret[]=$village_details[2];
		}
		return $ret;
	}
	
	function get_properties($project_id)
	{
		$scalars = array('start_date','target_end_date','actual_end_date','target_enrolments');
		$ret = array();	
		if($row = $this->find_by('enrol_project_id', $project_id))
		{
			$ret['villages'] = $this->__array_from_serialized_str($row->villages);
			$ret['agents'] = $this->__array_from_serialized_str($row->agents);
			foreach($scalars as $col)
				$ret[$col]=$row->{$col};
		}
		return $ret;
	}
}
?>
