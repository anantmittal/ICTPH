<?php

//TODO this controller is not in used any more this is not a comment




class training extends CI_Controller {
	function create() {

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'description', 'Description', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['description'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/create_training_session' );
		} else {

			$this->load->model('chw/training_session_model', 'training_session');
			$this->load->model('chw/training_sessions_criteria_model', 'training_sessions_criteria');
			$this->load->model('chw/training_session_content_model', 'training_session_content');
			$this->load->library('utils');

			$data['chw_group_id'] = 1; // @todo : remove this hardcoded values to its appropriate value
			//will come project_id
			$data['project_id']   = 1; // @todo : remove this hardcoded values to its appropriate value
			//come from url
			$data['description']  = $this->input->post ( 'description' );


			$training_session_obj = $this->training_session->new_record($data);
			$training_session_obj->save();
			$training_session_id = $training_session_obj->uid();

			$data = $this->input->post ( 'trainingTableData' );
			$training_parsed_data = $this->parse_table_data($data, 'training_topic');



			/*echo '<pre>';
			echo 'training_parsed_data';
			print_r($training_parsed_data);
			echo '<pre>';*/
			$data = array('training_session_id'=> $training_session_id);
			foreach($training_parsed_data as $training_parsed_data_row) {

				$training_parsed_data_arr = explode('/', $training_parsed_data_row['training_topic']);
				/*echo '<pre>';
				print_r($training_parsed_data_arr);
				echo '<pre>';*/

				$arr_count = count($training_parsed_data_arr);
				if( $arr_count == 1){
					$data['content_id'] = Utils::extract_id($training_parsed_data_arr[0]);
					$data['type'] = 'module';
				}
				else if($arr_count == 2) {
					$data['content_id'] = Utils::extract_id( $training_parsed_data_arr[1]);
					$data['type'] = 'topic';
				}

				$content_obj = $this->training_session_content->new_record($data);
				$content_obj->save();
				echo '<pre>';
				print_r($data);


			}

			$data = $this->input->post ( 'criteriaTableData' );
			$criteria_parsed_data = $this->parse_table_data($data, 'criteria');

			foreach($criteria_parsed_data as $criteria_parsed_row) {
				$criteria_parsed_row['training_session_id'] = $training_session_id;
				$criteria_obj = $this->training_sessions_criteria->new_record($criteria_parsed_row);
				$criteria_obj->save();
				print_r($criteria_parsed_row);
			}
			die();
		}
	}

	private function parse_table_data($data = '', $field) {
			$splited_data = array ();
			$data_rows = explode ( '~', $data );

			array_pop ( $data_rows );
			$cnt = 0;
			foreach ( $data_rows as $row ) {
				$row_values = explode ( '|', $row );
				$splited_data [$cnt] [$field] = $row_values [1];
				$cnt ++;
			}
			return $splited_data;
	}

	function edit(){

	}
	function add_topics(){

	}
	function listing(){
 	}
}
?>