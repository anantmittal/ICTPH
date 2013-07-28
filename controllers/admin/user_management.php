<?php
class User_management extends CI_Controller {
	public function User_management() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('ignitedrecord/ignitedrecord');
		$this->load->library('opd/problem_dom_displayer');
		$this->load->model('user/user_model', 'user');
		$this->load->model('user/role_model', 'role');
		$this->load->model('user/users_role_model', 'user_role');
		$this->load->model('user/role_right_model', 'role_right');
		$this->load->model('opd/provider_model', 'provider_model');
		$this->load->model('opd/provider_location_affiliation_model', 'pla');
		$this->load->helper('url');
		$this->load->helper('geo');
	}

	public function change_password() {
		if (!$_POST) {
			$message = "";
			$data['error_server_passwd'] = $message; 
			$this->load->view('session/change_password',$data);
			return;
		}

		// Is a post request
		$user_logged = $this->session->userdata('username');		
		$cur_password = $_POST['cur_password'];
		$cur_password_hash = md5($cur_password);
		
		$user = $this->user->find_by('username', $user_logged);

		if (!$user || $user->password_hash != $cur_password_hash ) {			
			// show error message
			$message = "wrong current password";
			$data['error_server_passwd'] = $message; 
			$this->load->view('session/change_password',$data);
			return;
		}
		
		$new_password1 = $_POST['new_password1'];
		$new_password2 = $_POST['new_password2'];
		
		if($user_logged == $new_password1) {		
			$message = " Password can not be same as username  ";
			$data['error_server_passwd'] = $message;
			$this->load->view('session/change_password',$data);
			return;
		}
		
		if ($new_password1 == $new_password2) {
			$new_password_hash = md5($new_password1);
			$user->password_hash = $new_password_hash;
			if (!$user->save()) {
				$message = " Password could not be changed. Try Again ";
				$data['error_server_passwd'] = $message;
				$this->load->view('session/change_password',$data);
			}

			$message = "Password for user " . $username . " has been successfully updated";
			$this->session->set_userdata('msg', $message);
			redirect($this->config->item('home_url'));			
		} else {
			$message = " Passwords do not match  ";
			$data['error_server_passwd'] = $message;			
			$this->load->view('session/change_password',$data);
		}

	}

	public function add_user() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('full_name', 'Name', 'required');
		$this->form_validation->set_error_delimiters('<label class="error">', '</label>');
		$data['states'] = get_states();
		$data['locations'] = get_locations();
		$data['roles'] = $this->role->get_names();
		$data['error_server'] = '';
		$edit_user = null;
		$data['edit_user'] = $edit_user;
		$data['disable_field'] = '';
		$data['displayer'] = $this->problem_dom_displayer;
		if (!$_POST) {
			$this->load->model('user/role_model', 'role');
			$data['roles'] = $this->role->get_names();
			$this->load->view('admin/add_user', $data);
			return;
		}
		$user_logged = $this->session->userdata('username');

		//User Validation
		$username = $_POST['username'];
		$new_password1 = $_POST['new_password1'];
		$new_password2 = $_POST['new_password2'];
		$fullname = $_POST['full_name'];
		$contact = $_POST['contact'];
		$email_id = $_POST['emailid'];
		$user_check = $this->user->validate_user($username, $new_password1, $new_password2);
		if (!empty ($user_check)) {
			$msg = $user_check;
			$data['error_server'] = $msg;
			$this->session->set_userdata('msg', $msg);
			$this->load->view('admin/add_user', $data);
		} else {
			$this->db->trans_begin();
			$saved_user = $this->user->save_user($username, $new_password1, $fullname, $contact,$email_id);
			if ($saved_user == null) {
				$msg = "Failed to add user please try later!";
				$data['error_server'] = $msg;
				$this->session->set_userdata('msg', $msg);
				$this->load->view('admin/add_user', $data);
			}
			$role_array = $_POST['roles'];
			$saved_user_role = $this->user_role->save_user_roles($saved_user, $role_array);
			$clinician_or_technician_or_hew = false;
			for ($i = 0; $i < sizeof($role_array); $i++) {
				if ($_POST['roles'][$i] == 7 || $_POST['roles'][$i] == 15 || $_POST['roles'][$i] == 17) {
					$clinician_or_technician_or_hew = true;
					break;
				}
			}
			if ($clinician_or_technician_or_hew) {
				$provider_object = $this->form_provider_object();
				$saved_provider = $this->provider_model->save_provider($provider_object);
				$provider_locations_array = $_POST['provider_locations'];
				$saved_pla = $this->pla->save_provider_location_affiliation($saved_provider, $provider_locations_array);
			}
			$this->db->trans_commit();
			$msg = 'User ' . $saved_user->name . ' with id ' . $saved_user->id . ' has been successfully created';
			$this->session->set_userdata('msg', $msg);
			redirect($this->config->item('home_url'));
		}
	}

	function form_provider_object() {
		$state_id = $_POST['state_id'];
		$district_id = $_POST['district_id'];
		$taluka_id = $_POST['taluka_id'];
		$village_city_id = $_POST['village_city_id'];
		$street_address = $_POST['street_address'];		
		$qualification = $_POST['qualification'];
		$registration_number = $_POST['registration_number'];
		$type = $_POST['type'];
		$username = $_POST['username'];
		$fullname = $_POST['full_name'];

		$provider_object = $this->provider_model->new_record();
		//form provider object
		if (isset ($_POST['provider_id'])) {
			$provider_object->id = $_POST['provider_id'];
		}
		$provider_object->full_name = $fullname;
		$provider_object->type = $type;
		$provider_object->qualification = $qualification;
		$provider_object->registration_number = $registration_number;		
		$provider_object->street_address = $street_address;
		$provider_object->village_city_id = $village_city_id;
		$provider_object->taluka_id = $taluka_id;
		$provider_object->district_id = $district_id;
		$provider_object->state_id = $state_id;
		$provider_object->username = $username;
		return $provider_object;
	}

	public function find_user($action) {
		$data['error_server'] = '';
		$this->load->model('user/role_model', 'role');
		$user_list = $this->user->find_all();
		$data['roles'] = $this->role->get_names();
		$data['show_edit'] = false;
		$data['first_time'] = 'First';
		$data['user_list'] = $user_list;
		if ($action == "edit_user") {
			$this->load->view('admin/edit_user', $data);
			return;
		} else
			if ($action == "block_user") {
				$this->load->view('admin/block_user', $data);
				return;
			}

	}

	public function edit_user($userId) {
		$data['disable_field'] = 'disabled';
		$data['error_server'] = '';
		$data['first_time'] = 'Not first';
		$user_list = $this->user->find_all();
		$data['roles'] = $this->role->get_names();
		$data['show_edit'] = true;
		$data['user_list'] = $user_list;
		$data['states'] = get_states();
		$data['locations'] = get_locations();
		$edit_user = $this->user->find_by('id', $userId);
		//$role_ids_mapped = $this->user_role->where('user_id', $userId, true)->where('role_id >', '1', true)->find();
		//$role_ids_mapped = $this->user_role->find_by('user_id', $userId);

		$role_ids_mapped = $this->user_role->where('role_id >', '1', true)->find_all_by('user_id', $userId);
		$data['mapped_roles'] = $role_ids_mapped;

		$provider = $this->provider_model->find_by('username', $edit_user->username);

		if ($provider != null) {
			$data['provider'] = $provider;
			$provider_location_affiliations = $this->pla->find_all_by('provider_id', $provider->id);
			$data['pla'] = $provider_location_affiliations;
		}

		if ($edit_user == null) {
			$data['error_server'] = 'Not a valid user';
			$this->load->view('admin/edit_user', $data);
			return;
		}
		$data['edit_user'] = $edit_user;
		$data['displayer'] = $this->problem_dom_displayer;
		$this->load->view('admin/edit_user', $data);
		return;
	}
	
	// This function gets called when complete username is typed in Edit User Form and clicked on Find
	// Since the user id is not available so from username get the whole user object and then call edit_user($userId) 
	public function edit_user_no_user_id($username){
		$user_obj_with_id = $this->user->find_by('username', $username);
		$this->edit_user($user_obj_with_id->id);
	}

	public function update_user() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('full_name', 'Name', 'required');
		$this->form_validation->set_error_delimiters('<label class="error">', '</label>');
		$data['roles'] = $this->role->get_names();
		$data['error_server'] = '';

		$user_logged = $this->session->userdata('username');
		$contact = $_POST['contact'];
		//User Validation
		$username = $_POST['username'];
		$new_password1 = $_POST['new_password1'];
		$new_password2 = $_POST['new_password2'];
		$fullname = $_POST['full_name'];
		$contact = $_POST['contact'];
		$user_id = $_POST['id'];
		$email_id = $_POST['emailid'];
		
			$this->db->trans_begin();
			$user = $this->user->find_by('id', $user_id);

			//As update is not working for IgnitedRecord we a keepo=ing this code still in controller
			//TODO need to move to the respective model
			if (isset ($new_password1) && $new_password1 != '') {
				$new_password_hash = md5($new_password1);
				$new_password1 = $new_password_hash;
			} else {
				$new_password1 = $user->password_hash;
			}
			$user_data = array (
				"username" => $user->username,
				"name" => $fullname,
				"contact_number" => $contact,
				"password_hash" => $new_password1,
				"email_id" => $email_id
			);
			$this->db->where('id', $user->id);
			$this->db->update('users', $user_data);
			$updated_user = $this->user->find_by('id', $user_id);
			if ($updated_user == null) {
				$msg = "Failed to add user please try later!";
				$data['error_server'] = $msg;
				$this->session->set_userdata('msg', $msg);
				$this->load->view('admin/edit_user', $data);
			}

			//Related to users_role_model
			//TODO Need to move this code to users_role_model
			//As $this->delete is not working inside users_role_model
			$role_ids_mapped = $this->user_role->get_user_role_ids($updated_user);
			$edited_role_ids = $_POST['roles'];

			//To insert new Role
			for ($i = 0; $i < sizeof($edited_role_ids); $i++) {
				$role_id = $edited_role_ids[$i];
				if (!in_array($role_id, $role_ids_mapped)) {
					$new_role_rec = $this->user_role->new_record();
					$new_role_rec->user_id = $updated_user->id;
					$new_role_rec->role_id = $role_id;
					$new_role_rec->save();
				}
			}

			//To delete existing role
			for ($i = 0; $i < sizeof($role_ids_mapped); $i++) {
				$role_id = $role_ids_mapped[$i];
				if (!in_array($role_id, $edited_role_ids)) {
					if ($role_id == 7 || $role_id == 15) {
						continue;
					}
					$user_role_rec = $this->user_role->where('user_id', $updated_user->id, true)->where('role_id', $role_id, true)->find();
					//$this->user_role->delete_role($user_role_rec->id);
					$this->db->where('id', $user_role_rec->id);
					$this->db->delete('users_roles');
				}
			}
			//users_role_model ends here

			$role_array = $_POST['roles'];
			$clinician_or_technician_or_hew = false;
			foreach ($role_array as $value) {
				if ($value == 7 || $value == 15 || $value == 17) {
					$clinician_or_technician_or_hew = true;
					break;
				}
			}
			if ($clinician_or_technician_or_hew) {
				$provider_object = $this->form_provider_object();
				$provider_data = array (
					'full_name' => $provider_object->full_name,
					'type' => $provider_object->type,
					'qualification' => $provider_object->qualification,
					'registration_number' => $provider_object->registration_number,					
					'street_address' => $provider_object->street_address,
					'village_city_id' => $provider_object->village_city_id,
					'taluka_id' => $provider_object->taluka_id,
					'district_id ' => $provider_object->district_id,
					'state_id ' => $provider_object->state_id,
					'username ' => $provider_object->username,
					
				);
				//Fixing issue of saving provider while updating a user.
				if(isset($provider_object->id)){
					$this->db->where('id', $provider_object->id);
					$this->db->update('providers', $provider_data);
				}else{
					$provider_object->save();
				}
				
				$provider = $this->provider_model->find_by('id', $provider_object->id);

				$edited_locations_array = $_POST['provider_locations']; // has value in this array			

				$location_mapped = $this->pla->get_provider_location_ids($provider->id); //has locations ids					

				//To insert new locations
				for ($i = 0; $i < sizeof($edited_locations_array); $i++) {
					$provider_location_id = $edited_locations_array[$i];
					if (!in_array($provider_location_id, $location_mapped)) {
						$pla_rec = $this->pla->new_record();
						$pla_rec->provider_id = $provider->id;
						$pla_rec->provider_location_id = $provider_location_id;
						$pla_rec->save();
					}
				}
				// To delete existing locations
				for ($i = 0; $i < sizeof($location_mapped); $i++) {
					$location_id = $location_mapped[$i];
					if (!in_array($location_id, $edited_locations_array)) {
						$pla_rec = $this->pla->where('provider_id', $provider->id, true)->where('provider_location_id', $location_id, true)->find();
						//$this->user_role->delete_role($user_role_rec->id);
						$this->db->where('id', $pla_rec->id);
						$this->db->delete('provider_location_affiliations');
					}
				}
			}
			$this->db->trans_commit();
			$msg = 'User ' . $updated_user->name . ' with id ' . $updated_user->id . ' has been successfully edited';
			$this->session->set_userdata('msg', $msg);
			redirect($this->config->item('home_url'));
		
	}

	function block_user($userId) {
		$block_user_check = $this->user->find_by('id', $userId);
		$data['test'] = $block_user_check;

		$data['block_user'] = $block_user_check;
		$user_list = $this->user->find_all();
		$data['user_list'] = $user_list;
		$this->load->view('admin/block_user', $data);
		return;
	}

	function block_unblock_user() {
		$user_id = $_POST['user_id'];
		$user_check = $this->user->find_by('id', $user_id);
		$mesg2 = "";

		$this->db->trans_begin();

		if ($user_check->is_user_enable) {
			$user_blocked = $this->user->block_user($user_id);
			$mesg2 = "Blocked";
		} else {
			$user_unblocked = $this->user->unblock_user($user_id);
			$mesg2 = "Unblocked";
		}

		$this->db->trans_commit();

		$msg = 'User ' . $updated_user->name . ' with id ' . $user_id . ' has been successfully ' . $mesg2;
		$this->session->set_userdata('msg', $msg);
		redirect($this->config->item('home_url'));
	}
	
	function block_user_no_user_id($username){
		$user_obj_with_id = $this->user->find_by('username', $username);
		$this->block_user($user_obj_with_id->id);
	}

	function create_role() {
		$data['error_server'] = '';
		if (!$_POST) {
			$this->load->view('admin/create_role', $data);
			return;
		}

		$rolename = $_POST['name'];
		$role_rights = $_POST['rights'];
		$home_url = $_POST['home_url'];
		$home_view = $_POST['home_view'];

		$role_check = $this->role->validate_role($rolename);
		if (!empty ($role_check)) {
			$msg = $role_check;
			$data['error_server'] = $msg;
			$this->session->set_userdata('msg', $msg);
			$this->load->view('admin/create_role', $data);
			return;
		}
		$this->db->trans_begin();
		$new_role_rec = $this->role->new_record();
		$new_role_rec->name = $rolename;
		$new_role_rec->rights = $role_rights;
		$new_role_rec->home_url = $home_url;
		$new_role_rec->home_view = $home_view;

		$new_role = $this->role->create_new_role($new_role_rec);

		$module_array = $_POST['module'];
		$controller_array = $_POST['controller'];
		$action_array = $_POST['action'];

		$role_rights = $this->role_right->add_role_right($new_role->id, $module_array, $controller_array, $action_array);
		$this->db->trans_commit();
		$msg = 'New Role with id ' . $new_role->id . ' has been successfully created ';
		$this->session->set_userdata('msg', $msg);
		redirect($this->config->item('home_url'));
	}

	public function find_role($action) {
		$role_list = $this->role->find_all();
		$data['role_list'] = $role_list;
		//$this->load->view('admin/edit_role', $data);	

		if ($action == "edit_role") {
			$this->load->view('admin/edit_role', $data);
			return;
		} else
			if ($action == "delete_role") {
				$this->load->view('admin/delete_role', $data);
				return;
			}

	}

	public function edit_role($roleId) {
		$role_list = $this->role->find_all();
		$data['role_list'] = $role_list;
		$edit_role = $this->role->find_by('id', $roleId);
		$data['edit_role'] = $edit_role;
		$role_rights_mapped = $this->role_right->find_all_by('role_id', $roleId);
		$data['mapped_rights'] = $role_rights_mapped;
		$data['disable_field'] = 'disabled';
		$data['error_server'] = '';
		$this->load->view('admin/edit_role', $data);
		return;
	}
	
	public function edit_role_no_role_id($roleName){
		$role_obj_with_id = $this->role->find_by('name', $roleName);
		$this->edit_role($role_obj_with_id->id);
	}

	public function update_role() {
		$rolename = $_POST['name'];
		$role_description = $_POST['rights'];
		$home_url = $_POST['home_url'];
		$home_view = $_POST['home_view'];
		$role_id = $_POST['id'];

		$module_array = $_POST['module']; // starts from index 1
		$controller_array = $_POST['controller'];
		$action_array = $_POST['action'];

		$updated_role = $this->role->update_role($role_description, $home_url, $home_view, $role_id);
		
		$role_rights = $this->role_right->update_role_right($updated_role->id, $module_array, $controller_array, $action_array);

		$msg = 'Role with id ' . $updated_role->id . ' has been updated ';
		$this->session->set_userdata('msg', $msg);
		redirect($this->config->item('home_url'));
		return;
	}

	function delete_role($role_id) {
		$role_list = $this->role->find_all();
		$data['role_list'] = $role_list;
		$role_check = $this->user_role->find_all_by('role_id', $role_id);
		$role_name = $this->role->find_by('id', $role_id);

		$data['role_mapped'] = $role_check;

		$data['role_name'] = $role_name;
		$this->load->view('admin/delete_role', $data);
		return;
	}

	function delete_role_no_role_id($role_name){
		$role_obj_with_id = $this->role->find_by('name', $role_name);
		$this->delete_role($role_obj_with_id->id);
	}
	
	function remove_role() {
		$role_id = $_POST['role_id'];
		$this->db->delete('roles', array (
			'id' => $role_id
		)); // can't directly delete this b'coz of has many relation with role_rights
		$role_rights = $this->role_right->find_all_by('role_id', $role_id);
		$this->role_right->delete_role_rights($role_rights);

		$msg = 'Role with id ' . $role_id . ' has been deleted ';
		$this->session->set_userdata('msg', $msg);
		redirect($this->config->item('home_url'));

	}

	function logout() {
		// TODO Add more
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();
		redirect('/session/session/login');
		//      $this->load->view('session/login');
	}
}