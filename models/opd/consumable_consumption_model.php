<?php
class consumable_consumption_model extends IgnitedRecord {
	
	function save_consumable($product_id,$quantity,$location_id,$provider_id,$date,$scm_org_id,$visit_id,$comment){
		
		$consumable_config_obj = $this->new_record();
		$consumable_config_obj->product_id=$product_id;
		if($visit_id!=''){
			$consumable_config_obj->visit_id=$visit_id;
		}
		$consumable_config_obj->quantity_consumed=$quantity;
		$consumable_config_obj->provider_location_id=$location_id;
		$consumable_config_obj->provider_id=$provider_id;
		$consumable_config_obj->date=Date_util::to_sql($date);
		$consumable_config_obj->comment=$comment;
		$consumable_config_obj->scm_org_id=$scm_org_id ;
		$consumable_config_obj->save();
		return $consumable_config_obj;
	}
	
}