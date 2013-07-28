<?php
class location extends CI_Controller {

	public $form_data = array ();
	
	function __construct() {
    	parent::__construct();
    	$this->load->helper('geo');
	}

	function create() {

		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules ( 'name', 'Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		$this->form_data ['states'] = get_states ();
		$scm_orgs = $this->get_scmorgs();
		$scm_orgs['0'] = 'Create New';
		$this->form_data ['scm_orgs'] = $scm_orgs;
		$this->form_data ['type'] = 'add';

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'opd/location_add', $this->form_data );
		} else {
			$this->load->library ( 'date_util' );
			$this->load->model ( 'opd/provider_location_model','pl' );

			$pl_obj = $this->pl->new_record ( $_POST );
    $this->load->dbutil();
    $this->db->trans_begin();
    $tx_status = true;
			if($_POST['scm_org_id']==0)
			{
				$this->load->model ( 'scm/scm_organization_model','scm_org' );
				$org_obj = $this->scm_org->new_record();
				$org_obj->name = $_POST['name'];
				$org_obj->type = $_POST['type'];
				$org_obj->license_no = $_POST['registration_no'];
				$org_obj->phone_no = $_POST['phone_no'];
/*			$this->load->model('geo/village_citie_model','vc');
			$this->load->model('geo/taluka_model','taluka');
			$this->load->model('geo/district_model','district');
			$this->load->model('geo/state_model','state');
			$org_obj->address = $_POST['street_address']."\n".$this->vc->find($_POST['village_city_id'])->name."\nDistrict: ".$this->district->find($_POST['district_id'])->name."\n".$this->state->find($_POST['state_id'])->name;
*/
    			
				if($org_obj->save())
				{
					$pl_obj->scm_org_id = $org_obj->id;
				}
				else
				{
					$tx_status = false;
				}
			}
			if($pl_obj->save () && $tx_status)
			{
       	$this->db->trans_commit();
    				  $this->session->set_userdata('msg', 'Location: '.$pl_obj->name.' saved successfully with id: '.$pl_obj->id);
				  redirect('/opd/search/home');
			}
			else
			{
       $this->db->trans_rollback();
    				  $this->session->set_userdata('msg', 'Location: '.$pl_obj->name.' saved unsuccessful');
				  $this->load->view ( 'opd/location_add');
			}
		}
	}

	function edit_()
	{
		$url = "/opd/location/edit/".$_POST['c_id_edit'];
		redirect($url);
	}
		

	function edit($id = '') {

		if ($id == '') {
			echo 'id should be enter to edit';
			return false;
		}

		$this->load->library ( 'form_validation' );
		$this->load->model ( 'opd/provider_location_model','pl' );
		$this->form_data ['states'] = get_states ();
		$this->form_data ['scm_orgs'] = $this->get_scmorgs();
		$pl_obj = $this->pl->find ( $id );
		$this->form_data ['p_obj'] = & $pl_obj;
		$this->form_data ['type'] = 'edit';

		$this->form_validation->set_rules ( 'name', 'Name', 'required' );
		$this->form_validation->set_error_delimiters ( '<label class="error">', '</label>' );

		if (! isset ( $_POST ['name'] ) || $this->form_validation->run () == FALSE) {
			$this->load->view ( 'opd/location_add', $this->form_data );
		} else {

			$pl_obj->load_postdata ( array ('name', 'state_id', 'district_id', 'taluka_id','village_city_id', 'scm_org_id','street_address', 'phone_no','registration_no', 'affiliation','cachment_code' ) );

	/*	
			$this->load->model ( 'scm/scm_organization_model','scm_org' );
			$org_obj = $this->scm_org->find($pl_obj->scm_org_id);
			$org_obj->load_postdata ( array ('name', 'phone_no') );
			$org_obj->license_no = $_POST['registration_no'];
			$this->load->model('geo/village_citie_model','vc');
			$this->load->model('geo/taluka_model','taluka');
			$this->load->model('geo/district_model','district');
			$this->load->model('geo/state_model','state');
			$org_obj->address = $_POST['street_address']."\n".$this->vc->find($_POST['village_city_id'])->name."\nDistrict: ".$this->district->find($_POST['district_id'])->name."\n".$this->state->find($_POST['state_id'])->name;
*/

    $this->load->dbutil();
			$this->db->trans_begin();
//			if($org_obj->save() && $pl_obj->save ())
			if($pl_obj->save ())
			{
       	$this->db->trans_commit();
    				$this->session->set_userdata('msg', 'Location: '.$pl_obj->name.' saved successfully with id: '.$pl_obj->id);
				redirect('/opd/search/home');
			}
			else
			{
       	$this->db->trans_rollback();
    				$this->session->set_userdata('msg', 'Location: '.$pl_obj->name.' saved unsuccessful');
				$this->load->view ( 'opd/location_add');
			}
		}
	}

	function get_scmorgs() {
		$orgs = array ();
		$o_obj = IgnitedRecord::factory ( 'scm_organizations' );
		$o_rows = $o_obj->find_all ();
		foreach ( $o_rows as $o_obj ) {
			$orgs[$o_obj->id] = $o_obj->name;
		}
		return $orgs;
	}

	function search_by_name($name = '') {
		
		$this->load->model ( 'opd/provider_location_model', 'pl' );
		if($name =="ALL")
		{
			$pls = $this->pl->find_all();
		}
		else
		{
			$pls = $this->pl->like ( 'name', $name)->find_all();
		}

		$data ['p_obj'] = $pls;

		$this->load->view ( 'opd/z_locations_list', $data );
	}

	function search_by_geo($geo_type = '', $key = '') {
		
		$this->load->model ( 'opd/provider_location_model', 'pl' );

		if($geo_type =="village")
		{
			$this->load->model ('geo/village_citie_model','vc');
			$vcs = $this->vc->like('name',$key)->find_all();
			$vc_ids = '(';
			$i=0;
			foreach ($vcs as $vc)
			{
				if($i!=0)
					{$vc_ids = $vc_ids.',';}
				$vc_ids = $vc_ids.$vc->id;
			$i++;
			}
			$vc_ids = $vc_ids.')';
			$pls= $this->pl->find_all_by_sql("select * from provider_locations where village_city_id in ".$vc_ids.";");
		}

		if($geo_type =="taluka")
		{
			$this->load->model ('geo/taluka_model','taluka');
			$talukas = $this->taluka->like('name',$key)->find_all();
			$t_ids = '(';
			$i=0;
			foreach ($talukas as $t)
			{
				if($i!=0)
					{$t_ids = $t_ids.',';}
				$t_ids = $t_ids.$t->id;
			$i++;
			}
			$t_ids = $t_ids.')';
			$pls= $this->pl->find_all_by_sql("select * from provider_locations where taluka_id in ".$t_ids.";");
		}

		if($geo_type =="district")
		{
			$this->load->model ('geo/district_model','district');
			$districts = $this->district->like('name',$key)->find_all();
			$d_ids = '(';
			$i=0;
			foreach ($districts as $d)
			{
				if($i!=0)
					{$d_ids = $d_ids.',';}
				$d_ids = $d_ids.$d->id;
			$i++;
			}
			$d_ids = $d_ids.')';
			$pls= $this->pl->find_all_by_sql("select * from provider_locations where district_id in ".$d_ids.";");
		}

		$data ['p_obj'] = $pls;

		$this->load->view ( 'opd/z_locations_list', $data );
	}

}
?>
