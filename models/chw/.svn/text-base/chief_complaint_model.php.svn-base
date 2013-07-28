<?php
class chief_complaint_model extends IgnitedRecord {
	function check_duplicate($value) {
		return $chief_complaint_rec = $this->find_by_sql("SELECT * from chief_complaints where value=\"$value\"");
		
	}

	function save_value($addedValue1) {
		$value = $this->new_record();
		$value->value = strtolower($addedValue1);
		
		return $value->save();
	}
}