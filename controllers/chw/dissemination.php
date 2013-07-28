<?php
class dissemination extends CI_Controller {
	public $form_data = array();
	function add(){

		if (isset ( $_POST ['c_name'] )) {
			$this->load->model ( 'chw/dissemination_model', 'dissemination' );
			$data['name'] = $_POST['c_name'];
			$data['description'] = $_POST['c_desc'];
			$c_obj = $this->dissemination->new_record ( $data);
			if($c_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Dissemination: '.$c_obj->name.' saved successfully with id '.$c_obj->id);
			}
			else
			{
    				$this->session->set_userdata('msg', 'Dissemination: '.$c_obj->name.' save unsuccessful');
			}
			redirect('/chw/search/home');
		}

	}

	function edit(){
		if($_POST['c_old'] == '') {
			$msg = 'Old Dissemination name not passed';
    			$this->session->set_userdata('msg', $msg);
			redirect('/chw/search/home');
		}

		$this->load->model ( 'chw/dissemination_model', 'dissemination' );
		$c_obj = $this->dissemination->find_by('name',$_POST['c_old']);
		if($c_obj)
		{
			$c_obj->name = $_POST['c_new'];
			if($c_obj->save ())
			{
    				$msg = 'Dissemination name changed from '.$_POST['c_old'].' to '.$c_obj->name.' successfully id '.$c_obj->id;
			}
			else
			{
    				$msg ='Dissemination with id '.$c_obj->id.' name could not be changed form '.$_POST['c_old'].' to '.$_POST['c_new'];
			}
		}
		else
		{	$msg = 'No Dissemination with name "'.$_POST['c_old'].'" found';}
    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/search/home');

	}

	function  show(){

	}
}

?>
