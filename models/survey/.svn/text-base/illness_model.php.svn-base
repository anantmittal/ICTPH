<?php
class illness_model extends IgnitedRecord {
  var $belongs_to = "persons";
  
  function get_by_family($family_model, $family_id) {
    if (!($members = $family_model->get_members($family_id))) {
      echo "invalid family id [".$family_id."]";
      return false;
    }

    $member_ids = array();
    foreach ($members as $member) {
      $member_ids[] = $member->id;
    }

    $this->where_in("person_id", $member_ids);
    // TODO FIXME: Why does the following require find_all, not find??
    $res = $this->find_all();
    return $res;
  }
}