<?php 
class hospitalization_cost_item_model extends IgnitedRecord {
	var $has_one = 'claim_cost_item';
	
	/*function Hospitalization_cost_item_model()
	{
		parent::IgnitedQuery();
		
		$this->belongs_to('claim_cost_items')->fk('hospitalization_cost_item_id');
	}*/
	
	function get_all_claim_items($claim_id){		
	 $result = $this->select(array('item_type' , 'item_subtype', 'item_name','number_of_times','rate','amount','claimed_amount','comment'))
			 ->from(array('claim_cost_items'=>'cci'))
			 ->where('hospitalization_cost_items.id', 'cci.hospitalization_cost_item_id', false)
			 ->where('cci.claim_id', $claim_id, false)
			 ->order_by('item_type')
			 ->find_all();
		return $result;	 
	}
}
