<?php 
 
class Common extends Hosp_base_controller 
{
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
