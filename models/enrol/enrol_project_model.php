<?php
class enrol_project_model extends IgnitedRecord {
	var $table="enrol_project";
	var $cols = array("name","location_id","tool","status");
	function enrol_project_model()
	{
		parent::IgnitedRecord();
		$this->CI_handle =& get_instance();		
		$this->CI_handle->load->model('enrol/enrol_project_properties_model', 'props');
	}
	
	function get_options()
	{
		$data = array();
		$data['toolkit_options'] = array('ODK Aggregate'=>'odk', 'Commcare HQ'=>'commcare');
		$data['status_options']= array('Live'=>'live', 'Closed'=>'closed');
		return $data;
	}
		
	function get_all_projects()
	{
		$ret = array();
		if($recs = $this->find_all())
		{
			foreach($recs as $row)
				$ret[$row->id]=$row->name;
		}
		return $ret;
	}
	function get_project_name($id)
	{
		$ret = NULL;
		
		if($id!=NULL && ($rec = $this->find($id)))
			$ret = $rec->name;
		return $ret;
	}
	
	function get_project_tool($id)
	{
		$ret = NULL;
		if($id!=NULL && ($rec = $this->find($id)))
			$ret = $rec->tool;
		return $ret;
	}

	function get_properties($project_id)
	{
		$ret = $this->CI_handle->props->get_properties($project_id);
		$scalars = array('id','name','location_id','tool','status');
		if($row = $this->find($project_id))
		{
			foreach($scalars as $col)
				$ret[$col]=$row->{$col};
		}
		return $ret;
	}
	
	function get_projected_hh($project_id)
	{
		return $this->CI_handle->props->get_projected_hh($project_id);
	}
	
	function get_agents_list($project_id)
	{
		return $this->CI_handle->props->get_agents_list($project_id);
	}
		
	function get_agents_devices($project_id)
	{
		return $this->CI_handle->props->get_agents_devices($project_id);
	}
	
	function get_street_fields($project_id)
	{
		return $this->CI_handle->props->get_street_fields($project_id);
	}

	function store_record($data)
	{	
		
		if(array_key_exists('id',$data))
		{	$rec = $this->find_by('id',$data['id']);
			foreach($this->cols as $col)
			{
				if(array_key_exists($col, $data))
					{
						$rec->{"$col"}=$data[$col];
					}
				$rec->save();
			}
			
		}
		else
		{
			$new = $this->new_record($data);
			$new->save();
		}
		
		$this->store_project_properties($data);	
		
	}
	function store_project_properties($data)
	{
		
		$rec = $this->find_by('name',$data['name']);
		
		$data['enrol_project_id']=$rec->id;
		$this->CI_handle->props->store_record($data);

	}
}
?>
