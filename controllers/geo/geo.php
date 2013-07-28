<?php
class geo extends CI_Controller {

	public $form_data = array ();

  	function home() {
    		if($this->session->userdata('username')!=null) {
      			$this->load->view('geo/home');
    		} else {
      			redirect('/session/session/login');
    		}
  	}
  
	function add($type, $higher) {
		
		$this->form_data ['states'] = $this->get_objects('states');
		$this->form_data ['districts'] = $this->get_objects('districts');
		$this->form_data ['talukas'] = $this->get_objects('talukas');
		$this->form_data ['village_cities'] = $this->get_objects('village_cities');
		$this->form_data ['type'] = $type;
		$this->form_data ['higher'] = $higher;
        
		if (! isset( $_POST ['name'] ))  {
			$this->load->view ( 'geo/geo_add', $this->form_data );
		} else {
			$geo_name = $_POST['name'];
			$this->load->model ( 'geo/'.$type.'_model','obj_model' );
			$add_geo_value = $this->obj_model->where('name', $geo_name, true)->find();
			if($add_geo_value!=null){
				$msg=ucwords($geo_name).' already exists ';
				$this->session->set_userdata('msg', ucwords($geo_name).' already exists ');
				$this->load->view ( 'geo/geo_add', $this->form_data );
			}else{
				$this->load->model ( 'geo/'.$type.'_model','obj_model' );
				$rec = $this->obj_model->new_record ( $_POST );
				if($rec->save ()){
	    			$this->session->set_userdata('msg', 'A '.$type.' with name '.$rec->name.' saved successfully with id '.$rec->id);
					redirect('/geo/geo/home');
				}else{
	    				$this->session->set_userdata('msg', 'Failed to save a '.$type.' with name '.$rec->name);
					$this->load->view ( 'geo/geo_add', $this->form_data );
				}
			}
		}
	}

	function edit_()
	{
		$url = "/geo/geo/edit/".$_POST['type'].'/'.$_POST['id_edit'];
		redirect($url);
	}
		

	function edit($type ='',$id = '') {

		if ($id == '') {
			echo 'id should be enter to edit';
			return false;
		}

		$this->load->model ( 'geo/'.$type.'_model','obj_model' );
		$this->load->model ( 'geo/district_model','district' );
		$this->load->model ( 'geo/taluka_model','taluka' );
		$this->load->model ( 'geo/state_model','state' );
		$this->load->model ( 'geo/village_citie_model','village_citie' );
		$this->form_data ['streets'] = $this->get_objects('streets');
		$this->form_data ['states'] = $this->get_objects('states');
		$this->form_data ['districts'] = $this->get_objects('districts');
		$this->form_data ['talukas'] = $this->get_objects('talukas');
		$this->form_data ['village_cities'] = $this->get_objects('village_cities');
		$this->form_data ['type'] = $type;

		$obj = $this->obj_model->find ( $id );
		$get_vc_rec = $this->village_citie->find_by('id',$id);
		if(!empty($get_vc_rec)){
			if($get_vc_rec->code == -1){
				$url = "/geo/geo/home/";
				redirect($url);
			}
		}	
		
		$this->form_data ['obj'] = $obj;

		if (! isset ( $_POST ['name'] ) ) {
			if(isset ( $obj->village_city_id )){
				$ids= $obj->village_city_id;
			    $taluka_id=$this->village_citie->where('id', $ids, true)->find();
			    $taluka_ids= $taluka_id->taluka_id;
			    $district_id=$this->taluka->where('id', $taluka_ids, true)->find();
			     $district_ids=$district_id->district_id;
			     $state_id=$this->district->where('id', $district_ids, true)->find();
			     $state_ids=$state_id->state_id;
			     $this->form_data ['chw_obj1'] = $taluka_id;
			     $this->form_data ['chw_obj2'] = $district_id;
			     $this->form_data ['chw_obj3'] = $state_id;
			     $this->form_data ['chw_obj4'] = $obj;
				$this->load->view ( 'geo/geo_add', $this->form_data );
			}
			else if(isset ($obj->taluka_id)){
				$taluka_ids= $obj->taluka_id;
			    $district_id=$this->taluka->where('id', $taluka_ids, true)->find();
			     $district_ids=$district_id->district_id;
			     $state_id=$this->district->where('id', $district_ids, true)->find();
			     $this->form_data ['chw_obj1'] = $obj;
			     $this->form_data ['chw_obj2'] = $district_id;
			     $this->form_data ['chw_obj3'] = $state_id;
				 $this->load->view ( 'geo/geo_add', $this->form_data );
			}
			else if(isset ($obj->district_id)){
				$district_ids= $obj->district_id;
				$state_id=$this->district->where('id', $district_ids, true)->find();
			     $this->form_data ['chw_obj2'] = $obj;
			     $this->form_data ['chw_obj3'] = $state_id;
				$this->load->view ( 'geo/geo_add', $this->form_data );
				
			}
		    else if(isset ($obj->state_id)){
				$state_ids= $obj->state_id;
 			    $this->form_data ['chw_obj3'] = $obj;
				$this->load->view ( 'geo/geo_add', $this->form_data );
				
			}
			else{
				$this->load->view ( 'geo/geo_add', $this->form_data );
			}
		} else {
			$geo_name = $_POST['name'];
			$this->load->model ( 'geo/'.$type.'_model','obj_model' );
			$add_geo_value = $this->obj_model->where('name', $geo_name, true)->find();
			if($add_geo_value!=null){
				$msg=ucwords($geo_name).' already exists ';
				$this->session->set_userdata('msg', ucwords($geo_name).' already exists ');
				$this->load->view ( 'geo/geo_add', $this->form_data );
			}else{
				$obj->load_postdata ( array ('name', 'state_id', 'taluka_id','district_id', 'village_city_id', 'code') );
				if($obj->save ()){
	    				$this->session->set_userdata('msg', $type.': '.$obj->name.' saved successfully');
					redirect('/geo/geo/home');
				}else{
	    				$this->session->set_userdata('msg', $type.': '.$obj->name.' saved unsuccessful');
					$this->load->view ( 'geo/geo_add', $this->form_data );
				}
			}
		}
	}

	function get_objects($type) {
		$objects = array ();
		$objs = IgnitedRecord::factory ( $type );
		$o_rows = $objs->find_all ();
		foreach ( $o_rows as $o_row ) {
			$objects [$o_row->id] = $o_row->name;
		}
		return $objects;
	}


}
?>
