<?php
class order_model extends IgnitedRecord {
	
	/**
	 * @param Transation object $tx_obj
	 * Takes transaction a input and returns saved order object
	 */
	function save_order($tx_obj){
		$order_obj = $this->new_record();
		$order_obj->order_txid = $tx_obj->id;
		$order_obj->order_date = $tx_obj->date;
		if($order_obj->save()){
			return $order_obj;
		}else{
			return NULl;
		}
	}
	
	function close_order($order_id){
		$order_obj = $this->find_by("id",$order_id);
		$order_obj->order_status = "Closed";
		return $order_obj->save();
	}
	
}
