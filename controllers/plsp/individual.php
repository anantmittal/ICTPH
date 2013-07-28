<?php

class Individual extends CI_Controller {
	
	
	function AddToHousehold($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->load->database();
		$this->load->library('form_validation');
			
		$this->form_validation->set_rules('indiId', 'Individual ID', 'trim|required|callback_id_check');
		$this->form_validation->set_rules('indiFirstName', 'First Name', 'trim|required');
		$data['indiId']=$id;
		$query = $this->db->query("SELECT door_no,street,hamlet,village FROM plsp_master_list where cust_id=\"".$id."\"");
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data['door_no']=$row->door_no;
				$data['street']=$row->street;
				$data['hamlet']=$row->hamlet;
				$data['village']=$row->village;
				break;
			}
		}
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('survey/plsp/individualentry',$data);
		}
	}

	function EditIndividual($id)
	{
		$this->load->helper(array('form', 'url'));
		$this->load->database();
		$this->load->library('form_validation');
			
		$this->form_validation->set_rules('indiId', 'Individual ID', 'trim|required|callback_id_check');
		$this->form_validation->set_rules('indiFirstName', 'First Name', 'trim|required');
		$data['indiId']=$id;
		$query = $this->db->query("SELECT * FROM plsp_master_list where individual_id=\"".$id."\"");
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$data['firstName']=$row->first_name;
				$data['lastName']=$row->last_name;
				$data['dob']=$row->dob;
				$data['gender']=$row->gender;
				$data['door_no']=$row->door_no;
				$data['street']=$row->street;
				$data['hamlet']=$row->hamlet;
				$data['village']=$row->village;
				$data['phone']=$row->phone;
				$date['relationship']=$row->relationship;
				break;
			}
		}
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('survey/plsp/individualentry',$data);
		}
	}
}
?>
