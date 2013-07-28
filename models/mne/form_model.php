<?php
class form_model extends IgnitedRecord {

	function form_model()
	{
		parent::IgnitedRecord();
		$this->CI_handle =& get_instance();		
	}
	function get_all_forms($survey_id) {

		$select = array('forms.*');
		$from   = array('survey_forms');

		$forms_obj= $this->select($select)
							->from ($from)
						      ->where('survey_forms.form_id','forms.id', false)
						      ->where('survey_forms.survey_id', $survey_id)
						      ->find_all();

		return $forms_obj;
	}

	//Returns the array in the form of table_name=>"record". For tabular entries
	//the value will be an array against the key "table_name"
	function get_complete_response_record($form_id, $response_id)
	{	
		$ret = array();
		$this->CI_handle->load->model('mne/forms_variable_model', 'forms_variable');
		$table_list=array();
		if($formrec = $this->find($form_id))
		{
			$table_list= $this->CI_handle->forms_variable->get_subtables_for_form($form_id);	
			$table_name = "mne_".$formrec->table_name;
			
			$this->CI_handle->load->model('mne/forms/'.$table_name.'_model',$table_name);
			$ret[$table_name]=$this->CI_handle->{"$table_name"}->find($response_id);
			
			//Now foreach table get the records for this id
			foreach($table_list as $table_name)
			{
				$table_name = "mne_".$table_name;
				$this->CI_handle->load->model('mne/forms/'.$table_name.'_model',$table_name);
				$var_list = array('data_point_id','form_id');
				$value_list = array($response_id, $form_id);
				$ret[$table_name]=$this->CI_handle->{"$table_name"}->find_all_by($var_list, $value_list);
			}
		}
		return $ret;
	}
}
