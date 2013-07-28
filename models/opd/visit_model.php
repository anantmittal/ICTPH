<?php
class visit_model extends IgnitedRecord {
  var $belongs_to = array("person", "provider", "provider_location");
  var $has_many = array("visit_ros_entries", "visit_test_entries",
			"visit_physical_exam_entries","visit_protocol_information_entries",
			"visit_medication_entries", "visit_referral_entries",
			"visit_cost_item_entries", "visit_diagnosis_entries",
			"visit_procedure_entries", "visit_immunization_entries","lab_orders", "visit_addendums", "followup_informations",
			"visit_opdproduct_entries","visit_service_entries");
  // While visits "has_one" pregnancy_update and pregnancy, these should
  // be accessed via the visit_obstetric_record
  var $has_one = array("visit_obstetric_record", "pregnancy_update","visit_vitals",
		       "pediatric_update", "visit_auscults", "visit_visuals","visit_visual_prescriptions");

  // Not adding the following relationships since the use is not clear yet
  // illness, medications, lab_orders, immunization

	function count_for_person_id($id)
	{
		$rec = $this->find_by_sql('select count(*) as count from visits where person_id='.$id);
		return $rec->count;
	}
	function get_basic_details_for_last_two_visits($person_id)
	{
		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('opd/visit_diagnosis_entry_model', 'diagnosis');
		if(!$recs=$this->find_all_by_sql("select * from visits where person_id like '$person_id' and (type like 'General' or type like 'Followup') and valid_state like 'valid' order by date DESC"))
		{
			$visit[0]['chief_complaint']='';
			$visit[1]['chief_complaint']='';
			$visit[0]['diagnosis']='';
			$visit[1]['diagnosis']='';
			return $visit;
		}
		else
		{	
			$ctr = 0;
			
			foreach($recs as $rec)
			{	
				
				
				
						
				@$diagnosis_entry = $this->CI_handle->diagnosis->find_all_by('visit_id',$rec->id);
				$visit{$ctr}['diagnosis']='';
				foreach($diagnosis_entry as $diagnosis)
					@$visit{$ctr}['diagnosis']= $visit{$ctr}['diagnosis'].",".$diagnosis->diagnosis;
				@$visit{$ctr}['chief_complaint'] = $rec->chief_complaint;
				
				
				/*@$product_ids = $this->visit_medication_entry->find_all_by('visit_id',$rec->id);
				foreach($product_ids as $product_id)
				{
					@$medication{$ctr}[] = $this->product->find_by('id',$product_id->product_id);
				}*/
				
				
				if($ctr == 1)  // only last two visit records
					break;
				$ctr=$ctr+1;
			}
			return $visit;
		}
		
		
	}
	
	
	function get_all_past_encounters($person_id)
	{
		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('scm/product_model', 'product');
		$valid = 'valid';
		if($visits = $this->where('person_id',$person_id)->where('valid_state',$valid)->order_by('date','DESC')->find_all())
		{
			$k = 0;
			foreach($visits as $v)
			{
				//counters for medications, services, opd products and diagnosis
				$i=0;
				$j=0;
				$x=0;
				$l=0;
	
					
				$medication_entries = $v->related('visit_medication_entries')->get();
				$diagnosis_entries = $v->related('visit_diagnosis_entries')->get();
				$service_entries = $v->related('visit_service_entries')->get();
					
				$rec{$k}['visit_details']=array('visit_id'=>$v->id,'date'=>$v->date,"chief_complaint"=>$v->chief_complaint);
				foreach($medication_entries as $m)
				{
	
					if($product = $this->CI_handle->product->find_by('id',$m->product_id))
					{
						if($product->product_type == "MEDICATION" || $product->product_type = "UNUSED")
						{
							$rec{$k}['medication']{
								$i}['name'] = $product->name.' ('.$product->generic_name.') ';
								$rec{$k}['medication']{
									$i}['dosage']= $product->strength.' '.$product->strength_unit.' '.$product->retail_unit;
									$rec{$k}['medication']{
										$i}['frequency']=$m->frequency;
										$rec{$k}['medication']{
											$i}['duration']=$m->duration.' '.$m->duration_type;
											$rec{$k}['medication']{
												$i}['route']=$m->administration_route;
												$i=$i+1;
													
						}
						if($product->product_type == "OUTPATIENTPRODUCTS")
						{
								
							$rec{$k}['opd_product']{
								$j}['name']=$product->name.' ('.$product->generic_name.') ';
								$j=$j+1;
						}
					}
				}
				foreach($service_entries as $s)
				{
	
					$rec{$k}['service']{
						$x}['name']=$s->name;
						$x=$x+1;
				}
				foreach($diagnosis_entries as $d)
				{
					$rec{$k}['diagnosis']{
						$l}['name']=$d->diagnosis;
						$l=$l+1;
				}
	
				$k=$k+1;
			}
				
			if(isset($rec))
				return $rec;
		}
	
	}
	
	function get_all_diagnostic_tests($person_id)
	{
		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('opd/test_types_model', 'tests');
		$valid = 'valid';
		if($visits = $this->where('person_id',$person_id)->where('valid_state',$valid)->order_by('date','ASC')->find_all())
		{
			$k=0;
			foreach($visits as $v)
			{
				if($test_entries = $v->related('visit_test_entries')->get())
				{
					$k=$k+1;
					$date{$k} = $v->date;
					$visit_ids{$k} =$v->id;
				}
					
				foreach($test_entries as $t)
				{
						
					$test = $this->CI_handle->tests->find_by('id',$t->test_type_id);
					$test_name = $test->name;
					$rec{$test_name}{$k} = $t->result;
						
						
				}
	
			}
				
			if(isset($rec))
			{
				$rec = array('diagnostic_tests'=>$rec,'test_dates'=>$date,'visit_ids'=>$visit_ids);
				return $rec;
			}
		}
	}
	
	
	
	//METHOD TO GET THE DATA FOR Split by diagnosis Report.
	function get_diagnosis_count($pl_id,$from_date,$to_date) 
 	{		
 		$ret = array(0,0);
 		$charting_data_all = array();
 		$charting_data_others = array();
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		
 		{
 			foreach($visits as $visit)
	 		{
	 			
		 		$diagnosis = $visit->related('visit_diagnosis_entries')->get();
		 		foreach($diagnosis as $d)
		 		{
		 			$diag = $d->diagnosis;
		 			if($diag !="")
			 		{	
			 			if(array_key_exists($diag,$ret))
			 			{
			 				
			 				$ret{$d->diagnosis}=$ret{$diag}+1;	 			
			 			}
			 			else
			 			{
			 				$ret{$d->diagnosis}=1;
			 				
			 			}
			 		}			 					
		 		}
	 		}
	 	}
 		arsort($ret);   //it sorts the array in descending order
 		
 		// $charting_data_all is an array which contains all the present diagnosis and their count
 		$charting_data_all = $ret; 
 		
 		$len = count($ret);
 		foreach ($ret as $key => $value)
		{
			$key_diag[] = $key;
			$value_diag[] = $value;
		}
		
		//THE NUMBER IS '15' BELOW BECAUSE WE WANT THE TOP 15 DIAGNOSIS, AND OTHERS WE WANT CLUBBED IN 'OTHERS'
		for($i = 15; $i<=$len; $i++)
 		{
 			$other = $other + $value_diag[$i];
		}
		
		$arrayStart = array_splice($ret, 0, 15);   
		
		// $charting_data_others is an array which contains top '15' diagnosis present and other diagnosis clubbed in others
		$charting_data_others = array_merge($arrayStart, array("Others"=>$other));  
		
		$ret = array($charting_data_others,$charting_data_all);
		
		return $ret;
		
 		
 	}
 	
 	//METHOD TO GET THE DATA FOR Split by chief complaints Report.
 	function get_chief_complaints_count($pl_id,$from_date,$to_date)	
 	{
 		$ret = array(0,0);
 		$charting_data_all = array();
 		$charting_data_others = array();
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		{
 			foreach($visits as $visit)
			{
				$vis = $visit->chief_complaint;	
				if($vis !="")
			 	{	
			 		if(array_key_exists($vis,$ret))
			 		{
			 			$ret{$visit->chief_complaint}=$ret{$vis}+1;	 			
			 		}
			 		else
			 		{
			 			$ret{$visit->chief_complaint}=1;
			 		}
			 	}	
			}	
 		}	
 		arsort($ret);
 		$charting_data_all = $ret; // $charting_data_all is an array which contains all the diagnosis present and their count
 		unset($ret['Not Mentioned']); //This removes the key 'Not Mentioned' from the array.
 		$len = count($ret);
 		foreach ($ret as $key => $value)
		{
			$key_diag[] = $key;
			$value_diag[] = $value;
		}
		
		//THE NUMBER IS '15' BELOW BECAUSE WE WANT THE TOP 15 CHIEF COMPLAINTS, AND OTHERS WE WANT CLUBBED IN OTHERS
		
		for($i = 15; $i<=$len; $i++)
 		{
 			$other = $other + $value_diag[$i];
		}
		$arrayStart = array_splice($ret, 0, 15);   
		
		// $charting_data_others is an array which contains top '15' diagnosis present and other diagnosis clubbed in others
		$charting_data_others = array_merge($arrayStart, array("Others"=>$other));
		$ret = array($charting_data_others,$charting_data_all);
		return $ret;		
	}
	
	//This is method is used to get all the person_ids between a particular dates and from a particular location_id 
	function get_person_ids_by_location_id($pl_id,$from_date,$to_date)
 	{
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		{
	
	 		$ret = array();
	 		foreach($visits as $visit)
	 		{
	 			$ret[] = $visit->person_id;
	 			
	 		}
	 		return $ret;
	 	}
 	}
 	
 	
 	//METHOD TO GET THE DATA FOR Split by eye diagnosis Report.
 	function get_eye_diagnosis_count($pl_id,$from_date,$to_date,$list_eye_diagnosis)
 	{		
 		$ret = array();
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		
 		{	
 			
 			foreach($visits as $visit)
	 		{
	 			
		 		$diagnosis = $visit->related('visit_diagnosis_entries')->get();
		 		$va_cataract = $visit->related('visit_visuals')->get();
		 		
		 		//if va_cataract!=1, then it works normally
		 		if($va_cataract->va_cataract != 1)
			 	{	
			 		foreach($diagnosis as $d)
			 		{
			 			$diag = $d->diagnosis;
			 			if($diag !="")
				 		{	
				 			if(array_key_exists($diag,$list_eye_diagnosis))
				 			{
				 				
				 				$list_eye_diagnosis{$d->diagnosis}=$list_eye_diagnosis{$diag}+1;	 			
				 			}
				 		
				 		}
			 		}
		 		}
		 		//but if va_cataract =1 and the person has cataract as a diagnosis, then we increment cataract only once, to avoid duplicacy
		 		else
		 		{
		 			foreach($diagnosis as $d)
			 		{
			 			$diag = $d->diagnosis;
			 			if($diag !="" || $diag != 'cataract')
				 		{	
				 			
				 			if(array_key_exists($diag,$list_eye_diagnosis))
				 			{
				 				
				 				$list_eye_diagnosis{$diag}=$list_eye_diagnosis{$diag}+1;	 			
				 			}
				 		
				 		}
			 		}
		 			$list_eye_diagnosis{cataract}+=1;
		 		}
		 	}
	 	}
 		arsort($list_eye_diagnosis);
		return $list_eye_diagnosis; 
 	}
 	
 	function get_avg_time_visit_count($pl_id,$from_date,$to_date) //METHOD TO GET THE DATA FOR "Average time taken for each visit report."
 	{
 		
 		$dates = array();
 		$start_date = $from_date;
		$check_date = $start_date;
		$end_date = $to_date;
		$dates[0] = $start_date;  //$dates is an array which will contain all the days between $from_date and $to_date
		while ($check_date != $end_date) 
		{	
    			$check_date = date ("Y-m-d", strtotime ("+1 day", strtotime($check_date)));
    			$dates[] = $check_date;
    		}
    		$daily_avg = array();
    		
    		$global =0;
    		$global_count=0;
    		$global_average = 0;
    		
    		foreach ($dates as $d)
    		{	
			
			if($visits = $this->like('provider_location_id',$pl_id)
	 				  ->where('date =', $d)
	 				  ->where('valid_state','valid')
	 				  ->find_all())
	 		{	
	 			$daily = 0;
	 			$num_visits =0;
	 			
				
	 			foreach($visits as $visit)
				{
					
					$begin_time = $visit->begin_time;
					$end_time = $visit->end_time;
					
					if(($begin_time !=0) && ($end_time != 0))
					{
						
			
						$visit_time = $end_time - $begin_time;
						if(($visit_time != 0) && ($visit_time < 1800))//we put the condition <1800 to avoid the minutes whose time has been more than 30 minutes
						{
							$daily = $daily + $visit_time;
							$num_visits = $num_visits + 1;
						}
					}
				}	
				
				if($daily != 0)
				{
					$daily_avg{$d} = round(($daily/($num_visits*60)),1); // need the daily average in minutes
					$global = $global + $daily_avg{$d};
					$global_count = $global_count +1; 
				}
	 		}
	 		
	 		
	 	}
	 
	 	$global_average = round(($global/$global_count),1);
 		$ret = array($daily_avg,$global_average);
		return $ret;	
 	}	
 	
 	function get_avg_patient_visit_count($pl_id,$from_date,$to_date) //METHOD TO GET THE DATA FOR "Average number of patients report."
 	{
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
    		$daily_avg_free = array();
    		$global_free =0;
    		$global_count_free=0;
    		foreach ($dates as $d)
    		{
			
			if($visits = $this->like('provider_location_id',$pl_id)
	 				  ->where('date =', $d)
	 				  ->where('valid_state','valid')
	 				  ->find_all())
	 		{	
	 			$num_visits =0;
	 			$num_visits_free =0;
	 			foreach($visits as $visit)
				{
				
					$num_visits = $num_visits + 1;
					if($visit->paid_amount == '0')
					{
						$num_visits_free = $num_visits_free + 1;
					}
				}
					
				$daily_avg{$d} = $num_visits; 
				$daily_avg_free{$d} = $num_visits_free; 
				if($daily_avg{$d}!=0)
				{
					$global = $global + $daily_avg{$d};
					$global_count = $global_count +1; 
				}
				if($daily_avg_free{$d}!=0)
				{
					$global_free = $global_free + $daily_avg_free{$d};
					$global_count_free = $global_count_free +1; 
				}
			}
		}
	 	
	 	$global_average = round(($global/$global_count),1);
	 	$global_average_free = round(($global_free/$global_count_free),1);
 		
		$ret = array($daily_avg,$global_average,$daily_avg_free,$global_average_free);
		return $ret;	
 	}	
 	
 	//This is method is used to get all the person_ids between a particular dates and from a particular location_id, who have a particular chief_complaint
 	function get_person_ids_by_location_id_and_chief_complaint($pl_id,$from_date,$to_date, $rep_option)
 	{
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('chief_complaint', $rep_option)
 				->where('valid_state','valid')
 				->find_all())
 		{
	
	 		$ret = array();
	 		foreach($visits as $visit)
	 		{
	 			$ret[] = $visit->person_id;
	 			
	 		}
	 		return $ret;
	 	}
 	}
 	
 	//This is method is used to get all the person_ids between a particular dates and from a particular location_id, who have a particular diagnosis
 	function get_person_ids_by_location_id_and_diagnosis($pl_id,$from_date,$to_date, $rep_option)
 	{	
 		$ret = array();
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		
 		{
 			foreach($visits as $visit)
	 		{
	 			
		 		$diagnosis = $visit->related('visit_diagnosis_entries')->get();
		 		foreach($diagnosis as $d)
		 		{
		 			if($d->diagnosis == $rep_option)
		 			$ret[] = $visit->person_id;
	 			}
		 	}
	 		return $ret;
 		}
	}
 	
 	//METHOD TO GET THE DATA FOR "Average bill amounts per patient report."
 	function get_avg_bill_amounts_count($pl_id,$from_date,$to_date) 
 	{
 		
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
			if($visits = $this->like('provider_location_id',$pl_id)
	 				  ->where('date =', $d)
	 				  ->where('valid_state','valid')
	 				  ->find_all())
	 		{	
	 			$daily = 0;
	 			$num_visits =0;
	 			foreach($visits as $visit)
				{
					$paid_amount=$visit->paid_amount;
					if($paid_amount != 0)
					{
						$daily = $daily + $paid_amount;
					}
					$num_visits = $num_visits + 1;
				}
				if($daily!=0)
				{	
					$daily_avg{$d} = round(($daily/($num_visits)),1);
					$global = $global + $daily_avg{$d};
					$global_count = $global_count +1; 
				}
			}
		}
	 	$global_average = $global/$global_count; 		
		$ret = array($daily_avg,round($global_average,1));
		return $ret;	
 	}	
 	
 	//METHOD TO GET THE DATA FOR "Average bill amounts per patient report." but for a particular diagnosis
 	function get_avg_bill_amounts_count_by_diagnosis($pl_id,$from_date,$to_date,$rep_option)
 	{
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
			if($visits = $this->like('provider_location_id',$pl_id)
	 				  ->where('date =', $d)
	 				  ->where('valid_state','valid')
	 				  ->find_all())
	 		{	
	 			$daily = 0;
	 			$num_visits =0;
	 			foreach($visits as $visit)
				{
					$diagnosis = $visit->related('visit_diagnosis_entries')->get();
		 			foreach($diagnosis as $diag)
		 			{
		 				if($diag->diagnosis == $rep_option)
		 				{
		 					$paid_amount=$visit->paid_amount;
	 				
							if($paid_amount != 0)
							{
								$daily = $daily + $paid_amount;
							}
							$num_visits = $num_visits + 1;
						}
					}
				}
				if($daily!=0)
				{	
					$daily_avg{$d} = round(($daily/($num_visits)),1);
					$global = $global + $daily_avg{$d};
					$global_count = $global_count +1; 
				}
			}
		}
		$global_average = $global/$global_count;
	 	$ret = array($daily_avg,round($global_average,1));
		return $ret;	
 	}	
 	
 	
 	// METHOD TO GET THE DATA FOR "Cost of medication/services/lab tests dispensed/conducted report."
 	function get_cost_med_serv_tests_count($pl_id,$from_date,$to_date)
 	{
 		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('scm/product_model','products');
		$this->CI_handle->load->model('admin/opd_services_configuration_model','opd_services');
		$this->CI_handle->load->model('admin/test_group_tests_model','test_group_tests');
		$this->CI_handle->load->model('admin/test_group_consumables_model','test_group_consumables');
	
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
    		
    		$daily_visit_count = array();
    		$daily_count = array();
    		
    		foreach ($dates as $d)
    		{
    			
			if($visits = $this->like('provider_location_id',$pl_id)
	 				  ->where('date =', $d)
	 				  ->where('valid_state','valid')
	 				  ->find_all())
	 		{	
	 			$daily_visit_count{$d} = 0;
		 		foreach($visits as $visit)
		 		{
		 			$visit_cost = 0;
		 			$daily_visit_count{$d} = $daily_visit_count{$d} + 1;
		 			
		 			if($medications = $visit->related('visit_medication_entries')->get())
		 			{	
			 			foreach($medications as $medication)
			 			{	
			 				if($product = $this->CI_handle->products->find_by('id',$medication->product_id))
			 				{	
	 							
			 					if($product->retail_units_per_purchase_unit!=0)
			 					{
				 					$indi_product_cost = ($product->purchase_price)/($product->retail_units_per_purchase_unit);
				 					
				 					if($medication->frequency == 'OD')
				 					{
				 						$product_cost_medication = $indi_product_cost*($medication->duration);
				 					}
				 					else if ($medication->frequency == 'BID')
				 					{
				 						$product_cost_medication = $indi_product_cost*2*($medication->duration);
				 					}
				 					else if ($medication->frequency == 'TID')
				 					{
				 						$product_cost_medication = $indi_product_cost*3*($medication->duration);
				 					}
				 					else
				 					{
				 						$product_cost_medication = $indi_product_cost;
				 					}
				 					$visit_cost = $visit_cost + $product_cost_medication; 
		 						}
				 				
				 			}
			 			}
		 			}
		 			if($services = $visit->related('visit_service_entries')->get())
		 			{
		 				foreach ($services as $service)
		 				{
		 					if($opd_services = $this->CI_handle->opd_services->find_all_by('opd_service_id',$service->service_id))
		 					{
		 						foreach($opd_services as $opd_service)
		 						{
		 							
		 							if($product = $this->CI_handle->products->find_by('id',$opd_service->product_id))
		 							{
		 								if($product->retail_units_per_purchase_unit!=0)
		 								{
		 									$product_cost_service = ($product->purchase_price)*($opd_service->product_quantity)/($product->retail_units_per_purchase_unit);	
		 									$visit_cost = $visit_cost + $product_cost_service;
		 								}
		 							}
		 							
		 						}
		 					}
		 					
		 				}
		 			}
		 			if($opd_products = $visit->related('visit_opdproduct_entries')->get())
		 			{
		 				
		 				foreach ($opd_products as $opd_product)
		 				{
		 					if($product = $this->CI_handle->products->find_by('id',$opd_product->product_id))
		 					{
		 						if($product->retail_units_per_purchase_unit!=0)
		 						{
		 							$product_cost_opd = ($product->purchase_price)*($opd_product->number)/($product->retail_units_per_purchase_unit);		
		 							$visit_cost = $visit_cost + $product_cost_opd;
		 						}
		 					}
		 					
		 					
		 				}
		 			}
		 			
		 			if($tests = $visit->related('visit_test_entries')->get())
		 			{
		 				
		 				foreach ($tests as $test)
		 				{
		 					if($group_test = $this->CI_handle->test_group_tests->find_by('test_id',$test->test_type_id))
		 					{
		 						
		 							if($group_consumable = $this->CI_handle->test_group_consumables->find_by('test_group_id',$group_test->test_group_id))
		 							{
		 								
		 									if($product = $this->CI_handle->products->find_by('id',$group_consumable->product_id))
		 									{	
		 										if($product->retail_units_per_purchase_unit!=0)
		 										{	
		 											$product_cost_test = ($product->purchase_price)*($group_consumable->quantity_lab + $group_consumable->quantity_clinic)/($product->retail_units_per_purchase_unit);	
		 											$visit_cost = $visit_cost + $product_cost_test;
		 										}
		 							
		 									}
		 									
		 									
		 								
		 							}
		 						
		 								
		 					}
		 					
		 				}
		 			}
		 			if($visit_cost!=0)
		 			{
		 				$daily_count{$d} = $daily_count{$d}+round($visit_cost,1);
						$num_visits = $num_visits +1;
		 			}
		 		}
		 	}
	 		if($daily_count{$d}!=0)
	 		{
	 			$global = $global + $daily_count{$d};
	 			$global_count = $global_count +1;
	 		}
	 	}
	 	$global_avg_cost = $global/$global_count;
	 	
	 	$ret = array($daily_count,round($global_avg_cost,1),$daily_visit_count,round($global,1));
	 	return $ret;
	 	
 	}
 	
 	//METHOD TO GET THE DATA FOR "Average Cost of medication/services/lab tests dispensed/conducted report."
 	function get_avg_cost_med_serv_tests_count($pl_id,$from_date,$to_date)
 	{
 		
 		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('scm/product_model','products');
		$this->CI_handle->load->model('admin/opd_services_configuration_model','opd_services');
		$this->CI_handle->load->model('admin/test_group_tests_model','test_group_tests');
		$this->CI_handle->load->model('admin/test_group_consumables_model','test_group_consumables');
	
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
    		
    		$daily_visit_count = array();
    		$daily_count = array();
    		$daily_count_avg = array();
    		$num_visits = 0;
    		foreach ($dates as $d)
    		{
    			
			
			if($visits = $this->like('provider_location_id',$pl_id)
	 				  ->where('date =', $d)
	 				  ->where('valid_state','valid')
	 				  ->find_all())
	 		{	
	 			$num_visits = 0;
		 		foreach($visits as $visit)
		 		{	
		 			$visit_cost = 0;
		 			
		 			if($medications = $visit->related('visit_medication_entries')->get())
		 			{
			 			foreach($medications as $medication)
			 			{	
			 				
			 				if($product = $this->CI_handle->products->find_by('id',$medication->product_id))
			 				{	
	 					
			 					if($product->retail_units_per_purchase_unit!=0)
			 					{
				 					$indi_product_cost = ($product->purchase_price)/($product->retail_units_per_purchase_unit);
				 					
				 					if($medication->frequency == 'OD')
				 					{
				 						$product_cost_medication = $indi_product_cost*($medication->duration);
				 					}
				 					else if ($medication->frequency == 'BID')
				 					{
				 						$product_cost_medication = $indi_product_cost*2*($medication->duration);
				 					}
				 					else if ($medication->frequency == 'TID')
				 					{
				 						$product_cost_medication = $indi_product_cost*3*($medication->duration);
				 					}
				 					else
				 					{
				 						$product_cost_medication = $indi_product_cost;
				 					}
				 					$visit_cost = $visit_cost + $product_cost_medication;
		 						}
				 				
				 					
				 				
			 				}
			 			}
		 			}
		 			if($services = $visit->related('visit_service_entries')->get())
		 			{
		 				foreach ($services as $service)
		 				{
		 					if($opd_services = $this->CI_handle->opd_services->find_all_by('opd_service_id',$service->service_id))
		 					{
		 						foreach($opd_services as $opd_service)
		 						{
		 							
		 							if($product = $this->CI_handle->products->find_by('id',$opd_service->product_id))
		 							{
		 								if($product->retail_units_per_purchase_unit!=0)
		 								{
		 									$product_cost_service = ($product->purchase_price)*($opd_service->product_quantity)/($product->retail_units_per_purchase_unit);	
		 									$visit_cost = $visit_cost + $product_cost_service;
		 								}
		 							}
		 							
		 						}
		 					}
		 					
		 				}
		 			}
		 			if($opd_products = $visit->related('visit_opdproduct_entries')->get())
		 			{
		 				
		 				foreach ($opd_products as $opd_product)
		 				{
		 					if($product = $this->CI_handle->products->find_by('id',$opd_product->product_id))
		 					{
		 						if($product->retail_units_per_purchase_unit!=0)
		 						{
		 							$product_cost_opd = ($product->purchase_price)*($opd_product->number)/($product->retail_units_per_purchase_unit);	
		 							$visit_cost = $visit_cost + $product_cost_opd;
		 						}
		 					}
		 					
		 					
		 				}
		 			}
		 			
		 			if($tests = $visit->related('visit_test_entries')->get())
		 			{
		 				
		 				foreach ($tests as $test)
		 				{
		 					if($group_test = $this->CI_handle->test_group_tests->find_by('test_id',$test->test_type_id))
		 					{
		 						
		 							if($group_consumable = $this->CI_handle->test_group_consumables->find_by('test_group_id',$group_test->test_group_id))
		 							{
		 								
		 									if($product = $this->CI_handle->products->find_by('id',$group_consumable->product_id))
		 									{	
		 										if($product->retail_units_per_purchase_unit!=0)
		 										{	
		 											$product_cost_test = ($product->purchase_price)*($group_consumable->quantity_lab + $group_consumable->quantity_clinic)/($product->retail_units_per_purchase_unit);	
		 											$visit_cost = $visit_cost + $product_cost_test;
		 										}
		 							
		 									}
		 									
		 									
		 								
		 							}
		 					}
		 				}
		 			}
		 			if($visit_cost!=0)
	 				{
	 				$daily_count{$d} = $daily_count{$d}+round($visit_cost,1);
	 				}
		 			$num_visits = $num_visits +1;
		 		}
		 	}
	 		if($daily_count{$d}!=0)
	 		{
	 			$daily_count_avg{$d} =  round(($daily_count{$d})/($num_visits),1);
	 			$global_daily_count_avg = $global_daily_count_avg + $daily_count_avg{$d};
	 			$global_count = $global_count +1;
	 		}
	 		
		}
	 	
	 	$global_avg_cost_avg = $global_daily_count_avg/$global_count;
	 
	 	$ret = array($daily_count_avg,round($global_avg_cost_avg,1));
	 	return $ret;
	 	
 	}
 	
 	
 	
 	//METHOD TO GET THE DATA FOR "Diagnostic tests split by billed vs free report."
 	function get_diagnostic_tests_billed_free_count($pl_id,$from_date,$to_date)
 	{		
 		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('opd/test_types_model','test_types');
		
 		$ret = array();
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		
 		{
 			$paid_count = 0;
 			$free_count = 0;
  			
 			foreach($visits as $visit)
	 		{
	 			
		 		if($tests = $visit->related('visit_test_entries')->get())
		 		{
			 		foreach($tests as $test)
			 		{	
			 			if($test_type = $this->CI_handle->test_types->find_by('id',$test->test_type_id))
			 			{
			 				if($visit->paid_amount !=0)
			 				{
			 					$diagnostic_tests_paid{$test_type->name}=$diagnostic_tests_paid{$test_type->name}+1;
							}	 				
			 				else
			 				{
			 					$diagnostic_tests_free{$test_type->name}=$diagnostic_tests_free{$test_type->name}+1;
			 				}	
			 			}		
			 		}
		 		}
	 		}
 		}
 		$ret = array($diagnostic_tests_paid,$diagnostic_tests_free);
 		
		return $ret; 
 	}
 	
 	//METHOD TO GET THE DATA FOR "Split of diagnosis by system names Report."
 	function get_diagnosis_system_count($pl_id,$from_date,$to_date,$list_system_name)
 	{
 		
 		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('chw/opd_diagnosis_model','opd_diagnosis');
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		
 		{
 			foreach($visits as $visit)
	 		{
	 			
		 		$diagnosis = $visit->related('visit_diagnosis_entries')->get();
		 		foreach($diagnosis as $d)
		 		{
		 			if($opd_diagnosis = $this->CI_handle->opd_diagnosis->find_by('value',$d->diagnosis))
		 			{
			 			$sys_name = $opd_diagnosis->system_name;
			 			if($sys_name !="")
				 		{	
				 			if(array_key_exists($sys_name,$list_system_name))
				 			{
				 				$list_system_name{$sys_name} = $list_system_name{$sys_name}+1;	 			
				 			}
				 			else
				 			{
				 				$list_system_name{$sys_name} = 1;
				 			}
				 		}
			 		}
		 		}
		 	}
 		}
 		arsort($list_system_name);
		return $list_system_name; 
 	}
 	
 	//METHOD TO GET THE DATA FOR "Split of opd products report."
 	function get_opd_products_count($pl_id,$from_date,$to_date)
 	{	
 		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('scm/product_model','products');
		$ret = array();
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		{
 			foreach($visits as $visit)
 			{	
 				if($opd_products = $visit->related('visit_opdproduct_entries')->get())
	 			{
	 				foreach ($opd_products as $opd_product)
	 				{
	 					if($product = $this->CI_handle->products->find_by('id',$opd_product->product_id))
	 					{
	 						$prod_generic_name = $product->generic_name;
	 						if($prod_generic_name != "")
				 			{
				 				if(array_key_exists($prod_generic_name,$ret))	
				 				{
				 					$ret{$prod_generic_name}=$ret{$prod_generic_name}+1;	 	
				 				}
				 				else
					 			{
					 				$ret{$prod_generic_name}=1;
					 			}
				 			}
	 					}	
	 				}
	 			}
 			}
 		}
 		arsort($ret);
 		return $ret;
 	}
 	
 	
 	//METHOD TO GET THE DATA FOR "Repeated number of visits report."
 	function get_repeated_visits_count($pl_id,$from_date,$to_date)
 	{
 		$ret_mid = array();//THIS ARRAY WILL CONTAIN THE PERSON_ID AS KEY, AND THE NUMBER OF CORRESPONDING VISITS AS ITS VALUE
 		$ret = array();
 		$retu = array();
 		$ret_values = array();
 		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		{
 			foreach($visits as $visit)
 			{
 				$rec = $visit->person_id;
 				if($rec != 0)
	 			{
	 				if(array_key_exists($rec,$ret_mid))	
	 				{
	 					$ret_mid{$rec}=$ret_mid{$rec}+1;	 	
	 				}
	 				else
		 			{
		 				$ret_mid{$rec}=1;
		 				
		 			}
	 			}
 			}
 		}
 		
 		$ret_values = array_values($ret_mid);
 		foreach($ret_values as $ret_value)
		{
			if($ret_value != 0)
 			{
 				if(array_key_exists($ret_value,$ret))	
 				{
 					$ret{$ret_value}=$ret{$ret_value}+1;	 	
 				}
 				else
	 			{
	 				$ret{$ret_value}=1;
	 			}
 			}
		}
		arsort($ret);
 		return $ret;	
 	}
 	
 	//METHOD TO GET THE DATA FOR "Number OF Patients Seen By Each Doctor Report."
	function get_number_patients_by_doctor_count($pl_id,$from_date,$to_date)
	{
		$ret = array();
		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('opd/provider_model','providers');
		if($visits = $this->like('provider_location_id',$pl_id)
 				->where('date <=', $to_date)
 				->where('date >=', $from_date)
 				->where('valid_state','valid')
 				->find_all())
 		{
 			foreach($visits as $visit)
 			{
 				if($provider = $this->CI_handle->providers->find_by('id',$visit->provider_id))
 				{
 					$full_name = $provider->full_name;
 					if($full_name != "")
		 			{
		 				if(array_key_exists($full_name,$ret))	
		 				{
		 					$ret{$full_name}=$ret{$full_name}+1;	 	
		 				}
		 				else
			 			{
			 				$ret{$full_name}=1;
			 				
			 			}
		 			}
 				}
 			}	
 		}
 		arsort($ret);
 		return $ret;
	}
	
	//METHOD TO GET THE DATA FOR "Inventory consumed in Clinics Report."
	function get_inventory_consumed_count($pl_id,$from_date,$to_date, $rep_feature, $rep_option)
	{
		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('scm/product_model','products');
		$this->CI_handle->load->model('admin/opd_services_configuration_model','opd_services');
		$this->CI_handle->load->model('admin/test_group_tests_model','test_group_tests');
		$this->CI_handle->load->model('admin/test_group_consumables_model','test_group_consumables');
		$ret = array();
		if($visits = $this->like('provider_location_id',$pl_id)
 				  ->where('date >=', $from_date)
 				  ->where('date <=', $to_date)
 				  ->where('valid_state','valid')
 				  ->find_all())
 		{	
 			
	 		foreach($visits as $visit)
	 		{	
	 			$purchase_unit_medication = 0;
	 			$purchase_unit_opd = 0;
	 			$purchase_unit_service = 0;
	 			$purchase_unit_test = 0;
	 			if($rep_feature == 'ALL')
	 			{
		 			
		 			if($medications = $visit->related('visit_medication_entries')->get())
		 			{
			 			foreach($medications as $medication)
			 			{	
			 				if($product = $this->CI_handle->products->find_by('id',$medication->product_id))
			 				{	
	 							if($rep_option == "all")
	 							{
	 								$str = "/[0-9]+/";//THIS IS A REGEX TO GET ALL THE GENERIC IDS
	 							}
	 							else
	 							{
	 								$str = "/".$rep_option."/";
	 							}
	 							if(($product->retail_units_per_purchase_unit!=0) && (preg_match($str,$product->generic_id)))/*PREG_MATCH MATHCHES $STR WITH GENERIC ID AND RETURNS TRUE IF THEY MATCH*/
			 					{				 					
				 					if($medication->frequency == 'OD')
				 					{
				 						$purchase_unit_medication = round((($medication->duration)/($product->retail_units_per_purchase_unit)),1);
				 					}
				 					else if ($medication->frequency == 'BID')
				 					{
				 						$purchase_unit_medication = round((2*($medication->duration)/($product->retail_units_per_purchase_unit)),1);
				 					}
				 					else if ($medication->frequency == 'TID')
				 					{
				 						$purchase_unit_medication = round((3*($medication->duration)/($product->retail_units_per_purchase_unit)),1);
				 					}
				 					else
				 					{
				 						$purchase_unit_medication = round((1/($product->retail_units_per_purchase_unit)),1);
				 					}
				 					
				 					if(array_key_exists($product->name,$ret))
			 						{
			 							$ret{$product->name} = 	$ret{$product->name} + 	$purchase_unit_medication;
			 						}
			 						else
			 						{
			 							$ret{$product->name} = $purchase_unit_medication;
			 						}
		 						}	
		 					}
		 				}
		 			}
		 			if($services = $visit->related('visit_service_entries')->get())
		 			{
		 				foreach ($services as $service)
		 				{
		 					if($opd_services = $this->CI_handle->opd_services->find_all_by('opd_service_id',$service->service_id))
		 					{
		 						foreach($opd_services as $opd_service)
		 						{
		 							if($product = $this->CI_handle->products->find_by('id',$opd_service->product_id))
		 							{
		 								if($rep_option == "all")
			 							{
			 								$str = "/[0-9]+/";
			 							}
			 							else
			 							{
			 								$str = "/".$rep_option."/";
			 							}
		 								if(($product->retail_units_per_purchase_unit!=0) && (preg_match($str,$product->generic_id)))
		 								{
		 									$purchase_unit_service = round((($opd_service->product_quantity)/($product->retail_units_per_purchase_unit)),1);		
		 									if(array_key_exists($product->name,$ret))
					 						{
					 							$ret{$product->name} = 	$ret{$product->name} + 	$purchase_unit_service;
					 						}
					 						else
					 						{
					 							$ret{$product->name} = $purchase_unit_service;
					 						}				
					 					}
		 							}
		 						}
		 					}
		 				}
		 			}
		 			if($opd_products = $visit->related('visit_opdproduct_entries')->get())
		 			{
		 				foreach ($opd_products as $opd_product)
		 				{
		 					if($product = $this->CI_handle->products->find_by('id',$opd_product->product_id))
		 					{
		 						if($rep_option == "all")
	 							{
	 								$str = "/[0-9]+/";
	 							}
	 							else
	 							{
	 								$str = "/".$rep_option."/";
	 							}
		 						if(($product->retail_units_per_purchase_unit!=0) && (preg_match($str,$product->generic_id)))
		 						{
		 							$purchase_unit_opd = round((($opd_product->number)/($product->retail_units_per_purchase_unit)),1);				
			 						if(array_key_exists($product->name,$ret))
			 						{
			 							$ret{$product->name} = 	$ret{$product->name} + 	$purchase_unit_opd;
			 						}
			 						else
			 						{
			 							$ret{$product->name} = $purchase_unit_opd;
			 						}
		 						}
		 					}		 					
		 				}
		 			}
		 			if($tests = $visit->related('visit_test_entries')->get())
		 			{
		 				foreach ($tests as $test)
		 				{
		 					if($group_test = $this->CI_handle->test_group_tests->find_by('test_id',$test->test_type_id))
		 					{
		 						if($group_consumable = $this->CI_handle->test_group_consumables->find_by('test_group_id',$group_test->test_group_id))
	 							{
	 								if($product = $this->CI_handle->products->find_by('id',$group_consumable->product_id))
 									{	
 										if($rep_option == "all")
			 							{
			 								$str = "/[0-9]+/";
			 							}
			 							else
			 							{
			 								$str = "/".$rep_option."/";
			 							}
 										if(($product->retail_units_per_purchase_unit!=0) && (preg_match($str,$product->generic_id)))
 										{	
 											$purchase_unit_test = round((($group_consumable->quantity_lab + $group_consumable->quantity_clinic)/($product->retail_units_per_purchase_unit)),1);	
 											if(array_key_exists($product->name,$ret))
					 						{
					 							$ret{$product->name} = 	$ret{$product->name} + 	$purchase_unit_test;
					 						}
					 						else
					 						{
					 							$ret{$product->name} = $purchase_unit_test;
					 						}
 										}
 									}					 						
	 							}
		 					}
		 				}
		 			}
	 			}
	 			elseif($rep_feature == 'MEDICATION')
	 			{
	 				if($medications = $visit->related('visit_medication_entries')->get())
		 			{
			 			foreach($medications as $medication)
			 			{	
			 				if($product = $this->CI_handle->products->find_by('id',$medication->product_id))
			 				{	
	 							if($rep_option == "all")
	 							{
	 								$str = "/[0-9]+/";
	 							}
	 							else
	 							{
	 								$str = "/".$rep_option."/";
	 							}
	 							if(($product->retail_units_per_purchase_unit!=0) && (preg_match($str,$product->generic_id)))
			 					{				 					
				 					if($medication->frequency == 'OD')
				 					{
				 						$purchase_unit_medication = round((($medication->duration)/($product->retail_units_per_purchase_unit)),1);
				 					}
				 					else if ($medication->frequency == 'BID')
				 					{
				 						$purchase_unit_medication = round((2*($medication->duration)/($product->retail_units_per_purchase_unit)),1);
				 					}
				 					else if ($medication->frequency == 'TID')
				 					{
				 						$purchase_unit_medication = round((3*($medication->duration)/($product->retail_units_per_purchase_unit)),1);
				 					}
				 					else
				 					{
				 						$purchase_unit_medication = round((1/($product->retail_units_per_purchase_unit)),1);
				 					}
				 					if(array_key_exists($product->name,$ret))
			 						{
			 							$ret{$product->name} = 	$ret{$product->name} + 	$purchase_unit_medication;
			 						}
			 						else
			 						{
			 							$ret{$product->name} = $purchase_unit_medication;
			 						}
		 						}	
				 			}
			 			}
		 			}
	 			}
	 			elseif($rep_feature == 'CONSUMABLES')
	 			{
	 				if($services = $visit->related('visit_service_entries')->get())
		 			{
		 				foreach ($services as $service)
		 				{
		 					if($opd_services = $this->CI_handle->opd_services->find_all_by('opd_service_id',$service->service_id))
		 					{
		 						foreach($opd_services as $opd_service)
		 						{
		 							if($product = $this->CI_handle->products->find_by('id',$opd_service->product_id))
		 							{
		 								if($rep_option == "all")
			 							{
			 								$str = "/[0-9]+/";
			 							}
			 							else
			 							{
			 								$str = "/".$rep_option."/";
			 							}
		 								if(($product->retail_units_per_purchase_unit!=0) && (preg_match($str,$product->generic_id)))
		 								{
			 								$purchase_unit_service = round((($opd_service->product_quantity)/($product->retail_units_per_purchase_unit)),1);							if(array_key_exists($product->name,$ret))
					 						{
					 							$ret{$product->name} = 	$ret{$product->name} + 	$purchase_unit_service;
					 						}
					 						else
					 						{
					 							$ret{$product->name} = $purchase_unit_service;
					 						}	
		 								}
		 							}							
		 						}
		 					}
		 				}
		 			}
		 			if($tests = $visit->related('visit_test_entries')->get())
		 			{
		 				
		 				foreach ($tests as $test)
		 				{
		 					if($group_test = $this->CI_handle->test_group_tests->find_by('test_id',$test->test_type_id))
		 					{
		 						if($group_consumable = $this->CI_handle->test_group_consumables->find_by('test_group_id',$group_test->test_group_id))
	 							{
	 								if($product = $this->CI_handle->products->find_by('id',$group_consumable->product_id))
 									{	
 										if($rep_option == "all")
			 							{
			 								$str = "/[0-9]+/";
			 							}
			 							else
			 							{
			 								$str = "/".$rep_option."/";
			 							}
 										if(($product->retail_units_per_purchase_unit!=0) && (preg_match($str,$product->generic_id)))
 										{	
 											$purchase_unit_test = round((($group_consumable->quantity_lab + $group_consumable->quantity_clinic)/($product->retail_units_per_purchase_unit)),1);	
 											if(array_key_exists($product->name,$ret))
					 						{
					 							$ret{$product->name} = 	$ret{$product->name} + 	$purchase_unit_test;
					 						}
					 						else
					 						{
					 							$ret{$product->name} = $purchase_unit_test;
					 						}
 										}
 									}	 								
	 							}		
		 					}
		 				}
		 			}
	 			}
	 			else
	 			{
	 				if($opd_products = $visit->related('visit_opdproduct_entries')->get())
		 			{
		 				foreach ($opd_products as $opd_product)
		 				{
		 					if($product = $this->CI_handle->products->find_by('id',$opd_product->product_id))
		 					{
		 						if($rep_option == "all")
	 							{
	 								$str = "/[0-9]+/";
	 							}
	 							else
	 							{
	 								$str = "/".$rep_option."/";
	 							}
		 						if(($product->retail_units_per_purchase_unit!=0) && (preg_match($str,$product->generic_id)))
		 						{
		 							$purchase_unit_opd = round((($opd_product->number)/($product->retail_units_per_purchase_unit)),1);				
		 							
		 							if(array_key_exists($product->name,$ret))
			 						{
			 							$ret{$product->name} = 	$ret{$product->name} + 	$purchase_unit_opd;
			 						}
			 						else
			 						{
			 							$ret{$product->name} = $purchase_unit_opd;
			 						}		
		 						}
		 					}		 					
		 				}
		 			}
	 			}
	 		}	 		
 		}
 		arsort($ret);	
 		return $ret;
	}
	
	
	//METHOD TO GET THE DATA FOR "CVD Risk Factor Aggregation Report."
	function get_risk_factor_one_count($pl_id,$from_date,$to_date)
	{
		//A BUCKET FOR ALL THE RISK FACTORS
		$risk_factor_distribution = array("Age"=>0, "WHR"=>0, "BMI"=>0,"High BP"=>0, "Tobacco Consumption"=>0, "Personal History"=>0); 
		
		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('demographic/person_model','persons');
		$this->CI_handle->load->model('mne/forms/mne_pisp_adult_model','pisp_adult');
		$this->CI_handle->load->model('mne/forms/mne_pisp_personal_illness_model','pisp_personal_illness');
		$this->CI_handle->load->model('mne/forms/mne_pisp_adult_smoking_model','pisp_adult_smoking');
		if($visits = $this->like('provider_location_id',$pl_id)
 				  ->where('date >=', $from_date)
 				  ->where('date <=', $to_date)
 				  ->where('valid_state','valid')
 				  ->find_all())
 		{
 			$person_ids = array();
 			$persons_ids = array();
 			foreach($visits as $visit)
 			{
 				$person_ids[] = $visit->person_id;
 			}
 			$persons_ids = array_unique($person_ids);
 			foreach($persons_ids as $person_id)
 			{
 				if($person_id != NULL)
 				{
	 				if($person = $this->CI_handle->persons->find_by('id',$person_id))
	 				{
						$dob = $person->date_of_birth;
						list($year,$month,$day) = explode("-",$dob);
			    			$year_diff  = date("Y") - $year;
			    			$month_diff = date("m") - $month;
			    			$day_diff   = date("d") - $day;
			    			if ($day_diff < 0 || $month_diff < 0)
			    			{
			      				$year_diff--;
			      			}
			    			$age = $year_diff;
			    			if($age>35)
			    			{
			    				$risk_factor_distribution['Age']+=1;
			    			}
			     			$organization_member_id = $person->organization_member_id;
			    			if($organization_member_id != NULL)
			    			{
				    			if($pisp_adult = $this->CI_handle->pisp_adult->find_by('adult_id',$organization_member_id))
				    			{
					    			if(($pisp_adult->wc != NULL) && ($pisp_adult->hc != NULL))
					    			{
					    				if($pisp_adult->hc !=0)
					    				{
						    				if($person->gender == 'M')
						    				{
						    					if(($pisp_adult->wc/$pisp_adult->hc) > 0.95)
						    					{
						    						$risk_factor_distribution['WHR']+=1;
						    					}
						    				}
						    				elseif($person->gender == 'F')
						    				{
						    					if(($pisp_adult->wc/$pisp_adult->hc) > 0.8)
						    					{
						    						$risk_factor_distribution['WHR']+=1;
						    					}
						    				}
					    				}
					    			}
					    			if($pisp_adult_smoking = $this->CI_handle->pisp_adult_smoking->find_by('data_point_id',$pisp_adult->id))
					    			{
						    			if(($pisp_adult_smoking->tobacco_current == 'y') || ($pisp_adult_smoking->smoking_current == 'y'))
					    				{
					    					$risk_factor_distribution['Tobacco Consumption']+=1;
					    				}
						    			
					    			}
					    			if($pisp_personal_illness = $this->CI_handle->pisp_personal_illness->find_all_by('data_point_id',$pisp_adult->id))
					    			{
					    				foreach($pisp_personal_illness as $pisp_personal_illness_record)
					    				{
							    			if(($pisp_personal_illness_record->label_value != NULL) || ($pisp_personal_illness_record->pisp_chronic_conditions != NULL))
							    			{
							    				if((preg_match('/[1-4]/',$pisp_personal_illness_record->label_value)) && ($pisp_personal_illness_record->pisp_chronic_conditions == 'y'))
							    				{
							    					$risk_factor_distribution['Personal History']+=1;
							    					break;
							    				}
							    			}
						    			}
					    			}
					    		}
			    			}
		    			}
		    			if($visit = $this->find_by('person_id',$person_id))
					{
						if($visit_vital = $visit->related('visit_vitals')->get())
			    			{
				    			if(($visit_vital->bp_systolic != NULL) && ($visit_vital->bp_diastolic != NULL))
				    			{
				    				if(($visit_vital->bp_systolic >= 140) || ($visit_vital->bp_diastolic >= 90))
				    				{
				    					$risk_factor_distribution['High BP']+=1;
				    				}
				    			}
				    			if(($visit_vital->height_cm != NULL) && ($visit_vital->weight_kg != NULL))
				    			{
				    				$height_meters = $visit_vital->height_cm/100;
				    				if($height_meters !=0)
				    				{
				    					$BMI = $visit_vital->weight_kg/($height_meters*$height_meters);
				    					if($BMI > 23)
					    				{	
					    					$risk_factor_distribution['BMI']+=1;
					    				}
				    				}
				    			}
			    			}
		    			}
	    			}
	 		}
 		}
 		arsort($risk_factor_distribution);
 		return $risk_factor_distribution;
	}
	
	
	//METHOD TO GET THE DATA FOR "Count of CVD Risk Factor Report."
	function get_risk_factor_two_count($pl_id,$from_date,$to_date)
	{
		$ret = array();
		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('demographic/person_model','persons');
		$this->CI_handle->load->model('mne/forms/mne_pisp_adult_model','pisp_adult');
		$this->CI_handle->load->model('mne/forms/mne_pisp_personal_illness_model','pisp_personal_illness');
		$this->CI_handle->load->model('mne/forms/mne_pisp_adult_smoking_model','pisp_adult_smoking');
		if($visits = $this->like('provider_location_id',$pl_id)
 				  ->where('date >=', $from_date)
 				  ->where('date <=', $to_date)
 				  ->where('valid_state','valid')
 				  ->find_all())
 		{
 			$person_ids = array();
 			foreach($visits as $visit)
 			{
 				$person_ids[] = $visit->person_id;
 			}
 			$persons_ids = array_unique($person_ids);
 			foreach($persons_ids as $person_id)
 			{
 				if($person_id != NULL)
 				{
	 				$count = 0;
	 				if($person = $this->CI_handle->persons->find_by('id',$person_id))
	 				{
						$dob = $person->date_of_birth;
						list($year,$month,$day) = explode("-",$dob);
			    			$year_diff  = date("Y") - $year;
			    			$month_diff = date("m") - $month;
			    			$day_diff   = date("d") - $day;
			    			if ($day_diff < 0 || $month_diff < 0)
			    			{
			      				$year_diff--;
			    			}
			    			$age = $year_diff;
			    			if($age>35)
			    			{
			    				$count = $count + 1;
			    			}
			    			$organization_member_id = $person->organization_member_id;
			    			if($organization_member_id != NULL)
			    			{
				    			if($pisp_adult = $this->CI_handle->pisp_adult->find_by('adult_id',$organization_member_id))
				    			{
					    			if(($pisp_adult->wc != NULL) && ($pisp_adult->hc != NULL))
					    			{
					    				if($pisp_adult->hc !=0)
					    				{
						    				if($person->gender == 'M')
						    				{
						    					if(($pisp_adult->wc/$pisp_adult->hc) > 0.95)
						    					{
						    						$count = $count + 1;
						    					}
						    				}
						    				elseif($person->gender == 'F')
						    				{
						    					if(($pisp_adult->wc/$pisp_adult->hc) > 0.8)
						    					{
						    						$count = $count + 1;
						    					}
						    				}
					    				}
					    			}
					    			if($pisp_adult_smoking = $this->CI_handle->pisp_adult_smoking->find_by('data_point_id',$pisp_adult->id))
					    			{
						    			
					    				if(($pisp_adult_smoking->tobacco_current == 'y') || ($pisp_adult_smoking->smoking_current == 'y'))
					    				{
					    					$count = $count + 1;
					    				}
						    			
					    			}
					    			if($pisp_personal_illness = $this->CI_handle->pisp_personal_illness->find_all_by('data_point_id',$pisp_adult->id))
					    			{
					    				foreach($pisp_personal_illness as $pisp_personal_illness_record)
					    				{
							    			if(($pisp_personal_illness_record->label_value != NULL) || ($pisp_personal_illness_record->pisp_chronic_conditions != NULL))
							    			{
							    				if((preg_match('/[1-4]/',$pisp_personal_illness_record->label_value)) && ($pisp_personal_illness_record->pisp_chronic_conditions == 'y'))
							    				{
							    					$count = $count + 1;
							    					break;
							    				}
							    			}
						    			}
					    			}
					    		}
					    	}
					}
		    			if($visit = $this->find_by('person_id',$person_id))
					{
						if($visit_vital = $visit->related('visit_vitals')->get())
			    			{
				    			if(($visit_vital->bp_systolic != NULL) && ($visit_vital->bp_diastolic != NULL))
				    			{
				    				if(($visit_vital->bp_systolic >= 140) || ($visit_vital->bp_diastolic >= 90))
				    				{
				    					$count = $count + 1;
				    				}
				    			}
				    			
				    			if(($visit_vital->height_cm != NULL) && ($visit_vital->weight_kg != NULL))
				    			{
				    				$height_meters = $visit_vital->height_cm/100;
				    				if($height_meters !=0)
				    				{
				    					$BMI = $visit_vital->weight_kg/($height_meters*$height_meters);
				    					if($BMI > 23)
					    				{	
					    					$count = $count + 1;
					    				}
				    				}
				    			}
			    			}
		    			}
		    			if(array_key_exists($count,$ret))
					{
						$ret{$count} = 	$ret{$count} + 	1;
					}
					else
					{
						$ret{$count} = 1;
					}	 
		    			
				}   
	 		}
 		}
 		ksort($ret);
 		return $ret;
	}
	
	
	//METHOD TO GET THE STATUS IF THE PERSON HAS THE PARTICULAR RISK FOR "Risk Factors Combination Report."
	function get_risk_status_for_person($person_id,$risk_id)
	{
		//The keys in the bucket below are assigned according to the 'id' that I have given to each risk factor in the view file of this report
		$risk_array = array("1"=>"Age", "2"=>"BMI", "3"=>"WHR", "4"=>"Tobacco Consumption", "5"=>"High BP", "6"=>"Personal History"); 
		
		$this->CI_handle =& get_instance();
		$this->CI_handle->load->model('demographic/person_model','persons');
		$this->CI_handle->load->model('mne/forms/mne_pisp_adult_model','pisp_adult');
		$this->CI_handle->load->model('mne/forms/mne_pisp_personal_illness_model','pisp_personal_illness');
		$this->CI_handle->load->model('mne/forms/mne_pisp_adult_smoking_model','pisp_adult_smoking');
		$true = 0;
		if($risk_array{$risk_id} == 'Age')
		{
			if($person = $this->CI_handle->persons->find_by('id',$person_id))
			{
				$dob = $person->date_of_birth;
				list($year,$month,$day) = explode("-",$dob);
	    			$year_diff  = date("Y") - $year;
	    			$month_diff = date("m") - $month;
	    			$day_diff   = date("d") - $day;
	    			if ($day_diff < 0 || $month_diff < 0)
	    			{
	      				$year_diff--;
	    			}
	    			$age = $year_diff;
	    			if($age>35)
	    			{
	    				$true = 1;
	    				return $true;
	    			}
	    		}
		}
		elseif($risk_array{$risk_id} == 'BMI')
		{
			if($visit = $this->find_by('person_id',$person_id))
			{
				if($visit_vital = $visit->related('visit_vitals')->get())
	    			{
		    			if(($visit_vital->height_cm != NULL) && ($visit_vital->weight_kg != NULL))
		    			{
		    				$height_meters = ($visit_vital->height_cm)/100;
		    				if($height_meters !=0)
		    				{
		    					$BMI = ($visit_vital->weight_kg)/($height_meters*$height_meters);
		    					if($BMI > 23)
			    				{	
			    					$true = 1;
			    					return $true;
			    				}
		    				}	    				
		    			}
		    		}
	    		}
		}
		elseif($risk_array{$risk_id} == 'WHR')
		{
			if($person = $this->CI_handle->persons->find_by('id',$person_id))
			{
				$organization_member_id = $person->organization_member_id;
	    			if($organization_member_id != NULL)
	    			{
		    			if($pisp_adult = $this->CI_handle->pisp_adult->find_by('adult_id',$organization_member_id))
		    			{
			    			if(($pisp_adult->wc != NULL) && ($pisp_adult->hc != NULL))
			    			{
			    				if($person->gender == 'M')
			    				{
			    					if($pisp_adult->hc !=0)
			    					{
				    					if(($pisp_adult->wc/$pisp_adult->hc) > 0.95)
				    					{
				    						$true = 1;
				    						return $true;
				    					}
			    					}
			    				}
			    				elseif($person->gender == 'F')
			    				{
			    					if($pisp_adult->hc !=0)
			    					{
				    					if(($pisp_adult->wc/$pisp_adult->hc) > 0.8)
				    					{
				    						$true = 1;
				    						return $true;
				    					}
			    					}
			    				}
			    			}
			    		}
			    	}
		    	}
		}
		elseif($risk_array{$risk_id} == 'Tobacco Consumption')
		{
			if($person = $this->CI_handle->persons->find_by('id',$person_id))
			{
				$organization_member_id = $person->organization_member_id;
	    			if($organization_member_id != NULL)
	    			{
		    			if($pisp_adult = $this->CI_handle->pisp_adult->find_by('adult_id',$organization_member_id))
		    			{
			    			if($pisp_adult_smoking = $this->CI_handle->pisp_adult_smoking->find_by('data_point_id',$pisp_adult->id))
			    			{
				    			if(($pisp_adult_smoking->tobacco_current != NULL) || ($pisp_adult_smoking->smoking_current != NULL))
				    			{
				    				if(($pisp_adult_smoking->tobacco_current == 'y') || ($pisp_adult_smoking->smoking_current == 'y'))
				    				{
				    					$true = 1;
				    					return $true;
				    				}
				    			}
			    			}
			    		}
			    	}
		    	}
		}
		elseif($risk_array{$risk_id} == 'High BP')
		{
			if($visit = $this->find_by('person_id',$person_id))
			{
				if($visit_vital = $visit->related('visit_vitals')->get())
	    			{
		    			if(($visit_vital->bp_systolic != NULL) && ($visit_vital->bp_diastolic != NULL))
		    			{
		    				if(($visit_vital->bp_systolic >= 140) || ($visit_vital->bp_diastolic >= 90))
		    				{
		    					$true = 1;
		    					return $true;
		    				}
		    			}
	    			}
    			}
		}
		elseif($risk_array{$risk_id} == 'Personal History')
		{
			if($person = $this->CI_handle->persons->find_by('id',$person_id))
			{
				$organization_member_id = $person->organization_member_id;
	    			if($organization_member_id != NULL)
	    			{
		    			if($pisp_adult = $this->CI_handle->pisp_adult->find_by('adult_id',$organization_member_id))
		    			{
			    			
			    			if($pisp_personal_illness = $this->CI_handle->pisp_personal_illness->find_all_by('data_point_id',$pisp_adult->id))
			    			{
			    				foreach($pisp_personal_illness as $pisp_personal_illness_record)
			    				{
					    			if(($pisp_personal_illness_record->label_value != NULL) || ($pisp_personal_illness_record->pisp_chronic_conditions != NULL))
					    			{
					    				if((preg_match('/[1-4]/',$pisp_personal_illness_record->label_value)) && ($pisp_personal_illness_record->pisp_chronic_conditions == 'y'))
					    				{
					    					$true = 1;
					    					return $true;
					    				}
					    			}
				    			}
			    			}
		    			}
	    			}
    			}
		}
		return 0;
	}
	
	
	//METHOD TO GET THE STATUS IF THE PERSON HAS THE PARTICULAR DIAGNOSIS(diabetes mellitus, hypertension OR hyperlipidemia) FOR "Risk Factors Combination Report."
	function get_status_for_diagnosis($person_id)
	{
		$true = 0;
		if($visits = $this->find_all_by('person_id',$person_id))
		{
			foreach($visits as $visit)
	 		{
	 			
				if($diagnosis = $visit->related('visit_diagnosis_entries')->get())
				{
				 	foreach($diagnosis as $d)
			 		{
			 			$diag = $d->diagnosis;
			 			if(($diag =="diabetes mellitus") || ($diag =="hypertension") || ($diag =="hyperlipidemia"))
			 			{
			 				$true = 1;
			 				return $true;
			 			}
			 		}
		 		}
			}
		}
		return 0;
	}
	
	
	//METHOD TO GET THE DATA FOR "Risk Factors Combination Report."
	function get_risk_factor_combination_count($pl_id,$from_date,$to_date,$risk_ids) 
	{
		$ret = array();
		if($visits = $this->like('provider_location_id',$pl_id)
 				  ->where('date >=', $from_date)
 				  ->where('date <=', $to_date)
 				  ->where('valid_state','valid')
 				  ->find_all())
 		{	
 			$count = 0;
 			$count_two = 0;
 			$count_trial =0;
 			$person_ids = array();
 			$persons_ids = array();
 			foreach($visits as $visit)
 			{
 				$person_ids[] = $visit->person_id;
 			}
 			$persons_ids = array_unique($person_ids);
 			foreach($person_ids as $person_id)
 			{
 				$risk = array();
 				$risk = null;
 				if($person_id!=NULL)
 				{
	 				foreach($risk_ids as $risk_id)
	 				{
	 					$risk[] = $this->get_risk_status_for_person($person_id,$risk_id);
	 				}
	 				if(count(array_unique($risk))==1)
	 				{	
	 					$count_total++;
	 					$value = array_unique($risk);
	 					if($value{0} == 1)
	 					{
		 					$count = $count+1;
		 					$status_diagnosis = $this->get_status_for_diagnosis($person_id);
		 					if($status_diagnosis == 1)
		 					{
		 						$count_two = $count_two + 1;
		 					}
	 					}
	 				}
			 	}			
	 		}
 		}
 		
 		$ret[] = $count;//$COUNT IS THE TOTAL NUMBER WHO HAVE ALL THE RISK FACTORS MENTIONED
 		$ret[] = $count_two;/*$COUNT_TWO IS THE TOTAL NUMBER WHO HAVE ALL THE RISK FACTORS MENTIONED AND HAVE EITHER OF DIAGNOSIS AMONG diabetes mellitus, hypertension OR hyperlipidemia*/
 		$ret[] = $count_total;//$COUNT_TOTAL IS TOTTAL NUMBER
 		
 		return $ret;	
	}	 		
}
