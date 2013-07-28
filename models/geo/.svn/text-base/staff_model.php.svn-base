<?php
class staff_model extends IgnitedRecord {
//  var $habtm = ('areas', 'village_cities', 'talukas', 'districts');

  // has a Village / City id
//  var $has_one = array('table' => 'areas', 'name' => 'area_id');
   // $has_one = array('table' => 'village_cities', 'name' => 'village_city_id');
  // $has_one = array('table' => 'talukas', 'name' => 'taluka_id');
  // $has_one = array('table' => 'districts', 'name' => 'district_id');

  function get_names() {
    $records = $this->order_by('name','ASC')->find_all();
	$names = array();
    foreach ($records as $record)
      $names[$record->id] = $record->name;
  return $names;
  }

}
