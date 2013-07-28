<?php
class plsp_adolescent_model extends IgnitedRecord {
	var $table="plsp_adolescent";
	var $fieldId="F004";
	function find_by_id($id)
	{

		return $this->find_by($this->fieldId,$id);
	}
	function get_batch_nums($db)
	{
		$res = $db->query('select distinct batch from plsp_adolescent');
		$batches=array();
		if($res->num_rows()>0)
		{
			foreach($res->result() as $row)
				$batches[]=$row->batch;
		}
		return $batches;
	}

	function find_all_individual_ids()
	{
		return $this->find_all_by_sql('select '.$this->fieldId.' as id from '.$this->table);
	}

	function return_all_ids(&$idmap)
	{
		if($recs = $this->find_all_by_sql('select '.$this->fieldId.' as id from '.$this->table))
		{
			foreach($recs as $row)
			{
				$idmap[trim($row->id)]=true;
			}
		}
	}
}
