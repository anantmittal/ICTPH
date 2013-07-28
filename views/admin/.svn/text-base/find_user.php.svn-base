<?php $this->load->helper('form');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Edit User</title>
 <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script  type="text/javascript">
	// Have to assign the medications_list while inline - it should be
	// be available on document load
	var user_list = new Array();      
	user_list = [      
	<?php
	foreach ($user_list as $user){
	$user_id = $user->id;
	$user_name = $user->username;
	?>
	{id: '<?php echo $user_id; ?>', name: '<?php echo $user_name; ?>'},
	<?php
	}
	?>
	];
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
.action_items { font-size: 11px; line-height: 16px; }
.action_items a {text-decoration:none;}

</style>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/admin/find_user.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<div align="center">
	
		<span><strong>Find User :</strong> </span><input id = "user_name" type="text" value="" />
		<input id="user_id" type="hidden"/>
		<input id="user1_name" type="hidden"/>
		<input type="Submit" value="Find" name="submit" class="find"/>
	
</div>
</body>
</html>		