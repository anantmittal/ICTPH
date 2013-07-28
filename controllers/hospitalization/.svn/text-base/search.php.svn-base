<?php 
 
class Search extends Hosp_base_controller 
{
  function __construct() {
    parent::__construct();
    $this->load->model('demographic/person_model', 'person');
    $this->load->model('demographic/household_model', 'household');
    $this->load->model('admin/policy_model', 'policy');
    $this->load->model('admin/enrolled_member_model', 'enrolled_member');
    $this->load->model('hospitalization/hospital_model', 'hospital');
    
    $this->load->library('form_validation');
  }
  
  function home() {
    if($this->session->userdata('username')!=null) {
      $this->load->view('hospitalization/home');
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

    if ($in == "hospital" && $by == 'id' && $key=="All") {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "hospital" && $by == "id" && $this->hospital->find($key)) {
      log_message("debug", "TRUE!");
      $status = true;

      log_message("debug", "Search status = ".$status);
      echo json_encode($status);
      return;
    }

    if ($in == "hospital" && $by == "name" && $this->hospital->is_name($key)) {
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
      $url ='index.php/hospitalization/policy_details/show_policy_details/'.$key;	
    }

    if ($in== 'household' && $by =='name')	{
//      $url ='index.php/admin/enrolment/search_policies_by_name/'.$key.'"/index.php/hospitalization/policy_details/show_policy_details/"';	
      $url ='index.php/admin/enrolment/search_policies_by_name/'.$key.'/hospitalization';	
    }
    
    if($in == 'hospital' && $by == 'id' ) {
      $url= 'index.php/hospitalization/hospital_management/edit_hospital/'.$key;
    }

    if($in == 'hospital' && $by == 'id' && $key =='All') {
      $url= 'index.php/hospitalization/hospital_management/list_hospitals';
    }

    if($in == 'hospital' && $by == 'name' ) {
      $url= 'index.php/hospitalization/hospital_management/list_hospitals/'.$key;
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
