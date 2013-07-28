<?php 
class backend_claim_model extends IgnitedRecord {
	 
	 /**	  
	  * @uses  this function may not necessary check 	 
	  */
	 function get_all_backend_claims($policy_id) {
	 	return $this->find_all_by('policy_id', $policy_id);
	 }

	 function get_all_backend_claim_details($policy_id){	 	
	 	$backend_claim_recs = $this
	 			->select(array('backend_claim_settlements.amount_settled AS amount_settled'))
	 			->join('backend_claim_settlements','backend_claims.id = backend_claim_settlements.id','left')
	 	            	->find_all_by('backend_claims.policy_id', $policy_id);
		 
	 	if($backend_claim_recs){
	 	  return $backend_claim_recs;
	 	}
	 	else return false;	 	            
	 }
}
