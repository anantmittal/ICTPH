<?php
class Session extends CI_Controller
{
  public function Session()
  {
    parent::__construct();

    log_message('debug', 'Base path = ['.$this->config->item('path')."]\n");
    //    $this->load->library('session', array("cookie_path" => $this->config->item('path')));
    //$this->load->library('session');
    //$this->load->library('ignitedrecord/ignitedrecord');
    $this->load->model('user/user_model','user');
    $this->load->model('user/role_model','role');
    $this->load->model('user/users_role_model','user_role');
   // $this->load->helper('url');
  }

  public function login() {
    //$redirect_url = str_replace("/session/session/login", "", $this->uri->uri_string());
    // TODO - change this to the basic Search page

    if (!$_POST) {
      //$form_data['redirect_url'] = $redirect_url;
      $form_data['error_server'] = "";
      $this->load->view('session/login',$form_data);
      return;
    }
   
    // Is a post request
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = md5($password);
	$user = $this->user->find_by('username', $username);
    if (!$user || $user->password_hash != $password_hash) {
        // show error message
        //$form_data['redirect_url'] = $redirect_url;
        $form_data['error_server'] = "Invalid username or password";
        $this->load->view('session/login',$form_data);
        return;
    }else if(!$user->is_user_enable){
    	//$form_data['redirect_url'] = $redirect_url;
      	$form_data['error_server'] = "User is not authorized to access this system. Please contact your administrator.";
      	$this->load->view('session/login',$form_data);
      	return;
    }
    $this->session->set_userdata('username', $username);
    //$this->session->set_userdata('redirecturl', $redirect_url);
    redirect('/session/session/welcome');
  }

  function logout() {
    // TODO Add more
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('redirecturl');
    $this->session->sess_destroy();
	redirect('/session/session/login');
//      $this->load->view('session/login');
  }
  
  function welcome(){
  	if($this->session->userdata('username')!=null) {
  		$user = $this->user->find_by('username', $this->session->userdata('username'));
  		$redirect_url = $this->session->userdata('redirecturl');
  		$this->session->set_userdata('redirecturl', "");;
  		$roles = $this->user_role->where('role_id >', '1', true)->find_all_by('user_id', $user->id);
		if(sizeof($roles) == 1){
			foreach ( $roles as $key => $value ) {
	       		$role_id = $value->role_id;
			}
			$role_rec = $this->role->find($role_id);
		    $home_url = $this->config->item('base_url').'index.php/'.$role_rec->home_url; 
		    $this->session->set_userdata('home', $home_url);
		    if (!empty($redirect_url) && $redirect_url !== ""){
      			$home_url = $redirect_url;
		    }
		    redirect($home_url);
		}else if(sizeof($roles) > 1){
			$role_rec_list = array();
			$home_url_array = array();
			$i=0;
	      	foreach ( $roles as $key => $value ) {
	       		$role_id = $value->role_id;
	       		$role_rec = $this->role->find($role_id);
	       		$role_rec_list[$key] = $role_rec;
	       		if(!in_array($role_rec->home_url, $home_url_array)){
	       			$home_url_array[$i] = $role_rec->home_url;
	       			$i++;
	       		}
			}
			if(sizeof($home_url_array) == 1){
				$home_url = $this->config->item('base_url').'index.php/'.$home_url_array[0]; 
		    	$this->session->set_userdata('home', $home_url);
		    	if (!empty($redirect_url) && $redirect_url !== ""){
      				$home_url = $redirect_url;
		    	}
		    	redirect($home_url);
		    	return;
			}
			$data['roles_rec'] = $role_rec_list;
			$home_url = $this->config->item('base_url').'index.php/session/session/welcome';
			$this->session->set_userdata('home', $home_url);
			if (!empty($redirect_url) && $redirect_url !== ""){
      			$home_url = $redirect_url;
      			redirect($home_url);
		    }
	      	$this->load->view('welcome',$data);
	      	return;
		}else{
			$this->session->unset_userdata('username');
	    	$this->session->sess_destroy();
			redirect('/session/session/login');
		}
  	}
  }
}
//end of controller
