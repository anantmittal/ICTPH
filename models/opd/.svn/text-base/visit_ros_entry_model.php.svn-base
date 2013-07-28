<?php
class visit_ros_entry_model extends IgnitedRecord {
  var $belongs_to = array("visit");
  
  function save_visit($list, $visit_id){
		$tx_status = true;
		$custom_tree = new CustomTree();
		foreach ($list as $key => $ros) {
	    	if (isset($ros["status"]) && $ros["status"] != "NA") {
	    		$jsonStructure="{";
	    		if($ros["status"] =="Yes")
	    	  		$jsonStructure = $custom_tree->create_JSON_structure($ros,$jsonStructure,"name");    	  		
	    	  	$jsonStructure .= "}";
	    	  	$ros_entry = $this->new_record($ros);
	    	  	$ros_entry->details = $jsonStructure;
	    	  	$ros_entry->visit_id = $visit_id;
	    		if(!$ros_entry->save()) {
	  	 			$tx_status = false;
				}
	    	}
    	}
    	return $tx_status;
	}
}