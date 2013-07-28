<?php 
class mne_sum_report_model extends IgnitedRecord 
{ 
	var $table = "mne_sum_report";
	var $columns = array("run_id","form_id","data_point_id","label_value","opening_compliance", "closing_compliance", "unplanned_leave","outages");
	var $column = array("opening_compliance", "closing_compliance", "unplanned_leave","outages");
	var $display_columns = array("Opening Compliance", "Closing Compliance", "Unplanned Leave","Outages");
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
				foreach($this->columns as $col=>$def)
				{
					$val = $row->{$col};
					if( $val != $def)
					{
						if($val == 'y')
							$temp[$col]='Yes';
						else if($val == 'n')
							$temp[$col]='No';
					}
					else
						$temp[$col]='-';
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
					$val = $row->{$col};
					if( $val== 'y' || $val== 'n')
					{
						if($val == 'y')
							$temp[$col]='Yes';
						else if($val == 'n')
							$temp[$col]='No';
					}
					else{
						$temp[$col]=$val;
					}
				}
				$ret[$row->label_value]=$temp;
			}
		}
		return $ret;
	}
}
