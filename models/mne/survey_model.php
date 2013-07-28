<?php
class survey_model extends IgnitedRecord {

	function get_all_surveys($form_id) {

		$select = array('surveys.*');
		$from   = array('survey_forms');

		$forms_obj= $this->select($select)
							->from ($from)
						      ->where('survey_forms.survey_id','surveys.id', false)
						      ->where('survey_forms.form_id', $form_id)
						      ->find_all();

		return $forms_obj;
	}
}
