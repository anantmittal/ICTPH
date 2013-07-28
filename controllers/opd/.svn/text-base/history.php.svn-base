<?php

class History extends OPD_base_controller {
  private $data = array();

  function __construct() {
    parent::__construct();
    $this->load->model('demographic/person_model', 'person');
    $this->load->model('demographic/household_model', 'household');
	$this->load->model('geo/village_citie_model','village_citie');
    $this->load->model('opd/illness_model', 'illness');
    $this->load->model('opd/medication_model', 'medication');
    $this->load->model('opd/visit_model','visit');
    //    $this->load->model('opd/family_history_model', 'family_history');
    $this->load->helper('medical');
    //    $this->load->model('opd/visit_model', 'visit');
    $this->load->library('form_validation');
    $this->load->model('user/user_model', 'user');
    $this->load->model('user/users_role_model', 'user_role');
    $this->load->model('user/role_model', 'role');
    $this->username = $this->session->userdata('username');
    $this->load->model('mne/forms/mne_pisp_adult_model','pisp_adult');
  }

  public function summary($person_id) {
    $this->validate_id($person_id, 'person');
    
    $this->data['person'] = $this->person->find($person_id);
    $this->data['illnesses'] = $this->illness->get_current($person_id);
    $this->data['medications'] = $this->medication->get_current($person_id);
    // $this->data['visits'] = $this->data['person']->related('visits')->get();
    $this->load->view('opd/show_summary_resp', $this->data);
  }

public function overview($person_id,$policy_id) {
    $this->validate_id($person_id, 'person');
    
    $this->data['person'] = $this->person->find($person_id);
    $this->data['policy_id'] = $policy_id;
    $this->data['household'] = $this->data['person']->related('household')->get();
    $hew_login = $this->is_logged_in_user_hew();
    $this->data['hew_login'] = $hew_login;
    
    // TODO - Need to figure out pagination here, specially for medications
    //$this->data['illnesses'] = $this->illness->get_all($person_id);
    $this->data['past_encounters'] = $this->visit->get_all_past_encounters($person_id);
   
    $tests = $this->visit->get_all_diagnostic_tests($person_id);
    $this->data['diagnostic_tests']=$tests['diagnostic_tests'];
    $this->data['test_dates']=$tests['test_dates'];
    $this->data['test_visit_ids']=$tests['visit_ids'];
    $organization_member_id = $this->person->get_adult_id($person_id);
    $this->data['family_histories'] = $this->pisp_adult->get_family_history($organization_member_id);
    //    $this->data['family_history'] = $this->family_history->get_all($person_id);
	
    // TODO - figure out the models for pediatric, family and obstetric history
    //    $this->data['pediatric_history'] = $this->family_history->get_all($person_id);
    /*
    if ($this->medical_utils->is_obgyn_eligible($person))
      $this->data['obstetric_history'] = $this->obstetric_history->get_all($person_id);
    */
    // $this->data['visits'] = $this->data['person']->related('visits')->get();
    $this->load->view('opd/show_overview_resp', $this->data);
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
  
  
  public function add_illness($person_id) {
    $this->validate_id($person_id, 'person');
    $this->edit_illness_common(true, $person_id);
  }

  public function edit_illness($illness_id) {
    $this->validate_id($illness_id, 'illness');
    $this->edit_illness_common(false, $illness_id);
  }

  private function edit_illness_common($new, $illness_or_person_id) {
    // TODO - the right way to handle such errors will be as exceptions
    if (!$_POST) {
      $this->data['status'] = 'error';
      $this->data['msg'] = 'Please fill the right form to add an illness';
    } else {
    
      $this->form_validation->set_rules('illness', 'Illness', 'required');
      $this->form_validation->set_rules('status', 'Status', 'required');
      $this->form_validation->set_rules('start_date', 'Start Date', 'required');
      $this->form_validation->set_error_delimiters('<label class="error">', '</label>');
      
      if (!$this->form_validation->run()) {
	$this->data['status'] = 'error';
	$this->data['msg'] = 'Some fields are missing';
      } else {
	$id = $this->save_illness($new, $illness_or_person_id);
	if (!$id) {
	  $this->data['status'] = 'error';
	  $this->data['msg'] = 'Unable to save the illness';
	} else {
	  $this->data['status'] = 'success';
	  $this->data['msg'] = 'Illness successfully added';
	  $this->data['id'] = $id;
	}
      }
    }

    $this->load->view('opd/history/illness_resp_xml', $this->data);
    return;

  }

  private function save_illness($new, $id) {
    if ($new) {
      $illness_rec = $this->illness->new_record($_POST);
      
      log_message("debug", "New illness: Status got <".$_POST["status"].", set <".$illness_rec->status.">");
      $illness_rec->person_id = $id;
    } else {
      $illness_rec = $this->illness->get($id);
      // TODO - Is columns array required for load_postdata?
      $illness_rec->load_postdata();
    }
    if (!$illness_rec->save())
      return false;
    return $illness_rec->id;
  }

  // TODO - Should be similar to add illness above
  public function add_medication($person_id) {
  }
  public function edit_medication($person_id) {
  }


  /*
  public function edit($visit_id) {
    $this->validate_id($visit_id, 'visit');

    if (!isset($_POST['submit'])) {
      $this->data['visit'] = $this->visit->find($visit_id);
      // TODO Do I need to get the first member of the get array? Does get
      // return a single element in case of belongs_to relationship?
      $this->data['person'] = $this->data['visit']->related('persons')->get();
      $this->load->view('opd/edit_visit_req', $this->data);
      return;
    }

    // If a submit of visit edit
    // TODO - Add validation conditions
    if ($this->form_validation->run() && ($visit_id = $this->save())) {
      $this->set_flashdata('msg_type', 'success');
      $this->set_flashdata('msg', 'Visit '.$visit_id.' successfully added');
      redirect('opd/visits/'.$person_id);
    }
    
    $this->set_flashdata('msg_type', 'error');
    $this->set_flashdata('msg', 'Error adding new visit');    
    $this->load->view('opd/edit_visit_req', $this->data);
  }

  // TODO: Need to pass the new visit id
  private function save() {
    // TODO: Use of obstetric and pediatric flags to create/ save corresponding
    // records
    $visit = $this->visits->new_record($_POST);
    if (!$visit->save())
      return false;
  }
  */
}
