<?php
class stock_maintenance_model extends IgnitedRecord {
	function save_maintenance($maintenance_name,$maintenance_desc) {
		$value = $this->new_record();		
		$value->name = $maintenance_name;
		$value->description = $maintenance_desc;
		$value->save();
		return $value;
	}
	
	function block_maintenance($maintenance_id) {		
		$maintenance = $this->find_by('id', $maintenance_id);
		$maintenance->status = 0;
		$maintenance->save();	
	}
	
	function unblock_maintenance($maintenance_id) {		
		$maintenance = $this->find_by('id', $maintenance_id);
		$maintenance->status = 1;
		$maintenance->save();
	}	
}
