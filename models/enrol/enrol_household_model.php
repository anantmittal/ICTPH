<?php
class enrol_household_model extends IgnitedRecord {
	var $table="enrol_household";
	var $cols = array('cardnum', 'agent', 'date','end','doornum', 'street', 'village', 'phone','members_num', 'locationAccuracy', 'locationAltitude','latitude', 'longitude', 'lock', 'key');

	function enrol_household_model()
	{	
		parent::IgnitedRecord();
		//echo "here"; return;   
		$this->CI_handle =& get_instance();		
		$this->CI_handle->load->model('enrol/enrol_person_model', 'person');
		$this->CI_handle->load->model('enrol/enrol_project_model', 'project');
		
	}

	function store_records($project_id, $arr)
	{
		$err = array();
		foreach($arr as $rec)
		{	
			$rec['lock']=0;
			$rec['enrol_project_id']=$project_id;
			if($rec['cardnum']!=0)
			{
				if($row = $this->find_by(array('cardnum','enrol_project_id'), array($rec['cardnum'],$project_id)))
				{
					if($row->key == $rec['key']) //It's the same record being submitted twice
					{
						if($row->lock!=1)
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
					else // There's a chance that the card has been used twice
					{
						if($row->doornum != $rec['doornum'])
							$err[$row->cardnum]="Potential duplicate";	
					}
				}
				else
				{
					$new = $this->new_record($rec);
					$new->save();
				}
			}
		}
		return $err;
	}

	function update_keys($arr)
	{
		foreach($arr as $rec)
		{	
			if($rec['cardnum']!=0)
			{
				if($row = $this->find_by(array('cardnum','enrol_project_id'), array($rec['cardnum'],$rec['project_id'])))
				{
					$row->key=$rec['key'];
					$row->save();
					$rec['enrol_household_id']=$row->id;
					if($indis = $this->CI_handle->person->find_all_by('enrol_household_id', $row->id))
					{
						foreach($indis as $indi)
							$indi->delete();
					}
					//Now create the respondent record for this household
					$this->CI_handle->person->store_records(array($rec));
				}
				
			}
		}
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
	function get_record($id)
	{
		$ret = array('id'=>array('label',$id));
		$ret['individuals']=array('link',base_url()."index.php/enrol/enrol/edit_individuals/".$id);
		if($rec=$this->find($id))
		{
			foreach($this->cols as $col)
			{
				$set = array();
				if($col == 'lock')
					$set[]='bool';
				else if($col == 'date' || $col == 'end')
					$set[] = 'time';
				else
					$set[]='string';
				
				$set[]=$rec->{$col};
				$ret[$col]=$set;
			}
		}
		return $ret;
	}
	function delete_record($id)
	{
		
		$rec = $this->find_by('id',$id);
		$rec->delete();
		if($indis = $this->CI_handle->person->find_all_by('enrol_household_id', $id))
			{
				foreach($indis as $indi)
					$indi->delete();
			}
		return true;
		
	}
	function __count_helper($project_id, $fieldname, $appendstr='')
	{
		$ret = array();
		if($rec = $this->find_all_by('enrol_project_id',$project_id))
		{
			foreach($rec as $row)
			{
				if(array_key_exists($row->{"$fieldname"}.$appendstr, $ret))
					$ret[$row->{"$fieldname"}.$appendstr]=$ret[$row->{"$fieldname"}.$appendstr]+1;
				else
					$ret[$row->{"$fieldname"}.$appendstr]=1;
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
	
	function get_agent_by_date_counts($project_id,$agent=0)
	{
		$ret = array();
		if($rec=($agent<1 || $agent>14)?($this->find_all_by('enrol_project_id',$project_id)):($this->find_all_by(array('agent','enrol_project_id'),array($agent,$project_id))))
		{
			foreach($rec as $row)
			{
				$d= date("Y-m-d", $row->date);
				if(array_key_exists($d, $ret))
					$ret[$d]=$ret[$d]+1;
				else
					$ret[$d]=1;
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
				
				$d= date("H", $row->date);
				$ret[(int)$d.' ']=$ret[(int)$d.' ']+1;
			}
		}
		return $ret;
		
	}
	function get_time_taken_for_completion_counts($project_id, $agent =0)
	{
		$ret = array();
				// will try to create histograms with 10 second intervals
		for($i=0;$i<=20; $i++)
		{
				
			$ret[$i.' ']=0;
		}
		if($rec=($agent<1 || $agent>14)?($this->find_all_by('enrol_project_id',$project_id)):($this->find_all_by(array('agent','enrol_project_id'),array($agent,$project_id))))
		{
			foreach($rec as $row)
			{
				$start = $row->date;
				$end = $row->end;
				$time = $end-$start;
				$time = $time/60;				
				$t = round($time);
				if(isset($ret[(int)$t.' ']))
					$ret[(int)$t.' ']=$ret[(int)$t. ' ']+1;
			}
		}
		return $ret;
	}

	function get_count_by_village($project_id)
	{
		return $this->__count_helper($project_id, 'village');
	}

	function get_worm($project_id, $starttime, $endtime)
	{
		$ret=array();
		$date =strtotime($starttime);
		$enddate = strtotime($endtime);
		while($date <= $enddate)
		{
			if($rec = $this->find_by_sql('select count(*) as count from '.$this->table.' where date<='.($date+24*60*60).' and enrol_project_id='.$project_id))
				$ret[date("Y-m-d", $date)]=$rec->count;
			$date = $date+24*60*60;
		}
		return $ret;
	}
	
	function get_agent_date_table($project_id, $collist)
	{
		$ret = array();
		if($recs = $this->find_all_by('enrol_project_id',$project_id))
		{
			foreach($recs as $row)
			{
				$dateval = date("Y-m-d", $row->date);
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
		ksort($ret);
		return $ret;
	}

	function __return_arr_for_recs($rec_list)
	{
		$cols = array('id','cardnum','doornum','street','village','phone','members_num');
		$this->CI_handle =& get_instance();		
		$this->CI_handle->load->model('enrol/enrol_audit_model', 'audits');
		$data = array();
		foreach($rec_list as $row)
		{	unset($respondent);
			$newrec=array();
			foreach($cols as $field)
				$newrec[$field] = $row->{"$field"};
			$newrec['audit_state'] = $this->CI_handle->audits->get_status($row->id);
			$newrec['actual_individual_count'] = $this->CI_handle->person->get_individual_count($row->id);
			@$respondent = $this->CI_handle->person->get_self_records($row->id);
			$newrec['respondent'] = $respondent['name'];
			$data[]=$newrec;
		}
		return $data;
	}
	function get_data_for_date_agent($project_id, $date, $agent)
	{
		
		$recs = $this->find_all_by_sql('select * from '.$this->table.' where FROM_UNIXTIME(date,"%d-%m-%Y")="'.$date.'" and agent='.$agent.' and enrol_project_id='.$project_id);
		
		return $this->__return_arr_for_recs($recs);
	}
	function get_summary_for_ids($idlist)	
	{
		$recs = array();
		foreach($idlist as $id)
		{
			if($rec = $this->find($id))
				$recs[]=$rec;
		}
		return $this->__return_arr_for_recs($recs);
	}
	
	function export($project_id)
	{
		$ret = array();
		$cols_to_export = array('id','cardnum','doornum','street','village','phone','latitude','longitude','locationAltitude');
		if($records = $this->find_all_by('enrol_project_id',$project_id))
		{
			$rec_arr=array();
			foreach($records as $row)	
			{
				foreach($cols_to_export as $col)
					$rec_arr[$col]=$row->{$col};
				$ret[]=$rec_arr;
			}
			
		}
		return array($cols_to_export,$ret);
	}
	
	function get_indi_mismatch_count($project_id)
	{	
		
		$mismatch = array();
		if($records = $this->find_all_by_sql('select * from '.$this->table.' where enrol_project_id='.$project_id.' order by date'))
		{	
			$agentslist = $this->CI_handle->project->get_agents_list($project_id);
			$agentslist = array_flip($agentslist);
			foreach($records as $row)
			{	
				
				$actual_count = $this->CI_handle->person->get_individual_count($row->id);
				if($actual_count != $row->members_num)
					$mismatch[] = array($row->id,$row->cardnum ,$row->members_num, $actual_count, date('Y-m-d',$row->date),$agentslist{$row->agent});
			}
		}
		return $mismatch;
	}
	function find_all_hhids($project_id)
	{
		$recs=$this->find_all_by('enrol_project_id',$project_id);
		return $recs;

	}
	

}
?>
