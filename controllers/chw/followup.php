<?php
/**
 * @todo : error checking shoud be done when save functionality happened
 * @author pankaj.khairnar
 *
 */
class followup extends CI_Controller {

	private $form_data = array ();

	function add_plan($type='',$id = '', $person_id = '') {

		if ($id == '') {
			echo 'Id is not passed properly please inter it as a last argument in url';
			return;
		}

		$this->load->model ( 'chw/'.$type.'_model', 'model_obj' );
		$model_rec = $this->model_obj->find ( $id );

		if ($model_rec === false) {
			echo 'id '.$id.' of type '.$type.' does not exist in table';
			return;
		}
		if($type =='chw')
			$this->form_data ['chw_name'] = $model_rec->name;
		else
			$this->form_data ['project_name'] = $model_rec->name;

		if($person_id != '')
		{
			$this->load->model ( 'demographic/person_model', 'person_obj' );
			$p_rec = $this->person_obj->find ( $person_id );
			$this->form_data ['person_name'] = $p_rec->full_name;
		}

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'start_date', 'Start date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['start_date'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/chw_followup_plan_add', $this->form_data );
			return;
		}

//			echo '<pre>';
//			print_r($_POST);


			$this->load->model ( 'chw/followup_model', 'followup' );
			$this->load->model ( 'chw/followup_dissemination_model', 'followup_dissemination' );
			$this->load->model ( 'chw/followup_health_product_model', 'followup_health_product' );
			$this->load->model ( 'chw/followup_test_model', 'followup_test' );
			$this->load->model ( 'chw/followup_event_model', 'followup_event' );
			$this->load->model ( 'chw/followup_event_report_model', 'followup_event_report' );
			$this->load->library ( 'date_util' );
			$this->load->library('utils');

			if($type =='chw')
			{
				$data['chw_id'] = $id;
				$data ['project_id'] = Utils::extract_id($this->input->post('project'));
			}
			else
			{
				$data ['chw_id'] = Utils::extract_id($this->input->post('chw'));
				$data ['project_id'] = $id;
			}
			if($person_id == '')
			{
				$data ['person_id'] = Utils::extract_id($this->input->post('person'));
			}
			else
			{
				$data ['person_id'] = $person_id;
			}
			//will come from url
			$data ['start_date'] = Date_util::change_date_format ( $this->input->post ( 'start_date' ) );
			$data ['end_date']   = Date_util::change_date_format ( $this->input->post ( 'end_date' ) );
			$data ['summary']    = $this->input->post ( 'summary' );
//			print_r($data);
$tx_status = true;
$this->db->trans_begin();
			$followup_obj = $this->followup->new_record ( $data );
			if(!$followup_obj->save ())
			{
				$tx_status = false;
				$msg = 'Followup with chw id'.$data['chw_id'].' and project id '.$data['project_id'].' could not be saved';
			}

//			echo 'followup id :'.$followup_id = $followup_obj->uid ();
			$followup_id = $followup_obj->uid ();

			$events = $this->input->post('events');
//			print_r($events);

			foreach($events as $event) {

				$event['followup_id'] = $followup_id;
				$event['date']  = Date_util::change_date_format ($event['date']);
				if($event['dissemination_id'] !=0)
				{
					$followup_event = $this->followup_event->new_record($event);
					$followup_event->type = 'dissemination';
					$followup_event->type_id = $event['dissemination_id'];
					if(!$followup_event->save())
					{
						$tx_status = false;
					}
				}
	

				if($event['health_product_id'] !=0)
				{
					$followup_event = $this->followup_event->new_record($event);
					$followup_event->type = 'health_product';
					$followup_event->type_id = $event['health_product_id'];
					if(!$followup_event->save())
					{
						$tx_status = false;
					}
				}

				if($event['test_id'] !=0)
				{
					$followup_event = $this->followup_event->new_record($event);
					$followup_event->type = 'test';
					$followup_event->type_id = $event['test_id'];
					if(!$followup_event->save())
					{
						$tx_status = false;
					}
				}
			}

/* When we used separate tables for followup_tests, disseminations and product
			foreach($events as $event) {

				$event['followup_id'] = $followup_id;
				$event['date']  = Date_util::change_date_format ($event['date']);
				$followup_event = $this->followup_event->new_record($event);
				if(!$followup_event->save())
				{
					$tx_status = false;
				}

//				echo '<br>followup_event_id :';
//				echo $event['followup_event_id'] = $followup_event->uid();
//				echo '<br>';

//				print_r($event);
				$event['followup_event_id'] = $followup_event->uid();

				if($event['dissemination_id'] !=0)
				{
					$followup_dissemination = $this->followup_dissemination->new_record($event);
					if(!$followup_dissemination->save())
					{
						$tx_status = false;
					}
				}
	

				if($event['health_product_id'] !=0)
				{
					$followup_health_product = $this->followup_health_product->new_record($event);
					if(!$followup_health_product->save())
					{
						$tx_status = false;
					}
				}

				if($event['test_id'] !=0)
				{
					$followup_test =  $this->followup_test->new_record($event);
					if(!$followup_test->save())
					{
						$tx_status = false;
					}
				}
			}
*/

    	  if($tx_status == true)
    	  {
       		$this->db->trans_commit();
        	$this->session->set_userdata('chw_f_id', $followup_id);
    		$this->session->set_userdata('msg', 'Followup records saved successfully');
		redirect('/chw/search/home');
		
    	  }
    	  else {
        	$this->session->unsset_userdata('chw_f_id');
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $msg.$events);
		redirect('/chw/search/home');
    	  }

//			echo 'Data has been saved';

			/* OLD STYLE OF COADING OF PARSING FORM ROWS
			 * $splited_data = array ();
			$followup_table_data = $this->input->post ( 'followupTable_data' );
			$data_rows = explode ( '~', $followup_table_data );

			array_pop ( $data_rows );
			array_shift ( $data_rows );

			echo '<pre>';
			print_r ( $data_rows );

			//			die();

			foreach ( $data_rows as $row ) {
				$row_values = explode ( '|', $row );

				$followup_event_data ['followup_id'] = & $followup_id;
				$followup_event_data ['date']        = Date_util::change_date_format ( $row_values [1] );

				$followup_event_obj = $this->followup_event->new_record ( $followup_event_data );
				$followup_event_obj->save ();

				$event_report_data ['followup_event_id'] = $followup_event_obj->uid ();
				$event_report_data ['status'] = 'not done';
				$event_report_obj = $this->followup_event_report->new_record ( $event_report_data );
				$event_report_obj->save();

				$splited_data  ['followup_event_id'] = $followup_event_obj->uid ();
				$splited_data  ['health_product_id'] = Utils::extract_id ( $row_values [2] );
				$splited_data  ['test_id']           = Utils::extract_id ( $row_values [3] );
				$splited_data  ['dissemination_id']    = Utils::extract_id ( $row_values [4] );

				$followup_dissemination_obj = $this->followup_dissemination->new_record ( $splited_data );
				$followup_dissemination_obj->save ();

				$followup_health_product_obj = $this->followup_health_product->new_record ( $splited_data );
				$followup_health_product_obj->save ();

				$followup_test_obj = $this->followup_test->new_record ( $splited_data );
				$followup_test_obj->save ();
			}*/
	}

	/*private function extract_id($value = '') {
		if ($value == '')
			return false;

		$splited_value = explode ( '(', $value );
		$splited_value = explode ( ')', $splited_value [1] );
		return $splited_value [0];
	}*/


    function show_update_box($id = '') {
    	if($id == '') {
    		echo 'id is not passed';
    		return;
    	}

    	$this->load->model('chw/followup_event_model', 'event');
    	$events = $this->event->find_all_by('followup_id', $id);

		$data['id']         = $id;
		$data['events_obj'] = $events;
		$this->load->view('chw/status_update_box', $data);
	}

	function update_status() {

    	$this->load->helper('url');

		$this->load->library('date_util');
		$this->load->model('chw/followup_event_report_model', 'event_report');
		$this->load->model('chw/followup_event_model', 'followup_event');

		$event['on_date'] =  Date_util::change_date_format($this->input->post('on_date'));
		$event['status']  =  $this->input->post('status');
		$event['note']    =  $this->input->post('note');
		$event['followup_event_id'] =  $this->input->post('event_id');
		$event_report = $this->event_report->new_record($event);
		$result1 = $event_report->save();
		/*if(!$result) {
			echo '{"result":"error"}';
			return ;
		}*/


		$followup_event = $this->followup_event->find($event['followup_event_id']);
		$followup_event->last_status = $event['status'];
		$result2 = $followup_event->save();

		if(($result1 && $result2))
		{
    			$this->session->set_userdata('msg', 'update successful');
//			redirect('/chw/search/home');
		}
		else
		{
    			$this->session->set_userdata('msg', 'update unsuccessful 1.'.$result1.' 2. '.$result2);
	//		redirect('/chw/search/home');
		}
		$this->load->model('chw/followup_model', 'followup');
		$chw_id = $this->followup->find($followup_event->followup_id)->chw_id;
		redirect('/chw/chw/show/'.$chw_id);
	}


/*
 * BELOW CODE IS USED TO UPDATE BULK ABDATE OF RECORDS AND NOT SINGEL BY USING AJAX
 *
{		$events = $this->input->post('events');
		if(!$events) {
			echo 'no post data available';
			return;
		}
//		print_r($events);
		foreach($events as $event) {
//			print_r($event);
			$event['on_date'] =  Date_util::change_date_format($event['on_date']);
			$event_report = $this->event_report->find_by(
			                                array('followup_event_id','status','on_date','note'),
											array($event['followup_event_id'],$event['status'],$event['on_date'],$event['note']));
			if($event_report == false) {
				$event_report = $this->event_report->new_record($event);
				$event_report->save();
				$followup_event = $this->followup_event->find($event['followup_event_id']);
//				print_r($followup_event);
				$followup_event->last_status = $event['status'];
				$followup_event->save();

			} else {
				echo '<br> one SAME event record is already exist';
			}
		}
*/

		/*$records = array();
		$date    = $this->input->post('date');
		$status  = $this->input->post('status');
		$comment = $this->input->post('comment');

		foreach($date as $key=>$value) {
			$new_date = Date_util::change_date_format($value);
			$records  = array('followup_event_id'=>$key, 'on_date'=>$new_date,
								'status'=>$status[$key], 'note'=>$comment[$key]);
			$event_report = $this->event_report->new_record($records);
			$result = $event_report->save();
			if($result == false) {
				echo 'Database error occured while saving update data';
				return;
			}
		}*/
//		echo '<br><br>new records added successfully:<br> @todo  redirect this page to chw-details page ';

//		redirect()
//	}

	function edit_plan($chw_id = '') {
		if ($chw_id == '') {
			echo 'chw_id is not passed properly please inter it as a last argument in url';
			return;
		}

		$this->load->model ( 'chw/chw_model', 'chw_obj' );
		$chw_rec = $this->chw_obj->find ( $chw_id );

		if ($chw_rec === false) {
			echo 'chw_id is not exist in table';
			return;
		}

		$this->form_data ['chw_name'] = $chw_rec->name;

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'start_date', 'Start date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['start_date'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/chw_followup_plan_add', $this->form_data );
			return;
		}
	}
	function add_followup_event_summary() {

	}
}
?>
