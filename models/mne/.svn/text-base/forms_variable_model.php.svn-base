<?php
class forms_variable_model extends IgnitedRecord {
	var $table="forms_variables";

	//returns an array of tables
	function get_subtables_for_form($form_id)
	{
		$ret = array();
		$forms_obj= $this->select("properties")
						      ->where('form_id',$form_id)
						      ->where('data_type', 'table')
						      ->find_all();
		if($forms_obj)
		{
			foreach($forms_obj as $subtab)
			{
				$parts = explode(',',$subtab->properties);
				if(count($parts) >0)
				{
					$ret[]=$parts[0];
				}
			}
		} 
		return $ret;
	}
}
