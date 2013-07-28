<?php
class Replicate extends CI_Controller
{
  public function Replicate()
  {
    parent::__construct();

    log_message('debug', 'Base path = ['.$this->config->item('path')."]\n");
    //    $this->load->library('session', array("cookie_path" => $this->config->item('path')));
    $this->load->library('session');
    $this->load->library('ignitedrecord/ignitedrecord');
    $this->load->model('user/user_model','user');
    $this->load->model('user/role_model','role');
    $this->load->model('user/users_role_model','user_role');
    $this->load->model('repl/sql_run_model','sql_run');
    $this->load->helper('url');
    $this->load->library('date_util');
    $this->load->library('curl_util');
  }

  public function start() {
    $redirect_url = str_replace("/session/session/login", "", $this->uri->uri_string());

    // TODO - change this to the basic Search page
    if (!$_POST) {
      $this->load->view('session/login');
      return;
    }
     
    // Is a post request
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = md5($password);
/*
    $user = $this->user->find_by('username', $username);
    if (!$user || $user->password_hash != $password_hash) {
	$error = "Invalid username or password";
	$this->session->set_userdata('msg', $error);
	$this->load->view('repl/home');
	return;
    }

    $url = $this->config->item('server_path').'index.php/repl/s_replicate/auth';
    $form_data = array('machine_id' => $this->config->item('machine_id'),'username' => $username,'password' => $password_hash);
 
$form_data = urlencode('serverid').'='.urlencode($this->config->item('machine_id')).'&'.urlencode('username').'='.urlencode($username).'&'.urlencode('password').'='.urlencode($password_hash);
	$defaults = array(
	CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.3) Gecko/20091020 Ubuntu/9.10 (karmic) Firefox/3.5.3',
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
	CURLOPT_COOKIEJAR  => '/tmp/cookies.txt',  
	CURLOPT_COOKIEFILE => '/tmp/cookies2.txt',  
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_SSL_VERIFYHOST => 2
    	);

    	$ch = curl_init();
    	curl_setopt_array($ch, $defaults);
	curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$form_data);
    	if( ! $result = curl_exec($ch))
    	if( ! $result = Curl_util::submit_form($url, $form_data))
    	{
		$error = "Invalid username or password";
		$this->session->set_userdata('msg', $error);
    		curl_close($ch);
		$this->load->view('repl/home');
		return;
//        	trigger_error(curl_error($ch));
//		echo "error 1";
    	}*/
//	$run_query = $this->db->query('USE '.$this->config->item('repl_db').'; select MAX(timestamp) as timestamp from sql_runs where (machine_id=0 AND completed=1 AND type="Tx")');

    	$run_query = $this->db->query('select MAX(timestamp) as timestamp from sql_runs where (machine_id=1000 AND completed="Yes" AND type="Tx")');
	$start_time = $run_query->row()->timestamp;
	$end_time = Date_util::timestamp();
//$insert_query = $this->db->query('insert into sql_runs ("machine_id","username","timestamp","type","completed") values (0,'.$username.','.$end_time.',"Tx",0);');
	$sql_tx = $this->sql_run->new_record();
	$sql_tx->machine_id = 1000;
	$sql_tx->timestamp = $end_time;
	$sql_tx->username = $username;
	$sql_tx->save();
	$sql_tx->file_name = $sql_tx->id.'-tx.sql';
	$sql_tx->save();
	$tx_filename = $this->config->item('sql_tx_folder').$sql_tx->file_name;

/*	$sql_id = $insert_query->row()->id;
$update_query = $this->db->query('update sql_runs SET filename = '.$filename.' where id = '.$sql_id);
	$filename = $sql_id.'-tx.sql';
	$tx_filename = $this->config->item('sql_tx_folder').$filename;*/

	$sql_gen = '/usr/bin/mysqlbinlog --database='.$this->config->item('db_to_be_repl').' --start-datetime="'.$start_time.'" --stop-datetime="'.$end_time.'" --result-file='.$tx_filename.' /var/log/mysql/mysql-bin.0*';
//	$sql_gen = '/usr/bin/mysqlbinlog --host="localhost" --port="3306" --user="root" --password="vande" --result-file="'.$tx_filename.'" /var/log/mysql/mysql-bin.0*';
//	$sql_gen = 'bash '.$this->config->item('repl_script').' '.$this->config->item('db_to_be_repl').' "'.$start_time.'" "'.$end_time.'" '.$tx_filename;
//	echo $sql_gen;
//	$result2 = exec($sql_gen,$out,$result);
//	$result2 = 0;
	$result = shell_exec($sql_gen);
	if($result)
	{
		$error = "SQL File generation failed";
		$this->session->set_userdata('msg', $error);
		$this->load->view('repl/home');
		return;
	}
	shell_exec('bzip2 '.$tx_filename);

/*
	$form_data = array('machine_id' => "1 \n");
	$form_data['username'] = "sundeep";
	$form_data['password'] = "vande";
	$form_data['filename'] = "@$tx_filename";*/
//	$form_data = array('machine_id' => '"'.$this->config->item('machine_id').' \n"','username' => '"'.$username.' \n"','password' => '"'.$password_hash.' \n"','filename' => "@$tx_filename");
//	$form_data = array('machine_id' => $this->config->item('machine_id'),'username' => $username,'password' => $password_hash);
	
	$fp = fopen($tx_filename.'.bz2','rb');
	$sql_query = fread($fp,filesize($tx_filename.'.bz2'));
	fclose($fp);
	$sql_query = base64_encode($sql_query);
//	$sql_query = file_get_contents($tx_filename);
//	$form_data = array('machine_id' => $this->config->item('machine_id'),'username' => $username,'password' => $password_hash,'filename' => "@$tx_filename");

	$url = $this->config->item('server_path').'index.php/repl/s_replicate/rx_sql';
	$form_data = array('machine_id' => $this->config->item('machine_id'),'username' => $username,'password' => $password_hash,'sql' => $sql_query);
	$result = Curl_util::submit_form($url, $form_data);

	$five = substr($result,5,5); // dont know why, but first 5 characters are empty
	$pos = stripos($result,'error');
//	if($pos == 0)
	if(strcmp($five,'error') !=0)
	{
		//confirms receipt of sql by server

		$sql_tx->completed= 'Yes';
		$sql_tx->save();

		// Process sql that has been received
   		$fp = fopen($this->config->item('sql_rx_folder').'tmpfile.sql.bz2','wb');
   		$sql_rx = base64_decode($result,true);
   		fwrite($fp,$sql_rx);
   		fclose($fp);
   		$rm_ret = shell_exec('rm '.$this->config->item('sql_rx_folder').'tmpfile.sql');
   		$bz_ret = shell_exec('bunzip2 '.$this->config->item('sql_rx_folder').'tmpfile.sql.bz2');
//   		$app_ret = shell_exec('echo -e "SET sql_bin_log=0; \n $(cat '.$this->config->item('sql_rx_folder').'tmpfile.sql) \n SET sql_log_bin=1;" > '.$this->config->item('sql_rx_folder').'tmpfile.sql');
   		$sql_ret = shell_exec('mysql --user='.$this->config->item('db_user').' --password='.$this->config->item('db_password').' --force < '.$this->config->item('sql_rx_folder').'tmpfile.sql' );

		// Save record
	   	$sql_rx = $this->sql_run->new_record();
   		$sql_rx->machine_id = 1000;
   		$sql_rx->timestamp = Date_util::timestamp();
   		$sql_rx->username = $username;
   		$sql_rx->type= 'Rx';
   		$sql_rx->completed= 'Yes';
   		$sql_rx->save();
   		$filename = $sql_rx->id.'-rx.sql';
   		$sql_rx->file_name = $filename;
   		shell_exec('mv '.$this->config->item('sql_rx_folder').'tmpfile.sql '.$this->config->item('sql_rx_folder').$filename);
   		$sql_rx->save();

		// send file received confirmation
		$url2 = $this->config->item('server_path').'index.php/repl/s_replicate/cf_rx';
		$form2_data = array('machine_id' => $this->config->item('machine_id'),'username' => $username,'password' => $password_hash,'time' => $end_time);
		$result2 = Curl_util::submit_form($url2, $form2_data);

//   		$return_msg = ' SQL received successfully. five='.$five.'pos='.$pos.'result='.$result.'Record Saved bz_ret  = '.$bz_ret. ' sql_ret ='.$sql_ret ;
   		$return_msg = ' SQL received successfully. Record Saved bz_ret  = '.$bz_ret. ' sql_ret ='.$sql_ret ;
		$error = 'File accepted.  Result: '.$return_msg;
		$this->session->set_userdata('msg', $error);
		$this->load->view('repl/home');
		return true;
	}
	else
	{
		$error = 'File not accepted. Result: '.$result;
		$this->session->set_userdata('msg', $error);
		$this->load->view('repl/home');
		return false;
	}
  }

  function logout() {
    // TODO Add more
    $this->session->unset_userdata('username');
    $this->session->sess_destroy();
	redirect('/session/session/login');
//      $this->load->view('session/login');
  }
}
//end of controller
