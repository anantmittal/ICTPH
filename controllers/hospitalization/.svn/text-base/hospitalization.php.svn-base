<?php
class Hospitalization extends Hosp_base_controller {
	
	private $data=array();
	public $person_id;

	private $hospitalization_checks = array(
		     array(
                         'field'   => 'status',
                         'label'   => 'Status',
                         'rules'   => 'callback_check_status' ,
                      ),
        		
                   array(
                         'field'   => 'chief_complaint',
                         'label'   => 'Chief complaint',
                         'rules'   => 'required'
                      ),
                   array(
                         'field'   => 'current_diagnosis',
                         'label'   => 'Current Diagnosis',
                         'rules'   => 'required'
                      ),
                   array(
                         'field'   => 'procedure',
                         'label'   => 'Procedure',
                         'rules'   => 'required'
                      ),   
                   array(
                         'field'   => 'hospitalization_date',
                         'label'   => 'Date of Admission',
                         'rules'   => 'required'
                      )
        );

	function __construct()	{
		parent::__construct();
		$this->load->model('hospitalization/hospitalization_model','hospitalization');
		$this->load->model('hospitalization/pre_authorization_model','pre_auth');
		$this->load->model('hospitalization/hospital_model','hospital');

		$this->load->model('admin/policy_model','policy');
		$this->load->model('admin/enrolled_member_model','enrolled_member');

		$this->load->library('form_validation');
		
	}
	
	function index() {
		
	}
	
	/*function show() {
		$this->load->view('hospitalization/show_hospitalization');
	}*/
	function add_hospital_record($hospitalization_id = 0) {
		$this->validate_id($hospitalization_id, 'hospitalization');
		$this->data['short_context'] = $this->get_short_context($hospitalization_id,'hospitalization');
		$this->load->view('hospitalization/show_enter_hospital_record_form', $this->data);
	}

	function discharge_form($hospitalization_id = 0) {
		$this->validate_id($hospitalization_id, 'hospitalization');
		$this->data['short_context'] = $this->get_short_context($hospitalization_id,'hospitalization');		
		$this->load->view('hospitalization/show_hospital_discharge_form', $this->data);				
	}
		
	function _hospitalization_form_rules() {
     //this function contains all of the field validation rules so bad data can't enter the system  
      return $this->hospitalization_checks;
    }    
	
    function check_status($str) {
		if ($str == 'Select') {
			$this->form_validation->set_message('status_check', 'Please select Status"');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
    
	function _hospitalization_form_defaults() {
    //set default values when calling the Add function the first time, to prevent invalid index errors
    		       
    $values = array(
            			 'id'	=> '',
            			 'status'  => '',
                         'chief_complaint'   => '',
                         'detail_complaint'   => '',
                         'current_diagnosis'   => '',
                         'procedure'   => '',
                         'primary_physician'   => '',
                         'physician_reg_no'   => '',
                         'physician_qualification'   => '',
                         'comments'  => '',
                         'hospitalization_date' => '',
                         'discharge_date' => '',
                                              
                      );
                    
        return $values;
    }
        
    function add($pre_auth_id = 0) {

     $num_recs = $this->policy->where('id', $pre_auth_id)->count();
     if($num_recs == 0)
     {
      $this->validate_id($pre_auth_id, 'preauthorization');
      
      $form = $this->_hospitalization_form_rules();
      $form['short_context'] = $this->get_short_context($pre_auth_id, 'preauthorization');

      unset($form['short_context']['hospitalization_id']);
      unset($form['short_context']['family_id']);
      unset($form['short_context']['policy_status']);
      unset($form['short_context']['policy_status']);
      unset($form['short_context']['used_amount']);
      unset($form['short_context']['policy_end_date']);
      unset($form['short_context']['blocked_amount']);
      unset($form['short_context']['available_amount']);
      unset($form['short_context']['family_head']);
      unset($form['short_context']['household_id']);
	  
      $this->form_validation->set_rules($form);
      $pre_auth_data = $this->pre_auth->find($pre_auth_id);
   
      $form['action'] = "add";
      $form['pre_auth_object'] = $pre_auth_data;
      $policy_id = &$form['short_context']['policy_id']; 
    }
    else
    {
      $form = $this->_hospitalization_form_rules();
      $form['short_context'] = $this->get_short_context($pre_auth_id, 'policy');
      $policy_id = &$form['short_context']['policy_id']; 
      $this->form_validation->set_rules($form);
      $form['action'] = "add_new";
      $form['person_obj'] = $this->enrolled_member->get_members_by_policy_id($policy_id);		
      $form['hospital_obj'] =& $this->hospital;
    }

      if (!$_POST) {
      	$form['policy_id'] = &$form['short_context']['policy_id'];      	
      	$form['values'] = $this->_hospitalization_form_defaults();
      	$this->load->view('hospitalization/show_hospitalization', $form);
      	return;
      }
      // Is a post request
      if ( $this->form_validation->run() == FALSE || !$this->save_hospitalization($policy_id, $pre_auth_id,'add') ) {      	
      	$_POST['policy_id'] = $policy_id;
      	$form['values'] = $_POST;
      	$this->load->view('hospitalization/show_hospitalization', $form);
      }

     }

    function save_hospitalization($policy_id, $id, $action) {
    	/*echo '<pre>';
    	print_r($_POST);
    	echo '<pre>';die()*/;
      
      $this->load->library('date_util');
  	  $data  = $_POST;
  	  
//    $this->db->trans_start();
    $tx_status = true;
    $this->db->trans_begin();
      if($data['pre_auth_id'] != 0)
         $pre_auth_data = $this->pre_auth->find($data['pre_auth_id']);
      $data['policy_id'] = $policy_id;
//      $data['hospitalization_date'] = Base_controller::change_date_format($data['hospitalization_date']);
      $data['hospitalization_date'] = Date_util::change_date_format($data['hospitalization_date']);
      $data['discharge_date'] = Date_util::change_date_format($data['discharge_date']);
      
      $data['last_preauth_id'] = $data['pre_auth_id'];
      if($data['current_diagnosis'] == 'Other') {
      	$data['current_diagnosis'] = $data['current_diagnosis_other'];
      }
      if($data['procedure'] == 'Other') {
      	$data['procedure'] = $data['procedure_other'];
      }

      if($data['status'] == 'Admitted')
       $data['discharge_date'] = '0000-00-00';
      if($action == 'add') {
        if($data['pre_auth_id'] != 0)
      	    $data['person_id'] = $pre_auth_data->person_id;
       	$hospitalization_rec = $this->hospitalization->new_record($data);
       	$tx_status = $hospitalization_rec->save() AND $tx_status;      	
 //		update the $hospitalization_id column of pre_autherization table when new record will be inserted into hospitalization table
      	$hospitalization_id = $hospitalization_rec->uid();
//		check hospitalization_id of pre_autherization table. insert hospitalization_id only if its 0.
        if($data['pre_auth_id'] != 0)
        {
      	 $preauth_rec = $this->pre_auth->find_by('id',$data['pre_auth_id']);
      	 $preauth_rec->hospitalization_id = $hospitalization_id;
      	 $preauth_rec->preauth_status = $data['status'];
      	 $tx_status = $preauth_rec->save() AND $tx_status;
	 $prev_preauth_id = $preauth_rec->prev_preauth_id;
	 while($prev_preauth_id != 0)
	 {
		$preauth_rec = $this->pre_auth->find($prev_preauth_id);
      		$preauth_rec->hospitalization_id = $hospitalization_id;
//	      	$preauth_rec->preauth_status = $data['status'];
      		$tx_status = $preauth_rec->save() AND $tx_status;
		$prev_preauth_id = $preauth_rec->prev_preauth_id;
	 }
       }
		
      }
      else {
      	$hospitalization_rec = $this->hospitalization->find($id);
//       	$hospitalization_rec->discharge_date =Base_controller::change_date_format($hospitalization_rec->discharge_date);
       	$hospitalization_rec->discharge_date = Date_util::change_date_format($hospitalization_rec->discharge_date);
//      	$hospitalization_rec->hospitalization_date = Base_controller::change_date_format($hospitalization_rec->hospitalization_date);
      	$hospitalization_rec->hospitalization_date = Date_util::change_date_format($hospitalization_rec->hospitalization_date);
	if($hospitalization_rec->last_preauth_id !=0 && $hospitalization_rec->status != $data['status'])
	{
      	    $preauth_rec = $this->pre_auth->find($hospitalization_rec->last_preauth_id);
      	    $preauth_rec->preauth_status = $data['status'];
      	    $tx_status = $preauth_rec->save() AND $tx_status;
	}
		
      	$hospitalization_rec->load_data($data);
      	$tx_status = $hospitalization_rec->save() AND $tx_status;
      }
    if($tx_status == true)
    {
       $this->db->trans_commit();
    }
    else {
       $this->db->trans_rollback();
       return false;
    }
//    $this->db->trans_complete();
      redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);
      return true;
    }

    function edit($hospitalization_id) {    	
		$this->validate_id($hospitalization_id, 'hospitalization');
		$form = $this->_hospitalization_form_rules();	
    	$hospitalization_arr = $this->hospitalization->find($hospitalization_id);
    	$data['short_context'] = $this->get_short_context($hospitalization_id, 'hospitalization');
        $data['hospitalization_id'] = $data['short_context']['hospitalization_id'];    
      	unset($data['short_context']['hospitalization_id']);      
       	     
            
		$policy_id =& $data['short_context']['policy_id'];
    	$this->form_validation->set_rules($form);
		$data['action'] = "edit";
		
		
		//$this->form_validation->run() == false works in two ways one:if post data not set , two: if validation fails
		if ($this->form_validation->run() == FALSE || !$this->save_hospitalization($policy_id, $hospitalization_id,'edit'))	{	
			if (! $_POST) {
				$data['policy_id'] = $policy_id;
				$data['values'] = (array) $hospitalization_arr;				
			}
			else {
				$data['values'] = $_POST;
			}
			$this->load->view('hospitalization/show_hospitalization', $data);
		}        
    }
    
    /**
	 * @uses : (For Arvind to ask) : what about the error echeck of the following function as we are uploading file as well as data at
	 * same time if data is not save properly we are not proceding to file upload but what if data is got saved and file do not 
	 * get uploaded. do we need to delete that record. 
	 */
	
	function save_hospital_record($hospitalization_id = 0) {	
		
		$result = $this->validate_id($hospitalization_id, 'hospitalization', false);		
		
		if($result !== true) {
			echo str_replace('error','1',$result);
		                           	return ;				 	
		}	
		
		/*mail('pankaj.khairnar@magnettechnologies.com', 'hospital record add', 'records :'. print_r($_POST,true));
		die();*/
		
		$cnt = 1;
		$error = 0;
		$message = 'Record added successfully.';

		$report_date = $this->input->post('report_date');
		
		if($report_date == ''){
		  echo '1|Report Date CANNOT be empty.';		
		  return ;
		}

		
	    $date_exp = '/^((((31\/(0?[13578]|1[02]))|((29|30)\/(0?[1,3-9]|1[0-2])))\/(1[6-9]|[2-9]\d)?\d{2})|(29\/0?2\/(((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))|(0?[1-9]|1\d|2[0-8])\/((0?[1-9])|(1[0-2]))\/((1[6-9]|[2-9]\d)?\d{2}))$/';
		if(preg_match($date_exp, $report_date) === 0){
			echo '1|Please enter "Record Date" in proper format.';		
			return ;
		}
		

		$this->load->model('hospitalization/hospital_record_model', 'hospital_record');
		$this->load->library('date_util');
		$data = array();
		$data['hospitalization_id'] = $hospitalization_id;


//	    $data['reporting_on'] = date('Y-m-d',strtotime($this->input->post('report_date')));
		$data['reporting_on'] = Date_util::change_date_format($this->input->post('report_date'));
		$data['record_type'] = $this->input->post('report_type');    
	    $message = 'Record for Report type "'. ucfirst($data['record_type']). '" added successfully.';
	    
	    if($data['record_type'] == 'note') {
	    	if($_POST['note'] == '' || 
	    					$_POST['by'] == ''){
	    		echo '1|"Note" Or "Written by" fields CANNOT be empty.';
		  		return ;
	    	}

	    	$data['sub_type'] = $this->input->post('note_type');
	    	unset($_POST['note_type']);	    	
	    }
	    elseif ($data['record_type'] == 'diagnostic report') {
	    	if($_POST['diagnostic_type'] == 'Lab Test') {
		    	if($_POST['diagnostic_type_text']== '' || $_POST['value']== '' || $_POST['by']== '') {
		    		echo '1|"Test" Or "Value" Or "Conducted By" fields CANNOT be empty.';
			  		return ;
		    	}
	    	}
	    	else {
	    		if($_POST['lab_name']== '') {
		    		echo '1|"Lab Name" field CANNOT be empty.';
			  		return ;
		    	}
		    	
		    	if($_POST['lab_test_text'] == '' ){					
		    		//@todo : validation condition is not proper here also need to check either file uploaded or this text added
		    		echo '1|"Text" field CANNOT be empty.';
			  		return ;
		    	}
	    	}
	    	
	    	$data['sub_type'] = $this->input->post('diagnostic_type');
	    	unset($_POST['diagnostic_type']);	    		    	
	    }
	    elseif ($data['record_type'] == 'vital signs') {	    	
	    	if($_POST['by']== ''){
	    		echo '1|"Recorded by" field CANNOT be empty.';
		  		return ;
	    	}
//	    	mail('pankaj.khairnar@magnettechnologies.com', 'hospital record add- vital signs', 'records :'. print_r($_POST,true));
	    }
	    elseif ($data['record_type'] == 'medication administration') {
	    	if($_POST['name_of_medicine']== '' || $_POST['amount']== '' || $_POST['duration']== '' || $_POST['comment']== ''){
	    		echo '1|"Name of medicine" Or "Amount" Or "Duration" Or "Comment" fields CANNOT be empty.';
		  		return ;
	    	}
	    	
	    	$data['sub_type'] = $this->input->post('medication_type');
	    	$dosage = array('amount'=>$this->input->post('amount'), 'unit'=>$this->input->post('unit'), 
	    					'frequency'=>$this->input->post('frequency'));
	        $_POST['dosage'] = &$dosage;	        
	        unset($_POST['amount']);
	        unset($_POST['unit']);
	        unset($_POST['frequency']);
	    	unset($_POST['medication_type']);
	    }	    
	    elseif ($data['record_type'] == 'other') {
	    	if($_POST['comment']== ''){
	    		echo '1|"Comment" field CANNOT be empty.';
		  		return ;
	    	}
	    }

    	    
	    if(isset($_POST['by'])){
	    	$data['by'] = $this->input->post('by');
	    }
	    else $data['by'] = '';
	    
	    
	    $data['comment'] = $this->input->post('comment');
	    
	    
		unset($_POST['report_type']);	
		unset($_POST['by']);	
	    unset($_POST['report_date']);
	    unset($_POST['submit']);
	    unset($_POST['comment']);
	    
		
	    $data['serialize_records'] = serialize($_POST);	    
		
//    $this->db->trans_start();
    $tx_status = true;
    $this->db->trans_begin();
		$rec  = $this->hospital_record->new_record($data);		
		$result = $rec->save();
		if($result === false){			
			echo $error = 1;
			echo '|'.'Error occured while saving the data.';
		  $tx_status = FALSE;
			break;
//			return ;
		}
		
//        mail('pankaj.khairnar@magnettechnologies.com', 'hospital record add', var_export($result, true));
		$data['hospital_record_id'] = $rec->uid();

		//below line create object onthefly using factory method
		$this->record_attachment = IgnitedRecord::factory('hospital_record_attachments');	

		

		if (count($_FILES) > 0) {
			foreach ($_FILES as $file_key => &$file_array) {
               if($_FILES[$file_key]['name'] != '')  {
               	
//                 $file_name = $cnt .$_FILES[$file_key]['name']; 
                 $file_name = $_FILES[$file_key]['name']; 
//                 $file_ext = substr($file_name, strrpos($file_name,"."));                                  
                 
                 $file_prefix = $data['hospital_record_id'].'_'.$data['record_type'];
                 
//                 $new_file_name = $this->get_new_file_name($file_prefix, $file_ext);
                 $new_file_name = $this->get_new_file_name($file_prefix, $file_name);
                 
                 $file_path = $this->config->item('base_path').'uploads/hospital_record_files/'.$new_file_name;

				 if(!move_uploaded_file($_FILES[$file_key]['tmp_name'], $file_path)) {
				 	echo $error = 1;
				 	echo '|'. $message = 'Error occured while file uploading';
					$tx_status = false;
					break;
//				 	return ;
				 }

				 $data['file_name'] = $new_file_name ;
				 //$data['description'] = 'my description';
				 $record_attachment_rec = $this->record_attachment->new_record($data);
				 $result = $record_attachment_rec->save();
				 if($result === false){
				 	echo $error = 1;
				 	echo '|Error occured while saving record in hospital_record_attachments table.';
		  	$tx_status = FALSE;
			break;
				 }
				 $cnt++;
               }
               else {
               	 break;
               }
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
//    $this->db->trans_complete();
		echo $error; //prints error which is handle in javascript to check error exist if $error not equal to zero
		echo '|'. $message;  //then this message use showing eror in red color
	return true;
	}

	/**
	 * new_file_name()  function used to check file name exist or not if no then it create new filename and send it.
	 *
	 */
//	private function get_new_file_name($file_prefix, $file_ext) {		
	private function get_new_file_name($file_prefix, $file_name) {		
		$new_file_name = $file_prefix.'_'.rand(1,999).'_'.$file_name;
//	mail('pankaj.khairnar@magnettechnologies.com', 'new rec name', 'new rec name:'.$file_name);			
		if (file_exists($file_path.$new_file_name)) {
		  return $this->get_new_file_name($file_prefix, $file_name);
		}		
		else return $new_file_name;
	} 

}

