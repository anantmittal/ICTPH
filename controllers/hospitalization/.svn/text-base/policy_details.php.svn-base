<?php
class Policy_details extends Hosp_base_controller {
	private $data=array();
	public $policy_id;
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('hospitalization/show_policy_lookup_request');

		if(isset($_GET['policy_id']))
		{
			$policy_id = $_GET['policy_id'];
			$check_policy_id = $this->validate_id($policy_id, 'policy', false);
			if($check_policy_id !== true)
			{
				$this->session->set_flashdata('msg_type', 'error');
				$this->session->set_flashdata('msg', 'Policy ID is not valid');
			}
			else
			redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);
		}
	}

	function show_policy_details($policy_id ='')
	{
		$result = $this->validate_id($policy_id, 'policy');
		
		if($policy_id == '' )
		$policy_id = $this->input->get('policy_id');
		$this->data['policy_id'] = $policy_id;
		$this->load->model('admin/policy_type_model','policy_type');			
		$this->load->model('hospitalization/pre_authorization_model','pre_auth');
		$this->load->model('hospitalization/hospitalization_model','hospitalization');
		$this->load->model('hospitalization/claim_model');
		$this->load->model('hospitalization/claim_status_model', 'claim_status');    		
		$this->load->model('hospitalization/claim_cost_item_model', 'claim_cost_item'); 		
		$this->load->model('hospitalization/backend_claim_model','backend_claim');
		$this->load->model('hospitalization/backend_claim_status_model', 'claim_status');    		
		$this->load->model('hospitalization/hospital_model');
		$this->load->model('demographic/person_model','person');
		$this->data['short_context']['short_context'] =& $this->get_short_context($policy_id, 'policy');
		unset($this->data['short_context']['short_context']['family_id']);
		
		$preauth = $this->pre_auth->get_all_preauths($policy_id);
		$hospitalization = $this->hospitalization->get_all_hospitalization($policy_id);      
		$this->data['all_claims_obj'] =& $this->claim_model->get_all_claim_details($policy_id);
		$this->data['all_backend_claims_obj'] =& $this->backend_claim->get_all_backend_claim_details($policy_id);
		$claim = $this->claim_model->get_all_claims($policy_id);
		$this->data['policy_type_obj'] = $this->policy_type;
		$this->data['pre_auth_obj'] = $preauth;
		$this->data['person_obj'] = $this->person;
		$this->data['claim_obj'] = $claim;
		$this->data['claim_cost_item_obj'] = $this->claim_cost_item;
		$this->data['cashless_hospitals'] = $this->hospital_model->get_all_cashless();  		
		$this->data['hospitalizaion_obj'] = $hospitalization;
		$this->load->view('hospitalization/show_policy_lookup_response',$this->data);
	}

}
