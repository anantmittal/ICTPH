<?php
$this->load->helper('form');
$this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Block User</title>
<script type="text/javascript">

</script>
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
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/admin/find_user.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/admin/user_management_validator.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php

$this->load->view('common/header_logo_block');
$this->load->view('common/header_search');
?>

<!--Main Page-->
<div id="main">

  <div id="leftcol">
		<div class="yelo_left">
			<div class="yelo_right">
				<div class="yelo_middle">
					<span class="head_box">Actions</span>
				</div>
			</div>
		</div>
		<div class="yelo_body" style="padding:8px;">
			<div class="action_headings_bar"> User </div>
		    <div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/user_management/add_user">Add User</a></div>
		    <div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/user_management/find_user/edit_user">Edit User </a></div>
		    <div class="action_items" style="font-weight:bold" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/user_management/find_user/block_user">Block User</a> </div>
		    <div class="action_headings_bar"> Role </div>
		    <div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/user_management/create_role">Create Role</a></div>
		    <div class="action_items"> <a href="<?php echo $this->config->item('base_url');?>index.php/admin/user_management/find_role/edit_role">Edit Role</a></div>
		    <div class="action_items"> <a href="<?php echo $this->config->item('base_url');?>index.php/admin/user_management/find_role/delete_role">Delete Role</a></div>
		</div>
		<div class="yelobtm_left">
			<div class="yelobtm_right">
				<div class="yelobtm_middle">
				</div>
			</div>
		</div>
	</div>
	<div id="rightcol">
		<div class="blue_left">
			<div class="blue_right">
				<div class="blue_middle">
					<span class="head_box">Block User</span>
				</div>
			</div>
		</div>
		<div class="blue_body" style="padding:8px;">
		<form id = "find_user_form_block" method="post" onSubmit="return onFindUserSubmitBlock('<?php echo $this->config->item('base_url')?>');">
		<?php $this->load->view('admin/find_user.php'); ?>
		</form>
		
	
	   	<form method="POST" action="<?php echo $this->config->item('base_url').'index.php/admin/user_management/block_unblock_user'?>" >		
			
		<?php 
			if(isset($test)){
				$this->load->view('admin/block_unblock_user.php');				
			}
		?>
		</form>
		
		</div>
		<div class="bluebtm_left">
			<div class="bluebtm_right">
				<div class="bluebtm_middle">
				</div>
			</div>
		</div>
</div>
    <br class="spacer" />
    
   
</div></div>
<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>