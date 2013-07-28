<?php
class chw extends CI_Controller {

	public $form_data = array ();
	
	function __construct() {
    	parent::__construct();
    	$this->load->helper('geo');
	}

	function create() {

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->form_data ['states'] = get_states ();

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/chw_add', $this->form_data );
		} else {
			$this->load->library ( 'date_util' );
			$this->load->model ( 'chw/chw_model' );

			$_POST ['start_date'] = Date_util::change_date_format ( $_POST ['start_date'] );
			$chw_obj = $this->chw_model->new_record ( $_POST );
//			$chw_obj->save ();
			if($chw_obj->save ())
			{
    				$this->session->set_userdata('msg', 'CHW: '.$chw_obj->name.' saved successfully');
				redirect('/chw/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'CHW: '.$chw_obj->name.' saved unsuccessful');
				$this->load->view ( 'chw/chw_add');
			}
		}
	}

	function edit_()
	{
		$url = "/chw/chw/edit/".$_POST['id_edit'];
		redirect($url);
	}
		

	function edit($chw_id = '') {

		if ($chw_id == '') {
			echo 'id should be enter to edit';
			return false;
		}

		$this->load->library ( 'form_validation' );
		$this->load->model ( 'chw/chw_model' );
		$this->form_data ['states'] = get_states ();
		$chw_obj = $this->chw_model->find ( $chw_id );
		$this->form_data ['chw_obj'] = & $chw_obj;

		$this->form_validation->set_rules ( 'name', 'Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/chw_add', $this->form_data );
		} else {
			$this->load->library ( 'date_util' );

			$_POST ['start_date'] = Date_util::change_date_format ( $_POST ['start_date'] );
			$chw_obj->load_postdata ( array ('name', 'code','phone_no','state_id', 'district_id', 'village_city_id', 'area_id', 'start_date', 'status', 'comment' ) );
//			$chw_obj->save ();
			if($chw_obj->save ())
			{
    				$this->session->set_userdata('msg', 'CHW: '.$chw_obj->name.' saved successfully');
				redirect('/chw/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'CHW: '.$chw_obj->name.' saved unsuccessful');
				$this->load->view ( 'chw/chw_add');
			}
		}
	}	

	function show($chw_id = '') {

		//		$this->output->enable_profiler(TRUE);


		if ($chw_id == '') {
			echo 'Please pass chw_id in url';
			return;
		}
		$this->load->library ( 'date_util' );
		$this->load->model ( 'chw/chw_model', 'chw' );
		$this->load->model ( 'chw/followup_model', 'followup' );
		$this->load->model ( 'chw/followup_event_model', 'followup_event' );
		$this->load->model ( 'chw/followup_event_report_model', 'followup_event_report' );
		$this->load->model ( 'chw/followup_health_product_model', 'followup_health_product' );
		$this->load->model ( 'chw/followup_test_model', 'followup_test' );
		$this->load->model ( 'chw/followup_dissemination_model', 'followup_dissemination' );
		$this->load->model ( 'chw/chw_sale_model', 'chw_sale' );
		$this->load->model ( 'chw/training_session_report_score_model', 'report_score' );
		$this->load->model ( 'chw/visit_record_model', 'visit_record' );

		$select = array ('states.name AS state_name', 'districts.name AS district_name','village_cities.name AS village_name','areas.name AS area_name' );
		$from = array ('states', 'districts', 'village_cities','areas' );

		/*Reference : Query used to display training session details
		SELECT p.name project_name, ts.description, ts.date, avg( score ) avg_score
		FROM training_session_report_scores, training_sessions AS ts, projects AS p
		WHERE training_session_report_scores.training_session_id = ts.id
		AND ts.project_id = p.id
		AND chw_id = 1
		GROUP BY training_session_id*/

		$report_score_obj = $this->report_score->select ( array ('ta.status AS attendance','ta.comment AS remark','p.id AS project_id','p.name AS project_name', 'ts.description', 'ts.date AS date' ) )->select_avg ( 'score', 'avg_score' )->from ( array ('training_sessions' => 'ts', 'projects' => 'p','training_session_attendances'=> 'ta' ) )->where ( 'training_session_report_scores.training_session_id', 'ts.id', false )->where ( 'ts.project_id', 'p.id', false )->where ( 'training_session_report_scores.chw_id', $chw_id, false )->where('ta.training_session_id','ts.id',false)->where('ta.chw_id',$chw_id,false)->group_by ( 'training_session_id' )->find_all ();
		/*echo '<pre>';
		print_r($report_score_obj);
		echo '<pre>';*/
		$this->form_data ['report_score_obj'] = $report_score_obj;

		$chw = $this->chw->select ( $select )->from ( $from )->where ( 'chws.state_id', 'states.id', false )->where ( 'chws.district_id', 'districts.id', false )->where ( 'chws.village_city_id', 'village_cities.id', false )->where ( 'chws.area_id', 'areas.id', false )->where ( 'chws.id', $chw_id )->get ();

		$this->form_data ['id'] = $chw->id;
		$this->form_data ['name'] = $chw->name;
		$this->form_data ['state_name'] = $chw->state_name;
		$this->form_data ['district_name'] = $chw->district_name;
		$this->form_data ['village_city'] = $chw->village_name;
		$this->form_data ['area_id'] = $chw->area_name;
		$this->form_data ['start_date'] = Date_util::date_display_format ( $chw->start_date );

		$select = array ('projects.name AS project_name' );
		$from = array ('projects' );
		$followups = $this->followup->get_all_followups ( $chw_id );


//		print_r($followups);
		$this->load->model('chw/test_model','test');
		$this->load->model('chw/health_product_model','health_product');
		$this->load->model('chw/dissemination_model','dissemination');

		foreach ( $followups as & $followup ) {
			$cnt = 0;
			$followup_event_obj = $this->followup_event->find_all_by ( 'followup_id', $followup ['followup_id'] );
			foreach($followup_event_obj as $followup_event) {
				$followup['event'][$cnt]['id'] = $followup_event->id;
				$followup['event'][$cnt]['date'] = Date_util::to_display($followup_event->date);
				$followup['event'][$cnt]['last_status'] = $followup_event->last_status;
				$followup['event'][$cnt]['type'] = $followup_event->type;
//				$this->load->model('chw/'.$followup_event->type.'_model','obj');
				$followup['event'][$cnt]['type_name'] = $this->{$followup_event->type}->find($followup_event->type_id)->name;
//				$followup['event'][$cnt]['type_name'] = 'Sprinkles';
				$cnt ++;
			}
		}
/*
		foreach ( $followups as & $followup ) {
			$cnt = 0;
			$followup_event_obj = $this->followup_event
									   ->find_all_by ( 'followup_id', $followup ['followup_id'] );
			foreach($followup_event_obj as $followup_event) {
				$followup['event'][$cnt]['id'] = $followup_event->id;
				$followup['event'][$cnt]['date'] = $followup_event->date;
				$followup['event'][$cnt]['last_status'] = $followup_event->last_status;

				$followup_tests = $this->followup_test->select(array('tests.name AS test_name'))
													   ->from(array('tests'))
													   ->where('test_id','tests.id',false)
													   ->where('followup_event_id',$followup_event->id)
													   ->find();
//				$followup['event'][$cnt]['test_name'] = $followup_tests->test_name;


				$followup_disseminations = $this->followup_dissemination->select(array('disseminations.name AS dissemination_name'))
													   ->from(array('disseminations'))
													   ->where('dissemination_id','disseminations.id',false)
													   ->where('followup_event_id',$followup_event->id)
													   ->find();
//				$followup['event'][$cnt]['dissemination_name'] = $followup_disseminations->dissemination_name;


				$followup_health_products = $this->followup_health_product->select(array('health_products.name AS product_name'))
													   ->from(array('health_products'))
													   ->where('health_product_id','health_products.id',false)
													   ->where('followup_event_id',$followup_event->id)
													   ->find();
//				$followup['event'][$cnt]['product_name'] = $followup_health_products->product_name;

				if($cnt == 0) {
					if($followup_tests) {$followup['tests'] = $followup_tests->test_name;} else {$followup['tests'] = '';}
					if($followup_health_products) {$followup['products'] = $followup_health_products->product_name;} else {$followup['products'] = '';}
					if($followup_disseminations) {$followup['disseminations'] = $followup_disseminations->dissemination_name;} else {$followup['disseminations'] = '';}
				} else {
					if($followup_tests) {$followup['tests']    = $followup['tests'].', '.$followup_tests->test_name;}
					if($followup_health_products) {$followup['products'] = $followup['products'].', '.$followup_health_products->product_name;}
					if($followup_disseminations) {$followup['disseminations'] = $followup['disseminations'] .', '. $followup_disseminations->dissemination_name;}
				}
				$cnt ++;
			}
		}
*/

		/*print_r($followups);
		die();*/
		/*foreach ( $followups as & $followup ) {

			$followup_event_obj = $this->followup_event->find_all_by ( 'followup_id', $followup ['followup_id'] );

			$followup ['health_products'] = '';
			$followup ['tests'] = '';
			$followup ['disseminations'] = '';

			foreach ( $followup_event_obj as $followup_event_row ) { //loop over all events related to one followup


				if ($followup_event_row->date != '')
					$followup ['date'] = Date_util::date_display_format ( $followup_event_row->date );

//				echo '<br><b>followup array</b><pre>';
//			    print_r($followup);
//			    echo '<pre>';
//			    die();

				//this code is for getting helth product related to perticualar event.
				$followup_health_products = $this->followup_health_product->select ( 'hp.name AS health_product_name' )->from ( 'health_products AS hp' )->where ( 'followup_health_products.health_product_id', 'hp.id', false )->where ( 'followup_health_products.followup_event_id', $followup_event_row->id, false )->find_all ();

				$prod = '';
				foreach ( $followup_health_products as $health_prod_row ) {
					$prod .= $health_prod_row->health_product_name . ', ';
				}
				$followup ['health_products'] .= $prod;
				//			    echo '<Br><br>event_id:'.$followup_event_row->id.'  product:'.$prod;


				$followup_tests = $this->followup_test->select ( 'tests.name AS test_name' )->from ( 'tests' )->where ( 'followup_tests.test_id', 'tests.id', false )->where ( 'followup_tests.followup_event_id', $followup_event_row->id, false )->find_all ();

				$test_str = '';
				foreach ( $followup_tests as $followup_test_row ) {
					$test_str .= $followup_test_row->test_name . ', ';
				}
				$followup ['tests'] .= $test_str;
				//			    echo '<Br><br>event_id:'.$followup_event_row->id.'  tests:'.$test_str;


				$followup_disseminations = $this->followup_dissemination->select ( 'disseminations.name AS dissemination_name' )->from ( 'disseminations' )->where ( 'dissemination_id', 'disseminations.id', false )->where ( 'followup_event_id', $followup_event_row->id, false )->find_all ();

				$dissemination_str = '';
				foreach ( $followup_disseminations as $followup_dissemination_row ) {
					$dissemination_str .= $followup_dissemination_row->dissemination_name . ', ';
				}

				$followup ['disseminations'] .= $dissemination_str;
				//			    echo '<Br><br>event_id:'.$followup_event_row->id.'  disseminations:'.$dissemination_str;


				$event_report_result_obj = $this->followup_event_report->find_by ( 'followup_event_id', $followup_event_row->id );



				//@todo : showing status is may not be necessary in chw details. because this functionaity is
				// showing by combining all report items and status is different for each item
				if ($event_report_result_obj !== false) {
					$followup ['status'] = $event_report_result_obj->status;
				} else
					$followup ['status'] = '';
			}

			if (! isset ( $followup ['status'] ))
				$followup ['status'] = '';

			if (! isset ( $followup ['date'] ))
				$followup ['date'] = '';

		}*/
//		echo '<pre>';
//		print_r($followups);
//		echo '<pre>';
		$this->form_data ['followups'] = $followups;

		$chw_sales_obj = $this->chw_sale->select ( array ('chws.name AS chw_name', 'health_products.name AS health_product_name' ) )->from ( array ('health_products', 'chws' ) )->where ( 'chw_sales.chw_id', 'chws.id', false )->where ( 'chw_sales.health_product_id', 'health_products.id', false )->where ( 'chws.id', $chw_id, false )->find_all ();
		/*echo '<pre>';
		print_r($chw_sales_obj);
		echo '<pre>';*/

		$this->form_data ['chw_sales_obj'] = $chw_sales_obj;

		$visit_records = $this->visit_record->find_all_by ( 'chw_id', $chw_id );
		$this->form_data ['visit_records'] = $visit_records;

		$this->load->view ( 'chw/chw_details', $this->form_data );
	}

	function search_by_name($name = '') {
		
		$this->load->model ( 'chw/chw_model', 'chw' );
		if($name =="ALL")
		{
			$chws= $this->chw->find_all();
		}
		else
		{
			$chws = $this->chw->like ( 'name', $name)->find_all();
		}

		$data ['chw_obj'] = $chws;

		$this->load->view ( 'chw/z_chws_list', $data );
	}

	function search_by_geo($geo_type = '', $key = '') {
		
		$this->load->model ( 'chw/chw_model', 'chw' );

		if($geo_type =="hamlet")
		{
			$this->load->model ('geo/area_model','area');
			$areas = $this->area->like('name',$key)->find_all();
			$area_ids = '(';
			$i=0;
			foreach ($areas as $area)
			{
				if($i!=0)
					{$area_ids = $area_ids.',';}
				$area_ids = $area_ids.$area->id;
			$i++;
			}
			$area_ids = $area_ids.')';
			$chws= $this->chw->find_all_by_sql("select * from chws where area_id in ".$area_ids.";");
		}

		if($geo_type =="village")
		{
			$this->load->model ('geo/village_citie_model','vc');
			$vcs = $this->vc->like('name',$key)->find_all();
			$vc_ids = '(';
			$i=0;
			foreach ($vcs as $vc)
			{
				if($i!=0)
					{$vc_ids = $vc_ids.',';}
				$vc_ids = $vc_ids.$vc->id;
			$i++;
			}
			$vc_ids = $vc_ids.')';
			$chws= $this->chw->find_all_by_sql("select * from chws where village_city_id in ".$vc_ids.";");
		}

		if($geo_type =="taluka")
		{
			$this->load->model ('geo/taluka_model','taluka');
			$talukas = $this->taluka->like('name',$key)->find_all();
			$t_ids = '(';
			$i=0;
			foreach ($talukas as $t)
			{
				if($i!=0)
					{$t_ids = $t_ids.',';}
				$t_ids = $t_ids.$t->id;
			$i++;
			}
			$t_ids = $t_ids.')';
			$chws= $this->chw->find_all_by_sql("select * from chws where taluka_id in ".$t_ids.";");
		}

		if($geo_type =="district")
		{
			$this->load->model ('geo/district_model','district');
			$districts = $this->district->like('name',$key)->find_all();
			$d_ids = '(';
			$i=0;
			foreach ($districts as $d)
			{
				if($i!=0)
					{$d_ids = $d_ids.',';}
				$d_ids = $d_ids.$d->id;
			$i++;
			}
			$d_ids = $d_ids.')';
			$chws= $this->chw->find_all_by_sql("select * from chws where district_id in ".$d_ids.";");
		}

		$data ['chw_obj'] = $chws;

		$this->load->view ( 'chw/z_chws_list', $data );
	}

	function add_sales($chw_id = '') {

		if ($chw_id == '') {
			echo 'chw id should be enter in url';
			return false;
		}

		$this->load->model ( 'chw/chw_model', 'chw' );
		$chw = $this->chw->find ( $chw_id );

		$this->form_data ['chw_name'] = $chw->name;
		$this->form_data ['type'] = 'add';

		if (!isset($_POST['submit_form_data'])) {
			$this->load->view ( 'chw/add_sales', $this->form_data );
			return;
		}
			$this->save_chw_sales_records($chw_id);
	}

	function edit_sales($chw_id = '') {

		if ($chw_id == '') {
			echo 'chw id should be enter in url';
			return false;
		}


		$this->load->model ( 'chw/chw_model', 'chw' );
		$this->load->model ( 'chw/chw_sale_model', 'sale' );
		$this->load->library ( 'date_util');



		if (!isset($_POST['submit_form_data'])) {
			$chw = $this->chw->find ( $chw_id );
			$this->form_data['type'] = 'edit';
			$this->form_data ['chw_name'] = $chw->name;
			$sale = $this->sale->select(array('health_products.name AS product_name'))
							   ->from(array('health_products'))
							   ->where('health_product_id', 'health_products.id',false)
							   ->where('chw_id', $chw_id)
							   ->find_all();
			$this->form_data['type'] = 'edit';
			$this->form_data ['chw_sales'] = $sale;
			$this->load->view ( 'chw/add_sales', $this->form_data );
			return;
		}

		$this->save_chw_sales_records($chw_id);
	}

	function save_chw_sales_records($chw_id = 0) {
		$this->load->model ( 'chw/chw_sale_model', 'sale' );
		$this->load->library ( 'date_util');

		$sales_records = $this->input->post('sales_records');
		$sale_id_del   = $this->input->post('sale_id_del');
//		echo '<pre> Following records added in database :<br>';
    $tx_status = true;
    $this->db->trans_begin();
		if($sales_records) {
			foreach($sales_records as $sales_record) {
				$sales_record['chw_id'] = $chw_id;
				$sales_record['date'] = Date_util::change_date_format($sales_record['date']);
				$sale = $this->sale->new_record($sales_record);
				$result = $sale->save();
				if(!$result) {
					$msg = 'Sale id: '.$sale->id.' not saved';
					$tx_status = false;
				//	print_r($sales_record);
				}
			}
		}

		if($sale_id_del) {
//			echo '<br>Following record of id are deleted from database:';
			foreach($sale_id_del as $id) {
//				echo $id .'  ';
				$sale = $this->sale->find($id);
//				$sale->delete();
				if(!$sale->delete()){
					$msg = 'Sale id: '.$id.' not deleted';
					$tx_status = false;
				//	print_r($sales_record);
				}
			}
		}
    	  if($tx_status == true)
    	  {
       		$this->db->trans_commit();
    		$this->session->set_userdata('msg', 'Sale records saved successfully');
		redirect('/chw/search/home');
		
    	  }
    	  else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/search/home');
    	  }
	}


	function edit_single_sale_record($sale_record_id = 0) {
//		echo $sale_record_id;
		$this->load->model('chw/chw_sale_model','sale');
		$this->load->library('date_util');

		if(!isset($_POST['date'])) {
			$sale = $this->sale->select(array('health_products.name AS product_name'))
							   ->from(array('health_products'))
							   ->where('health_product_id', 'health_products.id', false)
							   ->where('chw_sales.id',$sale_record_id)
							   ->find();
			if(!$sale) {
				echo 'record not found for id :'.$sale_record_id;
				return;
			}

			$sale_rec = array();
			$sale_rec['id']        = $sale->id;
			$sale_rec['chw_id']    = $sale->chw_id;
			$sale_rec['quantity']  = $sale->quantity;
			$sale_rec['rate']      = $sale->rate;
			$sale_rec['date']      = Date_util::date_display_format($sale->date);
			$sale_rec['person_id'] = $sale->person_id;

			$sale_rec['product']      = $sale->product_name .' ('.$sale->health_product_id.')';
			$sale_rec['health_product_id'] = $sale->health_product_id;

			$this->form_data['sale'] = $sale_rec;
			$this->load->view('chw/edit_single_sale_record',$this->form_data);
		} else {
			$id = $this->input->post('id');
			$data['date']      =  Date_util::change_date_format($this->input->post('date'));
		    $data['person_id'] =  $this->input->post('person_id');
		    $product           =  $this->input->post('product');
		    $data['quantity']  =  $this->input->post('quantity');
		    $data['rate']      =  $this->input->post('rate');

		    $product = explode(')', $product);
		    $product = explode('(', $product[0]);
		    $data['health_product_id'] = $product[1];

		    $sale = $this->sale->find($id);
		    $sale->load_data($data);
		    $result = $sale->save();

		    var_dump($result);

		    if($result){
		    	echo 'data updated successfully';
		    } else {
		    	echo 'error occured while saving data';
		    }

		}
	}



	function add_records($chw_id = '') {
		if ($chw_id == '') {
			echo 'please enter chw-id in url';
			return;
		}
		$this->load->model ( 'chw/chw_model','chw_model' );
		$this->load->model ( 'chw/visit_record_model','vr_model' );
		$chw_obj = $this->chw_model->find ( $chw_id );

		if ($chw_obj == false) {
			echo 'chw record not found for the id you have given';
			return;
		}
		$this->form_data ['chw_name'] = $chw_obj->name;
		$this->vr_model->where('chw_id',$chw_id);
		$this->form_data ['visit_records'] = $this->vr_model->find_all();

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'records', 'Data', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['records'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'chw/add_records', $this->form_data );
		} else {

			$this->save_chw_records ( $chw_id );
			die ();

		/* OLD CODING STYLE NOT IN USE NOW
			 * $splited_data = array ();

			$data = $this->input->post ( 'records_table_data' );
			$data_rows = explode ( '~', $data );
			array_pop ( $data_rows );
			print_r($data_rows);


			foreach ( $data_rows as $row ) {
				$row_values = explode ( '|', $row );
				echo 'row values';
				print_r($row_values);

				$splited_data ['chw_id']    = & $chw_id;
 				$splited_data ['date']      = Date_util::change_date_format ( $row_values [1] );
 				$splited_data ['person_id'] = 1; // @todo : change this hardcoded value to its approprite value
				$splited_data ['type']      = $row_values [3];
				$splited_data ['details']   = $row_values [4];
				$splited_data ['complaint'] = $row_values [5];
				$splited_data ['plan']      = $row_values [6];

				echo '<pre>';
				print_r($splited_data);
				echo '<pre>';
				$visit_record_obj = $this->visit_record->new_record($splited_data);
				$visit_record_obj->save();
			}
*/

		}
	}


	function edit_records($chw_id = '') {

		if ($chw_id == '') {
			echo 'please enter chw-id in url';
			return;
		}
		$this->load->model ( 'chw/chw_model' );
		$this->load->model ( 'chw/visit_record_model', 'visit_record' );
		$chw_obj = $this->chw_model->find ( $chw_id );

		if ($chw_obj == false) {
			echo 'chw record not found for the id you have given';
			return;
		}

		$visit_records = $this->visit_record->find_all_by ( 'chw_id', $chw_id );
		$this->form_data ['chw_name'] = $chw_obj->name;
		$this->form_data ['visit_records'] = $visit_records;


		if (isset($_POST['records']) || isset($_POST['id_to_delete'])) {

			print_r ( $_POST );
//			echo '<pre>';
			$this->save_chw_records ( $chw_id );
		} else {
			$this->load->view ( 'chw/add_records', $this->form_data );
		}
	}

	function edit_single_record($record_id = 0) {
		$this->load->library ( 'date_util' );
		$this->load->model ( 'chw/visit_record_model', 'visit_record' );
		$this->load->library ( 'form_validation' );

		$this->form_validation->set_rules ( 'date', 'Date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$visit_record = $this->visit_record->find($record_id);
		$data['visit_record'] = $visit_record;

		if ($this->form_validation->run () == FALSE) {
			$this->load->view('chw/edit_single_chw_record', $data);
		} else {
			$_POST['date'] =  Date_util::change_date_format($_POST['date']);
			$visit_record->load_postdata(array('date','person_id','type','details','complaint','plan'));
			$visit_record->save();
			redirect('chw/chw/edit_records/'.$visit_record->chw_id);
		}
	}

	function save_chw_records($chw_id) {

//		echo 'save function';
//		echo '<pre>';
//		print_r ( $_POST );
//		echo '<pre>';

		$this->load->library ( 'date_util' );
		$this->load->model ( 'chw/visit_record_model', 'visit_record' );

		$ids_to_delete = $this->input->post ( 'id_to_delete' );

    $tx_status = true;
    $this->db->trans_begin();

		if ($ids_to_delete) {
			foreach ( $ids_to_delete as $id ) {
				$visit_record = $this->visit_record->find($id);

//				if($visit_record)
//					$visit_record->delete();
				if(!$visit_record->delete())
				{
					$msg = 'Could not delete record with id: '. $id;
					$tx_status = false;
				}
			}
		}

		$records = $this->input->post ( 'records' );
		if($records) {
			foreach ( $records as $record ) {
				$record ['chw_id'] = $chw_id;
				$record ['person_id'] = 1; // @todo : change this hardcoded value to its approprite value
				$record ['date'] = Date_util::change_date_format ( $record ['date'] );
				$visit_record = $this->visit_record->new_record ( $record );
//				$visit_record->save ();
				if(!$visit_record->save ())
				{
					$msg = 'Could not save record for chw with id: '. $chw_id;
					$tx_status = false;
				}
			}
		}
    	  if($tx_status == true)
    	  {
       		$this->db->trans_commit();
    		$this->session->set_userdata('msg', 'Visit records saved successfully');
		redirect('/chw/search/home');
		
    	  }
    	  else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/search/home');
    	  }
	}

	function list_followup_events() {

	}

	function add_visits() {

	}

	function list_visits() {

	}

	function list_sales() {

	}
}
?>
