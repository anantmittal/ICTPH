<?php
class review_of_system_model extends IgnitedRecord{
	function save_value($childName,$childType,$nodeId,$selectValues) {		
		$value = $this->new_record();		
	    
		$value->value = $childName;
		$value->parent_id = $nodeId;
		$value->type = $childType;
		$value->details=$selectValues;
		$value->save();
		return $value;
	}
	function save_root_value($parentName,$parentType) {		
		$value = $this->new_record();		
	    
		$value->value = $parentName;
		$value->type = $parentType;
		$value->save();
		return $value;
	}
	
	function get_tree(){
		$custom_tree = new CustomTree();
		return $custom_tree->populateTree($this->find_all());
	}
	
}