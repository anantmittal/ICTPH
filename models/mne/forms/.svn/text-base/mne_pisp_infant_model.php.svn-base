<?php 
class mne_pisp_infant_model extends IgnitedRecord 
{ 
	var $table = "mne_pisp_infant";
	var $subtables = array("mne_acute_illness_infant", "mne_infant_illness_history");
	function get_id_for_org_id($org_id)
	{
		$ret = false;
		if($record = $this->find_by('infant_id',$org_id))
		{
			$ret = $record->id;
		}
		return $ret;
	}
	
	function get_ids_and_payload_for_org_id($org_id)
	{
		$ret = array();
		if($records = $this->find_all_by('infant_id',$org_id))
		{
			foreach($records as $row)
				$ret[$row->id] = array($row->date_visit, 'infant', '17000');
		}
		return $ret;
	}

	function get_summary_from_latest_survey($person_org_id)
	{
		$idfield = "infant_id";
		$datefield = "date_visit";
		if(!$this->find_by($idfield,$person_org_id))
			return null;
		if($record = $this->find_by_sql('select max(id) as id from '.$this->table.' where '.$idfield.'="'.$person_org_id.'" and '.$datefield.'=(select max('.$datefield.') as date from '.$this->table.' where '.$idfield.'="'.$person_org_id.'")' ))
		{
			if($rec = $this->find_by('id',$record->id))
			{
				//compute summary
				$ret = array();
				$ret['date']=$rec->date_visit;
				if(date("Y-m-d") == $ret['date'])
				{
					$ret['weight']=$rec->infant_weight;
					$ret['height']=$rec->infant_height;
					$ret['muac']=$rec->infant_upperarm;
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
