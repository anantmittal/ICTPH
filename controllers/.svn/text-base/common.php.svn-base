<?php
class common extends CI_Controller {
	public function Common() {
		parent::__construct ();
		//$this->load->model('demographic/family_model','family');
	}

	function name_autocomplete() {
		$str = $this->input->post ( 'q' );
		$this->family->name_autocomplete ( $str );
	}
	function get_family_head_list($str = 's') {
		$str = mysql_real_escape_string ( $this->input->post ( 'q' ) );
		$this->family->get_family_head_list ( $str );
	}

	function dateDiff($dformat, $endDate, $beginDate) {
		$date_parts1 = explode ( $dformat, $beginDate );
		$date_parts2 = explode ( $dformat, $endDate );
		$start_date = gregoriantojd ( $date_parts1 [0], $date_parts1 [1], $date_parts1 [2] );
		$end_date = gregoriantojd ( $date_parts2 [0], $date_parts2 [1], $date_parts2 [2] );
		return $end_date - $start_date;
	}

	function autocomplete($table = '') {

		if ($table == '') {
			return false;
		}
		$this->load->helper ( 'inflector' );
		$singular_table = singular ( $table );

		if ($table == 'districts' || $table == 'talukas' || $table == 'village_cities' || $table == 'areas') {
			
			$this->load->model ( 'geo/' . $singular_table . '_model', 'model_obj' );

			if (isset ( $_POST ['id'] )) {
				$search = $_POST ['id'];
			} else {
				echo '["0~No Results"]';
				return;
			}

			if ($table == 'districts')
			{ $parent_var = 'state_id';}
			else if($table == 'talukas')
			{ $parent_var = 'district_id';}
			else if ($table == 'village_cities')
			{ $parent_var = 'taluka_id';}
			else if($table == 'areas')
			{ $parent_var = 'village_city_id';}
			
			$object = $this->model_obj->where ( $parent_var, $search );
			$results = $object->find_all ();
			$list = array ();

			foreach ( $results as & $result ) {
				$list [] = $result->id . '~' . $result->name;
			}
			echo json_encode ( $list );
			return;
		} else {

//	  		$search  =  'training_module1 (2)/t';
//			$search  =  'training_module';
			$list = '';

			if ($table == 'training_modules') {
				if(isset($_GET['q'])) {
	  				$search = $_GET['q'];
	  			} else {
	  				echo 'Nothing to search for| Records Found|No Records';
	  				return;
	  			}

				$this->load->library ( 'utils' );

				$search_arr = explode ( '/', $search );
				$arr_num = count ( $search_arr );
				if ($arr_num > 1) {
					$module_id = Utils::extract_id ( $search_arr [0] );
//					$module_id = $search_arr [0];
					$this->load->model('chw/training_topic_model', 'training_topic');
					$object = $this->training_topic->where ( 'training_module_id', $module_id )->like('name', $search_arr [1]);

					$results = $object->find_all ();

					/*echo '<pre>';
					print_r($object);
					echo '<pre>';*/


					foreach ( $results as & $result ) {
						$list .= $search_arr [0].'/'. $result->name . ' (' . $result->id . ')|' . $result->name . '\n
	  				'; //splitting of upper and this line is necessary for autocomplete do not add upper and this line
					}

					if ($list != '') {
			//			echo json_encode ( $list );
						echo $list;
					} else {
						echo 'No Records Found|No Records';
					}
					return;
				}
				else
				{
					$this->load->model ( 'chw/training_module_model', 'model_obj' );
				
					$object = $this->model_obj->like ( 'name', $search );
					$results = $object->find_all ();
//					$results = $this->model_obj->find_all ();

					foreach ( $results as & $result ) {
						$list .= $result->name . ' (' . $result->id . ')|' . $result->name . '\n
	  					'; //splitting of upper and this line is necessary for autocomplete do not add upper and this line
					}

					if ($list != '') {
			//			echo json_encode ( $list );
						echo $list;
					} else {
						echo 'No Records Found|No Records';
					}
				}	
			}
//			echo 'outer<br>';
			else
			{
				
	  			$search = $_GET['q'];
				if($table == 'persons')
				{
					$this->load->model ( 'demographic/' . $singular_table . '_model', 'model_obj' );
//					$this->model_obj->select( 'full_name', 'name');
//					$this->model_obj->select( 'id', 'id');
//					$object = $object->like ( 'full_name', $search );
					$object = $this->model_obj->like ( 'full_name', $search );
				}
				else
				{
					$this->load->model ( 'chw/' . $singular_table . '_model', 'model_obj' );
					$object = $this->model_obj->like ( 'name', $search );
				}
				$results = $object->find_all ();
//				$results = $this->model_obj->find_all ();

				foreach ( $results as & $result ) {
					if($table == 'persons')
						$result->name = $result->full_name;
					$list .= $result->name . ' (' . $result->id . ')|' . $result->name . '\n
	  				'; //splitting of upper and this line is necessary for autocomplete do not add upper and this line
				}

				if ($list != '') {
			//		echo json_encode ( $list );
					echo $list;
				} else {
					echo 'No Records Found|No Records';
				}
			}	
		}	
	} // end of autocomplete function

	function mne_autocomplete($table = '') {

		if ($table == '') {
			return false;
		}
		$this->load->helper ( 'inflector' );
		$singular_table = singular ( $table );

		if ($table == 'survey_runs' ) {
			
			$this->load->model ( 'mne/' . $singular_table . '_model', 'model_obj' );

			if (isset ( $_POST ['id'] )) {
				$search = $_POST ['id'];
			} else {
				echo '["0~No Results"]';
				return;
			}

			$object = $this->model_obj->where ('survey_id', $search );
			$results = $object->find_all ();
			$list = array ();

			foreach ( $results as & $result ) {
				$list [] = $result->id . '~' . $result->name;
			}
			echo json_encode ( $list );
			return;
		} 
		else
		if ($table == 'forms' ) {
			
			$this->load->model ( 'mne/survey_form_model', 'model_obj' );
			$this->load->model ( 'mne/form_model', 'form_obj' );

			if (isset ( $_POST ['id'] )) {
				$search = $_POST ['id'];
			} else {
				echo '["0~No Results"]';
				return;
			}

/*			$object = $this->model_obj->where ('survey_id', $search,'false' );
			$results = $object->find_all ();*/
			$results = $this->form_obj->get_all_forms($search);
			$list = array ();

			foreach ( $results as & $result ) {
//				$form = $this->form_obj->find($result->form_id);
				$list [] = $result->id . '~' . $result->name;
			}
			echo json_encode ( $list );
			return;
		} 
	} // end of autocomplete function

	function opd_autocomplete($table = '') {

		if ($table == '') {
			return false;
		}
		$this->load->helper ( 'inflector' );
		$singular_table = singular ( $table );

	  	$search = $_GET['q'];
		$this->load->model ( 'scm/product_model', 'model_obj' );
		$object = $this->model_obj->like ( 'name', $search );

		$results = $object->find_all ();

		foreach ( $results as & $result ) {
			$list .= $result->name . ' '.$result->strength.'(' . $result->id . ')|' . $result->name . '\n
	  		'; //splitting of upper and this line is necessary for autocomplete do not add upper and this line
		}

		if ($list != '') {
	//		echo json_encode ( $list );
			echo $list;
		} else {
			echo 'No Records Found|No Records';
		}

	}
}
//end of controller
