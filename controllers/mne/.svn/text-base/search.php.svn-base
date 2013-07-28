<?php 
 
class Search extends Search_base_controller
{
  private $data = array();
  
  function __construct() {
    parent::__construct();
    $this->load->model('demographic/person_model', 'person');
    $this->load->model('demographic/household_model', 'household');
    $this->load->model('admin/policy_model', 'policy');
    $this->load->model('opd/provider_model', 'provider');
    $this->load->model('opd/provider_location_model', 'provider_location');
    $this->load->model('admin/enrolled_member_model', 'enrolled_member');
    
    $this->load->library('form_validation');
  }
  
  function home() {
    if($this->session->userdata('username')!=null) {
      $this->load->view('mne/home');
    } else {
      redirect('/session/session/login');
    }
  }
  
  function check($in, $by, $key) {
    // if $key is of the type $type
    if ($in == "policy" && $by == "id" && $this->household->find_by('policy_id',$key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "policy" && $by == "name" && $this->enrolled_member->is_name($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "doctor" && $by == "id" && $this->provider->find($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "doctor" && $by == "name" && $this->provider->is_name($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "clinic" && $by == "id" && $this->provider_location->find($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "clinic" && $by == "name" && $this->provider_location->is_name($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    $status = false;
    log_message("debug", "Search status = ".$status);
    echo json_encode($status);
  }
  
  function results($in, $by, $key) {
    // For now, this can only be (in = policy, by = id, keyword = policy-id)
      // Later, have to generalize to support visits etc
    if ($in== 'policy' && $by =='id')	{
      $url ='index.php/admin/enrolment/search_policy_by_id/opd/'.$key;	
    }
  if ($in== 'policy' && $by =='name')	{
      $url ='index.php/admin/enrolment/search_policies_by_name/'.$key.'/opd/';	
    }
    
    if ($in== 'doctor' && $by =='id')	{
      $url ='index.php/opd/provider/edit/'.$key;	
    }
  if ($in== 'doctor' && $by =='name')	{
      $url ='index.php/opd/provider/search_by_name/'.$key;	
    }
    
    if ($in== 'clinic' && $by =='id')	{
      $url ='index.php/opd/location/edit/'.$key;	
    }
  if ($in== 'clinic' && $by =='name')	{
      $url ='index.php/opd/location/search_by_name/'.$key;	
    }
    
    redirect($this->config->item('base_url').$url);	
    return ;
  }
}
