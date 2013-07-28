<?php
class medication_model extends IgnitedRecord {
  var $belongs_to = array("person", "visit");

  // TODO
  function get_current($person_id) {
  }

  function get_all($person_id) {
    return $this->find_all_by("person_id", $person_id);
  }
}