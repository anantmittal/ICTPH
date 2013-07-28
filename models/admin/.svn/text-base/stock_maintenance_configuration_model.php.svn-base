<?php
class stock_maintenance_configuration_model extends IgnitedRecord {
function save_consumables_to_maintenance($values,$saved_value) {
		$service_config_obj = $this->new_record();
		$service_config_obj->stock_maintenance_id=$saved_value->id;
		$service_config_obj->product_id=$values['product_id'];
		$service_config_obj->product_quantity_lab=$values['quantity'];
		$service_config_obj->save();
		return $service_config_obj;
	}
}