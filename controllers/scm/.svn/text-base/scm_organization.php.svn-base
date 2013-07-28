<?php
class scm_organization extends CI_Controller {
	public $form_data = array();
	function add(){

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );
		

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'scm/org_add' );
		} else {
			$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
			$org_obj = $this->scm_org->new_record ( $_POST );
//			$product_obj->save ();
			if($org_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Organization: '.$org_obj->name.' saved successfully with id'.$org_obj->id);
				redirect('/scm/search/home');
			}
			else
			{
    				$this->session->set_userdata('msg', 'Organization: '.$org_obj->name.' saved unsuccessful');
				$this->load->view ( 'scm/org_add');
			}
		}

	}

	function edit_()
	{
		$organization_id=$_POST['organization_value'];
		$url = "/scm/scm_organization/edit/".$organization_id;
		redirect($url);
	}
		
	function edit($org_id = ''){
		if($org_id == '') {
			echo 'No Organization name chosen';
			return;
		}

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->load->model ( 'scm/scm_organization_model', 'scm_org' );
		$org_obj = $this->scm_org->find($org_id);
		$this->form_data['org_obj'] = & $org_obj;

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'scm/org_add', $this->form_data);
		} else {
			$org_obj->load_postdata(array('type','name','address','phone_no','license_no','pl_id','origin'));
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
	}
	
	function create_expiry_report(){
		$this->load->dbutil();
    	$this->load->library('date_util');
    	$this->load->library('utils');
    	$this->load->helper('url');  
    	$this->load->helper('date');  
    	$this->load->helper('file');
		
		if (!$_POST) {
			$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			$locations = $this->get_locations ();
			$locations[0] = 'All';
			$this->data['locations'] = $locations;
			$this->data['location_id'] = 0;
			$this->load->view ( 'scm/create_expiry_report',$this->data);
		}else{
			$this->load->model ( 'scm/drug_brand_model', 'brandname' );
			$this->load->model ( 'scm/product_model', 'productname' );
			$this->load->model ( 'scm/scm_organization_model', 'locationname' );
			$from_date = Date_util::change_date_format($_POST['from_date']);
			$to_date = Date_util::change_date_format($_POST['to_date']);
			$location_id = $_POST['location_id'];
			if($location_id == 0)
				$location_id = '%';
			$base_path = $this->config->item('base_path').'uploads/mne/';
			$report_filename = 'expiry-report-'.$_POST['location_id'].'-'.$from_date.'-'.$to_date.'.csv';
			$report_query = 'select * from expiry_log_details where  (from_date between "'.$from_date.'" and "'.$to_date.'") AND  (location_id LIKE "'.$location_id.'") ORDER BY from_date ,location_id ';
			$query = $this->db->query($report_query);
			if($query->num_rows() !=0)
			{
				$csv_expiry_result = 'Slno, Date, Location,Username, Product name,Product Type, Brand name , Quantity, Rate,Amount'."\n";
				$expiry_string ='( ';
				$i=1;
				$total = 0;
				foreach ($query->result() as $variance_rec){						
					$brand_rec = $this->brandname->find_by('id',$variance_rec->product_id);
					$product_rec = $this->productname->find_by('id',$variance_rec->product_id);
					$location_rec = $this->locationname->find_by('id',$variance_rec->location_id);
					$csv_expiry_result = $csv_expiry_result.$i.','.$variance_rec->from_date.','.$location_rec->name.','.$variance_rec->username.','.$product_rec->generic_name.','.$product_rec->product_type.','.$brand_rec->name.','.$variance_rec->quantity.','.$variance_rec->budgeted_rate.','.$variance_rec->value.','."\n";
					$total = $total + $variance_rec->value;
					$i++;
				}
				$csv_expiry_result = $csv_expiry_result.','.','.','.','.','.','.','.','.','.'Total='.$total;
				$expiry_string = $expiry_string.')';
				
				if(!write_file($base_path.$report_filename,$csv_expiry_result)){
					echo "File could not be written";
				}
				$this->data['report_filename1'] = $report_filename;
			}else{
				$this->data['no_data'] = true;
			}
			
			$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			$locations = $this->get_locations ();
			$locations[0] = 'All';
			$this->data['locations'] = $locations;
			$this->data['location_id'] = 0;
			$this->load->view('scm/create_expiry_report',$this->data);
				
		}
			
	}
	
	function create_maintenance_log_report(){
		$this->load->dbutil();
    	$this->load->library('date_util');
    	$this->load->library('utils');
    	$this->load->helper('url');  
    	$this->load->helper('date');  
    	$this->load->helper('file');
		
		if (!$_POST) {
			$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			$locations = $this->get_location();
			$locations[0] = 'All';
			$this->data['locations'] = $locations;
			$this->data['location_id'] = 0;
			$this->load->view ( 'scm/create_maintenance_log_report',$this->data);
		}else{
			$provider_locs = $this->get_data('provider_locations','name');
			$provider = $this->get_data('providers','full_name');
			$maintenance_names = $this->get_data('stock_maintenances','name');
			
			
			$from_date = Date_util::change_date_format($_POST['from_date']);
			$to_date = Date_util::change_date_format($_POST['to_date']);
			$location_id = $_POST['location_id'];
			if($location_id == 0){
				$location_id = '%';
			}
			$base_path = $this->config->item('base_path').'uploads/mne/';
			$report_filename = 'maintenance-log-report-'.$_POST['location_id'].'-'.$from_date.'-'.$to_date.'.csv';
			$report_query = 'select *  from stock_maintenance_histories where  (date between "'.$from_date.'" and "'.$to_date.'") AND  (provider_location_id LIKE "'.$location_id.'") ORDER BY date ,provider_location_id ';
			$query = $this->db->query($report_query);
			if($query->num_rows() !=0)
			{
				$csv_expiry_result = 'Slno,Maintenance Name, Date,Username, Location,Comment'."\n";
				$expiry_string ='( ';
				$i=1;
				$total = 0;
				foreach ($query->result() as $variance_rec){						
					$maintenance_name = $maintenance_names[$variance_rec->stock_maintenance_id];
					$provider_name = $provider[$variance_rec->provider_id];
					$location_name = $provider_locs[$variance_rec->provider_location_id];
					$csv_expiry_result = $csv_expiry_result.$i.','.$maintenance_name.','.$variance_rec->date.','.$provider_name.','.$location_name.','.$variance_rec->comment.','."\n";
					$i++;
				}
				$expiry_string = $expiry_string.')';
				
				if(!write_file($base_path.$report_filename,$csv_expiry_result)){
					echo "File could not be written";
				}
				$this->data['report_filename1'] = $report_filename;
			}else{
				$this->data['no_data'] = true;
			}
			
			$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			$locations = $this->get_location();
			$locations[0] = 'All';
			$this->data['locations'] = $locations;
			$this->data['location_id'] = 0;
			$this->load->view('scm/create_maintenance_log_report',$this->data);
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
	
	function create_inventory_cost_report(){
		$this->load->dbutil();	
    	$this->load->library('date_util');
    	$this->load->library('utils');
    	$this->load->helper('url');  
    	$this->load->helper('date');  
    	$this->load->helper('file');
		
		if (!$_POST) {
			$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			$locations = $this->get_locations ();
			$locations[0] = 'All';
			$this->data['locations'] = $locations;
			$this->data['location_id'] = 0;
			$this->load->view ( 'scm/create_inventory_cost_report',$this->data);
		}else{
			$product_names=$this->get_data('products','generic_name');
			$product_types=$this->get_data('products','product_type');
			$this->load->model ( 'scm/order_model', 'order' );
			$this->load->model ( 'scm/transaction_model', 'transaction' );
			$this->load->model ( 'scm/scm_organization_model', 'locationname' );
			$this->load->model ( 'scm/transaction_item_model', 'tx_item' );
			$from_date = Date_util::change_date_format($_POST['from_date']);
			$to_date = Date_util::change_date_format($_POST['to_date']);
			$location_id = $_POST['location_id'];
			if($location_id == 0)
				$location_id = '%';
			$base_path = $this->config->item('base_path').'uploads/mne/';
			$report_filename = 'inventory-cost-report-'.$_POST['location_id'].'-'.$from_date.'-'.$to_date.'.csv';
			$report_query = 'SELECT orders.order_date as order_date,scm_organizations.name as location, order_invoice_receive.receive_txn_id as transcation_id,transactions.type as type,transactions.bill_amount as bill_amount,transactions.vat as vat ,transactions.shipping_cost as shipping_cost from orders,order_invoice_receive,transactions,scm_organizations where (transactions.from_id like "'.$location_id.'" and orders.id=order_invoice_receive.order_id and order_date between "'.$from_date.'" and "'.$to_date.'" and transactions.id = order_invoice_receive.receive_txn_id and scm_organizations.id = transactions.from_id)  order by order_date , scm_organizations.name';
			
			$query = $this->db->query($report_query);
			if($query->num_rows() !=0)
			{
				$total_inventory_cost_result = 'Slno, Date,Location, Transaction_id,Type,Product Name,Product Type, Cost,Shipping Cost ,VAT , Total'."\n";
				$expiry_string ='( ';
				$i=1;
				$total = 0;
				foreach ($query->result() as $variance_rec){						
					$row_total=0;
					$row_total=$variance_rec->bill_amount+$variance_rec->shipping_cost+$variance_rec->vat;
					$total_inventory_cost_result =  $total_inventory_cost_result.$i.','.$variance_rec->order_date.','.$variance_rec->location.','.$variance_rec->transcation_id.','.$variance_rec->type;
					$product_query=$this->tx_item->find_all_by('transaction_id',$variance_rec->transcation_id);
					$j=1;
					foreach($product_query as $show_product){
						
						$product_id=$show_product->product_id;
						$product_name=$product_names[$show_product->product_id];
						$product_type=$product_types[$show_product->product_id];
						if($j==1){
							$total_inventory_cost_result =  $total_inventory_cost_result.','.$product_name.','.$product_type.','.$show_product->actual_value.','.$variance_rec->shipping_cost.','.$variance_rec->vat.','.$row_total.','."\n";
						}else{
							$total_inventory_cost_result =  $total_inventory_cost_result.','.','.','.','.','.$product_name.','.$product_type.','.$show_product->actual_value.','.$variance_rec->shipping_cost.','.$variance_rec->vat.','."\n";
						}
						$j=$j+1;
					}
					
					$total = $total + $row_total;
					$i++;
				}
				
				$total_inventory_cost_result = $total_inventory_cost_result.','.','.','.','.','.','.','.','.','.','.'Total='.$total;
				$expiry_string = $expiry_string.')';
				if(!write_file($base_path.$report_filename,$total_inventory_cost_result)){
					echo "File could not be written";
				}
				$this->data['report_filename1'] = $report_filename;
			}else{
				$this->data['no_data'] = true;
			}
			
			$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			$locations = $this->get_locations ();
			$locations[0] = 'All';
			$this->data['locations'] = $locations;
			$this->data['location_id'] = 0;
			$this->load->view('scm/create_inventory_cost_report',$this->data);
				
		}
			
	}
	
	function find_all() {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( 'scm_organizations' );
		$o_rows = $o_obj->find_all ();
		return $o_rows;
	}
	
	function create_inventory_variance_report (){
		$this->load->dbutil();
		$this->load->library('date_util');
		$this->load->library('utils');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('file');
		
		// not a post request
		if(!$_POST){
			$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			$locations = $this->get_locations ();
			$locations[0] = 'All';
			$this->data['locations'] = $locations;
			$this->data['location_id'] = 0;
			$this->load->view('scm/create_variance_report',$this->data);
		}
		// is a post request
		else{
			$this->load->model ( 'scm/drug_brand_model', 'brandname' );
			$this->load->model ( 'scm/product_model', 'productname' );
			$this->load->model ( 'scm/scm_organization_model', 'locationname' );
			$from_date = Date_util::change_date_format($_POST['from_date']);
			$to_date = Date_util::change_date_format($_POST['to_date']);
			$location_id = $_POST['location_id'];
			if($location_id == 0)
				$location_id = '%';
			$base_path = $this->config->item('base_path').'uploads/mne/';
			$report_filename = 'variance-report-'.$_POST['location_id'].'-'.$from_date.'-'.$to_date.'.csv';
			$report_query = 'select * FROM physical_reconcile_verifications where date between "'.$from_date.'" and "'.$to_date.'" and location_id LIKE "'.$location_id.'" order by date , location_id'; 
			$query = $this->db->query($report_query);
			if($query->num_rows() !=0) {				
				$variance_report_result = 'Slno, Date, Location, Username,Transaction id, Original Quantity, Actual Quantity, Difference, Product name,Brand name, Amount'."\n";
				$expiry_string ='( ';		 
				$i=1;
				$total = 0;
				foreach ($query->result() as $variance_rec){						
					$brand_rec = $this->brandname->find_by('id',$variance_rec->product_id);
					$product_rec = $this->productname->find_by('id',$variance_rec->product_id);
					$location_rec = $this->locationname->find_by('id',$variance_rec->location_id);
					
					$variance_report_result = $variance_report_result.$i.','.$variance_rec->date.','.$location_rec->name.','.$variance_rec->username.','.$variance_rec->tx_id.','.$variance_rec->quantity.','.$variance_rec->reconcile_quantity.','.$variance_rec->delta.','.$product_rec->name.','.$brand_rec->name.','.$variance_rec->amount.','."\n";
					
					$total = $total + $variance_rec->amount;
					$i++;
				}
				$variance_report_result = $variance_report_result.','.','.','.','.','.','.','.','.','.','.'Total='.$total;
				$expiry_string = $expiry_string.')';
	
				if(!write_file($base_path.$report_filename,$variance_report_result)){
					echo "File could not be written";
				}
				$this->data['report_filename'] = $report_filename;
			}else{
				$this->data['no_data'] = true;
			}
			
			$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			$locations = $this->get_locations ();
			$locations[0] = 'All';
			$this->data['locations'] = $locations;
			$this->data['location_id'] = 0;
			$this->load->view('scm/create_variance_report',$this->data);
				
		}
	}
	
	function get_locations() {
		$locations = array ();
		$l_obj = IgnitedRecord::factory ( 'scm_organizations' );
		$l_rows = $l_obj->find_all ();
		foreach ( $l_rows as $l_row ) {
			$locations [$l_row->id] = $l_row->name;
		}
		return $locations;
	}
	function get_location() {
		$locations = array ();
		$l_obj = IgnitedRecord::factory ( 'provider_locations' );
		$l_rows = $l_obj->find_all ();
		foreach ( $l_rows as $l_row ) {
			$locations [$l_row->id] = $l_row->name;
		}
		return $locations;
	}

}

?>
