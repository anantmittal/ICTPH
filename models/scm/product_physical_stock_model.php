<?php
class product_physical_stock_model extends IgnitedRecord {
 /* var $habtm = array(array("table" => "providers",
			   "join_table" => "provider_location_affiliation"));
	function is_name($text) {
	  $ps = $this->like('name',$text,'both')->find_all();

	  if($ps)
	  	return $ps;
	  else return false;	
	}*/
  var $belongs_to = "product";
}
