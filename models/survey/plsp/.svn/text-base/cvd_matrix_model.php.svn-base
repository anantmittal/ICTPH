<?php
class cvd_matrix_model extends IgnitedRecord {
	var $table="cvd_matrix";

	function get_all_values()
	{
		$ret = array();
		if($records = $this->find_all())
		{
			foreach($records as $row)	
			{
				if(!array_key_exists($row->fh,$ret))
					$ret[$row->fh]=array();
				if(!array_key_exists($row->age,$ret[$row->fh]))
					$ret[$row->fh][$row->age]=array();
				if(!array_key_exists($row->sh,$ret[$row->fh][$row->age]))
					$ret[$row->fh][$row->age][$row->sh]=array();
				if(!array_key_exists($row->bmi,$ret[$row->fh][$row->age][$row->sh]))
					$ret[$row->fh][$row->age][$row->sh][$row->bmi]=array();
				if(!array_key_exists($row->bp,$ret[$row->fh][$row->age][$row->sh][$row->bmi]))
					$ret[$row->fh][$row->age][$row->sh][$row->bmi][$row->bp]=$row->bucket;
			}
		}
		return $ret;
	}

	function get_all_labels()
	{
		$q = new IgnitedQuery();
		$ret= array();
		$collist = array("age", "fh", "sh", "bmi", "bp");
		foreach($collist as $col)
		{
			$vals = array();
			if($rows =$q->distinct()->select($col)->from($this->table)->get())
			{
				foreach($rows->result() as $rec)
					$vals[] = $rec->{$col};
			}
			$ret[$col] = $vals;
		}
		return $ret;
	}

}
