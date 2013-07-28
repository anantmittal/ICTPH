<?php 
class mne_pisp_child_model extends IgnitedRecord 
{ 
	var $table = "mne_pisp_child";
	var $subtables = array("mne_pisp_acute_condition", "mne_pisp_personal_illness","mne_childhood_illness");
	function get_id_for_org_id($org_id)
	{
		$ret = false;
		if($record = $this->find_by('child_id',$org_id))
		{
			$ret = $record->id;
		}
		return $ret;
	}
	
	function get_ids_and_payload_for_org_id($org_id)
	{
		$ret = array();
		if($records = $this->find_all_by('child_id',$org_id))
		{
			foreach($records as $row)
				$ret[$row->id] = array($row->date_interview,'child','14000');
		}
		return $ret;
	}

	function get_summary_from_latest_survey($person_org_id)
	{
		$idfield = "child_id";
		$datefield = "date_interview";
		if(!$this->find_by($idfield,$person_org_id))
			return null;
		if($record = $this->find_by_sql('select max(id) as id from '.$this->table.' where '.$idfield.'="'.$person_org_id.'" and '.$datefield.'=(select max('.$datefield.') as date from '.$this->table.' where '.$idfield.'="'.$person_org_id.'")' ))
		{
			if($rec = $this->find_by('id',$record->id))
			{
				//compute summary
				$ret = array();
				$ret['date']=$rec->{"$datefield"};
				$elapseddays = (strtotime(date("Y-m-d"))-strtotime($ret['date']))/86400;
				if($elapseddays == 0) //If PISP was done today
				{
					$ret['weight']=$rec->weight;
					$ret['height']=$rec->height;
				}
				if($elapseddays < 180) // If PISP was done less than 6 months ago, then include visual parameters
				{
					$ret['va_distance_r']=$rec->va_distance_r;
					$ret['va_distance_l']=$rec->va_distance_l;
					$ret['va_near']=$rec->va_near;
				}		
				return $ret;
			}
		}
		return null;
	}
	function delete_response($id,$db)
	{
		$db->trans_begin();
		$status = true;
		if($main_rec = $this->find($id))
		{
			foreach($this->subtables as $sub)
			{
				$status = $status AND $db->query('delete from '.$sub.' where data_point_id='.$main_rec->id);
			}
			$status = $status AND $main_rec->delete();
		}
		
		if($status)
			$db->trans_commit();
		else
			$db->trans_rollback();
		return $status;
	}
}
