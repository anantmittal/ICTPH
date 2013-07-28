<?php
class test_group_consumables_model extends IgnitedRecord {
function save_consumables_to_test_groups($values,$saved_value) {
		$consumables_obj = $this->new_record();
		$consumables_obj->test_group_id=$saved_value->id;
		$consumables_obj->product_id=$values['product_id'];
		$consumables_obj->quantity_lab=$values['quantity_lab'];
		$consumables_obj->quantity_clinic=$values['quantity_clinic'];
		$consumables_obj->save();
		return $consumables_obj;
	}
}