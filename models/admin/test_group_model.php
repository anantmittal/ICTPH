<?php
class test_group_model extends IgnitedRecord {
	function save_test_group($test_group_name,$test_group_desc) {
		$value = $this->new_record();		
		$value->name = $test_group_name;
		$value->description = $test_group_desc;
		$value->save();
		return $value;
	}
}