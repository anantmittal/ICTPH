<?php
class order_invoice_receive_model extends IgnitedRecord {
	var $table="order_invoice_receive";
	
	function save_new_invoice($order_id,$tx_obj){
		$order_invoice_receive_obj = $this->new_record();
		$order_invoice_receive_obj->order_id = $order_id;
		$order_invoice_receive_obj->invoice_number = $tx_obj->id;
		$order_invoice_receive_obj->invoice_txn_id = $tx_obj->id;
		$order_invoice_receive_obj->invoice_date = $tx_obj->date;
		if($order_invoice_receive_obj->save()){
			return $order_invoice_receive_obj;
		}else{
			return NULl;
		}
	}
	
	function save_new_receive($order_id,$tx_obj,$invoice_number,$invoice_date){
		$order_invoice_receive_obj = $this->new_record();
		$order_invoice_receive_obj->order_id = $order_id;
		$order_invoice_receive_obj->invoice_number = $invoice_number;
		$order_invoice_receive_obj->invoice_date = $invoice_date;
		$order_invoice_receive_obj->receive_txn_id = $tx_obj->id;
		$order_invoice_receive_obj->receive_date = $tx_obj->date;
		if($order_invoice_receive_obj->save()){
			return $order_invoice_receive_obj;
		}else{
			return NULl;
		}
	}
}
