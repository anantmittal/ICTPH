<?php
class plsp_svg_model extends IgnitedRecord {
	var $table="plsp_svg";
	function get_all_svgs()
	{
		$ret = array();
		if($recs = $this->find_all())
		{
			foreach($recs as $one)
				$ret[$one->code] = $one->svg_name;
		}
		return $ret;
	}
}
