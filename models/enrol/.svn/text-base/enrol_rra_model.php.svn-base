<?php
class enrol_rra_model extends IgnitedRecord {
	var $table="enrol_rra";
	var $cols=array("enrol_project_id", "person_id","agent","marital_status","pregnant","height","weight","wc","hc","bp_systole","bp_diastole","tobacco","personal_history", "cvd_voucher", "vision_voucher","wh_reproductive", "time", "status", "uid","lock");
	
	function enrol_rra_model()
	{
		parent::IgnitedRecord();
		$this ->CI_handle =& get_instance();
		$this->CI_handle->load->model('enrol/enrol_project_model', 'project');
	}
	
	function store_records($arr)
	{
		foreach($arr as $rec)
		{	
			$rec['lock']=0;
			if($row = $this->find_by(array('person_id','uid'), array($rec['person_id'],$rec['uid'])))
			{
				if($row->lock=0)
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
			}
			else
			{
				$new = $this->new_record($rec);
				$new->save();
			}
		}
	}

	function get_record($id)
	{
		$ret = array('id'=>array('label',$id));
		if($rec=$this->find($id))
		{
			foreach($this->cols as $col)
			{
				$set = array('','','');
				if($col == 'lock')
				{
					$set[0]='dropdown';
					$set[2]=array('unlocked', 'locked', 'invalid');
				}
				else
					$set[0]='string';
				$set[1]=$rec->{$col};
				
				if($col == 'person_id')
				{	
					if($col['person_id'] != 0)
					{	$set[0]='link';
						$set[1]= base_url()."index.php/enrol/enrol/edit_household/".$rec->{$col};
						$col = "Household";
					}
					
				}
				$ret[$col]=$set;
			}
		}
		return $ret;
	}

	function set_record($id, $data)
	{
		if($rec=$this->find($id))
		{
			foreach($data as $col=>$val)
			{
				$rec->{$col}=$val;
			}
			$rec->save();
		}
		else
			return false;
		return true;
	}

	function __count_helper($project_id, $fieldname, $appendstr='')
	{
		$ret = array();
		if($rec = $this->find_all_by('enrol_project_id',$project_id))
		{	
			
				foreach($rec as $row)
				{	if($row->lock!=2)
					{
						if(array_key_exists($row->{"$fieldname"}.$appendstr, $ret))
							$ret[$row->{"$fieldname"}.$appendstr]=$ret[$row->{"$fieldname"}.$appendstr]+1;
						else
							$ret[$row->{"$fieldname"}.$appendstr]=1;
					}
					
				}
			
			
		}
		return $ret;
	}	

	function get_agent_wise_counts($project_id)
	{
		$ret = $this->__count_helper($project_id,'agent',' ');
		ksort($ret);
		return $ret;
		
	}

	function get_agent_date_table($project_id, $collist)
	{
		$ret = array();
		if($recs = $this->find_all_by('enrol_project_id',$project_id))
		{	
			
				foreach($recs as $row)
				{	if($row->lock != 2)
					{
						$dateval = date("Y-m-d", $row->time);
						if(array_key_exists($dateval,$ret))
						{
							if(array_key_exists($row->agent." ", $ret[$dateval]))
								$ret[$dateval][$row->agent." "]=$ret[$dateval][$row->agent." "]+1;
							else
								$ret[$dateval][$row->agent." "]=1;
						}
						else
							$ret[$dateval][$row->agent." "]=1;
					}
					
				}






			
			
		}
		ksort($ret);
		return $ret;
	}

	function get_agent_by_date_counts($project_id,$agent=0)
	{
		$ret = array();
		if($rec=($agent<1 || $agent>14)?($this->find_all_by('enrol_project_id',$project_id)):($this->find_all_by(array('agent','enrol_project_id'),array($agent,$project_id))))
		{
			foreach($rec as $row)
			{	if($row->lock !=2)
				{
					$d= date("Y-m-d", $row->time);
					if(array_key_exists($d, $ret))
						$ret[$d]=$ret[$d]+1;
					else
						$ret[$d]=1;
				}
				
			}
		}
		ksort($ret);
		return $ret;
		
	}

	function get_time_of_day_counts($project_id, $agent=0)
	{
		$ret = array();
		for($i=0;$i<=24; $i++)
			$ret[$i.' ']=0;
		
		if($rec=($agent<1 || $agent>14)?($this->find_all_by('enrol_project_id',$project_id)):($this->find_all_by(array('agent','enrol_project_id'),array($agent,$project_id))))
		{
			foreach($rec as $row)
			{
				
				$d= date("H", $row->time);
				$ret[(int)$d.' ']=$ret[(int)$d. ' ']+1;
			}
		}
		return $ret;
		
	}

	function get_rra_without_indi($project_id)
	{	
		
		$mismatch = array();
		if($records = $this->find_all_by_sql('select * from '.$this->table.' where (enrol_project_id='.$project_id.' and person_id = 0) order by time'))
		{	
			$agentslist = $this->CI_handle->project->get_agents_list($project_id);
			$agentslist = array_flip($agentslist);
			foreach($records as $row)
			{	
				
				$mismatch[] = array($row->id,$agentslist{$row->agent},$row->cvd_voucher ,$row->vision_voucher,date('Y-m-d',$row->time));
			}
		}
		return $mismatch;
	}
}
?>
