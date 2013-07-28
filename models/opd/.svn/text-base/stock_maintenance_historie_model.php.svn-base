<?php 
class stock_maintenance_historie_model extends IgnitedRecord {
	function save_data($maintenance_id,$location_id,$provider_id,$date){
		$value = $this->new_record();		
		$value->provider_location_id = $location_id;
		$value->provider_id = $provider_id;
		$value->stock_maintenance_id = $maintenance_id;
		$value->date = Date_util::to_sql($date);
		$value->comment= 'stock maintenance and calibration';
		$value->save();
		return $value;
	}
}