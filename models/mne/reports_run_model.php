<?php
class reports_run_model extends IgnitedRecord {
	var $has_one = array('table' => 'reports', 'name' => 'report_id');

}
