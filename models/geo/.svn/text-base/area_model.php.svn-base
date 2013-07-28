<?php
class area_model extends IgnitedRecord {
//  var $habtm = "village_cities";
  var $belongs_to = "village_cities";

  // has a Village / City id
  var $has_one = array('table' => 'village_cities', 'name' => 'village_city_id');

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
