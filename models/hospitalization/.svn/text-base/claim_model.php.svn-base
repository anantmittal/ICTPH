<?php 
class claim_model extends IgnitedRecord {
	 var $has_many = 'claim_cost_items';
	 
	 /**	  
	  * @uses  this function may not necessary check 	 
	  */
	 function get_all_claims($policy_id) {
	 	return $this->find_all_by('policy_id', $policy_id);
	 }
	 
	 function get_all_claim_details($policy_id){	 	
	 	$claim_rec = $this
	 				->select(array('p.full_name AS patient_name', 'cs.claim_processing_status AS processing_status',
	 							'cs.claim_status', 'css.amount_settled AS amount_settled', 'cs.backend_claim_status AS backend_claim_status'))
	 	            ->from(array('persons'=>'p', 'hospitalizations'=>'h', 'claim_status'=>'cs', 'claim_settlements' => 'css'))
	 	            ->where('claims.hospitalization_id', 'h.id', false)
	 	            ->where('claims.last_claim_status_id', 'cs.id', false)
	 	            ->where('claims.id', 'css.id', false)
	 	            ->where('h.person_id','p.id', false)
	 	            ->find_all_by('claims.policy_id', $policy_id);

	 	  
		 
	 	if($claim_rec){
	 	  return $claim_rec;
	 	}
	 	else return false;	 	            
	 }
}
