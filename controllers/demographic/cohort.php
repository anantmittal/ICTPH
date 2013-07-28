<?php 
class Cohort extends CI_Controller
{
	var $typeList = array("Adult"=>"plsp_adult","Adolescent"=>"plsp_adolescent","Child"=>"plsp_child","Infant"=>"plsp_infant");
	function create()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Cohort Name', 'trim|required|callback_cohortname_check');
		if ($this->form_validation->run() == FALSE)
		{
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			$this->load->view ('demographic/cohort_add_edit', array("target"=>base_url()."index.php/demographic/cohort/create"));
			return;
		}
		//This means that the validation is done
		$this->add();
	}

	function view()
	{
		if($_POST)
		{
			$id=$_POST['viewcohort'];
			redirect('demographic/cohort/view_summary/'.$id); 
		}
	}

	function modify()
	{
		if($_POST)
		{
			$id=$_POST['editcohort'];
			redirect('demographic/cohort/edit/'.$id); 
		}
	}
	function edit($id='')
	{
		
		$this->load->library('form_validation');
		if($this->form_validation->run() == FALSE)
		{
			$this->load->model('demographic/cohort_model','cohort');
			$data=$this->cohort->get_cohort_details($id);
			$data['target']= base_url()."index.php/demographic/cohort/create";
			$this->load->view ('demographic/cohort_add_edit', $data);
			return;
		}
		//This means that the validation is done
		$this->add();
	}
	function cohortname_check($str)
	{
		$this->load->model('demographic/cohort_model','cohort');
		$ret = TRUE;
		if($id = $this->cohort->get_id_for_name(trim($str)))
		{
			//One exists in the database. Now decide if this is an add or edit
			if((array_key_exists('id',$_POST)) && ($this->input->post('id')==$id)) // If this is true then it's an edit
			{
				$ret = TRUE;
			}
			else
			{
				$this->form_validation->set_message('cohortname_check', 'A cohort with this name already exists. Please choose a unique name');
				$ret = FALSE;
			}
		}
		return $ret;
	}
	
	function add()
	{
		$this->load->model('demographic/cohort_model','cohorts');
		$this->load->model('demographic/person_model','persons');
		$this->load->model('demographic/household_model','households');
		$constituents = array('persons','households','cohorts');
		$events = $this->input->post('events');
		$persons = array();
		$invalidlist = array();
		$invalidstring="";
		foreach($constituents as $entity)
		{
			if($events && array_key_exists($entity, $events))
			{
				$invalid[$entity] = $this->{"$entity"}->prune_invalid_org_ids($events[$entity]);
				$_POST[$entity]=array_diff($events[$entity], $invalid[$entity]);
				
				//Prepare an error message
				if(count($invalid[$entity]) !=0)
				{
					$invalidstring = $invalidstring." ".$entity."(";
					foreach($invalid[$entity] as $missing)
						$invalidstring=$invalidstring.' '.$missing;
					$invalidstring = $invalidstring.")";
				}
			}
		}
		$retid = $this->cohorts->update($_POST);
		if(strlen(trim($invalidstring)) == 0) //then it was successsful
			$retmsg = "Successfully added/updated cohort ID ".$retid;
		else
			$retmsg = "Updated cohort ".$retid." with following errors; ".$invalidstring;
		$this->session->set_userdata('msg',$retmsg);
		redirect('welcome/home');
	}

	function view_summary($id='')
	{
		//Get list of persons
		$this->load->model('demographic/cohort_model','cohort');
		
		if(!$indis = $this->cohort->get_individuals_by_id($id))
		{
			$this->session->set_userdata('msg',"The cohort with id ".$id." is empty. Please add some valid individuals/households and then try the operation");
			redirect('welcome/home');
			return;
		}
		$this->load->model('demographic/person_model','person');
		$this->load->model('demographic/household_model','household');
		$this->load->model('opd/visit_model','visit');
		$this->__load_all_models();
		$data = array();
		foreach($indis as $person)
		{
			//Collect the individual id and full name
			$details=array();
			if($person_rec = $this->person->find($person))
			{
				$details['name'] = $person_rec->full_name;
				$details['org_id'] = $person_rec->organization_member_id;
				$details['id']=$person_rec->id;
				$details['visit_link']=base_url()."index.php/opd/visit/list_/".$person."/".$person_rec->household_id;
				$details['visit_count']=$this->visit->count_for_person_id($person);

				$hh = $this->household->find($person_rec->household_id);
				$details['household_link'] = base_url()."index.php/plsp/queryhhform/display_household/".$hh->policy_id;
				$details['household']=$hh->policy_id;
			
				$plsp=$this->__get_plsp_details($person_rec->organization_member_id);
				foreach($plsp as $k=>$v)
					$details[$k]=$v;
				
			}
			$data[]=$details;
		}
		$this->load->view ( 'demographic/cohort_view_summary', array('data'=>$data,'cohort_id'=>$id));
	}

	function get_all_cohorts()
	{
		$this->load->model('demographic/cohort_model','cohort');
		$result="";
		if($indis = $this->cohort->get_all_cohorts())
		{	
			foreach($indis as $cohortid=>$name)
			{
				$result = $result.'<option value="'.$cohortid.'">'.$name.'</option>';
			}
		}
		echo $result;
		return $result;
	}
	function __get_plsp_details($id)
	{	
		$report=NULL;
		$summary=NULL;
		$result = array("plsp_link"=>"", "risk_count"=>"0","age_group"=>"","risk_summary"=>array());
		foreach($this->typeList as $type=>$modelName)
		{
			$model=$this->{"$modelName"};
			if($report = $model->find_by_id($id))
			{
				$result['age_group']=$type;
				$summary_model_name=$modelName."_summary";
				$result['plsp_link']='<a href="'.base_url().'index.php/plsp/report/display_report/'.$id.'/tamilcode/html"> Tamil</a>, <a href="'.base_url().'index.php/plsp/report/display_report/'.$id.'/english/pdf">English</a>';
				$summary_model=$this->{"$summary_model_name"};
				$result['risk_summary'] = $summary_model->get_risk_summary($report->id);
				$result['risk_count'] = count($result['risk_summary']);
			}
		}
		
		return $result;	
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

	function household_roster($id)
	{
		//Given a cohort, prints all the household information
		$this->load->model('demographic/cohort_model','cohort');
		$this->load->model('demographic/household_model','cohort');
		$hh_list = $this->cohort->get_all_households_by_id($id);
		$this->load->library('plsp/writer/pdfwriter');
		$doc = new tcPdfWriter();
		$doc->InitDoc();
		
		$doc->PrepareDoc("", "", "", "",$this->config->item('base_url').'assets/images/common_images/sgv_logo.png'); 
		$ctr = count($hh_list);	
		foreach($hh_list as $hh)
		{
			$summary = $this->household->get_household_summary($hh);
			$individuals = $summary['individuals'];
			unset($summary['individuals']);
			$headers = array("Household Details","");
			$data=array();
			foreach($summary as $k=>$v)
			{
				$data[] = array($k,$v); //This needs to be 2x2
			}
			$doc->WriteTable($data, $headers, "Info","Household Roster",array('border'=>1));
			$headers = array("Individual ID","Name","Relationship","Gender", "Age"); 
			$data = array();
			foreach($individuals as $indi)
			{
				$row = array();
				foreach($indi as $k=>$v)
					$row[]=trim($v)."<br/>";
				$data[]=$row;
			}
			$doc->WriteTable($data, $headers, "Info","Household Roster",array('border'=>1,'width'=>array(20,35,25,10,10)));
			$ctr--;
			if($ctr!=0)
				$doc->NewPage();
			
		}
		
		$doc->Display();
		
	}
}
