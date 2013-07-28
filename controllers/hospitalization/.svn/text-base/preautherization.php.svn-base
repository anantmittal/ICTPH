<?php
class Preautherization extends Hosp_base_controller {
	private $data = array();
	public $pre_auth_id;

	function __construct() {
		parent::__construct();
		$this->load->model('demographic/person_model','person');
    		$this->load->model('user/user_model','user');
		$this->load->model('demographic/household_model','household');
		$this->load->model('hospitalization/pre_authorization_model','pre_auth');
		$this->load->model('hospitalization/hospital_model','hospital');
		$this->load->model('hospitalization/claim_review_doctor_model','claim_doctor');
		$this->load->model('hospitalization/backend_claim_model','backend_claim');
//		$this->load->model('hospitalization/member_policy_detail_model','member_policy_detail');
		$this->load->model('admin/policy_model','policy_model');
		$this->load->model('hospitalization/hospital_model','hospital');
		$this->load->model('hospitalization/hospitalization_model','hospitalization');
//		$this->load->model('hospitalization/network_facilitator_model', 'network_facilitator');
		$this->load->model('geo/staff_model', 'staff');
		$this->load->model('geo/village_citie_model', 'village_citie');
		$this->load->library('form_validation');
    		$this->load->library('session');
	}

	function index() {
		
	}

	function _preauth_form_rules()	{
	   //this function contains all of the field validation rules so bad data can't enter the system
	   $preauth_checks =array(
						array('field'=>'expected_cost', 'label'   => 'Expected cost', 'rules'   => 'required|numeric|callback_compare_available_balance')
					/*array('field'=>'current_diagnosis_other', 'label'   => 'Chief Complaint', 'rules'   => 'required'),
					  array('field'=>'current_diagnosis_other',	'label'   => 'Chief Complaint',	'rules'   => 'required')*/
					);
	   $this->form_validation->set_error_delimiters('<label class="error">', '</label>');
	   return $preauth_checks;
	}
	
	function compare_available_balance($balance) {
//		return true; //todo : remove this
	   $available_bal = 0;
	   $action = $this->uri->segment(3);
	   $this->form_validation->set_message('expected_cost', "Available balance is LESS than %s");	
	   	   
	   if($action == 'edit_preauth' || $action == 'enter_reauth') {
	   		$preauth_id =& $this->uri->segment(4);
	   		$this->load->model('hospitalization/pre_authorization_model','pre_auth');
	   		$preauth_obj =& $this->pre_auth->find($preauth_id);
	   		$policy_id =& $preauth_obj->policy_id;
	   		$expected_cost =& $preauth_obj->expected_cost;	   		
	   }
	   elseif($action == 'enter_preauth') {
	   		$policy_id = $this->uri->segment(4);
	   }
	   
//	   $this->load->model('hospitalization/Member_policy_detail_model','Member_policy_detail');
//	   $member_policy_details = $this->Member_policy_detail->find_by('policy_id', $policy_id);

	   $this->load->model('admin/policy_model','policy_model');
	   $member_policy_details = $this->policy_model->find($policy_id);
	   $available_bal = $member_policy_details->available_amount;

	   if($action == 'edit_preauth') {
	   		$available_bal = $available_bal + $expected_cost;
	   }

	   if($balance > $available_bal) {
		  return false;
		}
		else return true;
	}

	function _preauth_form_defaults() {
		//set default values when calling the Add function the first time, to prevent invalid index errors
		$preauth_values = array(
		'id'	=> '',
		'preauth_form_number' => '',
		'person_id'  => '',
		'hospital_id'   => '',
		'chief_complaint'   => '',
		'detail_complaint'   => '',
		'present_illness_history'   => '',
		'associated_illness'   => '',
		'expected_stay_duration'   => '',
		'expected_cost'   => '',
		'doctor_name'   => '',
		'network_faciliator_id'   => '',
		'procedure'   => '',
		'current_diagnosis'   => '',
		'cost_comment'   => '',
		'comments'  => '',
		);
		return $preauth_values;
	}

	function enter_preauth($policy_id = 0) {
		$this->validate_id($policy_id,'policy');
		$this->load->model('admin/enrolled_member_model','enrolled_member');
		
	  /*this functionality is previously used as due to table factored out it is useless
		$family_obj = $this->family->get_family_detail($policy_id);		
		$person_detail = $this->person->get_all_persons($family_obj->family_id);*/

		$pre_auth_id = 0; // this is hard coded because this functionality is for new preauth or reauth

		$form = $this->_preauth_form_rules();		
		$this->form_validation->set_rules($form);
		$this->form_validation->set_error_delimiters('<label class="error">', '</label>');

		$form['policy_id'] = &$policy_id;
//		$form['person_obj'] =&$person_detail;		
		$form['person_obj'] = $this->enrolled_member->get_members_by_policy_id($policy_id);;		
		$form['action'] = "add";
//		$form['nf_obj'] = &$this->network_facilitator;
		$form['nf_obj'] = &$this->staff;
		$form['short_context'] = &$this->get_short_context($policy_id,'policy');		
		$form['hospital_obj'] =& $this->hospital;

		if (!$_POST) {		
			$form['policy_id'] = $policy_id;
			$form['pre_auth_id'] = $pre_auth_id;
			$form['values'] = $this->_preauth_form_defaults();
			$this->load->view('hospitalization/show_preauth_entry_form', $form);
			return;
		}


		if ($this->form_validation->run() == FALSE || !$this->save_preauth($policy_id))	{
			$form['pre_auth_id'] =& $pre_auth_id;
			$form['values'] = $_POST;
			$this->load->view('hospitalization/show_preauth_entry_form', $form);
		}
	}
	
	function edit_preauth($pre_auth_id = 0)	{
//		only edit if the record exists		
		$this->validate_id($pre_auth_id,'preauthorization');

//		set rules for the for
		$form = $this->_preauth_form_rules();
		$this->form_validation->set_rules($form);
				
		$form['short_context'] = $this->get_short_context($pre_auth_id, 'preauthorization');
		
		$policy_id = $form['short_context']['policy_id'];
		
//		$family_obj = $this->family->get_family_detail($policy_id);

		
		
//		$person_detail = $this->person->get_all_persons($form['short_context']['family_id']);
		$person_detail = $this->person->find_all_by('household_id',  $form['short_context']['household_id']);
				
		
		$preauth_arr = $this->pre_auth->find($pre_auth_id);
		$result = $this->form_validation->run();

		if ($this->form_validation->run() == FALSE || !$this->save_preauth($policy_id, $pre_auth_id, 'edit')) {
//		if the post array doesn't exist yet, fill in the values from the database (pulled when checking existence of the record)
			$form['pre_auth_id'] = $pre_auth_id;
			$form['policy_id'] = $policy_id;
			$form['person_obj'] = $person_detail;
			$form['action'] = "edit";
			$form['hospital_obj'] = $this->hospital;
		//	$form['nf_obj'] = $this->network_facilitator;
			$form['nf_obj'] = $this->staff;
			
			
			if (!$_POST) {
				$form['values'] = (array) $preauth_arr;
			}
			else {
				$form['values'] = $_POST;
			}			
			$this->load->view('hospitalization/show_preauth_entry_form', $form);
		}
	}

	/**
	  * save_preauth() is used to save data with some conditions as per value of $pre_auth_id
	  *
	  * @param int $policy_id
	  * @param int $pre_auth_id : if its value is 0 it will insert new entry(preauth) or enter entry with pre_auth_id(reauth)
	  */
	
	function enter_reauth($pre_auth_id = 0)	{
//		only edit if the record exists
//		$this->validate_id($pre_auth_id, 'preauthorization');

	
//		set rules for the for
		$form = $this->_preauth_form_rules();
		$this->form_validation->set_rules($form);
		
		$form['short_context'] = $this->get_short_context($pre_auth_id, 'preauthorization');
		
		$policy_id = $form['short_context']['policy_id'];		
//		$family_obj = $this->family->get_family_detail($policy_id);
//		$person_detail = $this->person->get_all_persons($family_obj->family_id);
		$person_detail = $this->person->find_all_by('household_id',  $form['short_context']['household_id']);

		$preauth_arr = $this->pre_auth->find($pre_auth_id);

		if ($this->form_validation->run() == FALSE || !$this->save_preauth($policy_id, $pre_auth_id, 'reauth'))	{
//		if the post array doesn't exist yet, fill in the values from the database (pulled when checking existence of the record)

			$form['pre_auth_id'] = $pre_auth_id;
			$form['policy_id'] = $policy_id;
			$form['person_obj'] = $person_detail;
			$form['nf_obj'] = $this->staff;
//			$form['nf_obj'] = $this->network_facilitator;
			$form['action'] = "reauth";
			if (! $_POST) {
				$form['values'] = (array) $preauth_arr;
			}
			else {
				$form['values'] = $_POST;
			}
			$this->load->view('hospitalization/show_preauth_entry_form', $form);
		}
		
	}
	
	function save_preauth($policy_id = 0, $pre_auth_id = 0, $action = 'new') {
		
		$data = $_POST;
//    $this->db->trans_start();
    $tx_status = true;
    $this->db->trans_begin();
		if($data['day_care'] == 'yes') {
			$data['expected_stay_duration'] = 0;
		}

		$data['policy_id'] = $policy_id;
		if($data['chief_complaint'] == 'Other')
			$data['chief_complaint'] = $data['chief_complaint_other'];

		if($data['current_diagnosis'] == 'Other')
			$data['current_diagnosis'] = $data['current_diagnosis_other'];

		if($data['procedure'] == 'Other')
			$data['procedure'] = $data['procedure_other'];
			
		$data['date'] = date("Y-m-d");
		$u_name = $this->session->userdata('username');
		$claim_doctor_rec = $this->claim_doctor->find_by('username',$u_name);
		if($claim_doctor_rec)	
		{	$data['claim_review_doctor_id'] = $claim_doctor_rec->id;}
		else
		{	$data['claim_review_doctor_id'] = 1;}
		
		if($action == 'new' || $action == 'reauth')	{
			$pre_authorization_rec = $this->pre_auth->new_record($data);
			
//			$this->load->model('hospitalization/Member_policy_detail_model','Member_policy_detail');
//			$member_policy_details = $this->Member_policy_detail->find_by('policy_id',$policy_id);

			$this->load->model('admin/policy_model');
			$member_policy_details = $this->policy_model->find($policy_id);			
			
			$old_pre_auth_amount = 0;
			if($action == 'reauth')
			{
				$old_pre_auth_rec = $this->pre_auth->find($pre_auth_id);
				$old_pre_auth_amount = $old_pre_auth_rec->expected_cost;
				$old_pre_auth_rec->preauth_status = 'Released';
				$tx_status = $old_pre_auth_rec->save() AND $tx_status;
				
				$pre_authorization_rec->prev_preauth_id = $pre_auth_id;
			}

			$member_policy_details->available_amount -= ($pre_authorization_rec->expected_cost - $old_pre_auth_amount);
			$member_policy_details->blocked_amount +=  $pre_authorization_rec->expected_cost - $old_pre_auth_amount;
			

			$tx_status = $tx_status AND $pre_authorization_rec->save();
			$tx_status = $tx_status AND $member_policy_details->save();			
			
			$this->session->set_flashdata('msg_type', 'success');
	   		$this->session->set_flashdata('msg', 'Preauth record saved successfully');
		}
		else {		
			$pre_authorization_rec = $this->pre_auth->find($pre_auth_id);
			if($pre_authorization_rec->expected_cost != $data['expected_cost'])
			{
			  $this->load->model('admin/policy_model');
			  $member_policy_details = $this->policy_model->find($policy_id);			
			
			  $member_policy_details->available_amount += ($pre_authorization_rec->expected_cost - $data['expected_cost']);
			  $member_policy_details->blocked_amount -=  ($pre_authorization_rec->expected_cost - $data['expected_cost']);
			$tx_status = $tx_status AND $member_policy_details->save();			
			}
			
			$pre_authorization_rec->load_data($data);
			$tx_status = $tx_status AND $pre_authorization_rec->save();
			$this->session->set_flashdata('msg_type', 'success');
	   		$this->session->set_flashdata('msg', 'Preauth record updated successfully');
		}
	   
    if($tx_status == true)
    {
       $this->db->trans_commit();
    }
    else {
       $this->db->trans_rollback();
       return false;
    }
//    $this->db->trans_complete();
	   redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);
	    
	}
	
	function reject_preauth() {
		$this->load->view('hospitalization/show_preauth_reject');
	}
	
	function show_reason($pre_auth_id = 0) {		
		$this->load->model('hospitalization/pre_authorization_model','pre_auth');
		$pre_auth_obj = $this->pre_auth->find($pre_auth_id);		
		$data['reason'] =  $pre_auth_obj->rejection_reason;
		$this->load->view('hospitalization/show_reason',$data);
	}

	function save_reject_reason() {
//		$this->load->model('hospitalization/Member_policy_detail_model','Member_policy_detail');
		$this->load->model('admin/policy_model','policy_model');
	    
		$pre_auth_id = $_POST['pre_auth_id'];
		$preauth_rec = $this->pre_auth->find($pre_auth_id);
		$member_policy_details_rec = $this->policy_model->find($preauth_rec->policy_id);
//		$member_policy_details_rec = $this->Member_policy_detail->find_by('policy_id', $preauth_rec->policy_id);
		$preauth_rec->preauth_status = 'Reject';
		$preauth_rec->rejection_reason = $this->input->post('reason');
		
                //$preauth_rec->expected_cost;        
		$member_policy_details_rec->blocked_amount -= $preauth_rec->expected_cost;
		$member_policy_details_rec->available_amount += $preauth_rec->expected_cost;		

/*    $this->db->trans_start();
		$preauth_rec->save();
		$member_policy_details_rec->save();
    $this->db->trans_complete();*/

    $this->db->trans_begin();
		if( $preauth_rec->save() AND $member_policy_details_rec->save())
		{ $this->db->trans_commit();}
		else	
		{ $this->db->trans_rollback();}

		redirect('/hospitalization/policy_details/show_policy_details/'.$preauth_rec->policy_id);
	}

	function save_status($pre_auth_id) {
		$data = array();
		$data['short_context'] = &$this->get_short_context($pre_auth_id,'preauthorization');				
		$preauth_rec = $this->pre_auth->find_by('id',$pre_auth_id);
		if($preauth_rec->prev_preauth_id != 0)
		{ $is_reauth = true;
			$prev_id = $preauth_rec->prev_preauth_id;
			$prev_preauth_rec = $this->pre_auth->find_by('id',$prev_id);
		}
		else
		{ $is_reauth = false;}
		$preauth_rec->preauth_status = 'Approved';

		$hospital_rec = $this->hospital->find($preauth_rec->hospital_id);
		$person_rec = $this->person->find($preauth_rec->person_id);
        	if($person_rec->age == 0)
        	{
        		$today = date('m/d/Y');
        		$dob = date('m/d/Y',strtotime($person_rec->date_of_birth));
        		$date_parts1=explode("/", $dob);
        		$date_parts2=explode("/", $today);
        		$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
        		$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
        		$age =round(($end_date - $start_date)/365);
        	}
		else { $age = $person_rec->age;}
			$house_id = $this->household->find_by('policy_id',$preauth_rec->policy_id);
	        $hof_person_rec = $this->person->find_by('household_id',$house_id->id);
		$hof_name = $hof_person_rec->full_name;
		$village = $this->village_citie->get_name($house_id->village_city_id);

		$doctor_rec = $this->claim_doctor->find($preauth_rec->claim_review_doctor_id);

                $csv = '';
		$csv = $preauth_rec->date.',,'.$preauth_rec->preauth_form_number.','.$preauth_rec->policy_id.','.$hof_name.','.$village.','.$person_rec->full_name.','.$age.','.$person_rec->gender.','.$person_rec->relation.','.$hospital_rec->name.','.$hospital_rec->city_or_village.',,'.$this->config->item('primary_insurer').','.$preauth_rec->expected_stay_duration.','.$preauth_rec->expected_cost.','.$preauth_rec->comments.','.$preauth_rec->current_diagnosis.',,"'.$doctor_rec->sig_file_name.'",'.$doctor_rec->name ;
		if($is_reauth)
		{
			$csv = $csv.','.$prev_preauth_rec->expected_cost.','.$prev_preauth_rec->expected_stay_duration.','.$prev_preauth_rec->date.','.($prev_preauth_rec->expected_cost + $preauth_rec->expected_cost);
			$template_file = $this->config->item('reauth_template');
		}
		else
		{
			$template_file = $this->config->item('preauth_template');
		}
		$fname = $pre_auth_id.'.pdf';
		$pdf_file = $this->config->item('base_path').'uploads/preauths/'.$fname;
		$csv_file = $this->config->item('base_path').'uploads/preauths/'.$pre_auth_id.'.csv';
		$cmd = '/usr/bin/glabels-batch -i '.$csv_file.' -o '.$pdf_file.' '.$template_file; 
		$fp = fopen($csv_file,"w");
		fwrite($fp, $csv);
		fclose($fp);
		$result1 = shell_exec($cmd);

		

		$msg_type = '';
		$result2 = $preauth_rec->save();
		if($result1 and $result2)
		{
			$msg_type = 'success';
			$this->session->set_flashdata('msg_type', 'success');
			$this->session->set_flashdata('msg', 'Preauth is approved');
	     		redirect('/hospitalization/preautherization/download_file/'.$fname.'/'.$preauth_rec->policy_id);	
		}
		else
		{
			$msg_type = 'error';
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Preauth is not approved glabels_exec = '.$result1.' record save = '.$result2);
	    		redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);
		}
		
		//$this->load->view('hospitalization/show_preauth_lookup_response', $data);
	}
	
    function download_file ($filename = '', $policy_id = '')
    {
	$this->data['filename'] = $filename;
	$this->data['policy_id'] = $policy_id;
	$this->load->view('hospitalization/preauth_form_download',$this->data);					
    }

	function save_release_status($pre_auth_id = 0) {		
		$this->validate_id($pre_auth_id, 'preauthorization');		
		$preauth_rec = $this->pre_auth->find($pre_auth_id);
		
//    $this->db->trans_start();
    $tx_status = true;
    $this->db->trans_begin();
		$preauth_rec->preauth_status = 'Released';
		$release_amount = $preauth_rec->expected_cost;
		$this->load->model('admin/policy_model','policy_model');
		$member_policy_rec = $this->policy_model->find($preauth_rec->policy_id);			
		$member_policy_rec->blocked_amount = $member_policy_rec->blocked_amount - $release_amount; 	
		$member_policy_rec->available_amount = $member_policy_rec->available_amount + $release_amount;
		$tx_status = $tx_status AND $member_policy_rec->save();

	//	$member_policy_rec = $this->member_policy_detail->find_by('policy_id',$preauth_rec->policy_id);
		$tx_status = $tx_status AND $preauth_rec->save();
    if($tx_status == true)
    {
       $this->db->trans_commit();
    }
    else {
       $this->db->trans_rollback();
       return false;
    }
//    $this->db->trans_complete();
		
		redirect('/hospitalization/policy_details/show_policy_details/'.$preauth_rec->policy_id);
	}

   public function intimate_bc ($preauth_id = '')
   {
	$preauth_rec = $this->pre_auth->find($preauth_id);
	$policy_rec = $this->policy_model->find($preauth_rec->policy_id);
	$person_rec = $this->person->find($preauth_rec->person_id);
	$this->load->library('ipd/Raksha');
	$url = Raksha::get_intimation_url();
	$url = $url.'?'.urlencode('Memberid').'='.urlencode($policy_rec->backend_member_id).'&'.urlencode('disease').'='.urlencode($preauth_rec->chief_complaint);
	redirect($url);
   }

   public function update_claim_id()
   {
	$preauth_id = $_POST['preauth_id'];
	$insurer_claim_id = $_POST['insurer_claim_id'];

	$preauth_rec = $this->pre_auth->find($preauth_id);

	$hos_rec = $this->hospitalization->new_record();
	$hos_rec->policy_id = $preauth_rec->policy_id;
	$hos_rec->person_id = $preauth_rec->person_id;
	$hos_rec->hospitalization_date= $preauth_rec->date;
	$hos_rec->last_preauth_id= $preauth_rec->id;
	$hos_rec->hospital_id= $preauth_rec->hospital_id;
	$hos_rec->chief_complaint= $preauth_rec->chief_complaint;
	$hos_rec->detail_complaint= $preauth_rec->detail_complaint;
	$hos_rec->current_diagnosis= $preauth_rec->current_diagnosis;
	$hos_rec->comments= $preauth_rec->procedure;
	$hos_rec->procedure= $preauth_rec->procedure;
	$hos_rec->status= 'Admitted';
$this->db->trans_begin();
$tx_status = true;
	if(!$hos_rec->save())
	{
		$msg = 'Error creating new hospitalization record';
		$tx_status = false;
	}

	$preauth_rec->hospitalization_id = $hos_rec->id;
	$preauth_rec->preauth_status= 'Admitted';
	if(!$preauth_rec->save())
	{
		$msg = 'Error updating preauth record';
		$tx_status = false;
	}


	$bc_rec = $this->backend_claim->new_record();
	$bc_rec->status= 'Not Filed';
	$bc_rec->hospitalization_id = $hos_rec->id;
	$bc_rec->insurer_claim_id = $insurer_claim_id;
	$bc_rec->policy_id = $preauth_rec->policy_id;
	if(!$bc_rec->save())
	{
		$msg = 'Error creating backend claim record';
		$tx_status = false;
	}

    	if($tx_status == true)
    	{
    	   	$this->db->trans_commit();
		$this->session->set_flashdata('msg_type', 'success');
		$this->session->set_userdata('msg', 'Hospitalization and Backend Claim created. Insurer Claim Id successfully updated for preauth id '.$preauth_id);
	   	redirect('/hospitalization/policy_details/show_policy_details/'.$preauth_rec->policy_id);
		return true;
    	}
    	else {
       		$this->db->trans_rollback();
		$this->session->set_flashdata('msg_type', 'error');
		$this->session->set_userdata('msg', $home_msg);
	   	redirect('/hospitalization/policy_details/show_policy_details/'.$preauth_rec->policy_id);
       		return false;
    	}
   }
}
