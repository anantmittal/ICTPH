<?php
class person_model extends IgnitedRecord {
	var $table = "persons";
  var $belongs_to = "household";
	function person_model()
	{
		parent::IgnitedRecord();
		$this->CI_handle =& get_instance();
	}

	function prune_invalid_org_ids(&$strIdList)
	{
		$invalid=array();
		foreach($strIdList as $orgid)
		{
			if(!$this->find_by('organization_member_id', $orgid))
				$invalid[] = $orgid;
		}
		return $invalid;
	}

	function convert_org_id_to_id($arrIds)
	{
		$listIds=array();
		foreach($arrIds as $orgid)
		{
			if($rec = $this->find_by('organization_member_id', $orgid))
				$listIds[]=$rec->id;
		}
		return $listIds;
	}
	
	function get_all_hh_for_ids($arr_ids)
	{
		$listIds = array();
		$hhid = array();
		foreach($arr_ids as $id)
		{
			if($rec = $this->find_by('id', $id))
				$hhid[$rec->household_id]=true;
		}
		foreach($hhid as $hh=>$ignore)
			$listIds[]=$hh;
		return $listIds;
	}
	function get_summary_by_org_id($org_id)
	{
		$ret = array();
		if($rec = $this->find_by('organization_member_id', $org_id))
		{
			$ret['name']=$rec->full_name;
			$ret['org_id']=$rec->organization_member_id;
			$ret['gender'] = $rec->gender;
			$ret['dob']=date('d/m/Y', strtotime($rec->date_of_birth));
		}
		return $ret;
	}
	
	function create_persons_for_household($hhid, $hhorgid, $indi_arr)
	{
		$this->CI_handle->load->helper('soundex');
		$ctr = 1;
		$hof = 0;
		$person_list = array();
		foreach($indi_arr as $indi)
		{
			$person_rec = $this->new_record();
			$person_rec->full_name = mb_convert_case($indi['name'] ,MB_CASE_TITLE);
			$person_rec->name_soundex=return_soundex($indi['name'], 'ret_normalized_name_parts');
			$person_rec->household_id = $hhid;
			$person_rec->organization_member_id=$hhorgid.sprintf("%02s",$ctr);
			$person_rec->organization_id = 1;
			if($indi['gender'] == "male"){
                $person_rec->gender = "M";
            }else{
                $person_rec->gender = "F";
            }
			//$person_rec->gender = $indi['gender'];
			$person_rec->date_of_birth = $indi['dob'];
			$person_rec->relation = $indi['relation'];
			if(!($person_rec->save()))
				return false;
			//Foreach person create a record in the family table
			if($person_rec->relation=='self' || $ctr==1)
				$hof = $person_rec->id;
			$person_list[]=$person_rec->id;
			$ctr++;
		}
		return array('persons'=>$person_list);
		
	}
	function get_adult_id($person_id)
	{
		$person = $this->find_by('id',$person_id);
		$adult_id = $person->organization_member_id;
	
		return $adult_id;
	}
	
	function get_gender_distribution_count($per_ids)
	{
		$gd = array();
		$ret = array();
		
		foreach($per_ids as $per_id)
		{
			
			$rec = $this->find_by('id',$per_id);
			
			$gd = $rec->gender;
			if($gd !="")
		 	{	
		 		if(array_key_exists($gd,$ret))
		 		{
		 				
		 			$ret{$rec->gender}=$ret{$gd}+1;	 			
		 		}
		 		else
		 		{
		 			$ret{$rec->gender}=1;
		 		}
		 	}
			
		}
		
		return $ret;
		
	}
	
	//Method to get data for Split by age distribution Report.
	function get_age_distribution_count($per_ids)
	{
		$dob = array();
		//Empty bucket for each category of age.
		$age_distribution = array("0-4"=>0, "5-9"=>0, "10-18"=>0, "19-29"=>0, "30-49"=>0, "50-69"=>0, ">=70"=>0); 
		foreach($per_ids as $per_id)
		{
			$rec = $this->find_by('id',$per_id);
			$dob = $rec->date_of_birth;
			list($year,$month,$day) = explode("-",$dob);
    			$year_diff  = date("Y") - $year;
    			$month_diff = date("m") - $month;
    			$day_diff   = date("d") - $day;
    			if ($day_diff < 0 || $month_diff < 0)
    			{
      				$year_diff--;
    			}
    			$age = $year_diff;
    			if($age >= 0 and $age <= 4)
    				$age_distribution['0-4']+=1;
    			elseif($age >= 5 and $age <= 9)
    				$age_distribution['5-9']+=1;
    			elseif($age >= 10 and $age <= 18)
    				$age_distribution['10-18']+=1;
    			elseif($age >= 19 and $age <= 29)
    				$age_distribution['19-29']+=1;
    			elseif($age >= 30 and $age <= 49)
    				$age_distribution['30-49']+=1;
    			elseif($age >= 50 and $age<= 69)
    				$age_distribution['50-69']+=1;
    			else
    				$age_distribution['>=70']+=1;
		}
		return $age_distribution;	
	}
}
