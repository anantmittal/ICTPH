<?php
class Backend_claim_entry extends Base_controller {
	private  $data = array();
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->library('form_validation');
				
		/*$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');*/
		
		if (!isset($_POST['submit_btn']) || $this->form_validation->run() == FALSE) {
			$this->load->view('hospitalization/show_backend_claim_entry');
		}
		else {
			if($this->save()) {
//				redirect('');
			}
			else {
//				show below view with saving problem
				$this->load->view('hospitalization/show_backend_claim_entry');
			}
		}
	}
	
	function save() {
		echo 'data saving logic will goes here';
	}
}