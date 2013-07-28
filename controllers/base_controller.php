<?php

class Base_controller extends CI_Controller {
	/**
	 * This is a test comment
	 */
  public function Base_controller() {
    $this->load->library('session');
    $this->load->model('user_model', 'user');

    $GLOBALS['username'] = $this->session->userdata('username');
    $GLOBALS['user_roles'] = $this->user->get_roles('username',
						    $GLOBALS['username']);
  }
}
