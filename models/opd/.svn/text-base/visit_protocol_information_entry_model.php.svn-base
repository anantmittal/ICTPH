<?php 
class visit_protocol_information_entry_model extends IgnitedRecord {
  var $belongs_to = array("visit");
  
  function save_visit($list, $visit_id){
  	$tx_status = true;
	$custom_tree = new CustomTree();
	foreach ($list as $key => $protocol_information) { 
    	if (isset($protocol_information["status"]) && $protocol_information["status"] != "NA") {
    		$jsonStructure="{";
    		if($protocol_information["status"] =="Yes")
    	  		$jsonStructure = $custom_tree->create_JSON_structure($protocol_information,$jsonStructure,"name");    	  		
    	  	$jsonStructure .= "}";
    	  	
    	  	$protocol_information_entry = $this->new_record($protocol_information);
    	  	$protocol_information_entry->name = stripcslashes($protocol_information["name"]);
    	  	$protocol_information_entry->details = $jsonStructure;
    	  	$protocol_information_entry->visit_id = $visit_id;
    		if(!$protocol_information_entry->save()) {
  	 			$tx_status = false;
			}
    	}
    }
    return $tx_status;
  }
  
  function show_selected_values($list){
  	$jsonStructure = "";
  	$jsonStruct='';
	$custom_tree = new CustomTree();
	foreach ($list as $key => $protocol_information) { 
    	if (isset($protocol_information["status"]) && $protocol_information["status"] != "NA") {
    		$jsonStructure="{";
    		if($protocol_information["status"] =="Yes"){
    	  		$jsonStructure .= $custom_tree->create_JSON_structure($protocol_information,$jsonStructure,"name");
    		}    	  		
    	  	$jsonStructure .= "}";
    	  	$jsonStruct= $jsonStruct.''. $jsonStructure.'~';
    	}
    	
    }
    return $jsonStruct;
  }
  
  
}