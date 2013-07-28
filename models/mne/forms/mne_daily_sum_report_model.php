<?php 
	class mne_daily_sum_report_model extends IgnitedRecord 
	{ 
		var $table = "mne_daily_sum_report";
		var $subtables = array("mne_sum_payment","mne_sum_report");

		function mne_daily_sum_report_model()
		{
			parent::IgnitedRecord();
			$this->CI_handle =& get_instance();
		}

		function get_todays_latest_report()	
		{
			$ret = false;
			if($record = $this->find_by_sql('select max(id) as id from '.$this->table.' where date="'.date('Y-m-d').'"'))
			{
				if($latest = $this->find($record->id))
				{
					$ret['username'] = $latest->username;
					$ret['date']=$latest->date;
					$ret['comments']=$latest->comments;
					foreach($this->subtables as $subtab)
					{
						$this->CI_handle->load->model('mne/forms/'.$subtab.'_model',$subtab);
						$ret['rows'][$subtab] = $this->CI_handle->{$subtab}->get_summary($latest->id);
						$ret['columns'][$subtab] = $this->CI_handle->{$subtab}->get_columns();
					}
				}
			}
			
			return $ret;
		}
		//for Daily reports
		function get_todays_latest_report_for_mailing()	
		{
			$ret = false;
			if($record = $this->find_by_sql('select max(id) as id from '.$this->table.' where date="'.date('Y-m-d').'"'))
			{
				if($latest = $this->find($record->id))
				{
					$ret['username'] = $latest->username;
					$ret['date']=$latest->date;
					$ret['comments']=$latest->comments;
					foreach($this->subtables as $subtab)
					{
						$this->CI_handle->load->model('mne/forms/'.$subtab.'_model',$subtab);
						$ret['rows'][$subtab] = $this->CI_handle->{$subtab}->get_summary_for_latest_report($latest->id);
						$ret['columns'][$subtab] = $this->CI_handle->{$subtab}->get_columns();
					}
				}
			}
			
			return $ret;
		}
	}
