<?php
class user_model extends IgnitedRecord {
	var $habtm = array (
		array (
			"name" => "roles",
			"join_table" => "users_roles"
		),
		array (
			"name" => "access_domains",
			"join_table" => "users_access_domains"
		)
	);

	function save_user($username,$new_password1,$fullname,$contact,$email_id) {		
		$user = $this->new_record();		
	    $new_password_hash = md5($new_password1);
		$user->username = $username;
		$user->name = $fullname;
		$user->password_hash = $new_password_hash;
		$user->contact_number = $contact;
		if(!empty($email_id)){
			$user->email_id = $email_id;
		}
		if (!$user->save()) {
			$msg = " User could not be created. Try with another user name";		
			$user = null;
			return $user;
		}
		return $user;
	}

	function block_user($user_id) {		
		$user = $this->find_by('id', $user_id);
		$user->is_user_enable = 0;
		$user->save();	
	}
	
	function unblock_user($user_id) {		
		$user = $this->find_by('id', $user_id);
		$user->is_user_enable = 1;
		$user->save();
	}	

	function validate_user($username,$new_password1,$new_password2){		
		$msg="";		
		//duplicate check		
		$user_check = $this->find_by('username', $username);
		if($user_check) {
			$msg="User already exists";
			return $msg;
		}		
		else{
			return $msg;
		}
		
	}

}