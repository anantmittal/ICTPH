<?php
class cohort_constituents_model extends IgnitedRecord {
	var $table = "cohort_constituents";
	function reconcile($id, $type, $arr)
	{
		$lookup=array();
		foreach($arr as $val)
			$lookup[$val]=1;
		if($recs = $this->find_all_by(array('cohort_id','entity_type'), array($id, $type)))
		{
			foreach($recs as $row)
			{
				if(array_key_exists($row->entity_id, $lookup))
				{
					unset($lookup[$row->entity_id]);
				}
				else
				{
					$row->delete();
				}
			}
		}
		foreach($lookup as $key=>$val)
		{
			if($val==1)
			{
				$rec = $this->new_record(array('cohort_id'=>$id,'entity_type'=>$type, 'entity_id'=>$key));
				$rec->save();
			}
		}
	}
	function remove_all($id, $type)
	{
		if($recs = $this->find_all_by(array('cohort_id','entity_type'), array($id, $type)))
		{
			foreach($recs as $row)
				$row->delete();
		}
	}
	
	function get_constituent_by_type($id, $type)
	{
		$result = array();
		if($recs = $this->find_all_by(array('cohort_id','entity_type'), array($id, $type)))
		{
			foreach($recs as $row)
			{
				$result[]=$row->entity_id;
			}
		}
		return $result;
	}
}
