<?php 
class mne_sum_payment_model extends IgnitedRecord 
{ 
	var $table = "mne_sum_payment";
	var $columns = array("run_id","form_id","data_point_id","label_value","total_patients", "paid_patients", "free_patients", "kgfs_pending","collection");
	var $column = array("total_patients", "paid_patients", "free_patients", "kgfs_pending","collection");
	var $display_columns = array("Total Patient Count", "Paid Patients", "Free Patients", "Pending to KGFS", "Total Collection");
	function get_columns()
	{
		return $this->display_columns;
	}

	function get_summary($data_point_id)
	{
		$ret = false;
		if($records = $this->find_all_by('data_point_id', $data_point_id))
		{	
			$ret = array();
			foreach($records as $row)
			{
				$temp = array();
				foreach($this->columns as $col)
				{
					$temp[$col] = $row->{$col};
				}
				$ret[$row->label_value]=$temp;
			}
		}
		return $ret;
	}
	//for Daily Sum Report 
	function get_summary_for_latest_report($data_point_id)
	{
		$ret = false;
		if($records = $this->find_all_by('data_point_id', $data_point_id))
		{	
			$ret = array();
			foreach($records as $row)
			{
				$temp = array();
				foreach($this->column as $col)
				{
					$temp[$col] = $row->{$col};
				}
				$ret[$row->label_value]=$temp;
			}
		}
		return $ret;
	}
}
