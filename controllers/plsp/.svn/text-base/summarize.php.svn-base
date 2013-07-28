<?php

class Summarize extends CI_Controller {
	var $typeList = array("Adult"=>"plsp_adult","Adolescent"=>"plsp_adolescent","Child"=>"plsp_child","Infant"=>"plsp_infant");
	function index()
	{
		
		$this->load->helper(array('form', 'url'));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('reporttype', 'reporttype', 'required');
		$this->load->database();
		if ($this->form_validation->run() == FALSE)
		{
			//Get the list of all batches from Adult table
			
			$this->load->model('survey/plsp/plsp_adult_model', 'plsp_adult');
			$batches=$this->plsp_adult->get_batch_nums($this->db);
			$batches[]='All';
			sort($batches);
			$this->load->view('survey/plsp/summarizeplsp', array('batches'=>$batches));
		}
		else
		{
			$this->SummarizeReports();
		}		
	}
	function SummarizeReports()
	{
		$type = $this->input->post('reporttype');
		$batch = $this->input->post('batch');
		$this->load->model('survey/plsp/plsp_config_model', 'plsp_config');
		$this->load->model('survey/plsp/plsp_svg_model', 'plsp_svg');
		$this->load->model('demographic/person_model','person');
		$config = $this->plsp_config->get_config_map();
		$this->load->library('plsp/plspreportfactory');

		$reportFactory = new PlspReportFactory();
		$report = $reportFactory->getPlspReport($type);
		$modelName = 'plsp_'.strtolower($type);
		$this->load->model('survey/plsp/'.$modelName.'_model',$modelName);
		$summary_model = 'plsp_'.strtolower($type).'_summary';
		$this->load->model('survey/plsp/'.$summary_model.'_model',$summary_model);

		if($batch == 'All')
			$recs = $this->{"$modelName"}->find_all();
		else
			$recs = $this->{"$modelName"}->find_all_by('batch',$batch);

		$this->load->library('plsp/growthanalyzer/plspformulaanalyzer');
		$analyzer = new PlspFormulaAnalyzer();
		$this->load->model('survey/plsp/plsp_hwformula_model','plsp_hwformula');
		$analyzer->Init($this->plsp_hwformula);

		$report->generateReportSummary($recs, $config, $analyzer, $this->person, $this->plsp_svg, $this->{"$summary_model"});							
		$this->session->set_userdata('msg',"Report summaries generated for type $type");
		redirect('plsp/search/home');
	}

	function genRandomHH()
	{
		$this->load->database();
				
		$query = $this->db->query("select distinct cust_id from plsp_master_list ");
		$hh=array();
		foreach($query->result() as $row)
		{
			$hh[]=$row->cust_id;
			
		}	
		$rand=array();
		while(count($rand)<220)
		{
			$index=rand(0, count($hh));
			$rand[]=$hh[$index];
			$strAddr="";
			$queryAddr = $this->db->query("select door_no, street, hamlet, village, svg_id from plsp_master_list where cust_id=".$hh[$index]." limit 1");
			foreach($queryAddr->result() as $addr)
			{
				$strAddr=$addr->door_no.",".$addr->street.",".$addr->hamlet.",".$addr->village."|".$addr->svg_id;
				break;
			}
			echo "\"".$hh[$index]."\"|".$strAddr;
			echo "</br>";
		}
	}


	function __unistr_to_ords($str, $encoding = 'UTF-8'){        
		// Turns a string of unicode characters into an array of ordinal values,
		// Even if some of those characters are multibyte.
		$str = mb_convert_encoding($str,"UCS-4BE",$encoding);
		$ordstr="";

		// Visit each unicode character
		for($i = 0; $i < mb_strlen($str,"UCS-4BE"); $i++){        
			// Now we have 4 bytes. Find their total
			// numeric value.
			$s2 = mb_substr($str,$i,1,"UCS-4BE");                    
			$val = unpack("N",$s2);
			if($val[1]>127)            
				$ordstr=$ordstr.'&#'.$val[1].';';
			else
				$ordstr=$ordstr.chr($val[1]);
		}        
		return($ordstr);
	}
	 
	function gen_html_code($language="tamil")
	{
		$this->load->model('survey/plsp/plsp_strings_model','plsp_strings');
		$recs=$this->plsp_strings->find_all();
		if($_POST)
		{
			$language = $this->post->input('translate_language');
		}
		$languageCode = $language.'code';
		foreach($recs as $row)
		{
			$tamilstr=$row->{"$language"};
			$row->{"$languageCode"} = $this->__unistr_to_ords($tamilstr);
			$row->save();
		}
		$this->session->set_userdata('msg',"Language code updated");
		$this->load->view('survey/plsp/home');
	}

	function show_geo_tree()
	{
		$this->load->model('survey/plsp/plsp_masterlist_model', 'masterlist');
		$data = $this->masterlist->get_geo_map();
		$this->load->view('survey/plsp/geo_map', array('data'=>$data));
	}
	function show_geo_tree_db()
	{
		$this->load->model('demographic/household_model', 'household');
		$data = $this->household->get_all_addresses_for_karambayam($this->__get_all_completed_pisp());
		$this->load->view('survey/plsp/geo_map', array('data'=>$data));
	}
	function show_geo_map_db()
	{
		$this->load->model('demographic/household_model', 'household');
		$data = $this->household->get_color_coded_hh($this->__get_all_completed_pisp());
		
	}


	function __get_all_completed_pisp()
	{
		$idmap=array();
		foreach($this->typeList as $type=>$modelName)
		{
			
			$this->load->model('survey/plsp/'.$modelName."_model",$modelName);
			$list = $this->$modelName->return_all_ids($idmap);
		}
		return $idmap;
	}

}
?>
