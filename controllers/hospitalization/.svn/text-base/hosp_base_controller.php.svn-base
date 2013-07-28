<?php
class Hosp_base_controller extends CI_Controller {
	public $policy_id;	
	function __construct() {
		parent::__construct();
	}
/*	function index()
	{		
		
	}*/


	function get_short_context($id = '', $id_type = '') {
		$this->load->library('date_util');
		$short_context = array();		
		$policy_id = '';
		
		if($id_type == 'preauthorization') {	
		
			$this->load->model('hospitalization/pre_authorization_model','preauthorization');						
			$preauth_rec  = $this->preauthorization
			 				->select(array('persons.full_name AS patient_name','persons.gender AS patient_gender',
			 				'persons.date_of_birth AS dob', 'persons.age', 'hospitals.name AS hospital_name'))
			 				->from(array('persons','hospitals'))
			 				->where('persons.id', 'person_id', false)
			 				->where('hospitals.id', 'hospital_id', false)
			 				->where('pre_authorizations.id', $id)			 				
			 				->get();
			
			 				
		   $birth_date =  $preauth_rec->dob;
		   $age = $preauth_rec->age;

		   $dob = date('m/d/Y',strtotime($birth_date));
		   $today = date('m/d/Y');
           $date_parts1=explode("/", $dob);
           $date_parts2=explode("/", $today);
           $start_date = gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
           $end_date = gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
           $diff = round(($end_date - $start_date) / 365);
		   $age = $diff + $age;
		   
		   
		   
		    $short_context['patient_age'] = &$age;
			$policy_id =& $preauth_rec->policy_id;
			$short_context['patient_name'] =& $preauth_rec->patient_name;
			$short_context['patient_dob'] =& $birth_date;
			$short_context['patient_gender'] =& $preauth_rec->patient_gender;
			$short_context['hospitalization_id'] =& $preauth_rec->hospitalization_id;
			$short_context['hospital_name'] =& $preauth_rec->hospital_name;		
			$short_context['preauthorization_id'] =& $id;
		}
		elseif($id_type == 'claim'){
			$this->load->model('hospitalization/claim_model','claim');						
			$claim_rec  =& $this->claim->find($id);
						
			$short_context['claim_id'] =& $claim_rec->id;
			$short_context['hospitalization_id'] =& $claim_rec->hospitalization_id;
		}


		if($id_type == 'hospitalization' || $id_type == 'claim') {

			if(isset($short_context['hospitalization_id']))
				$id = $short_context['hospitalization_id'];

			$this->load->model('hospitalization/hospitalization_model','hospitalization');

			


			$hospitalizatin_rec  = $this->hospitalization
				->select(array('p.full_name AS patient_name', 'p.gender AS patient_gender', 'p.date_of_birth', 
							   'p.age', 'h.name AS hospital_name', 'vc.name AS village_name'))
				->from(array('persons' => 'p', 'hospitals' => 'h', 'households' => 'ho', 'village_cities' => 'vc')) 
				->where('hospitalizations.person_id', 'p.id', false)
				->where('hospitalizations.hospital_id', 'h.id', false)			 							 				
				->where('vc.id', 'ho.village_city_id', false)			 				
				->where('p.household_id', 'ho.id', false)			 				
				->where('hospitalizations.id', $id, false)
				->get();


		   $birth_date =  $hospitalizatin_rec->date_of_birth;
		   $age = $hospitalizatin_rec->age;

		   $dob = date('m/d/Y',strtotime($birth_date));
		   $today = date('m/d/Y');
           $date_parts1=explode("/", $dob);
           $date_parts2=explode("/", $today);
           $start_date = gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
           $end_date = gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
           $diff = round(($end_date - $start_date) / 365);
		   $age = $diff + $age;

		   $policy_id = &$hospitalizatin_rec->policy_id;			

		   $short_context['policy_id'] = &$hospitalizatin_rec->policy_id;
		   $this->load->model('admin/policy_model', 'policy_m');
		   $policy_rec = $this->policy_m->find($policy_id);
		   $short_context['backend_member_id'] = $policy_rec->backend_member_id;
		   $short_context['hospitalization_id'] = &$id;
		   $short_context['hospital_id'] = &$hospitalizatin_rec->hospital_id;
		   $short_context['patient_name'] = &$hospitalizatin_rec->patient_name;
		   $short_context['patient_dob'] =& $birth_date;
		   $short_context['patient_gender'] = &$hospitalizatin_rec->patient_gender;
		   $short_context['patient_age'] = &$age;		   
		   $short_context['hospital_name'] = &$hospitalizatin_rec->hospital_name;
//		   $short_context['hospitalization_date'] = $this->date_display_format($hospitalizatin_rec->hospitalization_date);
		   $short_context['hospitalization_date'] = Date_util::date_display_format($hospitalizatin_rec->hospitalization_date);

		   if($hospitalizatin_rec->discharge_date && $hospitalizatin_rec->discharge_date != '0000-00-00'){
//		   	  $short_context['discharge_date'] = $this->date_display_format($hospitalizatin_rec->discharge_date);
		   	  $short_context['discharge_date'] = Date_util::date_display_format($hospitalizatin_rec->discharge_date);		   	  
		   }
		   else $short_context['discharge_date'] = '--/--/----';

		   $short_context['village_name'] = &$hospitalizatin_rec->village_name;		   			
		}

		if($id_type == 'preauthorization' || $id_type == 'policy') {
			if($policy_id == '')
				$policy_id = &$id;
		
//			$this->load->model('hospitalization/member_policy_detail_model','member_policy');
			$this->load->model('admin/policy_model', 'policy');
			$this->load->model('admin/policy_type_model', 'policy_type');
			
 			$policy_rec = $this->policy
						->select(array('p.full_name AS family_head', 'policies.status AS policy_status', 'policies.used_amount', 
						'policies.backend_member_id','policies.blocked_amount', 'policies.available_amount','policies.policy_end_date', 'vc.name AS village_name', 'h.id AS household_id'))
						->from(array('persons'=>'p',  'households'=>'h', 'village_cities'=>'vc'))
						->where('h.policy_id', 'policies.id', false)
						->where('h.id', 'p.household_id', false)
						->where('vc.id', 'h.village_city_id', false)
						->where('policies.id', $policy_id)
						->get(); 


			if($policy_rec != false){
				$short_context['policy_id'] = $policy_id;
				$short_context['backend_member_id'] = $policy_rec->backend_member_id;
				$short_context['policy_status'] = $policy_rec->policy_status;
				$short_context['policy_type'] = $this->policy_type->find($policy_rec->scheme_id)->name;
				$short_context['policy_limit'] = $this->policy_type->find($policy_rec->scheme_id)->limit;
				$short_context['used_amount'] = $policy_rec->used_amount;
				$short_context['policy_end_date'] = $policy_rec->policy_end_date;
				$short_context['blocked_amount'] = $policy_rec->blocked_amount;
				$short_context['available_amount'] = $policy_rec->available_amount;
				$short_context['family_head'] = $policy_rec->family_head;
				$short_context['village_name'] = $policy_rec->village_name;
				$short_context['policy_end_date'] = $policy_rec->policy_end_date;
				$short_context['household_id'] = $policy_rec->household_id;
				
				if($policy_rec->policy_end_date != '0000-00-00') {
//					$short_context['policy_end_date'] = $this->date_display_format($policy_rec->policy_end_date);
					$short_context['policy_end_date'] = Date_util::date_display_format($policy_rec->policy_end_date);
				}	
				else $short_context['policy_end_date'] = '--/--/----';

			}
			else {
				return false;				
			}
		}		
		return $short_context;		
	}
	
	
	
	
	
	/**
	 *@uses : functions validate_id() is used to check whether passed id is valid or
	 * not it takes type and id and will find in db whether it is available in 
	 * db or its type is proper or not
	 * 
	 *@uses : only need to call the function from controller action with id and type and no need to check wheter it is returnig
	 * true or false.
	 * @return true if success and  and if id is false it Redirect to error page	 * 
	 *
	 * @param string or number $id
	 * @param string $type : can be 'claim', 'preauth', 'policy', 'hospitalization'
	 * @param string : $output_type = 'show_error' default is show_error if this parameter set different than show_error it will return 'false'
	 *   this is useful when validating id and by ajax call. as ajax do not support server side redirect in ajax call
	 * hospitalization  int(10)
	 * claim    int(10)	   	   
	 * preauth  int(10)
	 * hospital int 10
	 * policy  varchar   //only varchar ID
	 * family int(10)	   
	 * person  int(10)
	 * hospital_record int(10) --- may not needed to check	   
	 */
	
	
		function validate_id($id = '', $type = '', $output_type = 'show_error') {		
		$error = false;
		$error_msg = '';
		
		//quick hack : this name change is only for maintaining consistancy with 
		// short_context
		if($type == 'preauthorization')
			$type = 'pre_authorization';

		if ($id == '' || $type == '') {
//		    if($output_type != 'show_error'){
		    	$error = true;
		    	
		    	if($id == '' && $type !=''){
		    	   $error_msg = ucfirst($type).'-ID is not passed properly.';
		    	}
		    	else  
		    	$error_msg = 'ID or TYPE is not passed properly.';	

		    	if($output_type == 'show_error')
		       	    show_error($error_msg);		       	   
		    	else
		    	    return 'error|'.$error_msg;
		}

        if ($type != 'policy') {
        	if(!ctype_digit("$id")){
        	  $error = true;
		      $error_msg = 'ID should be NUMBER for '.$type.' type.';	
//        	  show_error('ID should be NUMBER for '.$type.' type.');
        	}
        	else {//if type $id is numeric        		        		
				if($type == 'hospitalization' || $type == 'claim' || $type == 'pre_authorization' || $type == 'hospital' || $type == 'backend_claim') {
					$this->load->model('hospitalization/'.$type.'_model', 'type_model');
//					$rec = $this->type_model->find($id);
					$num_recs = $this->type_model->where('id', $id)->count();
					if ($num_recs == 0) {
						$error = true;
		      			$error_msg = $type.'-ID : '.$id.' NOT FOUND IN DATABASE';
					}
					else return true;
				}
			    else {
					$error = true;
					$error_msg = 'TYPE IS NOT A VALID-TYPE';
				}
        	}
        }
        else { //if $id is alphanumeric which is policy_id        	 
//    	 	 $policy = IgnitedRecord::factory('family_enrolment_details');
			 $this->load->model('admin/policy_model', 'policy');
    	 	 
//			 $rec = $policy->find_by('policy_id', $id);				 
             $num_recs = $this->policy->where('id', $id)->count();
             
			 if ($num_recs == 0){
			 	$error = true;
		      	$error_msg = 'Policy-ID : "'.$id.'" NOT FOUND IN DATABASE';
			 }
			 else
			 	return true;
        }
        if($error == true && $output_type == 'show_error')
        	show_error($error_msg);
        elseif ($error == true && $output_type != 'show_error')
         return 'error|'.$error_msg;
        else return true;
	}


/**
 * this functions gives next actions
 * 
 * @param unknown_type $action
 * @param unknown_type $object_type
 * @return unknown
 */

	function  get_next_action($action, $object_type = ''){
		if($object_type == 'preauth'){
		$next_actions = array(
			"To be reviewed"=>array(
				array("text"=>"Approve", "controller"=>"hospitalization/preautherization","action" => "save_status"),
				array("text"=>"Reject",  "controller"=>"hospitalization/preautherization","action" => "reject_preauth"),
				array("text"=>"Release", "controller"=>"hospitalization/preautherization","action" => "save_release_status"),
				array("text"=>"Edit",    "controller"=>"hospitalization/preautherization","action" => "edit_preauth")),

			'Rejected' => array(
				array("text"=>"Show reason", "controller"=>"hospitalization/preautherization","action" => "show_reason")),

			'Released' => array(
			array("text"=>"", "controller"=>"hospitalization/preautherization","action" => "")),

			"Approved"=>array(
				array("text"=>"Intimate Backend",  "controller"=>"hospitalization/preautherization","action" => "intimate_bc"),
				array("text"=>"Reauth",  "controller"=>"hospitalization/preautherization","action" => "enter_reauth"),
				array("text"=>"Release", "controller"=>"hospitalization/preautherization","action" => "save_release_status"),
				array("text"=>"Hospitalize Patient",  "controller"=>"hospitalization/hospitalization","action" => "add")),

			"Discharged"=>array(
				array("text"=>"Release", "controller"=>"hospitalization/preautherization","action" => "save_release_status")),
		
			"Admitted"=>array(
				array("text"=>"Reauth",  "controller"=>"hospitalization/preautherization","action" => "enter_reauth"),
				array("text"=>"Release", "controller"=>"hospitalization/preautherization","action" => "save_release_status"))
				//array("text"=>"Hospitalize Patient",  "controller"=>"hospitalization/hospitalization","action" => "add"))
			);
		}
		if($object_type == 'hospitalization'){
		$next_actions = array(
			"Admitted"=>array(
				array("text"=>"Edit Hospitalization Details", "controller"=>"hospitalization/hospitalization","action" => "edit"),
				array("text"=>"Add Hospital Record",  "controller"=>"hospitalization/hospitalization","action" => "add_hospital_record")),
										
			"Discharged"=>array(
				array("text"=>"Edit Hospitalization Details", "controller"=>"hospitalization/hospitalization","action" => "edit"),
				array("text"=>"Add Hospital Record",  "controller"=>"hospitalization/hospitalization","action" => "add_hospital_record"),
				array("text"=>"Add Claim",  "controller"=>"hospitalization/claim","action" => "add"),
				array("text"=>"Add Backend Claim",  "controller"=>"hospitalization/backend_claim","action" => "add")));
		}
		if($object_type == 'claim'){
			$next_actions = array(
			"To be reviewed"=>array(
				array("text"=>"Review",  "controller"=>"hospitalization/claim","action" => "show"),
				array("text"=>"Edit",  "controller"=>"hospitalization/claim","action" => "edit")),

			'Settled' => array(
				array("text"=>"Review",  "controller"=>"hospitalization/claim","action" => "show"),
				array("text"=>"Add settlement details", "controller"=>"hospitalization/claim","action" => "add_settlement"),
				array("text"=>"Add Payment Made details", "controller"=>"hospitalization/claim","action" => "add_payment"),
				array("text"=>"Show settlement details", "controller"=>"hospitalization/claim","action" => "show_settlement")),
				
						
			'Pending hospital' => array(
				array("text"=>"Review", "controller"=>"hospitalization/claim","action" => "show"),
				array("text"=>"Edit",  "controller"=>"hospitalization/claim","action" => "edit")),

			'Pending patient' => array(
				array("text"=>"Review", "controller"=>"hospitalization/claim","action" => "show"),
				array("text"=>"Edit",  "controller"=>"hospitalization/claim","action" => "edit")));
		 }
		if($object_type == 'backend_claim'){
			$next_actions = array(
			"Not Filed"=>array(
				array("text"=>"Edit Backend Claim",  "controller"=>"hospitalization/backend_claim","action" => "add")
			),
			"Pending Insurer"=>array(
				array("text"=>"Update Status",  "controller"=>"hospitalization/backend_claim","action" => "status_update"),
				array("text"=>"Edit",  "controller"=>"hospitalization/backend_claim","action" => "edit")),

			'Settled' => array(
				array("text"=>"Add settlement details", "controller"=>"hospitalization/backend_claim","action" => "add_settlement"),
				array("text"=>"Add Payment Received details", "controller"=>"hospitalization/backend_claim","action" => "add_payment"),
				array("text"=>"Show settlement details", "controller"=>"hospitalization/backend_claim","action" => "show_settlement")),
						
			'Pending Hospital' => array(
				array("text"=>"Update Status",  "controller"=>"hospitalization/backend_claim","action" => "status_update"),
				array("text"=>"Edit",  "controller"=>"hospitalization/backend_claim","action" => "edit")),

			'Pending SIS' => array(
				array("text"=>"Update Status",  "controller"=>"hospitalization/backend_claim","action" => "status_update"),
				array("text"=>"Edit",  "controller"=>"hospitalization/backend_claim","action" => "edit")),

			'Pending Patient' => array(
				array("text"=>"Update Status",  "controller"=>"hospitalization/backend_claim","action" => "status_update"),
				array("text"=>"Edit",  "controller"=>"hospitalization/backend_claim","action" => "edit")));
		 }

		if(array_key_exists($action, $next_actions))
			return $next_actions[$action];
		else 
			return false;	
	}

}
