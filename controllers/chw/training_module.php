<?php
class training_module extends CI_Controller {	
	function add() {
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'Training Module Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );


		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/training_module_add' );
		} else {
			$this->load->model ( 'chw/training_module_model', 'tm_model' );
			$tm_obj = $this->tm_model->new_record ( $_POST );
			$tm_obj->owner_id = 1;
$tx_status = true;
$this->db->trans_begin();
			if(!$tm_obj->save ())
			{
				$tx_status = false;
    				$msg = 'Training Module: '.$tm_obj->name.' save unsuccessful';
			}

			$tm_id = $tm_obj->id;
			
			$config['upload_path'] = $this->config->item('base_path').'/uploads/training/';
			$this->load->library('upload', $config);

			if($_FILES['module_file']['name'] != '') {			

                 		$file_name = $this->config->item('base_path').'uploads/training/tm-'.$tm_id.'-'.$tm_obj->name.'-'.$_FILES['module_file']['name'];
				if ( move_uploaded_file($_FILES['module_file']['tmp_name'],$file_name))
				{
					$tm_obj->filename = 'tm-'.$tm_id.'-'.$tm_obj->name.'-'.$_FILES['module_file']['name'];
					$tm_obj->save();
//					$msg = 'tmp '.$_FILES['module_file']['tmp_name'].' name '.$_FILES['module_file']['name'].' new file name '.$file_name;
				}
				else {
					$tx_status = false;
					$msg = 'Could not upload file '.$_FILES['module_file']['name'];
				}			
			}

//			$table_data = $this->input->post('topicTableData');
//			$topic_rows = explode ('~',$table_data);
//			$no_rows = count($topic_rows) - 1;
			$topics = $this->input->post('new_topics');
//			$filenames = $this->input->post('filenames');
			$no_rows = count($topics);
//			$msg = $msg.' topic data '.$table_data.'no rows '.$no_rows;
			for($cnt=0; $cnt < $no_rows; $cnt++)
			{
/*				$values = explode ('|',$topic_rows[$cnt]);
				$data['name'] = $values[0];
				$data['description'] = $values[1];
				$data['training_module_id'] = $tm_id;
*/				
				$data['name'] = $topics[$cnt]['topic'];
				$data['description'] = $topics[$cnt]['description'];
				$data['training_module_id'] = $tm_id;

			$config['upload_path'] = $this->config->item('base_path').'uploads/training/';
			$this->load->library('upload', $config);
				$filevar = 'filename'.$cnt;
				if($_FILES[$filevar]['name'] != '') {			
               			  $file_name = $this->config->item('base_path').'uploads/training/tt-'.$tm_id.'-'.$data['name'].'-'.$_FILES[$filevar]['name'];
				  if (move_uploaded_file($_FILES[$filevar]['tmp_name'],$file_name))
				  {
				        $data['filename'] = 'tt-'.$tm_id.'-'.$data['name'].'-'.$_FILES[$filevar]['name'];
//					$msg = 'tmp '.$_FILES['module_file']['tmp_name'].' name '.$_FILES['module_file']['name'].' new file name '.$file_name;
				  }
				  else {
					$data['filename'] = 'no file';
					$tx_status = false;
					$msg = 'Could not upload file '.$_FILES[$filevar]['name'];
				  }  			
				}


				$this->load->model ( 'chw/training_topic_model', 'tt_model' );
				$tt_obj = $this->tt_model->new_record ( $data );
				
				if(!$tt_obj->save ())
				{
					$tx_status = false;
    					$msg = $msg.' Training Topic: '.$tt_obj->name.' saved unsuccessful';
				}
			}
				
				
			
			if($tx_status == true)
			{
				$this->db->trans_commit();
//    				$this->session->set_userdata('msg', $msg);
    				$this->session->set_userdata('msg', 'Training Module: '.$tm_obj->name.' saved successfully');
				redirect('/chw/search/home');
			}
			else
			{
				$this->db->trans_rollback();
    				$this->session->set_userdata('msg', $msg);
				$this->load->view ( 'chw/training_module_add');
			}
		}

    }

	function edit_()
	{
		$url = "/chw/training_module/edit/".$_POST['tmid_edit'];
		redirect($url);
	}
		
    
	function edit($tm_id = ''){
		
		if($tm_id == '') {
			echo 'Training Module id sent blank';
			return;
		}

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'Training Module Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->load->model ( 'chw/training_module_model', 'tm' );
		$this->load->model ( 'chw/training_topic_model', 'tt' );
		$tm_obj = $this->tm->find($tm_id);
		$this->form_data['training_module_obj'] = & $tm_obj;
		$this->tt->where('training_module_id',$tm_id);
		$topics = $this->tt->find_all();
		$this->form_data['topics'] = $topics;

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/training_module_add', $this->form_data);
		} else {
			$tm_obj->load_postdata(array('name','description','author'));

$tx_status = true;
$this->db->trans_begin();

			$config['upload_path'] = $this->config->item('base_path').'/uploads/training/';
			$this->load->library('upload', $config);

			if($_FILES['module_file']['name'] != '') {			

                 		$file_name = $this->config->item('base_path').'uploads/training/tm-'.$tm_id.'-'.$tm_obj->name.'-'.$_FILES['module_file']['name'];
				if ( move_uploaded_file($_FILES['module_file']['tmp_name'],$file_name))
				{
					$tm_obj->filename = 'tm-'.$tm_id.'-'.$tm_obj->name.'-'.$_FILES['module_file']['name'];
				}
				else {
					$tx_status = false;
					$msg = 'Could not upload file '.$_FILES['module_file']['name'];
				}			
			}

			$tm_obj->save ();
//			if(!$tm_obj->save ())
//			{
//    				$this->session->set_userdata('msg', 'Product saved unsuccessful');
//				$tx_status = false;
//    				$msg = 'Training Module: '.$tm_obj->name.' saved unsuccessful';
//				$this->load->view ( 'chw/training_module_add', $this->form_data);
//			}
	
			$tm_id = $tm_obj->id;

/*			$table_data = $this->input->post('topicTableData');
			$topic_rows = explode ('~',$table_data);
			$no_rows = count($topic_rows) - 1;
			$msg = $msg.' topic data '.$table_data.'no rows '.$no_rows;*/

			$topics = $this->input->post('new_topics');
			$no_rows = count($topics);

			for($cnt=0; $cnt < $no_rows; $cnt++)
			{
/*				$values = explode ('|',$topic_rows[$cnt]);
				$data['name'] = $values[0];
				$data['description'] = $values[1];
*/				$data['training_module_id'] = $tm_id;
				
				$data['name'] = $topics[$cnt]['topic'];
				$data['description'] = $topics[$cnt]['description'];
//				$data['filename'] = $topics[$cnt]['filename'];
				$data['training_module_id'] = $tm_id;

			$config['upload_path'] = $this->config->item('base_path').'uploads/training/';
			$this->load->library('upload', $config);
				$filevar = 'filename'.$cnt;
				if($_FILES[$filevar]['name'] != '') {			
               			  $file_name = $this->config->item('base_path').'uploads/training/tt-'.$tm_id.'-'.$data['name'].'-'.$_FILES[$filevar]['name'];
				  if (move_uploaded_file($_FILES[$filevar]['tmp_name'],$file_name))
				  {
				        $data['filename'] = 'tt-'.$tm_id.'-'.$data['name'].'-'.$_FILES[$filevar]['name'];
//					$msg = 'tmp '.$_FILES['module_file']['tmp_name'].' name '.$_FILES['module_file']['name'].' new file name '.$file_name;
				  }
				  else {
					$data['filename'] = 'no file';
					$tx_status = false;
					$msg = 'Could not upload file '.$_FILES[$filevar]['name'];
				  }  			
				}

				$this->load->model ( 'chw/training_topic_model', 'tt_model' );
				$tt_obj = $this->tt_model->new_record ( $data );
				
				if(!$tt_obj->save ())
				{
					$tx_status = false;
    					$msg = $msg.' Training Topic: '.$tt_obj->name.' saved unsuccessful';
				}
			}
				
				
			
			if($tx_status == true)
			{
				$this->db->trans_commit();
//    				$this->session->set_userdata('msg', $msg);
    				$this->session->set_userdata('msg', 'Training Module: '.$tm_obj->name.' saved successfully');
				redirect('/chw/search/home');
			}
			else
			{
				$this->db->trans_rollback();
    				$this->session->set_userdata('msg', $msg);
				$this->load->view ( 'chw/training_module_add');
			}
		}
	}

	function add_topics(){
		
	}

	function list_topics(){
 	}

	function search_by_name($name = '') {
		
		$this->load->model ( 'chw/training_module_model', 'training_module' );
		if($name =="ALL")
		{
			$tms = $this->training_module->find_all();
		}
		else
		{
			$tms = $this->training_module->like ( 'name', $name)->find_all();
		}
		$data ['tm_obj'] = $tms;

		$this->load->view ( 'chw/z_tm_list', $data );
	}
}
?>
