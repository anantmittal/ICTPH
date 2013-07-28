<?php
class survey extends CI_Controller {
	public $form_data;

  	function index() {
    		if($this->session->userdata('username')!=null) {
      		$this->load->view('mne/survey_home');
    		} else {
      		redirect('/session/session/login');
    		}
  	}	

	function create() {

		if(!$_POST)
		{
			$this->load->view('mne/create_survey_req');
		}
		else
		{
			$this->load->model('mne/survey_model', 'survey');
			$survey_rec = $this->survey->new_record($_POST);
			if($survey_rec->save())
			{
      				$this->session->set_userdata('msg', 'Added Survey Name'.$survey_rec->name.' with id '. $survey_rec->id);
				redirect('/mne/survey/index');
			}
			else
			{
      				$this->session->set_userdata('msg', 'Could not add Survey with name'.$_POST['name']);
				redirect('/mne/survey/index');
			}
		}
	}

	/**
	 * @todo : add pagination support for listing
	 *
	 */
	function list_() {
		$this->load->model('mne/survey_model', 'survey');
		$surveys = $this->survey->find_all();

		$this->form_data['surveys'] = $surveys;
		$this->load->view('mne/survey_list', $this->form_data);
	}

	function show($id = 0) {
		$this->load->model('mne/survey_model', 'survey');
		$this->form_data['survey'] = $this->survey->find($id);
		$this->load->model('mne/form_model', 'form');
		$this->form_data['forms'] = $this->form->get_all_forms($id);
/*							from('survey_forms')
							->where('survey_forms.survey_id',$id,'false')
							->where('survey_forms.form_id','forms.id','false')
							->find_all();*/
		$this->load->model('mne/survey_run_model', 'survey_run');
		$runs = $this->survey_run->find_all_by('survey_id',$id,'false');
		$this->load->model('geo/state_model','state');
		$this->load->model('geo/district_model','district');
		$this->load->model('geo/taluka_model','taluka');
		$this->load->model('geo/village_citie_model','village_citie');
		$this->load->model('geo/area_model','area');
		foreach($runs as $run)
		{
/*			$this->load->model('geo/'.$run->geography_type.'_model','object');
			$run->geo_name = $this->object->find($run->geo_id)->name;
*/
			$run->geo_name = $this->{$run->geography_type}->find($run->geo_id)->name;
		}
		$this->form_data['runs'] = $runs;
		$this->load->library('date_util');
		$this->load->view('mne/survey_show', $this->form_data);
	}

	function create_run() {

		if(!$_POST)
		{
			$this->form_data['staff_types'] = array('CHW' => 'CHW','surveyor' => 'Surveyor');
			$this->form_data['states'] = $this->get_array('states');
			$this->form_data['surveys'] = $this->get_array('surveys');
			$this->form_data['geos'] = $this->config->item('geos');
			$this->load->view('mne/create_survey_run', $this->form_data);
		}
		else
		{
			$this->load->model('mne/survey_run_model', 'survey_run');
			$sr_rec = $this->survey_run->new_record($_POST);
			$geo_var = $_POST['geography_type'].'_id';
			$sr_rec->geo_id = $_POST[$geo_var];
    			$this->load->helper('date');  
			$this->load->library('date_util');
			$sr_rec->start_date= Date_util::to_sql($_POST['start_date']);
			$sr_rec->end_date= Date_util::to_sql($_POST['end_date']);
			if($sr_rec->save())
			{
      				$this->session->set_userdata('msg', 'Added Survey Run '.$sr_rec->name.' for survey with id '. $sr_rec->survey_id);
				redirect('/mne/survey/index');
			}
			else
			{
      				$this->session->set_userdata('msg', 'Could not add Survey with name'.$_POST['name']);
				redirect('/mne/survey/index');
			}
		}
	}


	function add_data($survey_run_id = 0) {

	}

	function get_array($type) {
		$objs = array ();
		$obj = IgnitedRecord::factory ($type );
		$rows = $obj->find_all ();
		foreach ( $rows as $row ) {
			$objs [$row->id] = $row->name;
		}
		return $objs;
	}

}
?>
