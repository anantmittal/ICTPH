<?php
class visit_test_entry_model extends IgnitedRecord {
  var $belongs_to = array("visit");
  var $has_one = array("test_type", "visit_cost_item_entry");
   
  function save_visit($list,$visit_id,$test_type){
  	$t_array = array();
  	$tx_status = true;
    foreach ($list as $test) {
      if (isset($test["status"]) && $test["status"] != "NA") {
		$tt_rec = $test_type->find($test['test_type_id']);
		if($tt_rec->bill_type == 'Single'){
			$t_entry = $this->new_record($test);
			$t_entry->visit_id = $visit_id;
			if(!$t_entry->save()) {
  	 			$tx_status = false;
			}
			$t_array[$test["index"]] = $t_entry;
		}else{
			$para_str = explode(':',$tt_rec->bill_type);
			$paras = explode(',',$para_str[1]);
			$i=0;
			foreach($paras as $para){
				$t_entry = $this->new_record($test);
				$t_entry->visit_id = $visit_id;
				$t_entry->test_type_id = $para;
				if(!$t_entry->save()) {
      				$tx_status = false;
				}
				$t_array[$test["index"]] = null;
			}
		}
      }
    }
    if(!$tx_status)
    	return null;
    return $t_array;
  }
}
