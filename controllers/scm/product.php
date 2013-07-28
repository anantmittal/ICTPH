<?php
class product extends CI_Controller {
	public $form_data = array();
	function add(){

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'Brand Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );
		$this->load->model ( 'scm/drug_generic_model', 'drug_gx' );
		$gxs = $this->drug_gx->order_by('generic_name','ASC')->find_all();
		$gx_d = array();
		foreach($gxs as $gx)
		{
			$gx_d[$gx->id] = $gx->generic_name.' '.$gx->strength.' '.$gx->strength_unit.' '.$gx->capacity.' '.$gx->purchase_unit;
		}
		$this->form_data['gxs'] = $gx_d;


		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'scm/product_add',$this->form_data );
		} else {
//			$this->load->model ( 'scm/product_model', 'product' );
			$this->load->model ( 'scm/drug_brand_model', 'drug_brand' );
//			$product_obj = $this->product->new_record ( $_POST );
			$product_obj = $this->drug_brand->new_record ( $_POST );
//			$product_obj->save ();
           $this->load->dbutil();
           $this->db->trans_begin();
           $tx_status = true;
			if(!$product_obj->save ())
				$tx_status = false;

			$this->load->model ( 'opd/opd_product_model', 'opd_product' );
			$op_obj = $this->opd_product->new_record();
			$op_obj->product_id = $product_obj->id;
			if(!$op_obj->save())
				$tx_status = false;

			$this->load->model ( 'scm/pricelist_model', 'pl' );
			$pl_obj = $this->pl->new_record();
			$pl_obj->product_id = $product_obj->id;
			$pl_obj->pricelist_id = 1;
			$pl_obj->price = $product_obj->purchase_price;
			if(!$pl_obj->save())
				$tx_status = false;
				
			if($tx_status)
			{
       	$this->db->trans_commit();
    				$this->session->set_userdata('msg', 'Product: '.$product_obj->name. ' saved successfully with id '.$product_obj->id);
				redirect('/scm/search/home');
			}
			else
			{
       	$this->db->trans_rollback();
    				$this->session->set_userdata('msg', 'Product: '.$product_obj->name.' saved unsuccessful');
				$this->load->view ( 'scm/product_add',$this->form_data );
			}
		}

	}

	function edit_()
	{ 
		$brand_drug_id= $_POST['brand_value'];
		$url = "/scm/product/edit/".$brand_drug_id;
		redirect($url);
	}
		
	function edit($product_id = ''){
		if($product_id == '') {
			echo 'No brand name chosen';
			return;
		}

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'Brand Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

//		$this->load->model ( 'scm/product_model', 'product' );
		$this->load->model ( 'scm/drug_brand_model', 'product' );
		$this->load->model ( 'scm/product_model', 'select_product' );
		$product_obj = $this->product->find($product_id);
		
		$product_obj1 = $this->select_product->find($product_id);
		if($product_obj1->product_type==='UNUSED'){
			$this->form_data['is_product_enabled'] = true;
		}
		
		$this->form_data['product_obj'] = & $product_obj;
		$this->load->model ( 'scm/drug_generic_model', 'drug_gx' );
		$gxs = $this->drug_gx->order_by('generic_name','ASC')->find_all();
		$gx_d = array();
		foreach($gxs as $gx)
		{
			$gx_d[$gx->id] = $gx->generic_name.' '.$gx->strength.' '.$gx->strength_unit.' '.$gx->capacity.' '.$gx->purchase_unit;
		}
		$this->form_data['gxs'] = $gx_d;

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'scm/product_add',$this->form_data );
		} else {
//			$product_obj->load_postdata(array('name','generic_name', 'strength','strength_unit','description',
//								'form','purchase_unit','retail_unit','retail_units_per_purchase_unit','retail_price','purchase_price'));
    $this->load->dbutil();
    $this->db->trans_begin();
    $tx_status = true;
			if($product_obj->purchase_price != $_POST['purchase_price'])
			{
				$this->load->model ( 'scm/pricelist_model', 'pl' );
				$pl_obj = $this->pl->where('product_id',$product_obj->id)->where('pricelist_id','1')->find();
				$pl_obj->price = $_POST['purchase_price'];
				if(!$pl_obj->save())
					$tx_status = false;
			}

			$product_obj->load_postdata(array('name','generic_id', 'retail_units_per_purchase_unit','purchase_price','mrp'));
			if(!$product_obj->save ())
				$tx_status = false;

			if($tx_status)
			{
       	$this->db->trans_commit();
    				$this->session->set_userdata('msg', 'Product: '.$product_obj->name.' saved successfully');
//    				$this->session->set_userdata('msg', 'Product saved successfully');
				redirect('/scm/search/home');
			}
			else
			{
       	$this->db->trans_rollback();
//    				$this->session->set_userdata('msg', 'Product saved unsuccessful');
    				$this->session->set_userdata('msg', 'Product: '.$product_obj->name.' saved unsuccessful');
				$this->load->view ( 'scm/product_add', $this->form_data);
			}
	
		}
	}

	function add_generic(){

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'generic_name', 'Generic Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );


		if (! isset ( $_POST ['generic_name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'scm/generic_add' );
		} else {
			$this->load->model ( 'scm/drug_generic_model', 'drug_generic' );
			$product_obj = $this->drug_generic->new_record ( $_POST );
			if($product_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Generic: '.$product_obj->generic_name.' saved successfully with id '.$product_obj->id);
				redirect('/scm/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'Generic: '.$product_obj->generic_name.' saved unsuccessful');
				$this->load->view ( 'scm/generic_add');
			}
		}

	}

	function edit_generic_()
	{
	    $drug_generic_id=$_POST['generic_value'];
		$url = "/scm/product/edit_generic/".$drug_generic_id;
		redirect($url);
	}
		
	function edit_generic($product_id = ''){
		if($product_id == '') {
			echo 'No Generic name chosen';
			return;
		}

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'generic_name', 'Generic Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->load->model ( 'scm/drug_generic_model', 'drug_gx' );
		$product_obj = $this->drug_gx->find($product_id);
		$this->form_data['product_obj'] = & $product_obj;

		if (! isset ( $_POST ['generic_name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'scm/generic_add',$this->form_data );
		} else {
			$product_obj->load_postdata(array('generic_name', 'strength','strength_unit','capacity','description','form','purchase_unit','retail_unit','retail_price','product_type','product_order_type'));
			if($product_obj->save())
			{
    				$this->session->set_userdata('msg', 'Generic: '.$product_obj->generic_name.' saved successfully');
//    				$this->session->set_userdata('msg', 'Product saved successfully');
				redirect('/scm/search/home');
			}
			else
			{
//    				$this->session->set_userdata('msg', 'Product saved unsuccessful');
    				$this->session->set_userdata('msg', 'Generic: '.$product_obj->generic_name.' saved unsuccessful');
				$this->load->view ( 'scm/generic_add', $this->form_data);
			}
	
		}
	}

	function get_products() {
		$products = array ();
		$p_obj = IgnitedRecord::factory ( 'products' );
		$p_rows = $p_obj->find_all ();
		foreach ( $p_rows as $p_row ) {
			$products [$p_row->id] = $p_row->name;
		}
		return $products;
	}
	
	function stock_report_(){
		$url = "/scm/product/stock_report/".$_POST['locn_id'];
		redirect($url);
	}
	

	function stock_report($location_id=''){
		$this->load->model('opd/provider_location_model','pl_obj');
		if($location_id===''){
			$location_id= $this->session->userdata('location_id');
			if(empty($location_id)){
			  	$this->session->set_flashdata('msg_type', 'error');
			  	$this->session->set_flashdata('msg', 'Location must be chosen ');
				redirect('opd/visit/home');
		  	}else{
		  		$location_id=$this->pl_obj->find_by('id',$location_id)->scm_org_id;
		  	}
		}
		$this->load->helper('download');
		$this->load->model('opd/provider_location_model','pl_obj');

		$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
		$org_obj = $this->scm_org->find($location_id);
		if($org_obj == null) {
    			$this->session->set_userdata('msg', 'Location id : '.$location_id.' does not exist');
			redirect('/scm/search/home');
		}
		$this->form_data['location_type'] =  $org_obj->origin;
		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
    	$this->load->library('date_util');
		$this->form_data['location'] =  $org_obj->name;
		$this->form_data['location_id'] =  $location_id;
		$this->form_data['date'] = Date_util::today();
		$prod_stocks = $this->stock->select_sum('quantity','t_quantity')->where('quantity >','0')->group_by('product_id')->group_by('batch_number')->order_by('product_id')->find_all_by('location_id',$location_id);
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
			$order_items[$i]['product_id']=$prod->id;
			$order_items[$i]['brand_name']=$prod->name;
			$order_items[$i]['batch_number']= $item->batch_number;
			if(isset($item->expiry_date)){
				$order_items[$i]['expiry_date']= Date_util::to_display($item->expiry_date);
			}
			$order_items[$i]['quantity']= $item->t_quantity;
			$order_items[$i]['product_type']= $prod->product_type;
			$generic_name_array[$prod->generic_id] = $prod->generic_name.' '.$prod->form;
			if($prod->product_type=="MEDICATION"){
				$generic_medication_name_array[$prod->generic_id] = $prod->generic_name.' '.$prod->form;
			}else if($prod->product_type=="CONSUMABLES"){
				$generic_consumable_name_array[$prod->generic_id] = $prod->generic_name.' '.$prod->form;
			}else if($prod->product_type=="OUTPATIENTPRODUCTS"){
				$generic_opd_product_name_array[$prod->generic_id] = $prod->generic_name.' '.$prod->form;
				$order_items[$i]['opd_product_type']=$prod->product_order_type;
				$order_items[$i]['visit_id']=$prod->product_order_type;
			}
			$i++;
		}
    	$this->form_data['number_items'] = $i;
    	$this->form_data['order_items'] = $order_items;
    	
    	$this->form_data['generic_names'] = array_unique($generic_name_array);
    	$this->form_data['generic_medication_names'] = array_unique($generic_medication_name_array);
    	$this->form_data['generic_consumable_names'] = array_unique($generic_consumable_name_array);
    	$this->form_data['generic_opd_product_names'] =  array_unique($generic_opd_product_name_array);
    	if (! isset ( $_POST ['product_type'] ) ) {
    		$this->load->view ( 'scm/get_stock',$this->form_data );
    	}else{
    		$location_id = $_POST ['location_id'];
 			$product_type =$_POST ['product_type'];
 			$generic_id = $_POST ['generic_id'];
 			$provider_location_type = $_POST ['location_type'];
			$prod_stocks = $this->get_stock_by_product_type($location_id,$product_type);
			if($provider_location_type==='DISTRIBUTION'){
				$items_csv = 'SN,Product Id,Product Name,Batch No,Expiry,Quantity, Type,OP Product Type '."\n";
			}else{
				$items_csv = 'SN,Product Id,Product Name,Quantity, Type,OP Product Type '."\n";
			}
			$i=0;
			foreach ($prod_stocks as $item) {
				$prod =$this->product->find($item->product_id);
				if(!empty($generic_id) || $generic_id !== ""){
					if($generic_id === $prod->generic_id){
						if(isset($item->expiry_date)){
							if($provider_location_type==='DISTRIBUTION'){
								$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.$item->batch_number.','.Date_util::to_display($item->expiry_date).','.round($item->t_quantity,2).','.$prod->product_type;
							}else{
								$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.round($item->t_quantity,2).','.$prod->product_type;
							}
							$order_items[$i]['expiry_date']= Date_util::to_display($item->expiry_date);
						}else{
							if($provider_location_type==='DISTRIBUTION'){
								$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.$item->batch_number.',,'.round($item->t_quantity,2).','.$prod->product_type;
							}else{
								$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.round($item->t_quantity,2).','.$prod->product_type;
							}
							$order_items[$i]['expiry_date']='-';
						}
						if($prod->product_type==='OUTPATIENTPRODUCTS'){
							$items_csv = $items_csv.','.$prod->product_order_type."\n";
						}else{
							$items_csv = $items_csv.','."\n";
						}
						$order_items[$i]['product_id']=$prod->id;
						$order_items[$i]['brand_name']=$prod->name;
						$order_items[$i]['batch_number']= $item->batch_number;
						$order_items[$i]['quantity']= $item->t_quantity;
						$order_items[$i]['product_type']= $prod->product_type;
						if($prod->product_type=="OUTPATIENTPRODUCTS"){
							$order_items[$i]['opd_product_type']=$prod->product_order_type;
						}
						$i++;
					}
				}else{
					if(isset($item->expiry_date)){
						if($provider_location_type==='DISTRIBUTION'){
							$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.$item->batch_number.','.Date_util::to_display($item->expiry_date).','.round($item->t_quantity,2).','.$prod->product_type;
						}else{
							$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.round($item->t_quantity,2).','.$prod->product_type;
						}
						$order_items[$i]['expiry_date']= Date_util::to_display($item->expiry_date);
					}else{
						if($provider_location_type==='DISTRIBUTION'){
							$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.$item->batch_number.',,'.round($item->t_quantity,2).','.$prod->product_type;
						}else{
							$items_csv = $items_csv.$i.','.$prod->id.','.$prod->name.','.round($item->t_quantity,2).','.$prod->product_type;
						}
						$order_items[$i]['expiry_date']='-';
					}
					if($prod->product_type==='OUTPATIENTPRODUCTS'){
						$items_csv = $items_csv.','.$prod->product_order_type."\n";
					}else{
						$items_csv = $items_csv.','."\n";
					}
					$order_items[$i]['product_id']=$prod->generic_id;
					$order_items[$i]['brand_name']=$prod->name;
					$order_items[$i]['batch_number']= $item->batch_number;
					$order_items[$i]['quantity']= $item->t_quantity;
					$order_items[$i]['product_type']= $prod->product_type;
					if($prod->product_type=="OUTPATIENTPRODUCTS"){
						$order_items[$i]['opd_product_type']=$prod->product_order_type;
					}
					$i++;
				}
			}	
			$this->load->helper('date');
			$time = time();
			$datestring= "%Y%m%d";
	    	$today_date = mdate($datestring, $time);
			 $this->form_data['number_items'] = $i;
    		$this->form_data['order_items'] = $order_items;
    		$this->form_data['product_selected'] = $product_type;
    		$filename=$location_id.'-'.$today_date.'-stock.csv';
    		force_download($filename, $items_csv);
			$this->load->view ( 'scm/get_stock',$this->form_data );
    	}
	}
	
	function expiry_details($location_id) {
		$this->load->library('plsp/writer/pdfwriter');
		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
		$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
		$location=$this->scm_org->find_by('id',$location_id)->name;
		//echo $location_id;
		$this->load->library('date_util');
		$today = date("Y-m-d");
		$newdate = strtotime ( '+2 months' , strtotime($today)) ;
		$newdate = date ( "Y-m-d", $newdate );
		$prod_stocks = $this->stock->select_sum('quantity','t_quantity')->where('quantity >','0')->where('expiry_date <',$newdate)->group_by('product_id')->group_by('batch_number')->order_by('product_id')->find_all_by('location_id',$location_id);
		$doc = new tcPdfWriter();
		$doc->InitDoc();
		$doc->PrepareDoc("", "right", "left", "Bottom", $this->config->item('logo_file'));
		$expiry_details_header = array('SN','Product Id','Product Name','Batch No','Expiry','Quantity',' Type');
		$i=1;
		$expiry_details=array();
		foreach ($prod_stocks as $item) {
			$this->load->model ( 'scm/product_model', 'product' );
			$prod =$this->product->find($item->product_id);
			if($prod->product_type !='OUTPATIENTPRODUCTS' && $prod->product_type !='UNUSED'){
				if(isset($item->expiry_date)){
					 $expiry_details[]=array($i,$prod->id,$prod->name,$item->batch_number,Date_util::to_display($item->expiry_date),round($item->t_quantity,2),$prod->product_type);
					 $i++;
				}else{
					$expiry_details[]=array($i,$prod->id,$prod->name,$item->batch_number,'-',round($item->t_quantity,2),$prod->product_type);
					 $i++;
				}
			}
			
		}
		$location_name=array('Location :'.$location);
		$parameter1=array();
		$report_header=array('Details of Drugs which are expiring within next 2 months.');
		$parameter=array();
		$doc->WriteTable($parameter1, $location_name, "Table");
		$doc->WriteTable($parameter, $report_header, "Table");
		$doc->WriteTable($expiry_details, $expiry_details_header, "Table1" ,1,array('border'=>1,'width'=>array(3,11,16,10,10,8,20)),800);
		$doc->Output($location_id."_expiry_details.pdf", 'D');
	}
	
	function fetch_stock() {
 		$location_id = $this->input->post('location_id');
 		$provider_location_type = $this->input->post('provider_location_type');
 		$product_type = $this->input->post('product_type');
 		$generic_name = $this->input->post('generic_name');
 		if($location_id == '') {
    		$this->session->set_userdata('msg', 'Please provide Location ');
			redirect('/scm/search/home');
		}
 		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
    	$this->load->library('date_util');
		$prod_stocks = $this->get_stock_by_product_type($location_id,$product_type);
		
		$i=0;
		$ret_val_html = "";
		$has_value = false;
		
		foreach ($prod_stocks as $item) {
			$this->load->model ( 'scm/product_model', 'product' );
			$prod =$this->product->find($item->product_id);
			
			$today = date("Y-m-d");
			$newdate = strtotime ( '+2 months' , strtotime($today)) ;
			if(isset($item->expiry_date) &&$provider_location_type==='DISTRIBUTION' ){
				 if(strtotime($item->expiry_date) < $newdate){
					$ret_val_html.= '<tr style="color:red" >'."\n";
				}else{
					$ret_val_html.= '<tr  >'."\n";
				}
			}else{
				$ret_val_html.= '<tr  >'."\n";
			}
			
			if(!empty($generic_name) || $generic_name !== ""){
				if(strtolower($generic_name) === strtolower($prod->generic_name.' '.$prod->form)){
					$ret_val_html.= '<td>'.($i+1).'</td>'."\n";
					$ret_val_html.= '<td>'.$prod->id.'</td>'."\n";
					$ret_val_html.= '<td>'.$prod->name.'</td>'."\n";
					if($provider_location_type==='DISTRIBUTION'){
						$ret_val_html.= '<td>'.$item->batch_number.'</td>'."\n";
						if(isset($item->expiry_date)){
							$ret_val_html.= '<td>'.Date_util::to_display($item->expiry_date).'</td>'."\n";
						}else{
							$ret_val_html.= '<td>-</td>'."\n";
						}
					}
					
					$ret_val_html.= '<td>'.round($item->t_quantity,2).'</td>'."\n";
					$ret_val_html.= '<td>'.ucfirst(strtolower($prod->product_type)).'</td>'."\n";
					if($prod->product_type==='OUTPATIENTPRODUCTS'){
						$ret_val_html.= '<td>'.$prod->product_order_type.'</td>'."\n";
					}else{
						$ret_val_html.= '<td>-</td>'."\n";
					}
					$ret_val_html.= '</tr>'."\n";
					$i++;
					$has_value = true;
				}
			}else{
				$ret_val_html.= '<td>'.($i+1).'</td>'."\n";
				$ret_val_html.= '<td>'.$prod->id.'</td>'."\n";
				$ret_val_html.= '<td>'.$prod->name.'</td>'."\n";
				if($provider_location_type==='DISTRIBUTION'){
					$ret_val_html.= '<td>'.$item->batch_number.'</td>'."\n";
					if(isset($item->expiry_date)){
						$ret_val_html.= '<td>'.Date_util::to_display($item->expiry_date).'</td>'."\n";
					}else{
						$ret_val_html.= '<td>-</td>'."\n";
					}
				}
				$ret_val_html.= '<td>'.round($item->t_quantity,2).'</td>'."\n";
				$ret_val_html.= '<td>'.ucfirst(strtolower($prod->product_type)).'</td>'."\n";
				if($prod->product_type==='OUTPATIENTPRODUCTS'){
					$ret_val_html.= '<td>'.$prod->product_order_type.'</td>'."\n";
				}else{
					$ret_val_html.= '<td>-</td>'."\n";
				}
				
				$ret_val_html.= '</tr>'."\n";
				$i++;
				$has_value = true;
				
				
			}
		}
		$ret_val_html.= '<tr><td colspan="11"><input type="hidden" name="location_type" id="location_type" value="'.$provider_location_type.'" /></td></tr>';
		if(!$has_value){
			$ret_val_html = "";
			$ret_val_html.= '<tr>'."\n";
			$ret_val_html.= '<td colspan= "11" align="center">No data</td>'."\n";
			$ret_val_html.='</tr>';
		}
		//$this->generate_stock_report($location_id,$product_type,$generic_name);
		echo $ret_val_html;
	}
		
	function get_stock_by_product_type($location_id,$product_type){
		$this->load->model ( 'scm/product_batchwise_stock_model', 'stock' );
		$stocks = $this->stock->select_sum('quantity','t_quantity')->where('quantity >','0')->group_by('product_id')->group_by('batch_number')->order_by('product_id')->find_all_by('location_id',$location_id);
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

	function  add_batch(){

		$this->load->library ( 'date_util' );
		$this->form_data ['products'] = $this->get_products ();

		if (! isset ( $_POST ['submit_batch'] ) ) {
			$this->load->view ( 'scm/product_batch_add', $this->form_data );
		} else {
			$this->load->model ( 'scm/product_batche_model','pb' );

//			$_POST ['start_date'] = Date_util::change_date_format ( $_POST ['start_date'] );
			$pb_obj = $this->pb->new_record ( $_POST );
			$pb_obj->receipt_date = Date_util::change_date_format($_POST['receipt_date']);
			$pb_obj->expiry_date = Date_util::change_date_format($_POST['expiry_date']);
			if($pb_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Product Batch: '.$pb_obj->id.' Product Id: '.$pd_obj->product_id.' saved successfully');
				redirect('/scm/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'Batch for Product Id: '.$pd_obj->product_id.' could not be saved');
//    				$this->session->set_userdata('msg', 'Doctor: '.$p_obj->full_name.' saved unsuccessful');
				$this->load->view ( 'scm/product_batch_add');
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

	function get_prices() {
	  $this->load->model('scm/product_model', 'product');
	  $prices = array();
	  foreach ($_POST as $id) {
	    log_message("debug", "Got product ID [".$id."]\n");
	    if (!($p = $this->product->find($id))) {
	      log_message("debug", "Product not found");
	    }
	    $prices[$id] = $p->retail_price;
	  }
	  echo json_encode($prices);
	  return;
	}
}

?>
