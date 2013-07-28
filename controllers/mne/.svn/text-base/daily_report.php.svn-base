<?php

class Daily_report extends CI_Controller {
	
	
	function send_mail()
	{
		$this->load->model('mne/forms/mne_daily_sum_report_model','daily_report');
		$ret = $this->daily_report->get_todays_latest_report();
		if($ret == false)
		{
			echo "not found";
			return;
		}
		
		$finalstr = $this->__daily_summary($ret);
		echo $finalstr;
		$fpath = $base_path.'test_'.time();
		$fp = fopen($fpath,"w");
		if(!fwrite($fp,$csv_string))
		{ 
			echo "CSV File could not be written";  
		}
		$this->load->library('email', $this->config->item('email_configurations'));  // email_configurations in module_constants.php
		$this->email->set_newline("\r\n");
		$this->email->from('hmis@sughavazhvu.co.in');
		$this->email->to('sangeetha.lakshmanan@ictph.org.in');
		$this->email->subject('Daily Summary');
		$this->email->message($finalstr);
	  	$this->email->attach($fpath);
		if($this->email->send()) {
			//echo 'Email sent.';
		}
		//$this->load->library('mail_util');
		//$mail_sent = Mail_util::send('sangeetha.lakshmanan@ictph.org.in','Daily Summary',$finalstr,'html',$fpath,'text/plain');	
	}
	
	function __daily_summary($ret)
	{
		$subtabs = array('mne_sum_report'=>'Operation Summary', 'mne_sum_payment'=>'Payment Summary');
		$finalstr = "<html><body><table><tr><td>Reporter:</td><td>".$ret['username']."</td></tr><tr><td>Date:</td><td>".$ret['date']."</td></tr><table>";
		foreach($subtabs as $subt=>$caption)
		{
			$finalstr.="<table border=\"1px\"><caption>".$caption."</caption><tr><th>Location</th>";
			foreach($ret['columns'][$subt] as $col)
				$finalstr.="<th>".$col."</th>";
			$finalstr.="</tr>";
			
			//Now fill the values
			foreach($ret['rows'][$subt] as $loc=>$row)
			{
				$finalstr.="<tr><td>".mb_convert_case($loc,MB_CASE_TITLE)."</td>";
				foreach($row as $k=>$v)
					$finalstr.="<td>$v</td>";
				$finalstr.="</tr>";	
			}
				
			$finalstr.="</table>";
			
		}
		$comment = preg_replace('/\n/','<br/>',$ret['comments']);
		$finalstr.="<br/><b>Comment</b><br/><p>".$comment."</p></body></html>";
		return $finalstr;
	}

	
}
