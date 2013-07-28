<?php
/**
 * @todo : proper error checking is needed when data is saved or retrived
 * @todo : owner id is hardcoded and need to put a auto complete for it.
 * @todo : need to move parse_table_data() function to new library as this is needed in many functionality
 * @author pankaj.khairnar
 *
 */
class project extends CI_Controller {
	private $form_data = array ();

	function create($chw_group_id = '') {

		if ($chw_group_id == '') {
			echo 'chw group id is not passed';
			return;
		}
		$this->load->model ( 'chw/chw_group_model', 'chw_group' );
		$chw_group = $this->chw_group->find ( $chw_group_id );

		if ($chw_group === false) {
			echo 'chw group id is not exist';
			return;
		}
		$this->form_data ['chw_group_name'] = $chw_group->name;
		$this->form_data ['chw_group_id'] = $chw_group_id;
		$this->save();
	}

	/*private function parse_table_data($data = '', $field = '') {
		$this->load->library ( 'utils' );
		$splited_data = array ();
		$data_rows = explode ( '~', $data );

		array_pop ( $data_rows );
		$cnt = 0;
		foreach ( $data_rows as $row ) {
			$row_values = explode ( '|', $row );
			$splited_data [$cnt] [$field] = Utils::extract_id ( $row_values [1] );
 	$cnt ++;
		}
		return $splited_data;
	}*/


	function edit($project_id = 0) {

		if ($project_id == 0) {
			echo 'project_id is not passed properly in url';
			return;
		}

		$this->load->model ( 'chw/project_model', 'project' );
		$this->load->model ( 'chw/projects_health_product_model', 'health_product' );
		$this->load->model ( 'chw/projects_test_model', 'projects_test' );
		$this->load->model ( 'chw/projects_dissemination_model', 'dissemination_test' );

		/*
		 * Query for owner_name support need to implement this functionlity
		 * $project =  $this->project->select(array('chw_groups.name AS group_name', 'owners.name AS owner_name'))
								  ->from(array('chw_groups', 'owners'))
								  ->where('chw_groups.id', 'chw_group_id', false)
								  ->where('owner_id', 'owners.id', false)
								  ->where('projects.id', $project_id, false)
								  ->find();*/

		$project =  $this->project->select(array('chw_groups.name AS group_name'))
								  ->from(array('chw_groups'))
								  ->where('chw_groups.id', 'chw_group_id', false)
								  ->where('projects.id', $project_id, false)
								  ->find();

		$this->form_data ['chw_group_name'] = $project->group_name;
		$this->form_data ['chw_group_id']   = $project->chw_group_id;
		$this->form_data ['description']    = $project->description;

		$this->form_data ['project_id'] = $project_id;
		$this->form_data ['name']       = $project->name;
		$this->form_data ['goal']       = $project->goal;
		$this->form_data ['project_manager']       = $project->project_manager;

		$health_product = $this->health_product->select ( array ('health_products.name AS product_name' ) )
											   ->from ( array ('health_products' ) )
											   ->where ( 'health_product_id', 'health_products.id', false )
											   ->where ( 'project_id', $project_id, false )
											   ->find_all ();

		$projects_test = $this->projects_test->select ( array ('tests.name AS test_name' ) )
											 ->from ( array ('tests' ) )
											 ->where ( 'test_id', 'tests.id', false )
											 ->where ( 'project_id', $project_id, false )
											 ->find_all ();

		$projects_disseminations = $this->dissemination_test->select ( array ('disseminations.name AS dissemination_name' ) )
													    ->from ( array ('disseminations' ) )
													    ->where ( 'dissemination_id', 'disseminations.id', false )
													    ->where ( 'project_id', $project_id, false )
													    ->find_all ();

		$this->form_data ['health_products'] = &$health_product;
		$this->form_data ['projects_tests']  = &$projects_test;
		$this->form_data ['projects_disseminations'] = &$projects_disseminations;
		$this->load->view ( 'chw/create_project', $this->form_data );
		$this->save();
	}

	function show($project_id = 0) {

		if ($project_id == 0) {
			echo 'project_id is not passed properly in url';
			return;
		}

		$this->load->model ( 'chw/project_model', 'project' );
		$this->load->model ( 'chw/projects_health_product_model', 'health_product' );
		$this->load->model ( 'chw/projects_test_model', 'projects_test' );
		$this->load->model ( 'chw/projects_dissemination_model', 'dissemination_test' );
		$this->load->model ( 'chw/training_session_model', 'ts' );
		$this->load->model ( 'chw/training_session_model', 'ts' );
		$this->load->model ( 'chw/training_session_attendance_model', 'tsa' );
		$this->load->model ( 'chw/training_session_report_score_model', 'tss' );
		$this->load->model ( 'chw/owner_model', 'owner' );
		$this->load->model ( 'chw/chw_model', 'chw' );
		$this->load->model ( 'chw/chw_group_member_model', 'chwg' );
		$this->load->model ( 'chw/chw_sale_model', 'chw_sales' );
		$this->load->model ( 'chw/visit_record_model', 'vr' );
		$this->load->model ( 'chw/followup_model', 'followup' );
		$this->load->model ( 'geo/village_citie_model', 'vc' );

		/*
		 * Query for owner_name support need to implement this functionlity
		 * $project =  $this->project->select(array('chw_groups.name AS group_name', 'owners.name AS owner_name'))
								  ->from(array('chw_groups', 'owners'))
								  ->where('chw_groups.id', 'chw_group_id', false)
								  ->where('owner_id', 'owners.id', false)
								  ->where('projects.id', $project_id, false)
								  ->find();*/

		$project =  $this->project->select(array('chw_groups.name AS group_name'))
								  ->from(array('chw_groups'))
								  ->where('chw_groups.id', 'chw_group_id', false)
								  ->where('projects.id', $project_id, false)
								  ->find();

		$this->form_data ['chw_group_name'] = $project->group_name;
		$this->form_data ['chw_group_id']   = $project->chw_group_id;
		$this->form_data ['description']    = $project->description;

		$this->form_data ['project_id'] = $project_id;
		$this->form_data ['name']       = $project->name;
		$this->form_data ['goal']       = $project->goal;
		$this->form_data ['project_manager']       = $project->project_manager;

		$owner_rec       = $this->owner->find($project->owner_id);
		$this->form_data ['owner_name']       = $owner_rec->name;

		$select = 'name AS name, sum(quantity) AS quantity, count(person_id) AS persons, avg(rate) AS rate';
		$from = 'projects_health_products, health_products, chw_sales';
		$where = '(project_id = '.$project_id.') AND (chw_sales.health_product_id = health_products.id) AND (projects_health_products.health_product_id = health_products.id) GROUP BY health_products.id';

		$query = 'SELECT '.$select.' FROM '.$from.' WHERE '.$where;
		$p_rows = $this->db->query($query);

/*		$p_rows = $this->health_product->select ( array ('health_products.name AS name','sum(quantity) AS quantity','count(person_id) AS persons','avg(rate) AS average' ) )
										   ->from ( array ('health_products','chw_sales' ) )
										   ->where ( 'project_id', $project_id, false )
										   ->where ( 'chw_sales.health_product_id', 'health_products.id', false )
										   ->where ( 'health_product_id', 'health_products.id', false )
										   ->groupby('health_products.id')
										   ->find_all ();
*/
		$ts_records = $this->ts->where('project_id',$project_id)->find_all();
		$ts_rows = array();
		$cnt = 0;
		foreach($ts_records as $ts_record)
		{
			$ts_rows[$cnt]['date'] = $ts_record->date;
			$ts_rows[$cnt]['id'] = $ts_record->id;
			$ts_rows[$cnt]['faculty'] = $ts_record->faculty;
			$ts_rows[$cnt]['description'] = $ts_record->description;
			$total_r = $this->tsa->select_count('chw_id','total_chws')->where('training_session_id',$ts_record->id)->find();
			$present_r = $this->tsa->select_count('status','att')->where('status','present')->where('training_session_id',$ts_record->id)->find();
			if($present_r->att >0)
			{
				$ts_rows[$cnt]['attendance'] = ($present_r->att / $total_r->total_chws)*100;
			
				$avg_r = $this->tss->select_avg('score','average')->where('training_session_id',$ts_record->id)->find();
				$ts_rows[$cnt]['score'] = $avg_r->average;
			}
			else
			{
				$ts_rows[$cnt]['attendance'] = 'NA';
			}

			$cnt++;
		}

/*		$projects_test = $this->projects_test->select ( array ('tests.name AS test_name' ) )
											 ->from ( array ('tests' ) )
											 ->where ( 'test_id', 'tests.id', false )
											 ->where ( 'project_id', $project_id, false )
											 ->find_all ();

		$projects_disseminations = $this->dissemination_test->select ( array ('disseminations.name AS dissemination_name' ) )
													    ->from ( array ('disseminations' ) )
													    ->where ( 'dissemination_id', 'disseminations.id', false )
													    ->where ( 'project_id', $project_id, false )
													    ->find_all ();
*/
		$c_records = $this->chwg->where('chw_group_id',$project->chw_group_id,false)->find_all();
		$c_rows = array();
		$cnt = 0;
		foreach($c_records as $c_rec)
		{
			$c_rows[$cnt]['id'] = $c_rec->chw_id;
			$chw_rec = $this->chw->find($c_rec->chw_id);
			$c_rows[$cnt]['name'] = $chw_rec->name;
			$c_rows[$cnt]['village'] = $this->vc->get_name($chw_rec->village_city_id);

			$scores_r = $this->tss->select_avg('score','avg_score')->where('chw_id',$c_rec->chw_id,false)->find();
			$c_rows[$cnt]['score'] = $scores_r->avg_score;

			$sales_r = $this->chw_sales->select_sum('quantity','sales')->where('chw_id',$c_rec->chw_id,false)->find();
			$c_rows[$cnt]['sales'] = $sales_r->sales;

			$visits_r = $this->vr->select_count('chw_id','number')->where('chw_id',$c_rec->chw_id,false)->find();
			$c_rows[$cnt]['visits'] = $visits_r->number;

			$f_r = $this->followup->select_count('chw_id','number')->where('chw_id',$c_rec->chw_id,false)->find();
			$c_rows[$cnt]['followups'] = $f_r->number;

			$cnt++;
		}


		$this->form_data ['p_rows'] = $p_rows->result();
		$this->form_data ['ts_rows'] = $ts_rows;
		$this->form_data ['c_rows'] = $c_rows;
//		$this->form_data ['projects_tests']  = &$projects_test;
//		$this->form_data ['projects_disseminations'] = &$projects_disseminations;
		$this->load->view ( 'chw/project_details', $this->form_data );
	}

	function save($chw_group_id = 0) {

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/create_project', $this->form_data );
			return;
		}

		/*echo 'In save function<br>POST ARRAY<pre>';
		print_r($_POST);
		echo '<pre>';*/

		$this->load->model ( 'chw/project_model', 'project' );
		$this->load->model ( 'chw/projects_health_product_model', 'health_product' );
		$this->load->model ( 'chw/projects_test_model', 'test' );
		$this->load->model ( 'chw/projects_dissemination_model', 'dissemination' );

		$project_arr = array ();

		$project_arr ['name'] = $this->input->post ( 'name' );
		$project_arr ['description'] = $this->input->post ( 'description' );
		$project_arr ['goal'] = $this->input->post ( 'goal' );
		$project_arr ['project_manager'] = $this->input->post ( 'project_manager' );
		$project_arr ['chw_group_id'] = $this->input->post ( 'chw_group_id');

    $tx_status = true;
    $this->db->trans_begin();

		if(isset($_POST['project_id'])) { //edit existing project
			$project_arr ['owner_id'] = $this->input->post ( 'owner_id' );
			$project_id = $this->input->post('project_id');
			$project_rec = $this->project->find($project_id);
			$project_rec->load_postdata(array('name', 'description', 'owner_id', 'goal','project_manager'));
			$project_rec->save(true);
/*			if(!$project_rec->save(true))
			{
				$msg = 'Project: '.$project_rec->name.' could not be saved';
				$tx_status = false;
			}*/
				// record updated

		} else {//create new project
			$project_arr ['owner_id'] = 1; //@todo : change this to appropriate value
			$project_rec = $this->project->new_record ( $project_arr );
			if(!$project_rec->save())
			{
				$msg = 'Project: '.$project_rec->name.' could not be saved';
				$tx_status = false;
			}
			$project_id = $project_rec->uid ();
		}

		/*echo '<pre>';
		print_r($project_rec);
		echo '<pre>';*/



		$obj [0] = 'health_product';
		$obj [1] = 'test';
		$obj [2] = 'dissemination';

		$data [0] = $this->input->post ( 'products' );
		$data [1] = $this->input->post ( 'tests' );
		$data [2] = $this->input->post ( 'disseminations' );

		/*echo 'data array<pre>';
		print_r($data);
		echo '<pre>';*/

		foreach ( $data as $key => $data_row ) {
			if (isset ( $data_row ['delete_row_id'] )) {
				foreach ( $data_row ['delete_row_id'] as $id ) {
					$rec = $this->$obj [$key]->find ( $id );
					if(!$rec->delete ())
					{
						$msg = 'Could not delete record: '.$rec->name;
						$tx_status = false;
					}
				}
			}

			if (isset ( $data_row ['new_id'] )) {
				foreach ( $data_row ['new_id'] as $id ) {
					$to_save = array ('project_id' => $project_id, $obj [$key] . '_id' => $id );
					$rec = $this->$obj [$key]->new_record ( $to_save );
					if(!$rec->save ())
					{
						$msg = 'Could not save record: '.$rec->name;
						$tx_status = false;
					}
				}
			}
		}

    	if($tx_status == true)
    	{
       		$this->db->trans_commit();
    		$this->session->set_userdata('msg', 'Project: '.$project_rec->name.' saved successfully');
		redirect('/chw/search/home');
		
    	}
    	else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/search/home');
    	}
    }

	function search_by_name($name = '') {
		
		$this->load->model ( 'chw/project_model', 'project' );
		if($name =="ALL")
		{
			$projects = $this->project->find_all();
		}
		else
		{
			$projects = $this->project->like ( 'name', $name)->find_all();
		}
		$data ['project_obj'] = $projects;

		$this->load->view ( 'chw/z_project_list', $data );
	}
}
