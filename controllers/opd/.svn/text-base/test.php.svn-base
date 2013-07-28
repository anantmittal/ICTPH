<?php
class test extends CI_Controller {
	public $form_data = array();
	function add(){

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'type', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );
		$this->load->model ( 'opd/test_types_model', 'test_type' );
		$this->form_data['tests'] = $this->test_type->find_all();


		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'opd/test_add',$this->form_data );
		} else {
			//print_r($_POST);
			//return;
			$test_obj = $this->test_type->new_record ( $_POST );
			if($_POST['test_status']=='on'){
				$test_obj->is_test_enabled = 0;
			}
			if($test_obj->bill_type == 'Group')
			{
				$params = $_POST['group'];
				$p_txt = ':';
				for($i=0; $i<sizeof($params); $i++)
				{
					if($i!=0)
						$p_txt .= ',';
					$p_txt .= $params[$i];
				
				}
				$test_obj->bill_type = 'Group'.$p_txt;
			}
			if($test_obj->save ())
			{	
    			$this->session->set_userdata('msg', 'Test: '.$test_obj->name.' saved successfully with id '.$test_obj->id);
				redirect('/opd/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'Test: '.$test_obj->name.' saved unsuccessful');
				$this->load->view ( 'opd/test_add',$this->form_data);
			}
		}

	}

	function edit_()
	{
		$url = "/opd/test/edit/".$_POST['t_id_edit'];
		redirect($url);
	}
		
	function edit($test_id = ''){
		if($test_id == '') {
			echo 'test id sent blank';
			return;
		}

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'type', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->load->model ( 'opd/test_types_model', 'test_type' );
		$test_obj = $this->test_type->find($test_id);
		$this->form_data['test_obj'] = & $test_obj;
		$this->form_data['tests'] = $this->test_type->find_all();

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'opd/test_add', $this->form_data);
		} else {
			if(!isset($_POST['test_status']) ){
				$test_obj->is_test_enabled = 1;
			}else{
				$test_obj->is_test_enabled = 0;
			}
			$test_obj->load_postdata(array('name','description','type','result_type','bill_type','cost'));
			if($test_obj->bill_type == 'Group')
			{
				$params = $_POST['group'];
				$p_txt = ':';
				for($i=0; $i<sizeof($params); $i++)
				{
					if($i!=0)
						$p_txt .= ',';
					$p_txt .= $params[$i];
				}
				$test_obj->bill_type = 'Group'.$p_txt;
			}
			if($test_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Test: '.$test_obj->name.' saved successfully');
//    				$this->session->set_userdata('msg', 'Product saved successfully');
				redirect('/opd/search/home');
			}
			else
			{
//    				$this->session->set_userdata('msg', 'Product saved unsuccessful');
    				$this->session->set_userdata('msg', 'Test: '.$test_obj->name.' saved unsuccessful');
				$this->load->view ( 'opd/test_add', $this->form_data);
			}
	
		}
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
}

?>
