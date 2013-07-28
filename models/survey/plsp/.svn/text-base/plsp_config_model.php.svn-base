<?php
class plsp_config_model extends IgnitedRecord {
	var $table="plsp_config";

	function get_config_map()
	{
		$dict=array();
		$records = $this->find_all();
		foreach($records as $row)
		{
			$dict[$row->config]=$row->value;
		}
		return $dict;
	}	
}
