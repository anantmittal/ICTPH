<?php 
 
class Search extends Search_base_controller 
{
  function __construct() {
    parent::__construct();
    $this->load->model('demographic/person_model', 'person');
    $this->load->model('demographic/household_model', 'household');
    $this->load->model('admin/policy_model', 'policy');
    $this->load->model('admin/enrolled_member_model', 'enrolled_member');
    $this->load->model('hospitalization/hospital_model', 'hospital');
    
    $this->load->model('chw/chw_model', 'chw');
    $this->load->model('chw/chw_group_model', 'chw_group');
    $this->load->model('chw/project_model', 'project');
    $this->load->model('chw/training_module_model', 'training_module');

    $this->load->library('form_validation');
  }

  function home() {
    if($this->session->userdata('username')!=null) {
      $this->load->view('chw/home');
    } else {
      redirect('/session/session/login');
    }
  }
  
  function check($in, $by, $key) {
    // if $key is of the type $type
    if ($in == "household" && $by == "policy_id" && $this->household->find_by('policy_id',$key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "household" && $by == "name" && $this->enrolled_member->is_name($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($by =="name" && $key=="ALL") {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "chw" && $by == "id" && $this->chw->find($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "chw" && $by == "name" && $this->chw->is_name($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "chw" && ($by == 'village' || $by == 'hamlet' || $by == 'district' || $by == 'taluka')) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "project" && $by == "id" && $this->project->find($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "project" && $by == "name" && $this->project->is_name($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "chw_group" && $by == "id" && $this->chw_group->find($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "chw_group" && $by == "name" && $this->chw_group->is_name($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "training" && $by == "id" && $this->training_module->find($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "training" && $by == "name" && $this->training_module->is_name($key)) {
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

    if ($in== 'household' && $by =='policy_id')	{
      $url ='index.php/admin/enrolment/search_policy_by_id/chw/'.$key;	
    }
  if ($in== 'household' && $by =='name')	{
      $url ='index.php/admin/enrolment/search_policies_by_name/'.$key.'/chw/';	
    }
    
    
    if($in == 'chw' && $by == 'id' ) {
      $url= 'index.php/chw/chw/show/'.$key;
    }

    if($in == 'chw' && $by == 'id' && $key =='ALL') {
      $url= 'index.php/chw/chw_group/show_chws';
    }

    if($in == 'chw' && $by == 'name' ) {
      $url= 'index.php/chw/chw/search_by_name/'.$key;
    }

    if($in == 'chw' && ($by == 'village' || $by == 'hamlet' || $by == 'district' || $by == 'taluka') ) {
      $url= 'index.php/chw/chw/search_by_geo/'.$by.'/'.$key;
    }

    if($in == 'chw_group' && $by == 'id' ) {
      $url= 'index.php/chw/chw_group/member_listing/'.$key;
    }

    if($in == 'chw_group' && $by == 'name' ) {
      $url= 'index.php/chw/chw_group/search_by_name/'.$key;
    }

    if($in == 'project' && $by == 'id' ) {
      $url= 'index.php/chw/project/show/'.$key;
    }

    if($in == 'project' && $by == 'name' ) {
      $url= 'index.php/chw/project/search_by_name/'.$key;
    }

    if($in == 'training' && $by == 'id' ) {
      $url= 'index.php/chw/training_module/edit/'.$key;
    }

    if($in == 'training' && $by == 'name' ) {
      $url= 'index.php/chw/training_module/search_by_name/'.$key;
    }

    redirect($this->config->item('base_url').$url);	
    return ;
  }

  /** 
   *
   * 
   * @return url|url  : if no error or proper id found as per type
   * @return error|message if ID of apppropriate TYPE is not found in database
   */	
  
  function search_form_redirect()
  {
    $this->load->model('hospitalization/policy_detail_model','policy_model');
    $type = $this->input->post('type');
    $id = trim($this->input->post('id'));
			
    if($type != 'hospital')
      $result = $this->validate_id($id, $type, 'false');
    
    $exploded_result = explode('|', $result);			
    
    if($exploded_result[0] == 'error'){
      echo $result;	
      return ;			
    }
    
    
    //			$policy_id_staus = $this->policy_model->is_valid_policy_id($policy_id);			
    
    //			mail('pankaj.khairnar@magnettechnologies.com', 'header search', 'policy id : '.$policy_id.'  type :'.$type);
    
    /*if ($policy_id_staus == false)	{
     echo 'error|policy id is not valid ';
     return ;
     }*/
    
    if ($type == 'policy')	{
      $url ='index.php/hospitalization/policy_details/show_policy_details/'.$id;	
    }
    elseif ($type == 'preauth') {
      $url= 'index.php/hospitalization/preautherization/edit_preauth/'.$id;					
    }
    elseif ($type == 'hospitalization') {
      $url='index.php/hospitalization/hospitalization/edit/'.$id;
    }
    elseif ($type == 'claim') {
      $url= 'index.php/hospitalization/claim/show/'.$id;				
    }
    elseif($type == 'hospital') {
      $url= 'index.php/hospitalization/hospital_management/list_hospitals';
    }
    
    echo 'url|'.$this->config->item('base_url').$url;	
    return ;
  }
  
  
  function claim_subtype_autocomplete(){
    //mail('pankaj.khairnar@gmail.com', 'common controller ', print_r($_GET, true));
    echo 'one|one\n
				  two|two';
  }  
}
