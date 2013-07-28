<?php
class pregnancy_model extends Illness_model {
  var $table = "pregnancies";
  var $belongs_to = array("persons",
			  array("table" => "persons", "field" => "child_id"));
}