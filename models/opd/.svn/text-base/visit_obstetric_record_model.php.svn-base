<?php
class visit_obstetric_record_model extends IgnitedRecord {
  var $belongs_to = array("visit", "pregnancy", "pregnancy_update");
  var $has_one = array(array("name" => "pregnancy", "fk" => "visit_id"),
		       array("name" => "pregnancy_update", "fk" => "visit_id"));

  // Not adding the following relationships since the use is not clear yet
  // illness, medications, lab_orders, immunization
}