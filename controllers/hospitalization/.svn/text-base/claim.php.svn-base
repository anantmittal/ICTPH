<?php

class Claim extends Hosp_base_controller {
	private  $data = array();

	function __construct()
	{ 
		parent::__construct();

		$this->load->model('hospitalization/claim_model','claim');
		$this->load->model('hospitalization/hospitalization_cost_item_model','hcim');
		$this->load->model('hospitalization/claim_cost_item_model','ccim');
		$this->load->model('hospitalization/claim_status_model','claim_status');

		$this->load->model('admin/policy_model','policy');						

		$this->load->model('hospitalization/hospitalization_model', 'hospitalization');
    	$this->load->model('hospitalization/hospital_record_model', 'hospital_record');
    	$this->load->model('hospitalization/claim_cost_item_model', 'claim_cost_item');
    	$this->load->model('hospitalization/hospitalization_cost_item_model', 'hosp_cost_item');
    	$this->load->model('hospitalization/pre_authorization_model', 'preauth_model');
    	$this->load->model('hospitalization/claim_settlement_model', 'claim_settlement');
	}

	function add($hospitalization_id = 0 ) {
	    $this->validate_id($hospitalization_id,'hospitalization');
		$total_claim_amount = 0;
		$data['short_context'] = $this->get_short_context($hospitalization_id, 'hospitalization');          
		unset($data['short_context']['hospital_id']);
            
		$policy_id = $data['short_context']['policy_id'];

		$this->load->library('form_validation');
		$this->form_validation->set_rules('form_rows_data', 'Claim items', 'required');		
//		$this->form_validation->set_message('form_rows_data', 'Claim Items should not be blank.');		
		$this->form_validation->set_rules('filling_date', 'Filling date', 'required');
		$this->form_validation->set_rules('claim_form_number', 'Claim form Number', 'required');
		$this->form_validation->set_error_delimiters('<label class="error">', '</label');
//		$this->form_validation->set_rules('', '', 'required');

		if (!isset($_POST['submit']) || $this->form_validation->run() == FALSE) 
		{			
			$values['claim_form_number'] = '';
			$values['filling_date']  = 'DD/MM/YYYY';
			$values['claim_by'] = 'Hospital';
			$values['claim_amount'] = 0;
    	                $values['claim_cost_items_rows'] = array();    	
			$data['values'] = $values;
			$this->load->view('hospitalization/show_claim_entry_form', $data);
		}
		else
		{
			$form_data_rows = explode('~', $_POST['form_rows_data']);
			array_pop($form_data_rows);			
            		$new_data_arr = array();

			foreach ($form_data_rows as $data_row) 
			{
				$data_row_arr = explode('|', $data_row);
				array_shift($data_row_arr);
			    array_pop($data_row_arr);
			    unset($data_row_arr[5]);
			    $new_data_arr['item_type'] = &$data_row_arr[0];
			    $new_data_arr['item_subtype'] = &$data_row_arr[1];
			    $new_data_arr['item_name'] = &$data_row_arr[2];
			    $new_data_arr['number_of_times'] = &$data_row_arr[3];
			    $new_data_arr['rate'] = &$data_row_arr[4];
			    $new_data_arr['claimed_amount'] = &$data_row_arr[6];
			    $total_claim_amount += $new_data_arr['claimed_amount'];
			    $new_data_arr['comment'] = &$data_row_arr[7];
			    $data_to_save[] = $new_data_arr;
			}

			
		
			
			if($this->save_item($data_to_save, $hospitalization_id, $policy_id, $total_claim_amount, 0))
			   redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	
			 else 
			 {
			 	show_error("record not found");
    			return;
			 }
		}
	}

	function edit($claim_id = 0 ) {
	    $this->validate_id($claim_id,'claim');
		$claim_rec = $this->claim->find($claim_id);
		$hospitalization_id = $claim_rec->hospitalization_id;
       	    $total_claim_amount = 0;
		$data['short_context'] = $this->get_short_context($claim_id, 'claim');          
            
		$policy_id = $data['short_context']['policy_id'];

		$this->load->library('form_validation');
		$this->form_validation->set_rules('form_rows_data', 'Claim items', 'required');		
//		$this->form_validation->set_message('form_rows_data', 'Claim Items should not be blank.');		
		$this->form_validation->set_rules('filling_date', 'Filling date', 'required');
		$this->form_validation->set_rules('claim_form_number', 'Claim form Number', 'required');
		$this->form_validation->set_error_delimiters('<label class="error">', '</label');
//		$this->form_validation->set_rules('', '', 'required');

		if (!isset($_POST['submit']) || $this->form_validation->run() == FALSE) 
		{			
			$values['claim_form_number'] = $claim_rec->claim_form_number;
			$values['filling_date']  = Date_util::date_display_format($claim_rec->filling_date);
			$values['claim_by'] = $claim_rec->claim_by;
			$values['claim_amount'] = $claim_rec->total_claim_amount;
    	                $values['claim_cost_items_rows'] = $this->hosp_cost_item->get_all_claim_items($claim_id);    	
			$data['values'] = $values;
			$this->load->view('hospitalization/show_claim_entry_form', $data);
		}
		else
		{
			$form_data_rows = explode('~', $_POST['form_rows_data']);
			array_pop($form_data_rows);			
            		$new_data_arr = array();

			foreach ($form_data_rows as $data_row) 
			{
				$data_row_arr = explode('|', $data_row);
				array_shift($data_row_arr);
			    array_pop($data_row_arr);
			    unset($data_row_arr[5]);
			    $new_data_arr['item_type'] = &$data_row_arr[0];
			    $new_data_arr['item_subtype'] = &$data_row_arr[1];
			    $new_data_arr['item_name'] = &$data_row_arr[2];
			    $new_data_arr['number_of_times'] = &$data_row_arr[3];
			    $new_data_arr['rate'] = &$data_row_arr[4];
			    $new_data_arr['claimed_amount'] = &$data_row_arr[6];
			    $total_claim_amount += $new_data_arr['claimed_amount'];
			    $new_data_arr['comment'] = &$data_row_arr[7];
			    $data_to_save[] = $new_data_arr;
			}

			
		
			
			if($this->save_item($data_to_save, $hospitalization_id, $policy_id, $total_claim_amount,$claim_id))
			   redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	
			 else 
			 {
			 	show_error("record not found");
    			return;
			 }
		}
	}

	function save_item($data_to_save, $hospitalization_id, $policy_id, $total_claim_amount, $claim_id = 0) {
		$this->load->library('date_util');
		$uploaded_file_name = '';
		
		$policy_rec = $this->policy->find($policy_id);
    		
//		$this->db->trans_start();
		$tx_status = true;
		$this->db->trans_begin();
		$delta_increase = 0;
		if($claim_id !=0)
		{
			$claim_rec = $this->claim->find($claim_id);

			$delta_increase = $total_claim_amount - $claim_rec->total_claim_amount;
		//	$policy_rec->blocked_amount = $policy_rec->blocked_amount + $delta_increase;
		//	$policy_rec->available_amount -= $delta_increase;
		//	$policy_rec->save();

		   	$claim_cost_item_recs = $this->claim_cost_item->find_all_by('claim_id',$claim_id);
			foreach ($claim_cost_item_recs as $claim_cost_item_rec)
			{
				$hosp_cost_item_rec = $this->hosp_cost_item->find($claim_cost_item_rec->hospitalization_cost_item_id);
				$hosp_cost_item_rec->delete();
				$claim_cost_item_rec->delete();
			}
			$claim_rec->delete();
		}	
		else
		{
			if($this->claim->find_by('hospitalization_id',$hospitalization_id))
			{	$blocked_amount = 0; }
			else {
			  $hosp_rec = $this->hospitalization->find($hospitalization_id);
			  if($hosp_rec)
			  {
				$preauth_rec = $this->preauth_model->find($hosp_rec->last_preauth_id);
				$blocked_amount = $preauth_rec->expected_cost;
			  }  
			  else
			  {	$blocked_amount = 0; }
                        }
			$delta_increase = $total_claim_amount - $blocked_amount;
		}
		$policy_rec->blocked_amount = $policy_rec->blocked_amount + $delta_increase;
		$policy_rec->available_amount = $policy_rec->available_amount - $delta_increase;
		$tx_status = $policy_rec->save() AND $tx_status;
			
		
		if($_FILES['claim_form']['name'] != '') {			
//			$config['upload_path'] = $this->config->item('base_path').'assets/uploaded_files/claim_forms';
			$config['upload_path'] = $this->config->item('base_path').'/uploads/claim_forms';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
			$config['max_size']	= '10000';
			$config['max_width']  = '3000';
			$config['max_height']  = '3000';
//					$config['encrypt_name'] = true;
			$this->load->library('upload', $config);

		$old_file_name = $_FILES['claim_form']['name'];

                $new_file_name = $_POST['claim_form_number'].'-'.$old_file_name;
                 
                 $file_path = $this->config->item('base_path').'uploads/claim_forms/'.$new_file_name;
//			if (!$this->upload->do_upload('claim_form')) 
			if ( !move_uploaded_file($_FILES['claim_form']['tmp_name'],$file_path))
			{
				$error = $this->upload->display_errors();
				show_error($error);
				$tx_status = false;
//				break;
			}
			else {
//				$upload_data = & $this->upload->data();
//				$uploaded_file_name = $upload_data['file_name'];
				$uploaded_file_name = $new_file_name;
			}			
		}

		$filling_date =  $this->input->post('filling_date');
//		$filling_date = $this->change_date_format($filling_date);
		$filling_date = Date_util::change_date_format($filling_date);		

        	$claim_form_number = $this->input->post('claim_form_number');        
        	if($this->input->post('claim_by')==0)
		 {$claim_by='Hospital';}
		else 
		 {if($this->input->post('claim_by')==1)
		 	{$claim_by='Individual';}
		  else
		 	{$claim_by='Pharmacy';}
		 }
		        
        	$claim_rec = &$this->claim->new_record(array('hospitalization_id'=>$hospitalization_id, 'policy_id'=>$policy_id, 'claim_form_number'=>$claim_form_number, 'claim_by'=>$claim_by, 'filling_date'=>$filling_date, 'claim_form_file'=>$uploaded_file_name, 'total_claim_amount'=>$total_claim_amount));
        
        	$result = $claim_rec->save();         // saving data in claims  table and new  claim_id generated
        	$claim_id = &$claim_rec->uid(); //assignment to make sense this is returning claim_id				

		$this->load->model('hospitalization/claim_status_model', 'claim_status');
		
		$claim_status_data = array('claim_id'=>$claim_id, 'claim_processing_status'=>'To be reviewed');
		$claim_status_rec = $this->claim_status->new_record($claim_status_data);
		$result = $claim_status_rec->save() AND $result;		
		
		$claim_rec->last_claim_status_id  =  $claim_status_rec->uid();
		$result = $claim_rec->save() AND $result;		
		
        	if($result === false){
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Error occured while saving data to claim_table');
		$tx_status = false;
		break;
//			return false;
        	}

        $this->load->model('hospitalization/hospitalization_model');
        
        $hospi_rec = $this->hospitalization_model->find($hospitalization_id);
        $hospi_rec->last_claim_id = $claim_id;
        $result = $hospi_rec->save();
		
        if($result === false){
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Error occured while saving data to hospitalization_table');
		$tx_status = false;
		break;
//			return false;
        }


        /**
         * @since : claim_id is generated by saving new claim in table and in claim_settlements table claim_id is also a 
         * primary key so below functionality is adding new record in claim_settlements table.
        */ 
        $this->claim_settlement_obj = IgnitedRecord::factory('claim_settlements');//create  claim_settlement_obj of $claim_settlements table on-the-fly 
        $claim_settlement_rec = $this->claim_settlement_obj->new_record(array('id'=>$claim_id));//create new record for $claim_settlement_obj
        $tx_status = $tx_status AND $claim_settlement_rec->save(); //save the object as record in table.


		foreach ($data_to_save as $row) 
		{
			$row['hospitalization_id'] = &$hospitalization_id;			
			$row['amount'] = $row['rate'] * $row['number_of_times'];
			$rec = &$this->hcim->new_record($row);
			$tx_status = $tx_status AND $rec->save(); //saves data in hospital_cost_items table

			$row['hospitalization_cost_item_id'] = $rec->uid(); //returns last-incremented-id of hospital_cost_items table
			$row['claim_id'] = &$claim_id;

			$rec = &$this->ccim->new_record($row);//saves data in claim_cost_items table
			$tx_status = $tx_status AND $rec->save();			
		}
		$data_arr = array('claim_id'=>$claim_id, 'claim_processing_status'=>'To be reviewed');
		
		$rec = & $this->claim_status->new_record($data_arr);	
		$result = $rec->save();		

		if($result === false){
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Error occured while saving data to Claim_status table');
		$tx_status = false;
		break;
//			return false;
        }
    if($tx_status == true)
    {
       $this->db->trans_commit();
    }
    else {
       $this->db->trans_rollback();
       return false;
    }
//        $this->db->trans_complete();
        
        
        $this->session->set_flashdata('msg_type', 'success');
		$this->session->set_flashdata('msg', 'New Claim Entry has been saved successfully');		
//$this->session->set_flashdata('msg', 'New Claim Entry has been saved successfully. ba '.$blocked_amount.' da '.$delta_increase);		
	    return true; 
	}


	//below two function was previously in claim_review controller 
	/**	 
	 *
	 * @param unknown_type $hospitalization_id
	 * @param unknown_type $claim_id
	 */

	function show($claim_id = 0, $panel = '') {
		
		if($panel == 'hosp_details')
		  $this->data['panel'] = $panel;
		else $this->data['panel'] = 'status_update';

		$this->validate_id($claim_id, 'claim');

    	$this->load->model('hospitalization/hospitalization_cost_item_model', 'hospitalization_cost_item');   	

    	$this->data['short_context'] = $this->get_short_context($claim_id, 'claim');    			
    	$hospitalization_id = $this->data['short_context']['hospitalization_id'];

    	$hospitalization_rec = $this->hospitalization->find($hospitalization_id); 	
    	$hospital_recs = $this->hospital_record->find_all_by('hospitalization_id',$hospitalization_id); 	    	
    	$claim_cost_items = $this->claim_cost_item->find_all_by('claim_id', $claim_id);    	
    	$preauth_recs = $this->preauth_model->find_all_by('hospitalization_id', $hospitalization_id);

    	$this->data['hospitalization_obj'] = & $hospitalization_rec;    	    	
    	$this->data['hospital_recs_obj'] = & $hospital_recs;
    	$this->data['claim_cost_items_obj'] = $this->hospitalization_cost_item->get_all_claim_items($claim_id);    	
    	$this->data['preauth_rec_obj'] = & $preauth_recs;

	$claim_rec = $this->claim->find($claim_id);
	$old_claim_status_rec = $this->claim_status->find($claim_rec->last_claim_status_id);
	$this->data['old_status'] = $old_claim_status_rec->claim_processing_status;
	$this->data['old_comment'] = $old_claim_status_rec->comment;
	$this->data['old_reviewer'] = $old_claim_status_rec->claim_reviewed_by;

	  	$this->load->view('hospitalization/show_claim_for_review_form',$this->data);		
	 }

	
	

	function save_status() {
		

		if(isset($_POST['claim_processing_status'])) {
			$this->load->model('hospitalization/claim_settlement_model', 'claim_settlement');
			$this->load->model('hospitalization/claim_model', 'claim');						
			$this->claims_status = IgnitedRecord::factory('claim_status');			
			
			
			$data['claim_id'] = $this->input->post('claim_id');
			$this->validate_id($data['claim_id'], 'claim');
			
			$data['claim_processing_status'] = $this->input->post('claim_processing_status');						
			$data['comment'] = $this->input->post('comment');
			$data['claim_reviewed_by'] = $this->input->post('claim_reviewed_by');
//			$data['backend_claim_status'] = $this->input->post('backend_claim_status');

			
/*			if($data['claim_processing_status'] == 'Settled') {
				$data['claim_status'] =& $this->input->post('claim_status');				
				$settlement['claim_status'] =& $this->input->post('claim_status');
				$settlement['payment_to_hospital'] =& $this->input->post('to_hospital');
				$settlement['payment_to_policy_holder'] =& $this->input->post('to_patient');
			}
			if($data['backend_claim_status'] == 'Settled'){
				$settlement['backend_claim_status'] =& $this->input->post('backend_claim_status');
				$settlement['payment_from_insurer'] =& $this->input->post('to_insurer');
			}
*/						
			
//        $this->db->trans_start();
        $this->db->trans_begin();
			$rec = $this->claim_status->new_record($data);
			$result = $rec->save();				
			
			if($result === false) {
				$this->session->set_flashdata('msg_type', 'error');
			 	$this->session->set_flashdata('msg', 'Error occured while saving claim status.');
        $this->db->trans_rollback();
			 	redirect('/hospitalization/claim/show/'.$data['claim_id']);
			}
			
			$claim_rec = $this->claim->find($data['claim_id']);			
			$claim_rec->last_claim_status_id = $rec->uid();			
			$result = $claim_rec->save();
			
			if($result === false){
				$this->session->set_flashdata('msg_type', 'error');
			 	$this->session->set_flashdata('msg', 'Error occured while updating last_claim_status_id in claim table.');
        $this->db->trans_rollback();
			 	redirect('/hospitalization/claim/show/'.$data['claim_id']);
			}

/*			if(isset($settlement)){
				$claim_settlement = $this->claim_settlement->find($data['claim_id']);			
				$claim_settlement->load_data($settlement);
				$result = $claim_settlement->save();
				
				if($result === false){
					$this->session->set_flashdata('msg_type', 'error');
					$this->session->set_flashdata('msg', 'Error occured while updating claim_settlement table.');
					redirect('/hospitalization/claim/show/'.$data['claim_id']);
				}
			}
			*/
        $this->db->trans_commit();
//        $this->db->trans_complete();
			$this->session->set_flashdata('msg_type', 'success');
			$this->session->set_flashdata('msg', 'Claim status updated successfully');
			redirect('/hospitalization/claim/show/'.$data['claim_id']);
		}		
		redirect('/hospitalization/claim/show/'.$data['claim_id']);
    }   
    
    
    function backend_claim_entry($claim_id = 0) {
		$this->validate_id($claim_id, 'claim');
		$this->data['short_context'] = $this->get_short_context($claim_id, 'claim');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('form_number', '"Backend claim form number"', 'required');				
		$this->form_validation->set_rules('amount_claimed', '"Amount claimed"', 'required|numeric');				
		$this->form_validation->set_rules('backend_claim_id', '"backend claim number"', 'required');				

		$this->form_validation->set_error_delimiters('<label class="error">', '</label');

		if (!isset($_POST['submit_btn']) || $this->form_validation->run() == FALSE)	{			
			$this->load->model('admin/policy_model','policy');						
			$claim_rec  =& $this->claim->find($claim_id);
			$policy_rec = $this->policy->find($claim_rec->policy_id);

			$this->data['backend_policy_type'] = $policy_rec->backend_policy_type;
			$this->data['backend_policy_number'] = $policy_rec->backend_policy_number;
			$this->data['backend_member_id'] = $policy_rec->backend_member_id;
			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);					
		}
		else {
//			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);
//			$backend_claim = IgnitedRecord::factory('backend_claims');
			
			$data = array();
            		$data['claim_id'] =& $claim_id;
            		$data['policy_id'] =& $this->data['short_context']['policy_id'];            
            		$data['form_number'] =& $this->input->post('form_number');
		    	$data['backend_claim_id'] =& $this->input->post('backend_claim_id');
		    	$data['amount_claimed'] =& $this->input->post('amount_claimed');
		    	$data['comment'] =& $this->input->post('comment');


    			$this->load->model('hospitalization/backend_claim_model', 'backend_claim');
			$backend_claim_rec = $this->backend_claim->find_by('form_number',$data['form_number']);
			if($backend_claim_rec == null)
			     $backend_claim_rec = $this->backend_claim->new_record();
//			$backend_claim_rec-> = $backend_claim->new_record($data);
			$backend_claim_rec->load_data($data);
			$backend_claim_rec->save();
			$last_backend_claim_id =&$backend_claim_rec->uid();
			
			
			$claim_rec = $this->claim->find($claim_id);
			$claim_rec->last_backend_claim_id = $last_backend_claim_id;
			
//			$claim_rec->backend_insurer_claim_number = $data['backend_claim_id'];
		        $result = $claim_rec->save();
			
		    if($result === true){
		    	$msg_type = 'success';
		    	$msg = 'New backend claim entry added successfully for claim-ID : '.$claim_id;
		    }
		    else {
		    	$msg_type = 'error';
		    	$msg = 'Error occured while adding backend claim entry for claim-ID : '. $claim_id;
		    }
		    $this->session->set_flashdata('msg_type', $msg_type);
		    $this->session->set_flashdata('msg', $msg);
		    $policy_id = &$this->data['short_context']['policy_id'];	    
//			echo '@todo : where this page will get redirected after save';
			redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	
		}
	}
	
    function add_settlement($claim_id = 0) {
	        $this->validate_id($claim_id,'claim');
		$claim_rec = $this->claim->find($claim_id);
		$hospitalization_id = $claim_rec->hospitalization_id;
		$this->data['short_context'] = $this->get_short_context($claim_id, 'claim');          

		$this->load->library('form_validation');

		$this->form_validation->set_rules('amount_settled', '"Amount Settled"', 'required');				
		$this->form_validation->set_rules('amount_claimed', '"Amount claimed"', 'required|numeric');				

		$this->form_validation->set_error_delimiters('<label class="error">', '</label');

//		if (!isset($_POST['submit_btn']) || $this->form_validation->run() == FALSE)			
		if (!isset($_POST['submit_btn']) )	
		{			
			$values['action'] = 'add';
			$values['form_number'] = $claim_rec->claim_form_number;
			$values['filling_date'] = Date_util::date_display_format($claim_rec->filling_date);
			$values['claim_by'] = $claim_rec->claim_by;
			$values['amount_claimed'] = $claim_rec->total_claim_amount;


		        $cs_rec = $this->claim_settlement->find($claim_id);
			if($cs_rec)
			{
			   $values['status'] = $cs_rec->claim_status;
			   $values['amount_settled'] = $cs_rec->amount_settled;
//			   $values['payment_date'] = Date_util::date_display_format($cs_rec->payment_date);
//			   $values['payment_details'] = $cs_rec->payment_details;
			   $values['settled_by'] = $cs_rec->settled_by;
			}
			else {
			   $values['status'] = 'Approved';
			   $values['amount_settled'] = '';
//			   $values['payment_date'] = 'DD/MM/YYYY';
//			   $values['payment_details'] = '';
			   $values['settled_by'] = '';
			}
			$this->data['values'] = $values;
			$this->load->view('hospitalization/show_claim_settlement', $this->data);					
		}
		else {
//			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);
//			$backend_claim = IgnitedRecord::factory('backend_claims');
			
			$data = array();
//            		$data['claim_id'] =& $claim_id;
			$data['id'] = $claim_id;
			$data['claim_status'] = & $this->input->post('status');
			$data['amount_settled'] = & $this->input->post('amount_settled');
    			$time = time();
    			$datestring= "%Y-%m-%d";
			$this->load->helper('date');
			$data['settled_date']  = mdate($datestring, $time);
//		    	$data['payment_date'] =& $this->input->post('payment_date');
//			$data['payment_date'] = Date_util::change_date_format($data['payment_date']);
//			$data['payment_details'] = & $this->input->post('payment_details');
			$data['settled_by'] = & $this->input->post('settled_by');


//        $this->db->trans_start();
        $this->db->trans_begin();
	$result = true;
			$find_rec = $this->claim_settlement->find($claim_id);
			$re_settle = false;
			$prev_used_amount = 0;
			if($find_rec)
			{  
				if($find_rec->amount_settled!=null)
				{
					$prev_used_amount = $find_rec->amount_settled;
					$re_settle = true;
				}
				$find_rec->delete();
			}
	    	   	$claim_settlement_rec = $this->claim_settlement->new_record();
			$claim_settlement_rec->load_data($data);
//			$result = $claim_settlement_rec->save();
			if(!$claim_settlement_rec->save())
			{	
				$loc = 1;
				$result = false;
			}
			
			$policy_rec = $this->policy->find($claim_rec->policy_id);
//			$policy_rec->used_amount = $policy_rec->used_amount + $claim_settlement_rec->amount_settled;
			if($re_settle)
			{
				$policy_rec->used_amount = $policy_rec->used_amount - $prev_used_amount + $data['amount_settled'];
				$policy_rec->available_amount = $policy_rec->available_amount + $prev_used_amount - $data['amount_settled'];
				$changed = !($prev_used_amount == $data['amount_settled']);
			}
			else
			{
				$policy_rec->used_amount = $policy_rec->used_amount + $data['amount_settled'];
				$policy_rec->blocked_amount = $policy_rec->blocked_amount - $claim_rec->total_claim_amount;
				$policy_rec->available_amount = $policy_rec->available_amount + $claim_rec->total_claim_amount - $data['amount_settled'];
				$changed = !(($claim_rec->total_claim_amount == 0) && ($data['amount_settled'])==0);
			}
//			$result = $policy_rec->save() AND $result;
			if($changed && !$policy_rec->save())
			{	
				$loc = 2;
				$result = false;
			}
			
		        if($result){
		    		$msg_type = 'success';
		    		$msg = 'New Claim Settlement entry added successfully for Claim ID : '.$claim_id;
        $this->db->trans_commit();
		    	}
		    	else {
		    		$msg_type = 'error';
		    		$msg = 'Error occured while adding '.$loc.' claim settlement entry for claim ID : '. $claim_id;
        $this->db->trans_rollback();
		    	}
		    $this->session->set_flashdata('msg_type', $msg_type);
		    $this->session->set_flashdata('msg', $msg);
		    $policy_id = &$this->data['short_context']['policy_id'];	    
//			echo '@todo : where this page will get redirected after save';
			redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	
		}
	   }
	
    function show_settlement($claim_id = 0) {
	        $this->validate_id($claim_id,'claim');
		$claim_rec = $this->claim->find($claim_id);
		$this->data['short_context'] = $this->get_short_context($claim_id, 'claim');          

			$values['form_number'] = $claim_rec->claim_form_number;
			$values['filling_date'] = Date_util::date_display_format($claim_rec->filling_date);
			$values['claim_by'] = $claim_rec->claim_by;
			$values['amount_claimed'] = $claim_rec->total_claim_amount;

		        $cstatus_rec = $this->claim_status->find($claim_rec->last_claim_status_id);
			   $values['comment'] = $cstatus_rec->comment;

		        $cs_rec = $this->claim_settlement->find($claim_id);
			   $values['status'] = $cs_rec->claim_status;
			   $values['amount_settled'] = $cs_rec->amount_settled;
			   $values['settled_by'] = $cs_rec->settled_by;
			   $values['settled_date'] = Date_util::date_display_format($cs_rec->settled_date);
			if($cs_rec->claim_status == 'Paid')
			{
			   $values['payment_date'] = Date_util::date_display_format($cs_rec->payment_date);
			   $values['payment_details'] = $cs_rec->payment_details;
			   $values['paid_by'] = $cs_rec->paid_by;
			   $values['paid_amount'] = $cs_rec->paid_amount;
			}
			else
			{
			   $values['payment_date'] = 'Not Paid';
			   $values['payment_details'] = 'Not Paid';
			   $values['paid_by'] = 'Not Paid';
			   $values['paid_amount'] = 'Not Paid';
			}
			$this->data['values'] = $values;
			$this->load->view('hospitalization/show_claim_settlement_detail', $this->data);					
	   }

    function add_payment($claim_id = 0) {
	        $this->validate_id($claim_id,'claim');
		$claim_rec = $this->claim->find($claim_id);
		$cs_rec = $this->claim_settlement->find($claim_id);
		if((!$cs_rec || $cs_rec->claim_status != 'Approved') && ($cs_rec->claim_status != 'Paid'))
		{
		    	$msg_type = 'error';
		    	$msg = 'Please add Settlement details before adding payment details for Claim ID : '.$claim_id;
	 		$this->session->set_flashdata('msg_type', $msg_type);
			$this->session->set_flashdata('msg', $msg);
			$policy_id = &$this->data['short_context']['policy_id'];	    
			redirect('/hospitalization/policy_details/show_policy_details/'.$claim_rec->policy_id);	
		}

		$hospitalization_id = $claim_rec->hospitalization_id;
		$this->data['short_context'] = $this->get_short_context($claim_id, 'claim');          
			
		$this->load->library('form_validation');

		$this->form_validation->set_rules('payment_date', '"Payment Date"', 'required');				

		$this->form_validation->set_error_delimiters('<label class="error">', '</label');

//		if (!isset($_POST['submit_btn']) || $this->form_validation->run() == FALSE)			
		if (!isset($_POST['submit_btn']) )	
		{			
			$values['action'] = 'add';
			$values['form_number'] = $claim_rec->claim_form_number;
			$values['filling_date'] = Date_util::date_display_format($claim_rec->filling_date);
			$values['settled_date'] = Date_util::date_display_format($cs_rec->settled_date);
			$values['claim_by'] = $claim_rec->claim_by;
			$values['amount_claimed'] = $claim_rec->total_claim_amount;
			$values['status'] = $cs_rec->claim_status;
			$values['amount_settled'] = $cs_rec->amount_settled;
			if($cs_rec->payment_date)
			{
				$values['payment_date'] = Date_util::date_display_format($cs_rec->payment_date);
			}
			else
			{
				$values['payment_date'] = 'DD/MM/YYYY';
			}
			$values['payment_details'] = $cs_rec->payment_details;
			$values['paid_by'] = $cs_rec->paid_by;
			$values['paid_amount'] = $cs_rec->paid_amount;
			$values['settled_by'] = $cs_rec->settled_by;
			$this->data['values'] = $values;
			$this->load->view('hospitalization/show_claim_payment', $this->data);					
		}
		else 
		{

	$result = true;
			$cs_rec->payment_date = Date_util::change_date_format($_POST['payment_date']);
			$cs_rec->payment_details = $_POST['payment_details'];
			$cs_rec->paid_by = $_POST['paid_by'];
			$cs_rec->paid_amount = $_POST['paid_amount'];
			$cs_rec->claim_status = 'Paid';
//			$result = $claim_settlement_rec->save();
			if(!$cs_rec->save())
				$result = false;
			
		        if($result === true){
		    		$msg_type = 'success';
		    		$msg = 'Payment Details added successfully for Claim ID : '.$claim_id;
		    	}
		    	else {
		    		$msg_type = 'error';
		    		$msg = 'Error occured while adding payment details for claim ID : '. $claim_id;
		    	}
		    $this->session->set_flashdata('msg_type', $msg_type);
		    $this->session->set_flashdata('msg', $msg);
		    $policy_id = &$this->data['short_context']['policy_id'];	    
//			echo '@todo : where this page will get redirected after save';
			redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	
		}
	   }
	
/*	
	function show_settelement($claim_id = 0)	{
		$this->load->model('hospitalization/claim_settlement_model','claim_settlement');
		$claim_settlement_obj = $this->claim_settlement->find($claim_id);
		$data['payment_to_hospital'] =  $claim_settlement_obj->payment_to_hospital;
		$data['payment_to_policy_holder'] =  $claim_settlement_obj->payment_to_policy_holder;
		$data['payment_from_insurer'] =  $claim_settlement_obj->payment_from_insurer;
		$data['status_payment_to_hospital'] =  $claim_settlement_obj->status_payment_to_hospital;
		$data['status_payment_to_policy_holder'] =  $claim_settlement_obj->status_payment_to_policy_holder;
		$data['status_payment_from_insurer'] =  $claim_settlement_obj->status_payment_from_insurer;
		$data['claim_status'] =  $claim_settlement_obj->claim_status;
		
		$this->load->view('hospitalization/show_settlement_detail',$data);
	}*/
}
