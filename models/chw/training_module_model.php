<?php
class training_module_model extends IgnitedRecord {

	function is_name($text) {
	  $recs = $this->like('name',$text,'both')->find_all();

	  if($recs)
	  	return $recs;
	  else return false;	
	}

}
