<?php
class pregnancy_model extends IgnitedRecord {
  var $belongs_to = array("person");
  var $has_many = array("visit_obstetric_records", "pregnancy_records");
}