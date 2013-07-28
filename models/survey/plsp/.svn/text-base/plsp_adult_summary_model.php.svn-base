<?php 
class plsp_adult_summary_model extends IgnitedRecord {
	var $table="plsp_adult_summary";
	var $belongs_to="plsp_adult";

	function get_risk_summary($id)
	{
		$ret=array();
		if( $rec = $this->find_by("plsp_adult_id", $id))
		{
			if($rec->assess_bmi==2)
				$ret[]="Low BMI";
			if($rec->assess_bmi==5 || $rec->assess_bmi==6)
				$ret[]="High BMI";
			if($rec->assess_wc>1)
				$ret[]="High WC";
			if($rec->assess_bp==3)
				$ret[]="Very High BP";
			if($rec->assess_preg==1)
				$ret[]="Pregnant";
		}
		return $ret;
	}
}
