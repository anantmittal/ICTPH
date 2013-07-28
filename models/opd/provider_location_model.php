<?php
class provider_location_model extends IgnitedRecord 
{
  	var $habtm = array(array("table" => "providers", "join_table" => "provider_location_affiliations"));
	function is_name($text) 
	{
	  $ps = $this->like('name',$text,'both')->find_all();
	  if($ps)
	  	return $ps;
	  else 
	  	return false;	
	}

	function get_all_clinic_suffixes()
	{
		$ret = array();
		if($recs = $this->find_all_by('type', 'Clinic'))
		{
			foreach($recs as $row)
			{
				$ret[$row->name] = $row->cachment_code;
			}
		}
		return $ret;
	}

	function get_all_clinic_ids()
	{
		$ret = array();
		if($recs = $this->find_all_by('type', 'Clinic'))
		{
			foreach($recs as $row)
			{
				$ret[$row->name] = $row->id;
			}
		}
		return $ret;
	}
	
	function get_id_by_name($location)
	{
	
		$record = $this->like('name',$location)->find();		
		$id = $record->id;
		return $id;

	}
	function get_all_names() //This method returns an associative array, in which the keys are the location ids and values are the corresponding RMHC names. 
	{
		$ret = array();
		if($recs = $this->find_all_by('type', 'Clinic'))
		{
			foreach($recs as $row)
			{
				$ret[$row->id] = $row->name;
			}
		}
		
		return $ret;
	}
		
}







