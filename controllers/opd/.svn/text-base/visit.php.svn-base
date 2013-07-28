<?php

// TODO - the following require_once should not be required
//require_once(APPPATH.'controllers/opd/opd_base_controller.php');
include_once(APPPATH.'libraries/plsp/mne/mnepisphelper.php');
include (APPPATH.'libraries/CustomTree.php');
class Visit extends Opd_base_controller {
  private $data = array();
  private $username = false;
  function __construct() {
    parent::__construct();
    $this->load->model('demographic/person_model', 'person');
    $this->load->model('demographic/household_model', 'household');
    $this->load->model('geo/village_citie_model', 'village_citie');
    $this->load->model('geo/street_model','street');
    $this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
    $this->load->model('opd/visit_model', 'visit');
    $this->load->model('opd/visit_ros_entry_model', 'visit_ros_entry');
    $this->load->model('opd/visit_physical_exam_entry_model', 'visit_physical_exam_entry');
    $this->load->model('opd/visit_vital_model', 'visit_vital');
    $this->load->model('opd/visit_diagnosis_entry_model', 'visit_diagnosis_entry');
    $this->load->model('opd/visit_medication_entry_model', 'visit_medication_entry');
    $this->load->model('opd/visit_opdproduct_entry_model', 'visit_opdproduct_entry');
    $this->load->model('opd/visit_service_entry_model', 'visit_service_entry');
    $this->load->model('opd/visit_referral_entry_model', 'visit_referral_entry');
    $this->load->model('opd/visit_test_entry_model', 'visit_test_entry');
    $this->load->model('opd/visit_cost_item_entry_model', 'visit_cost_item_entry');
    $this->load->model('opd/visit_auscult_model', 'visit_auscult');
	$this->load->model('opd/visit_visual_model', 'visit_visual');
    $this->load->model('opd/visit_document_model', 'visit_document');
    $this->load->model('mne/forms/mne_pisp_adult_model', 'mne_pisp_adult');
    $this->load->model('mne/forms/mne_pisp_adolescent_model', 'mne_pisp_adolescent');
    $this->load->model('mne/forms/mne_pisp_child_model', 'mne_pisp_child');
    $this->load->model('mne/forms/mne_pisp_infant_model', 'mne_pisp_infant');
	$this->load->model('opd/followup_history_model','followup_hist');
    $this->load->model('opd/consumable_consumption_model', 'consumable_consumption');
    
    $this->load->model('admin/test_group_model', 'test_group');
	$this->load->model('admin/test_group_tests_model', 'test_group_tests');
	$this->load->model('admin/test_group_consumables_model', 'test_group_consumables');	

    $this->load->model('opd/visit_addendum_model', 'visit_addendum');
    $this->load->model('opd/provider_model', 'provider');
    $this->load->model('opd/provider_location_model', 'provider_location');
    $this->load->model('opd/opd_product_model', 'opd_product');
    $this->load->model('opd/consultation_types_model', 'consultation_types');
    $this->load->model('opd/test_types_model', 'test_types');
    $this->load->model('scm/product_model', 'product');
    $this->load->model('admin/opd_services_model', 'opd_services');
	$this->load->model('admin/opd_services_configuration_model', 'service_config');

    $this->load->model('opd/visit_protocol_information_entry_model', 'visit_protocol_information_entry');
     $this->load->model('opd/visit_visual_prescription_model', 'visit_visual_prescription');
    $this->load->model('chw/protocol_information_model', 'protocol_information');
    $this->load->model('chw/review_of_system_model', 'review_of_system');
    $this->load->model('chw/physical_exam_model', 'physical_exam');
    $this->load->model('chw/opd_diagnosis_model', 'opd_diagnosis');
    $this->load->model('user/users_role_model', 'user_role');
    $this->load->model('user/role_model', 'role');
    $this->load->model('user/user_model', 'user');
    $this->load->model('opd/pre_visit_values', 'pre_visit');
    $this->load->model('chw/project_model', 'project');
    $this->load->model('opd/followup_information_model','followup_info');
    $this->load->model('chw/chief_complaint_model', 'chief_complaint');
    $this->load->helper('medical');
    $this->load->helper('date');
    $this->load->dbutil();
    $this->load->library('form_validation');
    $this->load->library('utils');
    $this->load->library('date_util');
    $this->load->library('opd/problem_definition');
    $this->load->library('opd/problem_dom_displayer');
	//$this->load->helper('url');
    $this->username = $this->session->userdata('username');
  }
 
  public function home() {
        if($this->session->userdata('username')!=null) {
       	$hew_login = $this->is_logged_in_user_hew();
    	$provider = $this->provider->find_by('username', $this->username);
    	$locations = array();
    	$villages = array();
		$villages['0'] = 'All';
    	$loc_recs = $provider->related('provider_locations')->get();
    	foreach($loc_recs as $loc_rec){
			$locations[$loc_rec->id] = $loc_rec->name;
    	}
    	$this->session->set_userdata('locations',$locations);
    	if($this->session->userdata('location_id')!=null) {
			$pl_rec = $this->provider_location->find($this->session->userdata('location_id'));
			$vc_recs = $this->village_citie->find_all_by('code',$pl_rec->cachment_code);
    		foreach($vc_recs as $vc_rec){
				$villages[$vc_rec->id] = $vc_rec->name;
    	  	}
    	}else{
    		foreach($loc_recs as $loc_rec){
				$pl_rec = $this->provider_location->find($loc_rec->id);
				$vc_recs = $this->village_citie->find_all_by('code',$pl_rec->cachment_code);
    			foreach($vc_recs as $vc_rec){
					$villages[$vc_rec->id] = $vc_rec->name;
    	  		}
			}
			$vc_recs = $this->village_citie->find_all_by('code','ALL');
    		foreach($vc_recs as $vc_rec){
				$villages[$vc_rec->id] = $vc_rec->name;
    		}
		}
		$street_lists = $this->street->find_all();
		$data['street_lists']=$street_lists;
		$data['villages'] = $villages;
		$data['scm_orgs'] = $this->get_scm_orgs();
		if($hew_login){
			$this->load->view('opd/hew_home',$data);
			return;
		}
    	$this->load->view('opd/doc_home',$data);
    	} else {
      		redirect('/session/session/login');
    	}
  }

  function get_scm_orgs() {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( 'scm_organizations' );
		$o_rows = $o_obj->find_all ();
		foreach ( $o_rows as $o_row ) {
			$orgs [$o_row->id] = $o_row->name;
		}
		return $orgs;
  }
  
  public function is_logged_in_user_hew(){
  	$user_rec = $this->user->find_by('username' ,$this->username);
  	$user_role_rec = $this->user_role->find_all_by('user_id',$user_rec->id );
  	$hew_login = true;
  	foreach($user_role_rec as $user_role){
  		$role_rec = $this->role->find_by('id', $user_role->role_id);
  		if($role_rec->name == "Clinician" || $role_rec->name == "Lab Technician" || $role_rec->name=="admin" ){
  			$hew_login = false;
  			break;
  		}
  	}

  	return $hew_login;
  }
  
  public function select_locn(){
    	$this->session->set_userdata('location_id',$_POST['provider_location_id']);
    	$locn_rec = $this->provider_location->find($_POST['provider_location_id']);
    	$this->session->set_userdata('location_type',$locn_rec->type);
    	$this->session->set_userdata('msg','Provider Location is a '.$locn_rec->type.' with location id: '.$_POST['provider_location_id']);
		if($locn_rec->type == 'Lab')
	      	redirect('/opd/lab/home');
		else
	      	redirect('/opd/visit/home');
  }
  
  public function add_basic($person_id,$policy_id) {
    log_message("debug", "L1");
    $visit_type = $this->uri->segment(5, "general");
    if (!$visit_type)
      $visit_type = "General";
    $this->add_basic_visit($person_id, $policy_id, $visit_type, false, null);
  }

  private function add_basic_visit($person_id, $policy_id, $visit_type, $is_followup, $followup_to_visit_id) {
    log_message("debug", "L2");
    $this->validate_id($person_id, 'person');
    // TODO - Factor this username check out of here and into a codeigniter filter
    // TODO - Some of it could be factored into the controller constructor
    if (!$this->username) {
      $this->session->set_flashdata('msg_type', 'error');
      $this->session->set_flashdata('msg', 'User must be logged in');
      redirect('session/session/login');
    }
	
    if (!$this->session->userdata('location_id')) {
      $this->session->set_flashdata('msg_type', 'error');
      $this->session->set_flashdata('msg', 'Location must be chosen before adding visit');
      redirect('opd/visit/home');
    }
    $location_id = $this->session->userdata('location_id');

    $provider = $this->provider->find_by('username', $this->username);

    $this->data['person'] = $this->person->find($person_id);
    $this->data['policy_id'] = $policy_id;
    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['provider'] = $provider;
    $this->data['provider_locations'] = $provider->related('provider_locations')->get();
    $pl_rec = $this->provider_location->find($location_id);
    $this->data['provider_location'] = $pl_rec;
    $this->data['visit_type'] = $visit_type;

    if ($is_followup)
      $this->data['followup_to_visit_id'] = $followup_to_visit_id;
    else
      $this->data['followup_to_visit_id'] = 0;

    $this->data['displayer'] = $this->problem_dom_displayer;

    $this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
    $prod_stocks =  $this->stock->where('location_id',$pl_rec->scm_org_id,false)
				->where('quantity >','0',false)
				->find_all();

    $this->data['product_stocks'] = $prod_stocks;

    $this->data['opd_product_list'] = $this->opd_product->find_all();
    $this->data['consultation_types'] = $this->consultation_types->find_all();
    $this->data['test_types'] = $this->test_types->find_all();//('type', 'OPD');

//    $this->data['projects'] = $this->project->find_all();

    if (!$_POST) {
      $this->load->view('opd/new_basic_visit_req', $this->data);
      return;
    }

    log_message("debug", "Visit form submitted");

    // Required patient, provider, location and date
    $this->form_validation->set_rules('provider_id', 'Provider', 'required');
    $this->form_validation->set_rules('provider_location_id', 'Location', 'required');
    $this->form_validation->set_rules('date', 'Date', 'required');
    $this->form_validation->set_error_delimiters('<label class="error">', '</label>');

    log_message("debug", "Validating the inputs");
    if ($this->form_validation->run())
      log_message("debug", "Form inputs validated");
    else
      log_message("debug", "Validation check failed");

    $visit_type = $_POST['visit_type'];

    if ($this->form_validation->run()
        && ($visit_id = $this->save_basic($person_id, $policy_id,$visit_type))) {
      $this->session->set_flashdata('msg_type', 'success');
      $this->session->set_flashdata('msg', 'Visit '.$visit_id.' successfully added');
      redirect('opd/visit/show_basic/'.$visit_id.'/'.$policy_id);
    }
    log_message("debug", "Unable to save to the database");


    $this->session->set_flashdata('msg_type', 'error');
    $this->session->set_flashdata('msg', 'Error adding new visit');
    
    $this->load->view('opd/new_basic_visit_req', $this->data);
  }

  private function save_basic($person_id, $policy_id, $visit_type) {
    // TODO: Use of obstetric and pediatric flags to create/ save corresponding
    // records
    // TODO - singular or plural visit?
    // TODO - Add transactions here

    $tx_status = true;
    $this->db->trans_begin();
    $new_visit = $this->visit->new_record($_POST);
    if ($new_visit->chief_complaint == "Other")
      $new_visit->chief_complaint = $_POST["chief_complaint_other"];
    $new_visit->policy_id = $policy_id;
    $new_visit->type= $visit_type;
    $new_visit->chw_followup_id = $this->session->userdata('chw_f_id');

    log_message("debug", "Got visit <date = ".$new_visit->date.", provider = ".$new_visit->provider_id);

    if (!$new_visit->save()) {
      $home_message = 'Unable to save the visit';
      $this->session->set_userdata('msg', $home_message);
      $tx_status = false;
    }
	
    $new_visit_vital = $this->visit_vital->new_record($_POST);
    $new_visit_vital->visit_id = $new_visit->id;
    $new_visit_auscult = $this->visit_auscult->new_record($_POST);
    $new_visit_auscult->visit_id = $new_visit->id;
	$new_visit_visual = $this->visit_visual->new_record($_POST);
    $new_visit_visual->visit_id = $new_visit->id;
    
    if ( (!$new_visit_vital->save()) || (!$new_visit_auscult->save()) || (!$new_visit_visual->save())) {
      $home_message = 'Unable to save the visit vitals/auscult/visual';
      $this->session->set_userdata('msg', $home_message);
      $tx_status = false;
    }


    $t_array = array();
    foreach ($_POST["tests"] as $test) {
      if (isset($test["status"]) && $test["status"] != "NA") {
	$t_entry = $this->visit_test_entry->new_record($test);
	$t_entry->visit_id = $new_visit->id;
	if(!$t_entry->save()) {
      $home_message = 'Unable to save test_entry';
      $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
	}
	
	$t_array[$test["index"]] = $t_entry;
      }
    }

    foreach (explode(",", $_POST["differential_diagnosis"]) as $diagnosis) {
      $diagnosis_entry = $this->visit_diagnosis_entry->new_record();
      $diagnosis_entry->diagnosis = trim($diagnosis);
      $diagnosis_entry->visit_id = $new_visit->id;
      if(!$diagnosis_entry->save()) {
      $home_message = 'Unable to save diagnosis_entry';
      $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
	}
    }

    $m_array = array();
    foreach ($_POST["medication"] as $medication) {
      $m_entry = $this->visit_medication_entry->new_record($medication);
      $m_entry->visit_id = $new_visit->id;
      if(!$m_entry->save()){
	      $home_message = 'Unable to save medicine_entry';
	      $this->session->set_userdata('msg', $home_message);
	  	  $tx_status = false;
		}

      $m_array[$medication["index"]] = $m_entry;
    }

    foreach (explode(",", $_POST["referrals"]) as $speciality) {
      $referral_entry = $this->visit_referral_entry->new_record();
      $referral_entry->speciality = trim($speciality);
      $referral_entry->visit_id = $new_visit->id;
      if(!$referral_entry->save()){
      $home_message = 'Unable to save referral_entry';
      $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
	}
    }

    log_message("debug", "trying to add cost_items");

// Adding consultation entry
    $cost_items = $_POST["cost_items"];
    $cost_item = $cost_items[0];
    $c_entry = $this->visit_cost_item_entry->new_record($cost_item);
    $c_entry->rate = $cost_item["rate"];
    $c_entry->number = $cost_item["number"];
    $c_entry->cost = $c_entry->number * $c_entry->rate;
    $c_entry->visit_id = $new_visit->id;
    if(!$c_entry->save()){
      $home_message = 'Unable to save consultation cost_entry';
      $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
	}

// Adding drug entries
    for ($i=1; $i<=20; $i++)
    {
      $cost_item = $cost_items[$i];
      $c_entry = $this->visit_cost_item_entry->new_record($cost_item);
      // TODO(arvind): Is the following condition good enough?
      if (!isset($c_entry->subtype) || ($c_entry->subtype === "") || $c_entry->number < 1)
	continue;

       $c_entry->rate = $cost_item["rate"];
       $c_entry->number = $cost_item["number"];
       $c_entry->cost = $c_entry->number * $c_entry->rate;
       $c_entry->visit_id = $new_visit->id;
       
       if(!$c_entry->save()){
      $home_message = 'Unable to save medicine cost_entry';
      $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
	}
       
       $c_type = $c_entry->type;
       $index = $cost_item["index"];
	 $c_id = $c_entry->id;
	 $entry = null;
	   $entry = $m_array[$index];
	 $entry->visit_cost_item_entry_id = $c_id;
	 if(!$entry->save()){
      $home_message = 'Unable to save medicine cost_entry';
      $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
	}

   }

// Adding test entries
    for ($i=21; $i<=50; $i++)
    {
      $cost_item = $cost_items[$i];
      $c_entry = $this->visit_cost_item_entry->new_record($cost_item);
      // TODO(arvind): Is the following condition good enough?
      if (!isset($c_entry->subtype) || ($c_entry->subtype === "") || $c_entry->number < 1)
	continue;

       $c_entry->rate = $cost_item["rate"];
       $c_entry->number = $cost_item["number"];
       $c_entry->cost = $c_entry->number * $c_entry->rate;
       $c_entry->visit_id = $new_visit->id;
       
       if(!$c_entry->save()){
      $home_message = 'Unable to save test cost_entry';
      $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
	}
       
       $c_type = $c_entry->type;
       $index = $cost_item["index"];
	 $c_id = $c_entry->id;
	 $entry = null;
	   $entry = $t_array[$index];
	 $entry->visit_cost_item_entry_id = $c_id;
	if(! $entry->save()){
      $home_message = 'Unable to save test cost_entry';
      $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
	}
    } 

    $this->session->unset_userdata('chw_f_id');
    if($tx_status == true)
    {
       $this->db->trans_commit();
    return $new_visit->id;
    }
    else {
       $this->db->trans_rollback();
       return false;
    }
  }

  public function show_basic($visit_id, $policy_id = '') {
    $this->validate_id($visit_id, 'visit');
    $visit_rec = $this->visit->find($visit_id);    

    if ($policy_id == '')
    {
	$policy_id = $visit_rec->policy_id;	
    }

    $this->data['visit'] = $visit_rec;    
    if($visit_rec->chw_followup_id !=0)
    {
      $this->load->model('chw/followup_model', 'c_followup' );
      $f_rec = $this->c_followup->find($visit_rec->chw_followup_id);    
      $this->data['chw_id'] = $f_rec->chw_id;    
      $this->load->model('chw/chw_model', 'chw' );
      $this->data['chw_name'] = $this->chw->find($f_rec->chw_id)->name;    
    }
    else
    {
      $this->data['chw_id'] = 0;    
    }
    
    $this->data['policy_id'] = $policy_id;    
    $this->data['person'] = $this->person->find($this->data['visit']->person_id);
    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['displayer'] = $this->problem_dom_displayer;

    $this->data['test_types'] = $this->test_types->find_all();
    $this->load->view('opd/show_basic_visit', $this->data);
  }

  //Add Pre-consulation access to HEW
  public function add_preconsultation_visit($person_id,$policy_id, $visit_type ='General') {
  	log_message("debug", "L1");
  	if (!$visit_type)
  		$visit_type = "General";  	
  	
  	$hew_login = $this->is_logged_in_user_hew();
  	if(!$hew_login)
  		return;
  	
  	$recent_visit_rec = null;
  	$visit_visuals_rec = null;
  	$recent_visit_array =$this->visit->where('person_id',$person_id,false)->order_by('date','DESC')->limit(1)->find_all();  	
  	foreach ($recent_visit_array as $rec){
  		$recent_visit_rec = $rec;  		
  	}
  	if(isset($recent_visit_rec)){
  		$visit_visuals_rec = $this->visit_visual->find_by('visit_id',$recent_visit_rec->id);
  		$visit_vitals_rec = $this->visit_vital->find_by('visit_id',$recent_visit_rec->id);
  	}
  	if(isset($visit_visuals_rec)){
  		$visit_date =  $recent_visit_rec->date;
  		$visit_date_breakdown = explode("-", $visit_date);
  		$current_year =  date("Y") ;
  		$current_month = date ("m");
  		$months = ($current_year - $visit_date_breakdown[0]) * 12;
  		$months -= $visit_date_breakdown[1] + 1;
  		$months += $current_month;
  		
  		$actual_months = $months + 1;
  		if($actual_months <= 6){
  			$this->data['vision_within_6_months'] = $visit_visuals_rec;
  			$this->data['vital_within_6_months'] = $visit_vitals_rec;
  		}
  		$this->data['person_height'] = $visit_vitals_rec->height_cm;
  	}  	
  	
  	
  	$this->add_visit($person_id, $policy_id, $visit_type, false, null,null);
  }
  
  // visit_type can be "general", "diagnostic", "obstetric" and "pediatric"
  public function add($person_id,$policy_id, $visit_type ='General') {  	
    log_message("debug", "L1");
    if (!$visit_type)
      		$visit_type = "General";
	$hew_login = $this->is_logged_in_user_hew();
  	if($hew_login)
  		return;
	
  	$visit = null;    
  	$preconsulted_visit_rec =$this->visit->where('person_id',$person_id,false)->where('valid_state','"Pre-consulted"',false)
  								   ->where('date',date("Y-m-d"))
  									->order_by('date','DESC')->limit(1)->find_all();
  	foreach ($preconsulted_visit_rec as $rec){
  		$visit = $rec;
  	}
	
    $this->add_visit($person_id, $policy_id, $visit_type, false, null,$visit);
  }

  public function add_followup_visit($followup_to_visit_id, $policy_id) {
    $this->validate_id($followup_to_visit_id, 'visit');
    $person_id = $this->visit->find($followup_to_visit_id)->person_id;
    $this->add_visit($person_id, $policy_id, "Followup", true, $followup_to_visit_id,null);
  }

  private function add_visit($person_id, $policy_id, $visit_type, $is_followup, $followup_to_visit_id, $visit) {

    log_message("debug", "L2");
	$begin_time = time();
    $this->validate_id($person_id, 'person');

    // TODO - Factor this username check out of here and into a codeigniter filter
    // TODO - Some of it could be factored into the controller constructor
    if (!$this->username) {
      $this->session->set_flashdata('msg_type', 'error');
      $this->session->set_flashdata('msg', 'User must be logged in');
      redirect('session/session/login');
    }

    if (!$this->session->userdata('location_id')) {
      $this->session->set_flashdata('msg_type', 'error');
      $this->session->set_flashdata('msg', 'Location must be chosen before adding visit');
      redirect('opd/visit/home');
    }
    $location_id = $this->session->userdata('location_id');
    
    //To get preconsulted visit id
    if(isset($visit->id)){
    	$this->data['preconsulted_visit_id'] = $visit->id;
    }
    
    $opd_diagnosis_list=$this->opd_diagnosis->find_all(); 
    $this->data['opd_diagnosis_list'] = $opd_diagnosis_list;

    $chief_complaint_list=$this->chief_complaint->order_by('value')->find_all(); 
    $this->data['chief_complaint_list'] = $chief_complaint_list;
    
	//populate tree for ROS,PE and Protocol information
    $this->data['protocol_information_tree'] = $this->protocol_information->get_tree();                          
    $this->data['physical_exam_tree'] = $this->physical_exam->get_tree();   
    $this->data['review_of_system_tree'] = $this->review_of_system->get_tree();    
   
    if(isset($visit)){
    	$visit_vital_rec = $this->visit_vital->find_by('visit_id',$visit->id);
    	$visit_visuals_rec = $this->visit_visual->find_by('visit_id',$visit->id);
    	$this->data['is_pregnant'] = $visit_vital_rec->is_pregnant;
    }
    
    $visit_data = "";
    
    $provider = $this->provider->find_by('username', $this->username);
	$pispHelper = new MnePispHelper();
	$pisp_sum = $pispHelper->get_latest_pisp_response($person_id);	
	
	$hew_login = $this->is_logged_in_user_hew();
	if(isset($pisp_sum['risk'])){
		$risk_factor = $pisp_sum['risk'];
		$this->data['risk'] = $risk_factor;
	}
	
	if (isset($visit)){
		$visit_data = $this->pre_visit->form_preconsultation_object($visit_vital_rec,$visit->date,$visit_visuals_rec);
	}else{
		$visit_data = $this->pre_visit->form_pisp_object($pisp_sum);
	}	

	if(empty($visit_data))
		$visit_data = $this->pre_visit->form_blank_object();
	
	$hew_login = $this->is_logged_in_user_hew();
	$this->load->model('survey/plsp/plsp_config_model', 'plsp_config');
	$threshold_values = $this->plsp_config->get_config_map();
	
	$this->data['pisp']=$visit_data;	
    $this->data['person'] = $this->person->find($person_id);
    $this->data['policy_id'] = $policy_id;
    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['provider'] = $provider;
    $this->data['provider_locations'] = $provider->related('provider_locations')->get();
    $pl_rec = $this->provider_location->find($location_id);
    $this->data['provider_location'] = $pl_rec;
    $this->data['visit_type'] = $visit_type;
    $this->data['hew_login'] = $hew_login;
    
    $person_rec = $this->person->find($person_id);
    $current_year =  date("Y") ;
    $dob = $person_rec->date_of_birth;
    $year = explode("-", $dob);
    $this->data['person_age'] = $current_year - $year[0];
    
    $this->data['infant_threshold_age'] =  $threshold_values['dataInfantThresholdAge'];
    $this->data['bp_threshold_age'] =  $threshold_values['dataBPThresholdAge'];
    $this->data['wh_threshold_age'] =  $threshold_values['dataWHRatioThresholdAge'];
    $this->data['pregnant_threshold_age'] =  $threshold_values['dataPregnantThresholdAge'];
    $this->data['vision_threshold_age'] =  $threshold_values['dataVisionThresholdAge'];
    
    
    if ($is_followup)
      $this->data['followup_to_visit_id'] = $followup_to_visit_id;
    else
      $this->data['followup_to_visit_id'] = 0;
	
    $this->data['displayer'] = $this->problem_dom_displayer;

    $this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
    $prod_stocks =  $this->stock->where('location_id',$pl_rec->scm_org_id,false)
				->where('quantity >','0',false)
				->find_all();
  	$unique_products = array();
    foreach($prod_stocks as $query){
    	$unique_products[$query->product_id]=$query->product_id;
    }
    $this->data['product_stocks'] = array_unique($unique_products);
	$this->data['product_batch_details'] =$prod_stocks;
    $this->data['opd_service_list'] = $this->opd_services->find_all_by('status',1);
    $this->data['opd_product_list'] = $this->opd_product->find_all();
    $this->data['consultation_types'] = $this->consultation_types->find_all();
    $this->data['test_types'] = $this->test_types->where('is_test_enabled',1)->find_all();//('type', 'OPD');
    $lab_recs = $this->provider_location->find_all_by('type','Lab');//('type', 'Lab');
    $labs = array();
    foreach($lab_recs as $lab_rec){
		$labs[$lab_rec->id] = $lab_rec->name;
    }
    $this->data['labs'] = $labs;
	$this->data['begin_time']=$begin_time;
    $this->data['projects'] = $this->project->find_all();

    if (!$_POST) {
      $this->load->view('opd/new_visit_req', $this->data);
      return;
    }    
    log_message("debug", "Visit form submitted");

    // Required patient, provider, location and date
    $this->form_validation->set_rules('provider_id', 'Provider', 'required');
    $this->form_validation->set_rules('provider_location_id', 'Location', 'required');
    $this->form_validation->set_rules('date', 'Date', 'required');
    $this->form_validation->set_error_delimiters('<label class="error">', '</label>');

    log_message("debug", "Validating the inputs");
    if ($this->form_validation->run())
      log_message("debug", "Form inputs validated");
    else
      log_message("debug", "Validation check failed");

    $visit_type = $_POST['visit_type'];

    if ($this->form_validation->run() && ($visit_id = $this->save($person_id, $policy_id,$visit_type))) {
      $this->session->set_flashdata('msg_type', 'success');
      if($hew_login)
      	$this->session->set_flashdata('msg', 'Preconsultation '.$visit_id.' successfully added');
      else
      	$this->session->set_flashdata('msg', 'Visit '.$visit_id.' successfully added');
      if($hew_login)
      	redirect('opd/visit/show_preconsultation/'.$visit_id.'/'.$policy_id);
      else 
      	redirect('opd/visit/show/'.$visit_id.'/'.$policy_id);
    }
    log_message("debug", "Unable to save to the database");


    $this->session->set_flashdata('msg_type', 'error');
    $this->session->set_flashdata('msg', 'Error adding new visit');
    
    // The following would have been more relevant if add_visit was an Ajax
    // thing
    // $this->load->view('opd/add_visit_resp.xml', $visit_id);
    // TODO - Explore use of XML-RPC for sending out XML responses

    $this->load->view('opd/new_visit_req', $this->data);
  }

  public function test_pisp(){
	$pispHelper = new MnePispHelper();
	$pisp_sum = $pispHelper->get_latest_pisp_response(2055000);
  }
  public function edit_visit($visit_id, $policy_id) {

    log_message("debug", "L2");
    $this->validate_id($visit_id, 'visit');

    // TODO - Factor this username check out of here and into a codeigniter filter
    // TODO - Some of it could be factored into the controller constructor
    if (!$this->username) {
      $this->session->set_flashdata('msg_type', 'error');
      $this->session->set_flashdata('msg', 'User must be logged in');
      redirect('session/session/login');
    }

    if (!$this->session->userdata('location_id')) {
      $this->session->set_flashdata('msg_type', 'error');
      $this->session->set_flashdata('msg', 'Location must be chosen before editting visit');
      redirect('opd/visit/home');
    }
    $location_id = $this->session->userdata('location_id');

    $provider = $this->provider->find_by('username', $this->username);
     $chief_complaint_list=$this->chief_complaint->find_all(); 
    $this->data['chief_complaint_list'] = $chief_complaint_list;
    
    $opd_diagnosis_list=$this->opd_diagnosis->find_all(); 
    $this->data['opd_diagnosis_list'] = $opd_diagnosis_list;
    $this->data['protocol_information_tree'] = $this->protocol_information->get_tree();                          
    $this->data['physical_exam_tree'] = $this->physical_exam->get_tree();   
    $this->data['review_of_system_tree'] = $this->review_of_system->get_tree();

    $visit_rec = $this->visit->find($visit_id);
    $this->data['visit_obj'] = $visit_rec;
    $this->data['visit_diagnosis'] = $visit_rec->related('visit_diagnosis_entries')->get();
    //$this->data['visit_auscult'] = $visit_rec->related('visit_auscult')->get();
    $this->data['visit_ros'] = $visit_rec->related('visit_ros_entries')->get();
    $this->data['visit_pes'] = $visit_rec->related('visit_physical_exam_entries')->get();
    $visit_vital_rec = $this->visit_vital->find_by('visit_id',$visit_id);
    $visit_visuals_rec = $this->visit_visual->find_by('visit_id',$visit_id);
    
    $this->data['visit_protocol'] = $visit_rec->related('visit_protocol_information_entries')->get();
    
    $this->data['person'] = $this->person->find($visit_rec->person_id);
    $this->data['policy_id'] = $policy_id;
    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['provider'] = $provider;
    $this->data['provider_locations'] = $provider->related('provider_locations')->get();
    $pl_rec = $this->provider_location->find($location_id);
    $this->data['provider_location'] = $pl_rec;
    $this->data['visit_type'] = $visit_rec->type;
    $this->data['followup_to_visit_id'] = $visit_rec->followup_to_visit_id;

    $this->data['displayer'] = $this->problem_dom_displayer;
    //$this->data['visit_auscult'] = $visit_rec->related('visit_auscult')->get();
//    $this->data['test_types'] = $this->test_types->find_all();//('type', 'OPD');

    
    $visit_data = "";
	$visit_data = $this->pre_visit->form_preconsultation_object($visit_vital_rec,$visit_rec->date,$visit_visuals_rec);
    
    $this->data['pisp']=$visit_data;
    $hew_login = $this->is_logged_in_user_hew();
    $this->data['hew_login'] = $hew_login;
    
    if (!$_POST) {
      $this->load->view('opd/edit_visit_req', $this->data);
      return;
    }

    log_message("debug", "Visit form submitted");

    // Required patient, provider, location and date
    $this->form_validation->set_rules('provider_id', 'Provider', 'required');
    $this->form_validation->set_rules('provider_location_id', 'Location', 'required');
    $this->form_validation->set_error_delimiters('<label class="error">', '</label>');

    log_message("debug", "Validating the inputs");
    if ($this->form_validation->run())
      log_message("debug", "Form inputs validated");
    else
      log_message("debug", "Validation check failed");

    $visit_type = $_POST['visit_type'];

    //echo $this->edit_save($visit_id,$policy_id,$visit_type);
    //return;
    if ($this->form_validation->run()
        && ($this->edit_save($visit_id,$policy_id,$visit_type))) {
      $this->session->set_flashdata('msg_type', 'success');
      $this->session->set_flashdata('msg', 'Visit '.$visit_id.' successfully edited');
      redirect('opd/visit/show/'.$visit_id.'/'.$policy_id);
    }else{
    	log_message("debug", "Unable to save to the database");
	    $this->session->set_flashdata('msg_type', 'error');
    	$this->session->set_flashdata('msg', 'Error adding new visit');
    	redirect('opd/visit/show/'.$visit_id.'/'.$policy_id);
    }
  }
  
  public function edit_preconsultation($visit_id, $policy_id){
  	$visit_rec = $this->visit->find($visit_id);
  	$visit_vital_rec = $this->visit_vital->find_by('visit_id',$visit_id);
  	$visit_visuals_rec = $this->visit_visual->find_by('visit_id',$visit_id);
  	$visit_data = $this->pre_visit->form_preconsultation_object($visit_vital_rec,$visit_rec->date,$visit_visuals_rec);
  	$location_id = $this->session->userdata('location_id');
  	$provider = $this->provider->find_by('username', $this->username);
  	$pl_rec = $this->provider_location->find($location_id);
  	$hew_login = $this->is_logged_in_user_hew();
  	$this->load->model('survey/plsp/plsp_config_model', 'plsp_config');
  	$threshold_values = $this->plsp_config->get_config_map();
  	$this->data['pisp'] = $visit_data;
  	$this->data['person'] = $this->person->find($visit_rec->person_id);
  	$this->data['policy_id'] = $policy_id;
  	$this->data['household'] = $this->data['person']->related('household')->get();
  	$this->data['provider'] = $provider;
  	$this->data['provider_locations'] = $provider->related('provider_locations')->get();  	
  	$this->data['provider_location'] = $pl_rec;
  	$this->data['visit_type'] = $visit_rec->type;
  	$this->data['hew_login'] = $hew_login;  	
  	$person_rec = $this->person->find($visit_rec->person_id);
  	$current_year =  date("Y") ;
  	$dob = $person_rec->date_of_birth;
  	$year = explode("-", $dob);
  	$this->data['person_age'] = $current_year - $year[0];
  	$this->data['is_pregnant'] = $visit_vital_rec->is_pregnant;

  	$this->data['infant_threshold_age'] =  $threshold_values['dataInfantThresholdAge'];
  	$this->data['bp_threshold_age'] =  $threshold_values['dataBPThresholdAge'];
  	$this->data['wh_threshold_age'] =  $threshold_values['dataWHRatioThresholdAge'];
  	$this->data['pregnant_threshold_age'] =  $threshold_values['dataPregnantThresholdAge'];
  	$this->data['vision_threshold_age'] =  $threshold_values['dataVisionThresholdAge'];
  	
  	if(!$_POST){
  		$this->load->view('opd/edit_preconsultation_req', $this->data);
  		return;
  	}
  	
  	$this->save_edited_preconsultation($visit_rec,$visit_vital_rec,$visit_visuals_rec);
  	redirect('opd/visit/show_preconsultation/'.$visit_id.'/'.$policy_id);
  	
  }
  
  public function save_edited_preconsultation($visit_rec,$visit_vital_rec,$visit_visuals_rec){  	
  	$visit_rec->date = date("Y-m-d");
  	$visit_rec->save();

  	// delete this record and recreate
  	$this->db->where('visit_id', $visit_rec->id);
  	$this->db->delete('visit_vitals');
  	
  	// create new record
  	$visit_vital_rec1 = $this->visit_vital->new_record($_POST);
    $visit_vital_rec1->visit_id = $visit_rec->id;
  	if(isset($_POST['pregnant'])){
	  	if($_POST['pregnant']=="Y")
	  		$visit_vital_rec1->is_pregnant = 1;
	  	else
	  		$visit_vital_rec1->is_pregnant = 0;
  	}
  	$visit_vital_rec1->save();
  	  	
  	$visit_visuals_rec->va_distance_r = $_POST['va_distance_r'];
  	$visit_visuals_rec->va_distance_l = $_POST['va_distance_l'];
  	$visit_visuals_rec->va_near = $_POST['va_near'];
  	$visit_visuals_rec->va_cataract = $_POST['va_cataract'];
  	$visit_visuals_rec->save();
  }
  
  public function show($visit_id, $policy_id = '') {
    $this->validate_id($visit_id, 'visit');
    $visit_rec = $this->visit->find($visit_id);    

    if ($policy_id == ''){
		$policy_id = $visit_rec->policy_id;	
    }

    $this->data['visit'] = $visit_rec;    
    if($visit_rec->chw_followup_id !=0){
      $this->load->model('chw/followup_model', 'c_followup' );
      $f_rec = $this->c_followup->find($visit_rec->chw_followup_id);    
      $this->data['chw_id'] = $f_rec->chw_id;    
      $this->load->model('chw/chw_model', 'chw' );
      $this->data['chw_name'] = $this->chw->find($f_rec->chw_id)->name;    
    }
    else{
      $this->data['chw_id'] = 0;    
    }
    $hew_login = $this->is_logged_in_user_hew();    
    $location_id = $this->session->userdata('location_id');
    $users_list = $this->provider->find_all_by_sql('select * from providers p,provider_location_affiliations pla where p.id=pla.provider_id and pla.provider_location_id= "'.$location_id.'" order by p.username ');
    //print_r($users_list);
    $username_array = array();
    foreach ($users_list as $prov_rec){    	
     $user_rec = $this->user->find_by('username',$prov_rec->username);
           if($user_rec && $user_rec->is_user_enable == 1){
                   $username_array[$prov_rec->username] = $user_rec->name;
           }
    }
    $followup_rec = $this->followup_info->find_by('visit_id',$visit_id);
	if (!empty($followup_rec)) {
    	$this->data['show_assign_section'] = true;
	}
    $this->data['hew_login'] = $hew_login;
    $this->data['policy_id'] = $policy_id;    
    $this->data['person'] = $this->person->find($this->data['visit']->person_id);
    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['displayer'] = $this->problem_dom_displayer;
    $this->data['username_list'] = $username_array;

    $this->data['test_types'] = $this->test_types->find_all();
    $this->load->view('opd/show_visit_resp', $this->data);
  }

  public function show_preconsultation($visit_id, $policy_id = ''){
  	$this->validate_id($visit_id, 'visit');
    $visit_rec = $this->visit->find($visit_id);    

    if ($policy_id == ''){
		$policy_id = $visit_rec->policy_id;	
    }

    $this->data['visit'] = $visit_rec;    
    if($visit_rec->chw_followup_id !=0){
      $this->load->model('chw/followup_model', 'c_followup' );
      $f_rec = $this->c_followup->find($visit_rec->chw_followup_id);    
      $this->data['chw_id'] = $f_rec->chw_id;    
      $this->load->model('chw/chw_model', 'chw' );
      $this->data['chw_name'] = $this->chw->find($f_rec->chw_id)->name;    
    }
    else{
      $this->data['chw_id'] = 0;    
    }
    $hew_login = $this->is_logged_in_user_hew();
    $this->data['hew_login'] = $hew_login;
    $this->data['policy_id'] = $policy_id;    
    $this->data['person'] = $this->person->find($this->data['visit']->person_id);
    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['displayer'] = $this->problem_dom_displayer;

    $this->data['test_types'] = $this->test_types->find_all();
    $this->load->view('opd/show_visit_preconsultation', $this->data);
  	
  }
  
  public function report_delivered($visit_id, $policy_id = '') {
    $this->validate_id($visit_id, 'visit');
    $visit_rec = $this->visit->find($visit_id);    

    if ($policy_id == ''){
		$policy_id = $visit_rec->policy_id;	
    }

    if($visit_rec->lab_report_delivered == 'No'){
		$visit_rec->lab_report_delivered = 'Yes';
		if(!$visit_rec->save())
		{
	      		$this->session->set_flashdata('msg_type', 'error');
	      		$this->session->set_flashdata('msg', 'Visit '.$visit_id.' status could not be updated. Lab report status is still undelivered');
	      		redirect('opd/visit/show/'.$visit_id.'/'.$policy_id);
		}
      	$this->session->set_flashdata('msg_type', 'success');
      	$this->session->set_flashdata('msg', 'Visit '.$visit_id.' status has been updated successfully');
      	redirect('opd/visit/show/'.$visit_id.'/'.$policy_id);
     }
     $this->session->set_flashdata('msg_type', 'error');
     $this->session->set_flashdata('msg', 'Lab report for Visit '.$visit_id.' was already delivered');
     redirect('opd/visit/show/'.$visit_id.'/'.$policy_id);
   }

  public function bill_paid($visit_id, $policy_id = '') {
  	$provider = $this->provider->find_by('username', $this->username);
    $current_provider_name=ucwords($provider->username);
  	$date= Date_util::today();
  	// to confirm if a location is selected by user
  /*	if(!($this->session->userdata('location_id'))){
	    $this->session->set_flashdata('msg_type', 'error');
  		$this->session->set_flashdata('msg', 'Location must be chosen ');
  		redirect('opd/visit/home');
	 }*/
  	$this->validate_id($visit_id, 'visit');
    $visit_rec = $this->visit->find($visit_id);    

    if ($policy_id == ''){
		$policy_id = $visit_rec->policy_id;	
    }

    if($visit_rec->bill_paid == 'No'){
		$visit_rec->bill_paid = 'Yes';
		$visit_rec->drug_dispensed= 'Yes';
		$this->db->trans_begin();
		$tx_status = true;

		if(!$visit_rec->save()){
			$tx_status = false;
		}
		//Medications Configuration
		$this->load->model('opd/visit_cost_item_entry_model', 'visit_cost_item_entry');
        $this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
      	$med_entries = $visit_rec->related('visit_medication_entries')->get();
      	  foreach ($med_entries as $m) {
      		//$save_medication=$this->stock->update_medication($med_entries);
	      	$prod = $m->related('product')->get();
	          $c = $this->visit_cost_item_entry->find($m->visit_cost_item_entry_id);
	          $pl_rec =$this->provider_location->find($visit_rec->provider_location_id);
	      	if(!$this->stock->update_medication($m,$prod,$c,$pl_rec,$tx_status)){
	      		$home_message = 'Unable to provide sufficient drugs';
	      		$tx_status = false;
	      	}
      	  }
       //OPD Products Configuration
			$opdprod_entries = $visit_rec->related('visit_opdproduct_entries')->get();
			foreach ($opdprod_entries as $opd_prod) {
		          $prod = $opd_prod->related('product')->get();
		          $c = $this->visit_cost_item_entry->find($opd_prod->visit_cost_item_entry_id);
		          $pl_rec =$this->provider_location->find($visit_rec->provider_location_id);
		          $prod_stocks = $this->stock->where('location_id',$pl_rec->scm_org_id,false)
						->where('product_id',$opd_prod->product_id,false)
						->where('quantity >','0',false)
						->order_by('expiry_date','ASC')
						->find_all();
		//          $prod = $this->product->find($entry->product_id);
				if($opd_prod->product_given_out === "yes"){
					if(!$this->stock->update_opd_product($opd_prod,$prod,$prod_stocks,$tx_status)){
	      				$home_message = 'Unable to provide sufficient OPD Products';
	      				$tx_status = false;
	      			}
		       }else{
	       		 if($prod->form != 'proc'){
	            	$quantity = $opd_prod->number/($prod->retail_units_per_purchase_unit);
	       			if(!$this->update_pending_order_table($opd_prod,$visit_rec->id,$quantity,$pl_rec->scm_org_id)){
	       				$home_message = 'Unable to add order to queue';
	        			$this->session->set_userdata('msg', $home_message);
	        			$tx_status = false;
	       			}
	       		 }
		       }
		}
		// part of code for consumable tracking moved to product batchwise stock model 
		
	  //service configuartion
	    $visit_service_entries = $visit_rec->related('visit_service_entries')->get();
	    foreach ($visit_service_entries as $visit_service) {
				$service_entries =$this->service_config->find_all_by('opd_service_id',$visit_service->service_id);
	      		foreach ($service_entries as $service) {
				  $prod =$this->product->find_by('id',$service->product_id);
		          $c = $this->visit_cost_item_entry->find($visit_service->visit_cost_item_entry_id);
		          $pl_rec =$this->provider_location->find($visit_rec->provider_location_id);
	      		$is_product_used=$this->stock->update_consumable($prod,$service->product_quantity,$pl_rec->scm_org_id);
		    	if($is_product_used==true){
		    		$comment="Consumed for Visit with Service Id=".$service->opd_service_id.' and updated by ' .$current_provider_name  ;
					$saved_value = $this->consumable_consumption->save_consumable($service->product_id,$service->product_quantity,$pl_rec->id,$visit_rec->provider_id,$date,$pl_rec->scm_org_id,$visit_id,$comment);
		        }
	      	}
		}
	
	//test group configuration
	
		$visit_test_entries =$visit_rec->related('visit_test_entries')->get();
		// $this->visit_test_entry->where('visit_id',$visit_id)->where('result !=','""')->find_all();
		$test_group_ids=array();
		$i=0;
		
	    foreach ($visit_test_entries as $visit_test) {
	    	$check_test_type=$this->test_types->find_by("id",$visit_test->test_type_id);
			if($check_test_type->type == "Strip"  ||  $check_test_type->type == "Procedure"){
				$test_entries =$this->test_group_tests->find_by('test_id',$visit_test->test_type_id);
		      	if($test_entries!= null){
					$test_group_id=$test_entries->test_group_id;
		      		$pos = in_array($test_group_id,$test_group_ids);
		      		if($pos!=true){
						array_push($test_group_ids,$test_group_id);
	                }
			     }
		      	$i=$i+1;
			}
	    }
	    foreach ($test_group_ids as $key=>$val) {
				$test_group_entries =$this->test_group_consumables->find_all_by('test_group_id',$val);
	      		foreach ($test_group_entries as $test_group) {
				  $prod =$this->product->find_by('id',$test_group->product_id);
		          $pl_rec =$this->provider_location->find($visit_rec->provider_location_id);
	      		$is_product_used=$this->stock->update_consumable($prod,$test_group->quantity_clinic,$pl_rec->scm_org_id);
		    	if($is_product_used==true){
		    		$comment="Consumed for Visit with Test Group Id=".$val.' and updated by '.$current_provider_name ;
					$saved_value = $this->consumable_consumption->save_consumable($test_group->product_id,$test_group->quantity_clinic,$pl_rec->id,$visit_rec->provider_id,$date,$pl_rec->scm_org_id,$visit_id,$comment);
		        }
	      	}
		}
	    
		
		if($tx_status == true){
			$this->db->trans_commit();
	    	$home_message = 'Status updated successfully' ;
	    	$this->session->set_userdata('msg', $home_message);
	    }else{
	       	$this->db->trans_rollback();
	    	$this->session->set_userdata('msg', $home_message);
	    }
    }

    $this->data['visit'] = $visit_rec;    
    if($visit_rec->chw_followup_id !=0){
      $this->load->model('chw/followup_model', 'c_followup' );
      $f_rec = $this->c_followup->find($visit_rec->chw_followup_id);    
      $this->data['chw_id'] = $f_rec->chw_id;    
      $this->load->model('chw/chw_model', 'chw' );
      $this->data['chw_name'] = $this->chw->find($f_rec->chw_id)->name;    
    }else{
      $this->data['chw_id'] = 0;    
    }
    $hew_login = $this->is_logged_in_user_hew();
    $this->data['policy_id'] = $policy_id;    
    $this->data['person'] = $this->person->find($this->data['visit']->person_id);
    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['displayer'] = $this->problem_dom_displayer;    
    $this->data['hew_login'] = $hew_login;

    $this->data['test_types'] = $this->test_types->find_all();
    $this->load->view('opd/show_visit_resp', $this->data);
  }

  private function update_pending_order_table($opd_prod,$visit_id,$quantity,$scm_org_id){
  	$ret_val = true;
  	$this->load->model ( 'scm/opd_products_order_queue_model', 'opd_products_order_queue');
  	$product = $opd_prod->related('product')->get();
  	$opd_prod_order_queue = $this->opd_products_order_queue->new_record();
  	$opd_prod_order_queue->visit_id = $visit_id;
  	$opd_prod_order_queue->product_id = $opd_prod->product_id;
  	$opd_prod_order_queue->generic_id=$product->generic_id;
  	$opd_prod_order_queue->quantity = $quantity;
  	$opd_prod_order_queue->location_id = $scm_org_id;
  	$opd_prod_order_queue->order_type = "Made To Order";
  	if(!$opd_prod_order_queue->save()){
        $ret_val = false;
  	}
  	return $ret_val;
  }

  public function list_visits_by_date(){
		$url = "/opd/visit/search_by_date/".$_POST['d_id_edit'];
		redirect($url);
  }


  public function search_by_date($date){
    if(isset($_POST['update_status'])){			
		$tx_status = true;
		$this->db->trans_begin();
		for($i=0; $i< $_POST['number'];$i++){
			$visit_id = $_POST['visit_id_'.$i];
			$visit_state = $_POST['valid_state_'.$i];
			$visit_rec = $this->visit->find($visit_id);
			if($visit_rec->valid_state != $visit_state){
				$visit_rec->valid_state = $visit_state;
				if(!$visit_rec->save()){	
					$tx_status = false;
    					$home_message = 'Could not update status for visit id'.$visit_rec->id.'. Please try again' ;
				}
      			$pl_rec =$this->provider_location->find($visit_rec->provider_location_id);
				$med_entries = $visit_rec->related("visit_medication_entries")->get();
      			$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
				foreach ($med_entries as $med_entry){
      			    $prod = $this->product->find($med_entry->product_id);
			      	if($prod->form != 'proc' && $med_entry->visit_cost_item_entry_id){
						$c_entry = $this->visit_cost_item_entry->find($med_entry->visit_cost_item_entry_id);
						$bal_qty = $c_entry->number/($prod->retail_units_per_purchase_unit);
						if($visit_state == 'Invalid'){ 
      						$prod_stock = $this->stock->where('location_id',$pl_rec->scm_org_id,false)
			     									  ->where('product_id',$med_entry->product_id,false)
							        				  ->order_by('expiry_date','ASC')
													  ->get();
							if($prod_stock){
					 			$prod_stock->quantity = $prod_stock->quantity + $bal_qty;
	    				 		if(!$prod_stock->save()){
	    				 			$tx_status = false;
					 				$home_message = 'Could not save product with id '.$prod_stock->product_id;}
								}			
						}else {
	      					$prod_stocks = $this->stock->where('location_id',$pl_rec->scm_org_id,false)
				     				->where('product_id',$med_entry->product_id,false)
				     				->where('quantity >','0',false)
									->order_by('expiry_date','ASC')
									->find_all();
	 	      				foreach ($prod_stocks as $prod_stock){
						  		if($bal_qty > 0){
		    				       if($prod_stock->quantity < $bal_qty){
										$bal_qty = $bal_qty - $prod_stock->quantity;
										$prod_stock->quantity = 0;
		    						}else{
	    								$prod_stock->quantity = $prod_stock->quantity - $bal_qty;
										$bal_qty = 0;
		    						}
		    						if(!$prod_stock->save()){
		    							$tx_status = false;
							 			$home_message = 'Could not save product with id '.$prod_stock->product_id;
									}			
						  		}
	    					} 
	    					if($bal_qty > 0){
	    						$tx_status = false;
						 		$home_message = 'Balance Qty > 0. Could not save product with id '.$med_entry->product_id;
						 	}
	    				}
			     	}
			  	}
		    }
		}
    	if($tx_status == true){
       		$this->db->trans_commit();
    		$home_message = 'Status updated successfully' ;
    		$this->session->set_userdata('msg', $home_message);
    	}else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $home_message);
    	}
       	redirect('opd/visit/home');
      	//$this->load->view('opd/doc_home');
	}else{
		//$q_date = $date;
    	$date_arr = explode('-',$date);
    	$change_date = mktime(0,0,0,$date_arr[1],$date_arr[0],$date_arr[2]);
    	$q_date = date('Y-m-d',$change_date);
		//$q_date = Date_util::change_date_format($date);
		$provider_rec = $this->provider->find_by('username',$this->session->userdata('username'));
		$visits_query = 'select date, visits.id as visit_id, valid_state, approved, person_id, policy_id, provider_locations.name as locn_name, paid_amount, chief_complaint, hpi, assessment from (visits cross join provider_locations) where (provider_location_id = provider_locations.id) AND (provider_id = '.$provider_rec->id.') AND (date ="'.$q_date.'") ORDER BY visits.id';
		$query = $this->db->query($visits_query);
		//echo ' date = '.$q_date.' query = '.$visits_query;
		$visit_recs[] = '';
		$i=0;
		foreach ($query->result() as $visit_rec){
           	$visit_recs[$i] = $visit_rec;
	   		$i++;
		}	
		$data['date'] = $date;
		$data['number'] = $i;
		$data['visits'] = $visit_recs;
       	$this->load->view('opd/list_visits_date',$data);
  	 }
  }

  public function audit_search($role = 'q'){
	$p_query = '';
	if($role != 'q'){
		$provider_rec = $this->provider->find_by('username',$this->session->userdata('username'));
		$p_query = 'AND (provider_id = '.$provider_rec->id.')';
	}
	$visits_query = 'select date, visits.id as visit_id, valid_state, approved, audit_status, person_id, policy_id, provider_locations.name as locn_name, paid_amount, chief_complaint, hpi, assessment from (visits cross join provider_locations) where (provider_location_id = provider_locations.id) '.$p_query.' AND (audit_status != "closed") AND (valid_state="Valid") ORDER BY visits.id';
	$query = $this->db->query($visits_query);
	$visit_recs[] = '';
	$i=0;
	foreach ($query->result() as $visit_rec){
        $visit_recs[$i] = $visit_rec;
   		$i++;
	}	
	$data['number'] = $i;
	$data['visits'] = $visit_recs;
   	$this->load->view('opd/list_visits_audit',$data);
  }

  public function show_printable($visit_id,$policy_id) {
    $this->validate_id($visit_id, 'visit');

    $visit = $this->visit->find($visit_id);    
    $this->data['doctor'] = $this->provider->join('provider_location_affiliations','providers.id=provider_location_affiliations.provider_id','inner')
                                        ->where('providers.type','Doctor')
                                        ->where('provider_location_affiliations.provider_location_id',$visit->provider_location_id)
                                        ->find();

    $this->data['visit'] = $visit;    
    if($visit->type != 'Diagnostic')
	    $this->data['sig_file_name'] = $this->user->find_by('username',$this->data['doctor']->username)->sig_file_name;  
    $this->data['policy_id'] = $policy_id;    
    $this->data['date'] = Date_util::date_display_format($visit->date);    

    $person = $this->person->find($this->data['visit']->person_id);
    $this->data['person'] = $person;
//    $today = date('Y-m-d');
    $today = time();
    $dob_parts = explode('-',$person->date_of_birth);
    $dob = mktime(0,0,0,$dob_parts[1],$dob_parts[2],$dob_parts[0]);
    $this->data['age'] = round(($today - $dob)/(60*60*24*365),0);

    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['displayer'] = $this->problem_dom_displayer;

    $this->data['test_types'] = $this->test_types->find_all();
    $this->load->view('opd/show_visit_printable', $this->data);
  }


  public function add_addendum($visit_id) {
    if (!$_POST) {
      $this->data['status'] = 'error';
      $this->data['msg'] = 'Please fill the right form to add an illness';
    } else {
      $this->validate_id($visit_id, 'visit');
      $this->form_validation->set_rules('addendum', 'Addendum', 'required');
      $this->form_validation->set_error_delimiters('<label class="error">', '</label>');
      
      if ($this->form_validation->run()) {
        $addendum_id=$this->save_addendum($visit_id);
		 $this->data['addendum_id'] = $addendum_id;
        $this->data['status'] = 'success';
		$this->data['msg'] = 'Note successfully added';
		
		if(isset($_POST['ischecked'])){
			if($_POST['ischecked'] == true){
				$this->send_email_after_adding_note($visit_id);
			}
		}		
      } 
      else {
		$this->data['status'] = 'error';
		$this->data['msg'] = 'Error adding the note to the visit';
      }
    }  
    
    echo json_encode($this->data);	
  }

  public function list_($person_id,$policy_id) {
    $this->validate_id($person_id, 'person');
    $this->data['person'] = $this->person->find($person_id);
    $this->data['policy_id'] = $policy_id;
    $this->data['household'] = $this->data['person']->related('household')->get();
    // TODO - Figure out why the following doesnt work!?
    //    $this->data['visits'] = $this->data['person']->related('visit')->get();
    $state='Valid';
    $hew_login = $this->is_logged_in_user_hew();
    $this->data['hew_login'] = $hew_login;
    $this->data['visits'] = $this->visit->where('person_id', $person_id)->where('valid_state', $state)->find_all();// sachin
    $this->load->view('opd/list_visits_resp', $this->data);
  }

  // TODO: Need to pass the new visit id
  private function save($person_id, $policy_id, $visit_type) {
    // TODO: Use of obstetric and pediatric flags to create/ save corresponding
    // records
    // TODO - singular or plural visit?
    // TODO - Add transactions here
    $tx_status = true;
    $this->db->trans_begin();	
   
	$_POST['end_time'] = time();	
	
	$hew_login = $this->is_logged_in_user_hew();

    $new_visit = $this->visit->new_record($_POST);
   
    if ($new_visit->chief_complaint == "Other")
      $new_visit->chief_complaint = $_POST["chief_complaint_other"];
    $new_visit->policy_id = $policy_id;
    $new_visit->type= $visit_type;
    $new_visit->chw_followup_id = $this->session->userdata('chw_f_id');
	
    log_message("debug", "Got visit <date = ".$new_visit->date.", provider = ".$new_visit->provider_id);

    if($hew_login){
    	$new_visit->valid_state = "Pre-consulted";    	
    }
   
    if (!$new_visit->save()) {
      $home_message = 'Unable to save the visit';
      $this->session->set_userdata('msg', $home_message);
      $tx_status = false;
    }  
    
    $new_visit_vital = $this->visit_vital->new_record($_POST);
    $new_visit_vital->visit_id = $new_visit->id;
    $new_visit_auscult = $this->visit_auscult->new_record($_POST);
    $new_visit_auscult->visit_id = $new_visit->id;
    $new_visit_visual = $this->visit_visual->new_record($_POST);
    $new_visit_visual->visit_id = $new_visit->id; 
    $new_visit_visual_prescription = $this->visit_visual_prescription->new_record($_POST);
    $new_visit_visual_prescription->visit_id = $new_visit->id;	
  
    if($hew_login && isset($_POST['pregnant'])){
    	if($_POST['pregnant']=="Y"){
    		$new_visit_vital->is_pregnant = 1;
    		$new_visit_vital->waist_cm = 0;
    		$new_visit_vital->hip_cm =0;
    	}	
    	else
    		$new_visit_vital->is_pregnant = 0;
    }

    if ((!$new_visit_vital->save())||(!$new_visit_auscult->save()) ||(!$new_visit_visual->save()) ||(!$new_visit_visual_prescription->save())) {
      $home_message = 'Unable to save the visit vitals/auscult';
      $this->session->set_userdata('msg', $home_message);
      $tx_status = false;
    }
    
    
    //Followup information
    foreach ($_POST["protocol_information"] as $key => $protocol_information) {
    	$rootValueArray = explode(" " ,$protocol_information["name"]);
    	$rootValueStr = "";
    	for($i=0; $i < sizeof($rootValueArray);$i++){
    		$rootValueStr .= $rootValueArray[$i]."_";
    	}
    	$protocol_information_name =  substr($rootValueStr , 0, -1); // to trim _
    	if (isset($protocol_information["status"]) && $protocol_information["status"] =="Yes" && $_POST["followup_protocol_date_".$protocol_information_name] != "DD/MM/YYYY") {
			$protocol_value = "followup_protocol_value_".$protocol_information_name;
			$followup_root = "followup_root_".$protocol_information_name;
			$protocol_date = "followup_protocol_date_".$protocol_information_name;    		
    		$followup_value_array = explode(",",$_POST[$protocol_value]); //
    		
    		$followup_new_rec = $this->followup_info->new_record();
    		$followup_new_rec->person_id = $person_id;
    		$followup_new_rec->location_id = $this->session->userdata('location_id');
    		$followup_new_rec->visit_id = $new_visit->id;
    		$followup_new_rec->state = 'OPEN';
    		$followup_new_rec->next_action = $followup_value_array[0] ;
    		$followup_new_rec->protocol = $_POST[$followup_root];
    		$followup_new_rec->due_date = Date_util::change_date_format($_POST[$protocol_date]);
    		$followup_new_rec->assigned_to = $this->session->userdata('username');
    		$followup_new_rec->created_by = $this->session->userdata('username');
    		if (!$followup_new_rec->save()) {
    			$home_message = 'Unable to save followup information';
    			$this->session->set_userdata('msg', $home_message);
    			$tx_status = false;
    		}
    		
    		$jsonStructure="{";
    		$jsonStructure .= '"name" :';
    		$jsonStructure .= "\"".$_POST[$followup_root]."\"" . "," ;
    		$jsonStructure .= '"children": [';
    		$jsonStructure .= "{";
    		$jsonStructure .= "\"name\" :";
    		$jsonStructure .= "\"".$followup_value_array[0].",".$followup_value_array[1] ."\"". ",";
    		$jsonStructure .= '"children": [';
    		$jsonStructure .= "{";
    		$jsonStructure .= "\"name\" :";
    		$jsonStructure .= "\"".$_POST[$protocol_date] ."\"";
    		$jsonStructure .= "}]}]}";
    		
    		$protocol_information_entry = $this->visit_protocol_information_entry->new_record($protocol_information);
    		$protocol_information_entry->visit_id = $new_visit->id;
    		$protocol_information_entry->name = $_POST[$followup_root].'_followup';    		
    		$protocol_information_entry->details = $jsonStructure;
    		
    		if(!$protocol_information_entry->save()) {
    			$tx_status = false;
    		}
    		
    	}
    }   
    
    //ROS
    if(!$this->visit_ros_entry->save_visit($_POST["ros"],$new_visit->id)){
    	$home_message = 'Unable to save ros_entry';
      	$this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
    }
    
    //Physical Exam 
    if(!$this->visit_physical_exam_entry->save_visit($_POST["physical_exam"],$new_visit->id)){
    	$home_message = 'Unable to save physical_exam_entry';
      	$this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
    }
    //Protocol Information
    if(!$this->visit_protocol_information_entry->save_visit($_POST["protocol_information"],$new_visit->id)){
    	$home_message = 'Unable to save protocol_information_entry';
      	$this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
    } 
	
	//diagnosis_entry
    if(!$this->visit_diagnosis_entry->save_visit(explode(",", $_POST["differential_diagnosis"]),$new_visit->id)){
    	$home_message = 'Unable to save diagnosis_entry';
	    $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
    } 
   	
	//Medication entries
	if(isset($_POST["medication"])){
		/*$m_array = $this->visit_medication_entry->save_visit($_POST["medication"],$new_visit->id);
		if(!isset($t_array)){
			$home_message = 'Unable to save medicine_entry';
		    $this->session->set_userdata('msg', $home_message);
		  	$tx_status = false;
		}*/
		
		foreach ($_POST["medication"] as $medication) {
			if(((int)$medication["number"]) > 0){
				$c_entry = $this->visit_cost_item_entry->new_record($medication);
				$c_entry->rate = $medication["rate"];
		       	$c_entry->number = $medication["number"];
		       	$c_entry->cost = $c_entry->number * $c_entry->rate;
		      	$c_entry->visit_id = $new_visit->id;
			    if(!$c_entry->save()){
			      	$home_message = 'Unable to save medicine cost_entry';
			     	$this->session->set_userdata('msg', $home_message);
			  	 	$tx_status = false;
				}
				if($tx_status){ //Save medication entry if cost_item transaction is successfull
			      	$m_entry = $this->visit_medication_entry->new_record($medication);
			      	$m_entry->visit_id = $new_visit->id;
			      	$m_entry->visit_cost_item_entry_id = $c_entry->id;
			      	if(!$m_entry->save()){
				      	$home_message = 'Unable to save medicine_entry';
				      	$this->session->set_userdata('msg', $home_message);
				  	 	$tx_status = false;
					}
				}
			}
    	}
	}

	//OPD products entries
	$opd_prod_array = array();
	if(isset($_POST["opdproducts"])){
		/*$opprod_array = $this->visit_opdproduct_entry->save_visit($_POST["opdproducts"],$new_visit->id);
		if(!isset($opprod_array)){
			$home_message = 'Unable to save OP Product entry';
		    $this->session->set_userdata('msg', $home_message);
		  	$tx_status = false;
		}*/
		foreach ($_POST["opdproducts"] as $opdproduct) {
			if(((int)$opdproduct["number"]) > 0){
				$c_entry = $this->visit_cost_item_entry->new_record($opdproduct);
				$c_entry->rate = $opdproduct["rate"];
		       	$c_entry->number = $opdproduct["number"];
		       	$c_entry->cost = $c_entry->number * $c_entry->rate;
		      	$c_entry->visit_id = $new_visit->id;
			    if(!$c_entry->save()){
			      	$home_message = 'Unable to save OP Product cost_entry';
			     	$this->session->set_userdata('msg', $home_message);
			  	 	$tx_status = false;
				}
				if($tx_status){ //Save OP product entry if cost_item transaction is successfull
			      	$opprod_entry = $this->visit_opdproduct_entry->new_record($opdproduct);
			      	if(isset($opdproduct["product_given_out"]) && $opdproduct["product_given_out"] === "on"){
      					$opprod_entry->product_given_out = "yes";
      					$opprod_entry->is_present_in_stock = "Yes";
      				}else{
      					$opprod_entry->product_given_out = "no";
      					$opprod_entry->is_present_in_stock = "No";
      				}
			      	$opprod_entry->visit_id = $new_visit->id;
			      	$opprod_entry->visit_cost_item_entry_id = $c_entry->id;
			      	if(!$opprod_entry->save()){
				      	$home_message = 'Unable to save OP product Entry';
				      	$this->session->set_userdata('msg', $home_message);
				  	 	$tx_status = false;
					}
				}
				
				//save made to order opd product with -ve quantity in product_batchwise_stock 
				$product_id=$this->product->find_by('id',$opdproduct["product_id"]);
				$product_order_type=$product_id->product_order_type;
				$provider_location_id=$this->provider_location->find($new_visit->provider_location_id);
				if($product_order_type=='MADETOORDER'){
					$made_to_order_entry = $this->stock->new_record($opdproduct);
					$made_to_order_entry->location_id=$provider_location_id->scm_org_id;
					$made_to_order_entry->receipt_date=$new_visit->date;
					$made_to_order_entry->batch_number="opd_made_to_order";
					$made_to_order_entry->quantity=-$opdproduct["number"];
					$made_to_order_entry->save();
				}
				
			}
    	}
	}
	
	//service entries
	$service_array = array();
	if(isset($_POST["services"])){
		/*$service_array = $this->visit_service_entry->save_visit($_POST["services"],$new_visit->id);
		if(!isset($service_array)){
			$home_message = 'Unable to save service entry';
		    $this->session->set_userdata('msg', $home_message);
		  	$tx_status = false;
		}*/
		foreach ($_POST["services"] as $service) {
				$c_entry = $this->visit_cost_item_entry->new_record($service);
				$c_entry->rate = $service["rate"];
		       	$c_entry->number = 1; //Special case for service
		       	$c_entry->cost = $c_entry->number * $c_entry->rate;
		      	$c_entry->visit_id = $new_visit->id;
			    if(!$c_entry->save()){
			      	$home_message = 'Unable to save service cost_entry';
			     	$this->session->set_userdata('msg', $home_message);
			  	 	$tx_status = false;
				}
				if($tx_status){ //Save OP product entry if cost_item transaction is successfull
			      	$service_entry = $this->visit_service_entry->new_record($service);
			      	$service_entry->visit_id = $new_visit->id;
			      	$service_entry->visit_cost_item_entry_id = $c_entry->id;
			      	if(!$service_entry->save()){
				      	$home_message = 'Unable to save service Entry';
				      	$this->session->set_userdata('msg', $home_message);
				  	 	$tx_status = false;
					}
				}
			}
	}
	
    //Referral_entry
     if(!$this->visit_referral_entry->save_visit(explode(",", $_POST["referrals"]),$new_visit->id)){
    	$home_message = 'Unable to save referral_entry';
      	$this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
    } 
    
    //Consultation
    if(isset($_POST["consultation"])){
    	$consultation = $_POST["consultation"][0];
    	$c_entry = $this->visit_cost_item_entry->new_record($consultation);
    	$c_entry->rate = $consultation["rate"];
    	$c_entry->number = $consultation["number"];
    	$c_entry->cost = $c_entry->number * $c_entry->rate;
    	$c_entry->visit_id = $new_visit->id;
    	if(!$c_entry->save()){
      		$home_message = 'Unable to save consultation cost_entry';
      		$this->session->set_userdata('msg', $home_message);
  	 		$tx_status = false;
		}
    }

	//Test entries
	if(isset($_POST["test"])){
		foreach ($_POST["test"] as $test) {
			$c_entry = $this->visit_cost_item_entry->new_record($test);
		    // TODO(arvind): Is the following condition good enough?
		    if (!isset($c_entry->subtype) || ($c_entry->subtype === "") || $c_entry->number < 1)
				continue;
		    $c_entry->rate = $test["rate"];
		    $c_entry->number = $test["number"];
		    $c_entry->cost = $c_entry->number * $c_entry->rate;
		    $c_entry->visit_id = $new_visit->id;
		    if(!$c_entry->save()){
				$home_message = 'Unable to save test cost_entry';
			    $this->session->set_userdata('msg', $home_message);
			  	$tx_status = false;
			}
			//To allow strip test and procedure test result as label in show visit page
			$tt_rec = $this->test_types->find($test['product_id']);
			if($tt_rec->bill_type == 'Single'){
				if($tt_rec->type==='Strip' || $tt_rec->type==='Procedure'){
					$t_entry = $this->visit_test_entry->new_record($test);
					$t_entry->visit_id = $new_visit->id;
					$t_entry->visit_cost_item_entry_id = $c_entry->id;
					$t_entry->test_type_id = $tt_rec->id;
					$t_entry->result =$test['result'];
					$t_entry->technician_id =$new_visit->provider_id;
					$t_entry->date_of_result =$new_visit->date;
					if(!$t_entry->save()) {
			  	 		$tx_status = false;
					}
				}else{
					$t_entry = $this->visit_test_entry->new_record($test);
					$t_entry->visit_id = $new_visit->id;
					$t_entry->visit_cost_item_entry_id = $c_entry->id;
					$t_entry->test_type_id = $tt_rec->id;
					$t_entry->result = null;
					if(!$t_entry->save()) {
			  	 		$tx_status = false;
					}
				}
			}else{
				$para_str = explode(':',$tt_rec->bill_type);
				$paras = explode(',',$para_str[1]);
				foreach($paras as $para){
					$test_enable_check=$this->test_types->where('id',$para)->find();
					if($test_enable_check->is_test_enabled==1){
						$t_entry = $this->visit_test_entry->new_record($test);
						$t_entry->visit_id = $new_visit->id;
						$t_entry->test_type_id = $para;
						$t_entry->visit_cost_item_entry_id = $c_entry->id;
						$t_entry->result = null;
						if(!$t_entry->save()) {
			      			$tx_status = false;
						}
					}
				}
			}
    	 }
	}

	// Adding barcode entries
    for ($j=0; $j<5; $j++){
		$b_var = 'barcode_'.$j;
		$l_var = 'location_'.$j;
		if($_POST[$b_var] != ''){
			/*$check_duplicate_barcode=$this->visit_document->where("document_id",$_POST[$b_var])->where("destination_id",$_POST[$l_var])->find();
			if($check_duplicate_barcode->id !=null){
				$this->session->set_userdata('msg','Barcode for test already exists ');
      			redirect("/opd/visit/add/$person_id/$policy_id");
			}*/
			$doc_rec = $this->visit_document->new_record();
			$doc_rec->visit_id = $new_visit->id;
			$doc_rec->type ='barcode';
			$doc_rec->destination_type ='Lab';
			$doc_rec->document_id = $_POST[$b_var];
			$doc_rec->destination_id = $_POST[$l_var];
			if(!$doc_rec->save()){
      			$home_message = 'Unable to save Bar code entry '.$j;
      			$this->session->set_userdata('msg', $home_message);
  	 			$tx_status = false;
			}
		}
    }
    $this->session->unset_userdata('chw_f_id');
    if($tx_status == true){
	    //Change PreConsultated Visit Status
	    if(isset($_POST['visit_preconsultation_id']) && $_POST['visit_preconsultation_id'] !=''){
	    	$preconsulted_visit_id=$_POST['visit_preconsultation_id'];
	    	$get_preconsulted_visit=$this->visit->where('id',$preconsulted_visit_id)->find();
	    	$get_preconsulted_visit->valid_state="Consultation_completed";
	    	$get_preconsulted_visit->save();
	    }
       	$this->db->trans_commit();
    	return $new_visit->id;
    }else {
       $this->db->trans_rollback();
       return false;
    }
  }

  private function print_array($inArray){
  	foreach ($inArray as $key => $value) {
  		echo "   Key :".$key;
  		if(is_array($value)){
  			$this->print_array($inArray);
  		}else{
  			echo "   " .$inArray;
  		}
  	}
  }
  
  private function edit_save($visit_id, $policy_id, $visit_type) {
    // TODO: Use of obstetric and pediatric flags to create/ save corresponding
    // records
    // TODO - singular or plural visit?
	
    $tx_status = true;
    $this->db->trans_begin();
    $new_visit = $this->visit->find($visit_id);
    $new_visit->chief_complaint = $_POST['chief_complaint'];
    $new_visit->type= $visit_type;
    $new_visit->hpi = $_POST['hpi'];
    $new_visit->risk_level = $_POST['risk_level'];
    $new_visit->approved = 'Unseen';
    
    log_message("debug", "Got visit <date = ".$new_visit->date.", provider = ".$new_visit->provider_id);

    $new_visit->save();

//Delete all releated data for a visit
  	//Diagnosis
	$visit_ds = $new_visit->related('visit_diagnosis_entries')->get();
	if($visit_ds != null){
		$new_visit->related('visit_diagnosis_entries')->delete();
	}
	//Physical Exam
    $physical_exam_row_exists = $new_visit->related('visit_physical_exam_entries')->get();
	if($physical_exam_row_exists!=null){
		$new_visit->related('visit_physical_exam_entries')->delete();
	}
	//ROS
	$visit_ros = $new_visit->related('visit_ros_entries')->get();
	if($visit_ros != null){
		$new_visit->related('visit_ros_entries')->delete();
	}
	//Protocol information
	$visit_protocol = $new_visit->related('visit_protocol_information_entries')->get();
	if($visit_protocol != null){
		$new_visit->related('visit_protocol_information_entries')->delete();
	}

//Add all releated data for a visit
  	//Diagnosis
    if(!$this->visit_diagnosis_entry->save_visit(explode(",", $_POST["differential_diagnosis"]),$new_visit->id)){
    	$home_message = 'Unable to save diagnosis_entry';
	    $this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
    }
	//Physical Exam 
    if(!$this->visit_physical_exam_entry->save_visit($_POST["physical_exam"],$new_visit->id)){
    	$home_message = 'Unable to save physical_exam_entry';
      	$this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
    }
    //ROS
	if(!$this->visit_ros_entry->save_visit($_POST["ros"],$new_visit->id)){
    	$home_message = 'Unable to save ros_entry';
      	$this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
    }
    //Protocol Information
    if(!$this->visit_protocol_information_entry->save_visit($_POST["protocol_information"],$new_visit->id)){
    	$home_message = 'Unable to save protocol_information_entry';
      	$this->session->set_userdata('msg', $home_message);
  	 	$tx_status = false;
    }

    //Followup information    
    foreach ($_POST["protocol_information"] as $key => $protocol_information) {
    	$rootValueArray = explode(" " ,$protocol_information["name"]);
    	$rootValueStr = "";
    	for($i=0; $i < sizeof($rootValueArray);$i++){
    		$rootValueStr .= $rootValueArray[$i]."_";
    	}
    	$protocol_information_name =  substr($rootValueStr , 0, -1); // to trim _
    	if (isset($protocol_information["status"]) && $protocol_information["status"] =="Yes" && $_POST["followup_protocol_date_".$protocol_information_name] != "DD/MM/YYYY") {
    		$protocol_value = "followup_protocol_value_".$protocol_information_name;
    		$followup_root = "followup_root_".$protocol_information_name;
    		$protocol_date = "followup_protocol_date_".$protocol_information_name;
    		$followup_value_array = explode(",",$_POST[$protocol_value]);
    		$followup_rec = $this->followup_info->where('protocol', $protocol_information["name"])->where('visit_id', $visit_id)->find();    		    		
    		
    		//save to followup history and modify followup info
    		
    		if(Date_util::date_display_format($followup_rec->due_date) != $_POST[$protocol_date]){
    			$followup_rec->due_date = Date_util::change_date_format($_POST[$protocol_date]);
    			$followup_rec->save();
    			$this->save_followup_history($followup_rec->id,'Due date',$followup_rec->due_date);
    		}
    		if($followup_rec->next_action != $followup_value_array[0]){
    			$followup_rec->next_action = $followup_value_array[0];
    			$followup_rec->save();
    			$this->save_followup_history($followup_rec->id,'Next action',$followup_rec->next_action);
    		}
    		
    		$jsonStructure="{";
    		$jsonStructure .= '"name" :';
    		$jsonStructure .= "\"".$_POST[$followup_root]."\"" . "," ;
    		$jsonStructure .= '"children": [';
    		$jsonStructure .= "{";
    		$jsonStructure .= "\"name\" :";
    		$jsonStructure .= "\"".$followup_value_array[0].",".$followup_value_array[1] ."\"". ",";
    		$jsonStructure .= '"children": [';
    		$jsonStructure .= "{";
    		$jsonStructure .= "\"name\" :";
    		$jsonStructure .= "\"".$_POST[$protocol_date] ."\"";
    		$jsonStructure .= "}]}]}";
    
    		$protocol_information_entry = $this->visit_protocol_information_entry->new_record($protocol_information);
    		$protocol_information_entry->visit_id = $new_visit->id;
    		$protocol_information_entry->name = $_POST[$followup_root].'_followup';    		
    		$protocol_information_entry->details = $jsonStructure;
    
    		if(!$protocol_information_entry->save()) {
    			$tx_status = false;
    		}   		
    
    	}
    }  

    if($tx_status == true){
       	$this->db->trans_commit();
		return true;
    }else {
    	$this->db->trans_rollback();
     	return false;
    }
    
  }

  private function save_addendum($visit_id) {
    $new_addendum = $this->visit_addendum->new_record($_POST);
    $new_addendum->visit_id = $visit_id;
    $new_addendum->username = $this->username;

    //    log_message("debug", "Username = [".$this->username."]");

    if (!$new_addendum->save())
      return false;
    return $new_addendum->id;
  }
  
  // Assigning Followup
  public function assign_followup($visit_id){  	
  	$followup_info_recs = $this->followup_info->find_all_by('visit_id' , $visit_id);
  	$i=1;
  	foreach ($followup_info_recs as $followup_info_rec){
  		$followup_info_rec->assigned_to = $_POST["username_".$i];
  		$followup_info_rec->save();
  		$this->save_followup_history($followup_info_rec->id,'Assigned to',$followup_info_rec->assigned_to);
  		$i++;
  	}
  	$policy_id = '';
  	$this->session->set_flashdata('msg_type', 'success');
  	$this->session->set_flashdata('msg', 'Visit '.$visit_id.' successfully assigned');
  	redirect('opd/visit/show/'.$visit_id.'/'.$policy_id);
  }
  
  // Listing all OPEN followups

public function list_followups(){

  	$location_id = $this->session->userdata('location_id');
  	if(empty($location_id)){
  	  	$this->session->set_flashdata('msg_type', 'error');
      	$this->session->set_flashdata('msg', 'Location must be chosen ');
      	redirect('opd/visit/home');
  	}  	
  	$followup_info_rec = $this->followup_info->where('location_id',$location_id,false)->where('state','"OPEN"',false)->order_by('due_date','DESC')->find_all();
  	$followup_id_list_edited_today = array() ;	
  	foreach( $followup_info_rec as $followup_rec ){
  
	  	 $date=Date_util::today();
	  	 $today_date_sql = Date_util::to_sql($date);
	  	$followup_histories =$this->followup_hist-> where('followup_id',$followup_rec->id,true)->where('date',$today_date_sql,true)->find_all();
	  	
	  	if(!empty($followup_histories) && sizeof($followup_histories) > 0)
	  	{
	  	$followup_id_list_edited_today[$followup_rec->id]=$followup_rec->id;
  		}
  	}
  	
  	$visit_link_url = 'index.php/opd/visit/show/';
  	$person_link_url = 'index.php/opd/visit/show_protocol_history/';
  	$followup_details_link_url = 'index.php/opd/visit/show_followup/';
 	$this->data['visit_link_url'] = $visit_link_url;
  	$this->data['person_link_url'] = $person_link_url;
  	$this->data['followup_link_url'] = $followup_details_link_url;  	
  	$this->data['followup_info_list'] = $followup_info_rec;
  	$this->data['followup_id_list_edited_today'] = $followup_id_list_edited_today;
  	$this->load->view('opd/list_open_followups', $this->data);
  	
  }
  
  // Update followup assignee, due_date and status and comment entered is stored in followup history table
  public function update_followup_info(){
  	$this->load->model('opd/followup_history_model','followup_hist');
  	$followup_info_rec = $this->followup_info->find_by('id',$_POST["followup_id"]);
  	$is_saved_to_history = false;
  	if(Date_util::date_display_format($followup_info_rec->due_date) != $_POST["due_date"]){
  		$followup_info_rec->due_date = Date_util::change_date_format($_POST["due_date"]);
  		$followup_info_rec->save();
  		$this->save_followup_history($followup_info_rec->id,'Due date',$followup_info_rec->due_date);
  		$is_saved_to_history = true;
  	}
  	if($followup_info_rec->assigned_to != $_POST["assigned_to"]){
  		$followup_info_rec->assigned_to = $_POST["assigned_to"];
  		$followup_info_rec->save();
  		$this->save_followup_history($followup_info_rec->id,'Assigned to',$followup_info_rec->assigned_to);
  		$is_saved_to_history = true;
  	}
  	if($followup_info_rec->state != $_POST["state"]){
  		$followup_info_rec->state = $_POST["state"];
  		$followup_info_rec->save();
  		$this->save_followup_history($followup_info_rec->id,'State',$followup_info_rec->state);
  		$is_saved_to_history = true;
  	}
  	if(!$is_saved_to_history){
  		$followup_hist_new = $this->followup_hist->new_record();  	
  		$followup_hist_new->followup_id = $followup_info_rec->id;
  		$followup_hist_new->updated_by = $this->username;
  		$followup_hist_new->updated_parameter = "";
  		$followup_hist_new->updated_value = "";
  		$followup_hist_new->date = date("Y-m-d");
  		$followup_hist_new->remarks = $_POST["comments_text"];
  		$followup_hist_new->save();
  	}
  	$this->session->set_flashdata('msg_type', 'success');
  	$this->session->set_flashdata('msg', 'Updated successfully ');  	
  	redirect('opd/visit/show_followup/'.$followup_info_rec->id);
  	
  }
  
  private function save_followup_history($followup_id,$updated_parameter,$update_value){
  	$this->load->model('opd/followup_history_model','followup_hist');
  	$followup_hist_new = $this->followup_hist->new_record();
  	
  	$followup_hist_new->followup_id = $followup_id;
  	$followup_hist_new->updated_by = $this->username;
  	$followup_hist_new->updated_parameter = $updated_parameter;
  	$followup_hist_new->updated_value = $update_value;
  	$followup_hist_new->date = date("Y-m-d");
  	if(isset($_POST["comments_text"])){
  		$followup_hist_new->remarks = $_POST["comments_text"];
  	}
  	$followup_hist_new->save();  	
  }
  
  // Followup details page
 public function show_followup($followup_id){
  	
  	$area_name = $this->get_names('areas','name');
	$village_name = $this->get_names('village_cities','name');
    $taluka_name =  $this->get_names('talukas','name');
	$district_name = $this->get_names('districts','name');

  	
  	$this->load->model('opd/followup_history_model','followup_hist');
  	$location_id = $this->session->userdata('location_id');
  	$followup_hist_recs = $this->followup_hist->where('followup_id',$followup_id,false)->order_by('id','DESC')->find_all();
  	$followup_info_rec = $this->followup_info->find_by('id',$followup_id);
  	 
  	$users_list = $this->provider->find_all_by_sql('select * from providers p,provider_location_affiliations pla where p.id=pla.provider_id and pla.provider_location_id= "'.$location_id.'" order by p.username ');
  	$username_array = array();
  	foreach ($users_list as $prov_rec){
  	 $user_rec = $this->user->find_by('username',$prov_rec->username);
           if($user_rec && $user_rec->is_user_enable == 1){
                 $username_array[$prov_rec->username] = $user_rec->name;
           }
  	}
  	
	$person_rec = $this->person->find_by('id',$followup_info_rec->person_id);
	$household_rec = $this->household->find_by('id',$person_rec->household_id);
  	$visit_link_url = 'index.php/opd/visit/show/';
  	$person_link_url = 'index.php/opd/visit/show_protocol_history/';
  	
  	$this->data['visit_link_url'] = $visit_link_url;
  	$this->data['person_link_url'] = $person_link_url;
  	$this->data['policy_id'] = $household_rec->policy_id;
  	$this->data['contact_number'] = $household_rec->contact_number;
  	
  	$this->data['street'] = $household_rec->street_address;
  	if(isset($household_rec->area_id) && $household_rec->area_id!=0)
  	$this->data['areas'] = $area_name[$household_rec->area_id];
  	if(isset($household_rec->village_city_id) && $household_rec->village_city_id!=0)
  	$this->data['village'] = $village_name[$household_rec->village_city_id];
  	if(isset($household_rec->taluka_id) && $household_rec->taluka_id!=0)
  	$this->data['taluka'] = $taluka_name[$household_rec->taluka_id];
  	if(isset($household_rec->district_id) && $household_rec->district_id!=0)
  	$this->data['district'] = $district_name[$household_rec->district_id];
  	
  	$this->data['person_name'] = $person_rec->full_name;
  	$this->data['followup_info'] = $followup_info_rec;
  	$this->data['followup_history_recs'] = $followup_hist_recs;
  	$this->data['username_list'] = $username_array;
  	$this->load->view('opd/followup_history_list' , $this->data);
  }
  
	function get_names($table_name,$column_name) {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ($table_name);
		$o_rows = $o_obj->find_all ();
		foreach ( $o_rows as $o_row ) {
			$orgs [$o_row->id] = $o_row->$column_name;
		}
		return $orgs;
	}

  //Overdue Tasks
  public function overdue_tasks(){
  	$current_date = date("Y-m-d");
  	$location_id = $this->session->userdata('location_id');
  	if(empty($location_id)){
  		$this->session->set_flashdata('msg_type', 'error');
  		$this->session->set_flashdata('msg', 'Location must be chosen ');
  		redirect('opd/visit/home');
  	}	
  	$followup_records = $this->followup_info->find_all_by_sql('select * from followup_informations where location_id="'.$location_id.'" and due_date <= "'.date("Y-m-d").'" and state = "OPEN" order by due_date desc');  	
  	$values = array();
  	$i=0;
  	foreach ($followup_records as $followup_rec){
  		$values[$i]['followup_id'] = $followup_rec->id;
  		$values[$i]['followup_name'] = Ucwords($followup_rec->protocol).','.$followup_rec->next_action;
  		$get_person_name=$this->person->find_by('id',$followup_rec->person_id);
  		$person_name=$get_person_name->full_name;
  		$values[$i]['person_id'] =$followup_rec->person_id;
  		$values[$i]['person_name'] =$person_name;
  		$values[$i]['visit_id'] = $followup_rec->visit_id;
  		$values[$i]['due_date'] = $followup_rec->due_date;
  		$values[$i]['assigned_to'] = $followup_rec->assigned_to;
  		$values[$i]['created_by'] = $followup_rec->created_by;
  		$i++;
  	}
  	
  	$overdue_tasks_url = 'index.php/opd/visit/show_followup/';
  	$visit_link_url = 'index.php/opd/visit/show/';
  	$person_link_url = 'index.php/opd/visit/show_protocol_history/';
  	$this->data['link_url'] = $overdue_tasks_url;
  	$this->data['visit_link_url'] = $visit_link_url;
  	$this->data['person_link_url'] = $person_link_url;
  	$this->data['total_results'] = $i;
  	$this->data['values'] = $values;
  	$this->load->view('opd/overdue_tasks_list' , $this->data);
  }
  
  
  //Protocol History
  public function show_protocol_history($person_id){
  	$person_rec = $this->person->find_by('id',$person_id);
  	$household_rec = $this->household->find_by('id',$person_rec->household_id); // to get policy
  	$followup_info_records = $this->followup_info->where('person_id',$person_id,false)->order_by('due_date','DESC')->find_all();  	
  	$all_protocols = $this->protocol_information->find_all_by_sql('select * from protocol_informations  where parent_id is null'); // first time to get all protocols 	
  	$policy_link_url = 'index.php/admin/enrolment/search_policy_by_id/opd/';
  	$followup_url = 'index.php/opd/visit/show_followup/';
  	$visit_link_url = 'index.php/opd/visit/show/';
	
  	
  	$values = array();
  	$i=0;
  	foreach ($followup_info_records as $followup_info_rec){
  		$visit_rec = $visit_rec = $this->visit->find($followup_info_rec->visit_id);
  		$values[$i]['visit_rec'] = $visit_rec;
  		$i++;    
  	}
  	
  	
  	$this->data['values'] = $values;
  	$this->data['displayer'] = $this->problem_dom_displayer;  	
  	$this->data['person_rec'] = $person_rec;
  	$this->data['household_rec'] = $household_rec;
  	$this->data['followup_info_records'] = $followup_info_records;
  	$this->data['all_protocols'] = $all_protocols;
  	$this->data['policy_link_url'] = $policy_link_url;
  	$this->data['link_url'] = $followup_url;
  	$this->data['visit_link_url'] = $visit_link_url;
  	$this->data['check_all']='check_all';       // right side check_all is hard-coded just to fill data['check_all']
  	$this->load->view('opd/show_protocol_history' ,$this->data);
  }
  
  // Protocol history filter events
  public function filter_protocol_history(){  	
  	$person_id = $_POST['person_id']; 	
  	$protocol_checked = $_POST['filters'];  	
  	$person_rec = $this->person->find_by('id',$person_id);
  	$household_rec = $this->household->find_by('id',$person_rec->household_id); // to get policy
  	$all_protocols = $this->protocol_information->find_all_by_sql('select * from protocol_informations  where parent_id is null');
  	$policy_link_url = 'index.php/admin/enrolment/search_policy_by_id/opd/';
  	$followup_url = 'index.php/opd/visit/show_followup/';
  	$visit_link_url = 'index.php/opd/visit/show/';
  	
  	$protocol_str =''; 	
  	$protocol_strng = "";
  	foreach ($protocol_checked as $key => $value){  		
  		$protocol_str = $protocol_str ."\"".$value."\"".',';
  		$protocol_strng = $protocol_strng .$value.',';
  	}
  	$str =  substr($protocol_str , 0, -1); // to trim ,
  	$strng = substr($protocol_strng , 0, -1); // to trim ,
  	
  	$key2 = array_search('all', $protocol_checked); // if 'All' checkbox is present
  	
  	if($key2 === 0){
  		$followup_info_records = $this->followup_info->where('person_id',$person_id,false)->order_by('due_date','DESC')->find_all();  		
  	}	
  	else{
  		$followup_info_records = $this->followup_info->find_all_by_sql('select * from followup_informations where protocol IN ('.$str.') and person_id = "'.$person_id.'" order by due_date desc');  		
  	}

  	$pieces = explode(",", $strng);
  	$checked_protocol_array = array();
  	$i = 0;
  	foreach ($pieces as $protocol_check){
  		$checked_protocol_array[$i] = $protocol_check;
  		$i++;
  	}

  	if($key2 === 0){
  		$checked_protocol_array = array();  				// if all is present in array then 'All' checkbox needs to checked .. in the view check for size 0 .
  	}
  	
  	$values = array();
  	$i=0;
  	foreach ($followup_info_records as $followup_info_rec){
  		$visit_rec = $visit_rec = $this->visit->find($followup_info_rec->visit_id);
  		$values[$i]['visit_rec'] = $visit_rec;
  		$i++;
  	}
  	
  	$this->data['values'] = $values;
  	$this->data['displayer'] = $this->problem_dom_displayer;  	
  	$this->data['person_rec'] = $person_rec;
  	$this->data['household_rec'] = $household_rec;
  	$this->data['followup_info_records'] = $followup_info_records;
  	$this->data['checked_protocols'] = $checked_protocol_array;
  	$this->data['all_protocols'] = $all_protocols;
  	$this->data['policy_link_url'] = $policy_link_url;
  	$this->data['link_url'] = $followup_url;
  	$this->data['visit_link_url'] = $visit_link_url;
  	$this->load->view('opd/show_protocol_history' ,$this->data);
  	
  }	
  
  // Task Calendar functions Start
  public function task_calendar(){
  	$location_id = $this->session->userdata('location_id');
  	if(empty($location_id)){
  		$this->session->set_flashdata('msg_type', 'error');
  		$this->session->set_flashdata('msg', 'Location must be chosen ');
  		redirect('opd/visit/home');
  	}
 
    
   	$this->load->view('opd/taskcal', $this->data);
   	
  }
  
  // Ajax call called for each event except drang and drop of calendar.
  public function fetch_cal_data(){  	
  	$view_type = $this->input->post('view_type');
  	$month = $this->input->post('month');
  	$year = $this->input->post('year');
  	$start_date = $this->input->post('start_date');
  	$end_date = $this->input->post('end_date');
  	
  	$location_id = $this->session->userdata('location_id');
  	if($view_type == "month"){
  		$start_date = $year."-".$month."-01";
  		$end_date = $year."-".$month."-31"; //This will not be a problem as we a fetching records in between start and end dates.
  	}
  	
  	$in_filters = array();
  	if($this->input->post('filters') != ""){
  		$in_filters = explode(",",$this->input->post('filters'));
  	}
  	
	$key2 = in_array("all",$in_filters);
	if($key2 || sizeof($in_filters) == 0 ){
		$followup_records = $this->followup_info->find_all_by_sql('select * from followup_informations where location_id="'.$location_id.'" and due_date between "'.$start_date.'" and "'.$end_date.'" ');
  	}else{
  		$protocol_str ='';
  		foreach ($in_filters as $key => $value){
  			$temp_value = str_replace("_"," ",$value);
  			$protocol_str = $protocol_str ."\"".$temp_value."\"".',';
  		}
  		$str =  substr($protocol_str , 0, -1); // to remove the extracome at the end of the string  		
  		$followup_records = $this->followup_info->find_all_by_sql('select * from followup_informations where location_id="'.$location_id.'" and due_date between "'.$start_date.'" and "'.$end_date.'" and protocol IN ('.$str.')');
	}

  	// form json structure
  	$jsonStructure=' { "event_data":[';
  	$base_url = $this->config->item('base_url');
  	$follow_up_color_code = $this->config->item('follow_up_color_codes');
  	foreach ($followup_records as $followup_rec){
  		$follow_up_color = $follow_up_color_code['open'];
  		if($followup_rec->state === 'CLOSED'){
  			$follow_up_color = $follow_up_color_code['close'];
  		}else if($followup_rec->due_date <= date('Y-m-d')){
  			$follow_up_color = $follow_up_color_code['over_due'];
  		}
  		$peron_obj = $this->person->find_by('id',$followup_rec->person_id);
  		$jsonStructure .= "{";
  		$jsonStructure .= '"id":';
  		$jsonStructure .= '"'.$followup_rec->id.'"';
  		$jsonStructure .= ",";
  		$jsonStructure .= '"title":';
  		$jsonStructure .= '"'.$peron_obj->full_name." - ".$followup_rec->protocol." - ".$followup_rec->next_action.'"';
  		$jsonStructure .= ",";
  		$jsonStructure .= '"start":';
  		$jsonStructure .= '"'.$followup_rec->due_date.'"';
  		$jsonStructure .= ",";
  		$jsonStructure .= '"url":';
  		$jsonStructure .= '"'.$base_url.'index.php/opd/visit/show_followup/'.$followup_rec->id.'"'; // need base url
  		$jsonStructure .= ",";
  		$jsonStructure .= '"color":';
  		$jsonStructure .= '"'.$follow_up_color.'"'; // color for event
  		$jsonStructure .= "}";
  		$jsonStructure .= ",";
  	}
  	$jsonString = $jsonStructure;
  	if(!empty($followup_records) || sizeof($followup_records) > 0)
  		$jsonString =  substr($jsonStructure , 0, -1); // to trim ,
  	$jsonString .= ']';
  	$followup_for_fillters = $this->followup_info->find_all_by_sql('select * from followup_informations where location_id="'.$location_id.'" and due_date between "'.$start_date.'" and "'.$end_date.'" ');
  	$protocols_array = array();
  	array_push($protocols_array, "all");
  	foreach ($followup_for_fillters as $followup_rec){
  		array_push($protocols_array, $followup_rec->protocol);    // store protocols in an array , these are shown in filter
  	}
  	$protocols_array = array_unique($protocols_array);
  	$jsonString .=',';
  	$jsonString .='"filters": [';
  	foreach ( $protocols_array as $protocol ) {
		$selected = "false";
   		if(in_array($this->remove_whitespace($protocol),$in_filters)){
   			$selected = "true";
   		}
   		$jsonString .='{';
   		$jsonString .='"filter_name":';
   		$jsonString .= '"'.ucwords(trim($protocol)).'"';
   		$jsonString .=',';
   		$jsonString .='"filter_value":';
   		$jsonString .= '"'.$this->remove_whitespace(trim($protocol)).'"';
   		$jsonString .=',';
   		$jsonString .= '"is_selected":';
   		$jsonString .= '"'.$selected.'"';
   		$jsonString .='},';
	}
	$jsonString =  substr($jsonString , 0, -1); // to trim ,
	$jsonString .= ']';
  	$jsonString .='}';
  	echo json_encode($jsonString);
  	
  }
  
  //Utility methods for calebdar fetch data
  function remove_whitespace($name) {
	$temp_str = preg_replace('#[ ,\/()+]#s', '_', ltrim(rtrim($name)));
	return str_replace("'", "_",$temp_str);
  }
  
  function replace_whitespace($name) {	
	return str_replace("_", " ",$name);
  }
  
  // Ajax call to update due date on dragging event in calendar
  /*
   *	adds days to date
   *	$date = date("Y-m-d");// current date
   * 	$timestamp = strtotime(date("Y-m-d", strtotime($date)) . " +1 day");
   *	$updated_date=strftime( "%Y-%m-%d",$timestamp);
  */  	
  public function update_event_date(){
  	$event_id = $this->input->post('event_id');
  	$day_delta = $this->input->post('day_delta');
  	
  	$followup_rec = $this->followup_info->find_by('id',$event_id);  	
  	$current_date = $followup_rec->due_date;  	
  	$last_parameter = $day_delta." day";  	
  	$timestamp = strtotime(date("Y-m-d", strtotime($current_date)) . $last_parameter);
  	$updated_date=strftime( "%Y-%m-%d",$timestamp);
  	$followup_rec->due_date = $updated_date;
  	$followup_rec->save();
  	$this->save_followup_history($followup_rec->id,'Due date',$followup_rec->due_date);
  	echo $updated_date;
  	  	
  }

// Task Calendar functions End
  
  public function send_email_after_adding_note($visit_id){
  	$base_url = $this->config->item('base_url');
  	$visit = $this->visit->find($visit_id);
  	$show_url = $base_url."index.php/opd/visit/show/$visit_id/$visit->policy_id";
  	$provider = $this->provider->find_by('id', $visit->provider_id);
  	$user_rec = $this->user->find_by('username', $provider->username); // to get 'to' email_id
  	$this->load->library('email', $this->config->item('email_configurations'));  // email_configurations in module_constants.php
	$visit_addendums_recs = $this->visit_addendum->where('visit_id',$visit_id,false)->order_by('date','DESC')->limit(1)->find_all();;
    $visit_addendums_rec="";
    foreach ($visit_addendums_recs as $visit_addendums){
    	$visit_addendums_rec = $visit_addendums;
    }
    $message = "";
    $to_email_id = $user_rec->email_id;
    if(!isset($user_rec->email_id) || empty($user_rec->email_id)){
    	$message = "Dear Admin <br>";
    	$message .= "As email id in not configured for user "."'$user_rec->name' this email has been redirected to you.<br>";
    	$message .= "Please take necessary action on the below message.";
    	$to_email_id = $this->config->item('admin_email_id');
    }
    $message .= "<html> <body> <table border=1px solid width=100%><tr><th width=35%;>Note</th><th width=30%;>Visit Id</th><th width=35%;>Date</th> </tr>  
							<tr><td>$visit_addendums_rec->addendum</td><td><a href='$show_url'>$visit_id</a></td><td>$visit_addendums_rec->date</td> </tr></table> </body> </html>";
	$this->email->set_newline("\r\n");
	$this->email->from('hmis@sughavazhvu.co.in');
	$this->email->to($to_email_id);
	$this->email->cc('karthik.tiruvarur@ictph.org.in');
	$this->email->subject('Test mail');
	$this->email->message($message);
	  	
	if($this->email->send()) {
		//echo 'Email sent.';
	}
	else {
		show_error($this->email->print_debugger());
	}
	
  }
  
  public function check_duplicate_barcode(){
  	 $new_barcode=$_POST["new_barcode"];
  	 $new_barcode_location=$_POST["new_barcode_location"];
  	 $duplicate_barcode_check=$this->visit_document->where('document_id',$new_barcode)->where('destination_id',$new_barcode_location)->find();
  	 if($duplicate_barcode_check !=null){
  	 	echo true;
  	 }else{
  	 	echo false;
  	 }
  }
  
  public function list_pisp_details(){
  	$i=0;
  	$person_details=array();
  	$current_date=Date_util::change_date_format(Date_util::today());
	  $location_id = $this->session->userdata('location_id');
	  if(empty($location_id)){
	  	$this->session->set_flashdata('msg_type', 'error');
	  	$this->session->set_flashdata('msg', 'Location must be chosen ');
		redirect('opd/visit/home');
	  }
	  //URLs
	  $policy_details_url = 'index.php/admin/enrolment/search_policy_by_id/opd/';
	  $list_visit_url = 'index.php/opd/visit/list_/';
	  $add_visit_url = 'index.php/opd/visit/add/';
	  
	  $villages_list=$this->get_names('village_cities','name');

	  //Get current date's Preconsultation Entries for particular clinic
  	  $preconsultation_entries = $this->visit->find_all_by_sql('select * from visits where date = "'.$current_date.'" and provider_location_id="'.$location_id.'" and valid_state="Pre-consulted" ORDER BY id DESC');
  	  foreach($preconsultation_entries as $preconsultation){
  	  	$person_details[$i]['person_id']=$preconsultation->person_id;
  	  	$person_details[$i]['policy_id']=$preconsultation->policy_id;
  	  	$person=$this->person->where('id',$preconsultation->person_id)->find();
  	  	
  	  	$person_date_of_birth=$person->date_of_birth;
  	  	$diff = abs(strtotime($current_date) - strtotime($person_date_of_birth));
		$years = floor($diff / (365*60*60*24));
		$person_details[$i]['age']=$years;
  	  	$person_details[$i]['person_name']=$person->full_name;
  	  	$person_details[$i]['gender']=$person->gender;
  	  	$person_household=$person->household_id;
  	  	$household=$this->household->where('id',$person_household)->find();
  	  	$person_details[$i]['village']=$villages_list[$household->village_city_id];
  	  	$person_details[$i]['type']='Pre-Consultation';
  	  	$i++;
  	  }
  	  
  	  //Get current date's Adult PISP Entries
  	  $pisp_adult_entries = $this->mne_pisp_adult->find_all_by_sql('select * from mne_pisp_adult where date_interview = "'.$current_date.'" and provider_location_id="'.$location_id.'" ORDER BY id DESC');
  	  foreach($pisp_adult_entries as $pisp_adult){
  	  	$person_date_of_birth=$pisp_adult->dob;
  	  	$diff = abs(strtotime($current_date) - strtotime($person_date_of_birth));
		$years = floor($diff / (365*60*60*24));
		$person_details[$i]['age']=$years;
  	  	$person_org_id=$pisp_adult->adult_id;
  	  	$person_info =$this->person->where('organization_member_id',$person_org_id)->find();
  	  	$person_details[$i]['gender']=$person_info->gender;
  	  	$person_details[$i]['person_id']=$person_info->id;
  	  	$person_details[$i]['person_name']=$person_info->full_name;
  	  	
  	  	$person_household=$person_info->household_id;
  	  	$household=$this->household->where('id',$person_household)->find();
  	  	$person_details[$i]['policy_id']=$household->policy_id;
  	  	$person_details[$i]['village']=$villages_list[$household->village_city_id];
  	  	$person_details[$i]['type']='Adult PISP';
  	  	$i++;
  	  }
  	  
 	 //Get current date's Adolescent PISP Entries
  	  $pisp_adolescent_entries = $this->mne_pisp_adolescent->find_all_by_sql('select * from mne_pisp_adolescent where date_interview = "'.$current_date.'" and provider_location_id="'.$location_id.'" ORDER BY id DESC');
  	  foreach($pisp_adolescent_entries as $pisp_adolescent){
  	  	$person_date_of_birth=$pisp_adolescent->dob;
  	  	$diff = abs(strtotime($current_date) - strtotime($person_date_of_birth));
		$years = floor($diff / (365*60*60*24));
		$person_details[$i]['age']=$years;
  	  	$person_org_id=$pisp_adolescent->adolescent_id;
  	  	$person_info =$this->person->where('organization_member_id',$person_org_id)->find();
  	  	$person_details[$i]['gender']=$person_info->gender;
  	  	$person_details[$i]['person_id']=$person_info->id;
  	  	$person_details[$i]['person_name']=$person_info->full_name;
  	  	
  	  	$person_household=$person_info->household_id;
  	  	$household=$this->household->where('id',$person_household)->find();
  	  	$person_details[$i]['policy_id']=$household->policy_id;
  	  	$person_details[$i]['village']=$villages_list[$household->village_city_id];
  	  	$person_details[$i]['type']='Adolescent PISP';
  	  	$i++;
  	  }
  	  
  	  //Get current date's Child  PISP Entries
  	  $pisp_child_entries = $this->mne_pisp_child->find_all_by_sql('select * from mne_pisp_child where date_interview = "'.$current_date.'" and provider_location_id="'.$location_id.'" ORDER BY id DESC');
  	  foreach($pisp_child_entries as $pisp_child){
  	  	$person_date_of_birth=$pisp_child->dob;
  	  	$diff = abs(strtotime($current_date) - strtotime($person_date_of_birth));
		$years = floor($diff / (365*60*60*24));
		$person_details[$i]['age']=$years;
  	  	$person_org_id=$pisp_child->child_id;
  	  	$person_info =$this->person->where('organization_member_id',$person_org_id)->find();
  	  	$person_details[$i]['gender']=$person_info->gender;
  	  	$person_details[$i]['person_id']=$person_info->id;
  	  	$person_details[$i]['person_name']=$person_info->full_name;
  	  	
  	  	$person_household=$person_info->household_id;
  	  	$household=$this->household->where('id',$person_household)->find();
  	  	$person_details[$i]['policy_id']=$household->policy_id;
  	  	$person_details[$i]['village']=$villages_list[$household->village_city_id];
  	  	$person_details[$i]['type']='Child PISP';
  	  	$i++;
  	  }
  	  
      //Get current date's Infant PISP Entries
  	  $pisp_infant_entries = $this->mne_pisp_infant->find_all_by_sql('select * from mne_pisp_infant where date_visit = "'.$current_date.'" and provider_location_id="'.$location_id.'" ORDER BY id DESC');
  	  foreach($pisp_infant_entries as $pisp_infant){
  	  	$infant_date_of_birth=$pisp_infant->infant_dob;
  	  	$diff = abs(strtotime($current_date) - strtotime($infant_date_of_birth));
		$years = floor($diff / (365*60*60*24));
		$person_details[$i]['age']=$years;
  	  	$person_org_id=$pisp_infant->infant_id;
  	  	$person_info =$this->person->where('organization_member_id',$person_org_id)->find();
  	  	$person_details[$i]['gender']=$person_info->gender;
  	  	$person_details[$i]['person_id']=$person_info->id;
  	  	$person_details[$i]['person_name']=$person_info->full_name;
  	  	
  	  	
  	  	$person_household=$person_info->household_id;
  	  	$household=$this->household->where('id',$person_household)->find();
  	  	$person_details[$i]['policy_id']=$household->policy_id;
  	  	$person_details[$i]['village']=$villages_list[$household->village_city_id];
  	  	$person_details[$i]['type']='Infant PISP';
  	  	$i++;
  	  }
  	  
  	  $this->form_data['date'] = $current_date;
  	  $this->form_data['policy_details_url'] = $policy_details_url;
  	  $this->form_data['list_visit_url'] = $list_visit_url;
  	  $this->form_data['add_visit_url'] = $add_visit_url;
  	  $this->form_data['values'] = $person_details;
	  $this->form_data['total_results'] = $i;
  	  $this->load->view('opd/list_preconsultation',$this->form_data);
  }
  
  public function list_visit_details(){
  	  $i=0;
  	  $person_details=array();
  	  $current_date=Date_util::change_date_format(Date_util::today());
	  $location_id = $this->session->userdata('location_id');
	  $villages_list=$this->get_names('village_cities','name');
	  if(empty($location_id)){
	  	$this->session->set_flashdata('msg_type', 'error');
	  	$this->session->set_flashdata('msg', 'Location must be chosen ');
		redirect('opd/visit/home');
	  }
	  //URLs
	  $policy_details_url = 'index.php/admin/enrolment/search_policy_by_id/opd/';
	  $show_visit_url = 'index.php/opd/visit/show/';
  	  
	  $visit_entries_for_today = $this->visit->find_all_by_sql('select * from visits where date = "'.$current_date.'" and provider_location_id="'.$location_id.'" and valid_state="Valid" ORDER BY id DESC');
  	  foreach($visit_entries_for_today as $visit_entries){
  	  	$person_details[$i]['person_id']=$visit_entries->person_id;
  	  	$person_details[$i]['policy_id']=$visit_entries->policy_id;
  	  	$person_details[$i]['visit_id']=$visit_entries->id;
  	  	$person=$this->person->where('id',$visit_entries->person_id)->find();
  	  	
  	  	$person_date_of_birth=$person->date_of_birth;
  	  	$diff = abs(strtotime($current_date) - strtotime($person_date_of_birth));
		$years = floor($diff / (365*60*60*24));
		$person_details[$i]['age']=$years;
  	  	$person_details[$i]['person_name']=$person->full_name;
  	  	$person_details[$i]['gender']=$person->gender;
  	  	$person_household=$person->household_id;
  	  	$household=$this->household->where('id',$person_household)->find();
  	  	$person_details[$i]['village']=$villages_list[$household->village_city_id];
  	  	$i++;
  	  }
  	  
  	  $this->form_data['date'] = $current_date;
  	  $this->form_data['policy_details_url'] = $policy_details_url;
  	  $this->form_data['show_visit_url'] = $show_visit_url;
  	  $this->form_data['values'] = $person_details;
	  $this->form_data['total_results'] = $i;
  	  $this->load->view('opd/list_valid_visit',$this->form_data);
  }
  
  //Edit Addendum
  public function edit_addendum($policy_id=''){

	  	$addendum=$_POST['edit_addendum'];
	  	$date=Date_util::to_sql($_POST['datepicker']);
	  	$username= $this->session->userdata('username');
	  	$addendum_id=$_POST['addendum_id'];
	  	$visit_id=$_POST['visit_id'];
	  	$find_addendum = array (
								"visit_id" => $visit_id,
								"username" => $username,
						   	 	"date" => $date,
					  			"addendum" => $addendum
								);
				$this->db->where('id', $addendum_id);
				$this->db->update('visit_addendums', $find_addendum); 
				$show_url = "/opd/visit/show/$visit_id/$policy_id";
				redirect($show_url);
	  }
	  
	  public function list_orders(){
		  $location_id = $this->session->userdata('location_id');
		  if(empty($location_id)){
		  	$this->session->set_flashdata('msg_type', 'error');
		  	$this->session->set_flashdata('msg', 'Location must be chosen ');
			redirect('opd/visit/home');
		  }
	  	 redirect('scm/order/list_orders');
	  }
	  
	  public function update_md_to_ordr_prod($visit_id,$product_id,$policy_id){
	  	$prod=$this->product->find_by('id',$product_id);
	  	$location_id=$this->visit->find_by('id',$visit_id)->provider_location_id;
	  	$update_opd_products=$this->visit_opdproduct_entry->where('visit_id',$visit_id)->where('product_id',$product_id)->where('product_given_out','no')->where('is_present_in_stock','Yes')->find();
	  	if($update_opd_products){	
	  		$update_opd_products->product_given_out='yes';
	  		$update_opd_products->save();
	  		$products=$this->stock->where('location_id',$location_id)->where('product_id',$product_id)->where('quantity >','0')->find_all();
	  	 	$bal_qty = ($update_opd_products->number)/($prod->retail_units_per_purchase_unit);
			  foreach ($products as $prod_stock){
				   if($bal_qty !=0){
					    $tx_qty = 0;
					    if($prod_stock->quantity < $bal_qty){
					    	$tx_qty = $prod_stock->quantity;
					    	$bal_qty = $bal_qty - $prod_stock->quantity;
					    	$prod_stock->quantity = 0;
					    }else{
					    	$prod_stock->quantity = $prod_stock->quantity - $bal_qty;
					    	$tx_qty = $bal_qty;
					    	$bal_qty = 0;
					    }
					    $prod_stock->save();
				   }
			  }
	  		
	  	}
	  	$prod_name=$prod->name;
	  	$this->session->set_flashdata('msg_type', 'success');
		$this->session->set_flashdata('msg', 'OP Product ( '.$prod_name.' ) given out successfully' );
	  	$show_url = "/opd/visit/show/$visit_id/$policy_id";
		redirect($show_url);
	  }
	  
}
