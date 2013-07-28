<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Add New User</title>

<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#666666;
	margin:0px;
	padding:0px;
}
.maindiv
{
width:550px;
margin:auto;
border:#000000 1px solid;
}
.mainhead{background-color : #aaaaaa;}
.tablehead{background-color : #d7d7d7;}
.row{   background-color : #e7e7e7;}
.data_table tr{
	font-size:11px;
	height:25px;
	background-color:#e8e8e8;
}

.largeselect {   width:200px; }

</style>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<!--Main Page-->
<div id="main">

  <div class="hospit_box">

<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Login</span></div></div></div>
          <div class="green_body">

<form method="POST" action="<?php echo $this->config->item('base_url').'index.php/admin/user_management/add_user'?>">

<table width="600" border="0" align="center" cellpadding="0" cellspacing="2" class="data_table">
    <tr>
    <td width="46%">Username</td>
    <td width="54%"><input type="text" name="username"/></td>
    </tr>
    <tr>
    <td width="46%">New Password</td>
    <td width="54%"><input type="password" name="new_password1"/></td>
    </tr>
    <tr>
    <td width="46%">Repeat New Password</td>
    <td width="54%"><input type="password" name="new_password2"/></td>
    </tr>
    <tr>
    <td width="46%">Full Name</td>
    <td width="54%"><input type="text" name="fullname"/></td>
    </tr>
    <tr>
    <td width="46%">Contact Number</td>
    <td width="54%"><input type="text" name="contact"/></td>
    </tr>
    <tr>
    <td width="46%">Role</td>
     <td> <?php echo form_dropdown("role", $roles, '', 'class="bigselect"'); ?></td>
<!--    <td width="54%"><input type="text" name="role"/></td>-->
    </tr>
  </tr>
</table>


<br/>
<table align="center" >
<tr>
<td width="50%" align="center">
<td width="50%" align="center"><input type="submit" value="submit" name="submit" class="submit"/></td>
 </tr>
</table>
    
</form>
    <br class="spacer" /></div>
    <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div></div>
</div>
<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
