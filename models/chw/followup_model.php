<?php
class followup_model extends IgnitedRecord {
	public $chw_id;

	function get_all_followups($chw_id) {

		$select = array('chws.name AS chw_name', 'projects.name AS project_name','persons.full_name AS person_name','persons.organization_member_id AS alt_id');
		$from   = array('chws', 'projects','persons');

		$followups_obj = $this->select($select)
							->from ($from)
						      ->where('followups.chw_id','chws.id', false)
						      ->where('followups.person_id','persons.id', false)
						      ->where('followups.project_id','projects.id', false)
						      ->where('followups.chw_id', $chw_id)
						      ->find_all();

		$followup_data = array();
		$cnt = 0;
		foreach ($followups_obj as $obj) {
			$followup_data[$cnt]['followup_id']  = $obj->id;
			$followup_data[$cnt]['chw_name']     = $obj->chw_name;
			$followup_data[$cnt]['project_name'] = $obj->project_name;
			$followup_data[$cnt]['person_id']    = $obj->person_id;
			$followup_data[$cnt]['alt_id']    = $obj->alt_id;
			$followup_data[$cnt]['person_name']    = $obj->person_name;
			$followup_data[$cnt]['start_date']    = $obj->start_date;
			$followup_data[$cnt]['summary']      = $obj->summary;
			$cnt++;
		}
		return $followup_data;
	}




}
