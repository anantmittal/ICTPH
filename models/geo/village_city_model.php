<?php
class village_city_model extends IgnitedRecord {
  var $habtm = array("areas");
  var $belongs_to = "taluka";

  // has a taluka id
  var $has_one = array('table' => 'talukas', 'name' => 'taluka_id');

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

	function village_exists($taluka_id, $village_name)
	{
		if($rec = $this->find_by(array('taluka_id','name'), array($taluka_id, $village_name)))
			return true;
		else
			return false;
	}

}
