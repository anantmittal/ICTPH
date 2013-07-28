<?php
class visit_service_entry_model extends IgnitedRecord {
  var $belongs_to = array("visit", "product");
  var $has_one = array("visit_cost_item_entry");
  
  function save_visit($list,$visit_id){
  	$service_array = array();
  	$tx_status = true;
    foreach ($list as $service) {
      	$new_service_entry = $this->new_record($service);
      	$new_service_entry->visit_id = $visit_id;
      	if(!$new_service_entry->save()){
	      	$home_message = 'Unable to save opd prod entry';
	      	$this->session->set_userdata('msg', $home_message);
	  	 	$tx_status = false;
		}
      $service_array[$service["index"]] = $new_service_entry;
    }
    if(!$tx_status)
    	return null;
    return $service_array;
  }
}