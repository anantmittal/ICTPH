<?php
class plsp_adult_model extends IgnitedRecord {
	var $table="plsp_adult";
	var $has_one="plsp_adult_summary";
	var $fieldId='F003';
	function find_by_id($id)
	{
		return $this->find_by('F003',$id);
	}
	function get_batch_nums($db)
	{
		$res = $db->query('select distinct batch from plsp_adult');
		$batches=array();
		if($res->num_rows()>0)
		{
			foreach($res->result() as $row)
				$batches[]=$row->batch;
		}
		return $batches;
	}
	function find_all_individual_ids()
	{
		return $this->find_all_by_sql('select '.$this->fieldId.' as id from '.$this->table);
	}
	function return_all_ids(&$idmap)
	{
		if($recs = $this->find_all_by_sql('select '.$this->fieldId.' as id from '.$this->table))
		{
			foreach($recs as $row)
			{
				$idmap[trim($row->id)]=true;
			}
		}
	}
	
	function get_cvd_risk_count($fh,$age,$sh,$bmi,$bp)
	{
		$query = "select count(*) as my_count from plsp_adult,plsp_adult_summary where plsp_adult.id=plsp_adult_summary.plsp_adult_id";
		
		$query = $query.$this->__cvd_query_helper($fh, $age, $sh, $bmi, $bp);
		$CI =& get_instance();
		$counts = 0;
		if($ret = $CI->db->query($query))
		{
			$res = $ret->result();
			$counts = $res[0]->my_count;
		}
		return $counts;
	}
	function get_cvd_risk_individuals($fh, $age, $sh, $bmi, $bp)
	{
		$query = "select plsp_adult.id as id,plsp_adult.".$this->fieldId." as individual from plsp_adult,plsp_adult_summary where plsp_adult.id=plsp_adult_summary.plsp_adult_id";
		
		$query = $query.$this->__cvd_query_helper($fh, $age, $sh, $bmi, $bp);
		$CI =& get_instance();
		$indis = array();
		if($ret = $CI->db->query($query))
		{
			$res = $ret->result();
			foreach($res as $row)
			{
				$indis[]=array($row->id,$row->individual);
			}
		}
		return $indis;
	}
	function __cvd_query_helper($fh, $age, $sh, $bmi, $bp)
	{
		$substr="";
		$fh_str = " and plsp_adult_summary.assess_cvd_fh=";
		if($fh=="Yes")
			$fh_str.="2";
		else
			$fh_str.="1";

		$age_str =" and plsp_adult_summary.err_dob=0 and plsp_adult.F101yy";
		if($age=="<=34")
			$age_str.=">=1976";
		else if($age=="35-64")
			$age_str.="<1976 and plsp_adult.F101yy>=1946";
		else
			$age_str.="<1946";

		$sh_str =" and plsp_adult_summary.assess_smoking";
		if($sh=="No")
			$sh_str.="=1";
		else if($sh=="Low")
			$sh_str.="=2";
		else
			$sh_str.="=3";

		$tobacco_str =" and plsp_adult_summary.assess_tobacco";
		if($sh=="No")
			$tobacco_str.="=1";
		else
			$tobacco_str.="=2";
		
		$bmi_str =" and plsp_adult_summary.assess_bmi";
		if($bmi=="High")
			$bmi_str.="=5";
		else if($bmi=="Very High")
			$bmi_str.="=6";
		else
			$bmi_str.="<5 and plsp_adult_summary.assess_bmi!=0";

		$bp_str =" and plsp_adult_summary.assess_bp";
		if($bp=="Normal")
			$bp_str.="=1";
		else if($bp=="High")
			$bp_str.="=2";
		else
			$bp_str.="=3";

		$substr = $fh_str.$age_str.$sh_str.$bmi_str.$bp_str;
		return $substr;
	}
	
}
