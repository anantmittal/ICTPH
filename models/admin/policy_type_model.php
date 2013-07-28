<?php
class policy_type_model extends IgnitedRecord {
  // TODO - add relationships

  function get_names() {
    $records = $this->find_all();
	$names = array();
    foreach ($records as $record)
      $names[$record->id] = $record->name;
  return $names;
  }
}
