<?php
class pediatric_update_model extends IgnitedRecord {
  var $belongs_to = array("person", "visit");
}