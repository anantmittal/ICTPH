<?php
class Enrol extends CI_Controller {
	var $bar_colours=array('#0066CC', '#639F45', '#9933CC');
	
	var $relation_map = array('self'=>'Self', 'wife'=>'Wife', 'husband'=>'Husband', 'son'=>'Son', 'grand_daughter'=>'Grand_daughter', 'daughter'=>'Daughter', 			'other'=>'Other', 'mother_in_law'=>'Mother_in_Law','brother'=>'Brother','father'=>'Father','sister'=>'Sister', 'mother'=>'Mother',
		'daughter_in_law'=>'Daughter_in_Law','grandmother'=>'Grandmother','grandson'=>'Grand_son','son_in_law'=>'Son_in_law',
		'father_in_law'=>'Father_in_Law', 'brother_in_law'=>'Brother_in_Law', 'grandfather'=>'Grandfather', 'sister_in_law'=>'Sister_in_Law');
	var $month_map = array('Jan'=> 01,'Feb'=> 02,'Mar'=> 03, 'Apr' => 04, 'May'=> 05,'Jun'=> 06,'Jul'=> 07,'Aug'=>08, 'Sep'=>09,'Oct'=>10,'Nov'=>11,'Dec'=>12);

	var $current_project = 0;
	function index()
	{
		$this->load->model('enrol/enrol_project_affiliation_model','project_affiliation');
			
		$username = $this->session->userdata('username');
		$current_project = $this->project_affiliation->get_current_project($username);
		if(!$_POST)
		{
			
			$data['username']=$username;
			if($current_project == NULL)
			{
				redirect('enrol/enrol/configuration');
			}
			else
			{
				$this->load->model('enrol/enrol_project_model','project');
				$data = $this->project->get_properties($current_project);
				$data['current_project']=$current_project;
				$this->load->view('enrol/home.php', $data);
			}
			return;
		}
		//This is a post request. Now handle the different kinds of input
		if($current_project != NULL)
			redirect('enrol/enrol/'.$this->input->post('action').'/'.$current_project.'/'.$this->input->post('agent').'/'.$this->input->post('record_type'));
	}
	
	function configuration()
	{
		$this->load->model('enrol/enrol_project_affiliation_model','project_affiliation');
		$this->load->model('enrol/enrol_project_model','project');
			
		$username = $this->session->userdata('username');
		$current_project = $this->project_affiliation->get_current_project($username);
		$data['username']=$username;
		$data['project_list'] = $this->project->get_all_projects();
		$data['current_project'] = $current_project;
		$data['current_project_name']=$this->project->get_project_name($current_project);
		$this->load->view('enrol/configuration', $data);
	}

	function __get_content($filearr)
	{
		$tmppath = $filearr['tmp_name'];
		if(trim($tmppath)=="")
			return "";
		$str = file_get_contents($tmppath);
		$type = $filearr['type'];
		if($type=='application/x-bzip')
			$str =  bzdecompress($str);
		return $str;
	}
	private function get_xml_content($filearr)
	{
		$tmppath = $filearr['tmp_name'];
		if(trim($tmppath)=="")
			return "";
		//$str = simplexml_load_file($tmppath);
		
		$type = $filearr['type'];
		if($type=='application/x-bzip')
		{
			$zip = new ZipArchive();
			if($zip->open($tmppath))
			{
				echo "here";
				$zip->extractTo("base_url()./uploads/enrolment");
			}
			
		}
		
		return $str;
	}  
	
	function upload_rra_from_csv($project_id)
	{
		$this->load->model('enrol/enrol_rra_model','enrol_rra');
		$this->load->model('enrol/enrol_person_model','enrol_person');
		$this->load->model('enrol/enrol_project_model','enrol_project');
		
		$rracontent =$this->__get_content($_FILES['rra']);
		$params = array('project_id'=>$project_id);
		$params['agent_devices']=$this->enrol_project->get_agents_devices($project_id);
		if(trim($rracontent) != "")
		{
			echo "Updating RRA data...<br/>";
			$rrarecs = $this->__convert_csv_to_map($rracontent, "__normalize_rra_record",$params);
			$this->enrol_rra->store_records($rrarecs);
		}
	}
	
	function upload_from_xml($project_id)
	{
		$this->load->model('enrol/enrol_household_model','enrol_household');
		$this->load->model('enrol/enrol_person_model','enrol_person');
		$this->load->model('enrol/enrol_project_model','enrol_project');
		
		$content = $this->get_xml_content($_FILES['xml_file']);
		
		$params = array('project_id'=>$project_id);
		$params['agents']=$this->enrol_project->get_agents_list($project_id);
		$params['street_fields']=$this->enrol_project->get_street_fields($project_id);
		
		$normalizer_arr = "normalize_xml_file";
		
		$recs = $this->convert_xml_to_map($content,$params);
		$hrec = $recs[0];
		$irec = $recs[1];
		
		$hrec = $this->normalize_xml_household($hrec,$params);
		$hrecs[0] = $hrec;
		$errors = $this->enrol_household->store_records($project_id, $hrecs);
			
		if(count($errors)>0)
			echo "Errors detected:<br/>";
		foreach($errors as $k=>$v)
			echo "$k: $v<br/>";
		
		$indi_count = count($irec);
		for($i=0;$i<$indi_count;$i++)
		{
		$irec{$i} = $this->normalize_xml_individual($irec{$i},$params);
		}
				
		$this->enrol_person->store_records($irec);
				
		
	}
	
	
	
	function upload_from_csv($project_id)
	{
		$this->load->model('enrol/enrol_household_model','enrol_household');
		$this->load->model('enrol/enrol_person_model','enrol_person');
		$this->load->model('enrol/enrol_project_model','enrol_project');


		$hcontent =$this->__get_content($_FILES['household']);
		$icontent=$this->__get_content($_FILES['individual']);
		
		//Pass the list of agents
		$params = array('project_id'=>$project_id);
		$params['agents']=$this->enrol_project->get_agents_list($project_id);
		$params['street_fields']=$this->enrol_project->get_street_fields($project_id);
		$normalizer_arr = array("__normalize_commcare_household", "__normalize_commcare_individual");
		if($this->enrol_project->get_project_tool($project_id) == 'odk')
			$normalizer_arr = array("__normalize_odk_household", "__normalize_odk_individual");
		
		if(trim($hcontent) != "") //returns the files in a string
		{
			echo "Updating households...<br/>";
			$hrecs = $this->__convert_csv_to_map($hcontent, $normalizer_arr[0],$params);
			$errors = $this->enrol_household->store_records($project_id, $hrecs);
			if(count($errors)>0)
				echo "Errors detected:<br/>";
			foreach($errors as $k=>$v)
				echo "$k: $v<br/>";
		}
		
		if(trim($icontent) != "")
		{
			//Now write the individuals
			echo "<br/>Updating Individual data...<br/>";
			$irecs = $this->__convert_csv_to_map($icontent, $normalizer_arr[1], array('project_id'=>$project_id));
			$this->enrol_person->store_records($irecs);
		}
	}

	private function convert_xml_to_map($data,$params = array())
	{
		$key = mt_rand();
		foreach($data->children() as $child)
		{
			
			
			$attribute = strVal($child->getName());
			$value = strVal($child);
			if($attribute == 'individual')
			{
				foreach($child as $indi_rec)
				{
					$attribute = strVal($indi_rec->getName());
					$value = strVal($indi_rec);
					$rec{$attribute} = $value;
				}
				$rec['key'] = $key;
				$irec[] = $rec;
			}
			else
				$hrec{$attribute} = $value;
			//	$rec{$child->getName()} = strval($child);
		
				//$rec{$child->getName()} = $child;
		}
		$hrec['key'] = $key;
		
		
		$rec[0] = $hrec;
		$rec[1] = $irec;
		return $rec;
	}
	
	function __convert_csv_to_map($data, $normalize_func="__normalize_odk_household", $params=array())
	{
		$lines = $this->str_getcsv($data);
		$bFirst = true;
		$cols = array();
		$map=array();
		$line_num = 0;
		foreach($lines as $line)
		{
			$record=array();
			$ctr=0;
			
			if($bFirst == true)
			{
				$cols=$line;
				$bFirst = false;
			}
			else
			{
				if(count($line) != count($cols))
				{
					echo "Mismatch in number of fields on line ".$line_num."<br/>";
				}
				else
				{
					foreach($line as $field)
					{
						$record[$cols[$ctr]]=$field;
						$ctr++;
					}
					//Record has been constructed. We may have to normalize it
					$map[]=$this->{$normalize_func}($record,$params);
				}
			}
			$line_num++;
		}
		return $map;
	}
	function __normalize_rra_record($rec, $params)
	{	
		$newrec = array('project_id'=>$params['project_id']);
		$conversion = array('form.bp_diastole'=>'bp_diastole','form.bp_systole'=>'bp_systole',
					'form.hc'=>'hc','form.pregnant'=>'pregnant','id'=>'uid', 						'form.weight'=>'weight','form.cvd_voucher'=>'cvd_voucher',
					'form.case.case_id'=>'case_id',
					'form.tobacco'=>'tobacco','form.vision_voucher'=>'vision_voucher',
					'form.wc'=>'wc','form.personal_history'=>'personal_history',
					'form.height'=>'height');
		
		foreach($conversion as $k=>$v)
			$newrec[$v] = $rec[$k];
		$newrec['agent'] = $params['agent_devices'][$rec['form.meta.deviceID']];
		$newrec['enrol_project_id']=$params['project_id'];
		$newrec['person_id']='';
		if($person = $this->enrol_person->find_by('key', $newrec['case_id']))
			$newrec['person_id']=$person->id;

		$newrec['marital_status'] = (strtolower(trim($rec['form.marital_status']))== 'no')?0:1;
		$newrec['pregnant'] = (strtolower(trim($rec['form.pregnant']))== 'no')?0:1;
		$newrec['tobacco'] = (strtolower(trim($rec['form.tobacco']))== 'no')?0:1;
		
		$newrec['personal_history']=str_replace(' ',',',$rec['form.personal_history']);

		$newrec['cvd_voucher']=(strtolower(trim($rec['form.cvd_voucher']))== '---')?'':trim($rec['form.cvd_voucher']);
		$newrec['vision_voucher']=(strtolower(trim($rec['form.vision_voucher']))== '---')?'':trim($rec['form.vision_voucher']);
		
		$newrec['time'] = str_replace('Z','',trim($rec['form.meta.timeEnd']));
		if (($timestamp = strtotime($newrec['time'])) != false) 
			$newrec['time']=strtotime($newrec['time']);
		
		return $newrec;

	}
	
	private function normalize_xml_household($rec,$params)
	{
		/*  start and end does not work with this function yet      */
		$newrec = $rec;
		$newrec['street'] = $this->__get_street($rec, $params['street_fields']);
		date_default_timezone_set('Asia/Kolkata');
		$newrec['village'] = $this->__get_village($rec);
		$location = explode(" ",$rec['location']);
		$newrec['latitude'] = $location[0];
		$newrec['longitude'] = $location[1];
		$newrec['locationAccuracy'] = $location[2];
		$newrec['locationAltitude'] = $location[3];
		$newrec['enrol_project_id']=$params['project_id'];
		
		if(array_key_exists('start',$rec))
		{
			
			$timestamp = str_replace(",","",$rec['start']);
			$timestamp = explode(" ",$timestamp);
			$timestamp = $timestamp[1]." ".$timestamp[0].",".$timestamp[2]." ".$timestamp[3]." ".$timestamp[4];
			$timestamp = strtotime($timestamp);
			$newrec['date']=$timestamp;
		}
		else
			$newrec['date'] = time();
			
		
		return $newrec;
	}
	function __normalize_odk_household($rec,$params)
	{
		$newrec = $rec;
		$newrec['key'] =$rec['KEY']; // for the new version of ODK Aggregate - Feb 7, 2012
		/*$key = $rec['individual'];  (this will work for the enrolments done on Sughavazhvu.appspot.com for the Enrolments upto OKM)
		$strArr = explode('%22',$key);
		if(count($strArr)==3)
			$newrec['key']=$strArr[1]; */
		$newrec['street'] = $this->__get_street($rec, $params['street_fields']);
		date_default_timezone_set('Asia/Kolkata');
		$newrec['village'] = $this->__get_village($rec);
		$newrec['latitude']=$rec['location-Latitude'];
		$newrec['longitude']=$rec['location-Longitude'];
		$newrec['locationAccuracy'] = $rec['location-Accuracy'];
		$newrec['locationAltitude'] = $rec['location-Altitude'];
	
		$newrec['enrol_project_id']=$params['project_id'];
		// change in the way briefcase pulls out time from the server. 
		$timestamp = str_replace(",","",$rec['start']);
		$timestamp = explode(" ",$timestamp);
		if(array_key_exists($timestamp[0], $this->month_map))
			$timestamp[0] = $this->month_map[$timestamp[0]];
		$timestamp = $timestamp[1]."-".$timestamp[0]."-".$timestamp[2].",".$timestamp[3]." ".$timestamp[4];
		
		$timestamp = strtotime($timestamp);
		
		$newrec['date']=$timestamp;
		
		$end = str_replace(",","",$rec['end']);
		$end = explode(" ",$end);
		if(array_key_exists($end[0], $this->month_map))
			$end[0] = $this->month_map[$end[0]];
		$end = $end[1]."-".$end[0]."-".$end[2].",".$end[3]." ".$end[4];
		
		$end = strtotime($end);
		;
		$newrec['end']=$end;
		//$test = strtotime("09-04-2012, 5:54:57 PM");
		//$newrec['end']=$test;
		
	
		
	
		/* 
		if (($timestamp = strtotime($rec['start'])) != false) 
			$newrec['date']=$timestamp;
		if (($timestamp = strtotime($rec['end'])) != false) 
			$newrec['end']=$timestamp;
		*/
		return $newrec;
	}

	function __normalize_commcare_household($rec,$params)
	{
		$newrec = $rec;
		$newrec['street'] = $this->__get_commcare_street($rec, $params['street_fields']);
		$newrec['village'] = $this->__get_village($rec);
		$newrec['agent']= $params['agents'][$rec['guide_name']];
		$loc=explode(' ',$rec['location']);
		$newrec['latitude']=$loc[0];
		$newrec['longitude']=$loc[1];
		$newrec['locationAccuracy'] = $loc[3];
		$newrec['locationAltitude'] = $loc[2];
		$newrec['members_num']= $rec['individual_count'];
		$newrec['enrol_project_id']=$params['project_id'];
		$rec['submit_time'] = str_replace('Z','',trim($rec['submit_time']));
		if (($timestamp = strtotime($rec['submit_time'])) != false) 
			$newrec['date']=$timestamp;
		$newrec['phone'] = trim($newrec['phone']);
		$newrec['phone'] = str_replace(',','|',$newrec['phone']);
		$newrec['key']=$rec['id'];
		unset($newrec['id']);
		unset($newrec['']);
		return $newrec;
	}
	/*function __normalize_odk_household($rec,$params)
	{
		$rec['street'] = $this->__get_street($rec);
		$rec['village'] = $this->__get_village($rec);
		
		//get latitude and longitude
		$loc=explode(',',$rec['location']);
		if(count($loc) ==2)
		{
			$rec['latitude']=(float)$loc[0];
			$rec['longitude']=(float)$loc[1];
		}
		if (($timestamp = strtotime($rec['SubmissionDate'])) != false) 
			$rec['date']=$timestamp;
		$rec['respondentdob']=date("Y/m/d", strtotime($rec['respondentdob']));
		$newrec['enrol_project_id']=$params['project_id'];
		return $rec;
	}
	*/

	function __normalize_commcare_individual($rec,$params)
	{	

		$rec['relation'] = $this->__get_relation($rec);
		$rec['dob']=date("Y/m/d", strtotime($rec['dob']));
		$rec['enrol_household_id']=0;
		if($hh = $this->enrol_household->find_by(array('cardnum','enrol_project_id'),array($rec['key'], $params['project_id'])))
			$rec['enrol_household_id']=$hh->id;
		$rec['key']=$rec['case_id'];
		unset($rec['id']);
		unset($rec['']);
		return $rec;
	}
	
	private function normalize_xml_individual($rec,$params)
	{
		$rec['relation'] = $this->__get_relation($rec);
		
		 // changes made due to upgraded version of ODK aggregate - Feb 7,2012
		
		$key = $rec['key'];
		if($hh = $this->enrol_household->find_by('key',$key))
		{
			$rec['enrol_household_id']=$hh->id;
			
		}
		else
			$rec['enrol_household_id'] = 0;
		$rec['key']=$rec['name'];
		return $rec;
	}
	function __normalize_odk_individual($rec,$params)
	{	
		
		$rec['relation'] = $this->__get_relation($rec);
		
		$dob = explode(',',$rec['dob']); // changes made due to upgraded version of ODK aggregate - April 10, 2012
		
		$yyyy = $dob[1];
		$date = explode(' ',$dob[0]);
	
		$dd = $date[0];
		$mm = $date[1];
		if(array_key_exists($mm, $this->month_map))
			$mm = $this->month_map[$mm];
		$rec['dob'] = $yyyy.'-'.$mm.'-'.$dd;
			
	
		
		$key = $rec['PARENT_KEY'];  // changes made due to upgraded version of ODK aggregate - Feb 7,2012
		if($hh = $this->enrol_household->find_by('key',$key))
				$rec['enrol_household_id']=$hh->id;
		$rec['key']=$rec['KEY'];
		
		/*
		$strArr = explode('%22',$key); (this will work for the enrolments done on Sughavazhvu.appspot.com for the Enrolments upto OKM)
		if(count($strArr)==3)
			$rec['key']=$strArr[1];
		$key = $rec['PARENT_KEY'];
		$strArr = explode('%22',$key);
		if(count($strArr)==3)
		{
			if($hh = $this->enrol_household->find_by('key',$strArr[1]))
				$rec['enrol_household_id']=$hh->id;
		}*/
		return $rec;
	}
	function __get_relation($rec)
	{
		$relation = "";
		if($rec['gender']=='male')
			$relation=$rec['relation_male'];
		else
			$relation=$rec['relation_female'];
		if(array_key_exists($relation, $this->relation_map))
			$relation = $this->relation_map[$relation];
		return $relation;
	}
	function __get_street($rec, $street_fields)
	{
		$streetname=null;
		$street_fields[]="street_o";
		foreach($street_fields as $s)
		{
			if(array_key_exists($s, $rec))
				$streetname.=$rec[$s];  //Append to existing string
		}
		
		$streetname = trim(str_replace("_"," ", $streetname));
		if(array_key_exists("street_o",$rec))
		{
			$streetname = trim(str_replace("other","",$streetname));	
		}		
		$streetname=mb_convert_case($streetname ,MB_CASE_TITLE);
		return $streetname;
	}
	
	function __get_commcare_street($rec, $street_fields)
	{
		$streetname=null;
		foreach($street_fields as $s)
		{
			if(array_key_exists($s, $rec))
				$streetname.=$rec[$s];  //Append to existing string
		}
		$streetname = str_replace("---","", $streetname);
		$streetname = trim(str_replace("_"," ", $streetname));
		$streetname=mb_convert_case($streetname ,MB_CASE_TITLE);
		return $streetname;
	}



	function __get_village($rec)
	{
		$village = trim(str_replace("_"," ", $rec['village']));
		$village=mb_convert_case($village ,MB_CASE_TITLE);
		return $village;
	}

	function str_getcsv($input, $delimiter=',', $enclosure='"', $escape=null, $eol=null) {
		$temp=fopen("php://memory", "rw");
		fwrite($temp, $input);
		fseek($temp, 0);
		$r = array();
		while (($data = fgetcsv($temp, 8192, $delimiter, $enclosure)) !== false) {
			$r[] = $data;
		}
		fclose($temp);
		return $r;
	} 


	function agent_wise($project_id)
	{
		$this->__bar_chart_helper("enrol_household","get_agent_wise_counts", 0, 'Agent-wise Breakup', 'Agent-wise Counts',$project_id);
	}
	
	function agent_wise_rra($project_id)
	{
		$this->__bar_chart_helper("enrol_rra","get_agent_wise_counts", 0, 'Agent-wise Breakup', 'Agent-wise Counts',$project_id);
	}
	
	function agent_wise_persons($project_id)
	{ 
		$this->__bar_chart_helper("enrol_person","get_agent_wise_counts",0,'Agent-wise Breakup', 'Agent-wise Counts',$project_id);
	}
	function village_wise_persons($project_id)
	{ 
		$this->__bar_chart_helper("enrol_person","get_village_wise_counts",0,'Village-wise Breakup', 'Village-wise Counts',$project_id);
	}
	function time_of_day($project_id,$agent=0)
	{
		$this->__bar_chart_helper("enrol_household","get_time_of_day_counts", $agent, 'Time-wise Breakup', 'Time-of-day Counts', $project_id);
	}
	function time_taken_for_completion($project_id,$agent=0)
	{
		$this->__bar_chart_helper("enrol_household","get_time_taken_for_completion_counts", $agent, 'Time-wise Breakup', 'Time taken for Completion Counts', $project_id);
	}
	function time_of_day_rra($project_id,$agent=0)
	{
		$this->__bar_chart_helper("enrol_rra","get_time_of_day_counts", $agent, 'Time-wise Breakup', 'Time-of-day Counts', $project_id);
	}

	function __bar_chart_helper($modelname, $function, $agent, $page_title, $chart_title,$project_id)
	{
		$this->load->model('enrol/'.$modelname.'_model',$modelname);
		$count_arr = $this->{$modelname}->{"$function"}($project_id,$agent);
		if($agent!=0)	
		{
			$chart_title=$chart_title." (for agent ".$agent.")";
		}
		$chart_data=array(
		    'chart_height'  => 300,
                    'chart_width'   => '37%',
                    'page_title'    => ucwords($page_title),
		     'payload_bar'=> $this->get_data_bar(array($count_arr), $chart_title),
		   'raw_data'=>$count_arr);
		$this->load->view('enrol/chart_agent_wise', $chart_data);
	}
	function date_wise($project_id,$agent=0, $data_type='household')
	{
		$modelname=($data_type=='rra')?'enrol_rra':"enrol_household";
		$this->__bar_chart_helper($modelname,"get_agent_by_date_counts", $agent, 'Date-wise Breakup', 'Date-wise Counts', $project_id);
		
	}
	
	public function get_data_bar($vals, $title) //vals is a two dimensional array
	{

		$this->load->helper('ofc2');
		$title = new title( $title );
		$chart = new open_flash_chart();
		$max_val=0;
		$ctr=0;
		$x_labels=array();
		foreach($vals as $oneset)
		{
			$bar = new bar();
			$bar_val=array();
			foreach($oneset as $key=>$value)
			{
				$max_val=($max_val>$value)?$max_val:$value;
				$objBar =new bar_value($value);
				$objBar->set_tooltip($key." (".$value.")");
				$objBar->set_colour($this->bar_colours[$ctr%3]);
				$bar_val[]=$objBar;
				if($ctr==0)
					$x_labels[]=$key;
			}
			$bar->set_values( $bar_val );
			$chart->add_element( $bar );
			$ctr++;
		}
		$x = new x_axis();
		$xls = new x_axis_labels();
		$xls->set_size(14);
		$xls->set_labels($x_labels);
		$xls->set_vertical();
		$x->set_labels($xls);
		
		$y = new y_axis();
		// grid steps:
		$y->set_range( 0, $max_val*(1.1), (int)($max_val/10));
		
		$chart->set_title( $title );
		
		$chart->set_y_axis( $y );
		$chart->set_x_axis( $x );
		return $chart->toPrettyString();
	}

	function upload_data($project_id)
	{
		$this->load->model('enrol/enrol_household_model', 'enrol_household');
		$arr = $this->enrol_household->find_all_by('enrol_project_id',$project_id);
		echo "cardnum,agent,latitude,longitude,date,village,marker<br/>";
		foreach($arr as $row)
		{
			
			echo $row->cardnum.",".$row->agent.",".$row->latitude.",".$row->longitude.",".date("d-M-Y",$row->date).','.$row->village."<br/>";
		}
		
	}

	function percent_complete($project_id)
	{
		$this->load->model('enrol/enrol_household_model', 'enrol_household');
		$this->load->model('enrol/enrol_project_model', 'enrol_project');
		
		$arr = $this->enrol_household->get_count_by_village($project_id);
		$arr_projected_hh = $this->enrol_project->get_projected_hh($project_id);
		$projected_ctr=array();
		foreach($arr as $key=>$val)
		{
			if(array_key_exists($key, $arr_projected_hh))
				$projected_ctr[$key]=$arr_projected_hh[$key];
			else
				$projected_ctr[$key]=0;
		}
		foreach($arr_projected_hh as $village=>$count)
		{
			if(!array_key_exists($village, $arr))
			{
				$projected_ctr[$village]=$arr_projected_hh[$village];
				$arr[$village]=0;
			}
		}
		$chart_data=array(
		    'chart_height'  => 500,
                    'chart_width'   => '72%',
                    'page_title'    => ucwords("Projected household data"),
		     'payload_bar'=> $this->get_data_bar(array($projected_ctr,$arr), "Burn-down chart"));
		$this->load->view('enrol/chart_agent_wise', $chart_data);
	}
	function __daysDifference($endDate, $beginDate)
	{
		//explode the date by "-" and storing to array
		$date_parts1=explode("-", $beginDate);
		$date_parts2=explode("-", $endDate);
		//gregoriantojd() Converts a Gregorian date to Julian Day Count
		$start_date=gregoriantojd((int)$date_parts1[1], (int)$date_parts1[2], (int)$date_parts1[0]);
		$end_date=gregoriantojd((int)$date_parts2[1], (int)$date_parts2[2], (int)$date_parts2[0]);
		return $end_date - $start_date;
	}
	function worm($project_id)
	{
		
		$this->load->model('enrol/enrol_household_model','enrol_household');
		$this->load->model('enrol/enrol_project_model','enrol_project');
		$props = $this->enrol_project->get_properties($project_id);
		
		$test_arr=array($props['start_date']=>0);
		if($props['actual_end_date']=='0000-00-00' || $props['actual_end_date']>date('Y-m-d'))
			$props['actual_end_date'] = date('Y-m-d');
		$wormdata = $this->enrol_household->get_worm($project_id, $props['start_date'], $props['actual_end_date']);
		$wormdata=array_merge($test_arr, $wormdata);
		$refdata=array();
		$duration = $this->__daysDifference($props['target_end_date'],$props['start_date']);
		for($c=0;$c<=$duration;$c++)
			$refdata[]=null;
		$refdata[0]=0;
		$refdata[$duration]=intval($props['target_enrolments']);
		$chart_data=array(
		    'chart_height'  => 400,
                    'chart_width'   => '72%',
                    'page_title'    => ucwords("Projected household data"),
		     'payload_bar'=> $this->get_data_line($wormdata, "Progress against plan", $refdata));
		$this->load->view('enrol/chart_agent_wise', $chart_data);
		
		
	}
	
	public function get_data_line($vals, $title, $refdata) //vals is a two dimensional array
	{

		$this->load->plugin('ofc2');
		$title = new title( $title );
		$chart = new open_flash_chart();
		$max_val=0;
		$ctr=0;
		$x_labels=array();
		
		$d = new hollow_dot();
		$d->size(5)->halo_size(0)->colour('#3D5C56');
		$line = new line();
		$data=array();
		$x_labels = array();
		foreach($vals as $key=>$value)
		{
			$max_val=($max_val>$value)?$max_val:$value;
			$data[]=(int)$value;
			$x_labels[]=$key;
		}
		$line = new line();
		$line->set_default_dot_style($d);
		$line->set_width( 3 );
		$line->set_colour( '#FF0000' );
		$line->set_values( $data );
		$chart->add_element( $line);

		$refline = new line();
		$refline->set_default_dot_style($d);
		$refline->set_width( 1 );
		$refline->set_colour( '#3D5C56' );
		$refline->set_values( $refdata );
		$chart->add_element( $refline);
	
		$x = new x_axis();
		$xls = new x_axis_labels();
		$xls->set_labels($x_labels);
		$xls->set_vertical();
		$x->set_labels($xls);
		$y = new y_axis();
		// grid steps:
		$y->set_range( 0, 3200, 100);
		
		$chart->set_title( $title );
		
		$chart->set_y_axis( $y );
		$chart->set_x_axis( $x );
		return $chart->toPrettyString();
	}

	function agent_date_table($project_id,$print=0)
	{
		$this->__agent_date_table_helper("enrol_household", $project_id,$print);
	}
	function agent_date_table_rra($project_id,$print=0)
	{
		$this->__agent_date_table_helper("enrol_rra", $project_id,$print);
	}
        function __agent_date_table_helper($modelname, $project_id,$print=0)
	{
		$this->load->model('enrol/'.$modelname.'_model',$modelname);
		$this->load->model('enrol/enrol_project_model','project');
		$agentslist = $this->project->get_agents_list($project_id);
		$ret = $this->{$modelname}->get_agent_date_table($project_id, $agentslist);
		$data=array('cols'=>$agentslist, 'rows'=>$ret);
		if($print==0)
		{
			$data['title']="Agent Counts";
			$data['project_id']=$project_id;
			$this->load->view('enrol/agent_count_table',$data);
		}
		else
		{
			$this->load->library('plsp/writer/pdfwriter');
			$doc = new tcPdfWriter();
			$doc->InitDoc();
			$doc->PrepareDoc("", "right", "left", "Bottom",'/../../../../../../assets/images/common_images/sgv_logo.png'); 
			$headers=array_merge(array('Agent'),$agentslist);
			$data=array();

			foreach($ret as $date=>$vals)
			{
				$line=array($date);
				foreach($agentslist as $ag)
				{
					if(array_key_exists($ag." ",$vals))
						$line[]=$vals[$ag." "];
					else
						$line[]=0;
				}
				$data[]=$line;
			}
			$doc->WriteTable($data, $headers, "Agent-wise counts","Agent counts- ".date("%d-%m-%Y"),array('border'=>1));
			$doc->Display();
		}
	}
	function select_for_audit($project_id)
	{	
		
		if($_POST)
		{	
			redirect('enrol/enrol/create_audit/'.$project_id.'/'.$this->input->post('agent').'/'.$this->input->post('formdate'));
		}
	}
	function create_audit($project_id,$agent,$date)
	{
		$this->load->model('enrol/enrol_household_model', 'enrol_household');
		if(!$_POST)	
		{
			$forms = $this->enrol_household->get_data_for_date_agent($project_id,$date, $agent);			
			$this->load->view('enrol/audit_create', array('forms'=>$forms, 'agent'=>$agent, 'date'=>$date));
		}
		else
		{
			$this->load->model('enrol/enrol_audit_model', 'enrol_audit');
			$pending=array();
			foreach($_POST as $key=>$val)
				$pending[]=$key;
			if(count($pending) >0)
			{
				$this->enrol_audit->mark_status($pending,'pending',$project_id);
			}
			$this->session->set_userdata('msg',"Audit status updated");
			redirect('enrol/enrol');
		}
	}
	function pending_audits($project_id, $print=0)
	{
		$this->load->model('enrol/enrol_audit_model','enrol_audit');
		if(!$_POST)
		{
			$this->load->model('enrol/enrol_household_model','enrol_household');
			$ids = $this->enrol_audit->get_hh_for_state('pending',$project_id);
			$forms = $this->enrol_household->get_summary_for_ids($ids);
			if($print==0)
				$this->load->view('enrol/audit_create', array('forms'=>$forms, 'pending'=>true,'project_id'=>$project_id));
			else
			{
				$this->load->library('plsp/writer/pdfwriter');
				$doc = new tcPdfWriter();
				$doc->InitDoc();
				
				$doc->PrepareDoc("", "right", "left", "Bottom", '/../../../../../../assets/images/common_images/sgv_logo.png'); 
				$headers = array("Sl.no","Card","Respondent","Door","Street","Village","Phone","Members");
				$data=array();
				$ctr = 1;
				foreach($forms as $row)
				{
					$line=array();
					$line[]=$ctr;
					$line[]=$row['cardnum'];
					$line[]=$row['respondent'];
					$line[]=$row['doornum'];
					$line[]=$row['street'];
					$line[]=$row['village'];
					$line[]=$row['phone'];
					$line[]=$row['members_num'];
					$ctr++;
					$data[]=$line;
				}
				$doc->WriteTable($data, $headers, "Audit table","Audit Table - ".date("%d-%m-%Y"),array('border'=>1,'width'=>array(5,10,19,8,18,15,10,10)));
				$doc->Display();
			}
		}
		else
		{
			//Values have been submitted
			$statuslists=array();
			foreach($_POST as $key=>$val)
			{
				$statuslists[$val][]=$key;
			}
			foreach($statuslists as $status=>$listhh)
			{
				$this->enrol_audit->mark_status($listhh, $status);
			}
			$this->session->set_userdata('msg',"Audit status updated");
			redirect('enrol/enrol');
		}
	}

	function edit_household($id=0)
	{
		$this->load->model('enrol/enrol_household_model','household');
		if(!$_POST)
		{
			$data = $this->household->get_record($id);
			$project_id = $this->household->find_by('id',$id);
			$this->load->view('enrol/generic_record',array('data'=>$data,'title'=>'Correction of household','id' =>$id,'type'=>'household','audit'=>'button','project_id'=>$project_id->enrol_project_id));
			return;
		}
		//This means that it is a post
		if(!array_key_exists('lock',$_POST))
			$_POST['lock']=0;
		$this->household->set_record($id, $_POST);
		redirect('enrol/enrol');
	}
	function edit_individuals($hhid=0)
	{
		$this->load->model('enrol/enrol_person_model','person');
		$data = $this->person->get_records($hhid);
		$this->load->view('enrol/person_record',array('data'=>$data,'title'=>'Individuals'));
		return;
	}
	function edit_person($person_id)
	{
		$this->load->model('enrol/enrol_person_model','person');
		if(!$_POST)
		{
			$data = $this->person->get_person_record($person_id);
			
			$this->load->view('enrol/generic_record',array('data'=>$data,'title'=>'Correction of person','id'=>$person_id,'type' => 'person'));
			return;
		}
		//This means that it is a post
		
		$this->person->set_record($person_id, $_POST);
		redirect('enrol/enrol');
	}
	function edit_rra($rra_id)
	{
		$this->load->model('enrol/enrol_rra_model','rra');
		if(!$_POST)
		{
			$data = $this->rra->get_record($rra_id);
			
			$this->load->view('enrol/generic_record',array('data'=>$data,'title'=>'Correction of RRA'));
			return;
		}
		//This means that it is a post
		
		$this->rra->set_record($rra_id, $_POST);
		redirect('enrol/enrol');
	}
	function edit_by_card($project_id)
	{	
		if($_POST)
		{
			if(array_key_exists('cardnum',$_POST))
			{
				$c=$_POST['cardnum'];
				$this->load->model('enrol/enrol_household_model','household');
				if($rec = $this->household->find_by(array('cardnum','enrol_project_id'),array($c,$project_id)))
				{
					$id = $rec->id;
					redirect('enrol/enrol/edit_household/'.$id);
				}
				else
				{
					$home_message = "Card number does not exist";
					$this->session->set_userdata('msg', $home_message);
					redirect('enrol/enrol');
				}
			}
		}
	}
	function delete_household($id)
	{
		$this->load->model('enrol/enrol_household_model','household');
		$this->household->delete_record($id);
		redirect('enrol/enrol');
	}
	
	function export_household($project_id)
	{
		$this->load->model('enrol/enrol_household_model','enrol_household');
		$ret = $this->enrol_household->export($project_id);
		$this->__generate_dump($ret, 'household');
	}
	function export_individual($project_id)
	{
		$this->load->model('enrol/enrol_person_model','enrol_person');
		$ret = $this->enrol_person->export($project_id);
		$this->__generate_dump($ret, 'individual');
	}
	function check_this()
	{
		$this->load->model('enrol/enrol_person_model','enrol_person');
		$ret = $this->enrol_person->export(4);
		foreach($ret as $k=>$v)
			echo "$k=>$v<br/>";
	}
	function __generate_dump($ret, $type)
	{	
		
		$finalstring = "";
		foreach($ret[0] as $col_header)
			$finalstring.= $col_header.",";
		$finalstring.="\n";
		foreach($ret[1] as $row)
		{
			foreach($row as $k=>$v)
				
				$finalstring.=str_replace(',','|',$v).",";
			$finalstring.="\n";
		}
		$suffix = "/uploads/enrolment/enrolment_".$type."_".time(true).".csv.bz2";
		
		
		$filename = $this->config->item('base_path').$suffix;
		$finalstring = bzcompress($finalstring);
		// $file = $this->config->item('base_path').household;
		$filename = trim($filename);
		//$filename = "/var/www/household.csv.bz2";
		$fp = fopen($filename,"wb");
		
		$msg = "<a href=\"".base_url().$suffix."\">Click here for exported ".$type." data</a>";
		
		if(!fwrite($fp,$finalstring))
		{
			$msg = "CSV File could not be written"; 
			return;
		}
		$this->session->set_userdata('msg', $msg);
		redirect('enrol/enrol');
	}

	function print_arr($arr, $depth)
	{
		foreach($arr as $k=>$v)
		{
			for($i=0;$i<$depth;$i++)
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "$k=>$v<br/>";
			if(is_array($v))
				$this->print_arr($v, $depth+1);
		}
	}
	function project_create()
	{
		$this->load->model('enrol/enrol_project_model','project');
		if(!$_POST)
		{
			$this->load->model('opd/provider_location_model','provider_location');
			$data = $this->project->get_options();
			
			$data['locations']=$this->provider_location->get_all_clinic_ids();
			$data['title']='Create Enrollment Project';
			$data['action']='create'; //This is a flag that will tell the view which controls to enable
			$this->load->view('enrol/project_details',$data);
		}
		else
		{
			$this->print_arr($_POST,1);
			$this->project->store_record($_POST);
		}
	}
	function select_current_project()
	{
		if($_POST)
		{
			$project_id = $_POST['current_project'];
			$this->load->model('enrol/enrol_project_affiliation_model','project_affiliation');
			$this->load->model('enrol/enrol_project_model','project');
			$username = $this->session->userdata('username');
			$this->project_affiliation->set_current_project($username, $project_id);
			$proj_name = $this->project->get_project_name($project_id);
			$this->session->set_userdata('msg',"Current project set to ".$proj_name);
			redirect('enrol/enrol');
		}
	}
	
	function project_edit($id)
	{
		$this->load->model('enrol/enrol_project_model','project');
		if(!$_POST)
		{
			$this->load->model('opd/provider_location_model','provider_location');
			$data = $this->project->get_properties($id);
			$options = $this->project->get_options();
			foreach($options as $k=>$v)
				$data[$k]=$v;
			$data['locations']=$this->provider_location->get_all_clinic_ids();
			$data['title']='Edit Enrollment Project';
			$data['action']='edit'; //This is a flag that will tell the view which controls to enable
			//$this->print_arr($data,1);return;
			$this->load->view('enrol/project_details',$data);
		}
		else
		{	 
			$this->print_arr($_POST,1);
			$_POST['id']=$id;
			$this->project->store_record($_POST);
			redirect('enrol/enrol');
		}
		
	}
	function edit_project()
	{
		if($_POST)
		{
			$project_id = $_POST['project_edit'];
			redirect('enrol/enrol/project_edit/'.$project_id);
		}
	}

	function indi_count_mismatch($project_id)
	{		
		
		
		$this->load->model('enrol/enrol_household_model','enrol_household');
		
		$mismatch = $this->enrol_household->get_indi_mismatch_count($project_id);
		$this->load->view('enrol/mismatch_indi_count',array('mismatch'=>$mismatch, 'project_id'=>$project_id, 'title'=>'Mismatched Individuals'));
	}

	function rra_for_missing_indi($project_id)
	{
		$this->load->model('enrol/enrol_rra_model','enrol_rra');
		$mismatch = $this->enrol_rra->get_rra_without_indi($project_id);
		$this->load->view('enrol/rra_with_missing_indi',array('mismatch'=>$mismatch, 'project_id'=>$project_id, 'title'=>'RRA with No Individuals'));
	}
	function relation_duplicate_entries($project_id)
	{
		$this->load->model('enrol/enrol_person_model','enrol_person');
		$duplicate = $this->enrol_person->get_duplicate_relations_in_same_household($project_id);
			
		$this->load->view('enrol/relation_duplicate_entries',array('self' =>$duplicate['self'],'wife'=>$duplicate['wife'],'husband'=>$duplicate['husband'], 'project_id' =>$project_id,'title'=>'households with Duplicate entries'));
	}
	function mark_for_audit($project_id,$household_id)
	{	
		$this->load->model('enrol/enrol_audit_model','enrol_audit');
		$list[]=$household_id; //as one household on the list. 
		$this->enrol_audit->mark_status($list,'pending',$project_id);
		redirect("enrol/enrol/edit_household/$household_id");
		return;
		
	}
}
?>
