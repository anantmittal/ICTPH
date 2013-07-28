<?php
class backend_claim_settlement_model extends IgnitedRecord {

/*	function create_containts($data) {
		$payment_type_arr = array(
		'hospital'=>         array('field'=>'payment_to_hospital', 'label'=> 'Payment to Hospital',          'status_field'=>'status_payment_to_hospital'),
	    'patient' =>         array('field'=>'payment_to_policy_holder','label'=> 'Payment to Policy-Holder', 'status_field'=>'status_payment_to_policy_holder'),
		'backend_insurer' => array('field'=>'payment_from_insurer','label'=> 'Payment from Insurer',         'status_field'=>'status_payment_from_insurer'));
		
		$payment_type = $data['payment_type'];	
		
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        $this->select(array('full_name','person_id AS person_id', 'claims.policy_id','claims.filling_date'))
             ->from(array('claims', 'hospitalizations', 'persons'))
             ->where('claims.id', 'claim_settlements.id', false)
             ->where('claims.hospitalization_id', 'hospitalizations.id', false)
             ->where('hospitalizations.person_id', 'persons.id', false);
             
        if($start_date != '' && $end_date != '') {
			$this->where('claims.filling_date >=', $start_date);
			$this->where('claims.filling_date <=', $end_date);
        }
        elseif ($start_date != '' && $end_date == '') {
			$this->where('claims.filling_date >=', $start_date);
        }
        elseif ($start_date == '' && $end_date != '') {
			$this->where('claims.filling_date <=', $end_date);
        }
        elseif ($start_date == '' && $end_date == '') {
			//this condition means all data from database will be get fetch
        }
		
        $result = $this->find_all();
		
        $data_arr =array(array('Person Name','Policy-ID','Claim-ID','Filling Date', 'claim_status', 'Backend Claim Status', $payment_type_arr[$payment_type]['label'], ucfirst(implode(' ',explode('_',$payment_type_arr[$payment_type]['status_field'])))   ));
        foreach ($result as $row) {         	
           $data_arr[] = array(ucfirst($row->full_name), $row->policy_id, $row->id,$row->filling_date, $row->claim_status, $row->backend_claim_status,
           					 $row->$payment_type_arr[$payment_type]['field'], $row->$payment_type_arr[$payment_type]['status_field']);
        }
        return $data_arr;
	}
*/
}
