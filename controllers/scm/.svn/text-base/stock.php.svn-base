<?php
class stock extends CI_Controller {
	public $form_data = array();
	
	function __construct() {
    	parent::__construct();
    	$this->load->model('scm/drug_generic_model', 'drug_generic');
    	$this->load->model('scm/drug_brand_model', 'drug_brand');
    	$this->load->model ( 'scm/scm_organization_model', 'locationname' );
    	$this->load->library('date_util');
    
	}
	
	
	function stock_report(){

/*		if($location_id == '') {
    			$this->session->set_userdata('msg', 'Please provide Location for getting stock details');
			redirect('/scm/search/home');
		}*/
	$data['locations'] = $this->get_scm_orgs();

		$username = $this->session->userdata('username');
		$location_id= $this->session->userdata('location_id');
		$this->load->model ( 'opd/provider_location_model', 'pl_org' );
		$sc_location_id =$this->pl_org->find($location_id)->scm_org_id;
		if($location_id)
		{
			$data['location_id'] = $sc_location_id;
		}
		if(isset($_POST['location_id']))
		{	
			
			$location_id = $_POST['location_id'];
			$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
			$location =$this->scm_org->find($location_id);
			if($location == null){
    				$this->session->set_userdata('msg', 'Location id: '.$location_id.' is not a valid stock keeping location');
				$data['locations'] = $this->get_scm_orgs();
				$location_id= $this->session->userdata('location_id');
				if($location_id)
				{
					$data['location_id'] = $location_id;
				}
				$this->load->view('scm/get_stock',$data);
			}
			$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
			$stock_items = $this->stock->select_sum('quantity','t_quantity')->where('quantity >','0')->group_by('product_id')->group_by('batch_number')->order_by('product_id')->find_all_by('location_id',$location_id);
			$items_csv = 'SN,Product Id,Product Name,Qty-Purc,Tabs,Batch No,Expiry,OPD Product Type,OPD Product Order Type '."\n";
			$i=1;
			foreach ($stock_items as $stock_item)
			{
				$this->load->model ( 'scm/product_model', 'product' );
				$prod = $this->product->find($stock_item->product_id);
				$this->load->library('date_util');
				$qty = $stock_item->t_quantity;
				$qty_pur = floor($qty);
				$qty_ret = round(($qty-$qty_pur)*$prod->retail_units_per_purchase_unit);
				if(isset($stock_item->expiry_date)){
					$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.$qty_pur.','.$qty_ret.','.$stock_item->batch_number.','.Date_util::to_display($stock_item->expiry_date).','.$prod->product_type.','.$prod->product_order_type."\n";
				}else{
					$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.$qty_pur.','.$qty_ret.','.$stock_item->batch_number.',,'.$prod->product_type.','.$prod->product_order_type."\n";
				}
				$i++;
			}
			
		$stock_items_negative = $this->stock->select_sum('quantity','t_quantity')->where('quantity <','0')->group_by('product_id')->group_by('batch_number')->order_by('product_id')->find_all_by('location_id',$location_id);
			$items_csv = $items_csv."\n\n\n\n".',,,,Negative stock '."\n\n";
			$items_csv = $items_csv.'SN,Product Id,Product Name,Qty-Purc,Tabs,Batch No,Expiry,OPD Product Type,OPD Product Order Type '."\n";
			$i=1;
			foreach ($stock_items_negative as $stock_item)
			{
				$this->load->model ( 'scm/product_model', 'product' );
				$prod = $this->product->find($stock_item->product_id);
				$this->load->library('date_util');
				$qty = $stock_item->t_quantity;
				$qty_pur = floor($qty);
				$qty_ret = round(($qty-$qty_pur)*$prod->retail_units_per_purchase_unit);
				if(isset($stock_item->expiry_date)){
					$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.$qty_pur.','.$qty_ret.','.$stock_item->batch_number.','.Date_util::to_display($stock_item->expiry_date).','.$prod->product_type.','.$prod->product_order_type."\n";
				}else{
					$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.$qty_pur.','.$qty_ret.','.$stock_item->batch_number.',,'.$prod->product_type.','.$prod->product_order_type."\n";
				}
				$i++;
			}
			
    $this->load->helper('date');  
	$time = time();
	$datestring= "%Y%m%d";
    	$today_date = mdate($datestring, $time);
	        	$base_path = $this->config->item('base_path');
	    	   	$filename = 'uploads/stocks/'.$location_id.'-'.$today_date.'-stock.csv';
	    	   	$fp = fopen($base_path.$filename,"w");
		   	if(!fwrite($fp,$items_csv))
		   	{  echo "CSV File could not be written";  }
			else
			{
				$data['filetype'] = 'Stock Details';
				$data['filename'] = $filename;
			$username = $this->session->userdata('username');
			$home_url= $this->session->userdata('home');
			$this->load->model('user/user_model','user');
			$this->load->model('user/role_model','role');
			$this->load->model('user/users_role_model','ur');
			$u_rec = $this->user->find_by('username',$username);
			$urs = $this->ur->find_by (array('user_id','role_id >'),array($u_rec->id,'1'));
			$home = $this->role->find($urs->role_id)->home_view;
/*			if($urs != null)
				{$home = '/opd/doc_home';}
			else
				{$home = '/scm/home';}*/
			
				//$this->load->view($home,$data);
				$data['success_message'] = '';
				$this->load->view('scm/get_stock',$data);
			}
		}
		else
		{		
			$this->load->view('scm/get_stock',$data);
		}
		

	}
	function expiry_(){
		$url = "/scm/stock/expiry/".$_POST['locn_id'];
		redirect($url);
	}

	function expiry($location_id){
		$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
		$org_obj = $this->scm_org->find($location_id);
		if($org_obj->origin==='CONSUMPTION'){
			redirect('scm/stock/expired_product/'.$location_id);
		}
		$this->form_data['location'] =  $org_obj->name;
		$this->form_data['location_id'] =  $location_id;
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );
		$this->load->library('date_util');
		$this->load->model('scm/expiry_log_detail_model','expiry_log');

		if (! isset ( $_POST ['date'] ) || $this->form_validation->run () == FALSE) {
			$this->form_data['scm_orgs'] = $this->get_scm_orgs();
			$this->form_data['date'] = Date_util::today();
			//to separate drugs whose expiry date is within 2 months from present date
			$today = date("Y-m-d");
			$newdate = strtotime ( '+2 months' , strtotime($today)) ;
			$newdate = date ( "d/m/Y", $newdate );
			$this->form_data['expire_date'] = $newdate;

	    	$this->load->model('scm/product_model', 'product');
	    	$this->load->model('scm/product_batchwise_stock_model', 'product_batchwise_stock');
	    	$product_batchwise_query=$this->product_batchwise_stock->where('location_id',$location_id)->where('quantity >','0')->find_all();
	    	$unique_products = array();
	    	foreach($product_batchwise_query as $query){
	    		$unique_products[$query->product_id]=$query->product_id;
	    	}
	    	$this->form_data['product_batchwise_list']=array_unique($unique_products);
			$this->load->view ( 'scm/expiry_add',$this->form_data );
		} else {
			//print_r($_POST);
			//return;
			$data['scm_orgs'] = $this->get_scm_orgs();
		
			$generic_drug_list=$this->drug_generic->find_all(); 
	    	$data['generic_drug_list'] = $generic_drug_list;
	    	
	    	$brand_drug_list=$this->drug_brand->find_all(); 
	    	$data['brand_drug_list'] = $brand_drug_list;
	    	
	    	$organizations_list=$this->locationname->find_all(); 
	    	$data['organizations_list'] = $organizations_list;
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
					{$tx_status = false;
      					$home_msg = '1: Unable to save transaction object ';}
			$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
			$from_org =$this->scm_org->find($_POST['from_id']);
			$expiry_csv =$expiry_csv.'From:"'.$from_org->name.'"'."\n".'"'.$from_org->address.'"'."\n";
			$expiry_csv =$expiry_csv.'No: ,'.$tx_obj->id.',,Date: ,'.$_POST['date']."\n\n\n\n\n\n";

			$expiry_csv =$expiry_csv.'SN,Brand Name,Generic Name,Generic Type,Batch No,Expiry,Quantity,Rate,Total'."\n";
			$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
			$i=1;
    			foreach ($_POST["medication"] as $medication) {
				$tx_item_obj = $this->tx_item->new_record();
				$expiry_log_obj = $this->expiry_log->new_record();
				$tx_item_obj->transaction_id = $tx_obj->id;
				$tx_item_obj->product_id = $medication['product_id'];
				$tx_item_obj->quantity = $medication['quantity'];
				$tx_item_obj->rate = $medication['rate'];
				$tx_item_obj->value = $medication['rate'] * $medication['quantity'];
      				if(!$tx_item_obj->save()) {
      					$home_msg = '3: Unable to save transaction item entry for '.$tx_item_obj->product_id;
      					$this->session->set_userdata('msg', $home_message);
  	 					$tx_status = false;
					}
				$expiry_log_obj->product_id = $medication['product_id'];;				
				$expiry_log_obj->quantity = $medication['quantity'];
				$expiry_log_obj->username = $tx_obj->username;
				$expiry_log_obj->budgeted_rate = $medication['rate'];
				$expiry_log_obj->value = $medication['rate'] * $medication['quantity'];
				$expiry_log_obj->location_id = $_POST['from_id'];
				$expiry_log_obj->from_date = $tx_obj->date;		
				if(!$expiry_log_obj->save()){
					$home_msg = '3: Unable to save expiry item entry for '.$tx_item_obj->product_id;
					$this->session->set_userdata('msg', $home_message);
					$tx_status = false;
				}
				
			
				$this->load->model('scm/product_model','product');
				$prod = $this->product->find($tx_item_obj->product_id);
				
				
				$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
			  		$prod_stocks = $this->stock
						->where('id',$medication['product_batch_id'],false)
						->find();
						$tx_qty = $tx_item_obj->quantity;
						$prod_stocks->quantity = 0;
    					if(!$prod_stocks->save()){
							$tx_status = false;
      						$home_msg = '4: Unable to save product batch item for '.$prod_stocks->product_id.' batch no '.$prod_stock->batch_number;
			    		}
						
				/*if($tx_item_obj->quantity > 0)
			  	{
			  		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
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
			    				$this->load->library('date_util');
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
							{$tx_status = false;
      								$home_msg = '4: Unable to save product batch item for '.$prod_stock->product_id.' batch no '.$prod_stock->batch_number;}

			    
			    			}
						$i++;
			   		}
			   if($bal_qty > 0)
			   { $tx_status = false;
      			     $home_msg = '5: Stock for product '.$prod->id.' not sufficient by  '.$bal_qty;}
			  }*/
				$expiry_csv = $expiry_csv.$i.',"'.$prod->name.'","'.$prod->generic_name.'","'.$prod->product_type.'",'.$prod_stocks->batch_number.','.Date_util::to_display($prod_stocks->expiry_date).','.$tx_qty.','.$tx_item_obj->rate.','.$tx_qty*$tx_item_obj->rate."\n";
    			$i++;
    			}
    			
			$expiry_csv = $expiry_csv.'Total value,,,,,,,,'.$_POST['bill_amount'];

			if($tx_status == true)
			{
       	$this->db->trans_commit();
	        		$base_path = $this->config->item('base_path');
	    	   		$filename = 'uploads/orders/expiry-'.$tx_obj->id.'.csv';
	    	   		$fp = fopen($base_path.$filename,"w");
		   		if(!fwrite($fp,$expiry_csv))
		   		{  echo "CSV File could not be written";  }
				$this->session->set_flashdata('msg_type', 'success');
  				$this->session->set_flashdata('msg', 'Expiry with id : '.$tx_obj->id.' saved successfully ');
  				$this->session->set_flashdata('filetype', 'Expiry Details ');
  				$this->session->set_flashdata('filename', $filename);
				redirect('scm/stock/expiry/'.$location_id);
			}
			else
			{
       	$this->db->trans_rollback();
//    				$this->session->set_userdata('msg', 'Order save unsuccessful. Please try again');
    				$this->session->set_userdata('msg', $home_msg);
    				
				redirect('/scm/search/home');
			}
		}

	}
	
	function find_batchwise_products(){
		$product_id=$_POST['product_ids'];
		$from_id=$_POST['from_ids'];
		$this->load->model('opd/opd_product_model', 'opd_product');
    			$this->form_data['opd_product_list'] = $this->opd_product->find_all();
		$values = array();
		$i=0;
		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );  
		  $prod_stocks = $this->stock
						->where('location_id',$from_id,false)
						->where('product_id',$product_id,false)
						->where('quantity >','0',false)
						->order_by('expiry_date','ASC')
						->find_all();
			$product_names=$this->get_data('products','name');
			$provider_locs = $this->get_data('scm_organizations','name');
			$jsonStructure=' { "product_data":[';
			$number_of_stock=sizeof($prod_stocks);
			$i=1;
			foreach($prod_stocks as $opd_product_queue){
				$jsonStructure .= "{";
  				$jsonStructure .= '"product_id":';
  				$jsonStructure .= '"'.$opd_product_queue->product_id.'"';
  				$jsonStructure .= ",";
  				
  				$jsonStructure .= '"product_batch_id":';
  				$jsonStructure .= '"'.$opd_product_queue->id.'"';
  				$jsonStructure .= ",";
				
  				$jsonStructure .= '"product_name":';
  				$jsonStructure .= '"'.$product_names[$opd_product_queue->product_id].'"';
  				$jsonStructure .= ",";
  				
  				$jsonStructure .= '"location":';
  				$jsonStructure .= '"'.$provider_locs[$opd_product_queue->location_id].'"';
  				$jsonStructure .= ",";
  				
  				$jsonStructure .= '"batch":';
  				$jsonStructure .= '"'.$opd_product_queue->batch_number.'"';
  				$jsonStructure .= ",";
  				
  				$jsonStructure .= '"expiry":';
  				$jsonStructure .= '"'.$opd_product_queue->expiry_date.'"';
  				$jsonStructure .= ",";
  				
  				$jsonStructure .= '"quantity":';
  				$jsonStructure .= '"'.$opd_product_queue->quantity.'"';
  				$jsonStructure .= "}";
  				if($i==$number_of_stock){
  					
  				}else{
  					$jsonStructure .= ",";
  				}
  				$i=$i+1;
  				
  				/*$values[$i]['product_name'] = $product_names[$opd_product_queue->product_id];				
				$values[$i]['location'] =$provider_locs[$opd_product_queue->location_id];
				$values[$i]['batch'] =$opd_product_queue->batch_number;
				$values[$i]['product_id'] =$opd_product_queue->product_id;
				$values[$i]['expiry'] =$opd_product_queue->expiry_date;
				$values[$i]['quantity'] =$opd_product_queue->quantity;
				$i++;*/
			}
		$jsonStructure .= ']';
  		$jsonStructure .='}';

  		echo json_encode($jsonStructure);
  		
		/*$this->form_data['values'] = $values;
		 $this->form_data['total_results'] = $i;
		 echo 'i='. $i;	
		$this->load->view ( 'scm/expiry_add',$this->form_data );*/
		
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
	
	//TODO As of not using this function it was a brut force method to add to stock to particular branch.
	private function add_stock(){

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
			$tx_obj->to_id= $_POST['from_id'];
			$tx_obj->date = Date_util::to_sql($_POST['date']);
			$tx_obj->username = $this->session->userdata("username");
    $this->load->dbutil();
    $this->db->trans_begin();
    $tx_status = true;
			$stock_csv = '';
			if(!$tx_obj->save ())
					{$tx_status = false;
      					$home_msg = '1: Unable to save transaction object ';}
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
		   		{  echo "CSV File could not be written";  }
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
			
				$this->load->view($home,$data);
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

	function physical_stock_ (){
		$url = "/scm/stock/physical_stock/".$_POST['locn_id'];
		redirect($url);
	}

	function physical_stock ($location_id){
		if($location_id == '') {
    		$this->session->set_userdata('msg', 'Please provide Location id for entering physical stock');
			redirect('/scm/search/home');
		}

		$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
		$this->load->model ( 'scm/physical_reconcile_verification_model', 'physical_verification' );
		$org_obj = $this->scm_org->find($location_id);
		if($org_obj == null) {
    			$this->session->set_userdata('msg', 'Location id : '.$location_id.' does not exist');
			redirect('/scm/search/home');
		}

		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
    	$this->load->library('date_util');
		$this->form_data['location'] =  $org_obj->name;
		$this->form_data['location_id'] =  $location_id;
		$this->form_data['date'] = Date_util::today();
		$prod_stocks = $this->stock->find_all_by('location_id',$location_id);
		$this->load->model ( 'scm/transaction_model', 'tx' );
		$order_items = array();
		$i=0;
		$generic_name_array = array();
		$generic_medication_name_array = array();
		$generic_consumable_name_array = array();
		$generic_opd_product_name_array = array();
    	foreach ($prod_stocks as $item) {
			$this->load->model ( 'scm/product_model', 'product' );
			$prod =$this->product->find($item->product_id);
			$order_items[$i]['product_id']=$prod->generic_id;
			$order_items[$i]['brand_name']=$prod->name;
			$order_items[$i]['generic_name']=$prod->generic_name.' '.$prod->form;
			$order_items[$i]['strength']=$prod->strength.' '.$prod->strength_unit;
			$order_items[$i]['unit']= $prod->purchase_unit;
			$order_items[$i]['batch_number']= $item->batch_number;
			if(isset($item->expiry_date)){
				$order_items[$i]['expiry_date']= Date_util::to_display($item->expiry_date);
			}
			$order_items[$i]['quantity']= $item->quantity;
			$order_items[$i]['stock_id']= $item->id;
			$order_items[$i]['rate']= $prod->purchase_price;
			$order_items[$i]['product_type']= $prod->product_type;
			$generic_name_array[$prod->generic_id] = $prod->generic_name.' '.$prod->form;
			if($prod->product_type=="MEDICATION"){
				$generic_medication_name_array[$prod->generic_id] = $prod->generic_name.' '.$prod->form;
			}else if($prod->product_type=="CONSUMABLES"){
				$generic_consumable_name_array[$prod->generic_id] = $prod->generic_name.' '.$prod->form;
			}else if($prod->product_type=="OUTPATIENTPRODUCTS"){
				$generic_opd_product_name_array[$prod->generic_id] = $prod->generic_name.' '.$prod->form;
			}
			$i++;
		}
    	$this->form_data['number_items'] = $i;
    	$this->form_data['order_items'] = $order_items;
    	
    	$this->form_data['generic_names'] = array_unique($generic_name_array);
    	$this->form_data['generic_medication_names'] = array_unique($generic_medication_name_array);
    	$this->form_data['generic_consumable_names'] = array_unique($generic_consumable_name_array);
    	$this->form_data['generic_opd_product_names'] =  array_unique($generic_opd_product_name_array);
		if (! isset ( $_POST ['date'] ) ) {
    		$this->load->view ( 'scm/physical_stock',$this->form_data );
		} else {
			/*$data['scm_orgs'] = $this->get_scm_orgs();
		
			$generic_drug_list=$this->drug_generic->find_all(); 
	    	$data['generic_drug_list'] = $generic_drug_list;
	    	
	    	$brand_drug_list=$this->drug_brand->find_all(); 
	    	$data['brand_drug_list'] = $brand_drug_list;
	    	
	    	$organizations_list=$this->locationname->find_all(); 
	    	$data['organizations_list'] = $organizations_list;*/
			$ph_csv ='';
			$this->load->model ( 'scm/transaction_model', 'tx' );
			$tx_obj = $this->tx->new_record ( $_POST );
			$this->load->library('date_util');
			$tx_obj->date = Date_util::to_sql($_POST['date']);
			$tx_obj->username = $this->session->userdata("username");
			$tx_obj->type= 'Stock' ;
			$tx_obj->from_id= $location_id ;
			$tx_obj->to_id= $location_id ;
    		$this->load->dbutil();
    		$this->db->trans_begin();
    		$tx_status = true;
			if(!$tx_obj->save ())
					{$tx_status = false;
      					$home_msg = '1: Unable to save transaction object ';}
			$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
			$this->load->model ( 'scm/product_model', 'product' );
			$org =$this->scm_org->find($_POST['location_id']);
			$ph_csv =$ph_csv.'Physical Stock for:"'.$org->name.'"'."\n".'"'.$org->address.'"'."\n";
			$ph_csv =$ph_csv.'Date: ,'.$_POST['date']."\n\n\n";

			$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
			$this->load->model ( 'scm/product_physical_stock_model', 'ph_stock' );
			$bill_amount = 0.0;
			$ph_csv =$ph_csv.'SN,Brand Name,Generic Name,Batch No,Expiry,Qty,Rate,Total'."\n";
    			for ($i=0; $i < $_POST['number_items']; $i++) {
				$tx_item_obj = $this->tx_item->new_record();
				$phy_ver_obj = $this->physical_verification->new_record();
				$tx_item_obj->transaction_id = $tx_obj->id;
				$stock = $this->stock->find($_POST['stock_id_'.$i]);
				$prod = $this->product->find($stock->product_id);
				$tx_item_obj->product_id = $stock->product_id;
				$tx_item_obj->quantity = $_POST['quantity_'.$i];
				$tx_item_obj->rate = $prod->purchase_price;
				$tx_item_obj->value = $prod->purchase_price * $_POST['quantity_'.$i];
				$bill_amount = $bill_amount + $tx_item_obj->value;
      				if(!$tx_item_obj->save()){
      					$home_msg = '2: Unable to save transaction item entry for  '.$tx_item_obj->product_id;
  	 				$tx_status = false;
				}

				$phy_ver_obj->product_id = $stock->product_id;
				$phy_ver_obj->quantity = $_POST['actual_quantity_'.$i];
				$phy_ver_obj->reconcile_quantity = $_POST['quantity_'.$i];
				$phy_ver_obj->budgeted_rate = $prod->purchase_price;
				$phy_ver_obj->location_id = $location_id;
				$phy_ver_obj->date = $tx_obj->date;
				$phy_ver_obj->username = $tx_obj->username;
				$phy_ver_obj->tx_id = $tx_obj->id;
				$phy_ver_obj->delta= $_POST['quantity_'.$i] - round($stock->quantity,2);
				$phy_ver_obj->amount = $phy_ver_obj->delta * $phy_ver_obj->budgeted_rate ;
				
				if(!$phy_ver_obj->save()){
					$home_msg = '3: Unable to save entry for  '.$tx_item_obj->product_id;
					$tx_status = false;
				}
				
				/* updates product_batchwise_stock table 
					$stock->quantity = $_POST['quantity_'.$i];
					$stock->save();
				*/
				
				
				$ph_obj = $this->ph_stock->new_record();
				$ph_obj->stock_date = $tx_obj->date;
				$ph_obj->location_id = $location_id;
				$ph_obj->tx_id	= $tx_obj->id;
				$ph_obj->stock_id = $stock->id;
				$ph_obj->product_id = $stock->product_id;
				$ph_obj->marketed_by= $stock->marketed_by;
				$ph_obj->manufactured_by= $stock->manufactured_by;
				$ph_obj->batch_number= $stock->batch_number;
				$ph_obj->expiry_date= $stock->expiry_date;
				$ph_obj->quantity = $_POST['quantity_'.$i];
				$ph_obj->delta= $_POST['quantity_'.$i] - round($stock->quantity,2);
				if($ph_obj->delta !=0)
					$ph_obj->reconciled = 'No';
				else
					$ph_obj->reconciled = 'Yes';
      				if(!$ph_obj->save()){
      					$home_msg = '3: Unable to save Physical Stock Object for  '.$ph_obj->product_id;
  	 				$tx_status = false;
				}

			  $ph_csv = $ph_csv.($i+1).'","'.$prod->name.'","'.$prod->generic_name.'",'.$ph_obj->batch_number.','.$ph_obj->expiry_date.','.$tx_item_obj->quantity.','.$tx_item_obj->rate.','.$tx_item_obj->value."\n";
    			}
//			$tx_obj->bill_amount = $_POST['bill_amount'];
			$ph_csv = $ph_csv.'Total :,,,,,,,'.$tx_obj->bill_amount;
//			if(!$tx_obj->save ())
//					{$tx_status = false;}

			if($tx_status === true){
       			$this->db->trans_commit();
	        	$base_path = $this->config->item('base_path');
	    	   	$filename = 'uploads/stocks/'.$_POST['location_id'].'-'.$tx_obj->date.'-phy-stock.csv';
	    	   	$fp = fopen($base_path.$filename,"w");
		   		if(!fwrite($fp,$ph_csv)){  
		   			echo "CSV File could not be written";  
		   		}
		   		$home_msg='Physical Stock with Location id : '.$location_id.' taken successfully';
				//$this->session->set_userdata('msg', $home_msg);
				$this->form_data['filetype'] = 'Physical Stock Details';
				$this->form_data['filename'] = $filename;
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
			
				//$this->load->view($home,$data);
//				redirect('/scm/search/home');
				$this->form_data['success_message'] = $home_msg;
				$this->load->view ( 'scm/physical_stock',$this->form_data );
			}
			else
			{
       	$this->db->trans_rollback();
    				//$this->session->set_userdata('msg', 'Physical Stock unsuccessful. '.$home_msg.' Please try again');
				//redirect('/scm/search/home');
//				$this->load->view ( 'scm/search/home');
				$this->form_data['error_server'] = 'Physical Stock unsuccessful. '.$home_msg.'. Please try again';
				$this->load->view ( 'scm/physical_stock',$this->form_data );
			}
		}
	}
	
	/**
 	*	@author praveen
 	*	A ajax call for fetching physical stock details in html format
 	*/
 	function fetch_physical_stock() {
 		$location_id = $this->input->post('location_id');
 		$product_type = $this->input->post('product_type');
 		$generic_name = $this->input->post('generic_name');
 		if($location_id == '') {
    		$this->session->set_userdata('msg', 'Please provide Location id for entering physical stock');
			redirect('/scm/search/home');
		}
 		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
    	$this->load->library('date_util');
		$prod_stocks = $this->get_stock_by_product_type($location_id,$product_type);
		
		$i=0;
		$ret_val_html = "";
		$has_value = false;
		foreach ($prod_stocks as $key => $item) {
			$this->load->model ( 'scm/product_model', 'product' );
			$prod =$this->product->find($item->product_id);
			if(!empty($generic_name) || $generic_name !== ""){
				if(strtolower($generic_name) === strtolower($prod->generic_name.' '.$prod->form)){
					$ret_val_html.= '<tr>'."\n";
					$ret_val_html.= '<td>'.($i+1).'</td>'."\n";
					$ret_val_html.= '<td>'.$prod->name.'</td>'."\n";
					$ret_val_html.= '<td>'.$prod->generic_name.' '.$prod->form.'</td>'."\n";
					$ret_val_html.= '<td>'.ucfirst(strtolower($prod->product_type)).'</td>'."\n";
					$ret_val_html.= '<td>'.$prod->strength.' '.$prod->strength_unit.'</td>'."\n";
					$ret_val_html.= '<td>'.$item->batch_number.'</td>'."\n";
					if(isset($item->expiry_date)){
						$ret_val_html.= '<td>'.Date_util::to_display($item->expiry_date).'</td>'."\n";
					}else{
						$ret_val_html.= '<td></td>'."\n";
					}
					$ret_val_html.= '<td>'.$prod->purchase_unit.'</td>'."\n";
					$ret_val_html.= '<td><input type="text" name="quantity_'.$i.'" id="quantity_'.$i.'" value="'.round($item->quantity,2).'" size="4"  onchange="update_total()"/></td>'."\n";
					$ret_val_html.= '<input type="hidden" name="actual_quantity_'.$i.'" id="actual_quantity_'.$i.'" value="'.round($item->quantity,2).'" size="4" />'."\n";
					$ret_val_html.= '<input type="hidden" name="stock_id_'.$i.'" id="stock_id_'.$i.'" value="'.$item->id.'" />'."\n";
					$ret_val_html.= '<td id="rate_'.$i.'" value="'.$prod->purchase_price.'">'.$prod->purchase_price.'</td>'."\n";
					$ret_val_html.= '<td id="total_'.$i.'" ></td>'."\n";
					$ret_val_html.= '</tr>'."\n";
					$i++;
					$has_value = true;
				}
			}else{
				$ret_val_html.= '<tr>'."\n";
				$ret_val_html.= '<td>'.($i+1).'</td>'."\n";
				$ret_val_html.= '<td>'.$prod->name.'</td>'."\n";
				$ret_val_html.= '<td>'.$prod->generic_name.' '.$prod->form.'</td>'."\n";
				$ret_val_html.= '<td>'.ucfirst(strtolower($prod->product_type)).'</td>'."\n";
				$ret_val_html.= '<td>'.$prod->strength.' '.$prod->strength_unit.'</td>'."\n";
				$ret_val_html.= '<td>'.$item->batch_number.'</td>'."\n";
				if(isset($item->expiry_date)){
					$ret_val_html.= '<td>'.Date_util::to_display($item->expiry_date).'</td>'."\n";
				}else{
					$ret_val_html.= '<td></td>'."\n";
				}
				$ret_val_html.= '<td>'.$prod->purchase_unit.'</td>'."\n";
				$ret_val_html.= '<td><input type="text" name="quantity_'.$i.'" id="quantity_'.$i.'" value="'.$item->quantity.'" size="4"  onchange="update_total()"/></td>'."\n";
				$ret_val_html.= '<input type="hidden" name="actual_quantity_'.$i.'" id="actual_quantity_'.$i.'" value="'.$item->quantity.'" size="4" />'."\n";
				$ret_val_html.= '<input type="hidden" name="stock_id_'.$i.'" id="stock_id_'.$i.'" value="'.$item->id.'" />'."\n";
				$ret_val_html.= '<td id="rate_'.$i.'" value="'.$prod->purchase_price.'">'.$prod->purchase_price.'</td>'."\n";
				$ret_val_html.= '<td id="total_'.$i.'" ></td>'."\n";
				$ret_val_html.= '</tr>'."\n";
				$i++;
				$has_value = true;
			}
		}
		$ret_val_html.= '<tr><td colspan="11"><input type="hidden" name="number_items" id="number_items" value="'.$i.'" /></td></tr>';
		if(!$has_value){
			$ret_val_html = "";
			$ret_val_html.= '<tr>'."\n";
			$ret_val_html.= '<td colspan= "11" align="center">No data</td>'."\n";
			$ret_val_html.='</tr>';
		}
		
		echo $ret_val_html;
	}
	
	/**
 	*	@author praveen
 	*	Its a backup for fetch_physical_stock().
 	*/
	function get_stock_by_product_type($location_id,$product_type){
		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
		$stocks = $this->stock->find_all_by('location_id',$location_id);
		$prod_stock = array();
		foreach ($stocks as $item) {
			$this->load->model ( 'scm/product_model', 'product' );
			$prod =$this->product->find($item->product_id);
			if($product_type === "ALL"){
				array_push($prod_stock, $item);
			}else if(strtolower($product_type) === strtolower($prod->product_type)){
				array_push($prod_stock, $item);
			}
		}
		return $prod_stock;
	}

	function reconcile_stock_ (){
		$url = "/scm/stock/reconcile_stock/".$_POST['locn_id'];
		redirect($url);
	}

	function reconcile_stock ($location_id){
		if($location_id == '') {
    			$this->session->set_userdata('msg', 'Please provide Location id for entering physical stock');
			redirect('/scm/search/home');
		}

		$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
		$org_obj = $this->scm_org->find($location_id);
		if($org_obj == null) {
    			$this->session->set_userdata('msg', 'Location id : '.$location_id.' does not exist');
			redirect('/scm/search/home');
		}

		$this->load->model ( 'scm/product_physical_stock_model', 'ph_stock' );
    $this->load->library('date_util');

		if (! isset ( $_POST ['date'] ) ) {
			$this->form_data['location'] =  $org_obj->name;
			$this->form_data['location_id'] =  $location_id;
			$this->form_data['date'] = Date_util::today();
			$ph_stocks = $this->ph_stock->find_all_by(array('location_id','reconciled'),array($location_id,'No'));
			$this->load->model ( 'scm/transaction_model', 'tx' );
			$order_items = array();
			$i=0;
    			foreach ($ph_stocks as $item) {
				$this->load->model ( 'scm/product_model', 'product' );
				$prod =$this->product->find($item->product_id);
				$order_items[$i]['product_id']=$prod->generic_id;
				$order_items[$i]['brand_name']=$prod->name;
				$order_items[$i]['generic_name']=$prod->generic_name.' '.$prod->form;
				$order_items[$i]['strength']=$prod->strength.' '.$prod->strength_unit;
				$order_items[$i]['unit']= $prod->purchase_unit;
				$order_items[$i]['batch_number']= $item->batch_number;
				if(isset($item->expiry_date)){
					$order_items[$i]['expiry_date']= Date_util::to_display($item->expiry_date);
				}
				$order_items[$i]['quantity']= $item->quantity;
				$order_items[$i]['delta']= $item->delta;
				$order_items[$i]['stock_id']= $item->stock_id;
				$order_items[$i]['ph_stock_id']= $item->id;

				$i++;
			}

    			$this->form_data['number_items'] = $i;
    			$this->form_data['order_items'] = $order_items;
			$this->load->view ( 'scm/reconcile_stock',$this->form_data );
		} else {
			$data['scm_orgs'] = $this->get_scm_orgs();
		
			$generic_drug_list=$this->drug_generic->find_all(); 
	    	$data['generic_drug_list'] = $generic_drug_list;
	    	
	    	$brand_drug_list=$this->drug_brand->find_all(); 
	    	$data['brand_drug_list'] = $brand_drug_list;
	    	
	    	$organizations_list=$this->locationname->find_all(); 
	    	$data['organizations_list'] = $organizations_list;
			$ph_csv ='';
			$this->load->model ( 'scm/transaction_model', 'tx' );
			$tx_obj = $this->tx->new_record ( $_POST );
			$this->load->library('date_util');
			$tx_obj->date = Date_util::to_sql($_POST['date']);
			$tx_obj->username = $this->session->userdata("username");
			$tx_obj->type= 'Reconcile' ;
			$tx_obj->from_id= $location_id ;
			$tx_obj->to_id= $location_id ;
    $this->load->dbutil();
    $this->db->trans_begin();
    $tx_status = true;
			if(!$tx_obj->save ())
					{$tx_status = false;
      					$home_msg = '1: Unable to save transaction object ';}
			$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
			$this->load->model ( 'scm/product_model', 'product' );
			$org =$this->scm_org->find($_POST['location_id']);
			$ph_csv =$ph_csv.'Reconcile Physical Stock for:"'.$org->name.'"'."\n".'"'.$org->address.'"'."\n";
			$ph_csv =$ph_csv.'Date: ,'.$_POST['date']."\n\n\n";

			$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
			$this->load->model ( 'scm/product_physical_stock_model', 'ph_stock' );
			$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
			$ph_csv =$ph_csv.'SN,Brand Name,Generic Name,Batch No,Expiry,Qty,Old Delta, New Delta'."\n";
    			for ($i=0; $i < $_POST['number_items']; $i++) {
				$tx_item_obj = $this->tx_item->new_record();
				$tx_item_obj->transaction_id = $tx_obj->id;
				$stock = $this->stock->find($_POST['stock_id_'.$i]);
				$ph_stock = $this->ph_stock->find($_POST['ph_stock_id_'.$i]);
				$prod = $this->product->find($stock->product_id);
				$tx_item_obj->product_id = $stock->product_id;
				$tx_item_obj->quantity = $ph_stock->quantity;
				$tx_item_obj->rate = $ph_stock->delta;
				$tx_item_obj->value = $_POST['delta_'.$i];
      				if(!$tx_item_obj->save()){
      					$home_msg = '2: Unable to save transaction item entry for  '.$tx_item_obj->product_id;
  	 				$tx_status = false;
				}

//				$ph_stock->delta= $_POST['delta_'.$i] ;
				$ph_stock->reconciled = 'Yes';
      				if(!$ph_stock->save()){
      					$home_msg = '3: Unable to save Physical Stock Object for  '.$ph_stock->product_id;
  	 				$tx_status = false;
				}

				if($_POST['delta_'.$i] !=0)
				{
					$stock->quantity += $_POST['delta_'.$i];
					if($stock->quantity ===0){
						$stock->delete();
					}else{
      					if(!$stock->save()){
      						$home_msg = '4: Unable to save Batchwise Stock Object for  '.$stock->product_id;
  	 					$tx_status = false;
						}
					}
				}

			  $ph_csv = $ph_csv.($i+1).'","'.$prod->name.'","'.$prod->generic_name.'",'.$ph_stock->batch_number.','.$ph_stock->expiry_date.','.$tx_item_obj->quantity.','.$tx_item_obj->rate.','.$ph_stock->delta."\n";
    			}

			if($tx_status == true)
			{
       	$this->db->trans_commit();
	        		$base_path = $this->config->item('base_path');
	    	   		$filename = 'uploads/stocks/'.$_POST['location_id'].'-'.$tx_obj->date.'-recon.csv';
	    	   		$fp = fopen($base_path.$filename,"w");
		   		if(!fwrite($fp,$ph_csv))
		   		{  echo "CSV File could not be written";  }
    				
				$this->session->set_userdata('msg', 'Reconciliation Stock with Location id : '.$location_id.' taken successfully');
				$data['filetype'] = 'Reconciliation Stock Details';
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
    				$this->session->set_userdata('msg', 'Reconciliation Stock unsuccessful. '.$home_msg.' Please try again');
				redirect('/scm/search/home');
//				$this->load->view ( 'scm/search/home');
			}
		}
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
	
	function can_receive($scm_org_id = 0)
	{
		$this->load->model('opd/provider_location_model','pl');
		$pl_rec = $this->pl->find_by('scm_org_id',$scm_org_id);
		if($pl_rec)
		{
			if($pl_rec->id != $this->session->userdata('location_id')) {
				return false;
			}
		}
		return true;
	}
	
	function expired_product($location_id=''){

		 $this->load->model ( 'scm/scm_organization_model', 'scm_org' );
		 $this->load->model('opd/provider_location_model', 'provider_location');
		 $this->load->model ( 'scm/transaction_model', 'tx' );
		 $this->load->model('scm/expiry_log_detail_model','expiry_log');
		 $this->load->model ( 'scm/transaction_item_model', 'tx_item' );
		 if($location_id===''){
			if(!($this->session->userdata('location_id'))){
			    $this->session->set_flashdata('msg_type', 'error');
		  		$this->session->set_flashdata('msg', 'Location must be chosen ');
		  		redirect('opd/visit/home');
			 }
			 $location_id=$this->session->userdata('location_id');
			 $scm_org_id=$this->provider_location->find_by('id',$location_id)->scm_org_id;
		 }else{
		 	$scm_org_id=$location_id;
		 }
		if($this->scm_org->where('id',$scm_org_id)->find()->origin ==='DISTRIBUTION'){
	  		redirect('scm/stock/expiry/'.$scm_org_id);
		 }
		$tx_item_obj = $this->tx_item->new_record();
		$this->load->library('date_util');
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'date', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );
		$this->form_data['scm_orgs'] = $this->get_scm_orgs();
		$this->form_data['date'] = Date_util::today();
		
		$this->load->model ( 'scm/product_model', 'product' );
		$this->load->model('scm/product_batchwise_stock_model', 'product_batchwise_stock');
		$product_batchwise_query=$this->product_batchwise_stock->where('location_id',$scm_org_id)->where('quantity >','0')->find_all();
    	$unique_products = array();
    	foreach($product_batchwise_query as $query){
    		$unique_products[$query->product_id]=$query->product_id;
    	}
    	$this->form_data['product_batchwise_list']=array_unique($unique_products);

		if (! isset ( $_POST ['date'] ) || $this->form_validation->run () == FALSE) {
				
			$this->load->view('/scm/consumable_center_expiry',$this->form_data);
		} else {
			$vals=$_POST['medication'];
			$tx_obj = $this->tx->new_record ( $_POST );
			$tx_obj->type = 'Expiry';
			$tx_obj->date = Date_util::to_sql($_POST['date']);
			$tx_obj->username = $this->session->userdata("username");
			$this->load->dbutil();
			$this->db->trans_begin();
			$tx_status = true;
			if(!$tx_obj->save ()){
				$tx_status = false;
      			$home_msg = '1: Unable to save transaction object ';
			}
			$expiry_csv = '';			
			$from_org =$this->scm_org->find($scm_org_id);
			$expiry_csv =$expiry_csv.'From:"'.$from_org->name.'"'."\n".'"'.$from_org->address.'"'."\n";
			$expiry_csv =$expiry_csv.'No: ,'.$tx_obj->id.',,Date: ,'.$_POST['date']."\n\n\n\n\n\n";

			$expiry_csv =$expiry_csv.'SN,Brand Name,Generic Name,Generic Type,Quantity,Rate,Total'."\n";
			$i=1;
			foreach ($vals as $val){
				$this->load->library('date_util');
				$tx_item_obj = $this->tx_item->new_record();
				$expiry_log_obj = $this->expiry_log->new_record();
				$tx_item_obj->transaction_id = $tx_obj->id;
				$tx_item_obj->product_id = $val['product_id'];
				$tx_item_obj->quantity = $val['quantity'];
				$tx_item_obj->rate = $val['rate'];
				$tx_item_obj->value = $val['rate'] * $val['quantity'];
      			if(!$tx_item_obj->save()) {
      				$home_msg = '3: Unable to save transaction item entry for '.$tx_item_obj->product_id;
      				$this->session->set_userdata('msg', $home_message);
  	 				$tx_status = false;
				}
				$expiry_log_obj->product_id = $val['product_id'];			
				$expiry_log_obj->quantity = $val['quantity'];
				$expiry_log_obj->username = $tx_obj->username;
				$expiry_log_obj->budgeted_rate = $val['rate'];
				$expiry_log_obj->value = $val['rate'] * $val['quantity'];
				$expiry_log_obj->location_id = $scm_org_id;
				$expiry_log_obj->from_date = $tx_obj->date;
				if(!$expiry_log_obj->save()){
					$home_msg = '3: Unable to save expiry item entry for '.$tx_item_obj->product_id;
					$this->session->set_userdata('msg', $home_message);
					$tx_status = false;
				}						
			 	$product_id=$val['product_id'];
				$product = $this->product->find_by ('id',$product_id);
				$quantity_expire=$val['quantity'];
				$qty=$quantity_expire/$product->retail_units_per_purchase_unit;
				$batchwise_stock=$this->product_batchwise_stock->where('product_id',$product_id)->where('location_id',$scm_org_id)->where('quantity >','0')->find_all();

				$bal_qty=$qty;
				
				foreach ($batchwise_stock as $batch)
				{
					$quantity=$batch->quantity;
					if($bal_qty!=0){
			 			if($batch->quantity > $bal_qty)
			 			{
			 				$batch->quantity=$batch->quantity-$bal_qty;
			 				$bal_qty=0;
			 			}
						else{
			 				$bal_qty=$bal_qty-$batch->quantity;
			 				$batch->quantity=0;
			 			}	
			 			if (!$batch->save()){
			 				$tx_status = false;
      					$home_msg =' Unable to save batchwise entry for '.$tx_item_obj->product_id;
			 			}
					}
				}
				if($bal_qty>0){
					$tx_status = false;
					$home_msg =' Drugs entered is beyond Stock Range. Please try again';
				}
				$expiry_csv = $expiry_csv.$i.','.$product->name.','.$product->generic_name.','.$product->product_type.','.$quantity_expire.','.$tx_item_obj->rate.','.$quantity_expire*$tx_item_obj->rate."\n";
    			$i++;
				
			}
			$expiry_csv = $expiry_csv.'Total value,,,,,,'.$_POST['bill_amount'];
			
			if(!$tx_status){
				$this->db->trans_rollback();
			 	$this->session->set_flashdata('msg_type', 'error');
  				$this->session->set_flashdata('msg', $home_msg);
  				redirect('scm/stock/expired_product/'.$location_id);
			 }else{
			 	$this->db->trans_commit();
			 	$base_path = $this->config->item('base_path');
	    	   		$filename = 'uploads/orders/consumable-center-expiry-'.$tx_obj->id.'.csv';
	    	   		$fp = fopen($base_path.$filename,"w");
		   		if(!fwrite($fp,$expiry_csv)){
		   			echo "CSV File could not be written";  
		   		}
			 	$this->session->set_flashdata('msg_type', 'success');
  				$this->session->set_flashdata('msg', 'Drugs selected successfully expired ');
  				$this->session->set_flashdata('filetype', ' Expiry Details ');
  				$this->session->set_flashdata('filename', $filename);
  				redirect('scm/stock/expired_product/'.$location_id);
		 	}
		}
	}
		
}

?>
