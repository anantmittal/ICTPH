<?php
/**
 * hospital management functionality
 * uploading rate-list file functionality is remain in add-hospital and edit-hospital page
 * and on edit-hospital page if file is already there thene there should be remove and new version 
 * uploading option there.
 *
 */


class Hospital_management extends Hosp_base_controller {
	private  $data=array();
	function __construct()
	{
		parent::__construct();
		$this->load->model('hospitalization/hospital_model','hospital');
		$this->load->library('form_validation');
	}
	function index()
	{	
	  redirect('hospitalization/hospital_management/list_hospitals');
	}	

	function add_hospital() {
	 
	   $this->set_dist_list();
	  // Is Get request
	  if (!isset($_POST['submit']))
	  	$this->load->view('hospitalization/show_add_hospital',$this->data);
	  else {

	  	$this->form_validation->set_rules('name', 'Name', 'required');
	  	$this->form_validation->set_rules('registration_number', 'Registration Number', 'required|callback_registration_num_exist');

	  	$this->form_validation->set_error_delimiters('<label class="error">', '</label>');

	  	if ($this->form_validation->run() && $this->save()) {	  		
	  		redirect('hospitalization/hospital_management/list_hospitals');
	  	}
	  	else {		  		  		
	  		/**
	  	 * @uses : Error occured while saving is assigned in save function in $this->data variable
	  	 */
	  		$this->load->view('hospitalization/show_add_hospital',$this->data);	  		
	  		return;
	  	}
	  }
	}	

	function edit_hospital_()
	{
		$new_url = $this->config->item('base_url').'index.php/hospitalization/hospital_management/edit_hospital/'.$_POST['hosp_id_edit'];
		redirect($new_url);
	}

	/**
	 * function edit_hospital()
	 * @todo(Pankaj) : on edit hospital page currently it is not showing previously selected policy_types
	 * as I am taking multiple select field for showing policy_list and saving its data as a serialize
	 * array in db
	 * 
	 * @param unknown_type $hospital_id
	 */
	function edit_hospital($hospital_id = false)
	{
		$this->data['action'] = 'Edit';
	    if (!$hospital_id) {
			show_error('HOSPITAL ID IS NOT ENTERED  ADD IT AS A LAST ARGUMENT IN URL');
		}

		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('name', 'Name', 'required');			
			$this->form_validation->set_error_delimiters('<label class="error">', '</label>');			

			if ($this->form_validation->run() == FALSE)	{		
//				echo 'validation false';
				$this->load->view('hospitalization/show_add_hospital', $data);
			}
		    else {
				$this->save($hospital_id);
				redirect('hospitalization/hospital_management/list_hospitals');
			}
		}
		else {
			$rec = $this->hospital->find($hospital_id);
			if ($rec != false) {
				$this->set_dist_list();
				$this->data['hosp_obj'] = &$rec;				
				$this->load->view('hospitalization/show_add_hospital',$this->data);
			}
			else {
				//hospital id is not found show error
				show_error('HOSPITAL-ID IS NOT FOUND IN DATABASE');
			}
		}
	}

	private function save($hospital_id = false) {
		$form_data = &$_POST;	
		
		$this->load->library('upload');
        $config['upload_path'] = $this->config->item('base_path').'uploads/rate_list_files/';
	    
//		$config['allowed_types'] = 'gif|jpg|png|pdf';
		$config['allowed_types'] = 'application/force-download'|'application/pdf';
		$config['max_size']	= '2048';
		
//		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$old_file_name = $_FILES['rate_list']['name'];

                $new_file_name = $form_data['registration_number'].'-'.$form_data['name'].'-'.$old_file_name;
                 
                 $file_path = $this->config->item('base_path').'uploads/rate_list_files/'.$new_file_name;

		if ($_FILES['rate_list']['name'] != ''){
		
//			if ( ! $this->upload->do_upload('rate_list'))
			if ( !move_uploaded_file($_FILES['rate_list']['tmp_name'],$file_path))
			{
				$this->data['upload_error'] = array('error' => $this->upload->display_errors());
				$data = $this->upload->data();
				echo 'file type '.$data['file_type'].$this->upload->display_errors('<p>', '</p>');
				show_error('file uploading error');
				return false;
			}
			else
			{
//				$data = $this->upload->data();
//				$form_data['rate_list_file'] = $data['file_name'];
				$form_data['rate_list_file'] = $new_file_name;
			}
		}		
		
	  	$cashless_policy =  $this->input->post('cashless_policy');
	  	$form_data['cashless_policy'] = serialize($cashless_policy);
	  
	  	if ($hospital_id != false) {
			//$form_data['id'] = $hospital_id;
			$rec = $this->hospital->find($hospital_id);				
			$form_data_keys = array_keys($form_data);
			$rec->load_postdata($form_data_keys);
			$msg = 'Hospital record saved successfully.';
		}
		else {
			$rec = $this->hospital->new_record($form_data);	
			$msg = 'New hospital added successfully';
		}
	  
	  $result = $rec->save();
	  if($result === false){
	  	$msg_type = 'error';
	  	$return_type = false;
	  }	
	  else {
	  	$msg_type = 'success';	
	  	$return_type = true;
	  }
	  
	  $this->session->set_flashdata('msg_type', $msg_type);
	  $this->session->set_flashdata('msg', $msg);	  
      return $return_type;     
	}
	
	function set_dist_list(){
	  $dist_list = array();	
	  $this->load->model('geo/district_model','district');
	  $recs = $this->district->find_all();	    
	    
	  foreach ($recs as $rec){	  	
	  	$dist_data =  &$rec->get_data();	  	 
	  	$this->data['dist_list'][$dist_data['id']] = &$dist_data['name'];	  	
	  }
		
	}

	function list_hospitals($hosp_search = null) {      
          if($hosp_search == null)
    	  {
	    $this->load->model('hospitalization/hospital','hospital');
	    $data['hospital_list'] = $this->hospital->find_all_complete();	  
	  }
	  else {
            $data['hospital_list'] = $this->hospital->is_name($hosp_search);
 	  }	  
	  $this->load->view('hospitalization/show_hospital_list', $data);		
	}
	
	function show_hospital_dues(){
	  $this->load->model('hospitalization/hospital_model', 'hospital');	  
	  $this->load->view('hospitalization/show_hospital_payment_due');
	}
	
	
	 function registration_num_exist($reg_num){
		$rec = $this->hospital->find_by('registration_number', $reg_num);		
		if ($rec == false) // $rec is false means reg_num do not exist in database
			return true;
		else {
			echo 'The Registration number %s already exist in database.';
			$this->form_validation->set_message('registration_number', 'The Registration number %s already exist in database.');			
			return false;
		}		
	}

}
