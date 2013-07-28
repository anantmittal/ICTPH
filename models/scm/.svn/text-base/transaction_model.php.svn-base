<?php
class transaction_model extends IgnitedRecord {
  var $has_many = array("transaction_items");

  function  save_order_txn($tx_param,$date,$username){
  	$tx_obj = $this->new_record($tx_param);
  	$tx_obj->type = 'Order';
  	$tx_obj->date = $date;
  	$tx_obj->username = $username;
  	if($tx_obj->save()){
  		return $tx_obj;
  	}else{
  		return NULL;
  	}
  }

}
