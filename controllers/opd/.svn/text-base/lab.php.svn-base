<?php
class lab extends CI_Controller {
  public $form_data = array();

  function __construct() {
    parent::__construct();
    $this->load->model('demographic/person_model', 'person');
    $this->load->model('demographic/household_model', 'household');
    $this->load->model('geo/village_citie_model', 'village_citie');
    $this->load->model('geo/street_model','street');
    $this->load->model('opd/visit_model', 'visit');
    $this->load->model('opd/visit_ros_entry_model', 'visit_ros_entry');
    $this->load->model('opd/visit_physical_exam_entry_model', 'visit_physical_exam_entry');
    $this->load->model('opd/visit_vital_model', 'visit_vital');
    $this->load->model('opd/visit_diagnosis_entry_model', 'visit_diagnosis_entry');
    $this->load->model('opd/visit_medication_entry_model', 'visit_medication_entry');
    $this->load->model('opd/visit_referral_entry_model', 'visit_referral_entry');
    $this->load->model('opd/visit_test_entry_model', 'visit_test_entry');
    $this->load->model('opd/visit_cost_item_entry_model', 'visit_cost_item_entry');
    $this->load->model('opd/visit_auscult_model', 'visit_auscult');	
    $this->load->model('opd/visit_document_model', 'visit_document');
    $this->load->model('admin/stock_maintenance_model', 'stock_maintenance');
	$this->load->model('admin/stock_maintenance_configuration_model', 'maintenance_config');
	$this->load->model('opd/stock_maintenance_historie_model', 'stock_maintenance_historie');	
	$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
	$this->load->model('opd/consumable_consumption_model', 'consumable_consumption');

    $this->load->model('opd/visit_addendum_model', 'visit_addendum');
    $this->load->model('opd/provider_model', 'provider');
    $this->load->model('opd/provider_location_model', 'provider_location');
    $this->load->model('opd/opd_product_model', 'opd_product');
    $this->load->model('opd/consultation_types_model', 'consultation_types');
    $this->load->model('opd/test_types_model', 'test_types');
    $this->load->model('scm/product_model', 'product');
    $this->load->model('admin/test_group_model', 'test_group');
	$this->load->model('admin/test_group_tests_model', 'test_group_tests');
	$this->load->model('admin/test_group_consumables_model', 'test_group_consumables');	

    $this->load->model('chw/project_model', 'project');

    $this->load->helper('medical');
    $this->load->helper('date');
    $this->load->dbutil();
    $this->load->library('form_validation');
    $this->load->library('utils');
    $this->load->library('date_util');
    $this->load->library('opd/problem_definition');
    $this->load->library('opd/problem_dom_displayer');

    $this->username = $this->session->userdata('username');
  }
 
  public function home() {
    if($this->session->userdata('username')!=null) {
    	$provider = $this->provider->find_by('username', $this->username);
    	$locations = array();
    	$villages = array();
    	$data['scm_orgs'] = $this->get_scm_orgs();
		$villages['0'] = 'All';
    	$loc_recs = $provider->related('provider_locations')->get();
    	foreach($loc_recs as $loc_rec)
    	  {
		$locations[$loc_rec->id] = $loc_rec->name;
    	  }
    	$this->session->set_userdata('locations',$locations);
    	if($this->session->userdata('location_id')!=null) {
		$pl_rec = $this->provider_location->find($this->session->userdata('location_id'));
		$vc_recs = $this->village_citie->find_all_by('code',$pl_rec->cachment_code);
    		foreach($vc_recs as $vc_rec)
    	  	{
			$villages[$vc_rec->id] = $vc_rec->name;
    	  	}
	}
	else
	{
    		foreach($loc_recs as $loc_rec)
		{
			$pl_rec = $this->provider_location->find($loc_rec->id);
			$vc_recs = $this->village_citie->find_all_by('code',$pl_rec->cachment_code);
    			foreach($vc_recs as $vc_rec)
    	  		{
				$villages[$vc_rec->id] = $vc_rec->name;
    	  		}
		}
		$vc_recs = $this->village_citie->find_all_by('code','ALL');
    		foreach($vc_recs as $vc_rec)
    	  	{
			$villages[$vc_rec->id] = $vc_rec->name;
    	  	}
	}
	$data['villages'] = $villages;
	$maintenance_list = $this->stock_maintenance->find_all_by('status',1);
	$data['maintenance_list']=$maintenance_list;
	$data['provider_id']=$provider;
	$street_lists = $this->street->find_all();
		$data['street_lists']=$street_lists;
    $this->load->view('opd/lab_home',$data);
    } else {
     	redirect('/session/session/login');
    }
  }
  public function log_maintenance() {
  	
  if($this->session->userdata('location_type') != 'Lab'){
    		$this->session->set_userdata('msg','Please select Lab Location ');
      		redirect('/opd/lab/home');
	}
  	$maintenance_id=$_POST['maintenance_id'];
  	$location_id=$this->session->userdata('location_id');	
    $provider = $this->provider->find_by('username', $this->username);
    $provider_id=$provider->id;
	$date= Date_util::today();
	$this->db->trans_begin();
	$tx_status = true;
	
  	$med_entries =$this->maintenance_config->find_all_by('stock_maintenance_id',$maintenance_id);
  	$this->load->model ('scm/product_batchwise_stock_model', 'stock' );
    foreach ($med_entries as $m) {
    	$prod =$this->product->find_by('id',$m->product_id);
    	$pl_rec =$this->provider_location->find($this->session->userdata('location_id'));
		$is_product_used=$this->stock->update_consumable($prod,$m->product_quantity_lab,$pl_rec->scm_org_id);
    	if($is_product_used==true){
    		$comment="Consumed for Lab with Maintenance Id=".$m->stock_maintenance_id ;
			$saved_value = $this->consumable_consumption->save_consumable($m->product_id,$m->product_quantity_lab,$pl_rec->id,$provider_id,$date,$pl_rec->scm_org_id,'',$comment);
        }
   	}
	$log_value=$this->stock_maintenance_historie->save_data($maintenance_id,$location_id,$provider_id,$date);
	$this->db->trans_commit();
	$home_message = 'Status updated successfully' ;
	$this->session->set_userdata('msg', $home_message);
	redirect('/opd/lab/home');
  }

  function search_by_document() {

	$doc_rec = $this->visit_document->return_bar_code($_POST['barcode_id']);
	if($doc_rec)
	      	redirect('/opd/visit/show/'.$doc_rec->visit_id);
	else
	{
    		$this->session->set_userdata('msg','Barcode id '.$_POST['barcode_id'].' not found');
      		redirect('/opd/lab/home');
	}
  }

  function update_test_values($visit_id) {
  	/*Lab location validation*/
  	if($this->session->userdata('location_type') != 'Lab'){
    		$this->session->set_userdata('msg','Please select Lab Location beforing entering value');
      		redirect('/opd/lab/home');
	}
	if($visit_id == ''){
		$this->session->set_userdata('msg','Please enter correct visit id and test type id');
		redirect('/opd/lab/home');
	}
  	if($_POST){
  		if(isset($_POST["result"])){
  			$has_atleast_one_value = false;
  			$has_atleast_one_change = false;
  			$success = array();
  			$failure = array();
  			foreach ($_POST["result"] as $result){
  				if(empty($result["value"]) || $result["value"] == ''){
  					continue;
  				}
  				$has_atleast_one_value = true;
  				
  				//to consider only changed test entries
  				$test_rec = $this->visit_test_entry->where('visit_id',$visit_id,false)->where('test_type_id',$result["test_id"],false)->find();
  				if($test_rec->result===$result["value"]){
  					continue;
  				}
  				$has_atleast_one_change = true;
  				
  				if($this->update_test_value($visit_id,$result["test_id"],$result["value"])){
  					array_push($success,$result["name"]);
  				}else{
  					array_push($failure,$result["name"]);
  				}
  			}
  			/*For no resut values updated*/
  			if(!$has_atleast_one_value){
  				$this->session->set_flashdata('msg_type', 'error');
  				$this->session->set_flashdata('msg', 'Please enter atleast one result value');
  				redirect('/opd/visit/show/'.$visit_id);
  			}
  			
  			if(sizeof($failure) == 0){
  				if($has_atleast_one_change){
	  				$this->session->set_flashdata('msg_type', 'success');
	  				$this->session->set_flashdata('msg', 'Test Value(s) for test type(s) '.implode(',',$success).' updated successfully');
	  				redirect('/opd/visit/show/'.$visit_id);
  				}else{
  					redirect('/opd/visit/show/'.$visit_id);
  				}
  			}else{
  				$this->session->set_flashdata('msg_type', 'error');
  				$this->session->set_flashdata('msg', 'Error updating test value(s) for test type(s) '.implode(',',$failure));
  				redirect('/opd/visit/show/'.$visit_id);
  			}
  		}
  	}else{
  		$this->session->set_userdata('msg','Only POST Request accepted');
  		redirect('/opd/lab/home');
  	}
  }
  
  private function update_test_value($visit_id ='',$test_type_id = '',$result) {
  	$test_name=$this->get_tests();
  	$provider = $this->provider->find_by('username', $this->username);
    $provider_id=$provider->id;
  	$date= Date_util::today();
	$visit_rec = $this->visit->find($visit_id);
	
	//code to deduct consumables for tests conducted in lab comes here 
	$is_test_group_used=false;
	$test_conducted = $this->visit_test_entry->where('visit_id',$visit_id)->where('result !=','""')->find_all();
	foreach($test_conducted as $tests){
		//to check individual tests already conducted with new test
		$tests_already_conducted =$tests->test_type_id;
		
		//The below code provides check for strip and procedure tests:Consumables will not be deducted for these tests in lab **IMP**
		$check_test_type=$this->test_types->find_by("id",$tests_already_conducted);
		if($check_test_type->type=="Strip"  ||  $check_test_type->type=="Procedure"){
			//continue;
		}else{
			$test_entries =$this->test_group_tests->find_by('test_id',$tests_already_conducted);
			$present_test_entries =$this->test_group_tests->find_by('test_id',$test_type_id);
			if($test_entries!= null && $present_test_entries != null){
				if($test_entries->test_group_id == $present_test_entries->test_group_id){
					$is_test_group_used=true;
				}
			}
		}
	}
	
	//return;
	if($is_test_group_used==false){
		$present_test_entries =$this->test_group_tests->find_by('test_id',$test_type_id);
		if($present_test_entries!= null){
			$test_group_id=$present_test_entries->test_group_id;
			$test_group_entries =$this->test_group_consumables->find_all_by('test_group_id',$test_group_id);
	      		foreach ($test_group_entries as $test_group) {
				  $prod =$this->product->find_by('id',$test_group->product_id);
				  $pl_rec =$this->provider_location->find($this->session->userdata('location_id'));
	      		  $is_product_used=$this->stock->update_consumable($prod,$test_group->quantity_lab,$pl_rec->scm_org_id);
		    	  if($is_product_used==true){
		    		$comment="Consumed for Lab with Test Group Id=".$test_group_id ;
					$saved_value = $this->consumable_consumption->save_consumable($test_group->product_id,$test_group->quantity_lab,$pl_rec->id,$provider_id,$date,$pl_rec->scm_org_id,$visit_id,$comment);
		         }
	      	}
			
		}
		
	}
	
	//till here
	$test_rec = $this->visit_test_entry->where('visit_id',$visit_id,false)->where('test_type_id',$test_type_id,false)->find();
	$test_rec->result = $result;
	$test_rec->lab_id= $this->session->userdata('location_id');
    	$provider = $this->provider->find_by('username', $this->session->userdata('username'));
	$test_rec->technician_id= $provider->id;
	$test_rec->date_of_result= Date_util::today_sql();
	return $test_rec->save();
  }

  public function add_visit($person_id = '',$policy_id = '') {
	if($person_id == '' || $policy_id == '')
	{
    		$this->session->set_userdata('msg','Please provide person id and / or policy id to add visit');
      		redirect('/opd/lab/home');
	}
	
	redirect('opd/visit/add/'.$person_id.'/'.$policy_id.'/Diagnostic');
  }

  public function print_report($visit_id,$policy_id) {

    $visit = $this->visit->find($visit_id);    
    $this->data['doctor'] = $this->provider->join('provider_location_affiliations','providers.id=provider_location_affiliations.provider_id','inner')
                                        ->where('providers.type','Doctor')
                                        ->where('provider_location_affiliations.provider_location_id',$visit->provider_location_id)
                                        ->find();

    $this->data['visit'] = $visit;    
//    $this->data['sig_file_name'] = $this->user->find_by('username',$this->data['doctor']->username)->sig_file_name;  
    $this->data['policy_id'] = $policy_id;    
    $this->data['date'] = Date_util::date_display_format($visit->date);    

    $person = $this->person->find($this->data['visit']->person_id);
    $this->data['person'] = $person;
//    $today = date('Y-m-d');
    $today = time();
    $dob_parts = explode('-',$person->date_of_birth);
    $dob = mktime(0,0,0,$dob_parts[1],$dob_parts[2],$dob_parts[0]);
    $this->data['age'] = round(($today - $dob)/(60*60*24*365),0);

    $this->data['household'] = $this->data['person']->related('household')->get();
    $this->data['displayer'] = $this->problem_dom_displayer;

    $this->data['test_types'] = $this->test_types->find_all();
    $this->load->view('opd/lab_report_print', $this->data);
  }

  function get_tests() {
	$tests = array ();
	$t_obj = IgnitedRecord::factory ( 'test_types' );
	$t_rows = $t_obj->find_all ();
	foreach ( $t_rows as $t_row ) {
		$tests [$t_row->id] = $t_row->name;
	}
	return $tests;
  }
	function get_scm_orgs() {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( 'scm_organizations' );
		$o_rows = $o_obj->find_all ();
		foreach ( $o_rows as $o_row ) {
			$orgs [$o_row->id] = $o_row->name;
		}
		return $orgs;
	}

	function get_costs() {
	  $this->load->model('opd/test_types_model', 'test_type');
	  $costs = array();
	  foreach ($_POST as $id) {
	    log_message("debug", "Got product ID [".$id."]\n");
	    if (!($t = $this->test_type->find($id))) {
	      log_message("debug", "Product not found");
	    }
	    $costs[$id] = $t->cost;
	  }
	  echo json_encode($costs);
	  return;
	}
	
	function list_pending_lab_tests($location_id = "",$location_name = "") {
		
		$values = array();
		$today = date("Y-m-d");
		$newdate = strtotime ( '-1 months' , strtotime($today)) ;
		$newdate = date ( "Y-m-d", $newdate );
		//echo $newdate;
		//return;
		$i=0;
		$j=0;
		$k=0;
		$this->load->library('session');
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );
		$this->load->library('date_util');
		$this->load->model('opd/visit_test_entry_model', 'visit_test_entry');
		$this->load->model('opd/visit_document_model', 'visit_document');
		$this->load->model('opd/visit_model', 'visit');
		
		$test_name = $this->get_data('test_types','name');
		$provider_locs = $this->get_data('provider_locations','name');
		$selected_location_id = $location_id;
		$selected_location_name = $location_name;
		
		$visit_query='SELECT * FROM visit_test_entries where result is null and test_type_id !=0' ;
		$query = $this->db->query($visit_query);
		if($query->num_rows() !=0)
		{
			$unique_locations = array();
			$unique_locations['-1'] = 'All';
			$unique_visits = array();
			foreach($query->result() as $unique_visit_data){
				$unique_visits[$unique_visit_data->visit_id]=$unique_visit_data->visit_id;
			}
		}
		foreach($unique_visits as $key=>$visit_data){
			$values[$i]['visit_id'] = $visit_data;
			$visit_detail=$this->visit->where('id',$visit_data)->find();
			if($visit_detail->valid_state==="Invalid"){
				continue;
			}
			$visit_date=$visit_detail->date;
			if($visit_date < $newdate){
				continue;
			}
			$values[$i]['visit_date'] =$visit_detail->date;
			
			//To calculate the number of hours since sample taken
			$current_time=time();
			$visit_end_time=$visit_detail->end_time;
			$diff_time_in_sec=$current_time-$visit_end_time;
			$diff_time_in_days=floor(($diff_time_in_sec)/(3600*24));
			$diff_time_in_hrs=floor((($diff_time_in_sec)%(3600*24))/(3600));
			//$diff_time_in_min=floor(($diff_time_in_sec%3600)/(60));
			
			$values[$i]['hours_since_visit'] =sprintf("%d days %02d hrs", $diff_time_in_days,$diff_time_in_hrs);
			
			$unique_locations[$visit_detail->provider_location_id]=$provider_locs[$visit_detail->provider_location_id];
			if($selected_location_id != "" && $selected_location_id != "-1" && $selected_location_id != $visit_detail->provider_location_id){
				continue;
			}
			//get test names to populate from visit_test_entries table
			$tests=$this->visit_test_entry->where('visit_id',$visit_data)->find_all();
			foreach($tests as $test){
				if(!isset($test->result) && $test->test_type_id!=0){
					$values[$i][$j]['test_name'] =$test_name[$test->test_type_id];
					$j++;
				}
			}
			
			//get bar codes to populate from visit_documents table
			$bar_codes=$this->visit_document->where('visit_id',$visit_data)->find_all();
			foreach($bar_codes as $bar_code){
				$values[$i][$k]['bar_code'] =$bar_code->document_id;
				$k++;
			}
			$i++;
		}
		$visit_link_url = 'index.php/opd/visit/show/';
		$this->form_data['values'] = $values;
		$this->form_data['total_results'] = $i;
		$this->form_data['total_tests'] = $j;
		$this->form_data['total_bar_codes'] = $k;
		$this->form_data['unique_provider_location'] = $unique_locations;
		$this->form_data['show_visit_url'] = $visit_link_url;
		$this->form_data['location_id'] = $selected_location_id;
		$this->form_data['location_name'] = $selected_location_name;
		$this->load->view('opd/pending_lab_tests', $this->form_data);
	}
	
	function get_data($table_name,$column_name) {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( $table_name );
		$o_rows = $o_obj->find_all();
		foreach ( $o_rows as $o_row ) {
			$orgs [$o_row->id] = $o_row->$column_name;
		}
		return $orgs;
	}
	
}

?>
