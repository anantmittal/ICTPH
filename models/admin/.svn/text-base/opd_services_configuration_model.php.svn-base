<?php
class opd_services_configuration_model extends IgnitedRecord {
function save_products_to_service($values,$saved_value) {
		$service_config_obj = $this->new_record();
		$service_config_obj->opd_service_id=$saved_value->id;
		$service_config_obj->product_id=$values['product_id'];
		$service_config_obj->product_quantity=$values['quantity'];
		$service_config_obj->save();
		return $service_config_obj;
	}
}