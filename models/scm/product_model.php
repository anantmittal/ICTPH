<?php
class product_model extends IgnitedRecord {
  var $has_many = array("visit_medication_entries","product_batchwise_stocks");
  
  
  
}

