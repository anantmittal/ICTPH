<?php
class taluka_model extends IgnitedRecord {
  var $habtm = array("village_citie");
  var $belongs_to = "district";

  // has a district id
  var $has_one = array('table' => 'districts', 'name' => 'district_id');

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
