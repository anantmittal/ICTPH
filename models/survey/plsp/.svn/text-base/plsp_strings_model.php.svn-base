<?php
class plsp_strings_model extends IgnitedRecord {
	var $table="plsp_strings";
	
	function get_dict($language = "english")
	{
		$dict=array();
		$records = $this->find_all();
		foreach($records as $row)
		{
			$dict[$row->handle]=$row->{"$language"};
		}
		return $dict;
	}

}
