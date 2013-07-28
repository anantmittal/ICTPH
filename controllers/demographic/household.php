<?php 
class Household extends CI_Controller
{
  // TODO - should the following variables be global??
  var $family_id;
  var $policy_id;
  var $data = array();
  
  public function Household() {
    parent::__construct();

    $this->load->library('ignitedrecord/ignitedrecord');
    $this->load->library('form_validation');
    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->library('session');
    // Move session to autoload

    $this->load->model('user/user_model', 'user');
    $this->load->model('demographic/person_model','person');
    $this->load->model('demographic/household_model','household');
    $this->load->model('admin/policy_model','policy');
    $this->load->model('admin/enrolled_member_model','enrolled_member');
    $this->load->model('admin/enrolment_statuse_model','enrolment_statuse');
  }

  function add_photos($policy_id) {

    $this->policy_id = $policy_id;
     $house_id = $this->household->find_by('policy_id',$policy_id);
    if(!($members = $this->person->find_all_by('household_id',$house_id->id)))
    {
      $message = "Policy id ".$policy_id." is invalid";
      $this->session->set_userdata('msg',$message);
      redirect('/admin/enrolment/index');
      //      echo "family id [". $family_id. "] is invalid";
      return false;
    }

    // TODO: Try and get only the relevant columns (id, name) here
    
    $this->data['members'] = $members;
    $this->data['policy_id'] = $policy_id;
    
    if (!$_POST) {
      //      $form['values'] = $this->_hospitalization_form_defaults();
      $this->load->view('demographic/edit_photos', $this->data);
      return;
    }
     
    // Is a post request
    if (!$this->save_photos($policy_id, $members)) {
      // TODO: add an error message;
      // $data['values'] = $_POST;
      $this->load->view('demographic/edit_photos' , $this->data);
      return;
    }    
    $message = "Photos for Policy id ".$policy_id." have been uploaded successfully";
    $this->session->set_userdata('msg',$message);
    redirect('/admin/enrolment/index');
  }

  /*
  // TODO: What does edit_ mean for photos?
  function edit_photos($policy_id) {
    // Show older photos to change
    $this->add_photos($policy_id);
  }
  */

  function save_photos($policy_id, $members) {
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $num_files = count($_FILES);

    $config = array('upload_path' => $this->config->item('base_path').'uploads/photos',
		    'allowed_types' => 'gif|jpg|png|jpeg',
		    'max_size' => '2048',
		    'max_width' => '1024',
		    'max_height'  => '1024',
		    'encrypt_name' => false 
		    );

    $this->load->library('upload', $config);

//      $this->db->trans_start();
    $this->db->trans_begin();
    $tx_status = true;

    $member_ids = $_POST['member_id'];
    $i = 0;
    $j = 0;
    foreach ($members as $member) {
	  $filename_var = 'member'.$i;
	  $member_id = $member_ids[$i];

      if($_FILES[$filename_var]['name'] != '') {
	$new_filename = $this->config->item('base_path').'uploads/photos/'.$member_id.'-'.$_FILES[$filename_var]['name'];;
    
        if (!move_uploaded_file($_FILES[$filename_var]['tmp_name'],$new_filename)) {
	$this->data['error'] = $this->upload->display_errors();
	echo "Error2: i=[".$i."; ".$this->upload->display_errors()."]\n";
        $tx_status = false;
        }
	$j++;
      
      $member->has_photo = "Yes";
      $member->image_name = $new_filename;
//      $member->image_name = $this->config->item('base_path').'uploads/photos/'.$file_data['file_name'];
      if(!$member->save())
      {$tx_status = false;}
     }
     else
     { if($member->has_photo == "Yes") {$j++;}}
      $i++;
    }
    if($i == $j) {
      $enrolment_statuse_rec = $this->enrolment_statuse->find_by('policy_id',$policy_id);
      if($enrolment_statuse_rec->photo_status != 1)
      { 
        $enrolment_statuse_rec->photo_status = 1;
        if(!$enrolment_statuse_rec->save())
         {$tx_status = false;}
      }
     }
    if($tx_status == true)
    {
       $this->db->trans_commit();
    }
    else {
       $this->db->trans_rollback();
       return false;
    }
    $this->data["upload_data"] = $this->upload->data();
    return true;
  }
  
  
  function add_blood_group($household_id) {
  	if (!($members = $this->person->find_all_by('household_id',$household_id))) {
      // TODO - this error handling
	   $message = "Household id ".$family_id." is invalid";
	   $this->session->set_userdata('msg',$message);
	   redirect('/admin/enrolment/index');
      return;
    }
    // TODO: Try and get only the relevant columns (id, name) here

    $this->data['members'] = $members;
    $this->data['household_id'] = $household_id;
    $this->data['bgs'] = $this->config->item('bgs');
    
    if (!$_POST) {
      $this->load->view('demographic/edit_blood_group', $this->data);
      return;
    }
     
    // Is a post request
    if (!$this->save_blood_group($household_id, $members)) {
      // TODO: add an error message;
      // $data['values'] = $_POST;
      $this->load->view('demographic/edit_blood_group' , $this->data);
      return;
    }    
	redirect('/admin/enrolment/index');
  }

  function save_blood_group($household_id, $members) 
  {
    $posted_data = $_POST;
	$message = "";

    $i = 0;
    foreach ($members as $member) 
	{
	  $person_rec = $this->person->find($member->id);
	  $var_bg = 'member'.$i.'_blood_group';
	  if($person_rec->blood_group != $posted_data[$var_bg])
	  {
	    $person_rec->blood_group = $posted_data[$var_bg];
	    if(!($person_rec->save()))
	    {
	      echo "Blood group did not save successfully for ",$person_rec->id;
	      return false;
	    }
	   }
	    $message = $message."\n Blood Group set for ".$member->full_name;
        $i++;  
	}
	$message = $message."\n";
	$this->session->set_userdata('msg',$message);
	return true;
  }

  function index($family_id = 0) { 		
    //echo 'here is family id in index method '.$family_id;		
    $this->form_validation->set_rules('family_id', 'Family id', 'required');		
    
    if ($this->form_validation->run() == FALSE && $family_id == 0 ) {
      $this->load->view('family_get_id');
    } 		
    else {
      if($family_id != 0) {
	echo 'fam id through url';
	$family_id = &$family_id;
      }
      
      if (isset($_POST['family_id'])) {
	echo 'fam id through post method';
	$family_id = $this->input->post('family_id');			
      }
      
      //echo $family_id;
      
    //  $data   =  $this->family->get_family_details($family_id);
      $members = $this->person->get_member_details($family_id);
      $illness_info = $this->disease->get_illness_info($family_id);
      $c_illnesses_info = $this->disease->get_cillness_info($family_id);			
      $surgeries_advised = $this->disease->get_surgeries_advised($family_id);			
      $rch_info = $this->disease->get_rch_info($family_id);		
  
      /**
       * @todo : add age and birth date coding here as currently age is showing which was entered at a time of submission
       * it should show approximate age as per current year
       */
  
      foreach ($members as &$one_member) {
	if($one_member['age'] != 0) {
	  // $days = date() - $one_member['date_of_birth']
	  $one_member['date_of_birth'] = $one_member['age'];
	}
      }
      
      $data = $data[0];
      $data['members'] = $members;
      $data['illness_info'] = $illness_info;
      $data['c_illness_info'] = $c_illnesses_info;
      $data['surgeries_advised'] = $surgeries_advised;
      $data['rch_info'] = $rch_info;			
      
      $this->load->view('family_details', $data);
    }
  } 
  


  /**
   * function restore_values_step_two is used to restore values when user enter wrong data while filling step_two form
   * this function simply assign values to data array
   */
  private function restore_values_family_history() {			
    $member_id = $this->input->post('member_id');
    $illness = $this->input->post('illness');
    $days_hospitalised = $this->input->post('days_hospitalised');
    $cost_per_annum = $this->input->post('cost_per_annum');
    $status_of_illness = $this->input->post('status_of_illness');		
    for ($i=0; $i<=6; $i++) {
	$illness_episodes[$i]['person_id'] = $member_id[$i];
	$illness_episodes[$i]['illness_name'] = $illness[$i] ;
	$illness_episodes[$i]['days_of_hospitalization'] = $days_hospitalised[$i];
	$illness_episodes[$i]['cost_of_treatment'] = $cost_per_annum[$i];
	$illness_episodes[$i]['treatment_status'] = $status_of_illness[$i];
    }		
    $this->data['illness_episodes'] = $illness_episodes;
    unset($illness_episodes);	
    
    $ci_member_id = $this->input->post('ci_member_id');
    $ci_illness = $this->input->post('ci_illness');
    $ci_cost_per_month = $this->input->post('ci_cost_per_month');
    $ci_opd_visits = $this->input->post('ci_opd_visits');
    
    $sa_member_name = $this->input->post('sa_member_name');
    $sa_surgeries_advised = $this->input->post('sa_surgeries_advised');
    
    for ($i=0; $i<=4; $i++) {
      $chronic_illness[$i]['person_id'] = $ci_member_id[$i] ;
      $chronic_illness[$i]['illness'] = $ci_illness[$i] ;
      $chronic_illness[$i]['cost_per_month'] = $ci_cost_per_month[$i] ;
      $chronic_illness[$i]['opd_visits_per_month'] = $ci_opd_visits[$i];

      $surgeries_advised[$i]['person_id'] = $sa_member_name[$i];
      $surgeries_advised[$i]['surgeries_advised'] = $sa_surgeries_advised[$i];
    }
    
    $this->data['chronic_illness'] = $chronic_illness;
    $this->data['surgeries_advised'] = $surgeries_advised;		
    unset($chronic_illness);
    unset($surgeries_advised);		
    
    $rch_member_id = $this->input->post('rch_member_id');
    $rch_child_id = $this->input->post('rch_child_id');
    $rch_gender = $this->input->post('rch_gender');
    $rch_anc = $this->input->post('rch_anc');
    $rch_preg_comp = $this->input->post('rch_preg_comp');
    $rch_childbirth_comp = $this->input->post('rch_childbirth_comp');
    $rch_mode_deli = $this->input->post('rch_mode_deli');
    $rch_place_deli = $this->input->post('rch_place_deli');			
    for ($i=0; $i<=3; $i++) {
      $rch_information[$i]['motherId'] = $rch_member_id[$i];
      $rch_information[$i]['childId'] = $rch_child_id[$i];
      if (isset($rch_gender[$i]))
	$rch_information[$i]['gender'] = $rch_gender[$i];
      if (isset($rch_anc[$i])) 
	$rch_information[$i]['anc_taken'] = $rch_anc[$i];
      if (isset($rch_mode_deli[$i])) 
	$rch_information[$i]['mode_of_delivery'] = $rch_mode_deli[$i];
      
      $rch_information[$i]['complications_during_pregnancy'] = $rch_preg_comp[$i];
      $rch_information[$i]['complications_during_childbirth'] = $rch_childbirth_comp[$i];
      
      $rch_information[$i]['place_of_delivery'] = $rch_place_deli[$i];
    }
    $this->data['rch_info']  = $rch_information;
    unset($rch_information);
    
    $this->data['amount_details']['receipt_date']  = $this->input->post('receipt_date');	
    $this->data['amount_details']['receipt_number']  = $this->input->post('receipt_number');	
    $this->data['amount_details']['amount']  = $this->input->post('amount');
  }

  /**
   * form_parse_save_data() : used to call save_data() function for as per table fields and form fields 
   *
   * @param boolean $for_update  true : function is get called for update
   *                             false : functon is get called for insert opration
   */
  private function form_parse_save_data() {
    // saves data of "Information about Illness" section
    $form_fields = array('member_id', 'illness', 'days_hospitalised', 'cost_per_annum', 'status_of_illness');
    $table_fields = array('person_id', 'illness_name', 'days_of_hospitalization', 'cost_of_treatment', 'treatment_status');
    $this->save_data($form_fields, $table_fields, 6, 'illness_episodes');
    
    //saves data of "Chronic illnesses" section
    $form_fields = array('ci_member_id', 'ci_illness', 'ci_cost_per_month', 'ci_opd_visits');
    $table_fields = array('person_id', 'illness', 'cost_per_month', 'opd_visits_per_month');
    $this->save_data($form_fields, $table_fields, 5, 'chronic_illnesses');
    
    
    //saves data of "Surgeries advised" section
    $form_fields = array('sa_member_name', 'sa_surgeries_advised');
    $table_fields = array('person_id', 'surgeries_advised');
    $this->save_data($form_fields, $table_fields, 5, 'surgeries_advised');
    
    //saves data of "Reproductive and Child Health Information" section
    $form_fields = array('rch_member_id', 'rch_child_id', 'rch_gender', 'rch_anc', 'rch_preg_comp', 'rch_childbirth_comp', 'rch_mode_deli', 'rch_place_deli');
    $table_fields = array('person_id', 'child_id', 'gender', 'anc_taken', 'complications_during_pregnancy','complications_during_childbirth','mode_of_delivery', 'place_of_delivery' );
    $this->save_data($form_fields, $table_fields, 4, 'rch_history');
    
    //"receipt_date" "receipt_number" and "amount"		
    $data['receipt_date'] = $this->input->post('receipt_date');
    $data['receipt_number'] = $this->input->post('receipt_number');
    $data['amount_collected'] = $this->input->post('amount');
    $data['date_of_data_entry'] = date('Y-m-d');       
    $this->enrollment->save_enrolment_fields($this->family_id, $data);		
    /*
     if($for_update == false)
     
     else  echo 'for update'; 	   */
    //$this->family->save_enrolment_fields($this->family_id, $data);  
  }
	
	
  /**
   * function save_data() : function used to fetch form data which is same as table fields and 
   * call the modale for saving data to table
   *
   * @param unknown_type $form_fields   : actual from fields 
   * @param unknown_type $table_fields : table fields which are similar to form fields
   * @param unknown_type $num_rows   : number of rows because in some table tehre are only 4 or 5 rows 
   * @param unknown_type $table_name  : table name where data is going to save
   */
  private function save_data($form_fields, $table_fields, $num_rows, $table_name) {
    $data_arr = array();
    $form_fields_cnt = count($form_fields);
    
    switch ($table_name) {
    case 'illness_episodes' : $must_field = 'illness_name';
      break;
    case 'chronic_illnesses' : $must_field = 'illness';
      break;
    case 'surgeries_advised' : $must_field = 'surgeries_advised';
      break;
    }
    
    for($i = 0; $i < $form_fields_cnt; $i++) {
      if( isset($_POST[$form_fields[$i]]) )
	$table_data[$table_fields[$i]] = $_POST[$form_fields[$i]];
    }
    
    
    for($i=0; $i<$num_rows; $i++) { //for rows
      if(($table_name == 'rch_history' && isset($table_data['gender'][$i])
	  && isset($table_data['anc_taken'][$i]) && isset($table_data['mode_of_delivery'][$i]))) {
	foreach ($table_fields as $field) {
	  $row[$field] = $table_data[$field][$i];
	}
      }
      //this elseif is importand and checking all condition agane is also important as for radio button
      //need to use isset and for textboxes need to check with '' blank
      elseif(($table_name == 'rch_history'
	      || (isset($table_data['gender'][$i])
		  ||isset($table_data['anc_taken'][$i])
		  || isset($table_data['mode_of_delivery'][$i])))) {
	break;
      }
      elseif ($table_data[$must_field][$i] != '') {
	foreach ($table_fields as $field) {
	  $row[$field] = $table_data[$field][$i];
	}
      } else {
	break;
      }
      $data_arr[] = $row;
    }		
    $this->family->save_step_two_data($table_name, $data_arr);		
  }
  
  	private function restore_values_edit_family_history()
	{			
		$member_id = $this->input->post('member_id');
		$illness = $this->input->post('illness');
		$days_hospitalised = $this->input->post('days_hospitalised');
		$cost_per_annum = $this->input->post('cost_per_annum');
		$status_of_illness = $this->input->post('status_of_illness');		
		for ($i=0; $i<=6; $i++)
		{
		  	$illness_episodes[$i]['person_id'] = $member_id[$i];
			$illness_episodes[$i]['illness_name'] = $illness[$i] ;
			$illness_episodes[$i]['days_of_hospitalization'] = $days_hospitalised[$i];
			$illness_episodes[$i]['cost_of_treatment'] = $cost_per_annum[$i];
			$illness_episodes[$i]['treatment_status'] = $status_of_illness[$i];
		}		
		$this->data['illness_episodes'] = $illness_episodes;
		unset($illness_episodes);

		
		
		$ci_member_id = $this->input->post('ci_member_id');
		$ci_illness = $this->input->post('ci_illness');
		$ci_cost_per_month = $this->input->post('ci_cost_per_month');
		$ci_opd_visits = $this->input->post('ci_opd_visits');
		
		$sa_member_name = $this->input->post('sa_member_name');
		$sa_surgeries_advised = $this->input->post('sa_surgeries_advised');
		
		for ($i=0; $i<=4; $i++)
		{
		    $chronic_illness[$i]['person_id'] = $ci_member_id[$i] ;
		    $chronic_illness[$i]['illness'] = $ci_illness[$i] ;
		    $chronic_illness[$i]['cost_per_month'] = $ci_cost_per_month[$i] ;
		    $chronic_illness[$i]['opd_visits_per_month'] = $ci_opd_visits[$i] ;		    
		    
		    $surgeries_advised[$i]['person_id'] = $sa_member_name[$i];
		    $surgeries_advised[$i]['surgeries_advised'] = $sa_surgeries_advised[$i];
		}
		
		$this->data['chronic_illness'] = $chronic_illness;
		$this->data['surgeries_advised'] = $surgeries_advised;		
		unset($chronic_illness);
		unset($surgeries_advised);		
		
		$rch_member_id = $this->input->post('rch_member_id');
		$rch_child_id = $this->input->post('rch_child_id');
		$rch_gender = $this->input->post('rch_gender');
		$rch_anc = $this->input->post('rch_anc');
		$rch_preg_comp = $this->input->post('rch_preg_comp');
		$rch_childbirth_comp = $this->input->post('rch_childbirth_comp');
		$rch_mode_deli = $this->input->post('rch_mode_deli');
		$rch_place_deli = $this->input->post('rch_place_deli');			
		for ($i=0; $i<=3; $i++)		
		{
			$rch_information[$i]['motherId'] = $rch_member_id[$i];
			$rch_information[$i]['childId'] = $rch_child_id[$i];
			if (isset($rch_gender[$i]))
			   $rch_information[$i]['gender'] = $rch_gender[$i];
			if (isset($rch_anc[$i])) 
			   $rch_information[$i]['anc_taken'] = $rch_anc[$i];
		    if (isset($rch_mode_deli[$i])) 
			   $rch_information[$i]['mode_of_delivery'] = $rch_mode_deli[$i];
			   
			$rch_information[$i]['complications_during_pregnancy'] = $rch_preg_comp[$i];
			$rch_information[$i]['complications_during_childbirth'] = $rch_childbirth_comp[$i];
			
			$rch_information[$i]['place_of_delivery'] = $rch_place_deli[$i];			
		}
		$this->data['rch_info']  = $rch_information;
		unset($rch_information);
		
		$this->data['amount_details']['receipt_date']  = $this->input->post('receipt_date');	
		$this->data['amount_details']['receipt_number']=$this->input->post('receipt_number');	
		$this->data['amount_details']['amount']  = $this->input->post('amount');			
	}
	
	//Function to add soundex names to all persons in the database
	function add_soundex_to_households()
	{ 
		$this->load->helper('soundex');
		$this->load->model('demographic/household_model','household');
		
		soundex_all($this->household,"street_address","address_soundex",'ret_normalized_address_parts');
		
	}
}
