<?php
class test_group_tests_model extends IgnitedRecord {
function save_tests_to_test_groups($values,$saved_value) {
		$test_obj = $this->new_record();
		$test_obj->test_group_id=$saved_value->id;
		$test_obj->test_id=$values['test_id'];
		$test_obj->save();
		return $test_obj;
	}
}