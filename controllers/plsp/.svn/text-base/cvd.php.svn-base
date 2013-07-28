<?php

class Cvd extends CI_Controller {
	
	
	function summary()
	{
		$this->load->model('survey/plsp/cvd_matrix_model','cvd');
		$values = $this->cvd->get_all_values();
		$labels = $this->cvd->get_all_labels();
		$dict = array('fh'=>'Family History', 'sh'=>'Smoking History', 'age'=>'Age','bp'=>'BP','bmi'=>'BMI');
		$data = array('split'=>'fh', 'horizontals'=>array('sh','bmi'), 'verticals'=>array('age','bp'),'labels'=>$labels,
				'values'=>$values, 'style'=>$values, 'display_strings'=>$dict);
		
		$this->load->view('survey/plsp/cvd_matrix', $data);
	}

	function riskchart()
	{
		$this->load->model('survey/plsp/cvd_matrix_model','cvd');
		$this->load->model('survey/plsp/plsp_adult_model','plsp_adult');
		$values = $this->cvd->get_all_values();
		$style = $values;
		foreach($values as $fh=>$fhmap)
		{
			foreach($fhmap as $age=>$agemap)
			{
				foreach($agemap as $sh=>$shmap)
				{
					foreach($shmap as $bmi=>$bpmap)
					{
						foreach($bpmap as $bp=>$bucket)
						{
							$c = $this->plsp_adult->get_cvd_risk_count($fh,$age,$sh,$bmi,$bp);
							$values[$fh][$age][$sh][$bmi][$bp]=$c;
						}
					}
				}
			}
		}
		$labels = $this->cvd->get_all_labels();
		$dict = array('fh'=>'Family History', 'sh'=>'Smoking History', 'age'=>'Age','bp'=>'BP','bmi'=>'BMI');
		$link = base_url()."/index.php/plsp/cvd/risk_details";
		$data = array('split'=>'fh', 'horizontals'=>array('sh','bmi'), 'verticals'=>array('age','bp'),'labels'=>$labels,
				'values'=>$values, 'style'=>$style, 'display_strings'=>$dict, 'link'=>$link);
		
		$this->load->view('survey/plsp/cvd_matrix', $data);
	}

	function individuals_for_risk($fh,$age,$sh,$bmi,$bp)
	{
		$this->load->model('survey/plsp/plsp_adult_model','plsp_adult');
		$arr = $this->plsp_adult->get_cvd_risk_individuals($fh,$age,$sh,$bmi,$bp);
		foreach($arr as $k=>$v)
		{
			echo "<a href=\"".base_url()."/index.php/plsp/report/edit_report/".$k."/Adult\">".$v."</a><br/>";
		}
	}
	function risk_buckets()
	{
		$this->load->model('survey/plsp/cvd_matrix_model','cvd');
		$this->load->model('survey/plsp/plsp_adult_model','plsp_adult');
		$values = $this->cvd->get_all_values();
		
		$buckets=array(array(), array(), array(), array(), array());
		foreach($values as $fh=>$fhmap)
		{
			foreach($fhmap as $age=>$agemap)
			{
				foreach($agemap as $sh=>$shmap)
				{
					foreach($shmap as $bmi=>$bpmap)
					{
						foreach($bpmap as $bp=>$bucket)
						{
							$c = $values[$fh][$age][$sh][$bmi][$bp];
							$indis = $this->plsp_adult->get_cvd_risk_individuals($fh,$age,$sh,$bmi,$bp);
							$buckets[$c-1] = array_merge($buckets[$c-1],$indis);
						}
					}
				}
			}
		}
		$data = array('buckets'=>$buckets);
		$this->load->view('survey/plsp/cvd_risk_buckets', $data);
	}
	
	function risk_details()
	{
	}
}
?>
