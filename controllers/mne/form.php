<?php
class form extends CI_Controller {
	public $form_data;
	/**
	 * function define() :
	 * @return unknown_type
	 */

	function define($is_module ='No') {
		if(!$_POST){
//			$this->form_data['tabname'] = 'default';
//			$this->load->view('monitoring_evaluation/define_form', $this->form_data);

//			$this->load->view('monitoring_evaluation/create_survey_req', $this->form_data);
			$this->form_data['tabs'] = array('household', 'person','area','village','taluka');
			
			$this->form_data['modules'] = $this->get_modules();
			$this->load->view('mne/create_form_definition', $this->form_data);
			return;
		}


		$this->load->model('mne/form_model', 'form');
		if($is_module == 'Yes')
			$_POST['type'] = 'module';
		else
			$_POST['type'] = 'form';
		$f_rec = $this->form->new_record($_POST);
    $this->load->dbutil();
    $this->db->trans_begin();
    $tx_status = true;
    $msg = '';
		if(!$f_rec->save ())
		{
			$tx_status = false;
			$msg .= 'Could not save form record';
		}
		$this->load->model('mne/forms_variable_model', 'f_vars');
		$msg ='';
		$file_txt = $f_rec->title."\n";
		$sql_table ='create table mne_'.$f_rec->table_name.' ( id int(11) auto_increment, run_id int(11) references survey_runs(`id`) ';
		if($is_module =='Yes')
		{
			$sql_table .=', form_id int(11) references forms(`id`), data_point_id int(11), label_value varchar(100) ';
		}
		$html_form = ' <input type="hidden" name="table_name" value="'.$f_rec->table_name.'" /> <br> <table>';
		for($i=0; $i<$_POST['no_of_vars']; $i++)
		{
		    $fi_type_v = 'form_input_type_'.$i;
		    if($_POST[$fi_type_v] != 'null')
		    {	
			$desc_v = 'description_'.$i;
			$label_v = 'label_'.$i;
			$field_v = 'field_'.$i;
			$datatype_v = 'datatype_'.$i;
			$min_v = 'min_size_'.$i;
			$lv_v = 'length_value_'.$i;
			$v_v = 'form_input_values_'.$i;
			$var_rec = $this->f_vars->new_record();
			$var_rec->form_id = $f_rec->id;
			$var_rec->description= $_POST[$desc_v];
			$var_rec->screen_name = $_POST[$label_v];
			$var_rec->variable_name = $_POST[$field_v];
			$var_rec->form_type= $_POST[$fi_type_v];
			$var_rec->data_type= $_POST[$datatype_v];
//			$var_rec->min_size= $_POST[$min_v];
			if($var_rec->data_type == 'table')
			{
				$var_rec->properties= $_POST[$min_v].','.$_POST[$lv_v].','.$_POST[$v_v];
			}
			else if($var_rec->data_type == 'enum' || $var_rec->data_type == 'set')
			{
				$var_rec->properties= $_POST[$lv_v].','.$_POST[$v_v];
			}
			else
			{
				$var_rec->properties= $_POST[$lv_v].','.$_POST[$min_v];
			}
//			$var_rec->properties= get_data_string($var);
			if(!$var_rec->save ())
			{
				$tx_status = false;
				$msg .= 'Could not save variable record';
			}
//			$msg .= $i.'.'.$this->get_sql($var_rec).'"\n"';
//			if($i !=0)
			if($var_rec->data_type != 'label' && $var_rec->data_type != 'table')
			{	
				$sql_table .= ', ';
				$sql_table .= $this->get_sql($var_rec);
			}
//			$html_form .= '<tr> <td><b>'.$var_rec->screen_name.'</b></td>';
			$file_txt .= $var_rec->screen_name.": ";
			if($var_rec->data_type != 'label')
			{	
//				$html_form .= '<td>'.$this->get_html($var_rec).'</td></tr>';
				$file_txt .= $this->get_text($var_rec);
			}
			else
			{
//				$html_form .= '<td></td></tr>';
				$file_txt .= "\n";
			}
			$html_form .= $this->get_html($var_rec)."\n";
		    }
		}
		$sql_table .= ', Primary KEY (id) ); ';
		$html_form .= '</table>';

		$html_filename = $this->config->item('base_path').'application/views/mne/forms/'.$f_rec->table_name.'.html';
		$fp = fopen($html_filename,"w");
		if(!fwrite($fp,$html_form))
		{
			$tx_status = false;
			$msg .= 'Could not write html file';
		}
		fclose($fp);

		$model_txt = '<?php class mne_'.$f_rec->table_name.'_model extends IgnitedRecord { var $table = "mne_'.$f_rec->table_name.'";}';
		$model_filename = $this->config->item('base_path').'application/models/mne/forms/mne_'.$f_rec->table_name.'_model.php';
		$fp1 = fopen($model_filename,"w");
		if(!fwrite($fp1,$model_txt))
		{
			$tx_status = false;
			$msg .= 'Could not write model file';
		}
		fclose($fp1);


		$txt_filename = $this->config->item('base_path').'uploads/forms/'.$f_rec->table_name.'.txt';
		$fp2 = fopen($txt_filename,"w");
		if(!fwrite($fp2,$file_txt))
		{
			$tx_status = false;
			$msg .= 'Could not write Text file';
		}
		fclose($fp2);

		$sql_filename = $this->config->item('base_path').'db_schema/forms/'.$f_rec->table_name.'.sql';
		$fp = fopen($sql_filename,"w");
		if(!fwrite($fp,$sql_table))
		{
			$tx_status = false;
			$msg .= 'Could not write sql file';
		}
		fclose($fp);
		$q_res = $this->db->query($sql_table);
		if(!$q_res)
		{
			$tx_status = false;
			$msg .= 'Could not create table';
		}

		if($tx_status)
		{
       	$this->db->trans_commit();
    				$this->session->set_userdata('msg', 'Form: '.$f_rec->name.' saved successfully with id '.$f_rec->id.' sql '.$sql_table.' html '.$html_form);
				$this->form_data['filename'] = 'uploads/forms/'.$f_rec->table_name.'.txt';
				$this->load->view('mne/survey_home',$this->form_data);
//				redirect('/mne/survey/index');
		}
		else
		{
       	$this->db->trans_rollback();
    				$this->session->set_userdata('msg', 'Form: '.$f_rec->name.' save unsuccessful: '.$msg);
				redirect('/mne/survey/index');
		}

	}

	function get_sql($var_rec)
	{
		$sql = '';
		$num = explode(',',$var_rec->properties);
		if($var_rec->data_type == 'set' || $var_rec->data_type == 'enum')
		{
			$sql .= '`'.$var_rec->variable_name.'` '.$var_rec->data_type.'(';
			$trs = explode('<br>',$num[1]);
			for($i=0; $i < $num[0]; $i++)
			{
				$vals= explode('|',$trs[$i]);
				if($i!=0)
					$sql .= ',';
				$sql .= '"'.$vals[0].'"';
			}
			$sql .= ')';
		}
		else if($var_rec->data_type == 'date' || $var_rec->data_type == 'text')
		{
			$sql .= '`'.$var_rec->variable_name.'` '.$var_rec->data_type;
		}
		else if($var_rec->data_type == 'table')
		{
//			$sql .= '`'.$var_rec->variable_name.'_id` int(11) ';
		}
		else
		{
			$sql .= '`'.$var_rec->variable_name.'` '.$var_rec->data_type.'('.$num[0].')';
		}

		return $sql;

	}

	function get_html($var_rec,$prefix = '',$sn = '',$not_table = 'Y')
	{
		$html = '';
		if($not_table == 'Y')
		{
			$html .= '<tr> <td><b>'.$var_rec->screen_name.'</b></td>';
			$html .='<td>';
		}

		$num = explode(',',$var_rec->properties);
		if($var_rec->data_type == 'date')
		{
			$html .= '<input name="'.$prefix.$var_rec->variable_name.$sn.'" id="datepicker" type="text" size="10" class="datepicker" />';
		}
		else if($var_rec->form_type == 'text' || $var_rec->form_type == 'password' || $var_rec->form_type =='textarea')
		{
			$html .= '<input name="'.$prefix.$var_rec->variable_name.$sn.'" id="'.$prefix.$var_rec->variable_name.$sn.'" type="'.$var_rec->form_type.'" size="'.$num[0].'" />';
		}
		else if($var_rec->form_type == 'table' || $var_rec->form_type == 'sub_form')
		{
			$this->load->model('mne/form_model','form');
			$this->load->model('mne/forms_variable_model','fvars');
			$f_rec = $this->form->find_by('table_name',$num[0]);
			$fvars = $this->fvars->find_all_by('form_id',$f_rec->id);
			$html .= '<input name="'.$prefix.$var_rec->variable_name.'_nos'.$sn.'" id="'.$prefix.$var_rec->variable_name.'_nos'.$sn.'" type="hidden" value="'.$num[1].'" />';
			if($var_rec->form_type =='table')
			{
				$html .= '<table border="1">';
				$html .= '<tr>';
				$html .= '<td>SN</td>';
				$html .= '<td></td>';
				foreach($fvars as $fvar)
				{
					$html .= '<td>'.$fvar->screen_name.'</td>';
				}
				$html .='</tr>';
				$vls = $this->get_value_labels($var_rec->properties);
				for($i=0; $i < $num[1]; $i++)
				{
					$html .= '<tr><td>'.($i+1).'.</td>';
					$html .= '<td>'.$vls[$i]['lab'].':</td>';
					$html .= '<input name="'.$prefix.$var_rec->variable_name.'_label_value'.$i.'" id="'.$prefix.$var_rec->variable_name.'_label_value'.$i.'" type="hidden" value="'.$vls[$i]['val'].'" />';
					foreach($fvars as $fvar)
					{
						$html .= '<td>'.$this->get_html($fvar,$var_rec->variable_name,$i,"N").'</td>';
					}
					$html .='</tr>';
				}
				$html .= '</table>';
			}
			if($var_rec->form_type =='sub_form')
			{
				$vls = $this->get_value_labels($var_rec->properties);
				for($i=0; $i < $num[1]; $i++)
				{
					$html .= '<table border="1">';
					$html .= '<tr><td>'.($i+1).'.</td><td> '.$vls[$i]['lab'].':</td></tr>';
					$html .= '<input name="'.$prefix.$var_rec->variable_name.'_label_value'.$i.'" id="'.$prefix.$var_rec->variable_name.'_label_value'.$i.'" type="hidden" value="'.$vls[$i]['val'].'" />';
					foreach($fvars as $fvar)
					{
//						$html .= '<tr><td>'.$var_rec->screen_name.'</td><td>'.$this->get_html($fvar,$var_rec->variable_name,$i).'</td></tr>';
						$html .= $this->get_html($fvar,$var_rec->variable_name,$i,"Y");
					}
//					$html .='<br>';
					$html .='</table>';
				}
			}
		}
		else if($var_rec->form_type == 'select')
		{
			$html .= '<select name="'.$prefix.$var_rec->variable_name.$sn.'" id="'.$prefix.$var_rec->variable_name.$sn.'" >';
			$vls = $this->get_value_labels($var_rec->properties);
			for($i=0; $i < $num[0]; $i++)
			{
				$html .= '<option value="'.$vls[$i]['val'].'">'.$vls[$i]['lab'].'</option>';
			}
			$html .= '</select>';
		}
		else if($var_rec->form_type == 'checkbox' || $var_rec->form_type =='radio')
		{
			$vls = $this->get_value_labels($var_rec->properties);
			if($var_rec->form_type == 'checkbox')
			{
				$sn.='[]';
			}
			for($i=0; $i < $num[0]; $i++)
			{
				$html .= '<input type="'.$var_rec->form_type.'" name="'.$prefix.$var_rec->variable_name.$sn.'" id="'.$prefix.$var_rec->variable_name.$sn.'" value="'.$vls[$i]['val'].'" />'.$vls[$i]['lab'].'<br>';
			}
		}
		if($not_table == 'Y')
		{
			$html .='</td></tr>';
		}
		$html .= "\n";

		return $html;
	}

	function get_text($var_rec)
	{
		$txt = '';
		$num = explode(',',$var_rec->properties);
		if($var_rec->form_type == 'text' || $var_rec->form_type == 'password' || $var_rec->form_type =='textarea')
		{
			$txt .= '________________________________________________';
		}
		else if($var_rec->form_type == 'table' || $var_rec->form_type == 'sub_form')
		{
			$this->load->model('mne/form_model','form');
			$this->load->model('mne/forms_variable_model','fvars');
			$f_rec = $this->form->find_by('table_name',$num[0]);
			$fvars = $this->fvars->find_all_by('form_id',$f_rec->id);
			if($var_rec->form_type =='table')
			{
				$txt.= 'SN  |  '."\t";
				foreach($fvars as $fvar)
				{
					$txt .= " | \t".$fvar->screen_name;
				}
				$txt .="\n";
				$txt .= '________________________________________________'."\n";
				$vls = $this->get_value_labels($var_rec->properties);
				for($i=0; $i < $num[1]; $i++)
				{
					$txt .= ($i+1).'. '.$vls[$i]['lab'].' ('.$vls[$i]['val'].')'."\n";
					foreach($fvars as $fvar)
					{
						$txt .= "\t".$this->get_text($fvar);
					}
					$txt .="\n";
				}
				$txt .="\n";
			}
			if($var_rec->form_type =='sub_form')
			{
				$vls = $this->get_value_labels($var_rec->properties);
				for($i=0; $i < $num[1]; $i++)
				{
					$txt .= ($i+1).'. '.$vls[$i]['lab'].' ('.$vls[$i]['val'].')'."\n";
					foreach($fvars as $fvar)
					{
						$txt .= "\n".$var_rec->screen_name."\t".$this->get_text($fvar);
					}
					$txt .="\n";
				}
				$txt .="\n";
			}
		}
		else 
		{
			$vls = $this->get_value_labels($var_rec->properties);
			$txt .= "\n";
			for($i=1; $i <= $num[0]; $i++)
			{
				$txt .= $i.'. '.$vls[$i-1]['lab'].' ('.$vls[$i-1]['val'].')'."\n";
			}
		}

		return $txt;
	}

	function get_value_labels($string)
	{
		$ret = Array();
		$num = explode(',',$string);
		$j=0;
		if(sizeof($num) > 2)
			$j=1;
		$trs = explode('<br>',$num[($j+1)]);
		for($i=0; $i < $num[$j]; $i++)
		{
			$vals= explode('|',$trs[$i]);
			$ret[$i]['val'] = trim($vals[0]);
			$ret[$i]['lab'] = trim($vals[1]);
		}
		return $ret;
	}

	function assign() {

		$this->form_data ['surveys'] = $this->get_array('surveys');
		$this->form_data ['forms'] = $this->get_array('forms');

		if (! isset ( $_POST ['submit_affiliation'] ) ) {
			$this->load->view ( 'mne/survey_form', $this->form_data );
		} else {
			$this->load->model ( 'mne/survey_form_model','sf' );

//			$_POST ['start_date'] = Date_util::change_date_format ( $_POST ['start_date'] );
			$sf_obj = $this->sf->new_record ( $_POST );
			if($sf_obj->save ())
			{
    				$this->session->set_userdata('msg', 'Form: '.$sf_obj->form_id.' assigned to Survey: '.$sf_obj->survey_id.' successfully');
				redirect('/mne/survey/index');
			}
			else
			{
    				$this->session->set_userdata('msg', 'Form: '.$sf_obj->form_id.' could not be assigned to Survey: '.$sf_obj->survey_id);
				redirect('/mne/survey/index');
			}
		}
	}

	function get_array($type) {
		$objs = array ();
		$obj = IgnitedRecord::factory ($type );
		$rows = $obj->find_all ();
		foreach ( $rows as $row ) {
			$objs [$row->id] = $row->name;
		}
		return $objs;
	}

	function get_modules() {
		$objs = array ();
		$obj = IgnitedRecord::factory ('forms');
		$rows = $obj->find_all_by ('type','module');
		foreach ( $rows as $row ) {
			$objs [$row->table_name] = $row->name;
		}
		return $objs;
	}

	function list_() {

		$this->load->model('mne/form_model','form_mod');
		$this->form_data['forms'] = $this->form_mod->find_all();
		$this->load->view('mne/form_list',$this->form_data);

	}

	function show($id = 0) {
		$this->load->model('mne/form_model', 'form');
		$this->form_data['form'] = $this->form->find($id);
		$this->load->model('mne/survey_model', 'survey');
		$this->form_data['surveys'] = $this->survey->get_all_surveys($id);

		$this->load->model('mne/forms_variable_model', 'form_var');
		$vars = $this->form_var->find_all_by('form_id',$id,'false');
		$this->form_data['vars'] = $vars;
		$this->load->library('date_util');
		$this->load->view('mne/form_show', $this->form_data);
	}

	function select_form_run() {

		if(!$_POST){

			$this->load->model('mne/survey_model', 'survey');
			$surveys = $this->get_array('surveys');
			$this->form_data['surveys'] = $surveys;
			$this->load->view('mne/select_form_run', $this->form_data);
			return;
		}

		redirect('/mne/form/add_data/'.$_POST['srun_id'].'/'.$_POST['form_id']);

	}

	function add_data($srun_id =0,$form_id=0,$runtime_form = 0) {

		$this->load->model('mne/form_model', 'form');
		$form_rec = $this->form->find($form_id);
		if(!$_POST){
			$this->form_data['srun_id'] = $srun_id;
			$this->form_data['form'] = $form_rec;
			$this->form_data['runtime_form'] = $runtime_form;
			$this->load->view('mne/form_add_data', $this->form_data);
			return;
		}
	
    $this->load->dbutil();
    $this->db->trans_begin();
    $tx_status = true;
    $msg = '';
    $diff = false;
		$this->load->model('mne/forms/mne_'.$form_rec->table_name.'_model', 'table');
		$_POST['run_id'] = $srun_id;
		$location_id = $this->session->userdata('location_id');
		$_POST['provider_location_id'] = $location_id;
		$this->load->library('date_util');
		$this->load->model('mne/forms_variable_model', 'form_var');
		$vars = $this->form_var->find_all_by('form_id',$form_id);
		foreach ($vars as $var)
		{
			if($var->data_type == 'date')
			{

				$_POST[$var->variable_name] = Date_util::to_sql($_POST[$var->variable_name]);
				$diff = true;
			}
			if($var->data_type == 'set')
			{
				$recs = $_POST[$var->variable_name];
				$val = '';
				for($i=0; $i<sizeof($recs); $i++)
				{
					if($i!=0)
						$val .= ',';
					$val .= $recs[$i];
				}

				$_POST[$var->variable_name] = $val;
				$diff = true;
			}
		}
		$tbl_rec = $this->table->new_record($_POST);
		if(!$tbl_rec->save())
			$tx_status = false;
		foreach ($vars as $var)
		{
			if($var->data_type == 'table')
			{
			
				$num = explode(',',$var->properties);
				$this->load->model('mne/forms/mne_'.$num[0].'_model', $num[0]);
				$this->load->model('mne/form_model','form');
				$f_rec = $this->form->find_by('table_name',$num[0]);
				$fvars = $this->form_var->find_all_by('form_id',$f_rec->id,'false');
				for($i=0; $i<$num[1]; $i++)
				{
					$new_rec = $this->{$num[0]}->new_record();
					$new_rec->form_id = $form_id;
					$new_rec->run_id = $srun_id;
					$new_rec->data_point_id = $tbl_rec->id;
					$lbl_var = $var->variable_name.'_label_value'.$i;
					$new_rec->label_value = $_POST[$lbl_var];
					foreach($fvars as $fvar)
					{
						$p_var = $var->variable_name.$fvar->variable_name.$i;
						
						//There's a chance that in the html this particular value is 
						//"disabled". So explicitly check if it is present in $_POST
						if(!array_key_exists($p_var,$_POST))
							continue;
						if($fvar->data_type == 'date')
							$_POST[$p_var] = Date_util::to_sql($_POST[$p_var]);
						if($fvar->data_type == 'set')
						{
							$recs = $_POST[$p_var];
							$val = '';
							for($j=0; $j < sizeof($recs); $j++)
							{
								if($j!=0)
									$val .= ',';
								$val .= $recs[$j];
							}
							$new_rec->{$fvar->variable_name} = $val;
						}
						else
							$new_rec->{$fvar->variable_name} = $_POST[$p_var];
					}
					if(!$new_rec->save())
					{
						$msg .= 'i '.$i.':'.$new_rec->run_id.':'.$new_rec->data_point_id.':'.$new_rec->label_value;
						$tx_status = false;
					}
				}
			}
		}

		if($tx_status == 'true'){
       		$this->db->trans_commit();
    		$this->session->set_userdata('msg', 'Successfully Added data for '.$_POST['table_name'].$msg);
            $this->send_mail();
    	    redirect('/mne/survey/index');
		}else{
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', 'Could not save data for '.$_POST['table_name'].' Please try again '.$msg);
			redirect('/mne/survey/index');
		}

	}
	
	function send_mail(){
		$this->load->model('mne/forms/mne_daily_sum_report_model','daily_report');
		$ret = $this->daily_report->get_todays_latest_report_for_mailing();
		if($ret == false){
			echo "not found";
			return;
		}
		
		$finalstr = $this->__daily_summary($ret);
		echo $finalstr;
		$fpath = $base_path.'test_'.time();
		$fp = fopen($fpath,"w");
		if(!fwrite($fp,$csv_string))
		{ 
			echo "CSV File could not be written";  
		}
		 $daily_report_emails = $this->config->item('daily_report_emails');
		$this->load->library('email', $this->config->item('email_configurations'));  // email_configurations in module_constants.php
		$this->email->set_newline("\r\n");
		$this->email->from('hmis@sughavazhvu.co.in');
		//$this->email->to('sangeetha.lakshmanan@ictph.org.in');
		$this->email->cc($daily_report_emails);
		$this->email->subject('Daily Summary');
		$this->email->message($finalstr);
	  	//$this->email->attach($fpath);
		if($this->email->send()) {
			//echo 'Email sent.';
		}
		//$this->load->library('mail_util');
		//$mail_sent = Mail_util::send('sachin@sen-sei.in','Daily Summary',$finalstr,'html',$fpath,'text/plain');	
	}
	
	function __daily_summary($ret)
	{
		$subtabs = array('mne_sum_report'=>'Operation Summary', 'mne_sum_payment'=>'Payment Summary');
		$finalstr = "<html><body><table><tr><td>Reporter:".$ret['username']."</td></tr><tr><td>Date:".$ret['date']."</td></tr><table>";
		foreach($subtabs as $subt=>$caption)
		{
			$finalstr.="<table border=\"1px\"><caption style='font-size:20px'>".$caption."</caption><tr><th>Location</th>";
			foreach($ret['columns'][$subt] as $col)
				$finalstr.="<th>".$col."</th>";
			$finalstr.="</tr>";
			
			//Now fill the values
			foreach($ret['rows'][$subt] as $loc=>$row)
			{
				$finalstr.="<tr><td>".mb_convert_case($loc,MB_CASE_TITLE)."</td>";
				foreach($row as $k=>$v){
					if($k === "outages" && !empty($v)){
						$finalstr.="<td style='color:#f00;'>$v</td>";
					}else if( ($k === "opening_compliance" || $k === "closing_compliance") && $v === 'No'){
						$finalstr.="<td style='color:#f00;'>$v</td>";
					}else if( $k === "unplanned_leave" && $v === 'Yes'){
						$finalstr.="<td style='color:#f00;'>$v</td>";
					}else{
						$finalstr.="<td>$v</td>";
					}
				}
				$finalstr.="</tr>";	
			}
				
			$finalstr.="</table>";
			
		}
		$comment = preg_replace('/\n/','<br/>',$ret['comments']);
		$finalstr.="<br/><b style='font-size:15px'>Comment</b><br/><p>".$comment."</p></body></html>";
		return $finalstr;
	}

	function show_form($form_id=0,$runtime_form = 0) {

		$this->load->model('mne/form_model', 'form');
		$form_rec = $this->form->find($form_id);
		$this->form_data['srun_id'] = 0;
		$this->form_data['form'] = $form_rec;

		$form_html = ' <input type="hidden" name="table_name" value="'.$form_rec->table_name.'" /> <br> <table>';
		$this->load->model('mne/forms_variable_model', 'form_var');
		$vars = $this->form_var->find_all_by('form_id',$form_id);
		foreach ($vars as $var)
		{
			$form_html .= $this->get_html($var);
		}
		$form_html .= '</table>';
		$this->form_data['form_html'] = $form_html;

		$this->form_data['runtime_form'] = $runtime_form;
		$this->load->view('mne/form_add_data', $this->form_data);
	}
}
