<?php
include_once(APPPATH.'libraries/plsp/writer/tcpdf/tcpdf.php');
// To modify to use Base_controller - currently not working
class Enrolment extends CI_Controller
{
	var  $data = array();
	var  $posted_data = array();
	var  $household_id;

	var $is_registration = false;
	var $new_person_id = false;
	var $new_policy_id = false;
	var $redirect_url = false;

	public function Enrolment() {
		parent::__construct();
		$this->load->library('ignitedrecord/Ignitedrecord');

		$this->load->model('demographic/person_model','person');
		$this->load->model('demographic/household_model', 'household');
		$this->load->model('admin/policy_model', 'policy');
		$this->load->model('admin/policy_type_model', 'policy_type');
		//    $this->load->model('admin/scheme_model', 'scheme');
		$this->load->model('admin/enrolment_statuse_model', 'enrolment_statuse');
		$this->load->model('admin/enrolled_member_model', 'enrolled_member');
		$this->load->model('opd/provider_model', 'provider');

		$this->load->model('opd/provider_location_model','provider_location');
		$this->load->model('geo/street_model','street');

		$this->load->model('geo/area_model','area');
		$this->load->model('geo/village_citie_model','village_citie');
		$this->load->model('geo/taluka_model','taluka');
		$this->load->model('geo/district_model','district');
		$this->load->model('geo/street_model','street');
		$this->load->model('geo/staff_model','staff');

		$this->load->model('user/users_role_model', 'user_role');
		$this->load->model('user/role_model', 'role');

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('date_util');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('file');
		$this->load->dbutil();
		$this->username = $this->session->userdata('username');
	}

	function index() {
		if($this->session->userdata('username')!=null) {
			$this->load->view('admin/home');
		} else {
			redirect('/session/session/login');
		}
	}

	function register_person() {
		$this->is_registration = true;

		$redirect_url = str_replace("/admin/enrolment/register_person", "", $this->uri->uri_string());
		log_message("debug", "Redirect url [".$redirect_url."]\n");
		if ($redirect_url != "")
		$this->redirect_url = $redirect_url;
		return $this->enroll_new_household_members(0,"add");
	}

	/**
	 * this function adds a new health member not belonging to any organisation
	 *
	 */
	function enroll_new_member() {
		return $this->enroll_new_household_members(0,"add");
	}

	/**
	 * this function adds / edits a new health member given a labournet member
	 *
	 */
	function enroll_partner_members($organization_member_id) {
		if (!($person = $this->person->find_by('organization_member_id', $organization_member_id))) {
			$this->session->set_userdata('msg', 'Organization member ID '.$organization_member_id.' is invalid');
			redirect('/admin/enrolment/index');
		}
		//   redirect('/admin/enrolment/enroll_household_members/'.$person->household_id);
		return $this->enroll_household_members($person->household_id,"add");
	}

	function edit_member() {
		$health_id = $_POST['id_edit'];
		$url = "/admin/enrolment/edit_health_member/".$health_id;
		redirect($url);
	}


	function edit_health_member($health_member_id) {
		if (!($policy = $this->household->find_by('policy_id', $health_member_id))) {
			$this->session->set_userdata('msg', 'Health member ID '.$health_member_id.' is invalid');
			redirect('/admin/enrolment/index');
		}

		//    redirect('/admin/enrolment/enroll_household_members/'.$hh_id);
		return $this->enroll_household_members($health_member_id, "edit");
	}

	function edit_new_member() {
		$health_id = $_POST['id_edit'];
		$url = "/admin/enrolment/edit_new_health_member/".$health_id;
		redirect($url);
	}

	function edit_new_health_member($health_member_id) {
		if (!($policy = $this->household->find_by('policy_id', $health_member_id))) {
			$this->session->set_userdata('msg', 'Health member ID '.$health_member_id.' is invalid');
			redirect('/admin/enrolment/index');
		}

		//    redirect('/admin/enrolment/enroll_household_members/'.$hh_id);
		return $this->enroll_new_household_members($health_member_id, "edit");
	}

	function renew_health_member($health_member_id) {
		if (!($policy = $this->household->find_by('policy_id', $health_member_id))) {
			$this->session->set_userdata('msg', 'Health member ID '.$health_member_id.' is invalid');
			redirect('/admin/enrolment/index');
		}

		//    redirect('/admin/enrolment/enroll_household_members/'.$hh_id);
		return $this->renew_policy($health_member_id);
	}

	function enroll_household_members($household_id, $action) {
		// TODO Enroll household
		// $household_id = 2;
		
		
		//here parameter $household_id is actually policy_id
		if($action == "edit")
		{
			$health_member_id = $household_id;
			$policy = $this->policy->find($health_member_id);
			$household_data = $this->household->find_by('policy_id',$policy->id);
			$household_id = $household_data->id;
		}
		$this->household_id = $household_id;

		if (!($members = $this->household->get_members($household_id))) {
			// TODO - this error handling
			$message = "Household id ".$household_id." is invalid";
			$this->session->set_userdata('msg',$message);
			redirect('/admin/enrolment/index');
			//  echo "household id [". $household_id. "] is invalid";
			return;
		}
		// TODO: Try and get only the relevant columns (id, name) here
		// echo ("-- hh id".$household_id);
		$this->data['household'] = $this->household->find($household_id);
		$this->data['members'] = $members;
		$this->data['member_list'] = $this->household->get_members_list($household_id);
		$this->data['staff_list'] = $this->staff->get_names();
		$this->data['policy_type_list'] = $this->policy_type->get_names();
		$this->data['bgs'] = $this->config->item('bgs');
		 
		if (!$_POST) {
			if($action=="add")
			{
				$this->data['action'] = "add";
				$this->data['policy_number'] = NULL;
				$this->data['is_bpl'] = '';
				$this->data['bpl_card_number'] = '';
				$this->data['form_number'] = '';
				$this->data['form_date'] = "DD/MM/YYYY";
				$this->data['receipt_number'] = '';
				$this->data['receipt_date'] = "DD/MM/YYYY";
				$this->data['amount'] = '';
				$this->data['amount_collected'] = '';
				$this->data['scheme_id'] = '';
				$this->data['staff_id'] = '';
				$this->load->view('admin/edit_enrolment_details', $this->data);
				return;
			}
			else
			{
				$this->data['action'] = "edit";
				$this->data['policy_number'] = $health_member_id;
				$this->data['is_bpl'] = $policy->is_bpl;
				$this->data['bpl_card_number'] = $policy->bpl_card_number;
				$this->data['scheme_id'] = $policy->scheme_id;
				$this->data['expiry_date'] = Date_util::date_display_format($policy->policy_end_date);
				$enrolment_status_rec = $this->enrolment_statuse->find_by('policy_id',$health_member_id);
				$this->data['form_number'] = $enrolment_status_rec->id;
				$this->data['form_date'] = Date_util::date_display_format($enrolment_status_rec->form_date);
				$this->data['receipt_number'] = $enrolment_status_rec->receipt_number;
				$this->data['receipt_date'] = Date_util::date_display_format($enrolment_status_rec->receipt_date);
				$this->data['amount'] = $enrolment_status_rec->amount;
				$this->data['amount_collected'] = $enrolment_status_rec->amount_collected;
				$this->data['staff_id'] = $enrolment_status_rec->staff_id;
				$this->load->view('admin/edit_enrolment_details', $this->data);
	   return;
			}
		}
		 
		// Is a post request
		if (!$this->save_enrolment_details($this->data['household'], $members, $action)) {
			// TODO: add an error message;
			// $data['values'] = $_POST;
			//	  echo "save unsuccessful";
			show_error("Save unsuccessful: ".$this->session->userdata('msg'));
			$this->load->view('admin/edit_enrolment_details' , $this->data);
			return;
		}
		redirect('/admin/enrolment/index');
	}


	function enroll_new_household_members($household_id, $action) {
		// TODO Enroll household
		// $household_id = 2;
		
		
		//here parameter $household_id is actually policy_id
		if($action == "edit")
		{
			$health_member_id = $household_id;
			$policy = $this->policy->find($health_member_id);
			$household_data = $this->household->find_by('policy_id',$policy->id);
			$household_id = $household_data->id;

			if (!($members = $this->household->get_members($household_id))) {
				// TODO - this error handling
	   $message = "Household id ".$household_id." is invalid";
	   $this->session->set_userdata('msg',$message);
	   redirect('/admin/enrolment/index');
	   //  echo "household id [". $household_id. "] is invalid";
	   return;
			}
			$this->data['household'] = $household_data;
			$this->data['members'] = $members;
			$this->data['member_list'] = $this->household->get_members_list($household_id);
			$this->data['no_of_lives'] = count($members);
		}

		$this->household_id = $household_id;
		$this->data['household_id'] = $household_id;
		$this->data['staff_list'] = $this->staff->get_names();
		$this->data['policy_type_list'] = $this->policy_type->get_names();
		 
		if (!$_POST) {
			if($action=="add")
			{
				$this->data['action'] = "add";
				$this->data['policy_number'] = NULL;
				$this->data['policy_type'] = 0;
				$this->data['is_bpl'] = 'No';
				$this->data['bpl_card_number'] = '';
				$this->data['form_number'] = '';
				$this->data['form_date'] = "DD/MM/YYYY";
				$this->data['receipt_number'] = '';
				$this->data['receipt_date'] = "DD/MM/YYYY";
				$this->data['expiry_date'] = "15/11/2010";
				//		$this->data['expiry_date'] = "DD/MM/YYYY";
				$this->data['amount'] = '';
				$this->data['amount_collected'] = '';
				$this->data['is_hmf'] = 'No';
				$this->data['is_shg'] = 'No';
				$this->data['contact_number'] = '';
				//		$this->data['hmf_id'] = '';
				$this->data['no_of_lives'] = '1';
				$this->data['discount'] = '0';
				$this->data['street_address'] = '';
				$this->data['relations'] = $this->config->item('relations');
				$this->data['bgs'] = $this->config->item('bgs');
				$this->data['peds'] = $this->config->item('peds');
				//   	        $this->data['rhfs'] = $this->config->item('rhfs');
				$this->data['areas'] = $this->area->get_names();
				$this->data['districts'] = $this->district->get_names();
				$this->data['talukas'] = $this->taluka->get_names();
				$this->data['villages'] = $this->village_citie->get_names();

				$this->data['redirect_url'] = $this->redirect_url;
				if ($this->is_registration)
		  $this->load->view('admin/quick_registration', $this->data);
		  else
		  $this->load->view('admin/add_enrolment_details', $this->data);
		  return;
			}
			else
			{
				$this->data['action'] = "edit";
				$this->data['policy_number'] = $health_member_id;
				$this->data['is_bpl'] = $policy->is_bpl;
				$this->data['bpl_card_number'] = $policy->bpl_card_number;
				$this->data['is_shg'] = $policy->is_shg_member;
				$this->data['is_hmf'] = $policy->is_hmf_member;
				$this->data['contact_number'] = $this->data['household']->contact_number;
				$this->data['scheme_id'] = $policy->scheme_id;
				$this->data['expiry_date'] = Date_util::date_display_format($policy->policy_end_date);

				$hh_rec = $this->household->find($household_id);
				//		$this->data['street_address'] = $this->village_citie->get_name($hh_rec->village_city_id).', '.$this->taluka->get_name($hh_rec->taluka_id).', '.$this->district->get_name($hh_rec->district_id);
				$this->data['village_id'] = $hh_rec->village_city_id;
				$this->data['area_id'] = $hh_rec->area_id;
				$this->data['taluka_id'] = $hh_rec->taluka_id;
				$this->data['district_id'] = $hh_rec->district_id;
				$this->data['street_address'] = $hh_rec->street_address;

				$enrolment_status_rec = $this->enrolment_statuse->find_by('policy_id',$health_member_id);
				$this->data['form_number'] = $enrolment_status_rec->id;
				$this->data['form_date'] = Date_util::date_display_format($enrolment_status_rec->form_date);
				$this->data['receipt_number'] = $enrolment_status_rec->receipt_number;
				$this->data['receipt_date'] = Date_util::date_display_format($enrolment_status_rec->receipt_date);
				$this->data['amount'] = $enrolment_status_rec->amount;
				$this->data['amount_collected'] = $enrolment_status_rec->amount_collected;
				$this->data['discount'] = $enrolment_status_rec->amount - $enrolment_status_rec->amount_collected;
				$this->data['staff_id'] = $enrolment_status_rec->staff_id;

				$this->data['relations'] = $this->config->item('relations');
				$this->data['bgs'] = $this->config->item('bgs');
				$this->data['peds'] = $this->config->item('peds');
				//   	        $this->data['rhfs'] = $this->config->item('rhfs');
				$this->data['areas'] = $this->area->get_names();
				$this->data['districts'] = $this->district->get_names();
				$this->data['talukas'] = $this->taluka->get_names();
				$this->data['villages'] = $this->village_citie->get_names();

				$this->load->view('admin/edit_new_enrolment_details', $this->data);
	   return;
			}
		}
		 
		// Is a post request
		if($action == 'add')
		{
			$result = $this->save_with_new_household();
		}
		else
		{
			$result = $this->edit_new_household($this->data['household'], $members, $action);
		}
		if (!$result) {
			// TODO: add an error message;
			// $data['values'] = $_POST;
			//	  echo "save unsuccessful";
			show_error("Save unsuccessful: ".$this->session->userdata('msg'));
			$this->load->view('admin/edit_new_enrolment_details' , $this->data);
			return;
		}
		if ($this->redirect_url && $this->redirect_url != '') {
			if ($this->is_registration)
			$this->redirect_url = $this->redirect_url."/".$this->new_person_id.'/'.$this->new_policy_id;
			redirect($this->redirect_url);
		}
		else
		redirect('/admin/enrolment/index');
	}

	function edit_add_del($policy_id) {

		$policy_check = $this->household->find_by('policy_id',$policy_id);
		if (!($policy_check)) {
			$this->session->set_userdata('msg', 'Health member ID '.$policy_id.' is invalid');
			redirect('/admin/enrolment/index');
		}
		$household_id = $this->person->find_by('household_id',$policy_check->id)->household_id;
		

		$this->data['household'] = $policy_check;
		if (!($this->data['household'])) {
			// TODO - this error handling
			$message = "Household id ".$household_id." is invalid";
			$this->session->set_userdata('msg',$message);
			redirect('/admin/enrolment/index');
			//  echo "household id [". $household_id. "] is invalid";
			return;
		}
		$members = $this->household->get_members($household_id);
		$members_deleted = array();
		$i = 0;
		foreach ($members as $member){
			$person_id = $member->id;
			$em_recs = $this->enrolled_member->find_by('person_id',$person_id);
			if(empty($em_recs)){
				$members_deleted[$i] = $member->id;
				$i++;
			}
		}

		$this->data['deleted_members'] = $members_deleted;
		$this->data['members'] = $members;
		$this->data['no_of_lives'] = count($members);
		if($this->data['no_of_lives'] > 0)
		{
			$member_list = array();
			$member_list = $this->household->get_members_list($household_id);
			$this->data['member_list'] = $member_list;
		}
		else
		{
			$hof_list = array();
			for($i=1;$i<=15;$i++)
			$hof_list[$i] = $i;
			$this->data['member_list'] = $hof_list;
		}

		$this->household_id = $household_id;
		$this->data['household_id'] = $household_id;
		if (!$_POST) {
			 
			$this->data['policy_number'] = $policy_id;
			$this->data['contact_number'] = $this->data['household']->contact_number;
			
			//	        $hof_person_rec = $this->person->find($hof_id);
			//		$hh_rec = $this->household->find($hof_person_rec->household_id);
			$hh_rec = $this->data["household"];
			$addr_fields = explode(',',$hh_rec->street_address);
			$this->data['door_no'] = $addr_fields[0];
			$street_lists = $this->street->find_all();
			$this->data['street_lists']=$street_lists;
			$this->data['street'] = (count($addr_fields)>1)?$addr_fields[1]:"";
			$this->data['hamlet'] = (count($addr_fields)>2)?$addr_fields[2]:"";
			$this->data['village'] = $this->village_citie->get_name($hh_rec->village_city_id);
			$this->data['village_id_of_city'] = $hh_rec->village_city_id;
			$this->data['is_village_outside'] = $hh_rec->outside_catchment_village_name;
			$this->data['relations'] = $this->config->item('sgv_relations');
			$male_relations = $this->config->item('sgv_relations_male');
			asort($male_relations);
			$this->data['male_relations'] = $male_relations;
			 
			$female_relations = $this->config->item('sgv_relations_female');
			asort($female_relations);
			$this->data['female_relations'] = $female_relations;
			$this->data['comments'] = $this->config->item('sgv_absent_reasons');
			$this->load->view('admin/edit_add_del', $this->data);
			return;
		}
		 
		// Is a post request
		$result = $this->edit_add_del_hh($this->data['household'],$members,$policy_id,$members_deleted);

		if (!$result) {
			$this->load_post_household_details($policy_id);
			return;
		}
		//redirect('/admin/enrolment/index');
		 
		$this->search_policy_by_id('opd',$policy_id);
		//$this->load->view('admin/edit_add_del' , $this->data);
	}

	function load_post_household_details($policy_id) {
		$policy_check = $this->household->find_by('policy_id',$policy_id);
		if (!($policy_check)) {
			$this->session->set_userdata('msg', 'Health member ID '.$policy_id.' is invalid');
			redirect('/admin/enrolment/index');
		}
		$household_id = $this->person->find_by('household_id',$policy_check->id)->household_id;

		$this->data['household'] = $policy_check;
		if (!($this->data['household'])) {
			// TODO - this error handling
			$message = "Household id ".$household_id." is invalid";
			$this->session->set_userdata('msg',$message);
			redirect('/admin/enrolment/index');
			//  echo "household id [". $household_id. "] is invalid";
			return;
		}
		$members = $this->household->get_members($household_id);
		$members_deleted = array();
		$i = 0;
		foreach ($members as $member){
			$person_id = $member->id;
			$em_recs = $this->enrolled_member->find_by('person_id',$person_id);
			if(empty($em_recs)){
				$members_deleted[$i] = $member->id;
				$i++;
			}
		}
	  
		$this->data['deleted_members'] = $members_deleted;
		$this->data['members'] = $members;
		$this->data['no_of_lives'] = count($members);
		if($this->data['no_of_lives'] > 0)
		{
			$member_list = array();
			$member_list = $this->household->get_members_list($household_id);
			$this->data['member_list'] = $member_list;
		}
		else
		{
			$hof_list = array();
			for($i=1;$i<=15;$i++)
			$hof_list[$i] = $i;
			$this->data['member_list'] = $hof_list;
		}
		 
		$this->household_id = $household_id;
		$this->data['household_id'] = $household_id;
		$this->data['policy_number'] = $policy_id;
		$this->data['contact_number'] = $this->data['household']->contact_number;
		$this->data['hof_id'] = $hof_id;
		//	        $hof_person_rec = $this->person->find($hof_id);
		//		$hh_rec = $this->household->find($hof_person_rec->household_id);
		$hh_rec = $this->data["household"];
		$addr_fields = explode(',',$hh_rec->street_address);
		$this->data['door_no'] = $addr_fields[0];
		$street_lists = $this->street->find_all();
		$this->data['street_lists']=$street_lists;
		$this->data['street'] = (count($addr_fields)>1)?$addr_fields[1]:"";
		$this->data['hamlet'] = (count($addr_fields)>2)?$addr_fields[2]:"";
		$this->data['village'] = $this->village_citie->get_name($hh_rec->village_city_id);
		$this->data['village_id_of_city'] = $hh_rec->village_city_id;
		$this->data['is_village_outside'] = $hh_rec->outside_catchment_village_name;
		$this->data['relations'] = $this->config->item('sgv_relations');
		$male_relations = $this->config->item('sgv_relations_male');
		asort($male_relations);
		$this->data['male_relations'] = $male_relations;

		$female_relations = $this->config->item('sgv_relations_female');
		asort($female_relations);
		$this->data['female_relations'] = $female_relations;
		$this->data['comments'] = $this->config->item('sgv_absent_reasons');
		$this->load->view('admin/edit_add_del', $this->data);
		return;

	}

	function edit_add_del_hh($household, $members,$policy_id,$members_deleted) {
		//print_r($_POST);
		//return;
		$this->load->helper('soundex');
		$posted_data = $_POST;
		$tx_status = true;
		$this->db->trans_begin();
		$hh_diff = false;
		if($household->contact_number != $posted_data['contact_number'])
		{	    $household->contact_number = $posted_data['contact_number'];
		$hh_diff = true;
		}
		if($this->street->find_by('id',$posted_data['street']) !=null){
			$street_name=ucwords($this->street->find_by('id',$posted_data['street'])->name);
			if($household->street_id != $posted_data['street']){	
				$household->street_id =$posted_data['street'];
			}
		}else{
			$street_name=$posted_data['street'];
		}
		
		$new_street_address = $posted_data['door_no'].','.$street_name.','.$posted_data['hamlet'];
		if($household->street_address != $new_street_address)
		{
			$household->street_address = $new_street_address;
			$household->address_soundex=return_soundex($new_street_address, 'ret_normalized_address_parts');
			$hh_diff = true;
		}
		if($hh_diff)
		{
			if (!($household->save()))
			{
				$home_message = "Household rec could not be saved. Try Again";
				//$this->session->set_userdata('msg', $home_message);
				$tx_status = false;
			}
		}


		$serial_numbers = $_POST['array_data'];
		$slno_array = explode(",", $serial_numbers);
		 
		$i=1;
		$j=0;
		$person_ids = array();
		$hof_index;
		foreach($members as $person_rec) {
			if(in_array($person_rec->id, $members_deleted)){
				$i++;
				continue;										// these are disabled rows
			}
			$varname_id = "member".$i."_id";
			$varname_del = "member".$i."_del";
			$varname_name = "member".$i."_name";
			$varname_gender = "member".$i."_gender";
			$varname_relation = "member".$i."_relation";
			$varname_org_id= "member".$i."_org_id";
	  $varname_comment= "member".$i."_comment";
	   
	  $age = "member".$i."_age";
	  $birth = "member".$i."_dob";


	  $person_rec->full_name = $posted_data[$varname_name];
			$person_rec->name_soundex = return_soundex($person_rec->full_name, 'ret_normalized_name_parts');
			if($posted_data[$varname_relation] == 'Other')	{
				$varname_relation = "member".$i."_relation_other";
			}
			if($posted_data[$varname_relation] == 'Self') {
				$hof_index = $j;
			}
			$person_rec->gender = $posted_data[$varname_gender];

			if(empty($posted_data[$birth]) || $posted_data[$birth] == "DD/MM/YYYY"){
				$current_year =  date("Y") ;
				$actual_dob =  $current_year - $posted_data[$age];
				$varname_dob = "01/01/".$actual_dob;
				$person_rec->date_of_birth = Date_util::change_date_format($varname_dob);
			}else{
				$varname_dob = "member".$i."_dob";
				$person_rec->date_of_birth = Date_util::change_date_format($posted_data[$varname_dob]);
			}

			$person_rec->relation = $posted_data[$varname_relation];
			$person_rec->organization_member_id= $posted_data[$varname_org_id];
			$person_rec->comment = $posted_data[$varname_comment];
			if(!isset($_POST[$varname_del])){
				$person_ids[$j] = $person_rec->id;
				$j++;
			}
			$person_rec->save();
			$i++;
		}
		
		

		$existing_rows = $i;
		 
		for ($m=$existing_rows ; $m <= sizeof($slno_array) ; $m++ ) {
			$k = $slno_array[$m-1];
			$person_rec = $this->person->new_record();
			$varname_name = "member".$k."_name";
			$varname_gender = "member".$k."_gender";
			$varname_relation = "member".$k."_relation";
			$varname_org_id= "member".$k."_org_id";
	  $varname_comment= "member".$k."_comment";
	   
	  $age = "member".$k."_age";
	  $birth = "member".$k."_dob";

	  if(empty($posted_data[$birth]) || $posted_data[$birth] == "DD/MM/YYYY"){
	  	$current_year =  date("Y") ;
	  	$actual_dob =  $current_year - $posted_data[$age];
	  	$varname_dob = "01/01/".$actual_dob;
	  	$person_rec->date_of_birth = Date_util::change_date_format($varname_dob);
	  }else{
	  	$varname_dob = "member".$k."_dob";
	  	$person_rec->date_of_birth = Date_util::change_date_format($posted_data[$varname_dob]);
	  }

	  $person_rec->household_id = $household->id;
	  $person_rec->full_name = $posted_data[$varname_name];
	  $person_rec->name_soundex = return_soundex($person_rec->full_name, 'ret_normalized_name_parts');
	  if($posted_data[$varname_relation] == 'Other')   {
	  	$varname_relation = "member".$k."_relation_other";
	  }
	  if($posted_data[$varname_relation] == 'Self') {
	  	$hof_index = $j;
	  }
	  $person_rec->gender = $posted_data[$varname_gender];
	  $person_rec->relation = $posted_data[$varname_relation];
	  //$person_rec->organization_member_id= $posted_data[$varname_org_id];
	  $person_rec->comment = $posted_data[$varname_comment];
	   
	  if(isset($posted_data[$varname_org_id]) && trim($posted_data[$varname_org_id]) != "") {
	  	$person_rec->organization_member_id = trim($posted_data[$varname_org_id]);
	  	$person_rec->organization_id = 3;
	  }
	  else {
	  	if($household->outside_catchment_village_name == null)
	  	$person_rec->organization_member_id=$policy_id.sprintf("%02s",$j+1);
	  	else
	  	$person_rec->organization_member_id=$policy_id."_".($j+1);
	  	$person_rec->organization_id = 2;
	  }

	  if (!($person_rec->save()))  {
	  	$home_message = "Person rec could not be saved. Try Again";
	  	//$this->session->set_userdata('msg', $home_message);
	  	$tx_status = false;
	  }
		
	  
	  
	  $person_ids[$j] = $person_rec->uid();

	  $i = $i + 1;
	  $j = $j + 1;
		}
		
		$family_size = $j;

		$i = 0;

		$tx_status = $tx_status AND $this->db->query('DELETE from enrolled_members where policy_id="'.$policy_id.'";');

		for ($i = 0; $i < $family_size; $i++)
		{
			$enrolled_member_rec = $this->enrolled_member->new_record();
			$enrolled_member_rec->policy_id = $policy_id;
			$enrolled_member_rec->person_id = $person_ids[$i];
			if (!($enrolled_member_rec->save()))
			{
				$home_message = "Enrolled Member rec could not be saved. Try Again";
				//$this->session->set_userdata('msg', $home_message);
	   $tx_status = false;
			}
		}

		if($tx_status == true)
		{
			$this->db->trans_commit();
		}
		else {
			$this->db->trans_rollback();
			$this->data['error_server'] = $home_message;
			return false;
		}
		//    $this->db->trans_complete();
		$home_message = " Updated successfully Member id ". $household->policy_id ;
		$this->data['success_message'] = $home_message;
		//$this->session->set_userdata('msg', $home_message);
		return true;
	}

	function add_sgv() {
		$this->data['contact_number'] = '';
		$this->data['hof_id'] = 1;
		for($i=1;$i<=15;$i++)
		$hof_list[$i] = $i;
		$this->data['hof_list'] = $hof_list;
		$this->data['door_no'] = '';
		$this->data['street'] = '';
		$this->data['hamlet'] = '';
		$this->data['relations'] = $this->config->item('sgv_relations');
		$male_relations = $this->config->item('sgv_relations_male');
		asort($male_relations);
		$this->data['male_relations'] = $male_relations;
		 
		$female_relations = $this->config->item('sgv_relations_female');
		asort($female_relations);
		$this->data['female_relations'] = $female_relations;
		$this->data['comments'] = $this->config->item('sgv_absent_reasons');

		$villages = array();
		$provider = $this->provider->find_by('username', $this->session->userdata('username'));
		$loc_recs = $provider->related('provider_locations')->get();
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
				$vc_recs = $this->village_citie->or_where('code','ALL')->or_where('code',$pl_rec->cachment_code)->find_all_by('code',$pl_rec->cachment_code);
				foreach($vc_recs as $vc_rec)
				{
					$villages[$vc_rec->id] = $vc_rec->name;
				}
			}
		}
		$vc_outside_rec = $this->village_citie->find_by('code',-1);

		$village_outside_catchment =  array();
		$village_outside_catchment[$vc_outside_rec->id] = $vc_outside_rec->name;
		$this->data['village_outside_catchment'] = $village_outside_catchment;
		$street_lists = $this->street->find_all();
		$this->data['street_lists']=$street_lists;
		asort($villages);
		$this->data['villages'] = $villages;
		 
		if (!$_POST) {
			$this->load->view('admin/add_sgv', $this->data);
			return;
		}
		 
		// Is a post request
		$result = $this->save_add_sgv();

		/*IMP: result= true,ALA0011073
		 *     result[0]=true/false
		 *     result[1]=$policy_id*/

		$result=explode(",",$result);
		if (!$result[0]) {
			$this->load->view('admin/add_sgv', $this->data);
			return;
		}
		$this->search_policy_by_id('opd',$result[1]);
	}

	function save_add_sgv() {
		//server-side validations
		if($_POST['card_included']== 'Y'){
			$policy_id = $_POST['policy_id_value'];
			$msg = $this->policy->validateCard($policy_id);
			if(!empty($msg)){
				$this->session->set_userdata('msg', $msg);
				redirect('/opd/visit/home');
			}
		}
		 
		$serial_numbers = $_POST['array_data'];
		$slno_array = explode(",", $serial_numbers);
		$selfCount = 0;
		for ($s = 0 ; $s < sizeof($slno_array) ; $s++ ) {
			$k = $slno_array[$s];
			$p_data = "member".$k."_relation";
			if($_POST[$p_data] == "Self"){
				$selfCount++;
			}
		}
		 
		if($selfCount == 0){
			$home_message = "Household could not be saved. Atleast one self relation is required " ;
			//$this->session->set_userdata('msg', $home_message);
			redirect('/opd/visit/home');
		}
		 
		if($selfCount >1 ){
			$home_message = "Household could not be saved. Cannot have more than one self relation " ;
			//$this->session->set_userdata('msg', $home_message);
			redirect('/opd/visit/home');
		}
		 
		 
		$this->load->helper('soundex');
		$posted_data = $_POST;
		$tx_status = true;
		$this->db->trans_begin();

		$household = $this->household->new_record();
		if($_POST['card_included']== 'Y'){
			$household->village_city_id= $posted_data['village_id'];
			$street_name=$this->street->find_by('id',$posted_data['street'])->name;
			$street_name=ucwords($street_name);
			$household->street_id=$posted_data['street'];
		}else{
			$household->village_city_id= $posted_data['outside_village'];
			$household->outside_catchment_village_name= $posted_data['name_of_outside_village'];
			$street_name=$posted_data['street'];
		}
		$household->contact_number = $posted_data['contact_number'];
		$new_street_address = $posted_data['door_no'].','.$street_name.','.$posted_data['hamlet'];
		$household->street_address = $new_street_address;
		$household->enroled_on = Date_util::change_date_format(Date_util::today());;
		$household->address_soundex=return_soundex($new_street_address, 'ret_normalized_address_parts');
		
		if (!($household->save()))  {
			$home_message = "Household rec could not be saved. Try Again";
			//$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		$policy_rec = $this->policy->new_record();
		if($_POST['card_included']== 'N')
		$policy_rec->id = 'T'.$household->id;
		else
		$policy_rec->id = $_POST['policy_id_value'];
		$household->policy_id = $policy_rec->id;

		if (!($household->save())) {
			$home_message = "Household rec could not be saved. Try Again";
			//$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		$serial_numbers = $_POST['array_data'];
		$slno_array = explode(",", $serial_numbers);
		$person_ids = array();
		$i=0;
		$hof_index;
		for ($j=0 ; $j < sizeof($slno_array) ; $j++ ) {
			$k = $slno_array[$j];
			$person_rec = $this->person->new_record();
			$varname_name = "member".$k."_name";
			$varname_gender = "member".$k."_gender";

			$age = "member".$k."_age";
			$birth = "member".$k."_dob";
			 
			 
			if(empty($posted_data[$birth]) || $posted_data[$birth] == "DD/MM/YYYY"){
				$current_year =  date("Y") ;
				$actual_dob =  $current_year - $posted_data[$age];
				$varname_dob = "01/01/".$actual_dob;
				$person_rec->date_of_birth = Date_util::change_date_format($varname_dob);
			}else{
				$varname_dob = "member".$k."_dob";
				$person_rec->date_of_birth = Date_util::change_date_format($posted_data[$varname_dob]);
			}
			$varname_relation = "member".$k."_relation";
	  $varname_comment = "member".$k."_comment";
	  $varname_org_id = "member".$k."_org_id";
	  $person_rec->household_id = $household->id;
	  $person_rec->full_name = $posted_data[$varname_name];
	  $person_rec->name_soundex=return_soundex($person_rec->full_name, 'ret_normalized_name_parts');

	  if($posted_data[$varname_relation] == 'Other') {
	  	$varname_relation = "member".$k."_relation_other";
	  }
	  if($posted_data[$varname_relation] == 'Self') {
	  	$hof_index = $j;
	  }
	  $person_rec->gender = $posted_data[$varname_gender];
	  $person_rec->relation = $posted_data[$varname_relation];
	  $person_rec->comment = $posted_data[$varname_comment];
	  if($_POST['card_included']== 'N') {
	  	if(trim($posted_data[$varname_org_id]) != "") {
	  		$person_rec->organization_member_id = trim($posted_data[$varname_org_id]);
	  		$person_rec->organization_id = 3;
	  	}
	  	else {
	  		$person_rec->organization_member_id=$policy_rec->id."_".($j+1);
	  		$person_rec->organization_id = 2;
	  	}
	  }
	  else {
	  	$person_rec->organization_member_id=$policy_rec->id.sprintf("%02s",$j+1);
	  	$person_rec->organization_id = 1;
	  }


	  if (!($person_rec->save())) {
	  	$home_message = "Person rec could not be saved. Try Again";
	  	$tx_status = false;
	  }

	  $person_ids[$j] = $person_rec->uid();

	  $i = $i + 1;
		}

		$family_size = $i;

		$i = 0;
		 
		$policy_rec->scheme_id = 0;
		if(!$policy_rec->save())
		{
			$home_message = "Policy rec could not be saved";
			//$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		$es_rec = $this->enrolment_statuse->new_record();
		//    $es_rec->policy_id = 'T'.$household->id;
		$es_rec->policy_id = $policy_rec->id;
		$es_rec->id = 'Nurse'.$household->id;
		$es_rec->form_date = Date_util::today_sql();
		$es_rec->username = $this->session->userdata('username');
		if(!$es_rec->save())
		{
			$home_message = "Enrolment rec could not be saved";
			//$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		for ($i = 0; $i < $family_size; $i++)
		{
			$enrolled_member_rec = $this->enrolled_member->new_record();
			$enrolled_member_rec->policy_id = $policy_rec->id;
			$enrolled_member_rec->person_id = $person_ids[$i];
			if (!($enrolled_member_rec->save()))
			{
				$home_message = "Enrolled Member rec could not be saved. Try Again";
				//$this->session->set_userdata('msg', $home_message);
	   $tx_status = false;
			}
		}

		if($tx_status == true)
		{
			$this->db->trans_commit();
		}
		else {
			$this->db->trans_rollback();
			$this->data['error_server'] = $home_message;
			return false;
		}
		//    $this->db->trans_complete();
		$home_message = " Created new household successfully with Member id ". $policy_rec->id ;
		$this->data['success_message'] = $home_message;
		//$this->session->set_userdata('msg', $home_message);
		return true.','.$policy_rec->id;
	}

	function renew_policy($old_policy_id) {

		$policy = $this->policy->find($old_policy_id);
		$house_id = $this->household->find_by('policy_id',$policy->id);
		$household_id =  $house_id->id;

		if (!($members = $this->household->get_members($household_id))) {
			// TODO - this error handling
			$message = "Household id ".$household_id." is invalid";
			$this->session->set_userdata('msg',$message);
			redirect('/admin/enrolment/index');
			//  echo "household id [". $household_id. "] is invalid";
			return;
		}
		$this->data['household'] = $house_id;
		$this->data['members'] = $members;
		$this->data['no_of_lives'] = count($members);
		$member_list = array();
		$member_list = $this->household->get_members_list($household_id);
		$this->data['member_list'] = $member_list;

		$this->household_id = $household_id;
		$this->data['household_id'] = $household_id;
		$this->data['staff_list'] = $this->staff->get_names();
		$this->data['policy_type_list'] = $this->policy_type->get_names();
		 
		if (!$_POST) {
			$this->data['action'] = "renew";
			$this->data['policy_number'] = $old_policy_id;
			$this->data['is_bpl'] = $policy->is_bpl;
			$this->data['bpl_card_number'] = $policy->bpl_card_number;
			$this->data['is_shg'] = $policy->is_shg_member;
			$this->data['is_hmf'] = $policy->is_hmf_member;
			$this->data['contact_number'] = $this->data['household']->contact_number;
			$this->data['scheme_id'] = $policy->scheme_id;
			$new_expiry_date = Date_util::add_1yr($policy->policy_end_date);
			$this->data['expiry_date'] = Date_util::date_display_format($new_expiry_date);

			$hof_person_rec = $this->person->find_by('household_id',$household_id);
			$hh_rec = $this->household->find($hof_person_rec->household_id);
			//		$this->data['street_address'] = $this->village_citie->get_name($hh_rec->village_city_id).', '.$this->taluka->get_name($hh_rec->taluka_id).', '.$this->district->get_name($hh_rec->district_id);
			$this->data['village_id'] = $hh_rec->village_city_id;
			$this->data['taluka_id'] = $hh_rec->taluka_id;
			$this->data['district_id'] = $hh_rec->district_id;

			$this->data['form_number'] = '';
			$this->data['form_date'] = 'DD/MM/YYYY';
			$this->data['receipt_number'] = '';
			$this->data['receipt_date'] = 'DD/MM/YYYY';
			$this->data['amount'] = 750;
			$this->data['amount_collected'] = 750;
			$this->data['discount'] = 0;
			$this->data['staff_id'] = 1;

			$this->data['relations'] = $this->config->item('relations');
			$this->data['bgs'] = $this->config->item('bgs');
			$this->data['peds'] = $this->config->item('peds');
			//   	        $this->data['rhfs'] = $this->config->item('rhfs');
			$this->data['districts'] = $this->district->get_names();
			$this->data['talukas'] = $this->taluka->get_names();
			$this->data['villages'] = $this->village_citie->get_names();

			$this->load->view('admin/renew_details', $this->data);
			return;
		}
		 
		// Is a post request
		$result = $this->renew_household($this->data['household'],$members);

		if (!$result) {
			// TODO: add an error message;
			// $data['values'] = $_POST;
			//	  echo "save unsuccessful";
			show_error("Save unsuccessful: ".$this->session->userdata('msg'));
			$this->load->view('admin/renew_details' , $this->data);
			return;
		}
		redirect('/admin/enrolment/index');
	}

	function renew_household($household, $members) {

		$posted_data = $_POST;
		$tx_status = true;
		$this->db->trans_begin();
		//    $this->db->trans_start();
		$hh_diff = false;
		if($household->contact_number != $posted_data['contact_number'])
		{	    $household->contact_number = $posted_data['contact_number'];
		$hh_diff = true;
		}
		if($household->village_city_id != $posted_data['add_village'])
		{	    $household->village_city_id = $posted_data['add_village'];
		$hh_diff = true;
		}
		if($household->taluka_id != $posted_data['add_taluka'])
		{	    $household->taluka_id = $posted_data['add_taluka'];
		$hh_diff = true;
		}
		if($household->district_id != $posted_data['add_district'])
		{	    $household->district_id = $posted_data['add_district'];
		$hh_diff = true;
		}
		if($hh_diff)
		{
			if (!($household->save()))
			{
				$home_message = "Household rec could not be saved. Try Again";
				$this->session->set_userdata('msg', $home_message);
				$tx_status = false;
			}
		}

		$i=0;
		$j=0;
		$person_ids = array();
		foreach($members as $person_rec)
		{
			$varname_id = "member".$i."_id";
			$varname_del = "member".$i."_del";
			$varname_name = "member".$i."_name";
			$varname_ped = "member".$i."_ped";
			$varname_gender = "member".$i."_gender";
			$varname_dob = "member".$i."_dob";
			$varname_relation = "member".$i."_relation";
			$varname_bg = "member".$i."_bg";

			//      $person_rec->household_id = $hh_id;
			if($posted_data[$varname_del] != "Yes")
			{
				$person_rec->full_name = $posted_data[$varname_name];
				if($posted_data[$varname_ped] == 'Other')
				{
					$varname_ped = "member".$i."_ped_other";
				}
				$person_rec->addictions = $posted_data[$varname_ped];
				$person_rec->gender = $posted_data[$varname_gender];
				$person_rec->date_of_birth = Date_util::change_date_format($posted_data[$varname_dob]);
				$person_rec->relation = $posted_data[$varname_relation];
				$person_rec->blood_group = $posted_data[$varname_bg];
				//      $person_rec->rh_factor = $posted_data[$varname_rhf];

				$person_ids[$j] = $person_rec->id;
				$person_rec->save();
				$j++;

			}
			$i++;
		}

		$varname_name = "member".$i."_name";
		while($posted_data[$varname_name] != '')
		{
			$person_rec = $this->person->new_record();
			$varname_ped = "member".$i."_ped";
			$varname_gender = "member".$i."_gender";
			$varname_dob = "member".$i."_dob";
			$varname_relation = "member".$i."_relation";
			$varname_bg = "member".$i."_bg";

			$person_rec->household_id = $household->id;
			$person_rec->full_name = $posted_data[$varname_name];
			if($posted_data[$varname_ped] == 'Other')
			{
				$varname_ped = "member".$i."_ped_other";
			}
			$person_rec->addictions = $posted_data[$varname_ped];
			$person_rec->gender = $posted_data[$varname_gender];
			$person_rec->date_of_birth = Date_util::change_date_format($posted_data[$varname_dob]);
			$person_rec->relation = $posted_data[$varname_relation];
			$person_rec->blood_group = $posted_data[$varname_bg];

			if (!($person_rec->save()))
			{
				$home_message = "Person rec could not be saved. Try Again";
				$this->session->set_userdata('msg', $home_message);
				$tx_status = false;
			}

			$person_ids[$j] = $person_rec->uid();

			$i = $i + 1;
			$j = $j + 1;
			$varname_name = "member".$i."_name";
		}

		$varname_name = "member".$i."_name";
		$family_size = $j;
		if($posted_data['no_of_lives'] != $family_size)
		{
			$home_message = "No of lives do not match with name";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
			//        return false;
		}

		$i = 0;
		
		$counter_query = $this->db->query("select MAX(counter) as max_counter from policies");
		$new_id = $counter_query->row()->max_counter + 1;
		$policy_rec = $this->policy->new_record();
		$dist_code = $this->district->get_code($posted_data['add_district']);
		$policy_rec->id = $this->config->item('id_prefix').'-'.$dist_code."-R".$posted_data['policy_type']."-".$new_id;
		$policy_rec->available_amount = $this->policy_type->find($posted_data['policy_type'])->limit;
		$policy_rec->last_policy_id = $posted_data['prev_policy_number'];
		$old_policy_rec = $this->policy->find($posted_data['prev_policy_number']);
		$policy_rec->backend_member_id = $old_policy_rec->backend_member_id;

		$policy_rec->scheme_id = $posted_data['policy_type'];
		$policy_rec->is_bpl=$posted_data['is_bpl'];
		if($posted_data['is_bpl']=="Yes")
		{
			$policy_rec->bpl_card_number = $posted_data['bpl_card_number'];
			$policy_rec->id_type = "ration card";
		}
		else
		{
			$policy_rec->bpl_card_number = 'NA';
			$policy_rec->id_type = 'NA';
		}
		$policy_rec->is_hmf_member=$posted_data['is_hmf'];
		$policy_rec->is_shg_member = $posted_data['is_shg'];
		$policy_id = $policy_rec->id;

		for ($i = 0; $i < $family_size; $i++)
		{
			$enrolled_member_rec = $this->enrolled_member->new_record();
			$enrolled_member_rec->policy_id = $policy_id;
			$enrolled_member_rec->person_id = $person_ids[$i];
			if (!($enrolled_member_rec->save()))
			{
				$home_message = "Enrolled Member rec could not be saved. Try Again";
				$this->session->set_userdata('msg', $home_message);
	   $tx_status = false;
			}
		}

		$enrolment_statuse_rec = $this->enrolment_statuse->new_record();
		$enrolment_statuse_rec->policy_id = $policy_id;
		$enrolment_statuse_rec->staff_id = $posted_data['staff'];

		$enrolment_statuse_rec->id = $posted_data['form_number'];
		$form_date= Date_util::change_date_format($posted_data['form_date']);
		$enrolment_statuse_rec->form_date= $form_date;

		$enrolment_statuse_rec->receipt_number = $posted_data['receipt_number'];
		$receipt_date= Date_util::change_date_format($posted_data['receipt_date']);
		$enrolment_statuse_rec->receipt_date= $receipt_date;

		$time = time();
		$datestring= "%Y-%m-%d";
		$enrolment_statuse_rec->date_of_data_entry = mdate($datestring, $time);

		$enrolment_statuse_rec->amount = $posted_data['amount'];
		$enrolment_statuse_rec->amount_collected = $posted_data['amount_collected'];

		$enrolment_statuse_rec->username = $this->session->userdata('username');

		$end_date= Date_util::change_date_format($posted_data['expiry_date']);
		$policy_rec->policy_end_date = $end_date ;


		if (!($policy_rec->save())){
			$home_message = "Policy rec could not be saved. Try Again";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		if(!($enrolment_statuse_rec->save()))
		{
			$home_message = "Policy rec could not be saved. Try Again";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		if($tx_status == true)
		{
			$this->db->trans_commit();
		}
		else {
			$this->db->trans_rollback();
			return false;
		}
		$home_message = "Form No ".$enrolment_statuse_rec->id." Updated successfully with policy id ". $policy_rec->id ;
		$this->session->set_userdata('msg', $home_message);
		return true;
	}

	/* Create new persons, household and family along with policy */

	function save_with_new_household() {

		$posted_data = $_POST;
		$tx_status = true;
		$this->db->trans_begin();

		$hh_rec = $this->household->new_record();
		//ALA    $hh_rec->area_id = $posted_data['add_area'];
		//ALA    $hh_rec->street_address = $posted_data['street_address'];
		$hh_rec->village_city_id = $posted_data['add_village'];
		$hh_rec->taluka_id = $posted_data['add_taluka'];
		$hh_rec->district_id = $posted_data['add_district'];
		
		if (isset($posted_data['street_address']))
		$hh_rec->street_address = $posted_data['street_address'];

		if (isset($posted_data['contact_number']))
		$hh_rec->contact_number = $posted_data['contact_number'];

		if (!($hh_rec->save()))
		{
			$home_message = "Household rec could not be saved. Try Again";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		$hh_id = $hh_rec->uid();

		$person_ids = array();
		$i=0;
		$varname_name = "member".$i."_name";
		while($posted_data[$varname_name] != '')
		{
			$person_rec = $this->person->new_record();
			$varname_ped = "member".$i."_ped";
			$varname_gender = "member".$i."_gender";
			$varname_dob = "member".$i."_dob";
			$varname_relation = "member".$i."_relation";
			$varname_bg = "member".$i."_bg";

			$person_rec->household_id = $hh_id;
			$person_rec->full_name = $posted_data[$varname_name];
			if (isset($posted_data[$varname_ped])) {
	   if ($posted_data[$varname_ped] == 'Other')
	   $varname_ped = "member".$i."_ped_other";
	   // FIXME - addictions should not store PEDs!
	   $person_rec->addictions = $posted_data[$varname_ped];
			}

			$person_rec->gender = $posted_data[$varname_gender];
			$person_rec->date_of_birth = Date_util::change_date_format($posted_data[$varname_dob]);
			$person_rec->relation = $posted_data[$varname_relation];

			if (isset($posted_data[$varname_bg]))
			$person_rec->blood_group = $posted_data[$varname_bg];

			if (!($person_rec->save()))
			{
				$home_message = "Person rec could not be saved. Try Again";
				$this->session->set_userdata('msg', $home_message);
				$tx_status = false;
			}

			$person_ids[$i] = $person_rec->uid();

			$i = $i + 1;
			$varname_name = "member".$i."_name";
		}
		$this->new_person_id = $person_ids[0];
		 
		$family_size = $i;
		if(isset($posted_data['no_of_lives'])
		&& $posted_data['no_of_lives'] != $family_size)
		{
			$home_message = "No of lives do not match with name";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
			//        return false;
		}

		$counter_query = $this->db->query("select MAX(counter) as max_counter from policies");
		$new_id = $counter_query->row()->max_counter + 1;
		$policy_rec = $this->policy->new_record();
		$dist_code = $this->district->get_code($posted_data['add_district']);
		//ALA    $policy_rec->id = $this->config->item('idcard_org').$dist_code."-".$posted_data['policy_type']."-".$new_id;
		$vc_code = $this->village_citie->find($posted_data['add_village'])->code;
		$policy_rec->id = $vc_code."-".$posted_data['policy_type']."-".$new_id;
		$this->new_policy_id = $policy_rec->id;
		//ALA    $policy_rec->id = $this->config->item('idcard_org').$new_id;

		$policy_rec->scheme_id = $posted_data['policy_type'];
		//    if($policy_rec->scheme_id = 3) {$policy_rec->available_amount = "10000";} else {$limit = "30000";}
		$policy_rec->available_amount = $this->policy_type->find($policy_rec->scheme_id)->limit;

		$policy_rec->is_bpl=$posted_data['is_bpl'];
		if($posted_data['is_bpl']=="Yes")
		{
			$policy_rec->bpl_card_number = $posted_data['bpl_card_number'];
			$policy_rec->id_type = "ration card";
		}
		else
		{
			$policy_rec->bpl_card_number = 'NA';
			$policy_rec->id_type = 'NA';
		}

		$policy_rec->is_hmf_member=$posted_data['is_hmf'];
		$policy_rec->is_shg_member = $posted_data['is_shg'];

		$policy_id = $policy_rec->id;
		
		$hh_rec->policy_id=$policy_id;
		if (!($hh_rec->save())) {
			$home_message = "Household rec could not be saved. Try Again";
			//$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}
		
		for ($i = 0; $i < $family_size; $i++)
		{
			$enrolled_member_rec = $this->enrolled_member->new_record();
			$enrolled_member_rec->policy_id = $policy_id;
			$enrolled_member_rec->person_id = $person_ids[$i];
			if (!($enrolled_member_rec->save()))
			{
				$home_message = "Enrolled Member rec could not be saved. Try Again";
				$this->session->set_userdata('msg', $home_message);
	   $tx_status = false;
			}
		}
		$enrolment_statuse_rec = $this->enrolment_statuse->new_record();
		$enrolment_statuse_rec->policy_id = $policy_id;
		$enrolment_statuse_rec->staff_id = $posted_data['staff'];

		if(isset($posted_data['form_number']))
		$enrolment_statuse_rec->id = $posted_data['form_number'];
		else
		$enrolment_statuse_rec->id = $policy_id;
		$form_date= Date_util::change_date_format($posted_data['form_date']);
		$enrolment_statuse_rec->form_date= $form_date;

		$enrolment_statuse_rec->receipt_number = $posted_data['receipt_number'];
		$receipt_date= Date_util::change_date_format($posted_data['receipt_date']);
		$enrolment_statuse_rec->receipt_date= $receipt_date;

		$time = time();
		$datestring= "%Y-%m-%d";
		$enrolment_statuse_rec->date_of_data_entry = mdate($datestring, $time);

		$enrolment_statuse_rec->amount = $posted_data['amount'];
		$enrolment_statuse_rec->amount_collected = $posted_data['amount_collected'];
		if(($posted_data['amount'] - $posted_data['discount'])!= $posted_data['amount_collected'])
		{
			$home_message = "Form No ".$enrolment_statuse_rec->id." Not updated since amount and discount dont tally with policy id: ". $policy_rec->id ;
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		$enrolment_statuse_rec->username = $this->session->userdata('username');

		$end_date= Date_util::change_date_format($posted_data['expiry_date']);
		$policy_rec->policy_end_date = $end_date ;


		if (!($policy_rec->save()))
		{
			$home_message = "Policy rec could not be saved. Try Again";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		if(!($enrolment_statuse_rec->save()))
		{
			$home_message = "Enrolment rec could not be saved. Try Again";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}
		//	echo "status entry added with form no ",$enrolment_statuse_rec->form_number;

		/* TODO: Add in default values for
		 `idcard_status` int(11) NOT NULL default '0': 0
		 `photo_status` tinyint(1) NOT NULL default '0': 1
		 -- health_book_status -> policy_material status: 0
		 `policy_material_status` int(11) NOT NULL default '0': 0
		 `ack` int(11) NOT NULL default '0': 1
		 */
		// TODO - error checking at each step above

		if($tx_status == true)
		{
			$this->db->trans_commit();
		}
		else {
			$this->db->trans_rollback();
			return false;
		}
		$home_message = "Form No ".$enrolment_statuse_rec->id." Updated successfully with policy id ". $policy_rec->id ;
		$this->session->set_userdata('msg', $home_message);
		return true;
	}

	function edit_new_household($household, $members, $action) {

		$posted_data = $_POST;
		$tx_status = true;
		$this->db->trans_begin();
		$hh_diff = false;
		$vc_diff = false;
		
		if($household->contact_number != $posted_data['contact_number'])
		{	    $household->contact_number = $posted_data['contact_number'];
		$hh_diff = true;
		}
		if($household->village_city_id != $posted_data['add_village'])
		{	    $household->village_city_id = $posted_data['add_village'];
		$hh_diff = true;
		$vc_diff = true;
		}
		if($household->taluka_id != $posted_data['add_taluka'])
		{	    $household->taluka_id = $posted_data['add_taluka'];
		$hh_diff = true;
		}
		if($household->district_id != $posted_data['add_district'])
		{	    $household->district_id = $posted_data['add_district'];
		$hh_diff = true;
		}
		if($hh_diff)
		{
			if (!($household->save()))
			{
				$home_message = "Household rec could not be saved. Try Again";
				$this->session->set_userdata('msg', $home_message);
				$tx_status = false;
			}
		}

		$i=0;
		foreach($members as $person_rec)
		{
			$varname_name = "member".$i."_name";
			$varname_ped = "member".$i."_ped";
			$varname_gender = "member".$i."_gender";
			$varname_dob = "member".$i."_dob";
			$varname_relation = "member".$i."_relation";
			$varname_bg = "member".$i."_bg";

			$person_rec->full_name = $posted_data[$varname_name];
			if($posted_data[$varname_ped] == 'Other')
			{
				$varname_ped = "member".$i."_ped_other";
			}
			$person_rec->addictions = $posted_data[$varname_ped];
			$person_rec->gender = $posted_data[$varname_gender];
			$person_rec->date_of_birth = Date_util::change_date_format($posted_data[$varname_dob]);
			$person_rec->relation = $posted_data[$varname_relation];
			$person_rec->blood_group = $posted_data[$varname_bg];

			$person_rec->save();
			$i++;
		}
		if ($action == "edit")
		{
			$policy_rec = $this->policy->find($posted_data['policy_number']);
			$old_enrolment_status_rec = $this->enrolment_statuse->find_by('policy_id',$policy_rec->id);
			$old_enrolment_status_rec->delete();
		}

		$policy_diff = false;
		$scheme_diff = false;
		if($action == "add")
		{
			$counter_query = $this->db->query("select MAX(counter) as max_counter from policies");
			$new_id = $counter_query->row()->max_counter + 1;
			$policy_rec = $this->policy->new_record();
			$dist_code = $this->district->get_code($posted_data['add_district']);
			$policy_rec->id = $this->config->item('idcard_org').$dist_code."-".$posted_data['policy_type']."-".$new_id;
			//ALA        $policy_rec->id = $this->config->item('idcard_org').$new_id;
			$policy_rec->available_amount = $this->policy_type->find($posted_data['policy_type'])->limit;
		}
		if(($policy_rec->scheme_id != $posted_data['policy_type']))
		{
			$policy_diff = true;
			$scheme_diff = true;
			$policy_rec->scheme_id = $posted_data['policy_type'];
		}
		//    if($policy_rec->scheme_id = 3) {$policy_rec->available_amount = "10000";} else {$limit = "30000";}


		if(($policy_rec->is_bpl != $posted_data['is_bpl']))
		{
			$policy_diff = true;
			$policy_rec->is_bpl=$posted_data['is_bpl'];
		}
		if ($policy_rec->bpl_card_number != $posted_data['bpl_card_number'])
		{
			$policy_diff = true;
			if($posted_data['is_bpl']=="Yes")
			{
				$policy_rec->bpl_card_number = $posted_data['bpl_card_number'];
				$policy_rec->id_type = "ration card";
			}
			else
			{
				$policy_rec->bpl_card_number = 'NA';
				$policy_rec->id_type = 'NA';
			}
		}

		if(($policy_rec->is_hmf_member != $posted_data['is_hmf']))
		{
			$policy_diff = true;
			//    $policy_diff = $policy_diff OR ($policy_rec->is_hmf_member != $posted_data['is_hmf']);
			$policy_rec->is_hmf_member=$posted_data['is_hmf'];
		}

		if(($policy_rec->is_shg_member != $posted_data['is_shg']))
		{
			$policy_diff = true;
			//    $policy_diff = $policy_diff OR ($policy_rec->is_shg_member != $posted_data['is_shg']);
			$policy_rec->is_shg_member = $posted_data['is_shg'];
		}

		$end_date= Date_util::change_date_format($posted_data['expiry_date']);
		if(($policy_rec->policy_end_date != $end_date))
		{
			$policy_diff = true;
			//    $policy_diff = $policy_diff OR ($policy_rec->is_hmf_member != $posted_data['is_hmf']);
			$policy_rec->policy_end_date = $end_date ;
		}

		$policy_id = $policy_rec->id;

		if($vc_diff || $scheme_diff)
		{
			$vc_code = $this->village_citie->find($posted_data['add_village'])->code;
			$this->new_policy_id = $vc_code."-".$posted_data['policy_type']."-".$policy_rec->counter;

			if(!($policy_rec->save()))
			$tx_status = false;
			$pol_query = 'update policies set id ="'.$this->new_policy_id.'" where id="'.$policy_rec->id.'"';
			if(!($this->db->query($pol_query)))
			$tx_status = false;
			$em_query = 'update enrolled_members set policy_id ="'.$this->new_policy_id.'" where policy_id="'.$policy_rec->id.'"';
			if(!($this->db->query($em_query)))
			$tx_status = false;

			$policy_id = $this->new_policy_id;
		}
		else if ($policy_diff)
		{
			if (!($policy_rec->save())){
				$home_message = "Policy rec could not be saved. Try Again";
				$this->session->set_userdata('msg', $home_message);
				$tx_status = false;
			}
		}


		$enrolment_statuse_rec = $this->enrolment_statuse->new_record();
		$enrolment_statuse_rec->policy_id = $policy_id;
		$enrolment_statuse_rec->staff_id = $posted_data['staff'];

		$enrolment_statuse_rec->id = $posted_data['form_number'];
		
		$form_date= Date_util::change_date_format($posted_data['form_date']);
		$enrolment_statuse_rec->form_date= $form_date;

		$enrolment_statuse_rec->receipt_number = $posted_data['receipt_number'];

		$receipt_date= Date_util::change_date_format($posted_data['receipt_date']);
		$enrolment_statuse_rec->receipt_date= $receipt_date;

		$time = time();
		$datestring= "%Y-%m-%d";
		$enrolment_statuse_rec->date_of_data_entry = mdate($datestring, $time);

		$enrolment_statuse_rec->amount = $posted_data['amount'];
		$enrolment_statuse_rec->amount_collected = $posted_data['amount_collected'];

		$enrolment_statuse_rec->username = $this->session->userdata('username');

		if(!($enrolment_statuse_rec->save()))
		{
			$home_message = "Policy rec could not be saved. Try Again";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		if($tx_status == true)
		{
			$this->db->trans_commit();
		}
		else {
			$this->db->trans_rollback();
			return false;
		}
		$home_message = "Form No ".$enrolment_statuse_rec->id." Updated successfully with policy id ". $policy_id ;
		$this->session->set_userdata('msg', $home_message);
		return true;
	}

	function policy_details_counter($ctr)
	{
		$this->load->model('opd/visit_model', 'visit');
		if($policy_rec = $this->policy->find_by('counter',$ctr))
		{
			$house_rec = $this->household->find_by('policy_id',$policy_rec->id);
			$old_persons_recs = $this->person->find_all_by('household_id',$house_rec->id);
			$hh=0;
			foreach($old_persons_recs as $fp_rec)
			{
				echo "person=".$fp_rec->id."  visits=";
				$visits_rec=$this->visit->find_all_by('person_id',$fp_rec->id);
				foreach($visits_rec as $v)
				{
					echo $v->id.",";
				}
				echo "<br/>";
				$p = $this->person->find($fp_rec->id);
				$hh = $p->household_id;
			}
			echo "household = ".$hh;
		}
	}
	function household_details($id)
	{
		$this->load->model('opd/visit_model', 'visit');
		if($hh_rec=$this->household->find($id))
		{
			if($p_list = $this->household->get_members($id))
			{
				$anyoneid=0;
				foreach($p_list as $p)
				{
					echo "person=".$p->id."  visits=";
					$visits_rec=$this->visit->find_all_by('person_id',$p->id);
						
					foreach($visits_rec as $v)
					{
						echo $v->id.",";
					}
					echo "<br/>";
					$anyoneid=$p->id;
				}
				$policy = $this->policy->find_by('id',$hh_rec->policy_id);
				echo "Policy = ".$policy->id." (".$policy->counter.")";

			}
		}
	}

	function delete_policy_by_counter($ctr)
	{
		$tx_status = true;
		$this->db->trans_begin();
		if($policy_rec = $this->policy->find_by('counter',$ctr))
		{
			$old_enrolment_status_rec = $this->enrolment_statuse->find_by('policy_id',$policy_rec->id);
			$tx_status = $tx_status AND $old_enrolment_status_rec->delete();
			$house_rec = $this->household->find_by('policy_id',$policy_rec->id);
			$tx_status = $tx_status AND $this->db->query('DELETE from enrolled_members where policy_id="'.$policy_rec->id.'";');
			$tx_status = $tx_status AND $this->db->query('DELETE from persons where household_id="'.$house_rec->id.'";');
			$tx_status = $tx_status AND $house_rec->delete();
			$tx_status = $tx_status AND $this->db->query('DELETE from policies where counter='.$ctr);

			if($tx_status == true)
			{
				$this->db->trans_commit();
				$home_message = "Policy Counter  ".$ctr." Deleted successfully";
				$this->session->set_userdata('msg', $home_message);
				redirect('admin/enrolment/index');

			}
			else {
				$this->db->trans_rollback();
				$home_message = "Policy Counter  ".$ctr." Could not be deleted successfully";
				$this->session->set_userdata('msg', $home_message);
				redirect('admin/enrolment/index');
			}
		}
		else {
			$home_message = "Policy counter  ".$ctr." does not exist";
			$this->session->set_userdata('msg', $home_message);
			redirect('admin/enrolment/index');
		}
	}
	function delete_policy($policy_id) {

		$tx_status = true;
		$this->db->trans_begin();
		if($policy_rec = $this->policy->find($policy_id))
		{
			$old_enrolment_status_rec = $this->enrolment_statuse->find_by('policy_id',$policy_rec->id);
			$tx_status = $tx_status AND $old_enrolment_status_rec->delete();
			$tx_status = $tx_status AND $this->db->query('DELETE from enrolled_members where policy_id="'.$policy_rec->id.'";');

			$tx_status = $tx_status AND $policy_rec->delete();

			if($tx_status == true)
			{
				$this->db->trans_commit();
				$home_message = "Policy ID  ".$policy_id." Deleted successfully";
				$this->session->set_userdata('msg', $home_message);
				redirect('admin/enrolment/index');

			}
			else {
				$this->db->trans_rollback();
				$home_message = "Policy ID  ".$policy_id." Could not be deleted successfully";
				$this->session->set_userdata('msg', $home_message);
				redirect('admin/enrolment/index');
			}
		}
		else {
			$home_message = "Policy ID  ".$policy_id." does not exist";
			$this->session->set_userdata('msg', $home_message);
			redirect('admin/enrolment/index');
		}
	}


	function save_enrolment_details($household, $members, $action) {

		$posted_data = $_POST;
		$tx_status = true;
		$this->db->trans_begin();
		if ($action == "edit")
		{
			$policy_rec = $this->policy->find($posted_data['policy_number']);

			$old_enrolment_status_rec = $this->enrolment_statuse->find_by('policy_id',$policy_rec->id);
			$r2 = $old_enrolment_status_rec->delete();
			$r3 = $this->db->query('DELETE from enrolled_members where policy_id="'.$policy_rec->id.'";');
			if(!($r2 AND $r3))
			{
				$home_message = " Enrolment Status or Enrolled Members could not be deleted. Try Again";
				$this->session->set_userdata('msg', $home_message);
				$tx_status = false;
			}

		}

		$members = $this->data['members'];
		$i = 0;
		$new_enrolled_count = 0;
		$id_of_enrolled_persons = array();
		foreach ($members as $member)
		{
	  $varname = "member".$i."_policy_member";
	  if($posted_data[$varname]=="yes")
	  {
	  	$id_of_enrolled_persons[$new_enrolled_count] = $member->id;
	  	$new_enrolled_count++;

	  	$varname_bg = "member".$i."_blood_group";

	  	$person_rec = $this->person->find($member->id);
	  	$person_rec->blood_group = $posted_data[$varname_bg];
	  	$person_rec->save();
	  	// updating person record with existing blood group / rh factor gives error if the data is the same.
	  }
	  $i++;
		}

		if($action == "add")
		{
			$counter_query = $this->db->query("select MAX(counter) as max_counter from policies");
			$new_id = $counter_query->row()->max_counter + 1;
			$policy_rec = $this->policy->new_record();
			$policy_rec->id = $this->config->item('idcard_org').'BLR-'.$posted_data['policy_type']."-".$new_id;
			//ALA        $policy_rec->id = $this->config->item('idcard_org').$new_id;
		}
		$policy_rec->scheme_id = $posted_data['policy_type'];
		//    if($policy_rec->scheme_id = 3) {$policy_rec->available_amount = "10000";} else {$limit = "30000";}
		$policy_rec->available_amount = $this->policy_type->find($policy_rec->scheme_id)->limit;
		$policy_rec->is_bpl=$posted_data['is_bpl'];
		if($policy_rec->is_bpl=="Yes")
		{
			$policy_rec->bpl_card_number = $posted_data['bpl_card_number'];
			$policy_rec->id_type = "ration card";
		}
		else
		{
			$policy_rec->bpl_card_number = 'NA';
			$policy_rec->id_type = 'NA';
		}

		$policy_id = $policy_rec->id;

		for ($i = 0; $i < $new_enrolled_count; $i++)
		{
			$enrolled_member_rec = $this->enrolled_member->new_record();
			$enrolled_member_rec->policy_id = $policy_id;
			$enrolled_member_rec->person_id = $id_of_enrolled_persons[$i];
			if(!($enrolled_member_rec->save()))
			{
				$home_message = "Enrolled Member Rec could not be saved. Try Again";
				$this->session->set_userdata('msg', $home_message);
				$tx_status = false;
			}
		}
		$enrolment_statuse_rec = $this->enrolment_statuse->new_record();
		$enrolment_statuse_rec->policy_id = $policy_id;
		$enrolment_statuse_rec->staff_id = $posted_data['staff'];

		$enrolment_statuse_rec->id = $posted_data['form_number'];
		$form_date= Date_util::change_date_format($posted_data['form_date']);
		$enrolment_statuse_rec->form_date= $form_date;

		$enrolment_statuse_rec->receipt_number = $posted_data['receipt_number'];
		$receipt_date= Date_util::change_date_format($posted_data['receipt_date']);
		$enrolment_statuse_rec->receipt_date= $receipt_date;

		$time = time();
		$datestring= "%Y-%m-%d";
		$enrolment_statuse_rec->date_of_data_entry = mdate($datestring, $time);

		$enrolment_statuse_rec->amount = $posted_data['amount'];
		$enrolment_statuse_rec->amount_collected = $posted_data['amount_collected'];

		$enrolment_statuse_rec->username = $this->session->userdata('username');

		if($action == 'add')
		{
			$end_date_yy = substr($posted_data['receipt_date'],-4) + 1;
			$end_date_mm = substr($posted_data['receipt_date'],3,2);
			if($end_date_mm == 2) {$end_date_dd = 28;}
			else if($end_date_mm == 4 or $end_date_mm == 6 or $end_date_mm == 9 or $end_date_mm == 11)
			{ $end_date_dd = 30; }
			else {$end_date_dd = 31;}

			$end_date = $end_date_yy.$end_date_mm.$end_date_dd ;
		}
		else
		{
			$end_date = Date_util::change_date_format($posted_data['expiry_date']);
		}
		$policy_rec->policy_end_date = $end_date ;


		if (!($policy_rec->save()))
		{
			$home_message = "Policy Rec could not be saved. Try Again";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}

		if(!($enrolment_statuse_rec->save()))
		{
			$home_message = "Enrolment Status Rec could not be saved. Try Again";
			$this->session->set_userdata('msg', $home_message);
			$tx_status = false;
		}
		// TODO - error checking at each step above

		if($tx_status == true)
		{
			$this->db->trans_commit();
		}
		else {
			$this->db->trans_rollback();
			return false;
		}
		$home_message = "Form No ".$enrolment_statuse_rec->id." Updated successfully with policy id ". $policy_rec->id ;
		$this->session->set_userdata('msg', $home_message);
		return true;
	}

	function add_member() {
		$ln_id = $_POST['id_add'];
		$url = "/admin/enrolment/enroll_partner_members/".$ln_id;
		redirect($url);
	}

	function add_photos() {
		$health_id = $_POST['id_photos'];
	 $url = "/demographic/family/add_photos/".$health_id;
	 redirect($url);
	}

	function add_blood_group() {
		$health_id = $_POST['id_blood'];

	 if( !($household_policy_rec = $this->household->find_by('policy_id',$health_id)))
	 {
	 	$message = "Policy id ".$health_id." is invalid";
	 	$this->session->set_userdata('msg',$message);
	 	redirect('/admin/enrolment/index');
	 	return;
	 }
	 //$policy_id = $household_policy_rec->policy_id;
	 $household_id=$household_policy_rec->id;
	 $url = "/demographic/family/add_blood_group/".$household_id;
	 redirect($url);
	}

	function status_update() {
		$health_id = $_POST['id_update'];
	 $url = "/admin/enrolment/update_policy_status/".$health_id;
	 redirect($url);
	}

	function update_policy_status ($policy_id) {

		if(!( $enrolment_statuse_rec = $this->enrolment_statuse->where('policy_id',$policy_id)->find()))
		{
			$message = "Policy id ".$policy_id." is invalid";
			$this->session->set_userdata('msg',$message);
			redirect('/admin/enrolment/index');
			return;
		}

		$form_number = $enrolment_statuse_rec->id;

		$this->data['current_rec'] = $this->enrolment_statuse->get_all_details('policy_id',$policy_id);
		 
		if (!$_POST) {
			$this->load->view('admin/edit_enrolment_status', $this->data);
			return;
		}
		 
		// Is a post request
		$posted_data = $_POST;

		$enrolment_statuse_rec->idcard_status = $posted_data['idcard_status'];

		$date_submission = Date_util::change_date_format($posted_data['date_of_submission']);
		$enrolment_statuse_rec->date_of_submission= $date_submission;

		$enrolment_statuse_rec->policy_material_status = $posted_data['pm_status'];
		$enrolment_statuse_rec->ack= $posted_data['ack'];
		$enrolment_statuse_rec->backend_issued= $posted_data['backend_status'];

		$policy_rec = $this->policy->find($policy_id);
		$policy_rec->backend_policy_type = $posted_data['backend_type'];
		$policy_rec->backend_policy_number = $posted_data['backend_id'];

		$backend_date = Date_util::change_date_format($posted_data['backend_date']);
		$policy_rec->backend_policy_issuedate = $backend_date;

		$policy_rec->backend_member_id = $posted_data['backend_member_id'];

		$this->db->trans_begin();
		if (!($enrolment_statuse_rec->save()) || !($policy_rec->save()))
		{
			$this->load->view('admin/edit_enrolment_status' , $this->data);
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();
		$message = "Updating enrolment status of policy ".$policy_id." Successful";
		$this->session->set_userdata('msg',$message);
		redirect('/admin/enrolment/index');
	}

	// TODO - fill this function
	// TODO - fill this function
	function new_policy_id() {
		// need to use the policy type in here too
		return "MHF-LBN-BLR-01-000001";
	}


	// Needs to be modified
	function create_insurance_csv()
	{
		// COMMENT(Arvind): Oops -- I had slipped off on how to handle this. Even
		// this action has 2 steps -- one to get the form, and the other to handle
		// the form submit. Should we try and break this into 2 separate actions as
		// well -- one for getting the form, and the other for getting the results
		// Also, the get_csv form should not be a post request -- it should be a
		// get request, since there is no change on the server
		// How about making it 2 separate forms: get_enrolled_families_form, get_enrolled_families - both HTTP Get methods?
		if(isset($_POST['get_csv']))
		{
			$policy_end_date = Date_util::change_date_format($_POST['policy_end_date']);
			$select_list = 'counter, full_name, relation, gender, date_of_birth, is_bpl, bpl_card_number, id_number';
			$from_list = '((policies cross join enrolled_members on policies.id = enrolled_members.policy_id) cross join persons on enrolled_members.person_id = persons.id)';
			$where_list = 'policies.policy_end_date = "'.$policy_end_date.'"';
			$csv_insurance_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list.' ORDER BY counter ASC';
			$query = $this->db->query($csv_insurance_query);
			$csv_insurance_result = $this->dbutil->csv_from_result($query);
			$filename = 'uploads/insurance_file/insurance_file-'.$policy_end_date;
			if(!write_file($filename,$csv_insurance_result))
			{  echo "File could not be written";  }
			else
			{
				$this->output->set_header("HTTP/1.0 200 OK");
				$this->output->set_header("HTTP/1.1 200 OK");
				$this->output->set_header('Content Type: application/csv');
				$this->output->set_header('Cache-control: private');
				$this->output->set_header('Content-Length: '.filesize($filename));
				$this->output->set_header('Content-Disposition: attachement; filename="' . $filename . '"');
			 $this->output->set_header('Pragma: no-cache');
			 $this->output->set_header('Expires: 0');
			 $this->output->set_output($csv_insurance_result);
			}
		}
		else
		{
	  $this->data['policy_end_date'] = 'DD/MM/YYYY';
	  $this->load->view('admin/create_insurance_csv',$this->data);
		}
	}

	function create_report_csv()
	{
		if(isset($_POST['get_csv']))
		{
			$policy_end_date = Date_util::change_date_format($_POST['policy_end_date']);
			$select_list = 'counter, full_name, relation, gender, date_of_birth, is_bpl, bpl_card_number, id_number, scheme_id, amount, amount_collected, staff_id';
			$from_list = 'policies cross join (enrolled_members, persons, enrolment_statuses) ON (policies.id = enrolled_members.policy_id) AND (policies.id = enrolment_statuses.policy_id) AND (enrolled_members.person_id = persons.id)';
			$where_list = 'policies.policy_end_date = "'.$policy_end_date.'"';
			$csv_report_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list.' ORDER BY counter ASC';
			$query = $this->db->query($csv_report_query);
			$csv_report_result = $this->dbutil->csv_from_result($query);
			$filename = 'uploads/report_file/report_file-'.$policy_end_date;
			if(!write_file($filename,$csv_report_result))
			{  echo "File could not be written";  }
			else
			{
				$this->output->set_header("HTTP/1.0 200 OK");
				$this->output->set_header("HTTP/1.1 200 OK");
				$this->output->set_header('Content Type: application/csv');
				$this->output->set_header('Cache-control: private');
				$this->output->set_header('Content-Length: '.filesize($filename));
				$this->output->set_header('Content-Disposition: attachement; filename="' . $filename . '"');
			 $this->output->set_header('Pragma: no-cache');
			 $this->output->set_header('Expires: 0');
			 $this->output->set_output($csv_report_result);

			}
		}
		else
		{
	  $this->data['policy_end_date'] = 'DD/MM/YYYY';
	  $this->load->view('admin/create_report_csv',$this->data);
		}
	}

	function search_policies_by_date()
	{
		if(isset($_POST['search_policies']))
		{

	  	$from_date = Date_util::change_date_format($_POST['from_date']);
	  	$to_date = Date_util::change_date_format($_POST['to_date']);
	  	$values = array();
	  	$this->data['from_date'] = $_POST['from_date'];
	  	$this->data['to_date'] = $_POST['to_date'];

	  	$i=0;
	  	$status_list = $this->enrolment_statuse->find_all_by_sql('select * from enrolment_statuses where date_of_data_entry between "'.$from_date.'" and "'.$to_date.'" ORDER BY policy_id ASC');
	  	//		$status_list = $this->enrolment_statuse->find_all_by_sql('select * from enrolment_statuses where receipt_date between "'.$from_date.'" and "'.$to_date.'" ORDER BY policy_id ASC');
	  	foreach ($status_list as $status_rec)
	  	{

	  		$values[$i]['policy_id'] = $status_rec->policy_id;
	  		$values[$i]['form_number'] = $status_rec->id;
	  		$values[$i]['amount'] = $status_rec->amount_collected;
			
	  		$house_id = $this->household->find_by('policy_id',$status_rec->policy_id);
			if(isset($house_id) && !empty($house_id)){
		  		$hof_person_rec = $this->person->where('household_id',$house_id->id)->where('relation','Self')->find();
		  		$values[$i]['hof_name'] = $hof_person_rec->full_name;
		  		$values[$i]['address'] = $this->village_citie->get_name($house_id->village_city_id);
		  		
			}
	  			
	  		$select_list = 'persons.has_photo as has_photo, persons.image_name as image_name';
	  		$from_list = '(persons cross join enrolled_members on enrolled_members.person_id = persons.id)';
	  		$where_list = 'enrolled_members.policy_id = "'.$status_rec->policy_id.'"';
	  		$has_photo_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list;
	  		$query_res = $this->db->query($has_photo_query);
	  		//	            $image_string = '';
	  		$image_status = array();
	  		$image_names = array();
	  		$j=0;
		   foreach ($query_res->result() as $row_res)
		   {
		   	if($row_res->has_photo=="No")
		   	{ $image_status[$j] = 'N';
			   $image_names[$j] = '';
		   	}
		   	else {
		   		$image_status[$j] = 'Y';
		   		$base_len = strlen($this->config->item('base_path'));
		   		$image_names[$j] = $this->config->item('base_url').substr($row_res->image_name,$base_len);
		   	}
		  	 $j++;
		   }
		   while($j < 7)
		   {
		    $image_status[$j] = '-';
		    $j++;
		   }

		   $values[$i]['images_status'] = $image_status;
		   $values[$i]['images_name'] = $image_names;
		   $i++;
	  	}
	  	$this->data['values'] = $values;
	  	$this->data['total_results'] = $i;
	  	$this->load->view('admin/search_by_date',$this->data);
	  
		}
		else
		{
	  $this->data['from_date'] = 'DD/MM/YYYY';
	  $this->data['to_date'] = 'DD/MM/YYYY';
	  $this->data['total_results'] = '0';
	  $this->load->view('admin/search_by_date',$this->data);
		}
	}

	function search_policies_by_name($key,$module)
	{
		$values = array();
		$location = $this->session->userdata('location_id');
		$this->load->model('opd/provider_location_model', 'provider_location');
		$plocation_rec = $this->provider_location->find($location);
		$vc_code = $plocation_rec->cachment_code;

		$location = $this->session->userdata('location_id');
		if($location !=null)
		{
			$this->load->model('opd/provider_location_model', 'provider_location');
			$plocation_rec = $this->provider_location->find($location);
			$vc_code = $plocation_rec->cachment_code;
			$vc_query = ' village_cities.code="'.$vc_code.'"';
		}
		else
		{
			$provider = $this->provider->find_by('username', $this->session->userdata('username'));
			$loc_recs = $provider->related('provider_locations')->get();
			$i=0;
			$vc_query = '( ';
			foreach($loc_recs as $loc_rec)
			{
				if($i!=0)
				$vc_query .= ' OR ';
				$vc_query .= ' village_cities.code="'.$loc_rec->cachment_code.'" ';
				$i++;
			}
			$vc_query .= ' )';
		}

		$select_list = 'DISTINCT enrolled_members.policy_id';
		$from_list = '(persons,enrolled_members,households,village_cities)';
		$where_list = 'enrolled_members.person_id = persons.id AND households.village_city_id = village_cities.id AND persons.household_id=households.id AND '.$vc_query.' AND persons.full_name LIKE "%'.$key.'%"';
		//	        $where_list = 'enrolled_members.person_id = persons.id AND households.village_city_id = village_cities.id AND persons.household_id=households.id AND village_cities.code="'.$vc_code.'" AND persons.full_name LIKE "%'.$key.'%"';
		//	        $from_list = '(persons cross join enrolled_members on enrolled_members.person_id = persons.id)';
		//	        $where_list = 'enrolled_members.policy_id LIKE "%'.$vc_code.'%" AND persons.full_name LIKE "%'.$key.'%"';
		//ALA	        $where_list = 'persons.full_name LIKE "%'.$key.'%"';
		$name_search_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list.' ORDER BY policy_id ASC';
		$policy_ids = $this->db->query($name_search_query);
		$i=0;
		//		$policy_ids= $this->enrolled_member->is_name($key);
		foreach ($policy_ids->result() as $rec)
		{
			//$policy_rec = $this->policy->find($rec->policy_id);
			//if($policy_rec->status == 'valid')
			//{
				$house_id = $this->household->find_by('policy_id',$rec->policy_id);

				if($house_id!=null)
				{
					$values[$i]['policy_id'] = $rec->policy_id;
					//$values[$i]['valid_date'] = Date_util::to_display($this->policy->get_expiry($rec->policy_id));
					$hof_person_rec = $this->person->where('household_id',$house_id->id)->where('relation','Self')->find();
					$values[$i]['hof_name'] = $hof_person_rec->full_name;
					$values[$i]['address'] = $this->village_citie->get_name($house_id->village_city_id);
					$values[$i]['family_size'] = $this->enrolled_member->family_size($rec->policy_id);					
					$i++;
				}
			//}
		}
		$this->data['values'] = $values;
		$policy_urls = $this->config->item('policy_urls');
		$this->data['link_url'] = $policy_urls[$module];
		$other_actions =& $this->config->item('other_actions');
		$this->data['other_actions'] = $other_actions[$module];
		$this->data['total_results'] = $i;
		$this->load->view('admin/search_by_name',$this->data);
	}

	function search_policies_by_village()
	{
		$village_id = $_POST['village_id'];
		if($village_id !=0)
		{
			$vc_query = ' village_cities.id ="'.$village_id.'"';
		}
		else
		{
			$location = $this->session->userdata('location_id');
			if($location !=null)
			{
				$this->load->model('opd/provider_location_model', 'provider_location');
				$plocation_rec = $this->provider_location->find($location);
				$vc_code = $plocation_rec->cachment_code;
				$vc_query = ' village_cities.code="'.$vc_code.'"';
			}
			else
			{
				$provider = $this->provider->find_by('username', $this->session->userdata('username'));
				$loc_recs = $provider->related('provider_locations')->get();
				$i=0;
				$vc_query = '( ';
				foreach($loc_recs as $loc_rec)
				{
					if($i!=0)
					$vc_query .= ' OR ';
					$vc_query .= ' village_cities.code="'.$loc_rec->cachment_code.'" ';
					$i++;
				}
				$vc_query .= ' )';
			}
		}
		$type	    = $_POST['search_by'];
		$key	    = $_POST['value'];
		$keys = explode(',',$key);
		$key_query='';
		$i=0;
		foreach($keys as $indi)
		{
			$indi = ltrim(rtrim($indi));
			if($i !=0 )
			$key_query .= 'AND ';
			if($type=='name')
			$key_query .= 'persons.full_name ';
			else
			$key_query .= 'households.street_address ';

			$key_query .= 'LIKE "%'.$indi.'%" ';
			$i++;
		}
		$module	    = 'opd';
		$values = array();
		$select_list = 'DISTINCT enrolled_members.policy_id';
		$from_list = '(persons,enrolled_members,households,village_cities)';
		if($type=='name')
		$where_list = 'enrolled_members.person_id = persons.id AND households.village_city_id = village_cities.id AND persons.household_id=households.id AND '.$vc_query.' AND '.$key_query;
		else
		$where_list = 'enrolled_members.person_id = persons.id AND households.village_city_id = village_cities.id AND persons.household_id=households.id AND '.$vc_query.' AND '.$key_query;
		$name_search_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list;
		$policy_ids = $this->db->query($name_search_query);
		$i=0;
		foreach ($policy_ids->result() as $rec)
		{
			//$policy_rec = $this->policy->find($rec->policy_id);
			$house_id = $this->household->find_by('policy_id',$rec->policy_id);
			if( $house_id != null)
			{
				$values[$i]['persons'] = $this->enrolled_member->get_members_by_policy_id($rec->policy_id);
				$values[$i]['policy_id'] = $rec->policy_id;
				$hh_rec = $house_id;
				$values[$i]['address'] = $hh_rec->street_address;
				$values[$i]['village'] = $this->village_citie->get_name($hh_rec->village_city_id);
				$values[$i]['family_size'] = $this->enrolled_member->family_size($rec->policy_id);
				$i++;
			}
		}
		$this->data['values'] = $values;
		$policy_urls = $this->config->item('policy_urls');
		$this->data['link_url'] = $policy_urls[$module];
		$other_actions =& $this->config->item('other_actions');
		//		$this->data['other_actions'] = $other_actions[$module];
		$this->data['other_actions'] = array();
		$this->data['total_results'] = $i;
		$this->load->view('admin/search_by_village',$this->data);
	}

	function simple_match($vc_query, $key)
	{
		$select_list = 'DISTINCT enrolled_members.policy_id';
		$from_list = '(persons,enrolled_members,households,village_cities)';
		$where_list = 'enrolled_members.person_id = persons.id AND households.village_city_id = village_cities.id AND persons.household_id=households.id AND '.$vc_query.' AND persons.full_name LIKE "%'.$key.'%"';
		$name_search_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list.' ORDER BY policy_id ASC';
		$policy_ids = $this->db->query($name_search_query);
		$results=array();
		foreach ($policy_ids->result() as $rec)
		{
			$results[$rec->policy_id]=1;
		}
		return $results;
	}


	function search_policies_by_village_ex()
	{
		$this->load->model('demographic/person_model','person');
		$this->load->helper('soundex');
		$village_id = $_POST['village_id'];
		$street_query='';
		$street_id='';
		if(isset($_POST['street_id'])){
			$street_id = $_POST['street_id'];
		}
		if($village_id !=0){
			$vc_query = ' village_cities.id ="'.$village_id.'"';
			if(!empty($street_id)){
				if($street_id !=0){
					$street_query = ' AND households.street_id=streets.id AND streets.id ="'.$street_id.'"';
				}
			}
		}
		else
		{
			$location = $this->session->userdata('location_id');
			if($location !=null)
			{
				$this->load->model('opd/provider_location_model', 'provider_location');
				$plocation_rec = $this->provider_location->find($location);
				$vc_code = $plocation_rec->cachment_code;
				$vc_query = ' village_cities.code="'.$vc_code.'"';	
			}
			else
			{
				$provider = $this->provider->find_by('username', $this->session->userdata('username'));
				$loc_recs = $provider->related('provider_locations')->get();
				$i=0;
				$vc_query = '( ';
				foreach($loc_recs as $loc_rec)
				{
					if($i!=0)
					$vc_query .= ' OR ';
					$vc_query .= ' village_cities.code="'.$loc_rec->cachment_code.'" ';
					$i++;
				}
				$vc_query .= ' )';
			}
			if(!empty($street_id)){
				if($street_id !=0){
					$street_query = ' AND households.street_id=streets.id AND streets.id ="'.$street_id.'"';
				}
			}
		}
		$name	    = $_POST['name_value'];
		$address = trim($_POST['address_value']);
		$s_address=return_soundex($address, 'ret_normalized_street_address', false);//Normalize only the street address and don't pad with zeros
		$s_name = return_soundex_array($name, 'ret_normalized_name_parts', false);
		$name_append_str="";
		foreach($s_name as $name_part)
		{
			$name_append_str=$name_append_str.' AND persons.name_soundex like "%'.$name_part.'%"';
		}
		$address_append_str=($address=="")?"":' and households.address_soundex like "%'.$s_address.'%"';
		$module	    = 'opd';
		$values = array();
		$select_list = 'DISTINCT enrolled_members.policy_id';
		$from_list = '(persons,enrolled_members,households,village_cities,streets)';
		$where_list = 'enrolled_members.person_id = persons.id AND households.village_city_id = village_cities.id AND persons.household_id=households.id AND '.$vc_query.$street_query.$name_append_str.$address_append_str;

		$name_search_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list;
		$policy_ids = $this->db->query($name_search_query);
		$i=0;
		$simpleResults=$this->simple_match($vc_query, $name);
		$later=array();
		foreach ($policy_ids->result() as $rec)
		{
			if(!array_key_exists($rec->policy_id,$simpleResults))
			{
				$later[]=$rec->policy_id;
				continue;
			}

			//$policy_rec = $this->policy->find($rec->policy_id);
			$house_id = $this->household->find_by('policy_id',$rec->policy_id);
			if( $house_id != null)
			{
				$values[$i]['persons'] = $this->enrolled_member->get_members_by_policy_id($rec->policy_id);
				$values[$i]['policy_id'] = $rec->policy_id;
				$values[$i]['address'] = $house_id->street_address;
				$values[$i]['village'] = $this->village_citie->get_name($house_id->village_city_id);
				$values[$i]['family_size'] = $this->enrolled_member->family_size($rec->policy_id);
				$i++;
			}
		}
		foreach ($later as $rec)
		{

			//$policy_rec = $this->policy->find($rec);
			$house_id = $this->household->find_by('policy_id',$rec);
			if($house_id != null)
			{
				$values[$i]['persons'] = $this->enrolled_member->get_members_by_policy_id($rec);
				$values[$i]['policy_id'] = $rec;
				$values[$i]['address'] = $house_id->street_address;
				$values[$i]['village'] = $this->village_citie->get_name($house_id->village_city_id);
				$values[$i]['family_size'] = $this->enrolled_member->family_size($rec);
				$i++;
			}
		}
		$this->data['values'] = $values;
		$policy_urls = $this->config->item('policy_urls');
		$this->data['link_url'] = $policy_urls[$module];
		$other_actions =& $this->config->item('other_actions');
		$this->data['other_actions'] = array();
		$this->data['total_results'] = $i;
		$this->load->view('admin/search_by_village',$this->data);
	}

	function is_logged_in_user_hew(){
		$user_rec = $this->user->find_by('username' ,$this->username);
		$user_role_rec = $this->user_role->find_all_by('user_id',$user_rec->id );
		$hew_login = true;
		foreach($user_role_rec as $user_role){
			$role_rec = $this->role->find_by('id', $user_role->role_id);
			if($role_rec->name == "Clinician" || $role_rec->name == "Lab Technician" || $role_rec->name=="admin" ){
				$hew_login = false;
				break;
			}
		}
		 
		return $hew_login;
	}
	 
	function search_policy_by_id($module, $key)
	{

		//$this->data["policy"] = $this->policy->find($key);
		$em_recs = $this->enrolled_member->get_members_by_policy_id($key);
		$this->data["persons"] = $em_recs;
		foreach($em_recs as $em_rec)
		{
			$household_id = $this->person->find($em_rec->person_id)->household_id;
			break;
		}

		$this->data["household"] = $this->household->find($household_id);
		if($this->data["household"]->area_id)
		$this->data["area"] = $this->area->find($this->data["household"]->area_id)->name;
		else
		$this->data["area"] = "Not Defined";
		$this->data["village"] = $this->village_citie->find($this->data["household"]->village_city_id)->name;
		$outside_village = $this->data["household"]->outside_catchment_village_name;
		$this->data["is_village_outside"] = $outside_village;

		$policy_url_prefixes = $this->config->item('policy_url_prefixes');
		$this->data["policy_url_prefixes"] = $policy_url_prefixes[$module];

		$hew_login = $this->is_logged_in_user_hew();
		if($hew_login)
		$member_url_prefixes = $this->config->item('member_url_prefixes_hew');
		else
		$member_url_prefixes = $this->config->item('member_url_prefixes');

		$this->data["member_url_prefixes"] = $member_url_prefixes[$module];

		log_message("debug", "loading view");
		$this->load->view("admin/policy_summary", $this->data);

	}

	function search_policy_by_phone_no($module, $key)
	{

		$this->data["household"] = $this->household->find_by('contact_number',$key);
		$policy = $this->policy->where('id',$this->data['household']->policy_id)->find();

		$em_recs = $this->enrolled_member->get_members_by_policy_id($policy->id);
		$this->data["persons"] = $em_recs;

		if($this->data["household"]->area_id)
		$this->data["area"] = $this->area->find($this->data["household"]->area_id)->name;
		else
		$this->data["area"] = "Not Defined";
		$this->data["village"] = $this->village_citie->find($this->data["household"]->village_city_id)->name;


		$policy_url_prefixes = $this->config->item('policy_url_prefixes');
		$this->data["policy_url_prefixes"] = $policy_url_prefixes[$module];

		//$member_url_prefixes = $this->config->item('member_url_prefixes');
		// $this->data["member_url_prefixes"] = $member_url_prefixes[$module];

		log_message("debug", "loading view");
		$this->load->view("admin/policy_summary", $this->data);

	}

	function create_idcard()
	{
		if(isset($_POST))
		{
	  $this->form_validation->set_rules('dateFrom', '"Date From"', 'callback_validate_date');
	  $this->form_validation->set_rules('dateTo', '"Date To"', 'callback_validate_date');
	  $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	  if ($this->form_validation->run() == FALSE)
	  {
	  	//	  $this->data['policy_end_date'] = 'DD/MM/YYYY';
	  	//	  $this->data['search_value'] = 'DD/MM/YYYY';
	  	$this->data['search_value'] = 'id1,id2 OR DD/MM/YYYY';
	  	//	  $this->data['from_date'] = 'DD/MM/YYYY';
	  	//	  $this->data['to_date'] = 'DD/MM/YYYY';
	  	//	  $this->data['issue_date'] = 'DD/MM/YYYY';
	  	$this->load->view('admin/create_id',$this->data);
	  	//	    $this->load->view('admin/create_id');
	  }
	  else
	  {
	  	/*	  	$yyyy_from = $_POST['yyyyFrom'];
	  	 $mm_from = $_POST['mmFrom'];
	  	 $dd_from = $_POST['ddFrom'];
	  	 $yyyy_to= $_POST['yyyyTo'];
	  	 $mm_to= $_POST['mmTo'];
	  	 $dd_to= $_POST['ddTo'];
	  	 $dd_to= $_POST['ddTo'];
	  	 $from_date = $yyyy_from.$mm_from.$dd_from;
	  	 $to_date = $yyyy_to.$mm_to.$dd_to;
	    $issue_date_dd = $_POST['issue_date_dd'];
	    $issue_date_mm = $_POST['issue_date_mm'];
	    $issue_date_yy = $_POST['issue_date_yy'];
	    $issue_date = $issue_date_dd.'-'.$issue_date_mm.'-'.$issue_date_yy; */

	  	//		$from_date = Date_util::change_date_format($_POST['from_date']);
	  	//		$to_date = Date_util::change_date_format($_POST['to_date']);
	  	//		$policy_end_date = Date_util::change_date_format($_POST['policy_end_date']);
	  	$search_value = $_POST['search_value'];
	  	$search_by = $_POST['search_by'];
	  	//		$issue_date = $_POST['issue_date'];
	  	$base_path = $this->config->item('base_path').'uploads/idcard_file/';
	  	//            $filename = $base_path.'id_file-'.$policy_end_date.'.csv';
	  	//            $filename = $base_path.'id_file-'.$from_date.'-'.$to_date.'.csv';

	  	//		$status_list = $this->enrolment_statuse->find_all_by_sql('select * from enrolment_statuses where receipt_date between "'.$from_date.'" and "'.$to_date.'" ORDER BY policy_id ASC');
	  	//		$status_list = $this->enrolment_statuse->find_all_by_sql('select * from enrolment_statuses where date_of_data_entry between "'.$from_date.'" and "'.$to_date.'" ORDER BY policy_id ASC');
	  	//		$policy_list = $this->policy->find_all_by_sql('select * from policies where policy_end_date = "'.$policy_end_date.'" ORDER BY id ASC');
	  	if($search_by == 'ID')
	  	{
	  		$ids = explode(',',$search_value);
	  		$search_str = '("';
	  		for($i=0; $i < count($ids); $i++)
	  		{
	  			if($i!=0) {$search_str = $search_str.',"';}
	  			$search_str = $search_str.$ids[$i].'"';
	  		}
	  		$search_str = $search_str.')';
	  		$policy_list = $this->policy->find_all_by_sql('select * from policies where id in '.$search_str.' ORDER BY id ASC');
	  		$new_search_value = $ids[0];
	  		//		$filename = $base_path.'id_file-'.$search_by.'-'.$new_search_value.'.csv';
	  	}
	  	else
	  	{
	  		$search_value = Date_util::change_date_format($_POST['search_value']);
	  		$policy_list = $this->policy->find_all_by_sql('select * from policies where policy_end_date = "'.$search_value.'" ORDER BY id ASC');
	  		$new_search_value = $search_value;
	  	}
	  	$filename = $base_path.'id_file-'.$search_by.'-'.$new_search_value.'.csv';
	  	$fp = fopen($filename,"w");
	  	$csv_string = '';
	  	foreach ($policy_list as $policy_rec)
	  	{
		   $csv_string = '';
		   $csv_start_string = $csv_string;
		   $policy_id = $policy_rec->id;
		   $issue_date = Date_util::date_display_format($policy_rec->policy_end_date);
		   $csv_string = $csv_string.$issue_date;
		   if($policy_rec->scheme_id == 1) {$limit = "10";} else {$limit = "30";}
		   $csv_string = $csv_string.','.$policy_id;
		   $house_id = $this->household->find_by('policy_id',$policy_rec->id);
		   $hh_id = $this->person->find_by('household_id',$house_id->id)->household_id;
		   $hh_name = $this->person->find_by('household_id',$house_id->id)->full_name;
		   $hh_address = $this->village_citie->get_name($house_id->village_city_id).',\n'.$this->taluka->get_name($house_id->taluka_id).',\n'.$this->district->get_name($house_id->district_id);
		   $csv_string = $csv_string.','.$hh_id.','.$hh_name.',"'.$hh_address.'"';

		   $policy_string = "(''".$policy_id."'')";
		   $select_list = 'image_name, full_name, relation, gender, date_of_birth, blood_group';
		   $from_list = 'enrolled_members cross join persons on enrolled_members.person_id = persons.id';
		   $where_list = "policy_id = '".$policy_id."'";
		   $idcard_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list;
		   $query = $this->db->query($idcard_query);
		   $family_size = $query->num_rows();
		   $csv_string = $csv_string.','.$family_size;
		   $blank_image = $this->config->item('base_path').'uploads/idcard_file/default.jpg';
		   $i = 0;
		   if($query->num_rows() > 0)
		   {
		   	foreach ($query->result() as $row)
		   	{
		   		if(file_exists($row->image_name))
		   		{ $csv_string = $csv_string.','.$row->image_name;}
		   		else
		   		{ $csv_string = $csv_string.','.$blank_image;}

		   		$csv_string = $csv_string.','.$row->full_name;
		   		$csv_string = $csv_string.','.$this->get_gender($row->gender);
		   		$csv_string = $csv_string.',Date of Birth: '.$this->change_date_format($row->date_of_birth);
		   		$csv_string = $csv_string.',Relation: '.$row->relation;
		   		$csv_string = $csv_string.',BG: '.$row->blood_group;
		   		$csv_string = $csv_string.',';
		   		$i++;
		   	}
		   	for(;$i < 7; $i++)
		   	{
		   		$csv_string = $csv_string.','.$blank_image.',,,,,,';
		   	}
		   	$csv_string = $csv_string.','.$limit;
		   	$csv_string = $csv_string."\n";
		   }
		   else
		   { $csv_string = $csv_start_string;}
		   if(!fwrite($fp,$csv_string))
		   {  echo "CSV File could not be written";  }
	  	}
	  	if(!fclose($fp))
	  	{  echo "CSV File could not be closed";  }
	  	else
	  	{
	  		$tmp_filename = 'tmp_id_file.pdf';
	  		$new_filename = 'id_file-'.$search_by.'-'.$new_search_value.'.pdf';
	  		$full_new_filename = $base_path.$new_filename;
	  		$gl_shell_command = '/usr/bin/glabels-batch -i '.$filename.' -o '.$base_path.$tmp_filename.' '.$this->config->item('labels_template');
	  		$gs_shell_command = '/usr/bin/gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/printer -dNOPAUSE -dQUIET -dBATCH -sOutputFile='.$full_new_filename.' '.$base_path.$tmp_filename;
	  			
	  		if(shell_exec($gl_shell_command))
	  		{
	  			shell_exec($gs_shell_command);
	  			{
	  				$this->data['filename'] = $new_filename;
	  				$this->data['search_value'] = $search_value;
	  				$this->load->view('admin/create_id',$this->data);
	  			}
	  		}
	  		else
	  		{
			   echo 'shell command '.$gl_shell_command.' failed and returned ';
	  		}
	  	}
	  }
		}
		else
		{
	  $this->data['search_value'] = 'id1,id2 OR DD/MM/YYYY';
	  $this->load->view('admin/create_id',$this->data);
		}
	}

	function create_sgv_idcard()
	{
		if(isset($_POST['get_idcard']))
		{
			$search_value = $_POST['search_value'];
			$search_by = $_POST['search_by'];
			$base_path = $this->config->item('base_path').'uploads/idcard_file/';
			if($search_by == 'ID')
			{
				$ids = explode(',',$search_value);
				$search_str = '("';
				for($i=0; $i < count($ids); $i++)
				{
					if($i!=0) {$search_str = $search_str.',"';}
					$search_str = $search_str.$ids[$i].'"';
				}
				$search_str = $search_str.')';
				$policy_list = $this->policy->find_all_by_sql('select * from policies where id in '.$search_str.' ORDER BY id ASC');
				$new_search_value = $ids[0];
			}
			else
			{
				$search_value = Date_util::change_date_format($_POST['search_value']);
				$policy_list = $this->policy->find_all_by_sql('select * from policies where policy_end_date = "'.$search_value.'" ORDER BY id ASC');
				$new_search_value = $search_value;
			}
			$filename = $base_path.'id_file-'.$search_by.'-'.$new_search_value.'.csv';
			$fp = fopen($filename,"w");
			$csv_string = '';
			foreach ($policy_list as $policy_rec)
			{
				$csv_string = '';
				$csv_start_string = $csv_string;
				$policy_id = $policy_rec->id;
				$issue_date = Date_util::date_display_format($policy_rec->policy_end_date);
				$csv_string = $csv_string.$issue_date;
				//MAIN		   if($policy_rec->scheme_id == 1) {$limit = "10";} else {$limit = "30";}
				$csv_string = $csv_string.','.$policy_id;
				$house_id = $this->household->find_by('policy_id',$policy_rec->id);
				$hh_id = $this->person->find_by('household_id',$house_id->id)->household_id;
				$hh_name = $this->person->find_by('household_id',$house_id->id)->full_name;
				//MAIN		   $hh_address = $this->village_citie->get_name($hh_rec->village_city_id).',\n'.$this->taluka->get_name($hh_rec->taluka_id).',\n'.$this->district->get_name($hh_rec->district_id);
				$hh_address = $house_id->street_address.',\n'.$this->village_citie->get_name($house_id->village_city_id).',\n'.$this->taluka->get_name($house_id->taluka_id).',\n'.$this->district->get_name($house_id->district_id);
				//		   $hh_address = str_replace(",^M","\n",$hh_lbn_address);
				//MAIN		   $csv_string = $csv_string.','.$hh_id.','.$hh_name.',"'.$hh_address.'"';
				$area_name = $this->area->get_name($house_id->area_id);
				$csv_string = $csv_string.',"'.$area_name.'","'.$hh_name.'","'.$hh_address.'"';

				$policy_string = "(''".$policy_id."'')";
				$select_list = 'full_name, relation, gender, age';
				//MAIN		   $select_list = 'image_name, full_name, relation, gender, date_of_birth, blood_group';
				$from_list = 'enrolled_members cross join persons on enrolled_members.person_id = persons.id';
				$where_list = "policy_id = '".$policy_id."'";
				$idcard_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list;
				$query = $this->db->query($idcard_query);
				$family_size = $query->num_rows();
				$csv_string = $csv_string.','.$family_size;
				$blank_image = $this->config->item('base_path').'uploads/idcard_file/default.jpg';
				$i = 0;
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{
						//MAIN			 if(file_exists($row->image_name))
						//MAIN		         { $csv_string = $csv_string.','.$row->image_name;}
						//MAIN			 else
						//MAIN		         { $csv_string = $csv_string.','.$blank_image;}

						//MAIN		         $csv_string = $csv_string.','.$row->full_name;
						//MAIN		         $csv_string = $csv_string.','.$this->get_gender($row->gender);
						//MAIN		         $csv_string = $csv_string.',Date of Birth: '.$this->change_date_format($row->date_of_birth);
						//MAIN		         $csv_string = $csv_string.',Relation: '.$row->relation;
						//MAIN		         $csv_string = $csv_string.',BG: '.$row->blood_group;
						//		         $csv_string = $csv_string.','.$row->rh_factor;
						$csv_string = $csv_string.',"'.($i+1).'. '.$row->full_name.'"';
						$csv_string = $csv_string.','.$row->gender;
						$csv_string = $csv_string.',"'.$row->age.' yrs"';
						$csv_string = $csv_string.','.$row->relation;
						//MAIN		         $csv_string = $csv_string.',';
						$i++;
			 }
			 //MAIN             for(;$i < 7; $i++)
			 for(;$i < 12; $i++)
			 {
			 	//MAIN		         $csv_string = $csv_string.','.$blank_image.',,,,,,';
			 	$csv_string = $csv_string.',,,,';
			 }
			 //MAIN			 $csv_string = $csv_string.','.$limit;
			 $csv_string = $csv_string."\n";
			}
			else
			{ $csv_string = $csv_start_string;}
			if(!fwrite($fp,$csv_string))
			{  echo "CSV File could not be written";  }
		}
		if(!fclose($fp))
		{  echo "CSV File could not be closed";  }
		else
		{
			//	        $message = 'Id card file named '.$filename.' created successfully';
			//	        $this->session->set_userdata('msg',$message);
			$tmp_filename = 'tmp_id_file.pdf';
			//			$new_filename = 'id_file-'.$from_date.'-'.$to_date.'.pdf';
			//			$new_filename = 'id_file-'.$policy_end_date.'.pdf';
			$new_filename = 'id_file-'.$search_by.'-'.$new_search_value.'.pdf';
			$full_new_filename = $base_path.$new_filename;
			$gl_shell_command = '/usr/bin/glabels-batch -i '.$filename.' -o '.$base_path.$tmp_filename.' '.$this->config->item('labels_template');
			$gs_shell_command = '/usr/bin/gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/printer -dNOPAUSE -dQUIET -dBATCH -sOutputFile='.$full_new_filename.' '.$base_path.$tmp_filename;
				
			if(shell_exec($gl_shell_command))
			{
				/*
				 $this->output->set_header("HTTP/1.0 200 OK");
				 $this->output->set_header("HTTP/1.1 200 OK");
				 $this->output->set_header('Content Type: application/pdf');
				 $this->output->set_header('Cache-control: private');
				 $this->output->set_header('Content-Length: '.filesize($output_filename));
				 $this->output->set_header('Content-Disposition: attachement; filename="' . $output_filename . '"');
			 	$this->output->set_header('Pragma: no-cache');
			 	$this->output->set_header('Expires: 0');

			 	$this->output->set_output(readfile($output_filename));*/
				//			  if(shell_exec($gs_shell_command))
				shell_exec($gs_shell_command);
				{
					$this->data['filename'] = $new_filename;
					//				$this->data['policy_end_date'] = $_POST['policy_end_date'];
					$this->data['search_value'] = $search_value;
					//				$this->data['from_date'] = $_POST['from_date'];
					//				$this->data['to_date'] = $_POST['to_date'];
					//				$this->data['issue_date'] = $_POST['issue_date'];
					$this->load->view('admin/create_id',$this->data);
				}
				/*		  else
			  {
			  echo 'shell command '.$gs_shell_command.' failed and returned ';
			  }*/

			}
			else
			{
				echo 'shell command '.$gl_shell_command.' failed and returned ';
				// redirect('/admin/enrolment/index');
			}

		}
	}
	else
	{
		//	  $this->data['policy_end_date'] = 'DD/MM/YYYY';
		$this->data['search_value'] = 'id1,id2 OR DD/MM/YYYY';
		//	  $this->data['from_date'] = 'DD/MM/YYYY';
		//	  $this->data['to_date'] = 'DD/MM/YYYY';
		//	  $this->data['issue_date'] = 'DD/MM/YYYY';
		$this->load->view('admin/create_id',$this->data);
		//	  $this->load->view('admin/create_id');
	}
}

function print_risk_cards_2_x_4($filename, $startnum=0, $endnum=0, $prefix)
 
{
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT,true, 'UTF-8', false);
	 
	$BARCODE_NUMBER_FONT = 9;
	$BARCODE_HEIGHT = 20;
	$BARCODE_RESOLUTION = 0.65;
	$X_OFFSET_1 = 10; //Where on the page does the first card start
	$X_OFFSET_2 = 110; //...and the second one
	$BOX_WIDTH = 87;
	$BOX_HEIGHT = 59;
	$NO_OF_IDS_ON_PAGE = 8;
	$IMAGE_WIDTH = 81;
	$IMAGE_HEIGHT = 44;
	 
	$GAP_BETWEEN_CARDS = 4;
	$GAP_END_OF_LINE = 45;
	 
	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, 10);
	$pdf->AddPage();
	$style = array(
                          'position' => '',
                          'align' => 'C',
                          'stretch' => false,
                          'fitwidth' => true,
                          'cellfitalign' => '',
                          'border' => false,
                          'hpadding' => 'auto',
                          'vpadding' => 'auto',
                          'fgcolor' => array(0,0,0),
                          'bgcolor' => false,
                          'text' => true,
                          'font' => 'helvetica',
                          'fontsize' => $BARCODE_NUMBER_FONT,
                          'stretchtext' => 4
	);
	 
	$ctrinpage = 0;
	$y1 = '';
	for($i=$startnum; $i<=$endnum; $i++)
	{
		 
		if($ctrinpage%2==0)
		$y1 =$pdf->getY();
		$yoffset = ($ctrinpage%2==0)?$pdf->getY():$y1;
		$xoffset = ($ctrinpage%2==0)?$X_OFFSET_1:$X_OFFSET_2;
		// Image example with resizing
		 
		$pdf->write1DBarcode($prefix.sprintf("%04s",$i), 'C128A', $xoffset,$yoffset, '', $BARCODE_HEIGHT, $BARCODE_RESOLUTION, $style,'N');
		 
		$y2 = $pdf->getY()-3;
		$pdf->Image($filename, $xoffset, $y2, $IMAGE_WIDTH,$IMAGE_HEIGHT, 'JPEG', '', '', true, 300, 'T', false, false, 0, true,false, false);
		 
		 
		$ctrinpage++;
		 
		$pdf->Rect($xoffset-2, $y1+2, $BOX_WIDTH, $BOX_HEIGHT);
		$pdf->Ln($GAP_BETWEEN_CARDS );
		if($ctrinpage %$NO_OF_IDS_ON_PAGE ==0 && $i!=$endnum)
		{
			$pdf->AddPage();
			$y1='';
			$y2='';
		}
		else
		$pdf->Ln($GAP_END_OF_LINE);
		 
	}
	ob_clean();
	$pdf->Output('idcard.pdf', 'I');
}
function print_ids_2_x_4($filename, $startnum=0, $endnum=0)
{
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$BARCODE_NUMBER_FONT = 9;
	$BARCODE_HEIGHT = 20;
	$BARCODE_RESOLUTION = 0.85;
	$X_OFFSET_1 = 10; //Where on the page does the first card start
	$X_OFFSET_2 = 110; //...and the second one
	$BOX_WIDTH = 87;
	$BOX_HEIGHT = 59;
	$NO_OF_IDS_ON_PAGE = 8;
	$IMAGE_WIDTH = 81;
	$IMAGE_HEIGHT = 45.2;
	$GAP_BETWEEN_CARDS = 4;
	$GAP_END_OF_LINE = 45;

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, 10);
	$pdf->AddPage();
	$style = array(
			'position' => '',
			'align' => 'C',
			'stretch' => false,
			'fitwidth' => true,
			'cellfitalign' => '',
			'border' => false,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, 
			'text' => true,
			'font' => 'helvetica',
			'fontsize' => $BARCODE_NUMBER_FONT,
			'stretchtext' => 4
	);

	$ctrinpage = 0;
	$y1 = '';
	for($i=$startnum; $i<=$endnum; $i++)
	{

		if($ctrinpage%2==0)
		$y1 =$pdf->getY();
		$yoffset = ($ctrinpage%2==0)?$pdf->getY():$y1;
		$xoffset = ($ctrinpage%2==0)?$X_OFFSET_1:$X_OFFSET_2;
		// Image example with resizing
			
		$pdf->write1DBarcode(sprintf("%04s",$i), 'C128A', $xoffset, $yoffset, '', $BARCODE_HEIGHT, $BARCODE_RESOLUTION, $style,'N');
			
		$y2 = $pdf->getY()-3;
		$pdf->Image($filename, $xoffset, $y2, $IMAGE_WIDTH, $IMAGE_HEIGHT, 'JPEG', '', '', true, 300, 'T', false, false, 0, true, false, false);
		$ctrinpage++;
			
		$pdf->Rect($xoffset-2, $y1+2, $BOX_WIDTH, $BOX_HEIGHT);
		$pdf->Ln($GAP_BETWEEN_CARDS );
		if($ctrinpage %$NO_OF_IDS_ON_PAGE ==0 && $i!=$endnum)
		{
			$pdf->AddPage();
			$y1='';
			$y2='';
		}
		else
		$pdf->Ln($GAP_END_OF_LINE);
			
	}
	ob_clean();
	$pdf->Output('idcard.pdf', 'I');
}

function create_voucher()
{
	if(!$_POST)
	$this->load->view('admin/create_voucher');
	else
	{
		$msg = "";
			
		//Check if the file type is png
		if($_POST['start_num']>$_POST['end_num'])
		$msg = "Start number should be greater than the end number";
		else if($_POST['end_num']-$_POST['start_num']>3000)
		$msg = "Only 3000 vouchers can be printed at a time. Please try again.";
			
		if($msg =="")
		{
			echo "Success";
			echo $_FILES['uploadedfile']['error'];
			echo $_FILES['uploadedfile']['tmp_name'];
			//Then it is a success
			$this->print_ids_2_x_4($_FILES['uploadedfile']['tmp_name'],$_POST['start_num'],$_POST['end_num']);
		}
		else
		{
			$this->session->set_userdata('msg',$msg);
			redirect('/admin/enrolment/index');
		}
	}
}
function create_risk_card()
{
	if(!$_POST)
	$this->load->view('admin/create_risk_card');
	else
	{
		$msg = "";

		//Check if the file type is png
		if($_POST['start_num']>$_POST['end_num'])
		$msg = "Start number should be greater than the end number";
		else if($_POST['end_num']-$_POST['start_num']>3000)
		$msg = "Only 3000 vouchers can be printed at a time. Please try again.";

		if($msg =="")
		{
			echo "Success";
			echo $_FILES['uploadedfile']['error'];
			echo $_FILES['uploadedfile']['tmp_name'];
			//Then it is a success
			$this->print_risk_cards_2_x_4($_FILES['uploadedfile']['tmp_name'],$_POST['start_num'],$_POST['end_num'],$_POST['prefix']);
		}
		else
		{
			$this->session->set_userdata('msg',$msg);
			redirect('/admin/enrolment/index');
		}
	}
}

function import_enrolment_data()
{
	if(!$_POST)
	{
		//get teh geo data
		$this->load->model('geo/state_model','state');
		$this->load->model('geo/district_model','district');
		$this->load->model('geo/taluka_model','taluka');
		$this->load->model('opd/provider_location_model','location');
		$finalstring = "";
		if($states = $this->state->find_all())
		{
			foreach($states as $s)
			{
				$finalstring.= '"'.$s->name.'": ['.$s->id.',{';
				if($district_list = $this->district->find_all_by('state_id',$s->id))
				{
					foreach($district_list as $district)
					{
						$finalstring.= '"'.$district->name.'": ['.$district->id.', {';
						if($taluka_list = $this->taluka->find_all_by('district_id', $district->id))
						{
							foreach($taluka_list as $taluka)
							{
								$finalstring.= '"'.$taluka->name.'":'.$taluka->id.',';
							}
						}
						$finalstring.='}],';
					}
				}
				$finalstring.='}],';
			}
		}
		$locations = $this->location->get_all_clinic_suffixes();
		$this->load->view('admin/import_enrolment_data',array('geo_tree'=>$finalstring, 'clinics'=>$locations));
	}
	else
	{
		//now open the files and parse the contents
		$localhpath = $this->__make_local_copy($_FILES,"householdfile");
		$localipath = $this->__make_local_copy($_FILES,"individualfile");
			
		//For the first pass we only need the household file, because
		//we attempt to create the geo hierarchy
		$map = $this->__convert_csv_to_map($localhpath);
		if($map == null)
		{
			$this->session->set_userdata('msg',"Invalid file!");
			redirect('admin/enrolment/index');
		}
		$v_sum = $this->__return_villages_summary($map, $this->input->post('s_taluka'));
		$data = $v_sum;
		$data['target']=base_url()."index.php/admin/enrolment/analyze_import_file";
		$data['hfilepath']=$localhpath;
		$data['ifilepath']=$localipath;
		$data['taluka_id'] =$this->input->post('s_taluka');
		$data['rmhc_code']= $this->input->post('rmhc_location');
		$this->load->view('admin/create_villages', $data);
	}
}

function __make_local_copy($filearr, $type)
{
	$tmppath = $filearr[$type]['tmp_name'];
	if(trim($tmppath)=="")
	return "";
	$contents = file_get_contents($tmppath);
	$filetype = $filearr[$type]['type'];
	if($filetype=='application/x-bzip')
	$contents =  bzdecompress($contents);
	$targetfile=$this->config->item('base_path').'uploads/enrolment/'.$type.time(true);
	$fp2 = fopen($targetfile,"w");
	fwrite($fp2, $contents);
	fclose($fp2);
	return $targetfile;
}
function analyze_import_file()
{
	if($_POST)
	{
		$this->load->model('geo/village_citie_model', 'village_city');
		$hfile = $this->input->post('hfilepath');
		$ifile = $this->input->post('ifilepath');
			
		//First create the villages here
		$map = $this->__convert_csv_to_map($hfile);
		if($map == null)
		{
			$this->session->set_userdata('msg',"Invalid file!");
			redirect('admin/enrolment/index');
		}
		$v_sum = $this->__return_villages_summary($map, $this->input->post('s_taluka'));
		if(array_key_exists('new', $v_sum))
		{
			foreach($v_sum['new'] as $newvillage)
			{
				$vc_rec = $this->village_city->new_record();
				$vc_rec->taluka_id = $this->input->post('s_taluka');
				$vc_rec->code = $this->input->post('rmhc_code');
				$vc_rec->name = $newvillage;
				$vc_rec->save();
			}
		}
		$ret = $this->__consolidate_households($hfile, $ifile);
		$ret['target']=base_url()."index.php/admin/enrolment/create_household_from_files";
		$ret['hfilepath']=$hfile;
		$ret['ifilepath']=$ifile;
		$ret['taluka_id'] =$this->input->post('s_taluka');
		$ret['rmhc_code']= $this->input->post('rmhc_code');
		$this->load->view('admin/examine_import_files',$ret);
	}
	else
	redirect('admin/enrolment');
}
function create_household_from_files()
{
	if($_POST)
	{
		$hfile = $this->input->post('hfilepath');
		$ifile = $this->input->post('ifilepath');
		$ret = $this->__consolidate_households($hfile, $ifile);
		$prefix = trim($this->input->post('rmhc_code'))."001"; //This prefix is added to the cardnum to get the policy id
		$taluka_id = $this->input->post('taluka_id');
		$existing_policies = array();
		$created_policies = array();
		$aborted_policies = array();
		$village_not_exist = array();

		$village_ids=array();
		foreach($ret['hhmap'] as $hhid=>$details)
		{
			$policy_id = $prefix.sprintf("%04s",trim($details['cardnum']));

			//Now check if that policy exists
			if($this->policy->find_by('id',$policy_id))
			{
				$existing_policies[]=$policy_id;
				continue;
			}

			//The policy doesn't exist. Create it
			$details['taluka_id'] = $taluka_id;
			$details['policy_id'] = $policy_id;

			//Cache the village_city id to reduce db hits
			$village_city_id = 0;
			if(array_key_exists($details['village'],$village_ids))
			{
				$village_city_id = $village_ids[$details['village']];
			}
			else // Find it from the db
			{
				if($vc = $this->village_citie->find_by(array('taluka_id','name'), array($taluka_id,$details['village'])))
				{
					$village_city_id=$vc->id;
					$village_ids[$details['village']]=$village_city_id;
				}
				else
				{
					if(!array_key_exists($details['village'],$village_not_exist))
					$village_not_exist[$details['village']]=true;
				}
			}
			$details['village_city_id']=$village_city_id;
			$this->db->trans_begin();
			if($this->policy->create($details))
			{
				$created_policies[]=$policy_id;
				$this->db->trans_commit();
			}
			else
			{
				$aborted_policies[]=$policy_id;
				$this->db->trans_rollback();
			}
		}
		$data=array('existing_policies'=>$existing_policies,
					'created_policies'=>$created_policies,
					'aborted_policies'=>$aborted_policies,
					'village_not_exist'=>$village_not_exist);
		$this->load->view('admin/import_policies',$data);
	}
	else
	redirect('admin/enrolment');
}


function __consolidate_households($hfile, $ifile)
{
	$hmap = $this->__convert_csv_to_map($hfile);
	$imap = $this->__convert_csv_to_map($ifile);
	$finalhhmap = array();
	$orphanedindis = array();
	$missinghh=array();
	//Now copy the imap to the hmap
	foreach($hmap as $hh)
	{
		$hh['individuals']=array();
		$finalhhmap[$hh['id']]=$hh;
	}

	foreach($imap as $indi)
	{
		$hhid = $indi['enrol_household_id'];
		if(array_key_exists($hhid,$finalhhmap))
		{
			$finalhhmap[$hhid]['individuals'][]=$indi;
		}
		else
		{
			$orphanedindis[]=$indi['id'];
			$missinghh[]=$hhid;
		}
	}
	return array('hhmap'=>$finalhhmap, 'orphan_individuals'=>$orphanedindis,'missing_hh'=>$missinghh);
}

//Returns a map with two indices
//'present'=>array(villages that already exist)
//'new'=>'array('villages that will be created newly')
function __return_villages_summary($hh_records, $taluka_id)
{
	$this->load->model('geo/village_city_model','vc');
	//get unique list of villages
	$master_map=array();
	$return_map = array();
	foreach($hh_records as $rec)
	{
		$v_name = trim($rec['village']);
		if(!array_key_exists($v_name,$master_map))
		{
			if($this->vc->village_exists($taluka_id,$v_name))
			{
				$master_map[$v_name]='present';
			}
			else
			{
				$master_map[$v_name]='new';
			}

		}
	}
	foreach($master_map as $k=>$v)
	{
		if(!array_key_exists($v, $return_map))
		$return_map[$v]=array();
		$return_map[$v][]=$k;
	}
	return $return_map;
}

//Assumes a header row in the csv
function __convert_csv_to_map($filename, $normalize_func=null,$delimiter=',', $enclosure='"' )
{
	if(!$temp=fopen($filename, "r"))
	return null;
	while (($data = fgetcsv($temp, 4096, $delimiter, $enclosure)) !== false) {
		$r[] = $data;
	}
	$temp=fopen("php://memory", "rw");
	$bFirst = true;
	$cols = array();
	$map=array();
	foreach($r as $line)
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
			if(count($line) == count($cols))
			{
				foreach($line as $field)
				{
					$record[$cols[$ctr]]=$field;
					$ctr++;
				}
				//Record has been constructed. We may have to normalize it
				if($normalize_func==null)
				$map[]=$record;
				else
				$map[]=$this->{$normalize_func}($record);
			}
		}
	}
	return $map;
}

function create_enrollment_csv()
{
	//    if(isset($_POST['get_csv']))
	//    {
	//		$select_list = 'households.id as hid,door_no, street_address,area_id,village_city_id, persons.id AS pid, full_name, relation, gender, date_of_birth';
	//		$select_list = 'households.id as hid, street_address,area_id,village_city_id, persons.id AS pid, full_name, relation, gender, date_of_birth';
		$select_list = 'policy_id as hid, street_address,area_id,village_city_id, persons.organization_id AS pid, full_name, relation, gender, date_of_birth';
		$from_list = '(households cross join persons on households.id = persons.household_id)';
		$where_list = '1';
		$csv_enrollment_query = 'SELECT '.$select_list.' FROM '.$from_list.' WHERE '.$where_list.' ORDER BY hid ASC';
		//		echo " query ".$csv_enrollment_query;
		$query = $this->db->query($csv_enrollment_query);
		$csv_enrollment_result = $this->dbutil->csv_from_result($query);
		//		echo "query output ".$csv_insurance_result;
		$filename = 'uploads/idcard_file/enrollment_file';
		$fp = fopen($filename, "w");
		$csv_string = '';
		$hid = 0;
		$count = 0;
		foreach($query->result() as $rec)
		{

			$age = 2010 - substr($rec->date_of_birth,0,4);
			if($age > 18)
			{
				$age_grp = "Adult";
			}
			else if ($age < 2)
			{ $age_grp = "Infant";}
			else if ($age < 10)
			{$age_grp = "Child";}
			else {$age_grp = "Adolescent";}

			if($rec->hid != $hid)
			{
				if($hid !=0)
				{
					for ($i=$count+1; $i<12; $i++)
					{
						$csv_string = $csv_string.',99'.$hid.$i.',,,M / F, ';
					}
					$csv_string = $csv_string."\n";
					fwrite($fp,$csv_string);
				}
				$hid = $rec->hid;
				$csv_string = "";

				$village_name = $this->village_citie->get_name($rec->village_city_id);
				//				$csv_string = $csv_string.$hid.','.$rec->door_no.','.$rec->street_address.','.$village_name;
				$csv_string = $csv_string.$hid.',,"'.$rec->street_address.'",'.$village_name;

				$csv_string = $csv_string.','.$rec->pid.','.$rec->full_name.','.$age_grp.','.$rec->gender.','.$rec->relation;
				$count = 1;
			}
			else
			{
				/*				$age = 2010 - substr($rec->date_of_birth,0,4);
				 if($age > 18)
				 {
					$age_grp = "Adult";
					}
					else if ($age < 5)
					{ $age_grp = "Infant";}
					else {$age_grp = "Child";}*/
				$csv_string = $csv_string.','.$rec->pid.','.$rec->full_name.','.$age_grp.','.$rec->gender.','.$rec->relation;
				$count = $count + 1;
			}
		}

		fwrite($fp,"\n");

		if(!fclose($fp))
		{  echo "File could not be closed";  }
		$message = 'Enrollment CSV file named '.$filename.' created successfully';
		$this->session->set_userdata('msg',$message);
		redirect('/admin/enrolment/index');
		/*		if(!write_file($filename,$csv_enrollment_result))
		 else
		 {
		 $this->output->set_header("HTTP/1.0 200 OK");
		 $this->output->set_header("HTTP/1.1 200 OK");
		 $this->output->set_header('Content Type: application/csv');
		 $this->output->set_header('Cache-control: private');
		 $this->output->set_header('Content-Length: '.filesize($filename));
		 $this->output->set_header('Content-Disposition: attachement; filename="' . $filename . '"');
		 $this->output->set_header('Pragma: no-cache');
		 $this->output->set_header('Expires: 0');
		 $this->output->set_output($csv_enrollment_result);

		 $message = 'Insurance CSV file named '.$filename.' created successfully';
		 //       $this->session->set_userdata('msg',$message);
		 //       redirect('/admin/enrolment/index');
		 }*/
		/*    }
		 else
		 {
	  $this->load->view('admin/create_enrollment_csv');
	  }*/
	}

	private function change_date_format($orig_date)
	{
		//     $return_date = substr($orig_date,;
		$dd = substr($orig_date,-2);
		$mm = substr($orig_date,5,2);
		$yyyy = substr($orig_date,0,4);
		return $dd.'-'.$mm.'-'.$yyyy ;

		//     return $orig_date;
	}

	private function get_gender ($gender_code)
	{
		if(($gender_code == "M") || ($gender_code =="Male"))
		{return "Male";}
		if(($gender_code == "F") || ($gender_code =="Female"))
		{return "Female";}

		return $gender_code;
	}

	/*
	 private  function birth_date_adjust() // adjust_birth_date
	 {

	 $date_arr =  $this->input->post('bdate');

	 foreach ($date_arr as $key => $value)
	 {
	 if(ctype_digit($value))
	 {
	 $_POST['age'][$key] = $value;
	 $_POST['date_of_birth'][$key] = date("Y-m-d");
	 }
	 else
	 {
	 $_POST['age'][$key] = 0;
	 $_POST['date_of_birth'][$key] = $value;
	 }
	 }
	 }
	 */

	/**
	 * funtion is used to validate date
	 *
	 * @param unknown_type $bdate : is date of birth
	 * @return TRUE if date is valid , FALSE if date is not valid
	 */
	function  date_age_check($bdate) // check_date_age
	{
		echo "<br> ".$bdate;

		if ($bdate == '')
		{
			return TRUE;
		}
		else
		{
			$date_arr = explode('-', $bdate);

			if(count($date_arr) == 3)
	  {
	  	$y = $date_arr[0];
	  	$m = $date_arr[1];
	  	$d = $date_arr[2];
	  	if(ctype_digit($bdate) && $bdate > 0 && $bdate < 120)
	  	{
	  		return TRUE;
	  	}
	  	elseif (checkdate($m,$d,$y))
	  	{
	  		return TRUE;
	  	}
	  	else
	  	{
	  		$this->form_validation->set_message('bdate[]', 'The %s is not a valid Date or Age format');
	  		return FALSE;
	  	}
	  }
	  else
	  {
	  	$this->form_validation->set_message('bdate[]', 'The %s is not a valid Date or Age format');
	  	return FALSE;
	  }
		}
	}

	/**
	 * get_all_dropdown() : used to get list of village , taluka , distrct sakhi for showing in
	 * dropdown on step_one of enrolment from. function only sets values to data variable which
	 *
	 */
	private function get_all_dropdown()
	{
		$this->data['area_list'] = $this->area->get_names();
		$this->data['village_list'] = $this->village_citie->get_names();
		$this->data['taluka_list'] = $this->taluka->get_names();
		$this->data['district_list'] = $this->district->get_names();
		$this->data['staff'] = $this->staff->get_names();
	}

	/**
	 * function resotore_values_step_one is used to restore values when user enter wrong data while filling step_one form
	 * this function simply assign values to data array
	 */
	/*
	 private function restore_values_enrolled_family()
	 {
	 */
	/*$this->data['village_id'] = $this->input->post('village_id');
		$this->data['district_id'] = $this->input->post('district_id');
		$this->data['taluka_id'] = $this->input->post('taluka_id');
		$this->data['sakhi_id'] = $this->input->post('sakhi_id');*/
	/*
		$main = array();
		$temp = array();
		$main['village_id'] = $this->input->post('village_id');
		$main['district_id'] = $this->input->post('district_id');
		$main['taluka_id'] = $this->input->post('taluka_id');
		$main['sakhi_id'] = $this->input->post('sakhi_id');
		$main['is_shg_member'] = $this->input->post('is_shg_member');
		$main['form_number'] = $this->input->post('form_number');
		$main['date_of_enrolment'] = $this->input->post('date_of_enrolment');
		$main['contact_number'] = $this->input->post('contact_number');
		$main['house_location'] = $this->input->post('house_location');
		$main['annual_income'] = $this->input->post('annual_income');
		$main['annual_savings'] = $this->input->post('annual_savings');
		$main['id_type'] = $this->input->post('id_type');
		$main['id_number'] = $this->input->post('id_number');
		$main['caste'] = $this->input->post('caste');
		$main['religion'] = $this->input->post('religion');
		$main['is_own_number'] = $this->input->post('is_own_number');
		$main['bpl_card_number'] = $this->input->post('bpl_card_number');
			

		$this->data['main'] = $main;

		$addiction =  $this->input->post('addictions');
		$full_name = $this->input->post('full_name');
		$date_of_birth = $this->input->post('bdate');
		$marital_status = $this->input->post('marital_status');
		$gender = $this->input->post('gender');
		$relation = $this->input->post('relation');
		$education = $this->input->post('education');
		$income_source = $this->input->post('income_source');

		for($i=0; $i<=6; $i++)
		{
		$temp['addictions'] = $addiction[$i];
		$temp['full_name'] = $full_name[$i];
		$temp['date_of_birth'] = $date_of_birth[$i];
		$temp['relation'] = $relation[$i];
		$temp['education'] = $education[$i];
		$temp['income_source'] = $income_source[$i];
			
		if(isset($marital_status[$i]))
		$temp['marital_status'] = $marital_status[$i];
			
		if(isset($gender[$i]))
		$temp['gender'] = $gender[$i];
			
		$this->data['member_details'][] = $temp;
		}

		}


		private function set_family_details()
		{
		$fam_detils = $this->family->get_family_details($this->family_id);
		$members = $this->person->get_member_details($this->family_id);
		foreach ($fam_detils[0] as $key=>$value) {
		$this->data[$key] = $value;
		}
		$i=0;

		foreach ($members as &$member) {
		$this->data['member'.$i] = $member;
		$i++;
		}
		}

		private  function set_policy_id()
		{
		$area_type = $this->input->post('areaType');
		$policy_code = $this->family->create_policy_code($this->input->post('district_id'));
		//<Partner-Code>-<District Code>-<Urban/Rural>-<SchemeType>-<Autonumber>
		//Eg. SSP-LUR-R-23-000042
		$_POST['policy_number'] = $policy_code;

		}
			
		function edit_enrolled_family(){


		if(!isset($_POST['submit'])){
		$this->data['title'] = "Add new enrolled family";
		$family_data = array();
		$family_enrolment_data = array();
		$this->get_all_dropdown();
		$this->load->view('admin/edit_enrolled_family', $this->data);
		return;
		}


	 $this->form_validation->set_rules('form_number', 'Form number', 'required|max_length[32]');
	 $this->form_validation->set_rules('date_of_enrolment', 'Date of Enrolment', 'required|max_length[11]');
	 $this->form_validation->set_rules('family_head', 'Family head', 'required');
	 $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	 if ($this->form_validation->run() == FALSE) {
	 $this->get_all_dropdown();
	 $this->restore_values_enrolled_family();
	 $this->load->view('edit_enrolled_family', $this->data);
	 return;
	 }

	 if (!isset($_POST['is_edit'])) {   //if add
	 $this->set_policy_id();
	 $this->birth_date_adjust();
	 $this->family_id = $_POST['family_id'] = $this->family->save_family_details();
	 $this->enrollment->save_family_enrollment_details();
	 $this->person->save_person_details($_POST['family_id']);


	 }
	 else // if edit
	 {

	 $this->birth_date_adjust();
	 $this->family_id = $this->input->post('family_id');
	 $condition = "family_id = {$this->family_id}";

	 $this->family->save_family_details($condition);
	 $this->enrollment->save_family_enrollment_details($condition);
	 $this->person->save_person_details();
	 }

	 if (!isset($_POST['is_edit']))
	  
	 redirect('/family/add_family_history/'.$this->family_id);

	 else
	 {
	 $back_to = $this->input->post('back_to');
	 if ($back_to == 'normal')
	 redirect('/family/edit_family_history/'.$this->family_id);
	 elseif ($back_to == 'family_details')
	 redirect('/family/index/'.$this->family_id);
	 }
	 }
	 */

	function search_criteria($by,$key){
		$hew_login = $this->is_logged_in_user_hew();
		if($hew_login)
		$member_url_prefixes = $this->config->item('member_url_prefixes_hew');
		else
		$member_url_prefixes = $this->config->item('member_url_prefixes');

		$this->data["member_url_prefixes"] = $member_url_prefixes['opd'];
		if ($by =='policy_id'){
			$this->search_policy_by_id('opd',$key);
		}
		if ($by =='phone_no'){
			$this->search_policy_by_phone_no('opd',$key);
		}
		if ($by =='name'){
			$this->search_policies_by_name($key,'opd');
		}
	}


}
//end of file registration.php
