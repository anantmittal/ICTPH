<?php
class cohort_model extends IgnitedRecord {
	var $habtm = "cohort_constituents";
	var $table = "cohort";
	var $fields = array('id', 'name', 'description');
	function Cohort_model()
	{
		parent::IgnitedRecord();
		$this->CI_handle =& get_instance();		
		$this->CI_handle->load->model('demographic/cohort_constituents_model', 'constituents');
	}
	function update($data)
	{	
		$rec = NULL;
		if(array_key_exists('id', $data))
		{
			if($rec = $this->find_by('id', $data['id']))	
			{
				$rec->name=$data['name'];
				$rec->description=$data['description'];
			}
		}
		if(!$rec)
			$rec = $this->new_record($data);
		
		$rec->save();
		
		if(array_key_exists('persons', $data))		
			$this->CI_handle->constituents->reconcile($rec->id, 'person', $data['persons']);
		else
			$this->CI_handle->constituents->remove_all($rec->id, 'person');
		if(array_key_exists('households', $data))		
			$this->CI_handle->constituents->reconcile($rec->id, 'household', $data['households']);
		else
			$this->CI_handle->constituents->remove_all($rec->id, 'household');
		return $rec->id;
	}

	function get_id_for_name($name)
	{
		$id = FALSE;
		if($rec = $this->find_by('name', $name))
		{
			$id = $rec->id;
		}
		return $id;
	}
	
	function get_cohort_details($id)
	{
		$result=array();
		if($rec = $this->find_by('id', $id))
		{
			foreach($this->fields as $col)
			{	
				$result[$col] = $rec->{"$col"};
			}
		}
		$result['persons'] = $this->CI_handle->constituents->get_constituent_by_type($id,'person');
		$result['households'] = $this->CI_handle->constituents->get_constituent_by_type($id,'household');
		return $result;
	}
	
	function get_individuals_by_orgid($id)
	{		
		$persons = $this->CI_handle->constituents->get_constituent_by_type($id,'person');
		$households = $this->CI_handle->constituents->get_constituent_by_type($id,'household');
		$this->CI_handle->load->model('demographic/household_model', 'household');
		foreach($households as $indi_hh)
		{
			if($hh = $this->CI_handle->get_members_for_valid_policy($indi_hh))
			{
				foreach($hh as $person)
				{
					$persons[] = $person->organization_id;
				}
			}
		}
		return array_unique($persons);
	}
	
	function get_individuals_by_id($id)
	{		
		$this->CI_handle->load->model('demographic/person_model', 'person');
		$persons = $this->CI_handle->constituents->get_constituent_by_type($id,'person');
		$persons = $this->CI_handle->person->convert_org_id_to_id($persons);
		$households = $this->CI_handle->constituents->get_constituent_by_type($id,'household');
		$this->CI_handle->load->model('demographic/household_model', 'household');
		foreach($households as $indi_hh)
		{
			if($hh = $this->CI_handle->household->get_members_for_valid_policy($indi_hh))
			{
				foreach($hh as $person)
				{
					$persons[] = $person->id;
				}
			}
		}
		return array_unique($persons);
	}

	function get_all_cohorts()
	{
		$ret = array();
		if($recs = $this->find_all())
		{
			foreach($recs as $row)
				$ret[$row->id]=$row->name;
		}
		return $ret;
	}
	function get_all_households_by_id($id)
	{
		$this->CI_handle->load->model('demographic/person_model', 'person');
		$persons = $this->get_individuals_by_id($id);
		return $this->CI_handle->person->get_all_hh_for_ids($persons);
	}
}
