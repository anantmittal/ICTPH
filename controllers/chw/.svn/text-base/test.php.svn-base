<?php
class test extends CI_Controller {
	public $form_data = array();
	function add(){

		if (isset ( $_POST ['test_name'] )) {
			$this->load->model ( 'chw/test_model', 'test' );
			$data['name'] = $_POST['test_name'];
			$test_obj = $this->test->new_record ( $data);
//			$product_obj->save ();
			if($test_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Test: '.$test_obj->name.' saved successfully with id '.$test_obj->id);
			}
			else
			{
    				$this->session->set_userdata('msg', 'test: '.$test_obj->name.' save unsuccessful');
			}
			redirect('/chw/search/home');
		}

	}

	function edit(){
		if($_POST['test_old'] == '') {
			$msg = 'Old test name not passed';
    			$this->session->set_userdata('msg', $msg);
			redirect('/chw/search/home');
		}

		$this->load->model ( 'chw/test_model', 'test' );
		$t_obj = $this->test->find_by('name',$_POST['test_old']);
		if($t_obj)
		{
			$t_obj->name = $_POST['test_new'];
			if($t_obj->save ())
			{
    				$msg = 'Test name changed from '.$_POST['test_old'].' to '.$t_obj->name.' successfully id '.$t_obj->id;
			}
			else
			{
    				$msg ='Test with id '.$t_obj->id.' name could not be changed form '.$_POST['test_old'].' to '.$_POST['test_new'];
			}
		}
		else
		{	$msg = 'No Test with name "'.$_POST['test_old'].'" found';}
    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/search/home');

	}

	function  show(){

	}
}

?>
