<?php
class district_model extends IgnitedRecord {
  var $habtm = array("taluka");

  function get_code($id) {
	$record = $this->find($id);
	return $record->code;
  }

  function get_names() {
    $records = $this->order_by('name','ASC')->find_all();
	$names = array();
    foreach ($records as $record)
      $names[$record->id] = $record->name;
  return $names;
  }

  function get_name($id) {
    $record = $this->find($id);
    if($record) {
      return $record->name;}
    else
      return false;
  }
}
