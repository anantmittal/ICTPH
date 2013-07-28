<?php
class chw_group extends CI_Controller {
	function create() {

	}

	function show_chws() {
		//@todo : remove this method as this only for showing chws and creating group functionality
		$this->load->model ( 'chw/chw_model', 'chw' );
		$chws = $this->chw->find_all ();
		$data ['chw_obj'] = $chws;

		$this->load->view ( 'chw/z_chws_list', $data );

	/*echo '<pre>';
		print_r($chws);
		echo '<pre>';*/
	}

	function add_members() {

		if (! isset ( $_POST ['group_name'] )) {
			echo 'Group name is not entered';
			return;
		} elseif (! isset ( $_POST ['chw_ids'] )) {
			echo 'chws not selected';
			return;
		}
		$this->load->model ( 'chw/chw_group_model', 'chw_group' );
		$this->load->model ( 'chw/chw_group_member_model', 'group_member' );

		$chw_ids = $this->input->post ( 'chw_ids' );
		$group_name = $this->input->post ( 'group_name' );
		$group_desc= $this->input->post ( 'group_desc' );
		$group_type = $this->input->post ( 'group_type' );

		if ($group_type == 'new') {
			$data ['name'] = $group_name;
			$data ['description'] = $group_desc;

			$chw_group = $this->chw_group->new_record ( $data );
			$result = $chw_group->save ();
			if ($result == true)
			{	$msg = 'Group: '.$chw_group->name.' created';}
			else {
				$msg = 'Error occured while creating new group';
    				$this->session->set_userdata('msg', $msg);
				$this->load->view ( 'chw/chw/search_by_name/ALL');
				return;
			}
			unset ( $data ['name'] );
			$data ['chw_group_id'] = $chw_group->uid ();
		} else {
			$chw_group = $this->chw_group->find_by ( 'name', $group_name );
			if ($chw_group == false) {
				echo 'Error : no group by name "' . $group_name . '" found in database.';
				return;
			}
			$data ['chw_group_id'] = $chw_group->id;

		//			echo '<pre>';
		//			print_r($chw_group);
		//			echo '<pre>';
		}

		foreach ( $chw_ids as $id ) {
			$data ['chw_id'] = $id;
			$group_member = $this->group_member->new_record ( $data );
			$result = $result AND $group_member->save ();
		}
		if($result)
		{
    			$this->session->set_userdata('msg', $msg);
			redirect('/chw/search/home');
		}
		else
		{
    			$this->session->set_userdata('msg', 'Error in adding members to group: '.$group_name);
			$this->load->view ( 'chw/chw/search_by_name/ALL');
		}
	}

	function edit() {

	}

	function remove_members() {

	}

	function listing() {
		$this->load->model ( 'chw/chw_group_model', 'chw_group' );
		$chw_groups = $this->chw_group->find_all ();
		$data ['chw_groups'] = &$chw_groups;
		/*echo '<pre>';
		print_r($chw_groups);
		echo '<pre>';*/
		$this->load->view ( 'chw/chw_groups_list_resp', $data );
	}

	function search_by_name($name = '') {
		
		$this->load->model ( 'chw/chw_group_model', 'chw_group' );
		if($name =="ALL")
		{
			$chw_groups = $this->chw_group->find_all();
		}
		else
		{
			$chw_groups = $this->chw_group->like ( 'name', $name)->find_all();
		}
		$data ['chw_group_obj'] = $chw_groups;

		$this->load->view ( 'chw/z_chw_groups_list', $data );
	}

	function view()
	{
		$url = "/chw/chw_group/member_listing/".$_POST['id_list'];
		redirect($url);
	}
		

	function member_listing($group_id = 0) {
		$this->load->model ( 'chw/chw_group_member_model', 'group_member' );
		$this->load->model ( 'chw/chw_group_model', 'chw_group' );

		if ($group_id == 0 || !$this->group_member->find_by('chw_group_id', $group_id)) {
			$msg = 'Invalid group '.$group_id;
    			$this->session->set_userdata('msg', $msg);
			redirect('/chw/search/home/');
//			echo 'group id is not send in url';
//			return;
		}


		if (! isset ( $_POST ['submit'] )) {
			$group_members_members = $this->group_member->select ( array ('chws.name AS chw_name' ) )->from ( 'chws' )->where ( 'chw_group_members.chw_id', 'chws.id', false )->where ( 'chw_group_members.chw_group_id', $group_id, false )->find_all ();

			$data ['members'] = &$group_members_members;
			$data ['chw_group'] = $this->chw_group->find($group_id);
			$this->load->view ( 'chw/chw_group_members_list_resp', $data );

		} else {

//			echo 'POST array<pre>';
//			print_r ( $_POST );
//			echo '<pre>';
$tx_status = true;
$this->db->trans_begin();
			$records = $this->input->post('records');
			foreach($records as $record) {
				if(isset($record['state'])) {
//					print_r($record);
					$group_member = $this->group_member->find($record['id']);
//					echo '<br> Record Deleted :'.$record['id']. ' with Group id : '.$group_member->chw_group_id;
//					echo '  CHW ID : '.$group_member->chw_id;
//					$group_member->delete();
					if(!$group_member->delete())
					{
						$msg = '  CHW ID : '.$group_member->chw_id.' could not be deleted';
						$tx_status = false;
					}
				}
			}
    	  if($tx_status == true)
    	  {
       		$this->db->trans_commit();
    		$this->session->set_userdata('msg', 'Members deleted successfully');
		redirect('/chw/chw_group/member_listing/'.$group_id);
		
    	  }
    	  else {
       		$this->db->trans_rollback();
    		$this->session->set_userdata('msg', $msg);
		redirect('/chw/chw_group/member_listing/'.$group_id);
    	  }
		}

	}
}
?>
