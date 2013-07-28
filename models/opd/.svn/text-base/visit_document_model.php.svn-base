<?php
class visit_document_model extends IgnitedRecord {
  var $belongs_to = array("visit");
//  var $has_one = array("test_type", "visit_cost_item_entry");
	function return_bar_code($doc_id)
	{
		return $this->find_by_sql('select visits.id as visit_id, visit_documents.document_id  from visits, visit_documents where visits.id = visit_documents.visit_id and visits.valid_state="Valid" and visit_documents.document_id="'.strtoupper(trim($doc_id)).'"');
	}
}
