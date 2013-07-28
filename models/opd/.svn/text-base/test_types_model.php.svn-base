<?php
class test_types_model extends IgnitedRecord {
	function disable_tests($test_obj) {		
		$test_group = $this->find_by('id', $test_obj->test_id);
		$test_group->is_added_to_group = 1;
		$test_group->save();
	}

	function enable_tests($values) {		
		$test_group = $this->find_by('id', $values->test_id);
		$test_group->is_added_to_group = 0;
		$test_group->save();
	}
}
