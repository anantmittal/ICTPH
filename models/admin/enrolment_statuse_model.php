<?php
class enrolment_statuse_model extends IgnitedRecord {
  // TODO - add relationships
	var $table = "enrolment_statuses";
 	function get_all_details($field, $value)
	{
		$detail_rec = $this->join('policies','policy_id = policies.id','left')
				   ->select('policies.*',true)
				   ->where($field, $value)
				   ->find();
		return $detail_rec;
	}
}
