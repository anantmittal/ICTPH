<?php
class sql_report extends CI_Controller {
	public $form_data = array();

  	function index() {
   	 	if($this->session->userdata('username')!=null) {
			$reports = array();

			$username = $this->session->userdata('username');
			$this->load->model('user/user_model','user');
			$this->load->model('user/role_model','role');
			$this->load->model('user/users_role_model','ur');
			$u_rec = $this->user->find_by('username',$username);
			$urs = $this->ur->find_by (array('user_id','role_id >'),array($u_rec->id,'1'));

			$this->load->model('mne/report_model','rep');
			$this->load->model('mne/reports_permission_model','rep_perm');
//			$report_recs = $this->rep_perm->find_all_by('role_id',$urs->role_id);
//			$report_recs = $this->rep_perm->find_all_by_sql('select distinct report_id from reports_permissions where (role_id = 1 OR role_id ='.$urs->role_id.')');
			$report_recs = $this->rep_perm->distinct()
						      ->where('role_id','1',false)
						      ->or_where('role_id',$urs->role_id,false)
						      ->find_all();
			foreach($report_recs as $rec)
			{
				$rep_rec = $this->rep->find($rec->report_id);
				$reports[$rep_rec->id]=$rep_rec->name;
			}
			if($urs->role_id == 2)
				$this->form_data['allow_define'] = true;
			else
				$this->form_data['allow_define'] = false;
				ksort($reports);
			$this->form_data['reports'] = $reports;
      			$this->load->view('mne/report_home',$this->form_data);
    		} else {
      			redirect('/session/session/login');
    		}
  	}


	function define() {

		if(!$_POST) {

			$this->load->model('user/role_model','role');
			$roles_arr = array();
			$roles_recs = $this->role->find_all();

			$i=0;
			foreach ($roles_recs as $role_rec) {
				$roles_arr[$i]['id'] = $role_rec->id;
				$roles_arr[$i]['name'] = $role_rec->name;
				$i++;
			}
			$this->form_data['roles'] = $roles_arr;
			$this->form_data['num_roles'] = $i;

			$this->load->view('mne/define_sql_report', $this->form_data);
			return ;
		}
		else {
		
		$this->load->model('mne/report_model','rep');
		$this->load->model('mne/reports_permission_model','rep_perm');
		$this->load->model('mne/reports_variable_model','rep_var');

		$report_obj = $this->rep->new_record($_POST);
    $this->load->dbutil();
    $this->db->trans_begin();
    $tx_status = true;
		if(!$report_obj->save ())
			$tx_status = false;

		$roles = $_POST['roles'];
		for($i=0; $i<sizeof($roles); $i++)
		{
			$rp_obj = $this->rep_perm->new_record();
			$rp_obj->report_id = $report_obj->id;
			$rp_obj->role_id = $roles[$i];
			if(!$rp_obj->save ())
				$tx_status = false;
		}

		$num_vars = $_POST['variable_row_id'];
//		$variables = $_POST['variable'];
//		foreach($_POST['variable'] as $variable)
		for($j=1; $j < $num_vars; $j++)
		{
			$var_name = 'name_'.$j;
			$var_alias = 'alias_'.$j;
			$var_type= 'type_'.$j;
			if($_POST[$var_name] !='')
			{
				$var_obj = $this->rep_var->new_record();
				$var_obj->name = $_POST[$var_name];
				$var_obj->alias= $_POST[$var_alias];
				$var_obj->type = $_POST[$var_type];
				$var_obj->report_id = $report_obj->id;
				if(!$var_obj->save ())
					$tx_status = false;
			}
		}

		if($tx_status)
		{
       	$this->db->trans_commit();
//    				$this->session->set_userdata('msg', 'Report: '.$report_obj->name.' saved successfully with id '.$report_obj->id.' num vars '.$num_vars.$var_name.$var_alias.$var_type);
    				$this->session->set_userdata('msg', 'Report: '.$report_obj->name.' saved successfully with id '.$report_obj->id);
				redirect('/mne/sql_report/index');
		}
		else
		{
       	$this->db->trans_rollback();
    				$this->session->set_userdata('msg', 'Report: '.$report_obj->name.' save unsuccessful');
				$this->load->view ( 'mne/define_sql_report',$this->form_data );
		}
	}

}



	function generate($report_id = '') {
		if($report_id != '') {
			$this->load->model('mne/report_model', 'report');
			$report = $this->report->find($report_id);

			if(!$report) {
				echo 'Report id is Invalid'	;
				return ;
			}

//			$this->load->model('mne/reports_permission_model','rep_perm');
			$this->load->model('mne/reports_variable_model','rep_var');
			$variables = $this->rep_var->find_all_by('report_id',$report_id,false);
			$this->form_data['variables'] = $variables;
			$this->form_data['report'] = $report;

			
			if(!$_POST)
			{
				$this->load->view('mne/generate_sql_report', $this->form_data);
			}
			else
			{

    $this->load->dbutil();
    $this->load->helper('file');  
    $this->load->library('date_util');  
				$base_sql = $report->sql_query;
				$sql_query = $base_sql;
				foreach($variables as $variable)
				{
					if($variable->type == 'Text')
					{
						$var_new = $_POST[$variable->alias];
					}
					else
					{
					 	$this->load->library('date_util');
						
						$var_new = '"'.Date_util::to_sql($_POST[$variable->alias]).'"';
					}
					$sql_query = str_replace('$'.$variable->alias,$var_new,$sql_query);
				}
				$query = $this->db->query($sql_query);
				$csv_sql_result = $this->dbutil->csv_from_result($query);
				$this->load->model('mne/reports_run_model', 'reports_run');
				$rr_rec = $this->reports_run->new_record();
				$rr_rec->report_id = $report_id;
				$rr_rec->username = $this->session->userdata('username');
				$rr_rec->date= Date_util::to_sql(Date_util::today());
				$rr_rec->save();
		        	$filename = 'uploads/mne/'.$rr_rec->id.'-gen_report-'.$report->id.'.csv';
				if(!write_file($filename,$csv_sql_result))
				{  echo "New File could not be written";  }
				else
				{
					$this->load->library('mail_util');
					if($_POST['email_address'] !='')
					{
					$this->load->library('email', $this->config->item('email_configurations'));  // email_configurations in module_constants.php
					$this->email->set_newline("\r\n");
					$this->email->from('hmis@sughavazhvu.co.in');
					$this->email->to($_POST['email_address']);
					$this->email->subject($report->name.' Report');
					$this->email->message('Download Attachment');
	  				$this->email->attach($filename);
					if($this->email->send()) {
						$this->form_data['mail_sent'] = 'Email sent successfully';
					}else{
						$this->form_data['mail_sent'] = 'Failed to send Email! Please try again later';
					}
					//$mail_sent = Mail_util::send($_POST['email_address'],$report->name.' Report','Download Attachment','text',$filename,'text/plain');
  					//$this->form_data['mail_sent'] = $mail_sent;
					}
					else
					{
	  					$this->form_data['mail_sent'] = 'No Email Address Provided';
					}
	  				$this->form_data['filename'] = $filename;
					$this->load->view('mne/generate_sql_report', $this->form_data);
				}
			}


		} else {
			echo 'Report ID is not found in URL';
		}
	}




	//function is used to get table fields used for ajax call
	function table_fields($internal_call = false, $table_name = '') {

		if($internal_call == false) {
			$table_name = $this->input->post('table_name');
		}

		$result  = $this->db->table_exists($table_name);

		if(!$result) {
			$result['result'] = 'failure';
			echo json_encode($result);
			return ;
		}

		$result = $this->db->list_fields($table_name);

		foreach ($result as $value) {
			$fields_result['fields'][] = $value;
		}

		if($internal_call == false)
		{
			$fields_result['result'] = 'success';
			echo json_encode($fields_result);

		}else {
			return $fields_result['fields'];
		}
	}

	function list_() {
		$this->load->model('mne/report_model', 'report');
		$reports = $this->report->find_all();
		$this->form_data['reports'] = $reports;
		$this->load->view('mne/report_list', $this->form_data);
	}


 /**
  * function is used to return report's  id, name values, used in autocomplete functionality in add permission
  * functionality
  */
	function report_values() {
		$this->load->model('mne/report_model', 'report');
		$reports = $this->report->find_all();
		$values = '';

		foreach ($reports as $report ) {
			echo $report->name.'|'.$report->id.chr(10); //chr(10) is returing \n charector
		}
	}
	
	
	/**
  * Edit Reports
  */
	function edit_report($report_id = '') {
		$this->load->model('mne/report_model','rep');
		$this->load->model('mne/reports_permission_model','rep_perm');
		$this->load->model('mne/reports_variable_model','rep_var');
		
	
		if(!$_POST) {

			$this->load->model('user/role_model','role');
			$roles_arr = array();
			$permitted_roles = array();
			$roles_recs = $this->role->find_all();

			$i=0;
			foreach ($roles_recs as $role_rec) {
				$roles_arr[$i]['id'] = $role_rec->id;
				$roles_arr[$i]['name'] = $role_rec->name;
				
				$i++;
			}
			
			$find_report=$this->rep->where("id",$report_id)->find();
			if($find_report !=null){
				$find_variables=$this->rep_var->where("report_id",$find_report->id)->find_all();
				if($find_variables !=null){
					
					$this->form_data['edit_variables'] = $find_variables;
				}
				$find_permitted_roles=$this->rep_perm->where("report_id",$find_report->id)->find_all();
				if($find_permitted_roles !=null){
					foreach($find_permitted_roles as $find_permitted_role){
						$permitted_roles[$find_permitted_role->id]=$find_permitted_role->role_id;
					}
					
				}
				$this->form_data['edit_permitted_roles'] = $permitted_roles;
				$this->form_data['edit_report'] = $find_report;
				$this->form_data['report_id'] = $find_report->id;
			}
			
			$this->form_data['roles'] = $roles_arr;
			$this->form_data['num_roles'] = $i;

			$this->load->view('mne/define_sql_report', $this->form_data);
			return ;
		}else {
			//print_r($_POST);
			//return;
			$edited_report_id=$_POST['report_id'];
			//Delete initial report
			//$this->db->where('id', $edited_report_id);
			//$this->db->delete('reports');
			
			//Delete initial report_permissions
			$this->db->where('report_id', $edited_report_id);
			$this->db->delete('reports_permissions');
			
			//Delete initial report_varirbles
			$this->db->where('report_id', $edited_report_id);
			$this->db->delete('reports_variables');
			
			
	
			//$report_obj = $this->rep->new_record($_POST);
	    	$this->load->dbutil();
	   	 	$this->db->trans_begin();
	   	 	$tx_status = true;
	   	 	$report_data = array (
			"name" => $_POST['name'],
			"body" => $_POST['body'],
	   	 	"sql_query" => $_POST['sql_query']
			);
			$this->db->where('id', $edited_report_id);
			$this->db->update('reports', $report_data);
	
			$roles = $_POST['roles'];
			for($i=0; $i<sizeof($roles); $i++)
			{
				$rp_obj = $this->rep_perm->new_record();
				$rp_obj->report_id = $edited_report_id;
				$rp_obj->role_id = $roles[$i];
				if(!$rp_obj->save ())
					$tx_status = false;
			}
	
			$num_vars = $_POST['variable_row_id'];
	//		$variables = $_POST['variable'];
	//		foreach($_POST['variable'] as $variable)
			for($j=1; $j < $num_vars; $j++)
			{
				$var_name = 'name_'.$j;
				$var_alias = 'alias_'.$j;
				$var_type= 'type_'.$j;
				if($_POST[$var_name] !='')
				{
					$var_obj = $this->rep_var->new_record();
					$var_obj->name = $_POST[$var_name];
					$var_obj->alias= $_POST[$var_alias];
					$var_obj->type = $_POST[$var_type];
					$var_obj->report_id = $edited_report_id;
					if(!$var_obj->save ())
						$tx_status = false;
				}
			}
	
			if($tx_status){
	       		$this->db->trans_commit();
	//    				$this->session->set_userdata('msg', 'Report: '.$report_obj->name.' saved successfully with id '.$report_obj->id.' num vars '.$num_vars.$var_name.$var_alias.$var_type);
	    		$this->session->set_userdata('msg', 'Report: '.$_POST['name'].' saved successfully with id '.$edited_report_id);
				redirect('/mne/sql_report/index');
			}else{
	       		$this->db->trans_rollback();
	    		$this->session->set_userdata('msg', 'Report: '.$_POST['name'].' save unsuccessful');
				$this->load->view ( 'mne/define_sql_report',$this->form_data );
			}
		}
	}
}
