<?php
class visit_diagnosis_entry_model extends IgnitedRecord {
  var $belongs_to = array("visit");
  
  function save_visit($list, $visit_id){
  	$tx_status = true;
  	 foreach ($list as $diagnosis) {
	  	if(trim($diagnosis) == "") continue;
      	$diagnosis_entry = $this->new_record();
      	$diagnosis_entry->diagnosis = trim($diagnosis);
      	$diagnosis_entry->visit_id = $visit_id;
      	if(!$diagnosis_entry->save()) {
	      $home_message = 'Unable to save diagnosis_entry';
	      $this->session->set_userdata('msg', $home_message);
	  	  $tx_status = false;
		}
    }
    return $tx_status;
  }
 
}
