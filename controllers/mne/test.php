<?php
class test extends CI_Controller {
	function index() {
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';

		$data['tabname'] = 'household';
		$this->load->view('monitoring_evaluation/define_form', $data);
	}

	function test1() {

		$this->load->view('monitoring_evaluation/test');

	}
	function test2() {

		$data['tabs'] = array('household', 'area');
		$this->load->view('monitoring_evaluation/create_form_definition', $data);
	}
}