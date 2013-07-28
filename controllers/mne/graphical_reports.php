http://localhost/libs/slimphp/nit3.php<?php
class Graphical_reports extends CI_Controller 
{
	/**************************************************************************************/
	/*******THIS IS THE CONSTRUCTOR WHERE ALL THE MODELS BEING USED HAVE BEEN LOADED*******/
	/**************************************************************************************/
	
	public function __construct()
        {
            parent::__construct();
            $this->load->model('opd/provider_location_model','provider_location');
            $this->load->model('opd/visit_model','visit');
	    $this->load->model('chw/opd_diagnosis_model','opd_diagnosis');
	    $this->load->model('chw/chief_complaint_model','chief_complaint');
	    $this->load->model('demographic/person_model','person');
	    $this->load->model('demographic/household_model','household');
	    $this->load->model('mne/forms/mne_pisp_adult_model','pisp_adult');
	    $this->load->model('scm/product_model','products');
	    $this->load->model('scm/drug_generic_model','generic');
            $this->load->library('date_util'); 			//This library has been loaded so that we can change the format of the date.
            $this->load->library('mail_util'); 			//This library has been loaded to implement the mailing facility.
            $this->load->library('utils');  
            $this->load->library('mpdf');			//This is a third-party module. Which has been loaded so that we can get the .pdf of the report.	
            $this->load->helper('date');
            $this->load->helper('file');  
            $this->load->helper('url');  
            $this->load->dbutil();
            $this->load->library('opd/problem_dom_displayer');
        }    
        
        /*************LIST OF REPORTS********************/
        
        public function home()
        {
        	
        	$this->load->view('mne/graphical_reports/categories_of_reports');	//Loads the main page containing the list of all reports.
        }
        
        /*************LIST OF medical/research REPORTS********************/
        
        public function med_research_home()
        {
        	
        	$this->load->view('mne/graphical_reports/list_of_medical_research_reports');	//Loads the main page containing the list of all medical/research reports.
        }
        
        /*************LIST OF operations REPORTS********************/
        
        public function operations_home()
        {
        	
        	$this->load->view('mne/graphical_reports/list_of_operations_reports');	//Loads the main page containing the list of all operations reports.
        }
        
        
      
     	/**********************************************************************************************************************************************************/
	/*METHODS FOR REPORTS START HERE. EACH REPORT HAS 3 METHODS, AND ONE METHOD IS DEFINED IN THE END OF THE THIS FILE WHICH IS BEING USED BY ALL THE REPORTS.*/
	/**********************************************************************************************************************************************************/
	
	
	/**********************************************************************************************************************************************************/
	/*	FIRST METHOD => IT LOADS THE FIRST VIEW PAGE OF REPORT
		SECOND METHOD => THIS METHOD RETURNS THE DATA WHICH IS NEEDED TO MAKE THE REPORT.
		THIRD METHOD => THIS METHOD IS CALLED BY THE CORRESPONDING AJAX METHOD IN REPORT.JS FILE. *******/
	/**********************************************************************************************************************************************************/
	
	
	
	/**********************************************************************************************************************************************************/
	/*	FOURTH METHOD => THIS METHOD IS ALSO CALLED BY AN AJAX METHOD IN REPORT.JS FILE, THIS METHOD IS USED TO CREATE A PDF/CSV OF THE REPORT 
		AND ALSO ALLOWS TO MAIL THE CSV IF NEEDED.  */
	/**********************************************************************************************************************************************************/
        
        
        /**********************************************************************************************************************************************************/
	/*	    COMMENTS FOR ALL THE METHODS I HAVE MADE IN THE MODEL FILES THAT ARE BEING USED HERE WILL BE PRESENT IN THE MODEL FILES ITSELF */
	/**********************************************************************************************************************************************************/
        
        
        /*****************************DIAGNOSIS CHART*****************************/ 

	public function diagnosis_chart()			//This method loads the first view of the diagnosis chart page.
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	//GETS ALL THE LOCATION IDS AND NAMES OF THEIR RMHCS
		$rmhcs{'%'} = "All";		//TO ADD AN ALL OPTION TO THE LIST OF RMHCS
		ksort($rmhcs);	
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/diagnosis_chart',$this->data);
	}	
	
	public function get_data_for_diagnosis_chart($location_id,$from_date,$to_date)
	{	
		$query = $this->visit->get_diagnosis_count($location_id,$from_date,$to_date);
		return $query;  	
	}
	
	public function diagnosis_chart_call()
	{
		$rmhc = $_POST['rmhc'];			//GETS RMHC LOCATION ID FROM THE AJAX METHOD IN REPORT.JS FILE
		$from_date = Date_util::change_date_format($_POST['from_date']);	//GETS FROM_DATE FROM THE AJAX METHOD IN REPORT.JS FILE
		$to_date = Date_util::change_date_format($_POST['to_date']);		//GETS TO_DATE FROM THE AJAX METHOD IN REPORT.JS FILE
		$rmhc_name = $_POST['rmhc_name'];	//GETS RMHC NAME FROM THE AJAX METHOD IN REPORT.JS
		
		$data = $this->get_data_for_diagnosis_chart($rmhc, $from_date, $to_date);	//GETS DATA NEEDED FOR REPORT FROM THE ABOVE METHOD.
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;		<!--ALL THE INFORMATION NEEDED IS SENT BACK TO THE METHOD IN REPORT.JS FILE-->
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php		
	}
	 /*****************************END OF DIAGNOSIS CHART*****************************/ 
	 
	 
	 /**********************************************************************************************************************************************************/
	 /*	ALL THE METHODS FOR EACH REPORT ARE BEING USED IN A SAME MANNER AS ABOVE, HOWEVER I HAVE COMMENTED WHERE EXTRA UNDERSTANDING IS NEEDED. */
	 /**********************************************************************************************************************************************************/
	 
	 
	 /*****************************CHIEF COMPLAINTS CHART*****************************/ 
	 
	public function chief_complaints_chart()	
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";
		ksort($rmhcs);	
			
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/chief_complaint_chart',$this->data);
	
	}	
	public function get_data_for_chief_complaints_chart($location_id,$from_date,$to_date)
	{
		$query = $this->visit->get_chief_complaints_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	public function chief_complaint_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_chief_complaints_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php
	}
	
	/*****************************END OF CHIEF COMPLAINTS CHART*****************************/ 
	 
	
	/*****************************GENDER DISTRIBUTION CHART*****************************/	 
	 
	public function gender_distribution_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);		
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/gender_distribution_chart',$this->data);
	
	}	
	public function get_data_for_gender_distribution_chart($location_id,$from_date,$to_date)
	{
		$person_ids = $this->visit->get_person_ids_by_location_id($location_id,$from_date,$to_date);
		$query = $this->person->get_gender_distribution_count($person_ids);
		return $query;  
	}
	
	
	
	public function gender_distribution_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_gender_distribution_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}
	 
	/*****************************END OF GENDER DISTRIBUTION CHART*****************************/	 
	 
	 
	 
	 /********************EYE RELATED DIAGNOSIS CHART**************/
	 
	public function eye_diagnosis_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);		
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/eye_diagnosis_chart',$this->data);
	
	}	
	public function get_data_for_eye_diagnosis_chart($location_id,$from_date,$to_date)
	{
		$list_eye_diagnosis = $this->opd_diagnosis->get_list_eye_diagnosis();
		$query = $this->visit->get_eye_diagnosis_count($location_id,$from_date,$to_date,$list_eye_diagnosis);
		return $query;  
	}
	public function eye_diagnosis_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_eye_diagnosis_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);		
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;
		data = <?php echo $data;?>;
<?php	
	}
	 
	
	/********************END OF EYE RELATED DIAGNOSIS CHART**************/
	
	
	
	/*********************AGE DISTRIBUTION CHART****************/
	
	public function age_distribution_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);	
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/age_distribution_chart',$this->data);
	
	}	
	public function get_data_for_age_distribution_chart($location_id,$from_date,$to_date)
	{	
		$person_ids = $this->visit->get_person_ids_by_location_id($location_id,$from_date,$to_date);
		$query = $this->person->get_age_distribution_count($person_ids);
		return $query;  
	}
	
	public function age_distribution_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_age_distribution_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}
	
	/*********************END OF AGE DISTRIBUTION CHART****************/
	
	
	/*********************AVERAGE TIME FOR EACH VISIT CHART****************/
	
	public function avg_time_visit_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);		
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/avg_time_visit_chart',$this->data);
	
	}	
	public function get_data_for_avg_time_visit_chart($location_id,$from_date,$to_date)
	{	
		$query = $this->visit->get_avg_time_visit_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	public function avg_time_visit_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_avg_time_visit_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}
	 
	/*********************END OF AVERAGE TIME FOR EACH VISIT CHART****************/
	
	
	
	/*********************AVERAGE TIME FOR EACH PISP CHART****************/
	
	public function avg_time_pisp_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);	
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/avg_time_pisp_chart',$this->data);
	
	}	
	public function get_data_for_avg_time_pisp_chart($location_id,$from_date,$to_date)
	{	
		$query = $this->pisp_adult->get_avg_time_pisp_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	public function avg_time_pisp_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_avg_time_pisp_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}
	
	/*********************END OF AVERAGE TIME FOR EACH PISP CHART****************/

	
	
	/*********************AVERAGE NUMBER OF PATIENT VISIT CHART****************/

	public function avg_patient_visit_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);		
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/avg_patient_visit_chart',$this->data);
	
	}	
	public function get_data_for_avg_patient_visit_chart($location_id,$from_date,$to_date)
	{	
		$query = $this->visit->get_avg_patient_visit_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	
	public function avg_patient_visit_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_avg_patient_visit_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}

	/*********************END OF AVERAGE NUMBER OF PATIENT VISIT CHART****************/

	
	
	/*********************AGE DISTRIBUTION CHART BY DIAGNOSIS/CHIEF COMPLAINTS****************/

	public function age_distribution_by_diagnosis_cc_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);		
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
	  	$opd_diagnosis_list=$this->opd_diagnosis->order_by('value')->find_all(); //THIS METHOD GETS ALL THE DIAGNOSIS TO POPULATE THE DIAGNOSIS LIST IN VIEW FILE
	  	foreach($opd_diagnosis_list as $d)
	  	{
	  		$diagnosis_list[$d->value] = $d->value;
	  	}
		$this->data['opd_diagnosis_list'] = $diagnosis_list;						
		
		
		$chief_complaint_list=$this->chief_complaint->order_by('value')->find_all(); //THIS METHOD GETS ALL THE CHIEF COMPLAINTS TO POPULATE THE CHIEF 														COMPLAINTS LIST IN VIEW FILE
		foreach($chief_complaint_list as $c)
		{
			$chief_complaints[$c->value]=$c->value;
		}
		$this->data['chief_complaint_list'] = $chief_complaints;
		
		
		$this->load->view('mne/graphical_reports/age_distribution_by_diagnosis_cc_chart',$this->data);
	
	}	
	public function get_data_for_age_distribution_by_diagnosis_cc_chart($location_id,$from_date,$to_date, $rep_feature, $rep_option)
	{	
		if($rep_feature == 'diagnosis')
		{	
			$person_ids = $this->visit->get_person_ids_by_location_id_and_diagnosis($location_id,$from_date,$to_date, $rep_option);
			if($person_ids!=NULL)
			{
				$query = $this->person->get_age_distribution_count($person_ids);
				
			}
			else
			{
				return array("0-4"=>0, "5-9"=>0, "10-18"=>0, "19-29"=>0, "30-49"=>0, "50-69"=>0, ">=70"=>0); //EMPTY BUCKET IS BEING SENT BACK
			}
			
			return $query;  
		}
		else
		{
			
			$person_ids = $this->visit->get_person_ids_by_location_id_and_chief_complaint($location_id,$from_date,$to_date, $rep_option);
			if($person_ids!=NULL)
			{
				
				$query = $this->person->get_age_distribution_count($person_ids);
				
			}
			else
			{
				return array("0-4"=>0, "5-9"=>0, "10-18"=>0, "19-29"=>0, "30-49"=>0, "50-69"=>0, ">=70"=>0); 
			}
			
			return $query;
		}
		
	}
	
	public function age_distribution_by_diagnosis_cc_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rep_feature = $_POST['rep_feature'];	 //GETS WHETHER DIAGNOSIS OR CHIEF COMPLAINTS HAS BEEN CHOSEN IN THE REPORT PAGE, FROM THE AJAX METHOD IN REPORT.JS
		$rep_option = $_POST['rep_option'];	//GETS WHICH DIAGNOSIS OR CHIEF COMPLAINT HAS BEEN CHOSEN IN THE REPORT PAGE, FROM THE AJAX METHOD IN REPORT.JS
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_age_distribution_by_diagnosis_cc_chart($rmhc, $from_date, $to_date, $rep_feature, $rep_option);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
		$rep_feature = json_encode($rep_feature);
		$rep_option = json_encode($rep_option);
?>		
		rep_feature = <?php echo $rep_feature;?>;	
		rep_option = <?php echo $rep_option;?>;	
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;	
			
		data = <?php echo $data;?>;
	
<?php	
	}
	
	/*********************END OF AGE DISTRIBUTION CHART BY DIAGNOSIS/CHIEF COMPLAINTS****************/

	/*********************AVERAGE BILL AMOUNTS PER PATIENT CHART****************/

	public function avg_bill_amounts_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";		
		ksort($rmhcs);	
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
	  	$opd_diagnosis_list=$this->opd_diagnosis->order_by('value')->find_all(); 
	  	foreach($opd_diagnosis_list as $d)
	  	{
	  		$diagnosis_list[$d->value] = $d->value;
	  	}
		$this->data['opd_diagnosis_list'] = $diagnosis_list;
		
		
		$this->load->view('mne/graphical_reports/avg_bill_amounts_chart',$this->data);
	
	}	
	public function get_data_for_avg_bill_amounts_chart($location_id,$from_date,$to_date, $rep_feature, $rep_option)
	{	
			
			if($rep_feature == 'diagnosis')
			{
				$query = $this->visit->get_avg_bill_amounts_count_by_diagnosis($location_id,$from_date,$to_date, $rep_option);
				return $query;  	
			}
			else
			{		
				$query = $this->visit->get_avg_bill_amounts_count($location_id,$from_date,$to_date);
				return $query;  
			}
			
		
	} 

	public function avg_bill_amounts_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rep_feature = $_POST['rep_feature'];
		$rep_option = $_POST['rep_option'];
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_avg_bill_amounts_chart($rmhc, $from_date, $to_date, $rep_feature, $rep_option);
		
		$data = json_encode($data);		
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
		$rep_feature = json_encode($rep_feature);
		$rep_option = json_encode($rep_option);
?>		
		rep_feature = <?php echo $rep_feature;?>;
		rep_option = <?php echo $rep_option;?>;
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}

	/*********************END OF AVERAGE BILL AMOUNTS PER PATIENT CHART****************/

	
	
	/*********************Cost of medication/services/lab tests dispensed/conducted CHART****************/

	public function cost_med_serv_tests_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);		
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/cost_med_serv_tests_chart',$this->data);
	
	}	
	public function get_data_for_cost_med_serv_tests_chart($location_id,$from_date,$to_date)
	{	
		$query = $this->visit->get_cost_med_serv_tests_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	
	public function cost_med_serv_tests_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_cost_med_serv_tests_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}

	/*********************END OF Cost of medication/services/lab tests dispensed/conducted CHART****************/

	
	
	/*********************Average Cost of medication/services/lab tests dispensed/conducted CHART****************/

	public function avg_cost_med_serv_tests_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);	
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/avg_cost_med_serv_tests_chart',$this->data);
	
	}	
	public function get_data_for_avg_cost_med_serv_tests_chart($location_id,$from_date,$to_date)
	{	
		$query = $this->visit->get_avg_cost_med_serv_tests_count($location_id,$from_date,$to_date);
		return $query;  
	}

	public function avg_cost_med_serv_tests_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_avg_cost_med_serv_tests_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}
	 
	
	/*********************END OF average Cost of medication/services/lab tests dispensed/conducted CHART****************/

	
	/*********************Diagnostic tests split by billed/free CHART****************/

	public function diagnostic_tests_billed_free_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);	
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/diagnostic_tests_billed_free_chart',$this->data);
	
	}	
	public function get_data_for_diagnostic_tests_billed_free_chart($location_id,$from_date,$to_date)
	{
		$query = $this->visit->get_diagnostic_tests_billed_free_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	
	public function diagnostic_tests_billed_free_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_diagnostic_tests_billed_free_chart($rmhc, $from_date, $to_date);
		$data = json_encode($data);		
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php
	
	}
	 
	

	/*********************END OF Diagnostic tests split by billed/free CHART****************/


	/*********************Number of new cards created in each clinic CHART****************/

	public function number_new_cards_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$this->load->view('mne/graphical_reports/number_new_cards_chart',$this->data);
	
	}	
	public function get_data_for_number_new_cards_chart($from_date,$to_date)
	{
		$query = $this->household->get_number_new_cards_count($from_date,$to_date);
		return $query;  
	}
	
	public function number_new_cards_chart_call()
	{
		
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		
		$data = $this->get_data_for_number_new_cards_chart($from_date, $to_date);
		
		$data = json_encode($data);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}
	/*********************END OF Number of new cards created in each clinic CHART****************/

	
	/*****************************DIAGNOSIS SPLIT BY SYSTEM CHART*****************************/ 
	  
	public function diagnosis_system_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);		
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/diagnosis_system_chart',$this->data);
	
	}	
	
	public function get_data_for_diagnosis_system_chart($location_id,$from_date,$to_date)
	{	
		
		
		$list_system_name = $this->opd_diagnosis->get_list_system_name();       //GET ALL THE SYSTEM NAMES
		$query = $this->visit->get_diagnosis_system_count($location_id,$from_date,$to_date,$list_system_name);
		return $query;  
	}
	
	public function diagnosis_system_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_diagnosis_system_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php		
	}
	 
	
  
	/*****************************END OF DIAGNOSIS SPLIT BY SYSTEM CHART*****************************/ 

	
	
	
	/*********************GENDER DISTRIBUTION CHART BY DIAGNOSIS/CHIEF COMPLAINTS****************/

	public function gender_distribution_by_diagnosis_cc_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);		
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
	  	$opd_diagnosis_list=$this->opd_diagnosis->order_by('value')->find_all(); 
	  	foreach($opd_diagnosis_list as $d)
	  	{
	  		$diagnosis_list[$d->value] = $d->value;
	  	}
		$this->data['opd_diagnosis_list'] = $diagnosis_list;
		
		
		$chief_complaint_list=$this->chief_complaint->order_by('value')->find_all(); 
		foreach($chief_complaint_list as $c)
		{
			$chief_complaints[$c->value]=$c->value;
		}
		$this->data['chief_complaint_list'] = $chief_complaints;
		
		
		$this->load->view('mne/graphical_reports/gender_distribution_by_diagnosis_cc_chart',$this->data);
	
	}	
	public function get_data_for_gender_distribution_by_diagnosis_cc_chart($location_id,$from_date,$to_date, $rep_feature, $rep_option)
	{	
		if($rep_feature == 'diagnosis')
		{	
			
			$person_ids = $this->visit->get_person_ids_by_location_id_and_diagnosis($location_id,$from_date,$to_date, $rep_option);
			if($person_ids!=NULL)
			{
				$query = $this->person->get_gender_distribution_count($person_ids);
				
			}
			else
			{
				$query = array("M"=>0, "F"=>0); 
				return $query; 
			}
			return $query;  
		}
		else
		{
			
			$person_ids = $this->visit->get_person_ids_by_location_id_and_chief_complaint($location_id,$from_date,$to_date, $rep_option);
			if($person_ids!=NULL)
			{
				
				$query = $this->person->get_gender_distribution_count($person_ids);
				
			}
			else
			{
				$query = array("M"=>0, "F"=>0); 
				return $query; 
			}
			
			return $query;
		}
		
	}

	public function gender_distribution_by_diagnosis_cc_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rep_feature = $_POST['rep_feature'];
		$rep_option = $_POST['rep_option'];
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_gender_distribution_by_diagnosis_cc_chart($rmhc, $from_date, $to_date, $rep_feature, $rep_option);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
		$rep_feature = json_encode($rep_feature);
		$rep_option = json_encode($rep_option);
?>		
		rep_feature = <?php echo $rep_feature;?>;	
		rep_option = <?php echo $rep_option;?>;		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}
	 
	
	/*********************END OF GENDER DISTRIBUTION CHART BY DIAGNOSIS/CHIEF COMPLAINTS****************/

	/*********************SPLIT OF OPD PRODUCTS CHART****************/

	public function opd_products_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
	  	$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";
		ksort($rmhcs);					
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/opd_products_chart',$this->data);
	}	
	
	public function get_data_for_opd_products_chart($location_id,$from_date,$to_date)
	{	
		$query = $this->visit->get_opd_products_count($location_id,$from_date,$to_date);
		return $query;  	
	
	}
	
	public function opd_products_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_opd_products_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php		
	}
	 
	
	/*********************END OF SPLIT OF OPD PRODUCTS CHART****************/

	/*********************REPEATED VISITS CHART****************/

	public function repeated_visits_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);	
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/repeated_visits_chart',$this->data);
	
	}	
	public function get_data_for_repeated_visits_chart($location_id,$from_date,$to_date)
	{	
		
		$query = $this->visit->get_repeated_visits_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	public function repeated_visits_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_repeated_visits_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}

	/*********************END OF REPEATED VISITS CHART****************/

	/*********************NUMBER OF PATIENTS SEEN BY EACH DOCTOR CHART****************/

	public function number_patients_by_doctor_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);	
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/number_patients_by_doctor_chart',$this->data);
	
	}	
	public function get_data_for_number_patients_by_doctor_chart($location_id,$from_date,$to_date)
	{	
		
		$query = $this->visit->get_number_patients_by_doctor_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	public function number_patients_by_doctor_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_number_patients_by_doctor_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);		
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php	
	}

	/*********************END OF NUMBER OF PATIENTS SEEN BY EACH DOCTOR CHART****************/

	/*********************INVENTORY CONSUMED IN CLINICS CHART****************/

	public function inventory_consumed_chart()
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();
		$rmhcs{'%'} = "All";	
		ksort($rmhcs);		
	  	$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
	  	
	  	$generic_names_all_list = $this->generic->find_all(); 	//GETS ALL THE GENERIC NAMES 
	  	foreach($generic_names_all_list as $g)
	  	{
	  		$generic_names_all[$g->id] = $g->generic_name." ".$g->strength." ".$g->strength_unit;
	  		
	  	}
	  	$generic_names_all{'all'} = "All";
		$this->data['generic_names_all_list'] = $generic_names_all;
			
	  	
	  	$generic_names_medication_list = $this->generic->like('product_type','MEDICATION')->find_all(); //GETS GENERIC NAMES OF TYPE MEDICATION
	  	foreach($generic_names_medication_list as $g)
	  	{
	  		$generic_names_medication[$g->id] = $g->generic_name." ".$g->strength." ".$g->strength_unit;
	  	}
	  	$generic_names_medication{'all'} = "All";
		$this->data['generic_names_medication_list'] = $generic_names_medication;
		
		$generic_names_consumables_list = $this->generic->like('product_type','CONSUMABLES')->find_all(); //GETS GENERIC NAMES OF TYPE CONSUMABLES
	  	foreach($generic_names_consumables_list as $g)
	  	{
	  		$generic_names_consumables[$g->id] = $g->generic_name." ".$g->strength." ".$g->strength_unit;
	  		
	  	}
	  	$generic_names_consumables{'all'} = "All";
		$this->data['generic_names_consumables_list'] = $generic_names_consumables;
		
		$generic_names_opd_products_list = $this->generic->like('product_type','OUTPATIENTPRODUCTS')->find_all(); //GETS GENERIC NAMES OF TYPE OUTPATIENT 
	  	foreach($generic_names_opd_products_list as $g)
	  	{
	  		$generic_names_opd_products[$g->id] = $g->generic_name." ".$g->strength." ".$g->strength_unit;
	  	}
	  	$generic_names_opd_products{'all'} = "All";
	  	
		$this->data['generic_names_opd_products_list'] = $generic_names_opd_products;
		
		
		$this->load->view('mne/graphical_reports/inventory_consumed_chart',$this->data);
	
	}	
	public function get_data_for_inventory_consumed_chart($location_id,$from_date,$to_date, $rep_feature, $rep_option)
	{	
		$query = $this->visit->get_inventory_consumed_count($location_id,$from_date,$to_date, $rep_feature, $rep_option);
		return $query;  
	}
	
	
	public function inventory_consumed_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rep_feature = $_POST['rep_feature'];
		$rep_option = $_POST['rep_option'];
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_inventory_consumed_chart($rmhc, $from_date, $to_date, $rep_feature, $rep_option);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
		$rep_feature = json_encode($rep_feature);
		$rep_option = json_encode($rep_option);
?>		
		data = <?php echo $data;?>;
		rep_feature = <?php echo $rep_feature;?>;
		rep_option = <?php echo $rep_option;?>;
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		
	
<?php	
	}
	
	/*********************END OF INVENTORY CONSUMED IN CLINICS CHART****************/


	/*********************RISK FACTOR ONE CHART****************/

	public function risk_factor_one_chart()	
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";
		ksort($rmhcs);	
		$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/risk_factor_one_chart',$this->data);
	
	}	
	public function get_data_for_risk_factor_one_chart($location_id,$from_date,$to_date)
	{
		$query = $this->visit->get_risk_factor_one_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	public function risk_factor_one_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_risk_factor_one_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php
	
	}

	/*********************END OF RISK FACTOR ONE CHART****************/


	/*********************RISK FACTOR TWO CHART****************/

	public function risk_factor_two_chart()	
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";
		ksort($rmhcs);	
		$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/risk_factor_two_chart',$this->data);
	
	}	
	public function get_data_for_risk_factor_two_chart($location_id,$from_date,$to_date)
	{
		$query = $this->visit->get_risk_factor_two_count($location_id,$from_date,$to_date);
		return $query;  
	}
	
	public function risk_factor_two_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_risk_factor_two_chart($rmhc, $from_date, $to_date);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
?>		
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php
	}

	/*********************END OF RISK FACTOR two CHART****************/

	/*********************RISK FACTOR COMBINATION CHART****************/

	public function risk_factor_combination_chart()	
	{
		$this->data['from_date'] = 'DD/MM/YYYY';
	  	$this->data['to_date'] = 'DD/MM/YYYY';
	 	$this->data['from_date'] = Date_util::today();
	  	$this->data['to_date'] = $this->data['from_date'];	
		$rmhcs=$this->provider_location->get_all_names();	
		$rmhcs{'%'} = "All";
		ksort($rmhcs);	
		$this->data['locations'] = $rmhcs;
	  	$this->data['location_id'] = 0;
		$this->load->view('mne/graphical_reports/risk_factor_combination',$this->data);
	
	}	
	public function get_data_for_risk_factor_combination_chart($location_id,$from_date,$to_date,$risk_ids)
	{
		$query = $this->visit->get_risk_factor_combination_count($location_id,$from_date,$to_date,$risk_ids);
		return $query;  
	}
	
	public function risk_factor_combination_chart_call()
	{
		$rmhc = $_POST['rmhc'];
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$risk_ids = $_POST['risk_ids'];
		$rmhc_name = $_POST['rmhc_name'];
		
		$data = $this->get_data_for_risk_factor_combination_chart($rmhc, $from_date, $to_date, $risk_ids);
		
		$data = json_encode($data);
		$rmhc_name = json_encode($rmhc_name);
		$from_date = json_encode($from_date);
		$to_date = json_encode($to_date);
		$risk_ids = json_encode($risk_ids);
?>		
		risk_ids = <?php echo $risk_ids;?>;
		rmhc_name = <?php echo $rmhc_name;?>;
		from_date = <?php echo $from_date;?>;
		to_date = <?php echo $to_date;?>;		
		data = <?php echo $data;?>;
	
<?php
	
	}
	
	/*********************END OF RISK FACTOR COMBINATION CHART****************/	
		 
	/***********************************FOURTH METHOD*********************************/
	
	public function get_pdf_and_csv_rep()
	{
	 	$table_html = trim($_POST['table_html']);
	 	$email_address = trim($_POST['email_address']);
	 	$csv_string = trim($_POST['csv_string']);
	 	$filename = trim($_POST['filename']);
	 	
	 	$time_stamp = time();
	 	
	 	$fp = fopen($filename.'_'.$time_stamp.'.csv',"w");
		if(!fwrite($fp,$csv_string))
		{
			echo "CSV File could not be written";
		}
		
		$mpdf = new mPDF();
	 	$mpdf->WriteHTML($table_html);
	 	$mpdf->Output('/var/www/sgv/'.$filename.'_'.$time_stamp.'.pdf','F');
		
		$url =  $this->config->item('base_url').$filename.'_'.$time_stamp;
	 	if($_POST['email_address'])
		{
			$this->load->library('email', $this->config->item('email_configurations'));  
			$this->email->set_newline("\r\n");
			$this->email->from('hmis@sughavazhvu.co.in');
			$this->email->to($_POST['email_address']);
			$this->email->subject('Report');
			$this->email->message('Download Attachment');
	  		$this->email->attach($filename.'_'.$time_stamp.'.pdf');
			if($this->email->send()) 
			{
					$mail_sent = 'Email sent successfully';
			}
			else
			{
					$mail_sent = 'Failed to send Email! Please try again later';
			}
		}
		else
		{
	  		$mail_sent = 'No Email Address Provided';
		}
	 	
	 	$mail_sent = json_encode($mail_sent);
	 	
	 	$url = json_encode($url);
	 	
	 	?>
	 		url = <?php echo $url;?>;
	 	
			mail_sent = <?php echo $mail_sent;?>;

		<?php
			exit();
	 }
	/***********************************END OF FOURTH METHOD*********************************/ 
}
?>

