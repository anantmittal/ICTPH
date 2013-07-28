<?php
class visit_referral_entry_model extends IgnitedRecord {
  var $belongs_to = array("visit");
  
  function save_visit($list, $visit_id){
  	$tx_status = true;
  	foreach ($list as $speciality) {
      	$referral_entry = $this->new_record();
      	$referral_entry->speciality = trim($speciality);
      	$referral_entry->visit_id = $visit_id;
      	if(!$referral_entry->save()){
  	 		$tx_status = false;
		}
    }
    return $tx_status;
  }
}
