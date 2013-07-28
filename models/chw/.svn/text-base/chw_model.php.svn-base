<?php
class chw_model extends IgnitedRecord {
	function is_name($text) {
	  $chws = $this->like('name',$text,'both')->find_all();

	  if($chws)
	  	return $chws;
	  else return false;	
	}
}
