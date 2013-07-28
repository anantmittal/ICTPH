<?php
include (APPPATH.'libraries/CustomTree.php');
class Opd_configuration extends CI_Controller{
	function __construct() {
	    parent::__construct();
	    
    	$this->load->model('chw/protocol_information_model','protocol_information');
    	$this->load->model('opd/provider_location_model', 'provider_location');
    	$this->load->model('opd/provider_model', 'provider');
    	$this->load->model('geo/village_citie_model', 'village_citie');
    	$this->load->model('opd/visit_protocol_information_entry_model', 'visit_protocol_information_entry');
    	$this->load->model('opd/visit_model','visit');
    	$this->load->library('opd/problem_dom_displayer');
    	$this->load->dbutil();
    	$this->load->library('date_util');
    	$this->load->library('utils');
    	$this->load->helper('url');  
    	$this->load->helper('date');  
    	$this->load->helper('file');
    	
    	$this->username = $this->session->userdata('username');
	 }
  
	 function create_protocol_information_report() {
	 	$report_name='protocol_configuration_report';
	 	$model_name='protocol_information';
	 	$this->opd_configuration_report($report_name,$model_name);
	 }
	 
	 
	 
  function opd_configuration_report($report_name,$model_name) {
		if($this->session->userdata('username')!=null) {
			$provider = $this->provider->find_by('username', $this->username);
	    	$locations = array();
	    	$villages = array();
			$villages['0'] = 'All';
	    	$loc_recs = $provider->related('provider_locations')->get();
	    	foreach($loc_recs as $loc_rec){
				$locations[$loc_rec->id] = $loc_rec->name;
	    	}
	    	$this->session->set_userdata('locations',$locations);
	    	if($this->session->userdata('location_id')!=null) {
				$pl_rec = $this->provider_location->find($this->session->userdata('location_id'));
				$vc_recs = $this->village_citie->find_all_by('code',$pl_rec->cachment_code);
	    		foreach($vc_recs as $vc_rec){
					$villages[$vc_rec->id] = $vc_rec->name;
	    	  	}
	    	}else{
	    		foreach($loc_recs as $loc_rec){
					$pl_rec = $this->provider_location->find($loc_rec->id);
					$vc_recs = $this->village_citie->find_all_by('code',$pl_rec->cachment_code);
	    			foreach($vc_recs as $vc_rec){
						$villages[$vc_rec->id] = $vc_rec->name;
	    	  		}
				}
				$vc_recs = $this->village_citie->find_all_by('code','ALL');
	    		foreach($vc_recs as $vc_rec){
					$villages[$vc_rec->id] = $vc_rec->name;
	    		}
			}
			$this->data['villages'] = $villages;
		}   	
  	
  		if(!$_POST){
	  		$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			    
			
			//generalized code to fetch respective pe /ros/pi tree
			
			$this->data[$model_name.'_tree'] = $this->$model_name->get_tree();
			$this->load->view ( 'opd/'.$report_name,$this->data);
			
	  	}else{
	  		$from_date = Date_util::change_date_format($_POST['from_date']);
			$to_date = Date_util::change_date_format($_POST['to_date']);
			$location_id = $_POST['provider_location_id'];
		    
			//$_POST['protocol_information'];

			//separate code for pe/ros/pi 
			if($report_name=='protocol_configuration_report'){
				$json_struct=$this->visit_protocol_information_entry->show_selected_values($_POST["protocol_information"]);	 
			    $base_path = $this->config->item('base_path').'uploads/visits/configuration_report/protocol_configuration_report/';
	            $protocol_visits_filename = 'protocol-visit-report-'.$_POST['provider_location_id'].'-'.$from_date.'-'.$to_date.'.csv';
	            $protocol_visits_query ='select visits.date as date,  visit_protocol_information_entries.id as visit_protocol_id,visit_id, visit_protocol_information_entries.name as protocol_name, status, details from (visits,visit_protocol_information_entries) where (visit_id = visits.id) AND  (provider_location_id LIKE "'.$location_id.'") AND (date between "'.$from_date.'" and "'.$to_date.'") ORDER BY date ASC';
	            $query = $this->db->query($protocol_visits_query);
	            $root_parent_name='protocol_name';
			}
			
            if($query->num_rows() !=0){
	            $visit_string ='( ';
				$i=0;
				 $json_struct=$this->get_value($json_struct);
				 $json_structure= str_replace('~',',',$json_struct);
				 $json_structure= str_replace('=','',$json_structure);
				$csv_visits_result = ' Visit Id,Patient Id, Location, Provider Name,T,P,RR,BPS,BPD,BMI,Wt,Ht,WHR,Wst,Hip,HC,UAC,Distance(R),Distance(L),Near Vision,Cataract,Visit Date, '.$json_structure."\n";
	            foreach ($query->result() as $visit_rec){
				    $protocol_string ='';
				    $protocol_details='';
				    $selected=false;
		      		if ($visit_rec->status == 'NA'){
		      			continue;
			    	}
				   $protocol_details =','.$visit_rec->details;
				    
				     $separate_root_json=explode('~',$json_struct);
			    	 foreach($separate_root_json as $separate_json){
			    		 $json_selected_names=explode(',',$separate_json);
			    		 for($j=0;$j<sizeof($json_selected_names);$j=$j+1){
			    		 	  $protocol=$this->get_value($protocol_details);
							 $name=trim($json_selected_names[$j]);
								
							if(strpos($name,'|') && !strpos($name,'_') && strtolower($visit_rec->$root_parent_name)==trim($json_selected_names[0])){ //to show selected radio button in report 
								$radio_val=explode('|',$name);
								foreach($radio_val as $radio_name){
									if(!empty($radio_name)){ 
										$pos = strpos($protocol,trim($radio_name));
										if($pos==true){
											$selected=true;
											$protocol_string = $protocol_string.$radio_name.'';
										}
									}else{                             //to prevent values overlapping in a single column
										$radio_name=$radio_name."@#$%^&*";
										$pos = strpos($protocol,$radio_name);
									}
								}
							}else if(strpos($name,'|') && strpos($name,'_') && strtolower($visit_rec->$root_parent_name)==trim($json_selected_names[0])){//to show select value in report 
								 $select_val=explode('|',$name);
								 $select_val=str_replace('_',',',$select_val);
								foreach($select_val as $select_name){
									if(!empty($select_name)){ 
										$pos = strpos($protocol,$select_name);
										if($pos==true){
											$selected=true;
											$select_name=str_replace(',','_',$select_name);
											$exact_select_name=explode('_',$select_name);
											$protocol_string = $protocol_string.$exact_select_name[0].'';
										}
									}else{ //to prevent values overlapping in a single column
										$select_name=$select_name."@#$%^&*";
										$pos = strpos($protocol,$select_name);
									}
								}
							}/*else if(!strpos($name,'|') && !strpos($name,'_') && strpos($name,'=')){//to show textbox value in report (fill values in assessment tab and protocol configuration)
								$select_val=explode('=',$name);
								$val=explode(',',$protocol);
								foreach($val as $value){
									 if($prot_value=strpos($value,'=')){
									 	$value=explode('=',$value);
									 	$position = strcmp(strtolower(trim($value[0])),strtolower(trim($select_val[0])));
									 	if($position==0){
									 		$selected=true;
									 		$protocol_string = $protocol_string.$value[1].'';
									 	}	
									 }
								}
							}*/else{                                            //to show checkbox value in report 
								if(!empty($name) && strtolower($visit_rec->$root_parent_name)==trim($json_selected_names[0])){
									//echo $name.'--';
									//echo strpos(' abcd-123','dc-123');
									//echo $protocol;
									$pos = strpos($protocol,strtolower($name));
									if($pos==true){
										$selected=true;
										$protocol_string = $protocol_string.$name.',';
									}
								}else{ //to prevent values overlapping in a single column
									$name=$name."@#$%^&*";
									$pos = strpos($protocol,$name);
								}
							}
						    if($pos === false){
							 	$protocol_string = $protocol_string.',';
							}
		    			 }
	            	}
            		//echo $protocol_string;
            		if($selected==true){
            			$visit_ids=array();
            			array_push($visit_ids,$visit_rec->visit_id);
            			$visit = $this->visit->find($visit_ids);
            			$location_id=$visit->provider_location_id;
            			$location_name = $this->provider_location->find_by('id',$location_id);
            			$provider_id=$visit->provider_id;
            			$provider_name = $this->provider->find_by('id',$provider_id);
		  				$visit_vitals = $visit->related('visit_vitals')->get();
		  				$visit_visuals=$visit->related('visit_visuals')->get();
		  				$vitals_string =  Utils::print_vitals_report($visit_vitals);
		  				$visuals_string =  Utils::print_visuals_report($visit_visuals);
            			$csv_visits_result = $csv_visits_result.$visit_rec->visit_id.','.$visit->person_id.','.$location_name->name.','.$provider_name->full_name.','.$vitals_string.','.$visuals_string.','.$visit_rec->date.','.$protocol_string."\n";
            		}		
	            }
	            $visit_string =$visit_string.')';
	            
	            
	            if($report_name=='protocol_configuration_report'){
		            if(!write_file($base_path.$protocol_visits_filename,$csv_visits_result)){
						echo "File could not be written";
					}
					$this->data['protocol_visits_filename'] = $protocol_visits_filename;
	            }
	            
	            
            }else{
				$this->data['no_data'] = true;
			}
			
			$this->data['from_date'] = 'DD/MM/YYYY';
			$this->data['to_date'] = 'DD/MM/YYYY';
			$this->data['from_date'] = Date_util::today();
			$this->data['to_date'] = $this->data['from_date'];
			$this->data[$model_name.'_tree'] = $this->$model_name->get_tree();
			$this->load->view ( 'opd/'.$report_name,$this->data);
	  	}
     }  

     
	function get_value($selected_name) {
		$patterns=array();
		$patterns[0] = '/children/';
		$patterns[1] = '/name/';
		$patterns[2] = '/[{}":]/';
		 $val=preg_replace($patterns,'', $selected_name);
		 $val=str_replace('[','',$val);	
		 $val=str_replace(']','',$val);
		return $val;
	}
	
	
}
