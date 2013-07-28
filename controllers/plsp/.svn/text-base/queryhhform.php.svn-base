<?php

class QueryHhForm extends CI_Controller {
	var $typeList = array("Adult"=>"plsp_adult","Adolescent"=>"plsp_adolescent","Child"=>"plsp_child","Infant"=>"plsp_infant");
	function index()
	{
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('form_validation');
			
		$this->form_validation->set_rules('hhname', 'Household ID', 'trim|required|callback_hhid_check');
			
		if ($this->form_validation->run() == FALSE)
		{
      			$this->session->set_userdata('msg', 'Invalid Household ID: '.set_value('hhname'));
		        redirect('/plsp/search/home');
		}
		else
		{
			redirect('/plsp/queryhhform/display_household/'.set_value('hhname'));
			//$this->display_household(set_value('hhname'));
		}
	}
	
	function display_household($id)
	{
		$this->__load_all_models();
		$this->load->model('demographic/household_model', 'household');
		
		if($policy_id = $this->household->get_valid_policy_for_household($id))
		{
			if($persons = $this->household->get_members_for_valid_policy($id))
			{
				$data['hhid']=$id;
				$data['policy_id']=$policy_id;
				$individuals=array();
				foreach($persons as $indi)
				{
					$rowData=array();
					$rowData['individual_id']=$indi->organization_member_id;
					$rowData['full_name']=$indi->full_name;
					$rowData['relation']=$indi->relation;
					$rowData['gender']=$indi->gender;
					$rowData['age']=$indi->age;
					$plspDetails=$this->__get_plsp_details($indi->organization_member_id);
					if($plspDetails[0]!=NULL)
					{
						$rowData['plsp']=1;
						if($plspDetails[1]!=NULL)
						{	
							$rowData['plsp_status']=$plspDetails[1]->status;
						}
					}
					$individuals[]=$rowData;
				
				}
				$data['individuals']=$individuals;
				$this->load->view('survey/plsp/household', $data);
			}
			else
			{
				$this->session->set_userdata('msg',"Household $id not found");
				$this->load->view('survey/plsp/home');
			}
		}
		else
		{
			$this->session->set_userdata('msg',"Household $id does not have a valid policy");
			$this->load->view('survey/plsp/home');	
		}
	}
	function printable_top_sheet($hhid)
	{
		$this->__load_all_models();
		$this->load->model('demographic/household_model', 'household');
		
		if($hh_org_id = $this->household->get_valid_household_for_org_id($hhid))
		{
			$ret = $this->household->get_household_summary($hh_org_id);
			$this->load->view('survey/plsp/hh_top_sheet', $ret);
		}
		else
		{
			$this->session->set_userdata('msg',"Household $id not found");
			$this->load->view('survey/plsp/home');	
		}
	}
	function __get_plsp_details($id)
	{	
		$report=NULL;
		$summary=NULL;
		foreach($this->typeList as $type=>$modelName)
		{
			$model=$this->{"$modelName"};
			$report = $model->find_by_id($id);
			$summary_model_name=$modelName."_summary";
			if($report!=NULL)
			{	
				$summary_model=$this->{"$summary_model_name"};
				$summary = $summary_model->find_by($modelName."_id", $report->id);	
				break;
			}
		}
		return array($report, $summary);	
	}

	function __load_all_models()
	{
		foreach($this->typeList as $type=>$modelName)
		{
			$this->load->model('survey/plsp/'.$modelName."_model",$modelName);
			$summary_model_name=$modelName."_summary";
			$this->load->model('survey/plsp/'.$summary_model_name."_model",$summary_model_name);
		}
	}

	function mne_pisp_launcher($id, $policy)
	{
		if (!$this->session->userdata('location_id')) {
	      $this->session->set_flashdata('msg_type', 'error');
	      $this->session->set_flashdata('msg', 'Location must be chosen before administering PISP');
	      redirect('opd/visit/home');
	    }
		$this->load->model('demographic/person_model','person');
		if($rec= $this->person->find($id))
			redirect('plsp/queryhhform/mne_pisp_qna_launcher/'.$rec->organization_member_id);
		else
		{
	
			$this->session->set_userdata('msg', "Invalid ID");
			redirect('plsp/search/home');
		}
		
	}
	public function is_logged_in_user_hew(){
		$this->load->model('user/users_role_model', 'user_role');
		$this->load->model('user/role_model', 'role');
		$this->load->model('user/user_model', 'user');
		$username = $this->session->userdata('username');
		$user_rec = $this->user->find_by('username' ,$username);
		$user_role_rec = $this->user_role->find_all_by('user_id',$user_rec->id );
		$hew_login = true;
		foreach($user_role_rec as $user_role){
			$role_rec = $this->role->find_by('id', $user_role->role_id);
			if($role_rec->name == "Clinician" || $role_rec->name == "Lab Technician" || $role_rec->name=="admin" ){
				$hew_login = false;
				break;
			}
		}
	
		return $hew_login;
	}
	function mne_pisp_qna_launcher($org_id)
	{
		$this->load->model('demographic/person_model', 'person');
		$modelarr = $this->__pisp_model_picker($org_id);
		$model = $modelarr[0];
		$message = $modelarr[1];
		
		if($model == NULL)
		{
			$this->session->set_userdata('msg',$message);
			redirect('plsp/search/home');
			return;
		}

		$hew_login = $this->is_logged_in_user_hew();

		//Now check if there are existing responses already available
		$responses = $model->get_ids_and_payload_for_org_id($org_id);
		$forms = $this->__pisp_form_picker($org_id);
		
		$prefill = $this->person->get_summary_by_org_id($org_id);
		$person_rec = $this->person->find_by('organization_member_id', $org_id);  // to get person_id
		$household_rec = $person_rec->related('household')->get();				  // to get policy_id		
		$data = array('responses'=>$responses, 'forms'=>$forms, 'prefill'=>$prefill,'hew_login'=>$hew_login,'person_id'=>$person_rec->id,'policy_id'=>$household_rec->policy_id);
		$this->load->view('survey/plsp/plsp_picker', $data);
	}

	function mne_pisp_prefill_launcher($srun_id =0,$form_id=0,$runtime_form = 0)
	{
		$this->load->model('mne/form_model', 'form');
		$form_rec = $this->form->find($form_id);
		if($_POST){
			$this->form_data['srun_id'] = $srun_id;
			$this->form_data['form'] = $form_rec;
			$this->form_data['runtime_form'] = $runtime_form;
			$this->form_data['prefill']=$_POST;
			$this->form_data['action']=base_url().'index.php/mne/form/add_data/'.$srun_id.'/'.$form_id.'/'.$runtime_form;
			
			$this->load->view('mne/form_add_data', $this->form_data);
			return;
		}
	}

	function __pisp_model_picker($org_id)
	{
		$ret = array(NULL, "");
		$this->load->model('demographic/person_model', 'person');
		$age =0;
		$this->load->library('date_util');
		if($rec = $this->person->find_by('organization_member_id', $org_id))
		{
			$year = $rec->date_of_birth;
			$age = Date_util::age_in_months($year);
		}
		else
		{
			$ret[1] = "Individual(".$org_id.") does not exist.";
			return $ret;
		}
		//Now based on age, pick up one of the PISP types
		if($age < 6)
		{
			$ret[1]="Infant not old enough for PISP";
		}
		else if($age>=6 && $age<=24)
		{//Infant
			$this->load->model('mne/forms/mne_pisp_infant_model', 'mne_infant');
			$ret[0] = $this->mne_infant;
		}
		else if($age>24 && $age<=120)
		{//Child
			$this->load->model('mne/forms/mne_pisp_child_model', 'mne_child');
			$ret[0] = $this->mne_child;
		}
		else if($age>120 && $age<=228)
		{ //Adolescent
			$this->load->model('mne/forms/mne_pisp_adolescent_model', 'mne_adolescent');
			$ret[0] = $this->mne_adolescent;
		}
		else
		{//Otherwise assume an adult
			$this->load->model('mne/forms/mne_pisp_adult_model', 'mne_adult');
			$ret[0] = $this->mne_adult;
		}
		return $ret;
	}

	function __pisp_form_picker($org_id)
	{
		$ret = array();
		$this->load->model('demographic/person_model', 'person');
		$age =0;
		$this->load->library('date_util');
		if($rec = $this->person->find_by('organization_member_id', $org_id))
		{
			$year = $rec->date_of_birth;
			$age = Date_util::age_in_months($year);
		}
		else
		{
			return $ret;
		}
		//Now based on age, pick up one of the PISP types
		if($age < 6)
		{
			return $ret;
		}
		else if($age>=6 && $age<=24)
		{//Infant
			$ret[base_url()."index.php/plsp/queryhhform/mne_pisp_prefill_launcher/1/17000"] = 'Infant PISP';
		}
		else if($age>24 && $age<=120)
		{//Child
			$ret[base_url()."index.php/plsp/queryhhform/mne_pisp_prefill_launcher/1/14000"] = 'Child PISP';
		}
		else if($age>120 && $age<=228)
		{ //Adolescent
			$ret[base_url()."index.php/plsp/queryhhform/mne_pisp_prefill_launcher/1/12000"] = 'Adolescent PISP';
		}
		else
		{//Otherwise assume an adult
			$ret[base_url()."index.php/plsp/queryhhform/mne_pisp_prefill_launcher/1/10000"] = 'Adult PISP';
		}
		return $ret;
	}

	function get_all_svg()
	{
		$this->load->model('survey/plsp/plsp_svg_model','svg');
		$result="";
		if($indis = $this->svg->get_all_svgs())
		{	
			foreach($indis as $code=>$name)
			{
				$result = $result.'<option value="'.$code.'">'.$name.'</option>';
			}
		}
		echo $result;
		//return $result;
	}
}
?>
