<?php 
class plsp_infant_summary_model extends IgnitedRecord {
	var $table="plsp_infant_summary";
	
	function get_risk_summary($id)
	{
		$ret=array();
		if( $rec = $this->find_by("plsp_infant_id", $id))
		{
			if($rec->assess_w==1 || $rec->assess_w==2)
				$ret[]="Low Weight";
			if($rec->assess_h==1 || $rec->assess_h==2)
				$ret[]="Low Height";
		}
		return $ret;
	}
}
