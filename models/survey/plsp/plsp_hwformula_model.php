<?php
class Plsp_hwformula_model extends IgnitedRecord {
	var $table="plsp_hwformula";

	function get_all_values($age_group, $sex, $metric)
	{
		return $this->find_all_by_sql('select * from '.$this->table.' where age_range="'.$age_group.'" and sex="'.$sex.'" and metric="'.$metric.'"');
	}

}
