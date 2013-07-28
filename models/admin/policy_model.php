<?php
class policy_model extends IgnitedRecord {
  // TODO(arvind): Confused about where the policy type is stored - there is no
  // "schemes" table, only "policy_types" table
  // TODO - add relationships
  var $has_many = array("policy_types");
 	function Policy_model()
	{
		parent::IgnitedRecord();
		$this->CI_handle =& get_instance();
	}
  function get_limit($id)
  {
      if(!($policy_rec = $this->find($id)))
   	return false;
      return $policy_rec->related("policy_types")->get()->limit;
  }

  function get_expiry($id)
  {
      if(!($policy_rec = $this->find($id)))
   	return false;
      return $policy_rec->policy_end_date;
  }
  
	function create($details)
	{
		//First create the household and individuals
		$this->CI_handle->load->model('demographic/household_model','household');
		$this->CI_handle->load->model('admin/enrolment_statuse_model', 'enrolment_statuse');
		$this->CI_handle->load->model('admin/enrolled_member_model', 'enrolled_member');
		$policy_id=$details['policy_id'];
		if($hhret = $this->CI_handle->household->create_household_and_members($details))
		{
			$policy_rec = $this->new_record();
			$policy_rec->id = $policy_id;
			$policy_rec->scheme_id = 0;
			if(!$policy_rec->save())
				return false;
			$es_rec = $this->CI_handle->enrolment_statuse->new_record();
			$es_rec->policy_id = $policy_rec->id;
			$es_rec->id = 'Nurse'.$hhret['household_id'];
			$es_rec->form_date = Date_util::today_sql();
			$es_rec->username = 'admin';
			if(!$es_rec->save())
				return false;
			foreach($hhret['persons'] as $personid)
			{
				$enrolled_member_rec = $this->CI_handle->enrolled_member->new_record();
				$enrolled_member_rec->policy_id = $policy_rec->id;
				$enrolled_member_rec->person_id = $personid;
				if (!($enrolled_member_rec->save()))
					return false;
			}
			$policy_id=$policy_rec->id;
		}
		else 
			return false;
		return $policy_id;
	}
	
	function validateCard($policy_id){
		$policy_rec_exists = $this->find_by('id', $policy_id);
		$home_message="";
		if(!empty ($policy_rec_exists)){
			$home_message = "Household could not be saved. Policy already exists with id  ".$policy_id ."  ,to edit this policy please go to Edit household link" ;
			return $home_message;
		}
		else if(empty($policy_id) || strlen($policy_id) < 10 || preg_match ("/^[A-Z]{3}[0-9]{7}/",$policy_id) < 1){
			$home_message = "Household could not be saved. Invalid card number " ;
			return $home_message;
		}
		else {
			return $home_message;
		}
	}
}
