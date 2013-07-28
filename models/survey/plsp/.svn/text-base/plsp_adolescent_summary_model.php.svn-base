<?php 
class plsp_adolescent_summary_model extends IgnitedRecord {
	var $table="plsp_adolescent_summary";

	function get_risk_summary($id)
	{
		$ret=array();
		if( $rec = $this->find_by("plsp_adolescent_id", $id))
		{
			if($rec->assess_bmi==2 )
				$ret[]="Low BMI";
			if($rec->assess_bmi==5 || $rec->assess_bmi==6)
				$ret[]="High BMI";
			if($rec->assess_wc>1)
				$ret[]="High WC";
		}
		return $ret;
	}
}
