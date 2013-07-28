<?php
class training_session extends CI_Controller {
	public $form_data = array ();

	function add_report($training_session_id = '') {

		if ($training_session_id == '') {
			echo 'training_session_id is not passed properly in url';
			return false;
		}

		if (! isset ( $_POST ['summary'] )) {

			$this->load->model ( 'chw/training_session_model', 'training_session' );
			$this->load->model ( 'chw/chw_model', 'chw' );
			$this->load->model ( 'chw/training_session_content_model', 'tsession_content' );
			$this->load->model ( 'chw/training_sessions_criteria_model', 'criteria' );
			$training_session_obj = $this->training_session->select ( array ('projects.name AS project_name', 'chw_groups.name AS group_name' ) )->from ( array ('chw_groups', 'projects' ) )->where ( 'project_id', 'projects.id', false )->where ( 'training_sessions.chw_group_id', 'chw_groups.id', false )->where ( 'training_sessions.id', $training_session_id, false )->get ();

			$this->form_data ['id'] = $training_session_obj->id;
			$this->form_data ['project_name'] = $training_session_obj->project_name;
			$this->form_data ['group_name'] = $training_session_obj->group_name;
			$this->form_data ['description'] = $training_session_obj->description;

			$chw_group_id = $training_session_obj->chw_group_id;
			$project_id = $training_session_obj->project_id;

			$chw_obj = $this->chw->from ( array ('chw_group_members' => 'cgm' ) )->where ( 'chws.id', 'cgm.chw_id', false )->where ( 'cgm.chw_group_id', $chw_group_id, false )->find_all ();

			$this->form_data ['chw_obj'] = & $chw_obj;

			$criteria = $this->criteria->find_all_by ( 'training_session_id', $training_session_id );
			//		print_r($criteria);
			$criteria_arr = array ();
			$arr = array ();

			foreach ( $criteria as $criteria_row ) {
				$arr ['id'] = $criteria_row->id;
				$arr ['criteria'] = $criteria_row->criteria;

				$criteria_arr [] = $arr;
			}

			//		print_r($criteria_arr);
			$this->form_data ['criteria'] = $criteria_arr;

			$this->load->view ( 'chw/create_training_session_report', $this->form_data );
		}
		else {
			$this->load->model('chw/training_session_report_model', 'report');
			$this->load->model('chw/training_session_report_score_model', 'scores');
			$this->load->model('chw/training_session_attendance_model', 'attendance');
//			echo '<pre>';
//			print_r($_POST);
//			echo '<pre>';
//			echo $summary = $this->input->post('summary');
			$summary = $this->input->post('summary');
 $tx_status = true;
 $this->db->trans_begin();
			$report_obj = $this->report->new_record(array('training_session_id'=>$training_session_id,
														  'summary'=> $summary));
//			$report_obj->save();
			if(!$report_obj->save())
			{
				$tx_status = false;
				$msg = 'Report '.$summary.' cannot be saved';
			}

			$data = $this->input->post('score');
//			echo '<pre>';

			$table_row = array('training_session_id'=>$training_session_id);

			$criteria_arr = $data[0];
			unset($data[0]);
//			echo 'Criteria Array <br>';
//			print_r($criteria_arr);

//			echo '<br>data array <br>';
//			print_r($data);

//			echo '<br><br>Data is going to save in table <br>';
			foreach($data as $data_row) {
				$table_row['chw_id']  = $data_row['chw_id'];
				$table_row['status']  = $data_row['status'];
				$table_row['comment'] = $data_row['comment'];

				$attendance_obj = $this->attendance->new_record($table_row);
//				$attendance_obj->save();
				if(!$attendance_obj->save())
				{	
					$tx_status = false;
					$msg = 'Attendance cannot be saved';
				}

				unset($data_row['chw_id']);
				unset($data_row['status']);
				unset($data_row['comment']);

				foreach($data_row as $key=>$value ) {
					$table_row['training_session_criteria_id'] = $criteria_arr[$key];
					$table_row['score'] = $value;
					$scores_obj = $this->scores->new_record($table_row);
//					$scores_obj->save();
					if(!$scores_obj->save())
					{	
					 $tx_status = false;
					 $msg = 'Score cannot be saved';
					}
//					echo $key.'=>>'.$value.'   ';
//					print_r($table_row);
				}
//				echo '<br><br><br>';
			}
    	if($tx_status == true)
    	{
       		$this->db->trans_commit();
    		$this->session->set_userdata('msg', 'Training Report: '.$summary.' saved successfully');
//    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/search/home');
    	}
    	else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/training_session/add_report/'.$training_session_id);
    	}


		}

	}

	function create($chw_group_id = 1, $project_id = 1) {

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'description', 'Description', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['description'] ) || $this->form_validation->run () == FALSE) {
			$this->load->model('chw/chw_group_model', 'chw_group');
			$this->load->model('chw/project_model', 'project');
			$data['chw_group_name'] = $this->chw_group->get_name($chw_group_id); 
			$data['project_name']   = $this->project->get_name($project_id); 
			$this->load->view ( 'chw/create_training_session',$data);
		} else {
			//@todo : date is not getting saved need to save it in table
			$this->load->model('chw/training_session_model', 'training_session');
			$this->load->model('chw/training_sessions_criteria_model', 'training_sessions_criteria');
			$this->load->model('chw/training_session_content_model', 'training_session_content');
			$this->load->library('utils');
			$this->load->library('Date_util');

			$data['chw_group_id'] = $chw_group_id; 
			$data['project_id']   = $project_id; 

			$data['date']  = $this->input->post ('date');
			$data['date']  = Date_util::change_date_format($data['date']);
//			$data['date']  = '2009-11-11';

			$data['description']  = $this->input->post ( 'description' );
			$data['faculty']  = $this->input->post ( 'faculty' );

    $tx_status = true;
    $this->db->trans_begin();

			$training_session_obj = $this->training_session->new_record($data);
			if(!$training_session_obj->save())
			{
				$msg = 'Training Session: '.$training_session_obj->description.' could not be saved';
				$tx_status = false;
			}
			$training_session_id = $training_session_obj->uid();

			$data = $this->input->post ( 'trainingTableData' );
//			$msg = $msg.' training table data '.$data;
			$training_parsed_data = $this->parse_table_data($data, 'training_topic');



			/*echo '<pre>';
			echo 'training_parsed_data';
			print_r($training_parsed_data);
			echo '<pre>';*/
			$cnt = 0;
			$new_data = array('training_session_id'=> $training_session_id);
			$no_rows = count($training_parsed_data);
//			$msg = $msg.' No of training '.$no_rows;
//			foreach($training_parsed_data as $training_parsed_data_row) 
			for($cnt=0; $cnt < $no_rows; $cnt++) {

//				$training_parsed_data_arr = explode('/', $training_parsed_data_row[$cnt]['training_topic']);
				$training_parsed_data_arr = explode('/', $training_parsed_data[$cnt]);
				/*echo '<pre>';
				print_r($training_parsed_data_arr);
				echo '<pre>';*/

				$arr_count = count($training_parsed_data_arr);
				if( $arr_count == 1){
					$new_data['content_id'] = Utils::extract_id($training_parsed_data_arr[0]);
					$new_data['type'] = 'module';
				}
				else if($arr_count == 2) {
					$new_data['content_id'] = Utils::extract_id( $training_parsed_data_arr[1]);
					$new_data['type'] = 'topic';
				}

				$content_obj = $this->training_session_content->new_record($new_data);
				if(!$content_obj->save())
				{
					$msg = 'Content Object: '.$content_obj->name.' could not be saved';
					$tx_status = false;
				}
//				echo '<pre>';
//				print_r($data);
//				$cnt++;

			}

			$data = $this->input->post ( 'criteriaTableData' );
			$criteria_parsed_data = $this->parse_table_data($data, 'criteria');
//			$msg = $msg.' criteria table data '.$criteria_parsed_data;

			$cnt = 0;
			$no_rows = count($criteria_parsed_data);
//			$msg = $msg.' criteria rows '.$no_rows;
//			foreach($criteria_parsed_data as $criteria_parsed_row) {
			for($cnt=0; $cnt < $no_rows; $cnt++) {
				$new_data['training_session_id'] = $training_session_id;
//				$new_data['criteria'] = $criteria_parsed_row[$cnt]['criteria'];
				$new_data['criteria'] = $criteria_parsed_data[$cnt];
				$criteria_obj = $this->training_sessions_criteria->new_record($new_data);
				if(!$criteria_obj->save())
				{
					$msg = 'Criteria Object: '.$criteria_obj->name.' could not be saved';
					$tx_status = false;
				}
//				$cnt++;
//				print_r($criteria_parsed_row);
			}
    	if($tx_status == true)
    	{
       		$this->db->trans_commit();
    		$this->session->set_userdata('msg', 'Training Session: '.$training_session_obj->description.' saved successfully');
//    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/search/home');
    	}
    	else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/training_session/create/'.$chw_group_id.'/'.$project_id);
    	}
		}

	}


	function edit($training_session_id = 0) {

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'description', 'Description', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->load->model('chw/training_session_model', 'training_session');
		$this->load->model('chw/training_sessions_criteria_model', 'criteria');
		$this->load->model('chw/training_session_content_model', 'training_session_content');
		$this->load->library('utils');
		$this->load->library('Date_util');
		$training_session = $this->training_session->select(array('projects.name AS project_name', 'chw_groups.name AS chw_group_name'))
												   ->from(array('projects','chw_groups'))
												   ->where('project_id','projects.id', false)
												   ->where('training_sessions.chw_group_id', 'chw_groups.id', false)
												   ->where('training_sessions.id', $training_session_id)
												   ->find();

		$this->form_data['training_session'] = &$training_session;

		$criterias =  $this->criteria->find_all_by('training_session_id', $training_session_id);
		$this->form_data['criterias'] = &$criterias;

		if (!$training_session) {
			echo 'training_session_id not found in db';
			return;
		}

		if ($this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/create_training_session', $this->form_data);
			return;
		}

//		  echo 'POST ARRAY<pre>';
//		  print_r($_POST);
		  $this->save($training_session_id);

	}


	function save($training_session_id = 0) {
		if($training_session_id == 0) {
			echo 'training_session_id is not sent properly';
			return;
		}

		$this->load->model('chw/training_session_model', 'training_session');
		$ts_obj = $this->training_session->find($training_session_id);

		$data['date']  = $this->input->post ('date');
		$ts_obj->date  = Date_util::change_date_format($data['date']);
		$ts_obj->description  = $this->input->post ('description');
		$ts_obj->faculty  = $this->input->post ('faculty');

$tx_status = true;
$this->db->trans_begin();

		if(!$ts_obj->save())
		{
			$msg = 'Training Session: '.$ts_obj->description.' could not be saved';
			$tx_status = false;
		}

		$this->load->model('chw/training_sessions_criteria_model', 'criteria');
		$criteria_id_to_del = $this->input->post('criteria_id_to_del');
		$criteria_arr       = $this->input->post('criteria_arr');

//		print_r($criteria_id_to_del);
//		print_r($criteria_arr);

		/*this is delete operation which deletes criteria from training_sessions_criterias table but
		 * due to foreign key constraints it can not be delted
		 * if($criteria_id_to_del) {
			foreach($criteria_id_to_del as $id) {
				$criteria = $this->criteria->find($id);
				$criteria->delete();
			}
		}*/


		if($criteria_arr) {
			foreach($criteria_arr as $criteria){
				$data['training_session_id'] = $training_session_id;
				$data['criteria'] = $criteria;
//				echo '<pre>';
//				print_r($data);
//				echo '<pre>';
				$criteria = $this->criteria->new_record($data);
//				$criteria->save();
				if(!$criteria->save())
				{
					$tx_status = false;
					$msg = 'Criteria '.$criteria.' could not be saved';
				}
			}
		}
    	if($tx_status == true)
    	{
       		$this->db->trans_commit();
    		$this->session->set_userdata('msg', 'Training Session: '.$training_session_id.' saved successfully');
//    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/search/home');
    	}
    	else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/training_session/edit/'.$training_session_id);
    	}
}


	private function parse_table_data($data = '', $field) {
			$splited_data = array ();
			$data_rows = explode ( '~', $data );

//    		array_pop ( $data_rows );
//			$cnt = 0;
//			foreach ( $data_rows as $row ) {

			$row_count = count($data_rows) - 1;
			for ($cnt=0; $cnt<$row_count; $cnt++ ) {
				$row_values = explode ( '|', $data_rows[$cnt] );
				$splited_data [$cnt] = $row_values [0];
//				$splited_data [$cnt] [$field] = $row_values [1];
//				$cnt ++;
			}
			return $splited_data;
	}

}

?>


