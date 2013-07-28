<?php
class provider extends CI_Controller {

	public $form_data = array ();
	
	function __construct() {
    	parent::__construct();
    	$this->load->helper('geo');
	}
	function create() {

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'full_name', 'Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->form_data ['states'] = get_states ();
		$this->form_data ['users'] = $this->get_users ();

		if (! isset ( $_POST ['full_name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'opd/provider_add', $this->form_data );
		} else {
			$this->load->library ( 'date_util' );
			$this->load->model ( 'opd/provider_model' );

//			$_POST ['start_date'] = Date_util::change_date_format ( $_POST ['start_date'] );
			$p_obj = $this->provider_model->new_record ( $_POST );
			if($p_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Provider: '.$p_obj->full_name.' saved successfully with id: '.$p_obj->id);
				redirect('/opd/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'Doctor: '.$p_obj->full_name.' saved unsuccessful');
				$this->load->view ( 'opd/provider_add');
			}
		}
	}

	function edit_()
	{
		$url = "/opd/provider/edit/".$_POST['dr_id_edit'];
		redirect($url);
	}
		

	function edit($id = '') {

		if ($id == '') {
			echo 'id should be enter to edit';
			return false;
		}

		$this->load->library ( 'form_validation' );
		$this->load->model ( 'opd/provider_model' );
		$this->form_data ['states'] = get_states ();
		$this->form_data ['users'] = $this->get_users ();
		$p_obj = $this->provider_model->find ( $id );
		$this->form_data ['p_obj'] = & $p_obj;

		$this->form_validation->set_rules ( 'full_name', 'Full Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['full_name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'opd/provider_add', $this->form_data );
		} else {

			$p_obj->load_postdata ( array ('full_name', 'qualification','state_id', 'district_id', 'village_city_id', 'street_address', 'contact_number', 'registration_number', 'type','username' ) );
			if($p_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Doctor: '.$p_obj->full_name.' saved successfully with id:'.$p_obj->id);
				redirect('/opd/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'Doctor: '.$p_obj->full_name.' saved unsuccessful');
				$this->load->view ( 'opd/provider_add');
			}
		}
	}

  function get_users() {
		$users= array ();
		$u_obj = IgnitedRecord::factory ( 'users' );
		$u_rows = $u_obj->find_all ();
		foreach ( $u_rows as $u_row ) {
			$users [$u_row->username] = $u_row->username;
		}
		return $users;
	}


	function get_locations() {
		$locations = array ();
		$l_obj = IgnitedRecord::factory ( 'provider_locations' );
		$l_rows = $l_obj->find_all ();
		foreach ( $l_rows as $l_row ) {
			$locations [$l_row->id] = $l_row->name;
		}
		return $locations;
	}

	function get_providers() {
		$providers = array ();
		$p_obj = IgnitedRecord::factory ( 'providers' );
		$p_rows = $p_obj->find_all ();
		foreach ( $p_rows as $p_row ) {
			$providers [$p_row->id] = $p_row->full_name;
		}
		return $providers;
	}


	function search_by_name($name = '') {
		
		$this->load->model ( 'opd/provider_model', 'provider' );
		if($name =="ALL")
		{
			$providers = $this->provider->find_all();
		}
		else
		{
			$providers = $this->provider->like ( 'full_name', $name)->find_all();
		}

		$data ['p_obj'] = $providers;

		$this->load->view ( 'opd/z_providers_list', $data );
	}

	function search_by_geo($geo_type = '', $key = '') {
		
		$this->load->model ( 'opd/provider_model', 'p' );

		if($geo_type =="village")
		{
			$this->load->model ('geo/village_citie_model','vc');
			$vcs = $this->vc->like('name',$key)->find_all();
			$vc_ids = '(';
			$i=0;
			foreach ($vcs as $vc)
			{
				if($i!=0)
					{$vc_ids = $vc_ids.',';}
				$vc_ids = $vc_ids.$vc->id;
			$i++;
			}
			$vc_ids = $vc_ids.')';
			$ps= $this->p->find_all_by_sql("select * from providers where village_city_id in ".$vc_ids.";");
		}

		if($geo_type =="taluka")
		{
			$this->load->model ('geo/taluka_model','taluka');
			$talukas = $this->taluka->like('name',$key)->find_all();
			$t_ids = '(';
			$i=0;
			foreach ($talukas as $t)
			{
				if($i!=0)
					{$t_ids = $t_ids.',';}
				$t_ids = $t_ids.$t->id;
			$i++;
			}
			$t_ids = $t_ids.')';
			$ps= $this->p->find_all_by_sql("select * from providers where taluka_id in ".$t_ids.";");
		}

		if($geo_type =="district")
		{
			$this->load->model ('geo/district_model','district');
			$districts = $this->district->like('name',$key)->find_all();
			$d_ids = '(';
			$i=0;
			foreach ($districts as $d)
			{
				if($i!=0)
					{$d_ids = $d_ids.',';}
				$d_ids = $d_ids.$d->id;
			$i++;
			}
			$d_ids = $d_ids.')';
			$ps= $this->p->find_all_by_sql("select * from providers where district_id in ".$d_ids.";");
		}

		$data ['p_obj'] = $ps;

		$this->load->view ( 'opd/z_providers_list', $data );
	}

	function provider_location() {

		$this->form_data ['locations'] = $this->get_locations ();
		$this->form_data ['providers'] = $this->get_providers ();

		if (! isset ( $_POST ['submit_affiliation'] ) ) {
			$this->load->view ( 'opd/provider_location', $this->form_data );
		} else {
			$this->load->model ( 'opd/provider_location_affiliation_model','pla' );

//			$_POST ['start_date'] = Date_util::change_date_format ( $_POST ['start_date'] );
			$pla_obj = $this->pla->new_record ( $_POST );
			if($pla_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Provider: '.$pla_obj->provider_id.' Location: '.$pla_obj->provider_location_id.' associated successfully');
				redirect('/opd/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'Provider: '.$pla_obj->provider_id.' Location: '.$pla_obj->provider_location_id.' could not be associated');
//    				$this->session->set_userdata('msg', 'Doctor: '.$p_obj->full_name.' saved unsuccessful');
				$this->load->view ( 'opd/provider_location');
			}
		}
	}

  function create_visit_report()
  {
	$this->load->model('opd/visit_model','visit');
	$this->load->model('opd/visit_vital_model','visit_vital');
	$this->load->model('opd/visit_medication_entry_model','visit_medication_entry');
	$this->load->model('opd/visit_diagnosis_entry_model','visit_diagnosis_entry');
	$this->load->model('opd/visit_test_entry_model','visit_test_entry');
	$this->load->dbutil();
    	$this->load->library('date_util');
    	$this->load->library('utils');
    	$this->load->helper('url');  
    	$this->load->helper('date');  
    	$this->load->helper('file');  
    	$this->load->library('opd/problem_dom_displayer');

    if(isset($_POST['from_date']))
    {			
		$from_date = Date_util::change_date_format($_POST['from_date']);
		$to_date = Date_util::change_date_format($_POST['to_date']);
		$location_id = $_POST['location_id'];
		if($location_id == 0)
			$location_id = '%';
	        $base_path = $this->config->item('base_path').'uploads/visits/';
                $visits_filename = 'visit-report-'.$_POST['location_id'].'-'.$from_date.'-'.$to_date.'.csv';
                $summary_filename = 'summary-report-'.$_POST['location_id'].'-'.$from_date.'-'.$to_date.'.html';

		$visits_query = 'select date, visits.id as visit_id, valid_state, visits.type as type,visits.comment as comment,followup_to_visit_id as prev_visit_id, person_id, policy_id, approved, audit_status, full_name, paid_amount, chief_complaint, hpi, assessment, risk_level, chw_followup_id,bill_paid, provider_locations.name as location from (visits,providers, provider_locations) where (provider_id = providers.id) AND (provider_location_id = provider_locations.id) AND  (provider_location_id LIKE "'.$location_id.'") AND (date between "'.$from_date.'" and "'.$to_date.'") ORDER BY date ASC, valid_state DESC';
	//	$visits_query = 'select date, visits.id as visit_id, valid_state, visits.type as type,visits.comment as comment,followup_to_visit_id as prev_visit_id, person_id, policy_id, approved, full_name, paid_amount, chief_complaint, hpi, assessment, risk_level, chw_followup_id,bill_paid from (visits cross join providers) where (provider_id = providers.id) AND (provider_location_id = '.$location_id.') AND (date between "'.$from_date.'" and "'.$to_date.'") ORDER BY date ASC, valid_state DESC';
		$query = $this->db->query($visits_query);
	if($query->num_rows() !=0)
	{
//		$csv_visits_result = $this->dbutil->csv_from_result($query);

		$csv_string = '<html><head></head><body><table><tr><td colspan=2>Summary report for Valid Visits</td></tr>'. "\n";

    		$total_query = $this->db->query('select count(id) as number_visits, sum(case when followup_to_visit_id=0 then 1 else 0 end) as first_visits, SUM(paid_amount) as total_amount from visits where (provider_location_id LIKE "'.$location_id.'") AND (date between "'.$from_date.'" and "'.$to_date.'") AND (valid_state = "Valid")');
		$total_amount = $total_query->row()->total_amount;
		$number_visits = $total_query->row()->number_visits;
		$number_first_visits = $total_query->row()->first_visits;
		$csv_string = $csv_string.'<tr><td>Total number of Visits</td><td>'.$number_visits.'</td></tr>';
		$csv_string = $csv_string.'<tr><td>Total number of First Visits</td><td>'.$number_first_visits.'</td></tr>';
		$csv_string = $csv_string.'<tr><td>Total number of Followup Visits</td><td>'.($number_visits - $number_first_visits).'</td></tr>';

    		$total_unpaid_query = $this->db->query('select count(id) as number_up_visits from visits where (provider_location_id LIKE "'.$location_id.'") AND (date between "'.$from_date.'" and "'.$to_date.'") AND (paid_amount = 0) AND (valid_state = "Valid")');
		$number_up_visits = $total_unpaid_query->row()->number_up_visits;

    		$total_credit_query = $this->db->query('select count(id) as total_unpaid_visits, SUM(paid_amount) as total_unpaid_amount from visits where (provider_location_id LIKE "'.$location_id.'") AND (date between "'.$from_date.'" and "'.$to_date.'") AND (valid_state = "Valid") AND (bill_paid="No")');
		$total_unpaid_amount = $total_credit_query->row()->total_unpaid_amount;
		$total_unpaid_visits = $total_credit_query->row()->total_unpaid_visits;
		$csv_string = $csv_string.'<tr><td>Total Free visits</td><td>'.$number_up_visits.'</td></tr>' ;
		$csv_string = $csv_string.'<tr><td>Total Amount Billed</td><td>'.$total_amount.'</td></tr>';
		$csv_string = $csv_string.'<tr><td>Total Amount Collected</td><td>'.($total_amount-$total_unpaid_amount).'</td></tr>';
		$csv_string = $csv_string.'<tr><td>Total Credit - Number of Visits</td><td>'.$total_unpaid_visits.'</td></tr>';
		$csv_string = $csv_string.'<tr><td>Total Credit - Total Amount</td><td>'.$total_unpaid_amount.'</td></tr>';

		$visit_string ='( ';
		$i=0;
		$csv_visits_result = 'Date, Visit Id, Location, Valid, Bill Paid, Audit Status, Approved,Pt Type,Comment,Policy Id,Type, Person Id, Age, Gender, Provider Name, Amount, Chief Complaint,T,P,RR,BPS,BPD,BMI,Wt,Ht,WHR,Wst,Hip,HC,UAC,Dist sph r,Dist sph l,Dist cyl r,Dist cyl l,Dist axial r,Dist axial l,Dist va r,Dist va l,Near sph r,Near sph l,Near cyl r,Near cyl l,Near axial r,Near axial l,Near va,Tests,Diagnosis,Medicines, HPI, Assessment,Risk level,ROS,PE,CHW Followup Id'."\n";
		foreach ($query->result() as $visit_rec)
		{
		   if($visit_rec->valid_state == 'Valid')
		   {
		   	if($i != 0)
				$visit_string = $visit_string.',';
		   	$visit_string = $visit_string.'"'.$visit_rec->visit_id.'"';
		   	$i++;
		   }
		   $this->load->model('demographic/person_model','person');
		   $person_rec = $this->person->find($visit_rec->person_id);
		   if($person_rec->age !=0)
		   {
			$age = $person_rec->age;
		   }
		   else
	    	   {
			$dob = explode('-',$person_rec->date_of_birth);
			$now = getdate();
			$age = $now['year'] - $dob[0];
		   }

		   $this->load->model('admin/policy_model','policy');
		   $type = '';
		   if($visit_rec->valid_state =='Valid' )
		   {
		     $id_arr = explode('-',$visit_rec->policy_id);
//		     if(sizeof($id_arr) == 2) { $type = 'Old1'.$nov.$id_arr[1];}
		     if(sizeof($id_arr) <= 2) { $type = 'Old';}
		     else
		     { 
			if ($id_arr[1] == 1) {$type = 'Employee';}
			else
		   	{
		   		$no_old_visits = $this->db->query('select count(id) as num_visits from visits where (valid_state ="Valid") and (policy_id="'.$visit_rec->policy_id.'")');
		   		if($no_old_visits && $visit_rec->policy_id != '')
		   		{
		     			$nov = $no_old_visits->row()->num_visits;
    					if($nov == 1 || ($nov == 2 && $visit_rec->prev_visit_id > 0))
					{	$type = 'New'; }
					else
					{	$type = 'Old'; }
//					{	$type = 'Old3'.$nov.$id_arr[1]; }
       			  	}
		     	}
                   
		    }
		  }
		  else {$type = 'NA';}

		   $csv_visits_result = $csv_visits_result.$visit_rec->date.','.$visit_rec->visit_id.','.$visit_rec->location.','.$visit_rec->valid_state.','.$visit_rec->bill_paid.','.$visit_rec->audit_status.','.$visit_rec->approved.','.$type.','.$visit_rec->comment.','.$visit_rec->policy_id.','.$visit_rec->type.','.$visit_rec->person_id.','.$age.','.$person_rec->gender.','.$visit_rec->full_name.','.$visit_rec->paid_amount.',"'.$visit_rec->chief_complaint.'"';
	
//		   echo ' before vitals '.$csv_visits_result;
		   $visit = $this->visit->find($visit_rec->visit_id);
//		   $visit_vitals = $this->visit_vital->find_by('visit_id',$visit_rec->visit_id); 
		   $visit_vitals = $visit->related('visit_vitals')->get(); 
//		   $vitals_string =  Utils::print_vitals($visit_vitals);
		   $vitals_string =  Utils::print_vitals_report($visit_vitals);
		   $vision_prescription = $visit->related('visit_visual_prescriptions')->get();
		   $vision_prescription_string =  Utils::print_vision_prescription_report($vision_prescription);
		   $csv_visits_result = $csv_visits_result.','.$vitals_string.','.$vision_prescription_string;
//		   echo ' after vitals '.$csv_visits_result;
		   
//		   $test_entries = $this->visit_test_entries->find_by('visit_id',$visit_rec->visit_id); 
	           $test_entries = $visit->related('visit_test_entries')->get();
		   $test_string ='';
	    	   if (!empty($test_entries)) {
	      		foreach ($test_entries as $t) {
				$this->load->model('opd/test_types_model', 'test_types');
	      			$tt = $this->test_types->find($t->test_type_id);
				$test_string = $test_string.$tt->name.':  '.$t->result.'; ';
			}
		   }
		   $csv_visits_result = $csv_visits_result.',"'.$test_string.'"';
//		   echo ' after tests '.$csv_visits_result;

//		   $diag_entries = $this->visit_diagnosis_entries->find_by('visit_id',$visit_rec->visit_id); 
	   	   $diag_entries =$visit->related('visit_diagnosis_entries')->get();
		   $diag_string = '';
	    	   foreach ($diag_entries as $d)
	    		$diag_string = $diag_string.$d->diagnosis.'; ';
		   $csv_visits_result = $csv_visits_result.',"'.$diag_string.'"';
//		   echo ' after diag'.$csv_visits_result;

//		   $med_entries = $this->visit_medication_entries->find_by('visit_id',$visit_rec->visit_id); 
	           $med_entries = $visit->related('visit_medication_entries')->get();
		   $med_string ='';
	    	   if (!empty($med_entries)) {
	      		foreach ($med_entries as $m) {
	      			$p = $m->related('product')->get();
				if($p && $m)
				$med_string = $med_string.$p->generic_name.' '.$p->strength.$p->strength_unit.'  '.$m->frequency.' '.$m->duration.' days '.$m->comment.'; ';
			}
		   }
		   $csv_visits_result = $csv_visits_result.',"'.$med_string.'"';
//		   echo ' after med'.$csv_visits_result;

        	  $ros_entries = $visit->related('visit_ros_entries')->get();
		  $ros_string ='';
		  if (!empty($ros_entries)) {
		      foreach ($ros_entries as $r) {
		      	if ($r->status == 'NA')
		      		continue;
//		      	if ($r->status == 'Yes') {
				$ros_string = $ros_string.$r->name.' - '.$r->status.' - ';
     			//$ros_details = unserialize($r->details);
				//$ros_det_str = $this->problem_dom_displayer->show_string($ros_details);
				$ros_details = $r->details;
				$ros_det_str = $this->problem_dom_displayer->parse_vist_json_string($ros_details);
				$ros_string = $ros_string.$ros_det_str.';';
//			}
		      }
		}

		$physical_exam_entries = $visit->related('visit_physical_exam_entries')->get();
		$pe_string ='';
	        if (!empty($physical_exam_entries)) {
		    foreach ($physical_exam_entries as $p) {
		      if ($p->status == 'NA')
		        continue;
//    		      if ($p->status == 'Abnormal') {
      			//$pe_details = unserialize($p->details);
      			//$pe_det_str = $this->problem_dom_displayer->show_string($pe_details);
      			$pe_details = $p->details;
      			$pe_det_str = $this->problem_dom_displayer->parse_vist_json_string($pe_details);
      			$pe_string = $pe_string.$p->test.' - '.$p->status.' - '.$pe_det_str.';';
//			}
		    }
		}

		   $csv_visits_result = $csv_visits_result.',"'.$visit_rec->hpi.'","'.$visit_rec->assessment.'",'.$visit_rec->risk_level.',"'.$ros_string.'","'.$pe_string.'",'.$visit_rec->chw_followup_id.','."\n";
//		   echo ' loop '.$i.'  '.$csv_visits_result;
		}
		$visit_string = $visit_string.')';
		if(!write_file($base_path.$visits_filename,$csv_visits_result))
		{  echo "File could not be written";  }
		if($i!=0)
		{
    		   $item_wise = $this->db->query('select type, subtype, sum(number) as total_qty, rate, sum(cost) as total_cost from visit_cost_item_entries where (visit_id in '.$visit_string.') group by subtype order by type');
		   $csv_string = $csv_string.'</table><table border=1><tr><td>Type</td><td>Subtype</td><td>Total Quantity</td><td>Rate</td><td>Total Collected</td></tr>';
		   foreach($item_wise->result() as $st_rec)
		   {
			$csv_string = $csv_string.'<tr><td>'.$st_rec->type.'</td><td>'.$st_rec->subtype.'</td><td>'.$st_rec->total_qty.'</td><td>'.$st_rec->rate.'</td><td>'.$st_rec->total_cost.'</td></tr>'."\n" ;
		   }
		   $csv_string .= '</table></body></html>';
	
	    	   $fp = fopen($base_path.$summary_filename,"w");
		   if(!fwrite($fp,$csv_string))
		   {  echo "CSV File could not be written";  }

		   if(!fclose($fp))
		   {  echo "CSV File could not be closed";  }
		   else
		   {
				if(isset($_POST['email_address']) && !empty($_POST['email_address']))
				{
					$this->load->library('email', $this->config->item('email_configurations'));  // email_configurations in module_constants.php
					$this->email->set_newline("\r\n");
					$this->email->from('hmis@sughavazhvu.co.in');
					$this->email->to($_POST['email_address']);
					$this->email->subject('Visits Report');
					$this->email->message($csv_string);
	  				$this->email->attach($base_path.$visits_filename);
					if($this->email->send()) {
						//echo 'Email sent.';
					}
				  	//$this->load->library('mail_util');
				 	//$mail_sent = Mail_util::send($_POST['email_address'],'Visits Report',$csv_string,$base_path.$visits_filename,'text/plain');
				}

				$this->data['visit_filename'] = $visits_filename;
				$this->data['summary_filename'] = $summary_filename;
				$this->data['from_date'] = $_POST['from_date'];
				$this->data['to_date'] = $_POST['to_date'];
				$this->data['location_id'] = $_POST['location_id'];
	  		//	$this->data['locations'] = $this->get_locations ();
	  			$locations = $this->get_locations ();
				$locations[0] = 'All';
				$this->data['locations'] = $locations;
          			$this->load->view('opd/create_report',$this->data);
  		   }
		}
	}
	else
	{
      		$this->session->set_flashdata('msg_type', 'error');
		$this->session->set_flashdata('msg','No Visits between '.$_POST['from_date'].' and '.$_POST['to_date'].' for location with id '. $_POST['location_id']);
		redirect('/opd/provider/create_visit_report');
	}
    }
    else
    {
	  $this->data['from_date'] = 'DD/MM/YYYY';
	  $this->data['to_date'] = 'DD/MM/YYYY';
	  $this->data['from_date'] = Date_util::today();
	  $this->data['to_date'] = $this->data['from_date'];
	  $locations = $this->get_locations ();
	  $locations[0] = 'All';
	  $this->data['locations'] = $locations;
	  $this->data['location_id'] = 0;
          $this->load->view('opd/create_report',$this->data);
    }
   }
  
  public function approve_visit($visit_id, $status, $policy_id = '') {
//    $this->validate_id($visit_id, 'visit');
   $this->load->model('opd/visit_model','visit');
    $visit_rec = $this->visit->find($visit_id);    

    if ($policy_id == '')
    {
	$policy_id = $visit_rec->policy_id;	
    }

    if($visit_rec->approved == 'Unseen')
    {
	$visit_rec->approved = $status;
$this->db->trans_begin();
$tx_status = true;

	if(!$visit_rec->save())
	{
		$tx_status = false;
	}


	if($tx_status == true)
    	{
       		$this->db->trans_commit();
    		$home_message = 'Status updated successfully' ;
    		$this->session->set_userdata('msg', $home_message);
    	}
    	else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $home_message);
    	}
    }

   redirect('/opd/visit/show/'.$visit_id.'/'.$policy_id); 
/*
    $this->data['visit'] = $visit_rec;    
    if($visit_rec->chw_followup_id !=0)
    {
      $this->load->model('chw/followup_model', 'c_followup' );
      $f_rec = $this->c_followup->find($visit_rec->chw_followup_id);    
      $this->data['chw_id'] = $f_rec->chw_id;    
      $this->load->model('chw/chw_model', 'chw' );
      $this->data['chw_name'] = $this->chw->find($f_rec->chw_id)->name;    
    }
    else
    {
      $this->data['chw_id'] = 0;    
    }
    $this->data['policy_id'] = $policy_id;    
    $this->load->model('demographic/person_model','person');
    $this->data['person'] = $this->person->find($this->data['visit']->person_id);
    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['displayer'] = $this->problem_dom_displayer;

    $this->data['test_types'] = $this->test_types->find_all();
    $this->load->view('opd/show_visit_resp', $this->data);*/
  }

  public function audit_close($visit_id, $policy_id = '') {
//    $this->validate_id($visit_id, 'visit');
   $this->load->model('opd/visit_model','visit');
    $visit_rec = $this->visit->find($visit_id);    

    if ($policy_id == '')
    {
	$policy_id = $visit_rec->policy_id;	
    }

    if($visit_rec->audit_status != 'closed')
    {
	$visit_rec->audit_status = 'closed';
$this->db->trans_begin();
$tx_status = true;

	if(!$visit_rec->save())
	{
		$tx_status = false;
	}

	if($tx_status == true)
    	{
       		$this->db->trans_commit();
    		$home_message = 'Audit Status updated successfully' ;
    		$this->session->set_userdata('msg', $home_message);
    	}
    	else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $home_message);
    	}
    }

   redirect('/opd/visit/show/'.$visit_id.'/'.$policy_id); 
  }

}
?>
