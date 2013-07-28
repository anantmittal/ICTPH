<?php
class provider_model extends IgnitedRecord {
	var $habtm = array (
		array (
			"table" => "provider_locations",
			"join_table" => "provider_location_affiliations"
		)
	);

	function is_name($text) {
		$ps = $this->like('full_name', $text, 'both')->find_all();

		if ($ps)
			return $ps;
		else
			return false;
	}

	function save_provider($provider_object) {		
		$p_obj = $this->new_record($provider_object);
		$p_obj->save();			
		return $p_obj;
	}
}