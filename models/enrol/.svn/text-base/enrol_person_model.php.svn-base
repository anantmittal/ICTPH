<?php
class enrol_person_model extends IgnitedRecord {
	var $table="enrol_person";
	var $cols=array("dob","name","relation","key","enrol_household_id","gender","lock");
	var $relation_map = array('self'=>'Self', 'wife'=>'Wife', 'husband'=>'Husband', 'son'=>'Son', 'grand_daughter'=>'Grand_daughter', 'daughter'=>'Daughter', 			'o'=>'Other', 'mother_in_law'=>'Mother_in_Law','brother'=>'Brother','father'=>'Father','sister'=>'Sister', 'mother'=>'Mother',
		'daughter_in_law'=>'Daughter_in_Law','grandmother'=>'Grandmother','grandson'=>'Grand_son','son_in_law'=>'Son_in_law',
		'father_in_law'=>'Father_in_Law', 'brother_in_law'=>'Brother_in_Law', 'grandfather'=>'Grandfather', 'sister_in_law'=>'Sister_in_Law');
	
	function enrol_person_model()
	{
		parent::IgnitedRecord();
		$this->CI_handle =& get_instance();		
		//$this->CI_handle->load->model('enrol/enrol_household_model', 'household');
		
	}	

	

	function store_records($arr)
	{
		foreach($arr as $rec)
		{	
			$rec['lock']=0;
			if($rec['enrol_household_id']!=0)
			{
				if($row = $this->find_by(array('enrol_household_id','key'), array($rec['enrol_household_id'],$rec['key'])))
				{
					if($row->lock==0) // lock = 1 means locked and lock = 2 means invalid - for persons
					{
						foreach($this->cols as $col)
						{
							if(array_key_exists($col, $rec))
							{
								$row->{"$col"}=$rec[$col];
							}
						}
						
						$row->save();
					}
				}
				else
				{
					$new = $this->new_record($rec);
					$new->save();
				}
			}
		}
	}
	
	function get_records($hhid)
	{
		$ret = array();
		if($rec=$this->find_all_by('enrol_household_id',$hhid))
		{
			foreach($rec as $person)
			{
				$record=array();
				foreach($this->cols as $col)
				{
					$record[$col]=$person->{$col};
				}
				$record['id']=$person->id;
				$ret[]=$record;
			}
		}
		return $ret;
	}
	function get_self_records($hhid)
	{
		$ret = array();
		$self = 'Self';
		if($rec=$this->find_by(array('enrol_household_id','relation'),array($hhid,$self)))
		{
			
			$record=array();
			foreach($this->cols as $col)
			{
				$record[$col]=$rec->{$col};
			}
			$record['id']=$rec->id;
			
			
		}
		return $record;
	}

	function get_person_record($id)
	{
		$ret = array('id'=>array('label',$id));
		if($rec=$this->find($id))
		{
			foreach($this->cols as $col)
			{
				$set = array('','','');
				if($col == 'lock')
				{
					$set[0]='dropdown';
					$set[2]=array('unlocked', 'locked', 'invalid');
				}
				else
					$set[0]='string';
				$set[1]=$rec->{$col};
				
				if($col == 'enrol_household_id')
				{
					$set[0]='link';
					$set[1]= base_url()."index.php/enrol/enrol/edit_household/".$rec->{$col};
					$col = "Household";
				}
				$ret[$col]=$set;
			}
		}
		return $ret;
	}

	function export($project_id)
	{
		$ret = array();
		$cols_to_export = array('id','enrol_household_id','name','gender','dob','relation');
		if($records = $this->find_all_by_sql('select * from '.$this->table.' where (enrol_person.lock != 2 and enrol_household_id in (select id from enrol_household where enrol_project_id ='.$project_id.'))')) 
//		if($records = $this->find_all_by('enrol_project_id',$project_id))
		{
			$rec_arr=array();
			foreach($records as $row)	
			{
				foreach($cols_to_export as $col)
					$rec_arr[$col]=trim($row->{$col});
				echo $rec_arr['relation']."<br/>";
				if(array_key_exists($rec_arr['relation'],$this->relation_map))
					$rec_arr['relation']=$this->relation_map[$rec_arr['relation']];
				$ret[]=$rec_arr;
			}
			
		}
		return array($cols_to_export,$ret);
	}
	
	function get_individual_count($id)
	{
		$ret = 0;
		$lock = '!=2';
		if($records = $this->find_all_by(array('enrol_household_id','lock'),array($id,$lock)))
			$ret = count($records);
		return $ret;
	}
	
	function set_record($id, $data)
	{
		if($rec=$this->find($id))
		{
			foreach($data as $col=>$val)
			{
				$rec->{$col}=$val;
			}
			$rec->save();
		}
		else
			return false;
		return true;
	}
/*	function get_duplicate_indi_in_same_household($project_id)
	{
		$hhs = $this->CI_handle->household->find_all_hhids($project_id); //find the list of hhs, 
		foreach($hhs as $hh)
		{
			$recs = $this->find_all_by('enrol_househol_id',$hhid->id); // gives all members of a particular house

			$household_persons = NULL;			
			$household_persons = array();			
			foreach($recs as $rec)
			{
				$person=array();
				foreach($this->cols as $col)
				{
					$person[$col]=$rec->{$col};
				}
				$person['id']=$rec->id; 
				$person['cardnum']=$hh->cardnum; //assigning the cardnumber to the person - to return it to the controller
				$person['agent']=$hh->agent; //assigning the agent name to the person - to return to the controller
				if($person['relation']='self')
					$relation_self[]=$person['relation'];
				if($person['relation']='wife')
					$relation_wife[]=$person['relation'];
			}

			
		}
	
	return $duplicate;

	}

*/

	function print_arr($arr, $depth)
	{
		foreach($arr as $k=>$v)
		{
			for($i=0;$i<$depth;$i++)
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "$k=>$v<br/>";
			if(is_array($v))
				$this->print_arr($v, $depth+1);
		}
	}


	function get_duplicate_relations_in_same_household($project_id)
	{
		$this->CI_handle->load->model('enrol/enrol_household_model', 'household');
		$hhs = $this->CI_handle->household->find_all_hhids($project_id); //find the list of hhs, 
		foreach($hhs as $hh)
		{	
			$relation = 'relation';
			$household_id = NULL;
			$household_id = $hh->id;
			//echo "$household_id =>";
			$self = 'Self';
			$recs=$this->find_all_by('enrol_household_id',$household_id);
			$self=NULL;
			$husband=NULL;
			$wife=NULL;
			foreach($recs as $rec)
			{	
				
				if($rec->relation == 'Self')
				{	if($rec->lock != '2')
					$self=$self+1;
				}
				if($rec->relation == 'Wife')
				{	if($rec->lock != '2')
					$wife=$wife+1;
				}
				if($rec->relation == 'Husband')
				{	if($rec->lock != '2')
					$husband=$husband+1;
				}
				
				
			}
			
			
			if($self != 1) 
			{
				$date=date('d-m-Y',$hh->date);
				$self_duplicate{$household_id}[]=$date;
				$self_duplicate{$household_id}[]=$hh->agent;
				$self_duplicate{$household_id}[]=$self; // the count of self's
			}
			if($husband > 1) 
			{
				$date=date('d-m-Y',$hh->date);
				$husband_duplicate{$household_id}[]=$date;
				$husband_duplicate{$household_id}[]=$hh->agent;
				$husband_duplicate{$household_id}[]=$husband; // the count of husband's
			}	
			if($wife > 1) 
			{
				$date=date('d-m-Y',$hh->date);
				$wife_duplicate{$household_id}[]=$date;
				$wife_duplicate{$household_id}[]=$hh->agent;
				$wife_duplicate{$household_id}[]=$wife; // the count of wife's
			}	
					
			
		}
	
	return $duplicate = array('self'=>$self_duplicate,'husband'=>$husband_duplicate,'wife'=>$wife_duplicate);

	}
	
	function __count_helper($project_id, $fieldname, $appendstr='')
	{
		$this->CI_handle->load->model('enrol/enrol_household_model', 'household');
		$ret = array();
		$hhs = $this->CI_handle->household->find_all_by('enrol_project_id',$project_id);
		
		foreach($hhs as $hh)
		{
			$enrol_hh_id = $hh->id;
			$parameter = $hh->{"$fieldname"};
			
			if($rec = $this->find_all_by('enrol_household_id',$enrol_hh_id))
			{
				foreach($rec as $row)
				{
					$row->{"$fieldname"} = $parameter;
					if(empty($ret[$row->{"$fieldname"}.$appendstr]))
						$ret[$row->{"$fieldname"}.$appendstr]=1;
					if(array_key_exists($row->{"$fieldname"}.$appendstr, $ret))
						$ret[$row->{"$fieldname"}.$appendstr]=$ret[$row->{"$fieldname"}.$appendstr]+1;
					
				}
			}
		}
		return $ret;
	}

	function get_agent_wise_counts($project_id,$agent)
	{
		$ret = $this->__count_helper($project_id,'agent',' ');
		ksort($ret);
		return $ret;		
		
	}
	function get_village_wise_counts($project_id,$village)
	{
		$ret = $this->__count_helper($project_id,'village',' ');
		ksort($ret);
		return $ret;		
		
	}
	
}
?>
