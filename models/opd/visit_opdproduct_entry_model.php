<?php
class visit_opdproduct_entry_model extends IgnitedRecord {
  var $belongs_to = array("visit", "product");
  var $has_one = array("visit_cost_item_entry");
  
  function save_visit($list,$visit_id){
  	$opd_prod_array = array();
  	$tx_status = true;
    foreach ($list as $opd_product) {
      	$opd_prod_entry = $this->new_record($opd_product);
      	$opd_prod_entry->visit_id = $visit_id;
      	//To know wheather the prod is "Ready" or "Made To Order" type.
      	if($opd_product["product_given_out"] === "on"){
      		$opd_prod_entry->product_given_out = "yes";
      	}else{
      		$opd_prod_entry->product_given_out = "no";
      	}
      	if(!$opd_prod_entry->save()){
	      	$home_message = 'Unable to save opd prod entry';
	      	$this->session->set_userdata('msg', $home_message);
	  	 	$tx_status = false;
		}
      $opd_prod_array[$opd_product["index"]] = $opd_prod_entry;
    }
    if(!$tx_status)
    	return null;
    return $opd_prod_array;
  }
}