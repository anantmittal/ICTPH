<?php

class Consumables_configuration extends CI_Controller {
	public function Consumables_configuration() {
		parent ::__construct();
		$this->load->library('session');
		$this->load->library('ignitedrecord/ignitedrecord');
		$this->load->model('admin/opd_services_model', 'opd_services');
		$this->load->model('admin/opd_services_configuration_model', 'service_config');
		$this->load->model('admin/stock_maintenance_model', 'stock_maintenance');
		$this->load->model('admin/stock_maintenance_configuration_model', 'maintenance_config');
		$this->load->model('admin/test_group_model', 'test_group');
		$this->load->model('admin/test_group_tests_model', 'test_group_tests');
		$this->load->model('admin/test_group_consumables_model', 'test_group_consumables');
		$this->load->model('scm/product_model', 'product');
		$this->load->model('opd/test_types_model', 'test_types');
		$this->load->helper('url');
		$this->load->helper('geo');
		$this->load->helper('form');
	}
	
	public function service($action=null){
		if($action == "add"){
			return $this->add_service();
		}else if($action == "edit"){
			return $this->update_service();
		}else if($action == "block_unblock"){
			return $this->block_unblock_service();
		}
	}
	
	private function load_service($failure_message = null,$sucess_message = null){
		$services_list = $this->opd_services->find_all();
		$data['services_list']=$services_list;
		$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
		$data['consumable_list'] = $consumable_list;
		$medications_list = $this->product->find_all_by('product_type','MEDICATION');
		$data['medications_list'] = $medications_list;
		$data['error_server'] = $failure_message;
		$data['success_message'] = $sucess_message;
		$this->load->view('admin/add_service',$data);
		return;
	}
	
	public function add_service(){
		if(!$_POST){
			$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
			$data['consumable_list'] = $consumable_list;
			$medications_list = $this->product->find_all_by('product_type','MEDICATION');
			$data['medications_list'] = $medications_list;
			$this->load->view('admin/add_service',$data);
			return;
		}
		$service_name=$_POST['service_name'];
		$service_desc=$_POST['service_desc'];
		$service_price=$_POST['service_price'];
		$check_service=$this->opd_services->find_by('name',$service_name);
		if($check_service!=null){
			$msg='Service '.ucwords($service_name)." already exists ";
			return $this->load_service($msg);
		}else{
			$this->db->trans_begin();
			$saved_value = $this->opd_services->save_service($service_name,$service_desc,$service_price);
			
			if(isset($_POST["selected_"])){
				foreach ($_POST["selected_"] as $values) {
					$service_config_obj=$this->service_config->save_products_to_service($values,$saved_value);
				}
			}
			$this->db->trans_commit();
			$msg = 'Service '.ucwords($saved_value->name) .' has been successfully added';
			return $this->load_service('',$msg);
			
		}
		
	}
	
	public function find_service($action){
		$service_list = $this->opd_services->find_all();
		$data['service_list'] = $service_list;
		if ($action == "edit") {
			$this->load->view('admin/edit_service', $data);
			return;
		} else
			if ($action == "block") {
				$this->load->view('admin/block_service', $data);
				return;
			}
	}
	
	public function edit_service($service_id){
		$services_list = $this->opd_services->find_all();
		$data['service_list'] = $services_list;
		$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
		$data['consumable_list'] = $consumable_list;
		$medications_list = $this->product->find_all_by('product_type','MEDICATION');
		$data['medications_list'] = $medications_list;
		$edit_service = $this->opd_services->find_by('id', $service_id);
		$data['edit_service'] = $edit_service;
		$service_config_details = $this->service_config->find_all_by('opd_service_id', $service_id);
		$data['service_config_details'] = $service_config_details;
		$this->load->view('admin/edit_service', $data);
		return;
		
	}
	
	public function edit_typed_service($service_name){
		$typed_service_name = $this->opd_services->find_by('name', $service_name);
		$this->edit_service($typed_service_name->id);
	}
	
	private function update_service(){
		$service_id=$_POST['service_id'];
		$updated_service_name=$_POST['service_name'];
		$updated_service_desc=$_POST['service_desc'];
		$updated_service_price=$_POST['service_price'];
		
		$this->db->trans_begin();
		$service = $this->opd_services->find_by('id', $service_id);
		
		//to update the service details 
		$service_data = array (
			"name" => $updated_service_name,
			"description" => $updated_service_desc,
			"price" => $updated_service_price
		);
		$this->db->where('id', $service->id);
		$this->db->update('opd_services', $service_data);
		$updated_service = $this->opd_services->find_by('id', $service_id);
		//to delete rows from 'opd_services_configurations' table 
		$this->db->where('opd_service_id', $service->id);
		$this->db->delete('opd_services_configurations');
		
		//to add selected consumables to 'opd_services_configurations' table
		if(isset($_POST["selected_"])){
			foreach ($_POST["selected_"] as $values) {
				$service_config_obj=$this->service_config->save_products_to_service($values,$updated_service);
			}
		}
		$this->db->trans_commit();
		$msg = 'Service ' . ucwords($updated_service->name) .' has been successfully edited';
		return $this->load_service('',$msg);
	}
	
	public function block_service($service_id){
		$services_list = $this->opd_services->find_all();
		$data['service_list'] = $services_list;
		$block_service = $this->opd_services->find_by('id', $service_id);
		$data['block_service'] = $block_service;
		$this->load->view('admin/block_service', $data);
		return;
		
	}
	
	public function block_typed_service($service_name){
		$typed_service_name = $this->opd_services->find_by('name', $service_name);
		$this->block_service($typed_service_name->id);
	}
	
	private function block_unblock_service(){
		$service_id = $_POST['service_id'];
		$service_status_check = $this->opd_services->find_by('id', $service_id);
		$this->db->trans_begin();

		if ($service_status_check->status) {
			$block_service= $this->opd_services->block_service($service_id);
			$msg = "Blocked";
		} else {
			$unblock_service = $this->opd_services->unblock_service($service_id);
			$msg = "Unblocked";
		}

		$this->db->trans_commit();
		$msg = 'Service ' . ucwords($service_status_check->name) . ' has been successfully ' . $msg;
		return $this->load_service('',$msg);
	}
	
	//Add/Edit/Delete Test Group
	public function test_groups($action=null){
		if($action == "add"){
			return $this->add_test_group();
		}else if($action == "edit"){
			return $this->update_test_group();
		}else if($action == "delete"){
			return $this->remove_test_group();
		}
	}
	private function load_test_group($failure_message = null,$sucess_message = null){
		$test_list = $this->test_types->where('is_added_to_group',0)->where('is_test_enabled',1)->find_all();
		$data['test_list'] = $test_list;
		$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
		$data['consumable_list'] = $consumable_list;
		$data['error_server'] = $failure_message;
		$data['success_message'] = $sucess_message;
		$this->load->view('admin/add_test_group',$data);
		return;
	}
	
	
	public function add_test_group(){
		if(!$_POST){
			$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
			$data['consumable_list'] = $consumable_list;
			$test_list = $this->test_types->where('is_added_to_group',0)->where('is_test_enabled',1)->find_all();
			$data['test_list'] = $test_list;
			
			$this->load->view('admin/add_test_group',$data);
			return;
		}else{
			$test_group_name=$_POST['test_group_name'];
			$test_group_desc=$_POST['test_group_desc'];
			$check_test_group=$this->test_group->find_by('name',$test_group_name);
			if($check_test_group!=null){
				$msg="Test Group ".ucwords($test_group_name)." already exists ";
				return $this->load_test_group($msg);
			}else{
				$this->db->trans_begin();
				$saved_value = $this->test_group->save_test_group($test_group_name,$test_group_desc);
				$test_group_id=$saved_value->id;
				if(isset($_POST["test_"])){
					foreach ($_POST["test_"] as $values) {
						$test_obj=$this->test_group_tests->save_tests_to_test_groups($values,$saved_value);
						$test_type_obj=$this->test_types->disable_tests($test_obj);
					}
				}
				if(isset($_POST["selected_"])){
					foreach ($_POST["selected_"] as $values) {
						$consumables_obj=$this->test_group_consumables->save_consumables_to_test_groups($values,$saved_value);
					}
				}
				$this->db->trans_commit();
				$msg = "Test Group ".ucwords($saved_value->name) .' has been successfully added';
				return $this->load_test_group('',$msg);
			}
		}
	}
	
	public function find_test_group($action){
		$test_group_list = $this->test_group->find_all();
		$data['test_group_list'] = $test_group_list;
		$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
		$data['consumable_list'] = $consumable_list;
		$test_list = $this->test_types->where('is_added_to_group',0)->where('is_test_enabled',1)->find_all();
		$data['test_list'] = $test_list;
		if ($action == "edit") {
			$this->load->view('admin/edit_test_group', $data);
			return;
		} else
			if ($action == "delete") {
				$this->load->view('admin/delete_test_group', $data);
				return;
			}
	}
	
	public function edit_test_group($test_group_id){
		
		//loads test groups for autopopulation
		$test_group_list = $this->test_group->find_all();
		$data['test_group_list'] = $test_group_list;
		
		//loads tests for autopopulation
		$test_list = $this->test_types->where('is_added_to_group',0)->where('is_test_enabled',1)->find_all();
		$data['test_list'] = $test_list;
		
		//loads consumables for autopopulation
		$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
		$data['consumable_list'] = $consumable_list;
		
		$edit_test_group = $this->test_group->find_by('id', $test_group_id);
		$data['edit_test_group'] = $edit_test_group;
		$test_config_details = $this->test_group_tests->find_all_by('test_group_id', $test_group_id);
		$data['test_config_details'] = $test_config_details;
		$consumable_config_details = $this->test_group_consumables->find_all_by('test_group_id', $test_group_id);
		$data['consumable_config_details'] = $consumable_config_details;
		$this->load->view('admin/edit_test_group', $data);
		return;
	}
	
	public function edit_typed_test_group($test_group_name){
		$typed_test_group_name = $this->test_group->find_by('name', $test_group_name);
		$this->edit_test_group($typed_test_group_name->id);
	}
	
	private function update_test_group(){
		$test_group_id=$_POST['test_group_id'];
		$updated_test_group_name=$_POST['test_group_name'];
		$updated_test_group_desc=$_POST['test_group_desc'];
		
		$this->db->trans_begin();
		$test_group = $this->test_group->find_by('id', $test_group_id);
		
		$test_group_data = array (
			"name" => $updated_test_group_name,
			"description" => $updated_test_group_desc
		);
		$this->db->where('id', $test_group->id);
		$this->db->update('test_groups', $test_group_data);
		$updated_test_group = $this->test_group->find_by('id', $test_group->id);
		 
		//to enable the disabled tests
		$tests=$this->test_group_tests->find_all_by('test_group_id',$test_group->id);
		if(isset($tests)){
			foreach ($tests as $values) {
				$test_type_obj=$this->test_types->enable_tests($values);
			}
		}
		//delete rows from test_group_tests table
		$this->db->where('test_group_id', $test_group->id);
		$this->db->delete('test_group_tests');
		
		//delete rows from test_group_consumables table
		$this->db->where('test_group_id', $test_group->id);
		$this->db->delete('test_group_consumables');
		
		//to add selected tests
		if(isset($_POST["test_"])){
			foreach ($_POST["test_"] as $values) {
				$test_obj=$this->test_group_tests->save_tests_to_test_groups($values,$updated_test_group);
				$test_type_obj=$this->test_types->disable_tests($test_obj);
			}
		}
		//to add selected consumables
		if(isset($_POST["selected_"])){
			foreach ($_POST["selected_"] as $values) {
				$consumables_obj=$this->test_group_consumables->save_consumables_to_test_groups($values,$updated_test_group);
			}
		}
		$this->db->trans_commit();
		$msg = 'Test Group ' . ucwords($updated_test_group->name) .' has been successfully edited';
		return $this->load_test_group('',$msg);
		
	}
	
	public function find_test_group_to_remove($test_group_id){
		$test_group_list = $this->test_group->find_all();
		$data['test_group_list'] = $test_group_list;
		$delete_test_group = $this->test_group->find_by('id', $test_group_id);
		$data['delete_test_group'] = $delete_test_group;
		$this->load->view('admin/delete_test_group', $data);
		return;
		
	}
	
	public function block_typed_test_group($test_group_name){
		$typed_test_group_name = $this->test_group->find_by('name', $test_group_name);
		$this->find_test_group_to_remove($typed_test_group_name->id);
	}
	
	private function remove_test_group(){
		$test_group_id=$_POST['test_group_id'];
		$test_group_name=$_POST['test_group_name'];
		$this->db->trans_begin();
		$tests=$this->test_group_tests->find_all_by('test_group_id',$test_group_id);
		
		if(isset($tests)){
			foreach ($tests as $values) {
				$test_type_obj=$this->test_types->enable_tests($values);
			}
		}
		//delete test groups
		$this->db->where('id', $test_group_id);
		$this->db->delete('test_groups');
		
		//delete rows from test_group_tests table
		$this->db->where('test_group_id', $test_group_id);
		$this->db->delete('test_group_tests');
		
		//delete rows from test_group_consumables table
		$this->db->where('test_group_id', $test_group_id);
		$this->db->delete('test_group_consumables');
		
		$this->db->trans_commit();
		$msg = 'Test Group ' . ucwords($test_group_name) .' has been successfully deleted';
		return $this->load_test_group('',$msg);
		
	}
	
	public function stock_maintenance($action=null){
		if($action == "add"){
			return $this->add_maintenance();
		}else if($action == "edit"){
			return $this->update_maintenance();
		}else if($action == "block_unblock"){
			return $this->block_unblock_maintenance();
		}
	}
	
	private function load_stock_maintenance($failure_message = null,$sucess_message = null){
		$maintenance_list = $this->stock_maintenance->find_all();
		$data['maintenance_list']=$maintenance_list;
		$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
		$data['consumable_list'] = $consumable_list;
		$data['error_server'] = $failure_message;
		$data['success_message'] = $sucess_message;
		$this->load->view('admin/add_maintenance',$data);
		return;
	}
	
	public function add_maintenance(){
		if(!$_POST){
			$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
			$data['consumable_list'] = $consumable_list;
			$this->load->view('admin/add_maintenance',$data);
			return;
		}
		$maintenance_name=$_POST['maintenance_name'];
		$maintenance_desc=$_POST['maintenance_desc'];
		$check_maintenance=$this->stock_maintenance->find_by('name',$maintenance_name);
		if($check_maintenance!=null){
			$msg='Maintenance '.ucwords($maintenance_name)." already exists ";
			return $this->load_stock_maintenance($msg);
		}else{
			$this->db->trans_begin();
			$saved_value = $this->stock_maintenance->save_maintenance($maintenance_name,$maintenance_desc);
			
			if(isset($_POST["selected_"])){
				foreach ($_POST["selected_"] as $values) {
					$maintenance_config_obj=$this->maintenance_config->save_consumables_to_maintenance($values,$saved_value);
				}
			}
			$this->db->trans_commit();
			$msg = 'Maintenance '.ucwords($saved_value->name) .' has been successfully added';
			return $this->load_stock_maintenance('',$msg);
			
		}
		
	}
	
	public function find_maintenance($action){
		$maintenance_list = $this->stock_maintenance->find_all();
		$data['maintenance_list']=$maintenance_list;
		if ($action == "edit") {
			$this->load->view('admin/edit_maintenance', $data);
			return;
		} else
			if ($action == "block") {
				$this->load->view('admin/block_maintenance', $data);
				return;
			}
	}
	
	public function edit_maintenance($maintenance_id){
		$maintenance_list = $this->stock_maintenance->find_all();
		$data['maintenance_list']=$maintenance_list;
		$consumable_list = $this->product->find_all_by('product_type','CONSUMABLES');
		$data['consumable_list'] = $consumable_list;
		$edit_maintenance = $this->stock_maintenance->find_by('id', $maintenance_id);
		$data['edit_maintenance'] = $edit_maintenance;
		$maintenance_config_details = $this->maintenance_config->find_all_by('stock_maintenance_id', $maintenance_id);
		$data['maintenance_config_details'] = $maintenance_config_details;
		$this->load->view('admin/edit_maintenance', $data);
		return;
		
	}
	
	public function edit_typed_maintenance($maintenance_name){
		$typed_maintenance_name = $this->stock_maintenance->find_by('name', $maintenance_name);
		$this->edit_maintenance($typed_maintenance_name->id);
	}
	
	private function update_maintenance(){
		$maintenance_id=$_POST['maintenance_id'];
		$updated_maintenance_name=$_POST['maintenance_name'];
		$updated_maintenance_desc=$_POST['maintenance_desc'];
		
		$this->db->trans_begin();
		$maintenance = $this->stock_maintenance->find_by('id', $maintenance_id);
		 
		$maintenance_data = array (
			"name" => $updated_maintenance_name,
			"description" => $updated_maintenance_desc
		);
		$this->db->where('id', $maintenance->id);
		$this->db->update('stock_maintenances', $maintenance_data);
		$updated_maintenance = $this->stock_maintenance->find_by('id', $maintenance_id);
		
		$this->db->where('stock_maintenance_id', $maintenance->id);
		$this->db->delete('stock_maintenance_configurations');
		
		if(isset($_POST["selected_"])){
			foreach ($_POST["selected_"] as $values) {
				$service_config_obj=$this->maintenance_config->save_consumables_to_maintenance($values,$updated_maintenance);
			}
		}
		$this->db->trans_commit();
		$msg = 'Maintenance ' . ucwords($updated_maintenance->name) .' has been successfully edited';
		return $this->load_stock_maintenance('',$msg);
	}
	
	public function block_maintenance($maintenance_id){
		$maintenance_list = $this->stock_maintenance->find_all();
		$data['maintenance_list']=$maintenance_list;
		$block_maintenance = $this->stock_maintenance->find_by('id', $maintenance_id);
		$data['block_maintenance'] = $block_maintenance;
		$this->load->view('admin/block_maintenance', $data);
		return;
		
	}
	
	public function block_typed_maintenance($maintenance_name){
		$typed_maintenance_name = $this->stock_maintenance->find_by('name', $maintenance_name);
		$this->block_maintenance($typed_maintenance_name->id);
	}
	
	private function block_unblock_maintenance(){
		$maintenance_id = $_POST['maintenance_id'];
		$maintenance_status_check = $this->stock_maintenance->find_by('id', $maintenance_id);
		$this->db->trans_begin();

		if ($maintenance_status_check->status) {
			$block_maintenance = $this->stock_maintenance->block_maintenance($maintenance_id);
			$msg = "Blocked";
		} else {
			$unblock_maintenance = $this->stock_maintenance->unblock_maintenance($maintenance_id);
			$msg = "Unblocked";
		}

		$this->db->trans_commit();
		$msg = 'Maintenance ' . ucwords($maintenance_status_check->name) . ' has been successfully ' . $msg;
		return $this->load_stock_maintenance('',$msg);
	}
}