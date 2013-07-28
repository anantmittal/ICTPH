<?php
class provider_location_affiliation_model extends IgnitedRecord {
	/* var $habtm = array(array("table" => "providers",
				   "join_table" => "provider_location_affiliation"));
		function is_name($text) {
		  $ps = $this->like('name',$text,'both')->find_all();
	
		  if($ps)
		  	return $ps;
		  else return false;	
		}*/

	function save_provider_location_affiliation($p_obj,$provider_locations_array) {		
		for ($i = 0; $i < sizeof($provider_locations_array); $i++) {
			$pla_rec = $this->new_record();
			$pla_rec->provider_id = $p_obj->id;
			$pla_rec->provider_location_id = $provider_locations_array[$i];
			$pla_rec->save();
		}
	}
	
	function get_provider_location_ids($provider_id){
		$location_mapped = $this->find_all_by('provider_id', $provider_id);
		$provider_location_ids  = array();
		$i = 0;
		foreach ( $location_mapped as $value ) {
       		$provider_location_ids[$i] = $value->provider_location_id;
       		$i++;
		}
		return $provider_location_ids;
	}	
	

}