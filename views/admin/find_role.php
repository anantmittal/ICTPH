<?php $this->load->helper('form');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Edit Role</title>
 <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script  type="text/javascript">	
	var role_list = new Array();      
	role_list = [      
	<?php
	foreach ($role_list as $role){
	$role_id = $role->id;
	$role_name = $role->name;
	?>
	{id: '<?php echo $role_id; ?>', name: '<?php echo $role_name; ?>'},
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
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/admin/find_role.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<div align="center">	
		<span><strong>Find Role :</strong> </span><input id = "role_name" type="text" />
		<input id="role_id" type="hidden"/>
		<input type="Submit" value="Find" name="submit" class="find"/>
</div>
</body>
</html>		