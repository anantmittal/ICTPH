<?php 
class Medical_history extends CI_Controller
{
  var $family_id;
  var $data = array();
  var $disease_model;
  
  public function Medical_history() {
    parent::__construct();

    $this->load->library('form_validation');
    $this->load->helper('url');
    $this->load->library('ignitedrecord/ignitedrecord');
    $this->load->model('demographic/Family_model','family');
    $this->load->model('demographic/Person_model');
    $this->load->model('survey/Illness_model');
    $this->load->model('survey/Chronic_illness_model', 'chronic_illness');
    $this->load->model('survey/Past_hospitalization_model', 'past_hospitalization');
    $this->load->model('survey/Advised_surgery_model', 'advised_surgery');
    $this->disease_models = array("chronic_illnesses" => $this->chronic_illness,
				  "past_hospitalizations" => $this->past_hospitalization,
				  "advised_surgeries" => $this->advised_surgery
				  );
    $this->counts = array("chronic_illnesses" => 5,
			  "past_hospitalizations" => 7,
			  "advised_surgeries" => 5);
    $this->required_field = array("chronic_illnesses" => "illness",
				  "past_hospitalizations" => "illness",
				  "advised_surgeries" => "surgery");
  }
  
  //function step_two($family_id)
  function add($family_id = false) {
    $this->family_id = $family_id;
    if (!($members = $this->family->get_members($family_id))) {
      // TODO - this error handling
      echo "family id [". $family_id. "] is invalid";
      return;
    }
    $this->data['members'] = $members;
    $this->data['family_id'] = $family_id;
    
    if (!$_POST) {
      $this->set_view_values($family_id, $members);

      /*
      $this->restore_values_step_two();			
      */
      //      $form['values'] = $this->_hospitalization_form_defaults();
      $this->load->view('survey/edit_medical_history', $this->data);
      return;
    }
     
    // Is a post request
    $this->delete_medical_history($family_id, $members);
    if (!$this->save_medical_history($family_id, $members)) {
      // TODO: add an error message
      // $data['values'] = $_POST;
      $this->set_view_values($family_id, $members);
      $this->load->view('survey/edit_medical_history' ,$this->data);
      return;
    }

    $this->load->view('survey/save_medical_history_success', $this->data);
  }

  function delete_medical_history($family_id, $members) {
    // TODO: Try to see if one can loop over just chronic_illnesses,
    // illness_episodes and advised_surgeries
    //$family_rec->related("chronic_illnesses")->delete();
    foreach ($this->disease_models as $disease_model)
      if ($recs = $disease_model->get_by_family($this->family, $family_id))
	foreach ($recs as $rec)
	  $rec->delete();
  }

  function save_medical_history($family_id, $members) {
    // TODO: Parse each row into such arrays
    foreach (array("chronic_illnesses", "past_hospitalizations", "advised_surgeries") as $t) {
      $model = $this->disease_models[$t];
      for ($i = 0; $i < $this->counts[$t]; $i++) {
	$array = $_POST[$t][$i];

	if ($array[$this->required_field[$t]] != "") {
	  $rec = $this->chronic_illness->new_record();
	  $rec->load_data($array);
	  // TODO: Do bulk saves -- save multiple values at the same time
	  $rec->save();
	}
      }
    }
    return true;
  }

  function set_view_values($family_id, $members) {
      // TODO: Add children, women
      $this->data['member_list'] = $this->family->convert_to_array($members);
      $this->data['childrens'] = $this->family->convert_to_array($this->family->get_children($family_id));
      $this->data['rch_member']= $this->family->convert_to_array($this->family->get_women($family_id)); //rch_women
  }

  function edit_family_history($back_to, $family_id) {
    if($family_id > 0) {
      $this->data['family_id'] = $family_id;
      $this->data['member_list'] = $this->person->get_member_list($family_id);
      $this->data['rch_member'] = $this->person->get_female_members($family_id);
      $this->data['childrens'] = $this->person->get_children($family_id);
      
      $this->data['illness_episodes'] = $this->disease->get_illness_info($family_id);
      $this->data['chronic_illness'] = $this->disease->get_cillness_info($family_id);
      $this->data['surgeries_advised'] = $this->disease->get_surgeries_advised($family_id);
      $this->data['rch_info'] = $this->disease->get_rch_info($family_id);
      $myArr = $this->enrollment->get_amount_details($family_id);
      $this->data['amount_details'] = &$myArr[0];
      $this->data['back_to'] = $back_to;
      
      $this->load->view('edit_family_history', $this->data);
    }
    else echo 'family id is not valid';  	  
  }
}