<?php
class immunization_model extends IgnitedRecord {
  var $belongs_to = array("person", "visit");
}