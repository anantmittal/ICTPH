<?php
class visit_physical_exam_entry_model extends IgnitedRecord {
  var $belongs_to = array("visit");
  
  function save_visit($list, $visit_id){
  	$tx_status = true;
	$custom_tree = new CustomTree();
  	foreach ($list as $physical_exam) {
    	if (isset($physical_exam["status"]) && $physical_exam["status"] != "NA") {
    		$jsonStructure="{";
    		if($physical_exam["status"] =="Abnormal")
    			$jsonStructure = $custom_tree->create_JSON_structure($physical_exam,$jsonStructure,"test");    		
    		$jsonStructure .= "}";
    		$pe_entry = $this->new_record($physical_exam);
    		$pe_entry->details = $jsonStructure;
    		$pe_entry->visit_id = $visit_id;
    		if(!$pe_entry->save()) {
	  	 		$tx_status = false;
			}
    	}
    }
    return $tx_status;
  }
}