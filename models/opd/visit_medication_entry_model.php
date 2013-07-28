<?php
class visit_medication_entry_model extends IgnitedRecord {
  var $belongs_to = array("visit", "product");
  var $has_one = array("visit_cost_item_entry");
  
  function save_visit($list,$visit_id){
  	$m_array = array();
  	$tx_status = true;
    foreach ($_POST["medication"] as $medication) {
      	$m_entry = $this->new_record($medication);
      	$m_entry->visit_id = $visit_id;
      	if(!$m_entry->save()){
	      	$home_message = 'Unable to save medicine_entry';
	      	$this->session->set_userdata('msg', $home_message);
	  	 	$tx_status = false;
		}
      $m_array[$medication["index"]] = $m_entry;
    }
    if(!$tx_status)
    	return null;
    return $m_array;
  }
}
