<?php
include_once(APPPATH.'libraries/plsp/assessment/assessment_helper.php');
class mne_pisp_adult_model extends IgnitedRecord {
	var $table ='mne_pisp_adult';
	var $idfield = "adult_id";
	var $datefield = "date_interview";
	var $subtables = array("mne_pisp_acute_condition", "mne_pisp_personal_illness", "mne_pisp_adult_smoking", "mne_pisp_adult_alcohol", "mne_pisp_reproductive_health","mne_pisp_family_history");

	function mne_pisp_adult_model()
	{
		parent::IgnitedRecord();
		$this->CI_handle =& get_instance();
	}

	function get_id_for_org_id($org_id)
	{
		$ret = false;
		if($record = $this->find_by($this->idfield,$org_id))
		{
			$ret = $record->id;
		}
		return $ret;
	}
	
	function get_ids_and_payload_for_org_id($org_id)
	{
		$ret = array();
		if($records = $this->find_all_by($this->idfield,$org_id))
		{
			foreach($records as $row)
				$ret[$row->id] = array($row->date_interview,'adult', '10000');
		}
		return $ret;
	}
	
	function get_summary_from_latest_survey($person_org_id, $params)
	{
		if(!$this->find_by($this->idfield,$person_org_id))
			return null;
		if($record = $this->find_by_sql('select max(id) as id from '.$this->table.' where '.$this->idfield.'="'.$person_org_id.'" and '.$this->datefield.'=(select max('.$this->datefield.') as date from '.$this->table.' where '.$this->idfield.'="'.$person_org_id.'")' ))
		{
			if($rec = $this->find_by('id',$record->id))
			{
				//compute summary
				$ret = array();
				$ret['date']=$rec->{$this->datefield};
				$date = date('Y-m-d');
				if($ret['date']== $date) // so that only todays PISP would affect the vision prescription for a patient
				{
					$ret['vision_exam_consent']=$rec->vision_exam_consent;
					$ret['via_vili_consent']=$rec->via_vili_consent;
				}
				else 
				{
					$ret['vision_exam_consent']='n';
					$ret['via_vili_consent']='n';
				}
				$elapseddays = (strtotime(date("Y-m-d"))-strtotime($ret['date']))/86400;
				if($elapseddays == 0) //If PISP was done today
				{
					/*$bp = explode("/",$rec->bp);
					if(count($bp)==2)
					{
						$ret['systole']=$bp[0];
						$ret['diastole']=$bp[1];
					}*/
					$ret['weight']=$rec->weight;
					$ret['wc']=$rec->wc;
					$ret['hc']=$rec->hc;
					$ret['height']=$rec->height;
				}
				
				if($elapseddays < 180) // If PISP was done less than 6 months ago, then include visual parameters
				{
					$ret['va_distance_r']=$rec->va_distance_r;
					$ret['va_distance_l']=$rec->va_distance_l;
					$ret['va_near']=$rec->va_near;
					$ret['va_cataract']=$rec->va_cataract;
				}
				
				$ret['risk']=$this->__calculate_summary($rec, $params);			
				return $ret;
			}
		}
		return null;
	}

	function __calculate_summary($record, $params)
	{
		$data[$this->table]=$record;
		$ctr = 0;
		foreach($this->subtables as $st)
		{
			
			$this->CI_handle->load->model('mne/forms/'.$st.'_model',$st);
			$data[$st] = $this->CI_handle->{$st}->find_all_by('data_point_id',$record->id);
		}
		
		$assess = new AssessmentHelper($params['config'], $params['dict'], $params['analyzer']);
		$pispdata = new PispMneAdultRecord();
		$pispvalues = $pispdata->generate_array($data, $params['person'], NULL, NULL);
		$pisp_risk = array();
		
		$arr_risks = array('risk_whr'=>array('assessWaistHipRatio','WHR'), 					
				'risk_bp'=>array('assessBloodPressure','BP'),
				'risk_personal_illness'=>array('assessChronicConditions','Personal illness'), 
				'risk_bmi'=>array('assessBmi','BMI') , 
				'risk_alcohol'=>array('assessAlcoholDependence','Alcohol'), 
				'risk_smoking'=>array('assessNicotineDependence','Nicotine dependence'), 
				'risk_tobacco'=>array('assessChewingTobaccoDependence','Tobacco chewing'), 
				'risk_cvd'=>array('assessCVDRisks','CVD Risks'), 
				'risk_pregnant'=>array('assessPregnancy','Pregnant'));

		foreach($arr_risks as $k=>$display_text)
		{
			$func = $display_text[0];
			$assess_result = $assess->{$func}($pispvalues);
			if($assess_result['assess_flag']>=2) //then there's an error
			{
				if(array_key_exists('short_assess',$assess_result))
				{
					$pisp_risk[$k] = array($display_text[1],$assess_result['short_assess']);
				}
			}
		}
		return $pisp_risk;
	}

	function delete_response($id,$db)
	{
		$db->trans_begin();
		$status = true;
		if($main_rec = $this->find($id))
		{
			foreach($this->subtables as $sub)
			{
				$status = $status AND $db->query('delete from '.$sub.' where data_point_id='.$main_rec->id);
			}
			$status = $status AND $main_rec->delete();
		}
		
		if($status)
			$db->trans_commit();
		else
			$db->trans_rollback();
		return $status;
	}
	
	function get_family_history($organization_member_id)
	{
		if($pisp = $this->find_by('adult_id',$organization_member_id))  //takes care of only the last PISP
		{
			$k=0;
			$this->CI_handle =& get_instance();
			$this->CI_handle->load->model('mne/forms/mne_pisp_family_history_model', 'family_hist');
				
			$family_histories = $this->CI_handle->family_hist->find_all_by('data_point_id',$pisp->id);
	
			foreach($family_histories as $family_history)
			{
					
				if($family_history->pisp_familyconditions == 'y')
				{
					$history{$k} = $family_history->label_value;
	
					if(array_key_exists($history{$k},$this->family_hist_array))
						$history{$k} = $this->family_hist_array{$history{$k}
					};
						
					$k=$k+1;
				}
			}
			if(isset($history))
				return $history;
		}
	
	}
	
	
	//Method to get data for Average time taken for each pisp report.
	function get_avg_time_pisp_count($pl_id,$from_date,$to_date)
 	{
 		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('mne/forms/mne_pisp_adolescent_model','pisp_adolescent');
		$this->CI_handle->load->model('mne/forms/mne_pisp_child_model','pisp_child');
		$this->CI_handle->load->model('mne/forms/mne_pisp_infant_model','pisp_infant');
 		$dates = array();
 		$start_date = $from_date;
		$check_date = $start_date;
		$end_date = $to_date;
		$dates[0] = $start_date; 
		while ($check_date != $end_date) 
		{	
    			$check_date = date ("Y-m-d", strtotime ("+1 day", strtotime($check_date)));
    			$dates[] = $check_date;
    		}
    		$daily_avg = array();
    		$global =0;
    		$global_count=0;
    		foreach ($dates as $d)
    		{	
			$daily_adol =0;
			$daily_adult =0;
			$daily_child =0;
			$daily_infant =0;
			$daily = 0;
	 		$num_pisps =0;
			if($pisps_adult = $this->where('provider_location_id',$pl_id)
	 				  ->where('date_interview =', $d)
	 				  ->find_all())
	 		{	
	 			foreach($pisps_adult as $pisp_adult)
				{
					
					$start_time=$pisp_adult->start_time;
					$end_time = $pisp_adult->end_time;
					if(($start_time !=0) && ($end_time != 0))
					{
						$pisp_time = $end_time - $start_time;
						if(($pisp_time != 0) && ($pisp_time < 1800))
						{
							$daily_adult = $daily_adult + $pisp_time;
							$num_pisps = $num_pisps + 1;
						}
					}
				}
			}	
			if($pisps_adol = $this->CI_handle->pisp_adolescent->find_all_by(array('provider_location_id','date_interview'),array($pl_id,$d)))
			{	
				foreach($pisps_adol as $pisp_adol)
				{
					$start_time = $pisp_adol->start_time;
					$end_time = $pisp_adol->end_time;
					if(($start_time !=0) && ($end_time != 0))
					{
						$pisp_time = $end_time - $start_time;
						if(($pisp_time != 0 )&& ($pisp_time < 1800))
						{
							$daily_adol = $daily_adol + $pisp_time;
							$num_pisps = $num_pisps + 1;
						}
					}
				}
			}
				
			if($pisps_child = $this->CI_handle->pisp_child->find_all_by(array('provider_location_id','date_interview'),array($pl_id,$d)))
			{
				foreach($pisps_child as $pisp_child)
				{
					$start_time = $pisp_child->start_time;
					$end_time = $pisp_child->end_time;
					if(($start_time) !=0 && ($end_time != 0))
					{
						$pisp_time = $end_time - $start_time;
						if(($pisp_time != 0) && ($pisp_time < 1800))
						{
							$daily_child = $daily_child + $pisp_time;
							$num_pisps = $num_pisps + 1;
							
						}
					}
				}	
			}
			if($pisps_infant = $this->CI_handle->pisp_infant->find_all_by(array('provider_location_id','date_visit'),array($pl_id,$d)))	
			{
				foreach($pisps_infant as $pisp_infant)
				{
					$start_time=$pisp_infant->start_time;
					$end_time = $pisp_infant->end_time;
					if(($start_time !=0) && ($end_time != 0))
					{
						$pisp_time = $end_time - $start_time;
						if(($pisp_time != 0 )&& ($pisp_time < 1800))
						{
							$daily_infant = $daily_infant + $pisp_time;
							$num_pisps = $num_pisps + 1;
						}
					}
				}
			}
			if(($daily_adult!=0 || $daily_adol!=0 || $daily_child!=0 || $daily_infant!=0))
			{
			
				$daily_avg{$d} = round(($daily_adult+$daily_adol+$daily_child+$daily_infant)/(($num_pisps)*60),1); // need the daily average in minutes
				
				$global = $global + $daily_avg{$d};
				$global_count = $global_count +1; 
			}
	 	}
	 	$global_average = round(($global/$global_count),1);
		$ret = array($daily_avg,$global_average);	
 		return $ret;	
 	}	
}
