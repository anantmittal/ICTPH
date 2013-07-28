<?php
include_once(APPPATH.'libraries/plsp/assessment/assessment_helper.php');
class Report extends CI_Controller
{
	var $typeList = array("Adult"=>"plsp_adult","Adolescent"=>"plsp_adolescent","Child"=>"plsp_child","Infant"=>"plsp_infant");
	var $bLoadModel=false;
	function Report()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	function index() 
	{	
		$this->headers();
	}

	function consolidated_report($ids, $language="english", $format="pdf")
	{
		$listId=explode('-',$ids);
		$this->__reportHelper($listId, $language, $format);	
	}
	
	function household_report($id, $language="english", $format="pdf")
	{
		if($this->bLoadModel==false)
			$this->__load_all_plsp_models();
		$this->load->model('admin/policy_model', 'policy');
		$this->load->model('demographic/person_model','person');
		$this->load->model('demographic/household_model', 'household');
		$house_id = $this->household->find_by('policy_id',$id);
		
		if($persons = $this->household->get_members($house_id->id))
		{
			$idList=array();
			foreach($persons as $indi)
			{
				$idList[]=$indi->organization_member_id;
			}
			$this->__reportHelper($idList, $language, $format);
		}
		else
		{
			$this->session->set_userdata('msg',"Household $id not found");
			$this->load->view('survey/plsp/home');	
		}
	}
	function __reportHelper($idList, $language, $format)
	{

		$this->load->library('plsp/plspreportfactory');
		$reportFactory = new PlspReportFactory();
		if($format == "pdf")
		{
			$this->load->library('plsp/cezpdf');
			$this->load->library('plsp/writer/pdfwriter');
			$doc = new ezPdfWriter();
			$doc->InitDoc($this->cezpdf);
		}
		else if($format=="html")
		{
			$this->load->library('plsp/writer/htmlwriter');
			$doc = new HtmlWriter();
		}
		else
		{
			$this->session->set_userdata('msg',"Invalid report format (".$format.") requested");
			$this->load->view('survey/plsp/home');
			return;
		}
		
		foreach($idList as $id)
		{
			$type = $this->__get_plsp_type($id);
			if($type!="")
			{
				$modelName="plsp_".strtolower(trim($type));
				$this->load->model('survey/plsp/'.$modelName."_model",$modelName);
				$this->load->model('survey/plsp/plsp_svg_model','plsp_svg');
				$this->load->model('demographic/person_model','person');
				$plspModel=$this->{"$modelName"};
				if($rec = $plspModel->find_by_id($id))
				{	
					$report = $reportFactory->getPlspReport($type); 
					$household=NULL;
					if($person = $this->person->find_by('organization_member_id', trim($id)))
						$household= $person->related('household')->get();
					$report->generateReport( $doc, $rec, $person, $household, $this->plsp_svg, $this->configMap, $this->analyzer, $this->plsp_strings->get_dict($language));
				}
			}
		}
		$doc->Display();
	}
	function display_report($id, $language="english", $format="pdf")
	{
		$this->__reportHelper(array($id), $language, $format);
	}
	function highRisk()
	{
		$this->__view_launcher('getHighRisk', 'survey/plsp/highrisk');
	}
	function viewerrors()
	{
		$this->__view_launcher('getErrors', 'survey/plsp/plsperrors');
	}
	function __view_launcher($function_name, $view_name)
	{
		$batchnum='All';
		if($_POST)
		{
			$batchnum = $this->input->post('batch');
		}
		$this->__load_all_plsp_models();
		$types = array('Adult','Adolescent', 'Child', 'Infant');
		$this->load->library('plsp/plspreportfactory');
		$reportFactory = new PlspReportFactory();
		$results=array();
		$allbatches=array();
		foreach($types as $category)
		{
			$report = $reportFactory->getPlspReport($category);
			$modelName = 'plsp_'.strtolower($category);
			$summaryModel = $modelName.'_summary';
			$model=$this->{"$modelName"};
			
			$batches=$model->get_batch_nums($this->db);
			sort($batches);
			foreach($batches as $batch)
				$allbatches[$batch]=1;
			$results=$report->{"$function_name"}($this->configMap, $this->plsp_strings->get_dict(),$model, $this->{"$summaryModel"},$batchnum);
			$overall[$category]=$results;
		}

		$data['data']=$overall;
		sort($allbatches);
		$allbatches['All']=1;
		$data['batch']=$allbatches;
		$data['selected_batch']=$batchnum;
		$this->load->view($view_name, $data);
	}

	function error_pie($category,$batchnum)
	{
		//$batchnum='All';
		$this->__load_all_plsp_models();
		$types = array('Adult','Adolescent', 'Child', 'Infant');
		$this->load->library('plsp/plspreportfactory');
		$reportFactory = new PlspReportFactory();
		$results=array();
		$function_name="getErrors";
		
		$report = $reportFactory->getPlspReport($category);
		$modelName = 'plsp_'.strtolower($category);
		$summaryModel = $modelName.'_summary';
		$model=$this->{"$modelName"};
		
		$results=$report->{"$function_name"}($this->configMap, $this->plsp_strings->get_dict(),$model, $this->{"$summaryModel"},$batchnum);
		$count_arr=array();
		foreach($results as $keyCat=>$valItems)
		{
			$count_arr[$keyCat]=count($valItems);
			
		}
		
		$chart_data=array(
		    'chart_height'  => 300,
                    'chart_width'   => '37%',
                    'page_title'    => ucwords('Error Breakup'),
		    'payload_pie' => $this->get_data_pie($count_arr, 'Types of Errors'),
		     'payload_bar'=> $this->get_data_bar($count_arr, 'Error Counts'));
		$this->load->view('survey/plsp/chart_plsp_error', $chart_data);
	}

	function highrisk_chart($category, $batchnum)
	{
		$this->__load_all_plsp_models();
		$types = array('Adult','Adolescent', 'Child', 'Infant');
		$this->load->library('plsp/plspreportfactory');
		$reportFactory = new PlspReportFactory();
		$results=array();
		$function_name="getHighRisk";
		
		$report = $reportFactory->getPlspReport($category);
		$modelName = 'plsp_'.strtolower($category);
		$summaryModel = $modelName.'_summary';
		$model=$this->{"$modelName"};
		
		$results=$report->{"$function_name"}($this->configMap, $this->plsp_strings->get_dict(),$model, $this->{"$summaryModel"},$batchnum);
		$count_arr=array();
		$riskCount=array();
		foreach($results as $keyCat=>$valItems)
		{
			$count_arr[$keyCat]=count($valItems);
			if($keyCat!='High Waist Circumference' && $keyCat!='Very High BP' && $keyCat!='Very High BMI')
				continue;
			foreach($valItems as $indi=>$info)
			{
				$count=1;
				if(isset($riskCount[$indi]))
					$count=$riskCount[$indi]+1;
				$riskCount[$indi]=$count;
			}
			
		}
		$riskWiseAggr=array();	
		foreach($riskCount as $key=>$value)
		{
			$count=1;
			if(isset($riskWiseAggr[$value]))
				$count=$riskWiseAggr[$value]+1;
			$riskWiseAggr[$value]=$count;
		}
		$chart_data=array(
		    'chart_height'  => 300,
                    'chart_width'   => '37%',
                    'page_title'    => ucwords('Risk Chart'),
		    'payload_pie' => $this->get_data_pie($count_arr, 'High Risk Individual Breakup'),
		    'payload_bar'=> $this->get_data_bar($count_arr, 'High Risk Individuals'),
		    'payload_risk_pie' => $this->get_data_pie($riskWiseAggr, 'Risk Factor Counts'),
		    'payload_risk_bar'=> $this->get_data_bar($riskWiseAggr,'Risk Factor Counts'));
		$this->load->view('survey/plsp/chart_plsp_risk', $chart_data);
		
	}
	public function get_data_pie($ctr, $title)
	{
		$this->load->helper('ofc2');

		$title = new title( $title );

		$pie = new pie();
		$pie->set_alpha(0.6);
		$pie->set_start_angle( 35 );
		$pie->add_animation( new pie_fade() );
		$pie->{'on-show'} = false;
		$arrPie=array();
		foreach($ctr as $key=>$value)
		{
			$arrPie[]=new pie_value((int)$value,$key);	
		}	
		$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
		$pie->set_colours( array('#00CC66','#6666FF','#CC3333','#005500','#330033','#663366') );
		$pie->set_values( $arrPie );

		$chart = new open_flash_chart();
		$chart->set_title( $title );
		$chart->add_element( $pie );
		

		$chart->x_axis = null;

		return $chart->toPrettyString();
	}

	public function get_data_bar($ctr, $title)
	{

		$this->load->helper('ofc2');
		$title = new title( $title );


		$bar = new bar();
		$bar_val=array();
		$max_val=0;
		foreach($ctr as $key=>$value)
		{
			$max_val=($max_val>$value)?$max_val:$value;
			$objBar =new bar_value($value);
			$objBar->set_tooltip($key." (".$value.")");
			$bar_val[]=$objBar;
		}
		$bar->set_values( $bar_val );
		
		$y = new y_axis();
		// grid steps:
		$y->set_range( 0, $max_val*(1.1), 10);
		$chart = new open_flash_chart();
		$chart->set_title( $title );
		$chart->add_element( $bar );
		$chart->set_y_axis( $y );
		return $chart->toPrettyString();
	}
	function edit_report_by_person_id($id)
	{
		$ret = $this->__get_plsp_record($id);
		if($ret=="")
		{
			$this->session->set_userdata('msg',"PLSP Record for Individual ".$id." not found");
			$this->load->view('survey/plsp/home');
		}
		else
		{
			$this->edit_report($ret[1]->id, $ret[0]);
		}
	}

	function edit_report($id,$type)
	{
		if($this->bLoadModel==false)
			$this->__load_all_plsp_models();

		$modelName = 'plsp_'.strtolower(trim($type));
		$model =$this->{"$modelName"};
		if($rec = $model->find_by('id',$id))
		{
			if(!$_POST) {
				$summaryModelName='plsp_'.strtolower($type).'_summary';
				$summaryModel=$this->{"$summaryModelName"};
				$sum=$summaryModel->find_by('plsp_'.strtolower($type).'_id',$id);
				$this->__edit_helper($type, $rec, $sum);
			
			}
			else
			{
				foreach($_POST as $key=>$val)
				{
					$rec->{"$key"}=$this->input->post($key);
				}
				$rec->save();
				$this->session->set_userdata('msg',"Saved successfully");
				$this->load->view('survey/plsp/home');
			
			}
		
		}
		else
		{
			$this->session->set_userdata('msg',"Invalid ID ".$id." or type ".$type);
			$this->load->view('survey/plsp/home');
		}		
	}

	function __edit_helper($type, $row, $summary)
	{
		$this->load->library('plsp/plspreportfactory');
		$this->load->database();
		$reportFactory = new PlspReportFactory();
		$report = $reportFactory->getPlspReport($type);
		$this->load->model('survey/plsp/plsp_strings_model','plsp_strings');

		$report->initVariables($this->db,NULL, $this->plsp_strings->get_dict("english"));
		$fields['type']=$type;
		$indiField=$report->fieldId;
		$fields['id']=trim($row->id);
		$fields['data']=$report->getReportFields($row, $summary);
		$this->load->view('survey/plsp/reportdetails', $fields);
		
	}

	function get_plsp_details()
	{
		if($_POST)
		{
			$indi = $this->input->post('indiname');
			$_POST=NULL;
			$this->edit_report_by_person_id(trim($indi));
		}
	}

	function __get_plsp_record($id)
	{	
		if($this->bLoadModel==false)
			$this->__load_all_plsp_models();
		$report=NULL;
		$summary=NULL;
		$retType="";
		foreach($this->typeList as $type=>$modelName)
		{
			$model=$this->{"$modelName"};
			$report = $model->find_by_id($id);
			$summary_model_name=$modelName."_summary";
			if($report!=NULL)
			{	
				$summary_model=$this->{"$summary_model_name"};
				$summary = $summary_model->find_by($modelName."_id", $report->id);
				$retType=$type;	
				break;
			}
		}
		return array($retType,$report, $summary);	
	}
	function __get_plsp_type($id)
	{	
		if($this->bLoadModel==false)
			$this->__load_all_plsp_models();
		foreach($this->typeList as $type=>$modelName)
		{
			$model=$this->{"$modelName"};
			if($report = $model->find_by_id($id))
			{	
				return $type;
			}
		}
		return "";	
	}

	function __load_all_plsp_models()
	{
		if($this->bLoadModel==true)
			return;
		$this->load->library('plsp/growthanalyzer/plspformulaanalyzer');
		foreach($this->typeList as $type=>$modelName)
		{
			$this->load->model('survey/plsp/'.$modelName."_model",$modelName);
			$summary_model_name=$modelName."_summary";
			$this->load->model('survey/plsp/'.$summary_model_name."_model",$summary_model_name);
		}
		$this->load->model('survey/plsp/plsp_config_model', 'plsp_config');
		$this->configMap = $this->plsp_config->get_config_map();
		$this->load->model('survey/plsp/plsp_strings_model', 'plsp_strings');
		$this->analyzer = new PlspFormulaAnalyzer();
		$this->load->model('survey/plsp/plsp_hwformula_model','plsp_hwformula');
		$this->analyzer->Init($this->plsp_hwformula);

		$this->bLoadModel=true;
	}
	
	function survey_report($id,$format,$language,$letterhead=0,$type='adult', $formid='10000')
	{
		if($this->bLoadModel==false)
			$this->__load_all_plsp_models();
		$this->load->library('plsp/plspreportfactory');
		$reportFactory = new PlspReportFactory();
		$report = $reportFactory->getPlspReport($type); 	
		$this->load->model('mne/form_model','form_var');
		$row = $this->form_var->get_complete_response_record($formid,$id);
		if($format == "pdf")
		{
			$this->load->library('plsp/cezpdf');
			$this->load->library('plsp/writer/pdfwriter');
			$doc = new ezPdfWriter();
			$doc->InitDoc($this->cezpdf);
		}
		else if($format=="html")
		{
			$this->load->library('plsp/writer/htmlwriter');
			$doc = new HtmlWriter();
		}
		else
		{
			$this->session->set_userdata('msg',"Invalid report format (".$format.") requested");
			$this->load->view('survey/plsp/home');
			return;
		}
		$this->load->model('survey/plsp/plsp_svg_model','plsp_svg');
		$this->load->model('demographic/person_model','person');
		$main =$row['mne_pisp_'.$type];
		$idfield = $type.'_id';
		$person_id = $main->{$idfield};
		$household=NULL;
		if($person = $this->person->find_by('organization_member_id', trim($person_id)))
			$household= $person->related('household')->get();
		
		$report->generateReport2( $doc, $row, $person, $household, $this->plsp_svg, $this->configMap, $this->analyzer, $this->plsp_strings->get_dict($language),1);
		$doc->Display();
		
	}	

	function query_report()
	{
		if($_POST)
		{
			
			$id = trim($this->input->post('indi_org_id'));
			
			if($id =="")
			{
				$this->session->set_userdata('msg',"Enter valid ID");
				redirect('plsp/search/home');	
				return;
			}
			$this->load->model('mne/forms/mne_pisp_adult_model','mne_pisp_adult');
			$org_id=$this->mne_pisp_adult->get_id_for_org_id($id);
			if($org_id!=false)
			{
				redirect('plsp/report/survey_report/'.$org_id.'/html/'.$this->input->post('language').'/1');
			}
			else
			{
				$this->session->set_userdata('msg',"Could not find user with ID ".$id.". Enter valid ID");
				redirect('plsp/search/home');
				return;
			}
		}
	}
	function query_report_by_id($type)
	{
		if($_POST)
		{
			
			$id = trim($this->input->post('indi_id'));
			
			$form_id = trim($this->input->post('form_id'));
			
			if($id =="")
			{
				$this->session->set_userdata('msg',"Enter valid ID");
				redirect('plsp/search/home');	
				return;
			}
			$this->load->model('mne/forms/mne_pisp_'.$type.'_model','mne_pisp');
			if($id!="")
			{
				redirect('plsp/report/survey_report/'.$id.'/html/'.$this->input->post('language').'/1/'.$type.'/'.$form_id);
			}
			else
			{
				$this->session->set_userdata('msg',"Could not find user with ID ".$id.". Enter valid ID");
				redirect('plsp/search/home');
				return;
			}
		}
	}
	function self()
	{
		if(!$_POST)
		{
			$this->load->view('mne/forms/pisp_adult_self');
			return;	
		}
		if($this->bLoadModel==false)
			$this->__load_all_plsp_models();
		$this->load->library('plsp/plspreportfactory');
		$reportFactory = new PlspReportFactory();
		$report = $reportFactory->getPlspReport('Adult');
		if($_POST['language'] == "english")
		{
			$this->load->library('plsp/cezpdf');
			$this->load->library('plsp/writer/pdfwriter');
			$doc = new ezPdfWriter();
			$doc->InitDoc($this->cezpdf);
		}
		else 
		{
			$this->load->library('plsp/writer/htmlwriter');
			$doc = new HtmlWriter();
		}
		
		$report->generateReportSelf( $doc, $_POST, $this->configMap, $this->analyzer, $this->plsp_strings->get_dict($_POST['language']));
		$doc->Display();
	}
	
	function delete_mne_response($type,$id)
	{
		$modelname = 'mne_pisp_'.$type;
		$this->load->model('mne/forms/'.$modelname."_model",$modelname);
		if($rec = $this->{$modelname}->delete_response($id,$this->db))
			echo "Deleted";
		else
			echo "Failed";
	}
}

