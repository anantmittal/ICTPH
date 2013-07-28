<?php
class pregnancy_update_model extends IgnitedRecord {
  var $belongs_to = array("pregnancy", "visit");
  var $has_one = array("visit_obstetric_records");
}