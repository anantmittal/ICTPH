<?php

// TODO - the following require_once should not be required
//require_once(APPPATH.'controllers/opd/opd_base_controller.php');

class Retail extends Opd_base_controller {
	private $data = array();
	private $username = false;
	function __construct() {
		parent::__construct();

		 
		$this->load->model('user/user_model', 'user');

		$this->load->helper('medical');
		$this->load->helper('date');
		$this->load->dbutil();
		$this->load->library('form_validation');
		$this->load->library('utils');
		$this->load->library('date_util');
		 
		$this->username = $this->session->userdata('username');
		$this->load->model('scm/drug_generic_model', 'drug_gx');
		$this->load->model('scm/drug_brand_model', 'drug_brand');
		$this->load->model ( 'scm/scm_organization_model', 'locationname' );
		$this->load->model ( 'scm/transaction_model', 'tx' );
		$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
		$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
		$this->load->model('scm/product_model', 'product');
		$this->load->model('opd/retail_op_product_model', 'retail_opd_product');
		$this->load->model('opd/retail_op_product_detail_model', 'retail_opd_product_detail');
		$this->load->model('opd/provider_model', 'provider');
		$this->load->model('scm/product_model','product');
		

	}


	public function retails(){
		$username = $this->session->userdata('username');
		$location_id = $this->session->userdata('location_id');
		if(empty($location_id)){
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Location must be chosen ');
			redirect('opd/visit/home');
		}

		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );


		$this->form_data['date'] = Date_util::today();
		$location_id= $this->session->userdata('location_id');

		$this->load->model('opd/provider_location_model','pl_obj');
		$this->form_data['from_id'] = $this->pl_obj->find($location_id)->scm_org_id;

		$provider_locs = $this->get_data('provider_locations','name');


		$this->form_data['scm_orgs'] = $this->get_scm_orgs();
		//$stocks= $this->stock->where('location_id',$location_id)->where('quantity >', '0')->find_all();
		// = array();
	   // foreach($stocks as $stock){
	    //	$unique_products[$stock->product_id]=$stock->product_id;
	   // }array_unique($unique_products);
	    $this->form_data['gx_list_opdproducts']=$this->product->find_all_by('product_type','OUTPATIENTPRODUCTS');
		if (! isset ( $_POST ['date'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'opd/retail_view',$this->form_data );
		} else {

			$tx_status = true;
			$provider = $this->provider->find_by('username', $username);
			$this->db->trans_begin();
			$retail_obj=$this->retail_opd_product->new_record();
			$retail_obj->date=Date_util::to_sql($_POST['date']);
			$retail_obj->provider_id=$provider->id;
			$retail_obj->location_id=$location_id;
			$retail_obj->total_amount_collected=$_POST['bill_amount'];
			$product_names=$this->get_data('products','name');
			 
			if(!$retail_obj->save()){
				$home_msg = '3: Unable to save Retail OP Product ';
				$tx_status = false;
			}

			$retail_csv = '';
			$retail_csv=$retail_csv.'Sughavazhvu Healthcare Pvt Ltd'."\n";
			$retail_csv=$retail_csv.'Date: ,'.$_POST['date']."\n";
			$retail_csv=$retail_csv.'Name of the provider: ,'.$provider->full_name."\n";
			$retail_csv=$retail_csv.'Location: ,'.$this->pl_obj->find($location_id)->name."\n";
			$retail_csv=$retail_csv.'Total amount payable: ,'.$_POST['bill_amount']."\n";
			$retail_csv=$retail_csv.'Drug_Name,Quantity,Drug_MRP,Total '."\n";				
			foreach ($_POST["medication"] as $medication) {
				$retail_opd_obj = $this->retail_opd_product_detail->new_record();
				$retail_opd_obj->product_id =$medication['product_id'];
				$retail_opd_obj->MRP = $medication['rate'];
				$retail_opd_obj->retail_op_product_id = $retail_obj->id;
				$retail_opd_obj->quantity = $medication['quantity'];
				$retail_opd_obj->total_amount = $medication['rate']*$medication['quantity'] ;
				$retail_opd_obj->visit_id = $medication['visit_id'];

				$retail_csv=$retail_csv.$product_names[$medication['product_id']].','.$medication['quantity'].','.$medication['rate'].','.$medication['rate']*$medication['quantity']."\n";
					
				if(!$retail_opd_obj->save()){
					$home_msg = '3: Unable to save Retail OP Product ';
					$tx_status = false;
				}
				$prod_stocks=$this->stock->where('product_id',$medication['product_id'])->where('location_id',$location_id)->where('quantity >', '0')->find_all();
				$prod_details=$this->product->find_by('id',$medication['product_id']);
				if($medication['product_given']==='on'){
					$bal_qty = $medication['quantity']/$prod_details->retail_units_per_purchase_unit;
					foreach ($prod_stocks as $prod_stock){
						if($bal_qty !=0){
							if($prod_stock->quantity < $bal_qty){
								$bal_qty = $bal_qty - $prod_stock->quantity;
								$prod_stock->quantity = 0;
							}else{
								$prod_stock->quantity = $prod_stock->quantity - $bal_qty;
								$bal_qty = 0;
							}
							if(!$prod_stock->save()){
								$tx_status = false;
								$home_msg = ' Unable to save product batch item for '.$prod_stock->product_id ;
							}
						}
					}
					if($bal_qty >0){
						$tx_status = false;
						$home_msg = 'Stock for product '.$prod_details->name.' not sufficient by  '.$bal_qty;
					}
				}
			}

			$retail_csv=$retail_csv.',,,Total Amount '.$_POST['bill_amount'];
	
			if($tx_status == true){
				$this->db->trans_commit();
				$base_path = $this->config->item('base_path');
				$filename = 'uploads/opd/retail-'.$retail_obj->id.'.csv';
				$fp = fopen($base_path.$filename,"w");
				if(!fwrite($fp,$retail_csv))
				{
					echo "CSV File could not be written";
				}
				$home_msg='Retail OP Product saved successfully' ;
				$this->form_data['filetype'] = 'Retail Product Details';
				$this->form_data['filename'] = $filename;
				$this->form_data['success_message'] = $home_msg;
				$this->load->view ( 'opd/retail_view',$this->form_data );
			}else{
				$this->db->trans_rollback();
				$this->form_data['error_server'] = $home_msg;
				$this->load->view ( 'opd/retail_view',$this->form_data );
			}
		}
	}

	function get_data($table_name,$column_name) {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( $table_name );
		$o_rows = $o_obj->find_all ();
		foreach ( $o_rows as $o_row ) {
			$orgs [$o_row->id] = $o_row->$column_name;
		}
		return $orgs;
	}

	function get_scm_orgs() {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( 'scm_organizations' );
		$o_rows = $o_obj->find_all ();
		foreach ( $o_rows as $o_row ) {
			$orgs [$o_row->id] = $o_row->name;
		}
		return $orgs;
	}

}

	
 
