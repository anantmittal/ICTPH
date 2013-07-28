<?php
class household_model extends IgnitedRecord {
  var $has_many = array("persons");

	function Household_model()
	{
		parent::IgnitedRecord();
		$this->CI_handle =& get_instance();
	}
  function get_members($id) {
    if (!($household_rec = $this->find($id)))
      return false;
    return $household_rec->related("persons")->order_by('id')->get();
  }

  function get_members_list($id) {
    $members = array();
    foreach ($this->get_members($id) as $member)
      $members[$member->id] = $member->full_name;
    return $members;
  }
	function get_members_by_org_id($id)
	{
		if(!($household_rec = $this->find_by('policy_id',$id)))
			return false;
		return $household_rec->related("persons")->order_by('organization_member_id')->get();
	}

	function prune_invalid_org_ids(&$strIdList)
	{
		$invalid=array();
		foreach($strIdList as $orgid)
		{
			if(!$this->find_by('policy_id', $orgid))
				$invalid[] = $orgid;
		}
		return $invalid;
	}
	function get_members_for_valid_policy($id)
	{
		if($rec = $this->find_by_sql('select id,status from policies where id in (select policy_id from households where policy_id="'.$id.'") and status="valid"'))
		{
			//$this->CI_handle =& get_instance();
			return get_persons($rec->id);
		}
		return false;
	}
	function get_persons($id) {
		$this->CI_handle->load->model('demographic/person_model','person');
	    if (!($household_rec = $this->find_by('policy_id',$id)))
	      return false;
	    return $this->CI_handle->person->find_all_by('household_id',$household_rec->id);
	  }
	
	function get_valid_policy_for_household($hh_orgid)
	{
		if($rec = $this->find_by_sql('select id,status from policies where id in (select policy_id from households where policy_id="'.$hh_orgid.'") and status="valid"'))
		{
			return $rec->id;
		}
		return false;
	}

	function get_household_summary_for_org_id($id)
	{
		$ret = array();
		$this->CI_handle->load->model('demographic/person_model','person');
		$this->CI_handle->load->model('geo/village_citie_model','village');
		$hh=$this->find_by('policy_id', $id);
		$rec_village = $this->CI_handle->village->find($hh->village_city_id);
		$ret['hhid']=$id;
		$ret['street_address']=$hh->street_address;
		$ret['village_name']=$rec_village->name;
		$ret['contact_number']=$hh->contact_number;
		$persons = $this->get_members_for_valid_policy($id);
		$ret['individuals']=array();
		foreach($persons as $indi)
		{
			$rowData = array();
			$rowData['individual_id']=$indi->organization_member_id;
			$rowData['full_name']=$indi->full_name;
			$rowData['relation']=$indi->relation;
			$rowData['gender']=$indi->gender;
			$rowData['age']=$indi->age;
			$ret['individuals'][]=$rowData;
		}
		return $ret;
	}
	
	//This is remarkably similar to "get_household_summary_for_org_id"
	//and should ideally be merged, but I'm too lazy. Also, the whole
	//policy->family->household->person labyrinth is a little intimidating
	function get_household_summary($id)
	{
		$ret = array();
		$this->CI_handle->load->model('demographic/person_model','person');
		$this->CI_handle->load->model('geo/village_citie_model','village');
		$hh=$this->find( $id);
		$rec_village = $this->CI_handle->village->find($hh->village_city_id);
		$ret['hhid']=$id;
		$ret['street_address']=$hh->street_address;
		$ret['village_name']=$rec_village->name;
		$ret['contact_number']=$hh->contact_number;
		$persons = $this->get_members($id);
		$ret['individuals']=array();
		foreach($persons as $indi)
		{
			$rowData = array();
			$rowData['individual_id']=$indi->organization_member_id;
			$rowData['full_name']=$indi->full_name;
			$rowData['relation']=$indi->relation;
			$rowData['gender']=$indi->gender;
			$rowData['age']=$indi->age;
			$ret['individuals'][]=$rowData;
		}
		return $ret;
	}
	
	function create_household_and_members($hhdetails)
	{
		$this->CI_handle->load->helper('soundex');
		$this->CI_handle->load->model('demographic/person_model','person');
		$this->CI_handle->load->model('geo/gps_model','gps');
		$newrec = array();
		$newrec['village_city_id'] = $hhdetails['village_city_id'];
		$newrec['contact_number'] = $hhdetails['phone'];
		$newrec['street_address'] = $hhdetails['doornum'].",".$hhdetails['street'].",";
		$newrec['address_soundex']=return_soundex($newrec['street_address'], 'ret_normalized_address_parts');
		$newrec['policy_id'] = $hhdetails['policy_id'];
		
		//Create the GPS coords
		$gps = $this->CI_handle->gps->new_record();
		$gps->latitude = $hhdetails['latitude'];
		$gps->longitude = $hhdetails['longitude'];
		$gps->elevation = $hhdetails['locationAltitude'];
		
		if(!$gps->save())
			return false;
		$newrec['gps_id'] = $gps->id;
		$household_rec = $this->new_record($newrec);
		if(!$household_rec->save())
			return false;
		//Now create individuals
		$indi_arr = array();
		if(!$indi_arr = $this->CI_handle->person->create_persons_for_household($household_rec->id, $hhdetails['policy_id'], $hhdetails['individuals']))
			return false;
		$indi_arr['household_id']=$household_rec->id;
		return $indi_arr;
	}
	
	//Method to get data for Number of new cards created in each clinic report.
	function get_number_new_cards_count($from_date,$to_date)
	{
		$rmhc_and_number_new_cards = array(); 
		$temporary = 'Temporary';
		if($households = $this->where('enroled_on <=', $to_date)
 				->where('enroled_on >=', $from_date)
 				->find_all())
 		{
 			
 			foreach($households as $household)
 			{	
 				if(preg_match('/T[0-9][0-9][0-9][0-9][0-9][0-9][0-9]/',$household->policy_id))
 				{
 					$rmhc_and_number_new_cards{$temporary}+=1;
 				}
 				else
 				{
 					$str = substr("$household->policy_id", 0, 3);
 					$rmhc_and_number_new_cards{$str}+=1;
 				} 
 			}
 		} 		
 		return $rmhc_and_number_new_cards;
	}

}
