<?php
class S_Replicate extends CI_Controller
{
  public function S_Replicate()
  {
    parent::__construct();

//    log_message('debug', 'Base path = ['.$this->config->item('path')."]\n");
    //    $this->load->library('session', array("cookie_path" => $this->config->item('path')));
    $this->load->library('session');
    $this->load->model('user/user_model','user');
    $this->load->model('repl/sql_run_model','sql_run');
    $this->load->helper('url');
    $this->load->library('date_util');
    $this->load->library('curl_util');
  }

  public function auth() {

    // TODO - change this to the basic Search page
    if (!$_POST) {
//      $this->load->view('session/login');
      return false;
    }
     
    // Is a post request
    $machine_id= $_POST['machine_id'];
    $username = $_POST['username'];
    $password_hash = $_POST['password'];
//    $password_hash = md5($password);

    $user = $this->user->find_by('username', $username);
    if (!$user || $user->password_hash != $password_hash) {
	$error = "Invalid username or password";
//	$this->session->set_userdata('msg', $error);
//	$this->load->view('repl/home');
	return $error;
    }
    
    return true;

  }

  public function rx_sql() {

    $return_msg = 'error ';
//  $return_msg .= 'entered rx_sql';

/*    if (!$_POST) {
//      $this->load->view('session/login');
	$return_msg .= 'Not a POST Request';
	echo $return_msg;
	return $return_msg;
    }
*/     
// Is a post request
    $machine_id= $_POST['machine_id'];
    $username = $_POST['username'];
    $password_hash = $_POST['password'];
// (assume password sent is hashed)
//    $password_hash = md5($password); 

    $user = $this->user->find_by('username', $username);
    if (!$user || $user->password_hash != $password_hash) {
	$return_msg .= 'Invalid username or password';
	echo $return_msg;
	return $return_msg;
    }
    
    $return_msg .= ' password matched ';

// generate server sql before importing received transactions
   $run_query = $this->db->query('select MAX(timestamp) as timestamp from sql_runs where (machine_id='.$machine_id.' AND completed="Yes" AND type="Tx")');
   $start_time = $run_query->row()->timestamp;
   $end_time = Date_util::timestamp();
   $sql_tx = $this->sql_run->new_record();
   $sql_tx->machine_id = $machine_id;
   $sql_tx->timestamp = $end_time;
   $sql_tx->username = $username;
   $sql_tx->save();
   $sql_tx->file_name = $sql_tx->id.'-tx.sql';
   $sql_tx->save();
   $tx_filename = $this->config->item('sql_tx_folder').$sql_tx->file_name;
   $sql_gen = '/usr/bin/mysqlbinlog --database='.$this->config->item('db_to_be_repl').' --start-datetime="'.$start_time.'" --stop-datetime="'.$end_time.'" --result-file='.$tx_filename.' /var/log/mysql/mysql-bin.0*';
   $result = shell_exec($sql_gen);
   if($result)
   {
	$return_msg .= "SQL File generation failed";
	echo $return_msg;
	return $return_msg;
		return;
   }
   shell_exec('bzip2 '.$tx_filename);

// Process sql that has been received

   $sql_rx = $this->sql_run->new_record();
   $sql_rx->machine_id = $machine_id;
   $sql_rx->timestamp = $end_time;
   $sql_rx->username = $username;
   $sql_rx->type= 'Rx';
   $sql_rx->completed= 'Yes';
   $sql_rx->save();
   $filename = $sql_rx->id.'-rx.sql';
   $sql_rx->file_name = $filename;
   $sql_rx->save();
   $fp = fopen($this->config->item('sql_rx_folder').$filename.'.bz2','wb');
   $sql = base64_decode($_POST['sql'],true);
   fwrite($fp,$sql);
   fclose($fp);
   $bz_ret = shell_exec('bunzip2 '.$this->config->item('sql_rx_folder').$filename.'.bz2');
   $sql_ret = shell_exec('mysql --user='.$this->config->item('db_user').' --password='.$this->config->item('db_password').' --force < '.$this->config->item('sql_rx_folder').$filename );

   $return_msg .= ' Record Saved bz_ret  = '.$bz_ret. ' sql_ret ='.$sql_ret ;
//   echo $return_msg;
//   return $return_msg;

//  generate binary encoded string of generated sql query to send back
    $fp = fopen($tx_filename.'.bz2','rb');
    $sql_query = fread($fp,filesize($tx_filename.'.bz2'));
    fclose($fp);
    $sql_query = base64_encode($sql_query);

    echo $sql_query;

  }

  public function cf_rx() {

    $return_msg = 'error ';
//  $return_msg .= 'entered rx_sql';

/*    if (!$_POST) {
//      $this->load->view('session/login');
	$return_msg .= 'Not a POST Request';
	echo $return_msg;
	return $return_msg;
    }
*/     
// Is a post request
    $machine_id= $_POST['machine_id'];
    $username = $_POST['username'];
    $password_hash = $_POST['password'];
// (assume password sent is hashed)
//    $password_hash = md5($password); 

    $user = $this->user->find_by('username', $username);
    if (!$user || $user->password_hash != $password_hash) {
	$return_msg .= 'Invalid username or password';
	echo $return_msg;
	return $return_msg;
    }
    
    $return_msg .= ' password matched ';

// generate server sql before importing received transactions
   $run_query = $this->db->query('select * from sql_runs where (machine_id='.$machine_id.' AND completed="No" AND type="Tx") ORDER BY timestamp DESC');
   $sql_tx_id = $run_query->row()->id;
   $query2 = $this->db->query('update sql_runs set completed="Yes" where id ='.$sql_tx_id);

   echo 'true';

  }

  public function add_machine() {


    if (!$_POST) {
   	$this->load->view('repl/add_machine');
	return true;
    }
     
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $clinic_id = $_POST['clinic_id'];

    $DB2 = $this->get_db_con();
    if($_POST['action'] == "add")
    {
    	$ins_query = 'insert into machines values('.$id.',"'.$name.'","'.$location.'","'.$clinic_id.'","No")';
    	$run_query = $DB2->query($ins_query);

    	$cur_time = Date_util::timestamp();
    	$ins2_query = 'insert into heartbeats values('.$id.',"'.$id.'","'.$cur_time.'")';
    	$run2_query = $DB2->query($ins2_query);

    	if($run_query && $run2_query)
    	{
    		$srun_rec = $this->sql_run->new_record();
    		$srun_rec->id = $_POST['id'];
    		$srun_rec->machine_id = '1000';
    		$srun_rec->username= 'sundeep';
    		$srun_rec->timestamp= $cur_time;
    		$srun_rec->type= 'Tx';
    		$srun_rec->completed= 'Yes';
		if($srun_rec->save())
		{
   			$msg= 'Machine added with id '.$id;
   			$this->session->set_userdata('msg', $msg);
   			$this->load->view('repl/home');
		}
    	}
    	else
    	{
   		$msg= 'Machine could not be added with id '.$id;
   		$this->session->set_userdata('msg', $msg);
   		$this->load->view('repl/home');
    	}
    }
    else
    {
    	$m_query = 'update machines set name="'.$name.'",location="'.$location.'",clinic_id='.$clinic_id.' where id='.$id;
    	$mrun_query = $DB2->query($m_query);
	if($mrun_query)
	{
   		$msg= 'Machine edited with id '.$id;
   		$this->session->set_userdata('msg', $msg);
   		$this->load->view('repl/home');
	}
    }

  }

  public function edit_machine() {

    if (!$_POST) {
   	$msg= 'Please send POST request with machine id';
   	$this->session->set_userdata('msg', $msg);
   	$this->load->view('repl/home');
	return true;
    }
     

    $id = $_POST['machine_id'];

    $DB2 = $this->get_db_con();
    $s_query = 'select * from machines where id="'.$id.'"';
    $run_query = $DB2->query($s_query);

    $data['m_obj'] = $run_query->row();
    $this->load->view('repl/add_machine', $data);

  }

  public function check_status() {

    $DB2 = $this->get_db_con();
    $s_query = 'select machines.*,timestamp from machines,last_heartbeats where (machines.id = last_heartbeats.machine_id)';
    $run_query = $DB2->query($s_query);

    $i=0;
    $mc = null;
    foreach($run_query->result() as $row)
    {
	$mc[$i]['id'] = $row->id;
	$mc[$i]['name'] = $row->name;
	$mc[$i]['location'] = $row->location;
	$mc[$i]['clinic_id'] = $row->clinic_id;
	$mc[$i]['to_replicate'] = $row->to_replicate;
	$mc[$i]['last_heartbeat'] = $row->timestamp;

    	$t_query = 'select max(timestamp) as m_ts from sql_runs where (machine_id='.$row->id.' AND type="Tx" AND completed="Yes")';
    	$run_t_query = $this->db->query($t_query);
	$mc[$i]['last_tx'] = $run_t_query->row()->m_ts;

    	$r_query = 'select max(timestamp) as m_ts from sql_runs where (machine_id='.$row->id.' AND type="Rx" AND completed="Yes")';
    	$run_r_query = $this->db->query($r_query);
	$mc[$i]['last_rx'] = $run_r_query->row()->m_ts;

	$i++;
    }
    
    $data['values'] = $mc;
    $data['num_rows'] = $i;
    $this->load->view('repl/show_status',$data);

  }

  public function request_repl() {

    $DB2 = $this->get_db_con();
    for($i =0; $i<$_POST['num_rows'] ;$i++)
    {
	$check_var = 'check_'.$i;
	$id_var = 'id_'.$i;
	if($_POST[$check_var] == 'Yes')
	{
    		$u_query = 'update machines set to_replicate="Yes" where id='.$_POST[$id_var];
    		$run_query = $DB2->query($u_query);
	}
    }
    
    $this->load->view('repl/home');

  }

  public function hb_listener($machine_id = 0) {
/*
    $return_msg = 'error ';
//  $return_msg .= 'entered rx_sql';

    if (!$_POST) {
//      $this->load->view('session/login');
	$return_msg .= 'Not a POST Request';
	echo $return_msg;
	return $return_msg;
    }
     
// Is a post request
    $machine_id= $_POST['machine_id'];*/
    $cur_time = Date_util::timestamp();
    $DB2 = $this->get_db_con();
    $u_query = 'insert into heartbeats (`machine_id`,`timestamp`) values('.$machine_id.',"'.$cur_time.'")';
    $run_query = $DB2->query($u_query);
    if($run_query)
    {
    	$r_query = 'select * from machines where id='.$machine_id;
    	$run_r_query = $DB2->query($r_query);
	echo $run_r_query->row()->to_replicate;
//    	echo 'success';
    }
    else
	echo 'error';

  }

  function get_db_con()
  {
	
	$config2['hostname'] = "localhost";
	$config2['username'] = $this->config->item('db_user');
	$config2['password'] = $this->config->item('db_password');
	$config2['database'] = $this->config->item('repl_db');
	$config2['dbdriver'] = "mysql";
	$config2['dbprefix'] = "";
	$config2['pconnect'] = FALSE;
	$config2['db_debug'] = TRUE;
	$config2['cache_on'] = FALSE;
	$config2['cachedir'] = "";
	$config2['char_set'] = "utf8";
	$config2['dbcollat'] = "utf8_general_ci";

	return $this->load->database($config2, true);
  }
	

}
//end of controller
