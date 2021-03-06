<?php
class order extends CI_Controller {
	public $form_data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->library('date_util');
		$this->load->model('scm/drug_generic_model', 'drug_gx');
		$this->load->model('scm/drug_brand_model', 'drug_brand');
		$this->load->model ( 'scm/scm_organization_model', 'locationname' );
		$this->load->model ( 'scm/opd_products_order_queue_model', 'opd_products_order_queue');
		$this->load->model ( 'scm/transaction_model', 'tx' );
		$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
		$this->load->model ( 'scm/order_model', 'order' );
		$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
		$this->load->model ( 'scm/order_invoice_receive_model', 'order_invoice_receive' );
		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
		$this->load->library('plsp/writer/pdfwriter');
		$this->load->model('opd/visit_opdproduct_entry_model', 'visit_opdproduct_entry');
		
	}
	
	function add()
	{
		$values = array();
		$j=0;
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );
		$this->form_data['scm_orgs'] = $this->get_scm_orgs();
		$this->form_data['internal_scm_orgs'] = $this->get_internal_scm_orgs();
		$this->form_data['date'] = Date_util::today();
		$location_id= $this->session->userdata('location_id');
		if($location_id)
		{
			$this->load->model('opd/provider_location_model','pl_obj');
			$this->form_data['from_id'] = $this->pl_obj->find($location_id)->scm_org_id;
			$this->form_data['to_id'] = 3;
		}
		else
		{
		
			$this->form_data['from_id'] = 3;
			$this->form_data['to_id'] = 4;
		}
		$product_names=$this->get_data('products','generic_name');
		$provider_locs = $this->get_data('provider_locations','name');
		
		$this->load->model('opd/opd_product_model', 'opd_product');
		$this->form_data['opd_product_list'] = $this->opd_product->find_all();
		$this->form_data['gx_list_medication'] = $this->drug_gx->find_all_by('product_type','MEDICATION');
		$this->form_data['gx_list_opdproducts'] = $this->drug_gx->find_all_by('product_type','OUTPATIENTPRODUCTS');
		$this->form_data['gx_list_consumables'] = $this->drug_gx->find_all_by('product_type','CONSUMABLES');
		
		
		if (! isset ( $_POST ['date'] ) || $this->form_validation->run () == FALSE) 
		{
			if($this->session->userdata('location_id')==null) 
			{
			$opd_product_queue_data = $this->opd_products_order_queue->where('status','PENDING')->find_all();
			}
			else
			{
				$opd_product_queue_data = $this->opd_products_order_queue->where('status','PENDING')->where('location_id',$this->session->userdata('location_id'))->find_all();
			}
			
			foreach($opd_product_queue_data as $opd_product_queue)
			{
				$values[$j]['product_name'] = $product_names[$opd_product_queue->product_id];
				$values[$j]['quantity'] =$opd_product_queue->quantity;
				$values[$j]['location'] =$provider_locs[$opd_product_queue->location_id];
				$values[$j]['product_id'] =$opd_product_queue->product_id;
				$values[$j]['pending_queue_id'] =$opd_product_queue->id;
				$values[$j]['generic_id'] =$opd_product_queue->generic_id;
				$generic_cost=$this->drug_gx->find_by('id',$opd_product_queue->generic_id);
				if($generic_cost->capacity == 1)
				{
					$rate = $generic_cost->retail_price*10;
					$values[$j]['cost'] =$rate;
				}
				else
				{
					$rate = $generic_cost->retail_price;
					$values[$j]['cost'] =$rate;
				}
				$values[$j]['visit_id'] = $opd_product_queue->visit_id;
				$j++;
			}
			
			$this->form_data['values'] = $values;
			$this->form_data['total_results'] = $j;
			$this->load->view ( 'scm/order_add',$this->form_data );
		}
		else 
		{
			$this->load->dbutil();
			$this->db->trans_begin();
			$tx_status = true;
			$order_csv = '';		
			/*Save order transaction and load it back to an object*/
			$tx_param = $_POST;
			$tx_obj = $this->tx->save_order_txn($tx_param,Date_util::to_sql($_POST['date']),$this->session->userdata("username"));
			if( $tx_obj === NULL)
			{
				$tx_status = false;
				$home_msg = '1: Unable to save transaction object ';
			}
			/*Save order with the new transaction id*/
			$order_obj = $this->order->save_order($tx_obj);
			if($order_obj === NULL)
			{
				$tx_status = false;
				$home_msg = '2: Unable to save order object';
			}

			$from_org =$this->scm_org->find($_POST['from_id']);
			$order_csv =$order_csv.'From:"'.$from_org->name.'"'."\n".'"'.$from_org->address.'"'."\n";
			$to_org =$this->scm_org->find($_POST['to_id']);
			$order_csv =$order_csv.'To: "'.$to_org->name.'"'."\n".'"'.$to_org->address.'"'."\n";
			$order_csv =$order_csv.'No: ,'.$order_obj->id.',,Date: ,'.$_POST['date']."\n\n\n\n\n\n";

			$order_csv =$order_csv.'SN,Generic Name,Unit,Quantity'."\n";
			
			$i=1;
			foreach ($_POST["medication"] as $medication) 
			{
				$tx_item_obj = $this->tx_item->new_record();
				$tx_item_obj->transaction_id = $tx_obj->id;
				$tx_item_obj->quantity = $medication['quantity'];
				$tx_item_obj->rate = $medication['rate'];
				/* While initiate an order its intiated on generic id 
				 * so we not updating product id by default it will take 0 for product id
				*/
				$tx_item_obj->generic_id = $medication['product_id'];
				if(isset($medication['visit_id']) && trim($medication['visit_id']) !='')
				{
					$tx_item_obj->visit_id = $medication['visit_id'];
				}
				$tx_item_obj->value = $medication['rate'] * $medication['quantity'];
				if(!$tx_item_obj->save())
				{
					$home_msg = '3: Unable to save transaction item entry for '.$tx_item_obj->product_id;
					//$this->session->set_userdata('msg', $home_message);
					$tx_status = false;
				}

				if(isset($medication['pending_queue_id']))
				{
					$updated_pending_status_id=$medication['pending_queue_id'];
					$update_pending_data = array (
							"status" => 'ORDERED'
					);
					$this->db->where('id', $updated_pending_status_id);
					$this->db->update('opd_products_order_queues', $update_pending_data);
				}
				$prod = $this->drug_gx->find($tx_item_obj->generic_id);
				$order_csv =$order_csv.$i.',"'.$prod->generic_name.' '.$prod->strength.' '.$prod->strength_unit.' '.$prod->capacity.'","'.$prod->purchase_unit.'",'.$tx_item_obj->quantity."\n";
				$i++;
			}
			if($tx_status == true)
			{
				$this->db->trans_commit();
				$base_path = $this->config->item('base_path');
				$filename = 'uploads/orders/order-'.$tx_obj->id.'.csv';
				$fp = fopen($base_path.$filename,"w");
				if(!fwrite($fp,$order_csv))
				{
					echo "CSV File could not be written";
				}
				$home_msg='Order with id : '.$order_obj->id.' saved successfully';
				$this->form_data['filetype'] = 'Order Details';
				$this->form_data['filename'] = $filename;
				if($this->session->userdata('location_id')==null) 
				{
					$opd_product_queue_data = $this->opd_products_order_queue->where('status','PENDING')->find_all();
				}
				else
				{
					$opd_product_queue_data = $this->opd_products_order_queue->where('status','PENDING')->where('location_id',$this->session->userdata('location_id'))->find_all();
				}
				
				foreach($opd_product_queue_data as $opd_product_queue)
				{
					$values[$j]['product_name'] = $product_names[$opd_product_queue->product_id];
					$values[$j]['quantity'] =$opd_product_queue->quantity;
					$values[$j]['location'] =$provider_locs[$opd_product_queue->location_id];
					$values[$j]['product_id'] =$opd_product_queue->product_id;
					$values[$j]['pending_queue_id'] =$opd_product_queue->id;
					$values[$j]['generic_id'] =$opd_product_queue->generic_id;
					$generic_cost=$this->drug_gx->find_by('id',$opd_product_queue->generic_id);
					if($generic_cost->capacity == 1)
					{
						$rate = $generic_cost->retail_price*10;
						$values[$j]['cost'] =$rate;
					}
					else
					{
						$rate = $generic_cost->retail_price;
						$values[$j]['cost'] =$rate;
					}
					$values[$j]['visit_id'] = $opd_product_queue->visit_id;
					$j++;
				}
				
				$this->form_data['values'] = $values;
				$this->form_data['total_results'] = $j;
				$this->form_data['success_message'] = $home_msg;
				$this->load->view ( 'scm/order_add',$this->form_data);
			}
			else
			{
				$this->db->trans_rollback();
				$this->form_data['error_server'] = $home_msg;
				$this->load->view ( 'scm/order_add',$this->form_data);
			}
		}
	}

	function list_orders(){

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$scm_orgs = $this->get_scm_orgs();
		$scm_orgs_origin = $this->get_scm_orgs_origin();
		$scm_orgs[0] = 'All';
		$this->form_data['scm_orgs'] = $scm_orgs;
		$location_id= $this->session->userdata('location_id');
		if($location_id){
			$this->load->model('opd/provider_location_model','pl_obj');
			$this->form_data['from_id'] = $this->pl_obj->find($location_id)->scm_org_id;
			$this->form_data['to_id'] = 3;
			$this->form_data['location_id'] = $location_id;
		}else{
			$this->form_data['from_id'] = 3;
			$this->form_data['to_id'] = 4;
		}
		if (! isset ( $_POST ['from_id'] ) || $this->form_validation->run () == FALSE) {

			$this->form_data['total_results'] = 0;
			$this->load->view ( 'scm/list_orders',$this->form_data );
		} else {
			$this->load->model ( 'scm/order_model', 'order' );
			$i=0;
			$values = array();
			$from_id = $_POST['from_id'];
			$to_id = $_POST['to_id'];
			//			$order_recs = $this->order->where('invoice_txid','0',false)->where('received_txid','0',false)->find_all();
			//			$order_recs = $this->order->find_all_by(array('invoice_txid','received_txid'),array('0','0'));
			$order_recs = $this->order->find_all_by('order_status','Pending');
				
			foreach($order_recs as $order_rec)
			{
				$this->load->model ( 'scm/transaction_model', 'transaction' );
				$tx_rec = $this->transaction->find($order_rec->order_txid);
				if(($from_id == $tx_rec->from_id && $to_id == $tx_rec->to_id) ||
						($from_id == 0 && $to_id == $tx_rec->to_id) ||
						($to_id == 0 && $from_id == $tx_rec->from_id) ||
						($to_id ==0 && $from_id ==0)
				)
				{
					$values[$i]['order_no'] = $order_rec->id;
					$values[$i]['date'] = Date_util::to_display($order_rec->order_date);
					$values[$i]['from'] = $scm_orgs[$tx_rec->from_id];
					$values[$i]['to'] = $scm_orgs[$tx_rec->to_id];
					$values[$i]['comment'] = $tx_rec->comment;
					$values[$i]['bill_amount'] = $tx_rec->bill_amount;
					$values[$i]['from_origin'] = $scm_orgs_origin[$tx_rec->from_id];
					$values[$i]['to_origin'] = $scm_orgs_origin[$tx_rec->to_id];
					$order_details=$this->order_invoice_receive->find_all_by('order_id',$order_rec->id);
					$show_invoice=true;
					if($order_details){
						foreach($order_details as $order_det){
							if(!isset($order_det->receive_txn_id)){
								$show_invoice=false;
								continue;
							}
						}
					}
					$values[$i]['show_invoice'] = $show_invoice;
					$i++;
				}
			}

			$this->form_data['from_id'] = $_POST['from_id'];
			$this->form_data['to_id'] = $_POST['to_id'];
			$this->form_data['total_results'] = $i;
			
			
			if($i == 0){
				$msg ='No Search Results';
			}
			$this->form_data['values'] = $values;
			$this->load->view ( 'scm/list_orders',$this->form_data );
		}
	}

	function get_order_details(){
		$url = "/scm/order/show/".$_POST['receive_id_edit'];
		redirect($url);
	}

	function list_maintenance(){
		$values = array();
		$i=0;
		$this->load->library('session');
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );
		$this->load->model('opd/stock_maintenance_historie_model', 'stock_maintenance_historie');

		$provider_locs = $this->get_data('provider_locations','name');
		$provider = $this->get_data('providers','full_name');
		$maintenance_name = $this->get_data('stock_maintenances','name');

		$provider_locs[0] = 'All';
		$this->form_data['provider_locs'] = $provider_locs;
		if(!$_POST){
			$maintenance_datas=$this->stock_maintenance_historie->find_all();
			foreach($maintenance_datas as $maintenance_data){
				$values[$i]['maintenance_name'] = $maintenance_name[$maintenance_data->stock_maintenance_id];
				$values[$i]['date'] = Date_util::to_display($maintenance_data->date);
				$values[$i]['location'] = $provider_locs[$maintenance_data->provider_location_id];
				$values[$i]['provider'] = $provider[$maintenance_data->provider_id];
				$values[$i]['comment'] = $maintenance_data->comment;

				$i++;
			}
			$this->form_data['values'] = $values;
			$this->form_data['total_results'] = $i;
			$this->load->view ( 'scm/list_maintenance',$this->form_data );
		}else{
			$provider_location_id=$_POST['provider_location_id'];
				
			if($provider_location_id !=0){

				if($_POST['from_date']!='DD/MM/YYYY' && $_POST['to_date']!='DD/MM/YYYY'){
					$from_date =  Date_util::change_date_format($_POST['from_date']);
					$to_date =  Date_util::change_date_format($_POST['to_date']);
					$maintenance_query='select * from stock_maintenance_histories where provider_location_id like "'.$provider_location_id.'" and date between "'.$from_date.'" and "'.$to_date.'" order by date';
				}else{
					$maintenance_query='select * from stock_maintenance_histories where provider_location_id like "'.$provider_location_id.'" ';
				}
			}else{

				if($_POST['from_date']!='DD/MM/YYYY' && $_POST['to_date']!='DD/MM/YYYY'){
					$from_date =  Date_util::change_date_format($_POST['from_date']);
					$to_date =  Date_util::change_date_format($_POST['to_date']);
					$maintenance_query='select * from stock_maintenance_histories where date between "'.$from_date.'" and "'.$to_date.'" order by date';
				}else{
					$maintenance_query='select * from stock_maintenance_histories';
				}
			}
			$query = $this->db->query($maintenance_query);
			if($query->num_rows() !=0) {
				foreach($query->result() as $maintenance_data){
					$values[$i]['maintenance_name'] = $maintenance_name[$maintenance_data->stock_maintenance_id];
					$values[$i]['date'] = Date_util::to_display($maintenance_data->date);
					$values[$i]['location'] = $provider_locs[$maintenance_data->provider_location_id];
					$values[$i]['provider'] = $provider[$maintenance_data->provider_id];
					$values[$i]['comment'] = $maintenance_data->comment;
						
					$i++;
				}
				if($_POST['from_date']!='DD/MM/YYYY' && $_POST['to_date']!='DD/MM/YYYY' ){
						
					$msg = 'Maintenance log for location ' . $provider_locs[$provider_location_id] . ' with Date between  '.$from_date.' and '.$to_date.' is as follows';
				}else{
					$msg = 'Maintenance log for location ' . $provider_locs[$provider_location_id] . ' is as follows';
				}
				//$this->session->set_userdata('msg', $msg);
				$this->form_data['success_message'] = $msg;
			}else{
				$msg="No Maintenance Entries Found";
				$this->form_data['error_server'] = $msg;
			}
				
			$this->form_data['values'] = $values;
			$this->form_data['total_results'] = $i;
			$this->form_data['provider_location_id'] = $provider_location_id;
			$this->load->view ( 'scm/list_maintenance',$this->form_data );
		}

	}

	function expiry(){

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['date'] ) || $this->form_validation->run () == FALSE) {
			$this->form_data['scm_orgs'] = $this->get_scm_orgs();
			$this->form_data['date'] = Date_util::today();
			$location_id= $this->session->userdata('location_id');
			if($location_id)
			{
				$this->load->model('opd/provider_location_model','pl_obj');
				$this->form_data['from_id'] = $this->pl_obj->find($location_id)->scm_org_id;
				//				$this->form_data['to_id'] = 3;
			}
			else
			{
				$this->form_data['from_id'] = 3;
				//				$this->form_data['to_id'] = 4;
			}

			$this->load->model('opd/opd_product_model', 'opd_product');
			$this->form_data['opd_product_list'] = $this->opd_product->find_all();
			$this->load->view ( 'scm/expiry_add',$this->form_data );
		} else {
			$this->load->model ( 'scm/transaction_model', 'tx' );
			$tx_obj = $this->tx->new_record ( $_POST );
			$tx_obj->type = 'Expiry';
			$tx_obj->date = Date_util::to_sql($_POST['date']);
			$tx_obj->username = $this->session->userdata("username");
			$this->load->dbutil();
			$this->db->trans_begin();
			$tx_status = true;
			$expiry_csv = '';
			if(!$tx_obj->save ())
			{
				$tx_status = false;
				$home_msg = '1: Unable to save transaction object ';
			}
			/*			$this->load->model ( 'scm/order_model', 'order' );
			 $order_obj = $this->order->new_record();
			$order_obj->order_txid = $tx_obj->id;
			$order_obj->order_date = $tx_obj->date;
			if(!$order_obj->save())
			{$tx_status = false;
			$home_msg = '2: Unable to save order object';}
			*/
			$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
			$from_org =$this->scm_org->find($_POST['from_id']);
			$expiry_csv =$expiry_csv.'From:"'.$from_org->name.'"'."\n".'"'.$from_org->address.'"'."\n";
			//			$to_org =$this->scm_org->find($_POST['to_id']);
			//			$order_csv =$order_csv.'To: "'.$to_org->name.'"'."\n".'"'.$to_org->address.'"'."\n";
			$expiry_csv =$expiry_csv.'No: ,'.$tx_obj->id.',,Date: ,'.$_POST['date']."\n\n\n\n\n\n";

			$expiry_csv =$expiry_csv.'SN,Brand Name,Generic Name,Batch No,Expiry,Quantity,Rate,Total'."\n";
			$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
			$i=1;
			foreach ($_POST["medication"] as $medication) {
				$tx_item_obj = $this->tx_item->new_record();
				$tx_item_obj->transaction_id = $tx_obj->id;
				$tx_item_obj->product_id = $medication['product_id'];
				$tx_item_obj->quantity = $medication['quantity'];
				$tx_item_obj->rate = $medication['rate'];
				$tx_item_obj->value = $medication['rate'] * $medication['quantity'];
				if(!$tx_item_obj->save()){
					$home_msg = '3: Unable to save transaction item entry for '.$tx_item_obj->product_id;
					$this->session->set_userdata('msg', $home_message);
					$tx_status = false;
				}
				$this->load->model('scm/product_model','product');
				$prod = $this->product->find($tx_item_obj->product_id);

				if($tx_item_obj->quantity > 0)
				{
					$prod_stocks = $this->stock
					->where('location_id',$_POST['from_id'],false)
					->where('product_id',$tx_item_obj->product_id,false)
					->where('quantity >','0',false)
					->order_by('expiry_date','ASC')
					->find_all();
					$bal_qty = $tx_item_obj->quantity;
					foreach ($prod_stocks as $prod_stock)
					{
						if($bal_qty !=0)
						{
							$tx_qty = 0;
							$batch_no = $prod_stock->batch_number;
							$expiry = Date_util::to_display($prod_stock->expiry_date);
							if($prod_stock->quantity < $bal_qty)
							{
								$tx_qty = $prod_stock->quantity;
								$bal_qty = $bal_qty - $prod_stock->quantity;
								$prod_stock->quantity = 0;
							}
							else
							{
								$prod_stock->quantity = $prod_stock->quantity - $bal_qty;
								$tx_qty = $bal_qty;
								$bal_qty = 0;
							}
							if(!$prod_stock->save())
							{
								$tx_status = false;
								$home_msg = '4: Unable to save product batch item for '.$prod_stock->product_id.' batch no '.$prod_stock->batch_number;
							}

			    $expiry_csv = $expiry_csv.$i.',"'.$prod->name.'","'.$prod->generic_name.'",'.$batch_no.','.$expiry.','.$tx_qty.','.$tx_item_obj->rate.','.$tx_qty*$tx_item_obj->rate."\n";
						}
						$i++;
					}
					if($bal_qty > 0)
					{
						$tx_status = false;
						$home_msg = '5: Stock for product '.$prod_stock->product_id.' not sufficient by  '.$bal_qty;
					}
				}

			}
			$expiry_csv = $expiry_csv.'Total value,,,,,,,'.$_POST['bill_amount'];

			if($tx_status == true)
			{
				$this->db->trans_commit();
				$base_path = $this->config->item('base_path');
				$filename = 'uploads/orders/expiry-'.$tx_obj->id.'.csv';
				$fp = fopen($base_path.$filename,"w");
				if(!fwrite($fp,$expiry_csv))
				{
					echo "CSV File could not be written";
				}
				$this->session->set_userdata('msg', 'Expiry with id : '.$tx_obj->id.' saved successfully');
				$data['filetype'] = 'Expiry Details';
				$data['filename'] = $filename;

				$username = $this->session->userdata('username');
				$this->load->model('user/user_model','user');
				$this->load->model('user/users_role_model','ur');
				$u_rec = $this->user->find_by('username',$username);
				//			$urs = $this->ur->find_all_by (array('user_id','role_id'),array($u_rec->id,'7'));
				$urs = $this->ur->find_by (array('user_id','role_id >'),array($u_rec->id,'1'));
				$home = $this->role->find($urs->role_id)->home_view;
				/*			if($urs != null)
				 {$home = '/opd/doc_home';}
				else
				{$home = '/scm/home';}*/
					
				$this->load->view($home,$data);
				//				redirect('/scm/search/home');
			}
			else
			{
				$this->db->trans_rollback();
				//    				$this->session->set_userdata('msg', 'Order save unsuccessful. Please try again');
				$this->session->set_userdata('msg', $home_msg);
				$this->load->view ( 'scm/expiry_add');
			}
		}

	}

	/*Commenting this method as this methos is not used currently*/
	//TODO Check with mayank and delete this method from this controller if this is not used in future.
	/*function add_stock(){

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );
		$this->load->library('date_util');


		if (! isset ( $_POST ['date'] ) || $this->form_validation->run () == FALSE) {
			$this->form_data['scm_orgs'] = $this->get_scm_orgs();
			$this->form_data['date'] = Date_util::today();
			$location_id= $this->session->userdata('location_id');
			if($location_id)
			{
				$this->load->model('opd/provider_location_model','pl_obj');
				$this->form_data['from_id'] = $this->pl_obj->find($location_id)->scm_org_id;
				//				$this->form_data['to_id'] = 3;
			}
			else
			{
				$this->form_data['from_id'] = 3;
				//				$this->form_data['to_id'] = 4;
			}

			$this->load->model('opd/opd_product_model', 'opd_product');
			$this->form_data['opd_product_list'] = $this->opd_product->find_all();
			$this->load->view ( 'scm/stock_add',$this->form_data );
		} else {
			$this->load->model ( 'scm/transaction_model', 'tx' );
			$tx_obj = $this->tx->new_record ( $_POST );
			$tx_obj->type = 'Stock';
			$tx_obj->date = Date_util::to_sql($_POST['date']);
			$tx_obj->username = $this->session->userdata("username");
			$this->load->dbutil();
			$this->db->trans_begin();
			$tx_status = true;
			$stock_csv = '';
			if(!$tx_obj->save ())
			{
				$tx_status = false;
				$home_msg = '1: Unable to save transaction object ';
			}
			/*			$this->load->model ( 'scm/order_model', 'order' );
			 $order_obj = $this->order->new_record();
			$order_obj->order_txid = $tx_obj->id;
			$order_obj->order_date = $tx_obj->date;
			if(!$order_obj->save())
			{$tx_status = false;
			$home_msg = '2: Unable to save order object';}
			*/
			/*$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
			$from_org =$this->scm_org->find($_POST['from_id']);
			$stock_csv =$stock_csv.'For:"'.$from_org->name.'"'."\n".'"'.$from_org->address.'"'."\n";
			//			$to_org =$this->scm_org->find($_POST['to_id']);
			//			$order_csv =$order_csv.'To: "'.$to_org->name.'"'."\n".'"'.$to_org->address.'"'."\n";
			$stock_csv =$stock_csv.'No: ,'.$tx_obj->id.',,Date: ,'.$_POST['date']."\n\n\n\n\n\n";

			$stock_csv =$stock_csv.'SN,Brand Name,Generic Name,Batch No,Expiry,Quantity,Rate,Total'."\n";
			$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
			$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
			$i=1;
			foreach ($_POST["medication"] as $medication) {
				$tx_item_obj = $this->tx_item->new_record();
				$tx_item_obj->transaction_id = $tx_obj->id;
				$tx_item_obj->product_id = $medication['product_id'];
				$tx_item_obj->quantity = $medication['quantity'];
				$tx_item_obj->rate = $medication['rate'];
				$tx_item_obj->value = $medication['rate'] * $medication['quantity'];
				if(!$tx_item_obj->save()){
					$home_msg = '3: Unable to save transaction item entry for '.$tx_item_obj->product_id;
					$this->session->set_userdata('msg', $home_message);
					$tx_status = false;
				}


				$batch_obj = $this->stock->new_record();
				$batch_obj->location_id = $tx_obj->from_id;
				$batch_obj->receipt_date= $tx_obj->date;
				$batch_obj->product_id = $medication['product_id'];
				$batch_obj->quantity = $medication['quantity'];
				$batch_obj->batch_number= $medication['batch_no'];
				$batch_obj->expiry_date = Date_util::to_sql($medication['expiry']);
				if(!$batch_obj->save()){
					$home_msg = '4: Unable to save Product Batch item entry for '.$batch_obj->product_id;
					$this->session->set_userdata('msg', $home_message);
					$tx_status = false;
				}

				$this->load->model('scm/product_model','product');
				$prod = $this->product->find($tx_item_obj->product_id);

				$stock_csv = $stock_csv.$i.',"'.$prod->name.'","'.$prod->generic_name.'",'.$batch_obj->batch_number.','.$batch_obj->expiry_date.','.$tx_item_obj->quantity.','.$tx_item_obj->rate.','.$tx_item_obj->quantity*$tx_item_obj->rate."\n";
				$i++;
			}

			$stock_csv = $stock_csv.'Total value,,,,,,,'.$_POST['bill_amount'];

			if($tx_status == true)
			{
				$this->db->trans_commit();
				$base_path = $this->config->item('base_path');
				$filename = 'uploads/orders/new-stock-'.$tx_obj->id.'.csv';
				$fp = fopen($base_path.$filename,"w");
				if(!fwrite($fp,$stock_csv))
				{
					echo "CSV File could not be written";
				}
				$this->session->set_userdata('msg', 'Stock with id : '.$tx_obj->id.' saved successfully');
				$data['filetype'] = 'Stock Details';
				$data['filename'] = $filename;

				$username = $this->session->userdata('username');
				$this->load->model('user/user_model','user');
				$this->load->model('user/users_role_model','ur');
				$u_rec = $this->user->find_by('username',$username);
				//			$urs = $this->ur->find_all_by (array('user_id','role_id'),array($u_rec->id,'7'));
				$urs = $this->ur->find_by (array('user_id','role_id >'),array($u_rec->id,'1'));
				$home = $this->role->find($urs->role_id)->home_view;
				/*			if($urs != null)
				 {$home = '/opd/doc_home';}
				else
				{$home = '/scm/home';}*/
					
				/*$this->load->view($home,$data);
				//				redirect('/scm/search/home');
			}
			else
			{
				$this->db->trans_rollback();
				//    				$this->session->set_userdata('msg', 'Order save unsuccessful. Please try again');
				$this->session->set_userdata('msg', $home_msg);
				$this->load->view ( 'scm/stock_add');
			}
		}

	}
*/
	//TODO Need to take care once invoice and receive order methods are updated to one to many relation
	function show($order_id = ''){
		if($order_id == '') {
			$this->session->set_userdata('msg', 'Please provide Order id for editting');
			redirect('/scm/search/home');
		}

		$this->load->model ( 'scm/order_model', 'order' );
		$order_obj = $this->order->find($order_id);
		if($order_obj == null) {
			$this->session->set_userdata('msg', 'Order id : '.$order_id.' does not exist');
			redirect('/scm/search/home');
		}
			
		$this->form_data['order_id'] =  $order_id;
		$this->load->model ( 'scm/transaction_model', 'tx' );
		$tx_obj = $this->tx->find($order_obj->order_txid);
		$scm_orgs = $this->get_scm_orgs();
		$this->form_data['order_date'] =Date_util::to_display($tx_obj->date);
		$this->form_data['order_from'] = $scm_orgs[$tx_obj->from_id];
		$this->form_data['order_to'] = $scm_orgs[$tx_obj->to_id];
		$this->form_data['bill_amount'] = $tx_obj->bill_amount;
		$this->form_data['comment'] = $tx_obj->comment;
		$this->load->model ( 'scm/transaction_item_model', 'tx_item_mod' );
		$this->load->dbutil();
		$tx_items = $this->tx_item_mod->find_all_by('transaction_id',$tx_obj->id);
		$order_items = array();
		$order_items_consumable = array();
		$i=0;
		$j=0;
		$k=0;
		
		foreach ($tx_items as $tx_item) {
			$order_items[$i]['product_id']=$tx_item->product_id;
			$this->load->model ( 'scm/drug_generic_model', 'product' );
			$prod =$this->product->find($tx_item->product_id);
			$drug_generics = $this->drug_gx->find($tx_item->generic_id);
			$prod_type=$drug_generics->product_type;
			if(isset($prod_type ) && $prod_type=='MEDICATION'){
				$order_items[$i]['generic_name']=$drug_generics->generic_name;
				$order_items[$i]['strength']=$drug_generics->strength.' '.$drug_generics->strength_unit;
				$order_items[$i]['unit']= $drug_generics->purchase_unit;
				$order_items[$i]['capacity']= $drug_generics->capacity;
				$order_items[$i]['quantity']= $tx_item->quantity;
				$order_items[$i]['rate']=$tx_item->rate;
				$i++;
			}else if(isset($prod_type ) && $prod_type=='CONSUMABLES'){
				$order_items_consumable[$j]['generic_name']=$drug_generics->generic_name;
				$order_items_consumable[$j]['strength']=$drug_generics->strength.' '.$drug_generics->strength_unit;
				$order_items_consumable[$j]['unit']= $drug_generics->purchase_unit;
				$order_items_consumable[$j]['capacity']= $drug_generics->capacity;
				$order_items_consumable[$j]['quantity']= $tx_item->quantity;
				$order_items_consumable[$j]['rate']=$tx_item->rate;
				$j++;
			}else if(isset($prod_type) && $prod_type=='OUTPATIENTPRODUCTS'){
				$order_items_opd[$k]['generic_name']=$drug_generics->generic_name;
				$order_items_opd[$k]['strength']=$drug_generics->strength.' '.$drug_generics->strength_unit;
				$order_items_opd[$k]['unit']= $drug_generics->purchase_unit;
				$order_items_opd[$k]['capacity']= $drug_generics->capacity;
				$order_items_opd[$k]['quantity']= $tx_item->quantity;
				$order_items_opd[$k]['rate']=$tx_item->rate;
				$order_items_opd[$k]['visit_id']=$tx_item->visit_id;
				$k++;
			}
		}
		
		$show_visit_link_url = 'index.php/opd/visit/show/';
		$this->form_data['show_visit_link_url'] = $show_visit_link_url;
		$this->form_data['number_items'] = $i;
		$this->form_data['number_items_consumable'] = $j;
		$this->form_data['number_items_opd'] = $k;
		if(isset($order_items)){
			$this->form_data['order_items'] = $order_items;
		}
		if(isset($order_items_consumable)){
			$this->form_data['order_items_consumable'] = $order_items_consumable;
		}
		if(isset($order_items_opd)){
			$this->form_data['order_items_opd'] = $order_items_opd;
		}
		$this->form_data['order_obj'] = $order_obj;
		
		$order_invoice_receive_recs = $this->order_invoice_receive->where('order_id',$order_id)->where('invoice_number !=','')->find_all();
		$this->form_data['transactions'] = $order_invoice_receive_recs;
		
		if(isset($_POST['order_id'])){
			if($this->can_manually_close_order($_POST['order_id'])){
				$this->close_order($_POST['order_id'],true);
				$home_msg='Order with Order Id '.$_POST['order_id'].' successfully closed';
				$this->form_data['success_message'] = $home_msg;
				$order_obj=$this->order->find($_POST['order_id']);
				$this->form_data['order_obj'] =$order_obj;
			}else{
				$home_msg='Order with Id '.$_POST['order_id'].' could not be closed';
				$this->form_data['error_server'] = $home_msg;
			}
		}
		
		
		if($this->locationname->find_by('id',$tx_obj->to_id)->origin==='EXTERNAL'){
			$this->form_data['receive_order_only'] = true;
		}else{
			$this->form_data['receive_order_only'] = false;
			$invoice_possible=$this->check_invoice($order_id);
			$this->form_data['invoice_possible'] = $invoice_possible;
		}
		if($order_obj->order_status==='Pending'){
			$this->form_data['order_valid_to_close'] = $this->can_manually_close_order($order_id);
		}else{
			$this->form_data['order_valid_to_close'] =false;
		}
		$this->load->view ( 'scm/show_order',$this->form_data );
	}
	
	private function check_invoice($order_id){
		$invoice_possible = false;
		$ordered_drugs = $this->tx_item->find_all_by('transaction_id',$this->order->find($order_id)->order_txid);
		foreach($ordered_drugs as $drugs){
			$ordered_qty = $this->get_total_qty($order_id,$drugs->generic_id,'ORDER');
			$invoiced_qty = $this->get_total_qty($order_id,$drugs->generic_id,'INVOICE');
			
			if(($ordered_qty-$invoiced_qty) !== 0){
				$invoice_possible = true;
			}			
		}
		return $invoice_possible;
	}
	
	// To close order manually
	function can_manually_close_order($order_id=''){
		$order_completed=true;
		
		$invoices_done=$this->order_invoice_receive->where('order_id',$order_id)->where('invoice_number !=','')->find_all();
		if(isset($invoices_done) ){
			foreach($invoices_done as $invoice){
				if(!isset($invoice->receive_txn_id) || $invoice->receive_txn_id==0){
					$order_completed=false;
					continue;
				}
			}
		}
		return $order_completed;
	}
	

	function edit_()
	{
		$url = "/scm/order/edit/".$_POST['o_id_edit'];
		redirect($url);
	}

	/* Commenting this part of code as currently we do not have Edit option for a orde
	 * And this method is not complete to edit an order.
	 */
	/*function edit($order_id = ''){
		if($order_id == '') {
			$this->session->set_userdata('msg', 'Please provide Order id for editting');
			redirect('/scm/search/home');
		}

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->load->model ( 'scm/order_model', 'order' );
		$order_obj = $this->order->find($order_id);
		if($order_obj == null) {
			$this->session->set_userdata('msg', 'Order id : '.$order_id.' does not exist');
			redirect('/scm/search/home');
		}
		if($order_obj->invoice_txid != null) {
			$this->session->set_userdata('msg', 'Order id : '.$order_obj->id.' has already been invoiced and cannot be editted');
			redirect('/scm/search/home');
		}


		if (! isset ( $_POST ['date'] ) || $this->form_validation->run () == FALSE) {
			$this->form_data['id'] =  $order_id;
			$this->load->model ( 'scm/transaction_model', 'tx' );
			$tx_obj = $this->tx->find($order_obj->order_txid);
			$this->form_data['scm_orgs'] = $this->get_scm_orgs();
			$this->form_data['date'] =$tx_obj->date;
			$this->form_data['from_id'] = $tx_obj->from_id;
			$this->form_data['to_id'] = $tx_obj->to_id;
			$this->load->model('opd/opd_product_model', 'opd_product');
			$this->form_data['opd_product_list'] = $this->opd_product->find_all();
			$this->load->view ( 'scm/order_add',$this->form_data );
		} else {
			$org_obj->load_postdata(array('type','name','address','phone_no','license_no'));
			if($org_obj->save ())
			{
				$this->session->set_userdata('msg', 'Organization: '.$org_obj->name.' saved successfully');
				//    				$this->session->set_userdata('msg', 'Product saved successfully');
				redirect('/scm/search/home');
			}
			else
			{
				//    				$this->session->set_userdata('msg', 'Product saved unsuccessful');
				$this->session->set_userdata('msg', 'Organization: '.$org_obj->name.' saved unsuccessful');
				$this->load->view ( 'scm/org_add', $this->form_data);
			}

		}
	}*/

	function create_invoice_()
	{
		$url = "/scm/order/create_invoice/".$_POST['c_id_edit'];
		redirect($url);
	}
	
	function get_total_qty($order_id,$generic_id,$type){
		$invoiced_qty = 0;
		if($type=="ORDER"){
			$transaction_id = $this->order->find($order_id)->order_txid;
			$this->db->select_sum('quantity');
	    	$this->db->from('transaction_items');
	    	$this->db->where('transaction_id', $transaction_id);
	    	$this->db->where('generic_id', $generic_id);
	    	$query = $this->db->get();
	    	$total_qty = $query->row()->quantity;
	    	if ($total_qty > 0){
	        	$invoiced_qty = $total_qty;
	    	}
		}else{
			$order_invoice_receive_recs = $this->order_invoice_receive->where('order_id',$order_id)->where('invoice_number !=','')->find_all();
			foreach ($order_invoice_receive_recs as $order_invoice_receive){
				$transaction_id = "";
				if($type === 'INVOICE'){
					$transaction_id = $order_invoice_receive->invoice_txn_id;
				}else if($type === 'RECEIVE'){
					$transaction_id = $order_invoice_receive->receive_txn_id;
				}else{
					$transaction_id =$order_id;
				}
				$this->db->select_sum('quantity');
		    	$this->db->from('transaction_items');
		    	$this->db->where('transaction_id', $transaction_id);
		    	$this->db->where('generic_id', $generic_id);
		    	$query = $this->db->get();
		    	$total_qty = $query->row()->quantity;
		    	if ($total_qty > 0){
		        	$invoiced_qty = $invoiced_qty + $total_qty;
		    	}	
			}
		}
		return $invoiced_qty;
	}

function create_invoice ($order_id = ''){
		if($order_id == '') {
			$this->session->set_userdata('msg', 'Please provide Order id for editting');
			redirect('/scm/search/home');
		}

		$order_obj = $this->order->find($order_id);
		if($order_obj == null) {
			$this->session->set_userdata('msg', 'Order id : '.$order_id.' does not exist');
			redirect('/scm/search/home');
		}

		if($order_obj->order_status == 'Closed' ) {
			$this->session->set_userdata('msg', 'Order id : '.$order_obj->id.' has already been Closed.');
			redirect('/scm/search/home');
		}
		if (! isset ( $_POST ['date'] ) ) {
			$this->form_data['today_date'] = Date_util::today();
			$this->form_data['order_id'] =  $order_id;
			$tx_obj = $this->tx->find($order_obj->order_txid);
			$this->form_data['scm_orgs'] = $this->get_internal_scm_orgs();
			$this->form_data['scm_with_license_list'] = $this->get_scm_registartion_id();//sac
			$this->form_data['date'] = Date_util::today();
			$this->form_data['order_date'] =$tx_obj->date;
			$this->form_data['order_from_id'] = $tx_obj->from_id;
			$this->form_data['order_to_id'] = $tx_obj->to_id;
			$this->load->dbutil();
			$org_rec = $this->scm_org->find($tx_obj->from_id);
			$org_recs = $this->scm_org->find($tx_obj->to_id);
			$tx_items = $this->tx_item->find_all_by('transaction_id',$tx_obj->id);
			$order_items = array();
			$i=0;
			foreach ($tx_items as $tx_item) {
				//Get already invoiced quantity for a given generic_id and order_id
				$invoiced_qty = $this->get_total_qty($order_obj->id,$tx_item->generic_id,'INVOICE');
				//Calculate quantity remaing to be invoiced
				$remaining_quantity = $tx_item->quantity - $invoiced_qty;
				//Allow invoicing if and only if $remaining_quantity greater than zero
				if($remaining_quantity > 0){
					$order_items[$i]['generic_id']=$tx_item->generic_id;
					$this->load->model ( 'scm/product_model', 'product' );
					
					$drug_gx =$this->drug_gx->find($tx_item->generic_id);
					$order_items[$i]['generic_name']=$drug_gx->generic_name.' '.$drug_gx->form;
					$order_items[$i]['strength']=$drug_gx->strength.' '.$drug_gx->strength_unit;
					$order_items[$i]['unit']= $drug_gx->purchase_unit;
					$order_items[$i]['quantity']= $remaining_quantity;
					$order_items[$i]['type']= $drug_gx->product_type;
					$order_items[$i]['visit_id']= $tx_item->visit_id;
					$visit_link_url = 'index.php/opd/visit/show/';
					$this->form_data['visit_link_url'] = $visit_link_url;
					//				$order_items[$i]['brand_name']=$drug_gx->name;
					$brands_recs=$this->product->find_all_by('generic_id',$tx_item->generic_id);
					$brand_ids = array();
					$brand_names = array();
					$rates = array();
					$stocks = array();
					$j=0;
					$this->load->model ( 'scm/pricelist_model', 'plist' );
	
					$plid = $org_rec-> pl_id;
					
					$total_qty_in_place = 0;
					$defauilt_brand_id = "";
					foreach($brands_recs as $brand){
						$total_qty=$this->stock->select_sum('quantity','t_quantity')->where('location_id', $tx_obj->to_id)->where('product_id', $brand->id)->find()->t_quantity;
						//$this->db->from('product_batchwise_stocks');
						//$this->db->where('location_id', $tx_obj->to_id);
						//$this->db->where('product_id', $brand->id);
						//$query = $this->db->get();
						//$total_qty = $query->row()->quantity;
						$total_qty=round($total_qty,2);
						$brand_ids[$j] = $brand->id;
						$brand_names[$brand->id] = $brand->name;
						//					$rates[$brand->id] = $brand->purchase_price;
						$plist_rec = $this->plist->where('pricelist_id',$plid,false)->where('product_id',$brand->id,false)->find();
						if($plist_rec)
							$rates[$brand->id] = $plist_rec->price;
						else
							$rates[$brand->id] = "NA";	
						$total_qty_in_place = $total_qty_in_place + $total_qty;
						if($total_qty != null)
							$stocks[$brand->id] =  $total_qty;
						else
							$stocks[$brand->id] =  0;
						$j++;
						if($total_qty != null && $total_qty > 0){
							$defauilt_brand_id = $brand->id;
						}
					}
					$order_items[$i]['d_brand_id']=$defauilt_brand_id;
					if($defauilt_brand_id == ""){
						$order_items[$i]['d_brand_id']=$brand_ids[0];
					}
					$order_items[$i]['total_qty_in_place']=$total_qty_in_place;
					$products = $this->stock->find_all_by(array('location_id','product_id','quantity >'),array($tx_obj->to_id,$defauilt_brand_id,'0'));
					$default_batch_numbers = array();
					$d_batch_number = "";
					$k = 0;
					foreach($products as $product){
						if($product->batch_number != "" && !empty($product->batch_number)){
							if($k == 0){
								$d_batch_number = $product->batch_number;
							}
							$default_batch_numbers[$product->batch_number] = $product->batch_number;
							$k++;
						}
					}
					
					$product = $this->stock->find_by(array('location_id','product_id','quantity >','batch_number'),array($tx_obj->to_id,$order_items[$i]['d_brand_id'],'0',$d_batch_number));
					$order_items[$i]['num_brands']=$j;
					$order_items[$i]['brand_ids']=$brand_ids;
					$order_items[$i]['brand_names']=$brand_names;
					$order_items[$i]['stocks']=$stocks;
					$order_items[$i]['rates']=$rates;
					$order_items[$i]['d_batch_names']=$default_batch_numbers;
					$order_items[$i]['d_batch_expiry']="Empty";
					$order_items[$i]['d_batch_stock']=0;
					
					if(isset($product) && !empty($product)){
						if(isset($product->expiry_date)){
							$order_items[$i]['d_batch_expiry']=Date_util::date_display_format($product->expiry_date);
						}
						$order_items[$i]['d_batch_stock']=$product->quantity;
					}
					$i++;
				}
			}
			if($org_recs->origin==='DISTRIBUTION'){
				$this->form_data['number_items'] = $i;
				$this->form_data['order_items'] = $order_items;
				$this->load->view ( 'scm/invoice_add',$this->form_data );
			}else if ($org_recs->origin==='CONSUMPTION'){
				$this->form_data['number_items'] = $i;
				$this->form_data['order_items'] = $order_items;
				$this->load->view ( 'scm/invoice_consumption_add',$this->form_data );
			}else{
			$this->session->set_userdata('msg', 'Invoice cannot be generated for Orders from External Location');
			redirect('/scm/search/home');
			}
		} else {
			$data['scm_orgs'] = $this->get_scm_orgs();
			$invoice_csv ='';
			$tx_obj = $this->tx->new_record ( $_POST );
			$tx_obj->date = Date_util::to_sql($_POST['date']);
			$tx_obj->username = $this->session->userdata("username");
			//$tx_obj->last_tx_id= $order_obj->invoice_txid ;
			$this->load->dbutil();
			$this->db->trans_begin();
			$tx_status = true;
			if(!$tx_obj->save ())
			{
				$tx_status = false;
				$home_msg = '1: Unable to save transaction object ';
			}

			$from_org =$this->scm_org->find($_POST['from_id']);
		
			$doc = new tcPdfWriter();
			$doc->InitDoc();
			$doc->PrepareDoc("", "right", "left", "Bottom", $this->config->item('logo_file'));
			$line1=array("Order Number:".$_POST['order_id'],"","Date:".$_POST['date']);
			$invoice_no_add=array("Invoice Number:".$tx_obj->id);
			$doc->WriteTable(array(), $line1, "Table");
			$doc->WriteTable(array(), $invoice_no_add, "Table");
			if($from_org->license_no!=NULL && trim($from_org->license_no)!="" ){
				$line2=array("License Number:".$from_org->license_no);
				$doc->WriteTable(array(), $line2, "Table");
			}else{
				$line2=array("");
				$doc->WriteTable(array(), $line2, "Table");
			}
				
			$to_org =$this->scm_org->find($_POST['to_id']);
			$addressheadings=array("From,","","To,");
			$addresscols[]=array($from_org->name."<br/>".$from_org->address,"", $to_org->name."<br/>".$to_org->address);
			$doc->WriteTable($addresscols, $addressheadings, "Table");
				
			//Currently it nor required as we don have an option to close an order while intiatng order
			/*$order_obj = $this->order->find($_POST['order_id']);
			if($order_obj->order_status !== $_POST['order_status']){
				$order_obj->order_status = $_POST['order_status'];
				if(!$order_obj->save(true)){
					$tx_status = false;
					$home_msg = '2: Unable to update order status ';
				}
			}*/
			
			$order_invoice_receive_obj = $this->order_invoice_receive->save_new_invoice($order_obj->id,$tx_obj);
			if($order_invoice_receive_obj == NULL){
				$tx_status = false;
				$home_msg = '3: Unable to save order invoice receive table';
			}
			
			$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
			$bill_amount = 0.0;

			$invoicedata=array();
			$headings=array("SN","Brand Name","Generic Name","Batch No", "Expiry", "Qty","Rate", "Total");


			for ($i=0; $i < $_POST['number_items']; $i++) {
				$product_id = $_POST['product_id_'.$i];
				$quantity = $_POST['quantity_'.$i];

				if($quantity > 0){
				  $this->load->model ( 'scm/product_model', 'product_m' );
				  $product_brand = $this->product_m->find($product_id);
				  
				  if(!empty($_POST['batch_expiry_'.$i]) && $_POST['batch_expiry_'.$i] != "Empty"){
				  	$expiry_date = $_POST['batch_expiry_'.$i];
				  	$expiry_date = Date_util::to_sql($expiry_date);
					  $prod_stocks = $this->stock
					  ->where('location_id',$_POST['from_id'],false)
					  ->where('product_id',$product_id,false)
					  ->where('quantity >','0',false)
					  ->where('batch_number',$_POST['batch_name_'.$i],true)
					  ->where('expiry_date',$expiry_date,true)
					  ->order_by('expiry_date','ASC')
					  ->find_all();
				  }else{
				  		$prod_stocks = $this->stock
					  ->where('location_id',$_POST['from_id'],false)
					  ->where('product_id',$product_id,false)
					  ->where('quantity >','0',false)
					  ->where('batch_number',$_POST['batch_name_'.$i],true)
					  ->find_all();
				  }
				  $bal_qty = $quantity;
				  foreach ($prod_stocks as $prod_stock){
				   if($bal_qty !=0){
				    $tx_qty = 0;
				    $expiry='';
				    $batch_no = $prod_stock->batch_number;
				    if(isset($prod_stock->expiry_date)){
				    	$expiry = Date_util::to_display($prod_stock->expiry_date);
				    }
				    if($prod_stock->quantity < $bal_qty){
				    	$tx_qty = $prod_stock->quantity;
				    	$bal_qty = $bal_qty - $prod_stock->quantity;
				    	$prod_stock->quantity = 0;
				    }else{
				    	$prod_stock->quantity = $prod_stock->quantity - $bal_qty;
				    	$tx_qty = $bal_qty;
				    	$bal_qty = 0;
				    }
				    if(!$prod_stock->save()){
				    	$tx_status = false;
				    	$home_msg = '3: Unable to save product batch item for '.$prod_stock->product_id.' batch no '.$prod_stock->batch_number;
				    }
	
				    $tx_item_obj = $this->tx_item->new_record();
				    $tx_item_obj->transaction_id = $tx_obj->id;
				    $tx_item_obj->product_id = $_POST['product_id_'.$i];
				    $tx_item_obj->product_batch_id = $prod_stock->id;
				    $tx_item_obj->quantity = $_POST['quantity_'.$i];
				    $tx_item_obj->rate = $_POST['rate_'.$_POST['product_id_'.$i]];
				    $tx_item_obj->value = $_POST['rate_'.$_POST['product_id_'.$i]] * $_POST['quantity_'.$i];
				    $tx_item_obj->generic_id = $_POST['generic_id_'.$i];
				    $tx_item_obj->visit_id = $_POST['visit_id_'.$i];
				    $tx_item_obj->batch_number = $_POST['batch_name_'.$i];
				    if(!empty($_POST['batch_expiry_'.$i]) && $_POST['batch_expiry_'.$i] != "Empty"){
				    	$tx_item_obj->expiry_date = $expiry_date;
				    }
				    $bill_amount = $bill_amount + $tx_item_obj->value;
				    if(!$tx_item_obj->save()){
				    	$home_msg = '4: Unable to save transaction item for '.$tx_item_obj->product->id;
				    	$this->session->set_userdata('msg', $home_message);
				    	$tx_status = false;
				    }
				    $invoicedata[]=array($invoice_csv.($i+1), $product_brand->name, $product_brand->generic_name, $batch_no, $expiry, $tx_qty, $tx_item_obj->rate, $tx_item_obj->value);
				     
				   }
				  }
				  if($bal_qty > 0){
				  	$tx_status = false;
				  	$home_msg = '5: Stock for product '.$tx_item_obj->product_id.' not sufficient by  '.$bal_qty;
				  }
				}
			}
			$invoicedata[] = array("Total","","","","","","",$bill_amount);
			$doc->WriteTable($invoicedata, $headings, "Table 1",1,array('border'=>1,'width'=>array(7,15,30,10,15,5,8,10)));
			if($tx_status == true)
			{
				$this->db->trans_commit();
				$base_path = $this->config->item('base_path');
				$filename = 'uploads/invoices/'.$_POST['order_id'].'-invoice.pdf';
				$doc->Output($filename, 'F');

				$this->session->set_userdata('msg', 'Invoice saved for Order with id : '.$order_obj->id.' saved successfully');
				$data['filetype'] = 'Invoice Details';
				$data['filename'] = $filename;
				$this->load_scm_home($data);
				//				redirect('/scm/search/home');
			}
			else
			{
				$this->db->trans_rollback();
				//    				$this->session->set_userdata('msg', 'Invoice generation unsuccessful. Please try again');
				$this->session->set_userdata('msg', 'Invoice generation unsuccessful. '.$home_msg.' Please try again');
				redirect('/scm/search/home');
				//				$this->load->view ( 'scm/search/home');
			}
		}
	}

	function load_scm_home($data){
		$this->load->model('scm/drug_generic_model', 'drug_generic');
		$this->load->model('scm/drug_brand_model', 'drug_brand');
		$this->load->model ( 'scm/scm_organization_model', 'locationname' );

		$data['scm_orgs'] = $this->get_scm_orgs();

		$generic_drug_list=$this->drug_generic->find_all();
		$data['generic_drug_list'] = $generic_drug_list;
		 
		$brand_drug_list=$this->drug_brand->find_all();
		$data['brand_drug_list'] = $brand_drug_list;
		 
		$organizations_list=$this->locationname->find_all();
		$data['organizations_list'] = $organizations_list;

		$this->load->view('scm/home',$data);
	}

	function receive_order_(){
		$url = "/scm/order/receive_order/".$_POST['r_id_edit'];
		redirect($url);
	}

	function receive_order ($order_id = ''){
		if($order_id == '') {
			$this->session->set_userdata('msg', 'Please provide Order id for receiving');
			redirect('/scm/search/home');
		}
		
		$order_obj = $this->order->find($order_id);
		if($order_obj == null) {
			$this->session->set_userdata('msg', 'Order id : '.$order_id.' does not exist');
			redirect('/scm/search/home');
		}
		
		if($order_obj->order_status == 'Closed' ) {
			$this->session->set_userdata('msg', 'Order id : '.$order_obj->id.' has already been Closed.');
			redirect('/scm/search/home');
		}

		$this->form_data['order_id'] =  $order_id;
		$tx_obj = $this->tx->find_by('id',$order_obj->order_txid);
		if(!$this->can_receive($tx_obj->from_id)){
			$this->session->set_userdata('msg', 'You are not authorised to received order for location: '.$tx_obj->from_id);
			redirect('/scm/search/home');
		}
		
		$scm_record = $this->scm_org->find_by('id',$tx_obj->to_id);
		if($scm_record->origin == "EXTERNAL"){
			$this->receive_external_order($order_id);
		}else{
			$this->receive_internal_order($order_id);
		}
	}
	
	private function receive_internal_order($order_id){
		$order_invoice_receive_recs = $this->order_invoice_receive->where('order_id',$order_id)->where('invoice_number !=','')->find_all();
		if(empty($order_invoice_receive_recs) || sizeof($order_invoice_receive_recs) <= 0){
			$this->session->set_userdata('msg', 'No invoice has been generated for the order : '.$order_id);
			redirect('/scm/search/home');
		}
		if(sizeof($order_invoice_receive_recs) === 1){
			$order_invoice_receive_rec = array_shift($order_invoice_receive_recs);
			$this->receive_order_on_invoice($order_id,$order_invoice_receive_rec->invoice_txn_id);
		}else{
			$invoices_array = array();
			$i = 0;
			$scm_orgs = $this->get_scm_orgs();
			foreach ($order_invoice_receive_recs as $order_invoice_receive_rec){
				if($order_invoice_receive_rec->receive_txn_id == null || empty($order_invoice_receive_rec->receive_txn_id)){
					$tx_obj = $this->tx->find($order_invoice_receive_rec->invoice_txn_id);
					$invoices_array[$i]['invoice_id'] = $tx_obj->id;
					$invoices_array[$i]['invoice_no'] = $order_invoice_receive_rec->invoice_number;
					$invoices_array[$i]['invoice_date'] = $order_invoice_receive_rec->invoice_date;
					$invoices_array[$i]['from'] = $scm_orgs[$tx_obj->from_id];
					$invoices_array[$i]['to'] = $scm_orgs[$tx_obj->to_id];
					$i++;
				}
			}
			$order_obj = $this->order->find($order_id);
			$tx_obj = $this->tx->find($order_obj->order_txid);
			$data['order_id'] = $order_id;
			$data['invoices'] = $invoices_array;
			$data["order_no"] = $order_id;
			$data['from'] = $scm_orgs[$tx_obj->from_id];
			$data['to'] = $scm_orgs[$tx_obj->to_id];
			$data['ordered_on'] = $tx_obj->date;
			$this->load->view ( 'scm/invoice_list',$data);	
		}
	}
	/*
	 * close an order after checking for valid order
	 * @params $order_id,$manually
	 * $returns true or flase
	 */
	private function close_order($order_id,$manual){
		$close_order = true;
		//$order_invoice_receive_recs = $this->order_invoice_receive->where('order_id',$order_id)->where('invoice_number !=','')->find_all();
		$ordered_drugs = $this->tx_item->find_all_by('transaction_id',$this->order->find($order_id)->order_txid);
		if($manual ){
			return $this->order->close_order($order_id);
		}
		foreach($ordered_drugs as $drugs){
			$ordered_qty = $this->get_total_qty($order_id,$drugs->generic_id,'ORDER');
			$received_qty = $this->get_total_qty($order_id,$drugs->generic_id,'RECEIVE');
			if(($ordered_qty-$received_qty) !== 0){
				$close_order = false;
			}			
		}
		if($close_order){
			return $this->order->close_order($order_id);
		}else{
			return false;
		}
	}
	
	function receive_order_on_invoice($order_id,$invoice_txid){
		
		if($order_id == '') {
			$this->session->set_userdata('msg', 'Please provide Order id for editting');
			redirect('/scm/search/home');
		}

		$order_obj = $this->order->find($order_id);
		if($order_obj == null) {
			$this->session->set_userdata('msg', 'Order id : '.$order_id.' does not exist');
			redirect('/scm/search/home');
		}
		
		$user_location_id = $this->session->userdata('location_id');
		if (!$this->session->userdata('location_id')) {
			$this->session->set_userdata('msg', 'Location must be chosen before receiving Order');
			redirect('/scm/search/home');
		}
		
		$tx_obj = $this->tx->find_by('id',$order_obj->order_txid);
		if(!$this->can_receive($tx_obj->from_id)){
			$this->session->set_userdata('msg', 'Not authorized for updating this order.');
			redirect('/scm/search/home');
		}
		
		$this->form_data['today_date'] = Date_util::today();
		$this->form_data['order_id'] =  $order_id;
		$order_tx_obj = $this->tx->find($order_obj->order_txid);
		$this->form_data['order_date'] = $order_tx_obj->date;
		$scm_orgs = $this->get_scm_orgs();
		$this->form_data['order_from'] = $scm_orgs[$order_tx_obj->from_id];
		$this->form_data['order_to'] = $scm_orgs[$order_tx_obj->to_id];
		$this->form_data['order_from_id'] = $order_tx_obj->from_id;
		$this->form_data['order_to_id'] = $order_tx_obj->to_id;
		$org_recs = $this->scm_org->find($order_tx_obj->to_id);
			
		$invoiced_tx_items = $this->tx_item->find_all_by('transaction_id',$invoice_txid);
		$order_items = array();
		$i=0;
		$total_value = 0;
		foreach ($invoiced_tx_items as $tx_item) {
			$order_items[$i]['generic_id']=$tx_item->generic_id;
			$this->load->model ( 'scm/product_model', 'product' );
			$drug_gx =$this->drug_gx->find($tx_item->generic_id);
			$order_items[$i]['generic_name']=$drug_gx->generic_name.' '.$drug_gx->form;
			$order_items[$i]['strength']=$drug_gx->strength.' '.$drug_gx->strength_unit;
			$order_items[$i]['unit']= $drug_gx->purchase_unit;
			$order_items[$i]['quantity']= $tx_item->quantity;
			$order_items[$i]['amount']= $tx_item->value;
			$order_items[$i]['batch_number']= $tx_item->batch_number;
			$order_items[$i]['expiry_date']= $tx_item->expiry_date;
			$total_value = $total_value + $tx_item->value;
			$brands_rec=$this->product->find_by('id',$tx_item->product_id);
			$order_items[$i]['product']= $brands_rec;
			$i++;
		}
		$this->form_data['total_amount'] = $total_value;
		$this->form_data['order_items'] = $order_items;
		$this->form_data['invoice_txn_id'] = $invoice_txid;
		$invoice_tx_obj = $this->tx->find($invoice_txid);
		$this->form_data['invoiced_on'] = $invoice_tx_obj->date;
		$this->form_data['order_id'] = $order_id;
		$this->form_data['can_receive'] = true;
		$order_invoice_receive_obj = $this->order_invoice_receive->where('order_id',$order_id)->where('invoice_txn_id',$invoice_txid)->find();
		$this->form_data['invoiced_number'] = $order_invoice_receive_obj->invoice_number;
		if(!isset($_POST['date'])){
			if($order_invoice_receive_obj->receive_txn_id !== NULL || !empty($order_invoice_receive_obj->receive_txn_id)){
				$this->form_data['can_receive'] = false;
			}
			$this->load->view ( 'scm/receive_invoice',$this->form_data);
		}else{
			$tx_status = true;
			$tx_param = $_POST;
			$tx_obj = $this->tx->save_order_txn($tx_param,Date_util::to_sql($_POST['date']),$this->session->userdata("username"));
			if( $tx_obj === NULL){
				$tx_status = false;
				$home_msg = '1: Unable to save transaction object ';
			}
			$this->db->trans_begin();
			$this->load->model ( 'scm/product_model', 'product' );
			
			$rx_csv ='';
			$from_org =$this->scm_org->find($_POST['from_id']);
			$rx_csv =$rx_csv.'From:"'.$from_org->name.'"'."\n".'"'.$from_org->address.'"'."\n";
			$to_org =$this->scm_org->find($_POST['to_id']);
			$rx_csv =$rx_csv.'By: "'.$to_org->name.'"'."\n".'"'.$to_org->address.'"'."\n";
			$rx_csv =$rx_csv.'Order No: ,'.$_POST['order_id'].',,,,Date: ,'.$_POST['date']."\n\n\n\n\n\n";

			$bill_amount = 0.0;
			$rx_csv =$rx_csv.'SN,Brand Name,Generic Name,Batch No,Expiry,Qty,Rate,Total'."\n";
			$tx_items = $this->tx_item->find_all_by('transaction_id',$_POST['invoice_id']);
			$j=1;
			foreach ($tx_items as $tx_item) {
				$tx_item_obj = $this->tx_item->new_record();
				$tx_item_obj->transaction_id = $tx_obj->id;
				$tx_item_obj->product_id = $tx_item->product_id;
				$tx_item_obj->quantity = $tx_item->quantity;
				$tx_item_obj->rate = $tx_item->rate;
				$tx_item_obj->value = $tx_item->value;
				$tx_item_obj->actual_rate = $tx_item->actual_rate;
				$tx_item_obj->actual_value = $tx_item->actual_value;
				$tx_item_obj->batch_number = $tx_item->batch_number;
				$tx_item_obj->expiry_date = $tx_item->expiry_date;
				$tx_item_obj->generic_id = $tx_item->generic_id;
				if(isset($tx_item->visit_id) && $tx_item->visit_id!='' ){
					$tx_status=$this->update_visit_opd_product_entry($tx_item->visit_id,$tx_item->product_id,$tx_status);
				}
				$bill_amount = $bill_amount + $tx_item->actual_value;
				if(!$tx_item_obj->save()){
					$home_msg = '3: Unable to save transaction item entry for  '.$tx_item->product_id;
					$tx_status = false;
				}
				if($tx_item_obj->quantity > 0){
					$params = array();
					$params = $_POST;
					//$params['batch_no'] = $_POST['batch_'.$i];
					$params['batch_no'] = $tx_item_obj->batch_number;
					$params['to_location'] = $_POST['from_id'];
					$params['product_id'] = $tx_item_obj->product_id;
					$params['date'] = $_POST['date'];
					$params['expiry_date'] = $tx_item_obj->expiry_date;
					$result = $this->update_inventory($tx_item_obj,$params);
					if($result['status']){
						$rx_csv = $rx_csv.$j.','.$result['msg'];
						$j++;
					}else{
						$tx_status = $result['status'];
						$home_msg = $result['msg'];
					}
				}
			}
			$tx_obj->bill_amount = $_POST['bill_amount'];
			$tx_obj->type = $_POST['type_of_good'];
			$tx_obj->save();
			$rx_csv = $rx_csv.'Total :,,,,,,,'.$tx_obj->bill_amount;
			//Update order_invoice_receive table with receive txn_id
			$order_invoice_receive_obj->receive_txn_id = $tx_obj->id;
			$order_invoice_receive_obj->receive_date = Date_util::change_date_format($_POST['date']);
			if(!$order_invoice_receive_obj->save()){
				$home_msg = '4: Unable to update invoice table for  transaction : '.$tx_obj->id;
				$tx_status = false;
			}
			if($tx_status == true){
				$this->db->trans_commit();
				//To close an order aynamically if all the items are full-filled.
				$this->close_order($order_id,false);
				if($order_invoice_receive_obj->receive_txn_id !== NULL || !empty($order_invoice_receive_obj->receive_txn_id)){
					$this->form_data['can_receive'] = false;
				}
				$base_path = $this->config->item('base_path');
				$filename = 'uploads/orders/'.$_POST['order_id'].'-receive.csv';
				$fp = fopen($base_path.$filename,"w");
				if(!fwrite($fp,$rx_csv)){
					echo "CSV File could not be written";
				}
				$home_msg ='Order with id : '.$order_id.' received successfully';
				$this->form_data['filetype'] = 'Receipt Details';
				$this->form_data['filename'] = $filename;
				$this->form_data['success_message'] = $home_msg;
				$this->load->view ( 'scm/receive_invoice',$this->form_data );
			}else{
				$this->db->trans_rollback();
				$this->form_data['error_server'] = 'Order Receipt unsuccessful. '.$home_msg.' Please try again';
				redirect('/scm/search/home');
			}	
		}
	}
	
	function update_inventory($transaction_item,$params){
		$ret_value = array();
		$home_msg = '';
		$tx_status = true;
		$batch_no=$params['batch_no'];
		$expiry = $params['expiry_date'];
		$prod_stock = $this->stock->find_by(array('location_id','product_id','batch_number'),array($params['to_location'],$transaction_item->product_id,$batch_no));
		$product_brand = $this->product->find($transaction_item->product_id);
		if($prod_stock){
			$prod_stock->quantity = $prod_stock->quantity + $transaction_item->quantity;
			if(!$prod_stock->save()){
				$tx_status = false;
				$home_msg = '4: Unable to add volume of product '.$prod_stock->product_id.' to existing batch no'.$batch_no;
			}
		}else{
			$n_stock = $this->stock->new_record();
			$n_stock->location_id = $params['to_location'];
			$n_stock->product_id = $params['product_id'];
			$n_stock->receipt_date = Date_util::to_sql($params['date']);
			$n_stock->batch_number = $params['batch_no'];
			if(isset($params['expiry_date'])  && !empty($params['expiry_date'])){
				$n_stock->expiry_date = $expiry;
			}
			$n_stock->quantity = $transaction_item->quantity;
			if(!$n_stock->save())
			{
				$tx_status = false;
				$home_msg = '5: Unable to add new batch of product '.$n_stock->product_id;
			}
		}
		if(isset($expiry) && !empty($expiry)){
			$home_msg = $product_brand->name.','.$product_brand->generic_name.','.$params['batch_no'].','.$params['expiry_date'].','.$transaction_item->quantity.','.$transaction_item->rate.','.$transaction_item->value."\n";
		}else{
			$home_msg = $product_brand->name.','.$product_brand->generic_name.','.$params['batch_no'].',,'.$transaction_item->quantity.','.$transaction_item->rate.','.$transaction_item->value."\n";
		}
		$ret_value['status'] = $tx_status;
		$ret_value['msg'] = $home_msg;
		return $ret_value;
	}
	
	private function receive_external_order($order_id) {
		
		$order_obj = $this->order->find($order_id);
		$this->form_data['order_id'] =  $order_id;
		
		$tx_obj = $this->tx->find_by('id',$order_obj->order_txid);
		
		$this->form_data['order_to_id'] = $tx_obj->to_id;
		$this->form_data['order_from_id'] = $tx_obj->from_id;
		
		
		$to_id = $tx_obj->to_id;
		$scm_record = $this->scm_org->find_by('id',$to_id);
		if($scm_record->origin == "EXTERNAL"){
			$this->form_data['is_external'] = $to_id;
		}
		
		if(!$this->can_receive($this->form_data['order_from_id']))
		{
			$this->session->set_userdata('msg', 'You are not authorised to receive order for location: '.$this->form_data['order_from_id']);
			redirect('/scm/search/home');
		}
		
		$this->form_data['scm_orgs'] = $this->get_scm_orgs();
		$this->form_data['date'] = Date_util::today();
		$this->form_data['order_date'] =$tx_obj->date;
		$this->load->model ( 'scm/transaction_item_model', 'tx_item_mod' );
		$this->load->dbutil();
		$tx_items = $this->tx_item_mod->find_all_by('transaction_id',$tx_obj->id);
		$order_items = array();
		$i=0;
		foreach ($tx_items as $tx_item) {
			//Get already invoiced quantity for a given generic_id and order_id
			$received_qty = $this->get_total_qty($order_obj->id,$tx_item->generic_id,'RECEIVE');
			//Calculate quantity remaing to be invoiced
			$remaining_quantity = $tx_item->quantity - $received_qty;
			//Allow invoicing if and only if $remaining_quantity greater than zero
			if($remaining_quantity>0){
				$this->load->model ( 'scm/product_model', 'product' );
				$this->load->model ( 'scm/drug_generic_model', 'drug_generic' );
				$prod = null;
				
				$order_items[$i]['product_id']=$tx_item->generic_id;
				$order_items[$i]['generic_id']=$tx_item->generic_id;
				$prod =$this->drug_generic->find($tx_item->generic_id);
				$brands_recs=$this->product->find_all_by('generic_id',$tx_item->generic_id);
				
				$order_items[$i]['generic_name']=$prod->generic_name.' '.$prod->form;
				$order_items[$i]['strength']=$prod->strength.' '.$prod->strength_unit;
				$order_items[$i]['unit']= $prod->purchase_unit;
				$order_items[$i]['type']= ucwords(strtolower($prod->product_type));
				$order_items[$i]['opd_type']= ucwords(strtolower($prod->product_order_type));
				$order_items[$i]['visit_id']= $tx_item->visit_id;
				$order_items[$i]['quantity']= $remaining_quantity;
				$visit_link_url = 'index.php/opd/visit/show/';
				$this->form_data['visit_link_url'] = $visit_link_url;
				$brand_ids = array();
				$brand_names = array();
				$rates = array();
				$stocks = array();
				$j=0;
				foreach($brands_recs as $brand){
					$brand_ids[$j] = $brand->id;
					$brand_names[$brand->id] = $brand->name;
					$rates[$brand->id] = $brand->purchase_price;
					$stock_item = $this->stock->find_by(array('location_id','product_id'),array($tx_obj->from_id,$brand->id));
					if($stock_item != null)
						$stocks[$brand->id] =  $stock_item->quantity;
					else
						$stocks[$brand->id] =  0;
					$j++;
				}
				if($tx_item->product_batch_id){
					$stock_item = $this->stock->find($tx_item->product_batch_id);
					$order_items[$i]['d_brand_id']=$stock_item->product_id;
					$order_items[$i]['d_batch_no']=$stock_item->batch_number;
					$order_items[$i]['d_expiry']=Date_util::to_display($stock_item->expiry_date);
				}else{
					$order_items[$i]['d_brand_id']=$brand_ids[0];
					$order_items[$i]['d_batch_no']='';
					$order_items[$i]['d_expiry']='DD/MM/YYYY';
				}
				$order_items[$i]['num_brands']=$j;
				$order_items[$i]['brand_ids']=$brand_ids;
				$order_items[$i]['brand_names']=$brand_names;
				$order_items[$i]['stocks']=$stocks;
				$order_items[$i]['rates']=$rates;
				$i++;
			}
		}
		
		$this->form_data['number_items'] = $i;
		$this->form_data['order_items'] = $order_items;
		
		
		if (! isset ( $_POST ['date'] ) ) {
			$this->load->view ( 'scm/receive_order',$this->form_data );
		} else {
			$invoice_tx_id=$_POST['invoicenumber'];
			$invoice_date=Date_util::to_sql($_POST['invoicedate']);
				
			$rx_csv ='';	
			$this->load->model ( 'scm/transaction_model', 'tx' );
			$tx_obj = $this->tx->new_record ( $_POST );
			$tx_obj->date = Date_util::to_sql($_POST['date']);
			$tx_obj->username = $this->session->userdata("username");
			$this->load->dbutil();
			$this->db->trans_begin();
			$tx_status = true;				
			if(!$tx_obj->save ()){
				$tx_status = false;
				$home_msg = '1: Unable to save transaction object ';
			}
			$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
			$this->load->model ( 'scm/product_model', 'product' );
			$from_org =$this->scm_org->find($_POST['from_id']);
			$rx_csv =$rx_csv.'From:"'.$from_org->name.'"'."\n".'"'.$from_org->address.'"'."\n";
			$to_org =$this->scm_org->find($_POST['to_id']);
			$rx_csv =$rx_csv.'By: "'.$to_org->name.'"'."\n".'"'.$to_org->address.'"'."\n";
			$rx_csv =$rx_csv.'Order No: ,'.$_POST['order_id'].',,,,Date: ,'.$_POST['date']."\n\n\n\n\n\n";
		
			$order_invoice_receive_obj = $this->order_invoice_receive->save_new_receive($order_obj->id,$tx_obj,$invoice_tx_id,$invoice_date);
			if($order_invoice_receive_obj == NULL){
				$tx_status = false;
				$home_msg = '3: Unable to save order invoice receive table';
			}
			
			$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
			$bill_amount = 0.0;
			$rx_csv =$rx_csv.'SN,Brand Name,Generic Name,Batch No,Expiry,Qty,Rate,Total'."\n";
			for ($i=0; $i < $_POST['number_items']; $i++) {
				if($_POST['quantity_'.$i] > 0){
					$tx_item_obj = $this->tx_item->new_record();
					$tx_item_obj->transaction_id = $tx_obj->id;
					$tx_item_obj->product_id = $_POST['product_id_'.$i];
					$tx_item_obj->quantity = $_POST['quantity_'.$i];
					//$tx_item_obj->product_batch_id = $_POST['batch_'.$i];    // ask this later
					$tx_item_obj->rate = $_POST['rate_'.$_POST['product_id_'.$i]];
					$tx_item_obj->value = $_POST['rate_'.$_POST['product_id_'.$i]] * $_POST['quantity_'.$i];
					$tx_item_obj->actual_rate = $_POST['actual_rate_'.$i];
					$tx_item_obj->actual_value = $_POST['actual_rate_'.$i] * $_POST['quantity_'.$i];
					$tx_item_obj->batch_number = $_POST['batch_'.$i];
					if(isset($_POST['expiry_'.$i])  && !empty($_POST['expiry_'.$i])){
						$tx_item_obj->expiry_date = Date_util::to_sql($_POST['expiry_'.$i]);
					}
					
					if( trim($_POST['visit_id_'.$i]!='' )){
						$tx_status=$this->update_visit_opd_product_entry($_POST['visit_id_'.$i],$_POST['product_id_'.$i],$tx_status);
					}
					
					$tx_item_obj->generic_id = $_POST['generic_id_'.$i];
					$bill_amount = $bill_amount + $tx_item_obj->actual_value;
					if(!$tx_item_obj->save()){
						$home_msg = '3: Unable to save transaction item entry for  '.$tx_item_obj->product_id;
						$tx_status = false;
					}
					if($tx_item_obj->quantity > 0){
						$batch_no = $_POST['batch_'.$i];
						$prod_stock = $this->stock->find_by(array('location_id','product_id','batch_number'),array($_POST['from_id'],$tx_item_obj->product_id,$batch_no));
						$product_brand = $this->product->find($tx_item_obj->product_id);
						if($prod_stock){
							$prod_stock->quantity = $prod_stock->quantity + $tx_item_obj->quantity;
							if(!$prod_stock->save()){
								$tx_status = false;
								$home_msg = '4: Unable to add volume of product '.$prod_stock->product_id.' to existing batch no'.$batch_no;
							}
						}else{
							$n_stock = $this->stock->new_record();
							$n_stock->location_id = $_POST['from_id'];
							$n_stock->product_id = $_POST['product_id_'.$i];
							$n_stock->receipt_date = Date_util::to_sql($_POST['date']);
							$n_stock->batch_number = $batch_no;
							if(isset($_POST['expiry_'.$i])  && !empty($_POST['expiry_'.$i])){
								$expiry = $_POST['expiry_'.$i];
								$n_stock->expiry_date = Date_util::to_sql($expiry);
							}
							$n_stock->quantity = $tx_item_obj->quantity;
							if(!$n_stock->save()){
								$tx_status = false;
								$home_msg = '5: Unable to add new batch of product '.$n_stock->product_id;
							}
						}
						if(isset($expiry) && !empty($_POST['expiry_'.$i])){
							$rx_csv = $rx_csv.($i+1).'","'.$product_brand->name.'","'.$product_brand->generic_name.'",'.$batch_no.','.$expiry.','.$tx_item_obj->quantity.','.$tx_item_obj->rate.','.$tx_item_obj->value."\n";
						}else{
							$rx_csv = $rx_csv.($i+1).'","'.$product_brand->name.'","'.$product_brand->generic_name.'",'.$batch_no.',,'.$tx_item_obj->quantity.','.$tx_item_obj->rate.','.$tx_item_obj->value."\n";
						}
					}
				}
			}
			if(isset($_POST['vat'])){
				$vat = $_POST['vat'];
				$shipping_cost = $_POST['shipping_cost'];
				$bill_amount = $bill_amount + $vat + $shipping_cost;
				$tx_obj->vat = $vat;
				$tx_obj->shipping_cost = $shipping_cost;
			}
			$tx_obj->bill_amount = $bill_amount;
			$tx_obj->type = $_POST['type_of_good'];
			$tx_obj->save();
			$rx_csv = $rx_csv.'Total :,,,,,,,'.$tx_obj->bill_amount;

			if($tx_status == true){
				$this->db->trans_commit();
				$base_path = $this->config->item('base_path');
				$filename = 'uploads/orders/'.$_POST['order_id'].'-receive.csv';
				$fp = fopen($base_path.$filename,"w");
				if(!fwrite($fp,$rx_csv)){
					echo "CSV File could not be written";
				}
				//To close an order aynamically if all the items are full-filled.
				$this->close_order($order_id,false);
				
				$home_msg ='Order with id : '.$order_obj->id.' received successfully';
				$this->form_data['filetype'] = 'Receipt Details';
				$this->form_data['filename'] = $filename;
				$this->form_data['success_message'] = $home_msg;
				$this->load->view ( 'scm/receive_order',$this->form_data );
			}else{
				$this->db->trans_rollback();
				$this->form_data['error_server'] = 'Order Receipt unsuccessful. '.$home_msg.' Please try again';
				redirect('/scm/search/home');
			}
		}
	}
	function external_order_details($order_id, $receive_txid){
		$order_obj=$this->order_invoice_receive->where('order_id',$order_id)->where('receive_txn_id',$receive_txid)->find();
		$this->form_data['invoice_number'] = $order_obj->invoice_number;
		$this->form_data['invoice_date'] = Date_util::to_display($order_obj->invoice_date);
		$this->form_data['order_id'] =  $order_id;
		$tx_obj = $this->tx->find_by('id',$order_obj->receive_txn_id);
		$this->form_data['vat_amount'] =$tx_obj->vat;
		$this->form_data['shipping_cost'] =$tx_obj->shipping_cost;
		$this->form_data['bill_amount'] =round($tx_obj->bill_amount,2);
		$this->form_data['order_from_id'] =$tx_obj->from_id ;
		$this->form_data['order_to_id'] =$tx_obj->to_id;
		$this->form_data['receive_id'] = $receive_txid;
		
		$this->form_data['scm_orgs'] = $this->get_scm_orgs();
		$this->form_data['date'] = Date_util::today();
		$this->form_data['order_date'] =Date_util::to_display($tx_obj->date);
		$this->load->model ( 'scm/transaction_item_model', 'tx_item_mod' );
		$this->load->dbutil();
		$tx_items = $this->tx_item_mod->find_all_by('transaction_id',$tx_obj->id);
		$order_items = array();
		$i=0;
		foreach ($tx_items as $tx_item) {
			$brand_name=$this->get_data('products','name');
			$this->load->model ( 'scm/product_model', 'product' );
			$this->load->model ( 'scm/drug_generic_model', 'drug_generic' );
			$prod = null;
			$order_items[$i]['product_id']=$brand_name[$tx_item->product_id];
			$order_items[$i]['generic_id']=$tx_item->generic_id;
			$prod =$this->drug_generic->find($tx_item->generic_id);
			$order_items[$i]['generic_name']=$prod->generic_name.' '.$prod->form;
			$order_items[$i]['strength']=$prod->strength.' '.$prod->strength_unit;
			$order_items[$i]['unit']= $prod->purchase_unit;
			$order_items[$i]['type']= ucwords(strtolower($prod->product_type));
			$order_items[$i]['opd_type']= ucwords(strtolower($prod->product_order_type));
			$order_items[$i]['quantity']= $tx_item->quantity;
			$order_items[$i]['batch_number']= $tx_item->batch_number;
			if(!empty($tx_item->expiry_date)){
				$order_items[$i]['expiry_date']= $tx_item->expiry_date;
			}
			$order_items[$i]['actual_value']= round($tx_item->actual_value,2);
			$i++;
		
		}
		$this->form_data['number_items'] = $i;
		$this->form_data['order_items'] = $order_items;
		$this->load->view ( 'scm/external_order_details',$this->form_data );
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
	
	function get_scm_orgs_origin() {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( 'scm_organizations' );
		$o_rows = $o_obj->find_all ();
		foreach ( $o_rows as $o_row ) {
			$orgs [$o_row->id] = $o_row->origin;
		}
		return $orgs;
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

	function get_internal_scm_orgs() {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( 'scm_organizations' );
		$o_rows = $o_obj->find_all ();
		foreach ( $o_rows as $o_row ) {
			if($o_row->origin != "EXTERNAL")
				$orgs [$o_row->id] = $o_row->name;
		}
		return $orgs;
	}

	function get_scm_registartion_id(){
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( 'scm_organizations' );
		$o_rows = $o_obj->find_all ();
		foreach ( $o_rows as $o_row ) {
			$orgs [$o_row->id] = $o_row->license_no;
		}
		return $orgs;
	}

	function can_receive($scm_org_id = 0){
		$this->load->model('opd/provider_location_model','pl');
		$this->load->model('scm/scm_organization_model','scm_org');
		$scm_rec = $this->scm_org->find($scm_org_id);
		if($scm_rec->type != 'Clinic')
			return true;

		$pl_rec = $this->pl->find_by('scm_org_id',$scm_org_id);
		if($pl_rec)
		{
			if($pl_rec->id != $this->session->userdata('location_id')) {
				return false;
			}
		}
		return true;
	}
	
	function get_batch_numbers(){
		
		$product_id = $this->input->post('product_id');
		$batch_number = $this->input->post('batch_number');
		
		$location_id = $this->input->post('from_id');

		if(isset($batch_number) && $batch_number !== ""){
			$products = $this->stock->find_all_by(array('location_id','product_id','quantity >','batch_number'),array($location_id,$product_id,'0',$batch_number));
			//$products = $this->stock->find_all_by(array('location_id','product_id','batch_number'),array($location_id,$product_id,$batch_number));
		}else{
			$products = $this->stock->find_all_by(array('location_id','product_id','quantity >'),array($location_id,$product_id,'0'));
			//$products = $this->stock->find_all_by(array('location_id','product_id'),array($location_id,$product_id));
		}
		// form json structure
		$jsonStructure=' { "data":[';
		foreach ($products as $product){
				$expiry_date = $product->expiry_date;
				if(empty($product->expiry_date) || $product->expiry_date === ""){
					$expiry_date = "Empty";
				}else{
					$expiry_date = Date_util::date_display_format($product->expiry_date);
				}
				$jsonStructure .= "{";
				$jsonStructure .= '"batch_number":';
				$jsonStructure .= '"'.$product->batch_number.'"';
				$jsonStructure .= ",";
				$jsonStructure .= '"stock":';
				$jsonStructure .= '"'.$product->quantity.'"';
				$jsonStructure .= ",";
				$jsonStructure .= '"expiry":';
				$jsonStructure .= '"'.$expiry_date.'"';
				$jsonStructure .= "}";
				$jsonStructure .= ",";
		}
		$jsonString = $jsonStructure;
		if(!empty($products) || sizeof($products) > 0)
			$jsonString =  substr($jsonStructure , 0, -1); // to trim ,
		$jsonString .= ']';
		$jsonString .= '}';
		$temp_json =  json_encode($jsonString);
		echo json_encode($jsonString);
	}
	
	public function order_details_report($order_id){

		$this->load->model ( 'scm/order_model', 'order' );
		$order_obj = $this->order->find($order_id);
		if($order_obj == null) {
			$this->session->set_userdata('msg', 'Order id : '.$order_id.' does not exist');
			redirect('/scm/search/home');
		}
			
		$this->form_data['order_id'] =  $order_id;
		$this->load->model ( 'scm/transaction_model', 'tx' );
		$tx_obj = $this->tx->find($order_obj->order_txid);
		$scm_orgs = $this->get_scm_orgs();
		$this->form_data['order_date'] =Date_util::to_display($tx_obj->date);
		$this->form_data['order_from'] = $scm_orgs[$tx_obj->from_id];
		$this->form_data['order_to'] = $scm_orgs[$tx_obj->to_id];
		$this->form_data['bill_amount'] = $tx_obj->bill_amount;
		$this->load->model ( 'scm/transaction_item_model', 'tx_item_mod' );
		$this->load->dbutil();
		$tx_items = $this->tx_item_mod->find_all_by('transaction_id',$tx_obj->id);
		$sl_no=0;
		
		$doc = new tcPdfWriter();
		$doc->InitDoc();
		$doc->PrepareDoc("", "right", "left", "Bottom", $this->config->item('logo_file'));
		
		$trans_details=array("Invoice Number","Invoice Date","Received Number","Received Date");
		$drug_details=array("SN","Generic Name","Type","Visit id","Strength","Retail Unit", "Capacity","Quantity Ordered","Retail Rate","Retail Value");
		$product_details=array();
		foreach ($tx_items as $tx_item) {
			$sl_no++;
			$this->load->model ( 'scm/drug_generic_model', 'product' );
			$prod =$this->product->find($tx_item->product_id);
			$drug_generics = $this->drug_gx->find($tx_item->generic_id);
			$prod_type=$drug_generics->product_type;
			$product_details[]=array($sl_no,$drug_generics->generic_name,$prod_type,$tx_item->visit_id,$drug_generics->strength.' '.$drug_generics->strength_unit,$drug_generics->purchase_unit,$drug_generics->capacity,$tx_item->quantity,$tx_item->rate,$tx_item->quantity*$tx_item->rate) ;
		}
		$product_details[]=array("","","","","","","","","Total",$tx_obj->bill_amount);
		
		$order_invoice_receive_recs = $this->order_invoice_receive->where('order_id',$order_id)->where('invoice_number !=','')->find_all();
		$invoice_receive_details=array();
		foreach($order_invoice_receive_recs as $order_invoice_receive_rec){
			$invoice_receive_details[]=array( $order_invoice_receive_rec->invoice_number, $order_invoice_receive_rec->invoice_date, $order_invoice_receive_rec->receive_txn_id, $order_invoice_receive_rec->receive_date);
		}
		
		$line1=array("Order Number:".$order_id,"Status: ".$order_obj->order_status,"Date:".Date_util::to_display($tx_obj->date));
		$doc->WriteTable(array(), $line1, "Table");
			
		$addressheadings=array("From: ".$scm_orgs[$tx_obj->from_id],"","To: ".$scm_orgs[$tx_obj->to_id]);
		$addresscols=array();
		$trans_det=array("Transaction Details:");
		$doc->WriteTable($addresscols, $addressheadings, "Table " );
		$doc->WriteTable(array(), $trans_det, "Table");
		
		$doc->WriteTable($invoice_receive_details, $trans_details, "Table 2" ,1,array('border'=>1,'width'=>array(20,20,20,20)));
		$order_det=array("Order Details:");
		$doc->WriteTable(array(), $order_det, "Table");
		$doc->WriteTable($product_details, $drug_details, "Table 3" ,1,array('border'=>1,'width'=>array(3,13,14,10,10,7,10,10,7,7)),750);
		$doc->Output($order_id."_order_details.pdf", 'D');
		//$doc->Display();
	}
	
	public function update_visit_opd_product_entry($visit_id,$product_id,$txstatus){
		$pending_opd_products=$this->visit_opdproduct_entry->where('visit_id',$visit_id)->where('product_given_out','no')->where('is_present_in_stock','No')->find_all();
		foreach($pending_opd_products as $pending_product){
			if($product_id===$pending_product->product_id){
				$pending_product->is_present_in_stock='Yes';
				if(!$pending_product->save()){
					$txstatus=false;
				}else{
					continue;
				}
			}
		}
		return $txstatus;
	}
	
}

?>
