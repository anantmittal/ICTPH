<?php
class testing extends CI_Controller {

	function index($id = 1) {
		if (isset ( $_POST ['start_date'] )) {
			print_r ( $_POST );
		}

		if ($id == 1)
			$this->load->view ( 'chw/chw_add' );

		if ($id == 2)
			$this->load->view ( 'chw/chw_followup_plan_add' );

		if ($id == 3)
			$this->load->view ( 'chw/health_product_add' );

		if ($id == 4)
			$this->load->view ( 'chw/add_sales' );

		if ($id == 5)
			$this->load->view ( 'chw/add_records' );

		if ($id == 6)
			$this->load->view ( 'chw/create_project' );

		if ($id == 7)
			$this->load->view ( 'chw/create_training_session' );
	}

	function search() {

		if (! isset ( $_POST ['search'] )) {
			$this->load->view ( 'chw/search_req' );
			return;
		}

		$topic = $this->input->post ( 'topic' );
		$value = $this->input->post ( 'value' );
		$by    = $this->input->post ( 'by' );

		echo '<pre>';
		print_r ( $_POST );
		echo '<pre>';

		if ($value == '') {
				echo 'value should not be blank';
				return;
		}


		if ($topic == 'chw') {
			if ($by == 'chw_name') {

				$this->load->model ( 'chw/chw_model', 'chw' );
				$chws = $this->chw->like ( 'name', $value )->find_all ();

				echo '<pre>';
				print_r ( $chws );
				echo '<pre>';
			}
		} elseif ($topic == 'chw_group') {

		} elseif ($topic == 'projects') {

		} elseif ($topic == 'training_module') {

		} elseif ($topic == 'health_product') {

			$this->load->model ( 'chw/health_product_model', 'health_product' );
			$health_products = $this->health_product->like ( 'name', $value )->find_all ();
			echo '<pre>';
			print_r($health_products);
			echo '<pre>';
		}
	}

	function autocomplete() {
		echo '1--Test one|One\n
		2--Test two|Two\n
		3--Test three|Three';
	}

	function autocomplete_product_list() {
		echo '1--Prod one|One\n
		2--Prod two|Two\n
		3--Prod three|Three';
	}

	function dissemination_autocomplete() {
		echo '1--dissemination one|One\n
		2--dissemination two|Two\n
		3--dissemination three|Three';
	}

	function list_districts() {
		$districts_arr = array ();
		$state_id = $_GET ['state_id'];
		$this->load->model ( 'chw/district_model', 'district' );

		$district_obj = $this->district->where ( 'state_id', $state_id );
		$districts = $district_obj->find_all ();

		foreach ( $districts as $district ) {
			$district_arr [] = $district->id . '~' . $district->name;
		}
		echo json_encode ( $district_arr );
	}

	function facebox($id) {
		$data['id'] = $id;
		$this->load->view('chw/status_update_box', $data);
	}
}
