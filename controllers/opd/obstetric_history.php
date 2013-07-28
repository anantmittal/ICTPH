<?php

class Obstetric_history extends CI_Controller {
  private $data = array();

  /*
  function __construct() {
    parent::__construct();
    $this->load->model('demographic/person', 'person');
    $this->load->model('opd/medication', 'medication');
    $this->load->library('form_validation');
    $this->load->library('medical_utils');
  }

  public function overview($person_id) {
    $this->validate_id($person_id, 'person');
    
    $this->data['person'] = $this->person->find($person_id);
    // TODO - Need to figure out pagination here, specially for medications
    $this->data['illnesses'] = $this->illness->get_all($person_id);
    $this->data['medications'] = $this->medication->get_all($person_id);
    $this->data['family_history'] = $this->family_history->get_all($person_id);
    $this->data['pediatric_history'] = $this->family_history->get_all($person_id);
    if ($this->medical_utils->is_obgyn_eligible($person))
      $this->data['obstetric_history'] = $this->obstetric_history->get_all($person_id);

    // $this->data['visits'] = $this->data['person']->related('visits')->get();
    $this->load->view('opd/show_overview_resp', $this->data);
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
    if (!isset($_POST['submit'])) {
      $this->data['msg_type'] = 'error';
      $this->data['msg'] = 'Please fill the right form to add an illness';
      $this->load->view('opd/edit_illness_resp_error_xml', $this->data);
      return;
    }
    
    $this->form_validation->set_rules('illness', 'Illness', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('start_date', 'Start Date', 'required');
    $this->form_validation->set_error_delimiters('<label class="error">', '</label>');

    if (!$this->form_validation->run()) {
      $this->data['msg_type'] = 'error';
      $this->data['msg'] = 'Some fields are missing';
      $this->load->view('opd/edit_illness_resp_error_xml', $this->data);
      return;
    }
    if (!$this->save_illness($new, $illness_or_person_id)) {
      $this->data['msg_type'] = 'error';
      $this->data['msg'] = 'Unable to save the illness';
      $this->load->view('opd/edit_illness_resp_error_xml', $this->data);
      return;
    }
    
    $this->data['msg_type'] = 'success';
    $this->data['msg'] = 'Illness successfully added';    
  }

  private function save_illness($new, $id) {
    if ($new) {
      $illness_rec = $this->illness->new_record($_POST);
      $illness_rec->person_id = $this->person_id;
    } else {
      $illness_rec = $this->illness->get($id);
      // TODO - Is columns array required for load_postdata?
      $illness_rec->load_postdata();
    }
    return $illness_rec->save();
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
