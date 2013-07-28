<?php
class payments extends Hosp_base_controller {

	function index() {		
		if(isset($_POST['end_date'])) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('payment_type', 'Payment type', 'required');
			
//			$this->form_validation->set_rules('start_date', 'Start Date', 'required');
//			$this->form_validation->set_rules('end_date', 'End Date', 'required');
			$this->form_validation->set_error_delimiters('<label class="error">', '</label>');
			
			if ($this->form_validation->run() == FALSE)	{
				$this->load->view('hospitalization/show_payment_request');
			}
			else {
				$payment_type = $this->input->post('payment_type');
				$export_as = $this->input->post('export_as');				
				$this->create_containts();				
			}
		}
		else {
			$this->load->view('hospitalization/show_payment_request');
		}
	}


	private function create_containts(){

		$this->load->model('hospitalization/claim_settlement_model', 'claim_settlement');
 		$this->load->library('date_util');
 		
        $data['payment_type'] = $this->input->post('payment_type');
        if($this->input->post('start_date')){
//	    	$data['start_date'] = $this->change_date_format($this->input->post('start_date'));
	    	$data['start_date'] = Date_util::change_date_format($this->input->post('start_date'));
        }
        else $data['start_date'] = '';

        if($this->input->post('end_date')) {			
//	    	$data['end_date'] = $this->change_date_format($this->input->post('end_date'));	    	
	    	$data['end_date'] = Date_util::change_date_format($this->input->post('end_date'));	    	
        }
        else $data['end_date'] = '';

	    $export_as = $this->input->post('export_as');         
		$data['containts'] = $this->claim_settlement->create_containts($data);
		$cnt = 0;		
		//below functionality is used to change date format of database date to dd/mm/yyyy
        foreach ($data['containts'] as &$data_row){
        	if($cnt != 0){        		
//        		$data_row[3] = $this->date_display_format($data_row[3]);        		
        		$data_row[3] = Date_util::date_display_format($data_row[3]);        		
        	}
        	$cnt++;
        }
        
        
         
		if ($export_as == 'html') {
			$this->load->view('hospitalization/show_payment_request', $data);
		}
		elseif ($export_as == 'csv'){			
			//create csv functionality will goes here
			$csv_string = '';
			foreach ($data as $row){
				foreach ($row as $array){
					foreach ($array as $value){
						$csv_string .= $value.',';
					}
					$csv_string .= "\r\n ";
				}
			}
			header('Content-type: text/csv');
			header('Content-disposition: attachment; filename="'.$payment_type.'_payment_file_'.time().'.csv"');
			header("Pragma: no-cache");
			header("Expires: 0");
			echo $csv_string;
		}
	}

	function payment_request(){
		//$this->load->view('hospitalization/show_payment_request');
	}
} 
