<?php 

class pre_authorization_model extends IgnitedRecord {
	//Pre_authorization_model belongs to person model ie one person may have many preauths.
	//var $belongs_to = "person";
	var $belongs_to = array("hospital", "hospitalization");
			
	function get_all_preauths($policy_id)
 	{ 		
 		$this->join_related('hospital', 'name');
 		return $this->find_all_by('policy_id',$policy_id);
 	} 	

	function get_total_amount($hospitalization_id)
 	{ 		
		$amount_recs = $this->select_sum('expected_cost','amount')->find_all_by('hospitalization_id',$hospitalization_id);
		foreach($amount_recs as $rec)
		    $amount = $rec->amount;
 		return $amount;
 	} 	
}
