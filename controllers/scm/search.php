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
    $this->load->model('opd/visit_model', 'visit');
    $this->load->model('opd/provider_location_model', 'provider_location');
    $this->load->model('admin/enrolled_member_model', 'enrolled_member');
    $this->load->model('scm/drug_generic_model', 'drug_generic');
    $this->load->model('scm/drug_brand_model', 'drug_brand');
    $this->load->model ( 'scm/scm_organization_model', 'locationname' );
    
    $this->load->library('form_validation');
//    $this->load->library('date_util');
    $this->load->helper('date');
  }
  
  function home() {
    if($this->session->userdata('username')!=null) {
		$form_data['scm_orgs'] = $this->get_scm_orgs();
		
		$generic_drug_list=$this->drug_generic->find_all(); 
    	$form_data['generic_drug_list'] = $generic_drug_list;
    	
    	$brand_drug_list=$this->drug_brand->find_all(); 
    	$form_data['brand_drug_list'] = $brand_drug_list;
    	
    	$organizations_list=$this->locationname->find_all(); 
    	$form_data['organizations_list'] = $organizations_list;
		
		
      	$this->load->view('scm/home',$form_data);
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

    if ($in == "visit" && $by == "date" ){
//	$q_date = $key; 
//	$o_date = Date_util::change_date_format($key); 
	$this->load->helper('date');
    $date_arr = explode('-',$key);
    $change_date = mktime(0,0,0,$date_arr[1],$date_arr[0],$date_arr[2]);
    $q_date = date('Y-m-d',$change_date);
	if($this->visit->find_by('date',$q_date))
	{ 
	
      	log_message("debug", "TRUE!");
      	$status = true;

      	log_message("debug", "Search status = ".$status);
      	echo json_encode($status);
      	return;
	}
    }

    if ($in == "visit" && $by == "id" && $this->visit->find($key)) {
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
    
    if ($in== 'visit' && $by =='id')	{
      $url ='index.php/opd/visit/show/'.$key;	
    }
  if ($in== 'visit' && $by =='date')	{
      $url ='index.php/opd/visit/search_by_date/'.$key;	
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