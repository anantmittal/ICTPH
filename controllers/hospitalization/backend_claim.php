<?php

class Backend_claim extends Hosp_base_controller {
	private  $data = array();

	function __construct()
	{ 
		parent::__construct();

		$this->load->model('hospitalization/claim_model','claim');
		$this->load->model('hospitalization/hospital_model','hospital');
		$this->load->model('hospitalization/backend_claim_model','backend_claim');
		$this->load->model('hospitalization/hospitalization_cost_item_model','hcim');
		$this->load->model('hospitalization/claim_cost_item_model','ccim');
		$this->load->model('hospitalization/claim_status_model','claim_status');
		$this->load->model('hospitalization/backend_claim_status_model','backend_claim_status');
		$this->load->model('hospitalization/backend_claim_settlement_model', 'backend_claim_settlement');

		$this->load->model('hospitalization/hospitalization_model', 'hospitalization');
    	$this->load->model('hospitalization/hospital_record_model', 'hospital_record');
    	$this->load->model('hospitalization/claim_cost_item_model', 'claim_cost_item');
    	$this->load->model('hospitalization/hospitalization_cost_item_model', 'hosp_cost_item');
    	$this->load->model('hospitalization/pre_authorization_model', 'preauth_model');
    	$this->load->model('hospitalization/claim_settlement_model', 'claim_settlement');
	}



	//below two function was previously in claim_review controller 
	/**	 
	 *
	 * @param unknown_type $hospitalization_id
	 * @param unknown_type $claim_id
	 */

	function status_update($backend_claim_id) {
		
		$this->validate_id($backend_claim_id, 'backend_claim');
		$backend_claim_rec = $this->backend_claim->find($backend_claim_id);
    	        $this->data['short_context'] = $this->get_short_context($backend_claim_rec->hospitalization_id, 'hospitalization');    			
		$values['backend_claim_id'] = $backend_claim_id;
		$values['backend_member_id'] = $backend_claim_rec->backend_member_id;
		$values['status'] = $backend_claim_rec->status;
      		$values['filling_date'] = Date_util::date_display_format($backend_claim_rec->filling_date);
		$values['form_number'] = $backend_claim_rec->form_number;
		$values['amount_claimed'] = $backend_claim_rec->amount_claimed;
		if($backend_claim_rec->last_backend_claim_status_id == 0)
		{ 
			$values['comment'] = $backend_claim_rec->comment;
			$values['claim_reviewed_by'] = $backend_claim_rec->claim_created_by;
		}
		else
		{
			$backend_claim_status_rec = $this->backend_claim_status->find($backend_claim_rec->last_backend_claim_status_id);
			$values['comment'] = $backend_claim_status_rec->comment;
			$values['claim_reviewed_by'] = $backend_claim_status_rec->claim_reviewed_by;
 		}
		$this->data['values'] = $values;
		$this->load->view('hospitalization/show_backend_claim_status', $this->data);					

	 }

	

	function save_status($backend_claim_id) {
		
			$this->validate_id($backend_claim_id, 'backend_claim');

			$data['backend_claim_id'] = $backend_claim_id;
			$data['comment'] = $this->input->post('comment');
			$data['claim_reviewed_by'] = $this->input->post('claim_reviewed_by');
			$data['backend_claim_status'] = $this->input->post('status');

//    		$this->db->trans_start();
		$tx_status = true;
    		$this->db->trans_begin();
			$rec = $this->backend_claim_status->new_record($data);
			$result = $rec->save();				
			
			if($result === false) {
				$this->session->set_flashdata('msg_type', 'error');
			 	$this->session->set_flashdata('msg', 'Error occured while saving backend claim status.');
		$tx_status = false;
    		$this->db->trans_rollback();
			 	redirect('/hospitalization/backend_claim/status_update/'.$backend_claim_id);
			}
			
			$backend_claim_rec = $this->backend_claim->find($backend_claim_id);			
			$backend_claim_rec->last_backend_claim_status_id = $rec->uid();			
			$backend_claim_rec->status = $data['backend_claim_status'];			
			$result = $backend_claim_rec->save();
			
			if($result === false){
				$this->session->set_flashdata('msg_type', 'error');
			 	$this->session->set_flashdata('msg', 'Error occured while updating last_backend_claim_status_id in backend_claim table.');
		$tx_status = false;
    		$this->db->trans_rollback();
			 	redirect('/hospitalization/backend_claim/status_update/'.$backend_claim_id);
			}
    if($tx_status == true)
    {
       $this->db->trans_commit();
    }
    else {
       $this->db->trans_rollback();
       return false;
    }
			
  //  		$this->db->trans_complete();
			$this->session->set_flashdata('msg_type', 'success');
			$this->session->set_flashdata('msg', 'Backend Claim status updated successfully');
		        redirect('/hospitalization/policy_details/show_policy_details/'.$backend_claim_rec->policy_id);
    }   
    
    
    function add($id = 0, $type = '') {
	if($type == 'bc')
	{
    		$this->load->model('hospitalization/backend_claim_model', 'backend_claim');
		$bc_rec = $this->backend_claim->find($id);
	    	$hospitalization_id = $bc_rec->hospitalization_id;
		$values['insurer_claim_id'] = $bc_rec->insurer_claim_id;
	}
	else
	{
	    	$hospitalization_id = $id;
		$values['insurer_claim_id'] = '';
	}
	        $this->validate_id($hospitalization_id,'hospitalization');
		$this->data['short_context'] = $this->get_short_context($hospitalization_id, 'hospitalization');          

		$this->load->library('form_validation');

		$this->form_validation->set_rules('form_number', '"Backend claim form number"', 'required');				
		$this->form_validation->set_rules('amount_claimed', '"Amount claimed"', 'required|numeric');				
		$this->form_validation->set_rules('backend_claim_id', '"backend claim number"', 'required');				
//		$this->form_validation->set_rules('claim_file_name', '"claim file name"', 'required');				

		$this->form_validation->set_error_delimiters('<label class="error">', '</label');

		if (!isset($_POST['submit_btn']) || $this->form_validation->run() == FALSE)	{			
			$this->load->model('admin/policy_model','policy');						
			$hospitalization_rec  =& $this->hospitalization->find($hospitalization_id);
			$policy_rec = $this->policy->find($hospitalization_rec->policy_id);

			$values['action'] = 'add';
			$values['backend_policy_type'] = $policy_rec->backend_policy_type;
			$values['backend_policy_number'] = $policy_rec->backend_policy_number;
			$values['backend_member_id'] = $policy_rec->backend_member_id;
			$values['status'] = 'Pending Insurer';

			$values['diagnosis'] = $hospitalization_rec->current_diagnosis;
			$values['doa'] = $hospitalization_rec->hospitalization_date;
			$values['dod'] = $hospitalization_rec->discharge_date ;
			$values['dr_name'] = $hospitalization_rec->primary_physician;
			$values['dr_reg'] = $hospitalization_rec->physician_reg_no;
			$values['dr_qual'] = $hospitalization_rec->physician_qualification;
			$values['hospital_id'] = $hospitalization_rec->hospital_id;

			$values['ward_days'] = $hospitalization_rec->discharge_date - $hospitalization_rec->hospitalization_date;
			$values['ward_rate'] = '150';
			$values['icu_days'] = '__';
			$values['icu_rate'] = '__';


			$values['filling_date'] = 'DD/MM/YYYY';
			$values['form_number'] = '';
			$values['backend_claim_id'] = '';

			$values['human_amount_claimed'] = '';
			$values['other_amount_claimed'] = '';
			$values['amount_claimed'] = '';

			$values['comment'] = '';
			$values['claim_created_by'] = '';
			$this->data['values'] = $values;
			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);					
		}
		else {
//			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);
//			$backend_claim = IgnitedRecord::factory('backend_claims');
			
			$data = array();
//            		$data['claim_id'] =& $claim_id;
            		$data['claim_id'] = 1;
            		$data['policy_id'] =& $this->data['short_context']['policy_id'];            
            		$data['hospitalization_id'] =& $this->data['short_context']['hospitalization_id'];            
            		$data['form_number'] =& $this->input->post('form_number');
		    	$data['backend_claim_id'] =& $this->input->post('backend_claim_id');
		    	$data['backend_policy_number'] =& $this->input->post('backend_policy_number');
		    	$data['backend_member_id'] =& $this->input->post('backend_member_id');
		    	$data['insurer_claim_id'] =& $this->input->post('insurer_claim_id');

		    	$data['status'] =& $this->input->post('status');
		    	$data['filling_date'] =& $this->input->post('filling_date');
      			$data['filling_date'] = Date_util::change_date_format($data['filling_date']);

		    	$data['ward_rate'] =& $this->input->post('ward_rate');
		    	$data['ward_days'] =& $this->input->post('ward_days');
		    	$data['icu_days'] =& $this->input->post('icu_days');
		    	$data['icu_rate'] =& $this->input->post('icu_rate');
		    	$data['human_amount_claimed'] =& $this->input->post('human_amount_claimed');
		    	$data['other_amount_claimed'] =& $this->input->post('other_amount_claimed');
		    	$data['amount_claimed'] =& $this->input->post('amount_claimed');
		    	$data['comment'] =& $this->input->post('comment');
		    	$data['claim_created_by'] =& $this->input->post('claim_created_by');


//	$this->db->trans_start();
    	$this->db->trans_begin();
    			$this->load->model('hospitalization/backend_claim_model', 'backend_claim');
			if($type == 'bc')
			{
				$backend_claim_rec = $this->backend_claim->find($id);
			}
			else
			{
				$backend_claim_rec = $this->backend_claim->find_by('form_number',$data['form_number']);
				if($backend_claim_rec == null)
			     		$backend_claim_rec = $this->backend_claim->new_record();
			}
//			$backend_claim_rec-> = $backend_claim->new_record($data);
			$fname = $data['form_number'].'.pdf';
			$fo = $this->config->item('base_path').'uploads/backend_claim_forms/'.$fname;
			$data['claim_file_name'] = $fo;
			$backend_claim_rec->load_data($data);
			$result = $backend_claim_rec->save();

	    	   	$backend_claim_settlement_rec = $this->backend_claim_settlement->new_record();
			$backend_claim_settlement_rec->id = $backend_claim_rec->id;
			$result2 = $backend_claim_settlement_rec->save();

//			$last_backend_claim_id =&$backend_claim_rec->uid();
			
			
//			$claim_rec = $this->claim->find($claim_id);
//			$claim_rec->last_backend_claim_id = $last_backend_claim_id;
			
//			$claim_rec->backend_insurer_claim_number = $data['backend_claim_id'];
//		        $result = $claim_rec->save();
			
            		$pt_name =& $this->data['short_context']['patient_name'];            
            		$pt_age =& $this->data['short_context']['patient_age'];            
            		$pt_dob=& $this->data['short_context']['patient_dob'];            
      			$pt_dob = Date_util::to_display($pt_dob);

		    	$diagnosis =& $this->input->post('diagnosis');
		    	$dr_name =& $this->input->post('dr_name');
		    	$doa =& $this->input->post('doa');
      			$doa = Date_util::to_display($doa);
		    	$dod =& $this->input->post('dod');
      			$dod = Date_util::to_display($dod);
		    	$d_start =& $this->input->post('d_start');
		    	$h_id =& $this->input->post('hospital_id');
			$h_rec  =& $this->hospital->find($h_id);
			$dr_reg = & $this->input->post('dr_reg');
			$dr_qual = & $this->input->post('dr_qual');
			$dr_add = '"'.$h_rec->street_address.',\n'.$h_rec->city_or_village.','.$h_rec->pin_code.'"';
			$h_name = $h_rec->name;
			$h_add = '"'.$h_rec->street_address.',\n'.$h_rec->city_or_village.','.$h_rec->pin_code.'"';

			$csv1 = $this->config->item('primary_insurer').','.$pt_name.',GROUP POLICY MEMBER,'.$pt_age.' years,'.$pt_dob.','.$data['backend_member_id'].','.$data['backend_policy_number'].','.$diagnosis.','.$dr_name.','.$dr_add.','.$dr_reg.','.$dr_qual.','.$h_name.','.$h_add.','.$doa.','.$dod.','.$d_start;
			
			$fT_tmp1 = $this->config->item('backend_form_template1');
			$fc_tmp1 = $this->config->item('base_path').'uploads/backend_claim_forms/tmp1.csv';
			$fo_tmp1 = $this->config->item('base_path').'uploads/backend_claim_forms/tmp1.pdf';
			$cmd1 = '/usr/bin/glabels-batch -i '.$fc_tmp1.' -o '.$fo_tmp1.' '.$fT_tmp1; 
			$fp1 = fopen($fc_tmp1,"w");
			fwrite($fp1, $csv1);
			fclose($fp1);
			shell_exec($cmd1);

			$ward_cost = $data['ward_days'] * $data['ward_rate'];
			$icu_cost = $data['icu_days'] * $data['icu_rate'];
			$csv2 = $data['ward_days'].','.$data['ward_rate'].','.$data['icu_days'].','.$data['icu_rate'].','.$ward_cost.','.$icu_cost.','.$data['human_amount_claimed'].','.$data['other_amount_claimed'].','.$data['amount_claimed'].','.$this->config->item('primary_insurer');
			
			$fT_tmp2 = $this->config->item('backend_form_template2');
			$fc_tmp2 = $this->config->item('base_path').'uploads/backend_claim_forms/tmp2.csv';
			$fo_tmp2 = $this->config->item('base_path').'uploads/backend_claim_forms/tmp2.pdf';
			$cmd2 = '/usr/bin/glabels-batch -i '.$fc_tmp2.' -o '.$fo_tmp2.' '.$fT_tmp2; 
			$fp2 = fopen($fc_tmp2,"w");
			fwrite($fp2, $csv2);
			fclose($fp2);
			shell_exec($cmd2);

			$cmd = '/usr/bin/gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile='.$fo.' '.$fo_tmp1.' '.$fo_tmp2; 
			$file_status = shell_exec($cmd);
			$data['filename'] = $fname;

//		    if($result === true && $result2==true && $upload_status==true){
		    if($result === true && $result2==true){
		    	$msg_type = 'success';
		    	$msg = 'New backend claim entry added successfully for Hospitalization ID : '.$hospitalization_id;
    	$this->db->trans_commit();
		    }
		    else {
		    	$msg_type = 'error';
		    	$msg = 'Error occured while adding backend claim entry for Hospitalization ID : '.$hospitalization_id.$result.$result2.$file_path.$upload_status;
    	$this->db->trans_rollback();
		    }
//    $this->db->trans_complete();
		    $this->session->set_flashdata('msg_type', $msg_type);
		    $this->session->set_flashdata('msg', $msg);
		    $policy_id = &$this->data['short_context']['policy_id'];	    
//			echo '@todo : where this page will get redirected after save';
		    if($msg_type == 'success')
		     {redirect('/hospitalization/backend_claim/download_file/'.$fname.'/'.$policy_id);	}
		    else {redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	}
		}
	}
	
    function download_file ($filename = '', $policy_id = '')
    {
	$this->data['filename'] = $filename;
	$this->data['policy_id'] = $policy_id;
	$this->load->view('hospitalization/backend_claim_form_download',$this->data);					
    }
/*	
    function add($hospitalization_id = 0) {
	        $this->validate_id($hospitalization_id,'hospitalization');
		$this->data['short_context'] = $this->get_short_context($hospitalization_id, 'hospitalization');          

		$this->load->library('form_validation');

		$this->form_validation->set_rules('form_number', '"Backend claim form number"', 'required');				
		$this->form_validation->set_rules('amount_claimed', '"Amount claimed"', 'required|numeric');				
		$this->form_validation->set_rules('backend_claim_id', '"backend claim number"', 'required');				
//		$this->form_validation->set_rules('claim_file_name', '"claim file name"', 'required');				

		$this->form_validation->set_error_delimiters('<label class="error">', '</label');

		if (!isset($_POST['submit_btn']) || $this->form_validation->run() == FALSE)	{			
			$this->load->model('admin/policy_model','policy');						
			$hospitalization_rec  =& $this->hospitalization->find($hospitalization_id);
			$policy_rec = $this->policy->find($hospitalization_rec->policy_id);

			$values['action'] = 'add';
			$values['backend_policy_type'] = $policy_rec->backend_policy_type;
			$values['backend_policy_number'] = $policy_rec->backend_policy_number;
			$values['backend_member_id'] = $policy_rec->backend_member_id;
			$values['status'] = 'Pending Insurer';
			$values['filling_date'] = 'DD/MM/YYYY';
			$values['form_number'] = '';
			$values['backend_claim_id'] = '';
			$values['amount_claimed'] = '';
			$values['comment'] = '';
			$values['claim_created_by'] = '';
			$this->data['values'] = $values;
			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);					
		}
		else {
//			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);
//			$backend_claim = IgnitedRecord::factory('backend_claims');
			
			$data = array();
//            		$data['claim_id'] =& $claim_id;
            		$data['claim_id'] = 1;
            		$data['policy_id'] =& $this->data['short_context']['policy_id'];            
            		$data['hospitalization_id'] =& $this->data['short_context']['hospitalization_id'];            
            		$data['form_number'] =& $this->input->post('form_number');
		    	$data['backend_claim_id'] =& $this->input->post('backend_claim_id');
		    	$data['backend_member_id'] =& $this->input->post('backend_member_id');
		    	$data['status'] =& $this->input->post('status');
		    	$data['filling_date'] =& $this->input->post('filling_date');
      			$data['filling_date'] = Date_util::change_date_format($data['filling_date']);
		    	$data['amount_claimed'] =& $this->input->post('amount_claimed');
		    	$data['comment'] =& $this->input->post('comment');
		    	$data['claim_created_by'] =& $this->input->post('claim_created_by');

			$upload_status = true;
		if($_FILES['claim_file_name']['name'] != '') {			
//			$config['upload_path'] = $this->config->item('base_path').'assets/uploaded_files/claim_forms';
//			$config['upload_path'] = $this->config->item('base_path').'/uploads/backend_claim_forms';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
			$config['max_size']	= '10000';
			$config['max_width']  = '3000';
			$config['max_height']  = '3000';
//					$config['encrypt_name'] = true;
			$this->load->library('upload', $config);

		$old_file_name = $_FILES['claim_file_name']['name'];
                $new_file_name = $data['form_number'].'-'.$old_file_name;
                 $file_path = $this->config->item('base_path').'uploads/backend_claim_forms/'.$new_file_name;
//			if (!$this->upload->do_upload('claim_form')) 
			if ( !move_uploaded_file($_FILES['claim_file_name']['tmp_name'],$file_path))
			{
				$error = $this->upload->display_errors();
				show_error($error);
				$upload_status = false;
//				break;
			}
			else {
//				$upload_data = & $this->upload->data();
//				$uploaded_file_name = $upload_data['file_name'];
				$upload_status = true;
		    	        $data['claim_file_name'] = $file_path;
			}			
		}

//	$this->db->trans_start();
    	$this->db->trans_begin();
    			$this->load->model('hospitalization/backend_claim_model', 'backend_claim');
			$backend_claim_rec = $this->backend_claim->find_by('form_number',$data['form_number']);
			if($backend_claim_rec == null)
			     $backend_claim_rec = $this->backend_claim->new_record();
//			$backend_claim_rec-> = $backend_claim->new_record($data);
			$backend_claim_rec->load_data($data);
			$result = $backend_claim_rec->save();

	    	   	$backend_claim_settlement_rec = $this->backend_claim_settlement->new_record();
			$backend_claim_settlement_rec->id = $backend_claim_rec->id;
			$result2 = $backend_claim_settlement_rec->save();

//			$last_backend_claim_id =&$backend_claim_rec->uid();
			
			
//			$claim_rec = $this->claim->find($claim_id);
//			$claim_rec->last_backend_claim_id = $last_backend_claim_id;
			
//			$claim_rec->backend_insurer_claim_number = $data['backend_claim_id'];
//		        $result = $claim_rec->save();
			
		    if($result === true && $result2==true && $upload_status==true){
		    	$msg_type = 'success';
		    	$msg = 'New backend claim entry added successfully for Hospitalization ID : '.$hospitalization_id;
    	$this->db->trans_commit();
		    }
		    else {
		    	$msg_type = 'error';
		    	$msg = 'Error occured while adding backend claim entry for Hospitalization ID : '.$hospitalization_id.$result.$result2.$file_path.$upload_status;
    	$this->db->trans_rollback();
		    }
//    $this->db->trans_complete();
		    $this->session->set_flashdata('msg_type', $msg_type);
		    $this->session->set_flashdata('msg', $msg);
		    $policy_id = &$this->data['short_context']['policy_id'];	    
//			echo '@todo : where this page will get redirected after save';
			redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	
		}
	}
*/	
    function edit($backend_claim_id) {
	        $this->validate_id($backend_claim_id,'backend_claim');
		$backend_claim_rec = $this->backend_claim->find($backend_claim_id);
		$hospitalization_id = $backend_claim_rec->hospitalization_id;
		$this->data['short_context'] = $this->get_short_context($hospitalization_id, 'hospitalization');          

		$this->load->library('form_validation');

		$this->form_validation->set_rules('form_number', '"Backend claim form number"', 'required');				
		$this->form_validation->set_rules('amount_claimed', '"Amount claimed"', 'required|numeric');				
		$this->form_validation->set_rules('backend_claim_id', '"backend claim number"', 'required');				

		$this->form_validation->set_error_delimiters('<label class="error">', '</label');

		if (!isset($_POST['submit_btn']) || $this->form_validation->run() == FALSE)	{			
			$this->load->model('admin/policy_model','policy');						
//			$hospitalization_rec  =& $this->hospitalization->find($hospitalization_id);
			$policy_rec = $this->policy->find($backend_claim_rec->policy_id);

			$values['action'] = 'edit';
			$values['backend_policy_type'] = $policy_rec->backend_policy_type;
			$values['backend_policy_number'] = $policy_rec->backend_policy_number;
			$values['backend_member_id'] = $backend_claim_rec->backend_member_id;
			$values['status'] = $backend_claim_rec->status;
      			$values['filling_date'] = Date_util::date_display_format($backend_claim_rec->filling_date);
			$values['form_number'] = $backend_claim_rec->form_number;
			$values['backend_claim_id'] = $backend_claim_rec->backend_claim_id;
			$values['amount_claimed'] = $backend_claim_rec->amount_claimed;
//			$values['claim_file_name'] = $backend_claim_rec->claim_file_name;
			$values['comment'] = $backend_claim_rec->comment;
			$values['claim_created_by'] = $backend_claim_rec->claim_created_by;
			$this->data['values'] = $values;
			if($backend_claim_rec->claim_file_name)
				$this->data['claim_file_name'] = $backend_claim_rec->claim_file_name;
			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);					
		}
		else {
//			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);
//			$backend_claim = IgnitedRecord::factory('backend_claims');
			
			$data = array();
//            		$data['claim_id'] =& $claim_id;
            		$data['claim_id'] = 1;
            		$data['policy_id'] =& $this->data['short_context']['policy_id'];            
            		$data['hospitalization_id'] =& $this->data['short_context']['hospitalization_id'];            
            		$data['form_number'] =& $this->input->post('form_number');
		    	$data['backend_claim_id'] =& $this->input->post('backend_claim_id');
		    	$data['backend_member_id'] =& $this->input->post('backend_member_id');
		    	$data['status'] =& $this->input->post('status');
		    	$data['filling_date'] =& $this->input->post('filling_date');
      			$data['filling_date'] = Date_util::change_date_format($data['filling_date']);
		    	$data['amount_claimed'] =& $this->input->post('amount_claimed');
		    	$data['comment'] =& $this->input->post('comment');
		    	$data['claim_created_by'] =& $this->input->post('claim_created_by');


			$upload_status = true;
		if($_FILES['claim_file_name']['name'] != '') {			
//			$config['upload_path'] = $this->config->item('base_path').'assets/uploaded_files/claim_forms';
//			$config['upload_path'] = $this->config->item('base_path').'/uploads/backend_claim_forms';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
			$config['max_size']	= '10000';
			$config['max_width']  = '3000';
			$config['max_height']  = '3000';
//					$config['encrypt_name'] = true;
			$this->load->library('upload', $config);

		$old_file_name = $_FILES['claim_file_name']['name'];
                $new_file_name = $data['form_number'].'-'.$old_file_name;
                 $file_path = $this->config->item('base_path').'uploads/backend_claim_forms/'.$new_file_name;
//			if (!$this->upload->do_upload('claim_form')) 
			if ( !move_uploaded_file($_FILES['claim_file_name']['tmp_name'],$file_path))
			{
				$error = $this->upload->display_errors();
				show_error($error);
				$upload_status = false;
//				break;
			}
			else {
//				$upload_data = & $this->upload->data();
//				$uploaded_file_name = $upload_data['file_name'];
				$upload_status = true;
		    	        $data['claim_file_name'] = $file_path;
			}			
		}

//    $this->db->trans_start();
    $this->db->trans_begin();
//			$backend_claim_rec = $this->backend_claim->find_by('form_number',$data['form_number']);
		    	$result2 = true;
			if($data['form_number'] != $backend_claim_rec->form_number)
			{
			     $backend_claim_rec->delete();
			     $backend_claim_rec = $this->backend_claim->new_record();

			     $old_bcs_rec = $this->backend_claim_settlement->find($backend_claim_id);
			     $old_bcs_rec->delete();
	    	   	     $backend_claim_settlement_rec = $this->backend_claim_settlement->new_record();
			     $backend_claim_settlement_rec->id = $backend_claim_rec->id;
			     $result2 = $backend_claim_settlement_rec->save();
			}
//			$backend_claim_rec-> = $backend_claim->new_record($data);
			$backend_claim_rec->load_data($data);
			$result = $backend_claim_rec->save();


//			$last_backend_claim_id =&$backend_claim_rec->uid();
			
			
//			$claim_rec = $this->claim->find($claim_id);
//			$claim_rec->last_backend_claim_id = $last_backend_claim_id;
			
//			$claim_rec->backend_insurer_claim_number = $data['backend_claim_id'];
//		        $result = $claim_rec->save();
			
		    if($result === true && $result2 == true){
		    	$msg_type = 'success';
		    	$msg = 'Backend claim entry with id '.$backend_claim_id.' edited successfully';
    $this->db->trans_commit();
		    }
		    else {
		    	$msg_type = 'error';
		    	$msg = 'Error occured while editting backend claim entry with id '. $backend_claim_id;
    $this->db->trans_rollback();
		    }
//    $this->db->trans_complete();
		    $this->session->set_flashdata('msg_type', $msg_type);
		    $this->session->set_flashdata('msg', $msg);
		    $policy_id = &$this->data['short_context']['policy_id'];	    
//			echo '@todo : where this page will get redirected after save';
			redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	
		}
	}

    function add_settlement($backend_claim_id = 0) {
	        $this->validate_id($backend_claim_id,'backend_claim');
		$backend_claim_rec = $this->backend_claim->find($backend_claim_id);
		$hospitalization_id = $backend_claim_rec->hospitalization_id;
		$this->data['short_context'] = $this->get_short_context($hospitalization_id, 'hospitalization');          

		$this->load->library('form_validation');

		$this->form_validation->set_rules('amount_settled', '"Amount Settled"', 'required');				
		$this->form_validation->set_rules('amount_claimed', '"Amount claimed"', 'required|numeric');				

		$this->form_validation->set_error_delimiters('<label class="error">', '</label');

//		if (!isset($_POST['submit_btn']) || $this->form_validation->run() == FALSE)			
		if (!isset($_POST['submit_btn']) )	
		{			
			$this->load->model('admin/policy_model','policy');						
			$policy_rec = $this->policy->find($backend_claim_rec->policy_id);

			$values['action'] = 'add';
			$values['backend_policy_type'] = $policy_rec->backend_policy_type;
			$values['backend_policy_number'] = $policy_rec->backend_policy_number;
			$values['backend_member_id'] = $policy_rec->backend_member_id;
			$values['backend_claim_id'] = $backend_claim_rec->id;
			$values['form_number'] = $backend_claim_rec->form_number;
			$values['amount_claimed'] = $backend_claim_rec->amount_claimed;


		        $backend_cs_rec = $this->backend_claim_settlement->find($backend_claim_id);
			if($backend_cs_rec)
			{
			   $values['status'] = $backend_cs_rec->backend_claim_status;
			   $values['amount_settled'] = $backend_cs_rec->amount_settled;
			   $values['payment_received_date'] = Date_util::date_display_format($backend_cs_rec->payment_received_date);
			   $values['payment_received_details'] = $backend_cs_rec->payment_received_details;
			   $values['settled_by'] = $backend_cs_rec->settled_by;
			}
			else {
			   $values['status'] = 'Approved';
			   $values['amount_settled'] = '';
			   $values['payment_received_date'] = 'DD/MM/YYYY';
			   $values['payment_received_details'] = '';
			   $values['settled_by'] = '';
			}
			$this->data['values'] = $values;
			$this->load->view('hospitalization/show_backend_claim_settlement', $this->data);					
		}
		else {
//			$this->load->view('hospitalization/show_backend_claim_entry', $this->data);
//			$backend_claim = IgnitedRecord::factory('backend_claims');
			
			$data = array();
//            		$data['claim_id'] =& $claim_id;
			$data['id'] = $backend_claim_id;
			$data['backend_claim_status'] = & $this->input->post('status');
			$data['amount_claimed'] = $backend_claim_rec->amount_claimed;
			$data['amount_settled'] = & $this->input->post('amount_settled');
		    	$data['payment_received_date'] =& $this->input->post('payment_received_date');
			$data['payment_received_date'] = Date_util::change_date_format($data['payment_received_date']);
			$data['payment_received_details'] = & $this->input->post('payment_received_details');
			$data['settled_by'] = & $this->input->post('settled_by');
			$data['last_backend_claim_status_id'] = $backend_claim_rec->last_backend_claim_status_id;


//    $this->db->trans_start();
    $this->db->trans_begin();
			$find_rec = $this->backend_claim_settlement->find($backend_claim_id);
			if($find_rec)
			{  $find_rec->delete();}
	    	   	$backend_claim_settlement_rec = $this->backend_claim_settlement->new_record();
			$backend_claim_settlement_rec->load_data($data);
			$result = $backend_claim_settlement_rec->save();
			
			
			
		    if($result === true){
		    	$msg_type = 'success';
		    	$msg = 'New backend claim Settlement entry added successfully for Backend Claim ID : '.$backend_claim_id;
    $this->db->trans_commit();
		    }
		    else {
		    	$msg_type = 'error';
		    	$msg = 'Error occured while adding backend claim entry for Hospitalization ID : '. $hospitalization_id;
    $this->db->trans_rollback();
		    }
//    $this->db->trans_complete();
		    $this->session->set_flashdata('msg_type', $msg_type);
		    $this->session->set_flashdata('msg', $msg);
		    $policy_id = &$this->data['short_context']['policy_id'];	    
//			echo '@todo : where this page will get redirected after save';
			redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	
		}
	   }
	
	
	function show_settlement($backend_claim_id = 0)	{
	        $this->validate_id($backend_claim_id,'backend_claim');
		$backend_claim_rec = $this->backend_claim->find($backend_claim_id);
		$hospitalization_id = $backend_claim_rec->hospitalization_id;
		$this->data['short_context'] = $this->get_short_context($hospitalization_id, 'hospitalization');          

		$backend_cstatus_rec = $this->backend_claim_status->find($backend_claim_rec->last_backend_claim_status_id);
		if($backend_cstatus_rec)
		{
			$values['comment'] = $backend_cstatus_rec->comment;
		}
		else
		{
			$values['comment'] = $backend_claim_rec->comment;
		}
		$backend_cs_rec = $this->backend_claim_settlement->find($backend_claim_id);
			$this->load->model('admin/policy_model','policy');						
			$policy_rec = $this->policy->find($backend_claim_rec->policy_id);
			
			$values['action'] = 'show';
			$values['backend_policy_type'] = $policy_rec->backend_policy_type;
			$values['backend_policy_number'] = $policy_rec->backend_policy_number;
			$values['backend_member_id'] = $policy_rec->backend_member_id;
			$values['backend_claim_id'] = $backend_claim_rec->id;

			$values['form_number'] = $backend_claim_rec->form_number;

			$values['status'] = $backend_cs_rec->backend_claim_status;
			$values['amount_claimed'] = $backend_cs_rec->amount_claimed;
			$values['amount_settled'] = $backend_cs_rec->amount_settled;
			$values['payment_received_date'] = Date_util::date_display_format($backend_cs_rec->payment_received_date);
			$values['payment_received_details'] = $backend_cs_rec->payment_received_details;
			$values['settled_by'] = $backend_cs_rec->settled_by;
			if($backend_cs_rec->cheque_received_date)
			{$values['cheque_received_date'] = Date_util::date_display_format($backend_cs_rec->cheque_received_date);}
			else
			{$values['cheque_received_date'] = 'Not Received';}
			$values['cheque_deposited_by'] = $backend_cs_rec->cheque_deposited_by;
			$this->data['values'] = $values;
			$this->load->view('hospitalization/show_backend_settlement_detail',$this->data);
	}

    function add_payment($backend_claim_id = 0) {
	        $this->validate_id($backend_claim_id,'backend_claim');
		$backend_claim_rec = $this->backend_claim->find($backend_claim_id);

		$hospitalization_id = $backend_claim_rec->hospitalization_id;
		$this->data['short_context'] = $this->get_short_context($hospitalization_id, 'hospitalization');          

		$this->load->library('form_validation');

		$this->form_validation->set_rules('amount_settled', '"Amount Settled"', 'required');				
		$this->form_validation->set_rules('amount_claimed', '"Amount claimed"', 'required|numeric');				

		$this->form_validation->set_error_delimiters('<label class="error">', '</label');

//		if (!isset($_POST['submit_btn']) || $this->form_validation->run() == FALSE)			
		if (!isset($_POST['submit_btn']) )	
		{			
			$this->load->model('admin/policy_model','policy');						
			$policy_rec = $this->policy->find($backend_claim_rec->policy_id);

			$values['action'] = 'add';
			$values['backend_policy_type'] = $policy_rec->backend_policy_type;
			$values['backend_policy_number'] = $policy_rec->backend_policy_number;
			$values['backend_member_id'] = $policy_rec->backend_member_id;
			$values['backend_claim_id'] = $backend_claim_rec->id;
			$values['form_number'] = $backend_claim_rec->form_number;
			$values['amount_claimed'] = $backend_claim_rec->amount_claimed;


		        $backend_cs_rec = $this->backend_claim_settlement->find($backend_claim_id);
			if($backend_cs_rec)
			{
			   $values['status'] = $backend_cs_rec->backend_claim_status;
			   $values['amount_settled'] = $backend_cs_rec->amount_settled;
			   $values['payment_received_date'] = Date_util::date_display_format($backend_cs_rec->payment_received_date);
			   $values['payment_received_details'] = $backend_cs_rec->payment_received_details;
			   $values['settled_by'] = $backend_cs_rec->settled_by;
			   $values['cheque_deposited_by'] = $backend_cs_rec->cheque_deposited_by;
			   if($backend_cs_rec->cheque_received_date)
			   {$values['cheque_received_date'] = Date_util::date_display_format($backend_cs_rec->cheque_received_date);}
			   else
			   {$values['cheque_received_date'] = 'DD/MM/YYYY';}
			}
			else {
			   $values['status'] = 'Approved';
			   $values['amount_settled'] = '';
			   $values['payment_received_date'] = 'DD/MM/YYYY';
			   $values['payment_received_details'] = '';
			   $values['settled_by'] = '';
			   $values['cheque_deposited_by'] = '';
			   $values['cheque_received_date'] = 'DD/MM/YYYY';
			}
			$this->data['values'] = $values;
			$this->load->view('hospitalization/show_backend_claim_payment', $this->data);					
		}
		else {
			
			$bc_rec = $this->backend_claim_settlement->find($backend_claim_id);
			if(!$bc_rec)
			{  
	    	   		$bc_rec = $this->backend_claim_settlement->new_record();
				$bc_rec->id = $backend_claim_id;
			}
			$bc_rec->status = 'Received';
			$bc_rec->cheque_received_date = Date_util::change_date_format($_POST['cheque_received_date']);
			$bc_rec->cheque_deposited_by = $_POST['cheque_deposited_by'];
			if($bc_rec->save())
			{
		    		$msg_type = 'success';
		    		$msg = 'New backend claim payment entry added successfully for Backend Claim ID : '.$backend_claim_id;
		    	}
		    	else {
		    		$msg_type = 'error';
		    		$msg = 'Error occured while adding backend claim payment for Backend Claim ID : '. $backend_claim_id;
		    	}
		    $this->session->set_flashdata('msg_type', $msg_type);
		    $this->session->set_flashdata('msg', $msg);
		    $policy_id = &$this->data['short_context']['policy_id'];	    
//			echo '@todo : where this page will get redirected after save';
			redirect('/hospitalization/policy_details/show_policy_details/'.$policy_id);	
		}
	   }

	public function show_bc_status ($bc_member_id = '',$bc_claim_id ='')
	{
		$this->load->library('ipd/Raksha');
		echo Raksha::open_claim_page($bc_member_id,$bc_claim_id);	
	}

	public function show_member_status ($bc_member_id = '')
	{
		$this->load->library('ipd/Raksha');
		echo Raksha::open_member_page($bc_member_id);	
	}
	
	
}
