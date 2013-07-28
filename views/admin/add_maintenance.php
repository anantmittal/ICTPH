<?php $this->load->helper('form');
$this->load->view('common/header');
?>

<meta
	http-equiv="Content-Language" content="en" />
<meta name="GENERATOR"
	content="Zend Studio" />
<meta
	http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Maintenance and Calibration</title>

<style>
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding: 0px;
}

.maindiv {
	width: 550px;
	margin: auto;
	border: #000000 1px solid;
}

.mainhead {
	background-color: #aaaaaa;
}

.tablehead {
	background-color: #d7d7d7;
}

.row {
	background-color: #e7e7e7;
}

.data_table tr {
	font-size: 11px;
	height: 25px;
	background-color: #e8e8e8;
}

.largeselect {
	width: 200px;
}
</style>

	
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>
<script  type="text/javascript">
//Creating javascript array from php array.

var consumable_list = new Array();      
consumable_list = [      
<?php
foreach ($consumable_list as $consumables){
	$id = $consumables->id;
	$consumable_name = $consumables->name.'-'.$consumables->generic_name;
	$retail_unit=$consumables->retail_unit;
	$purchase_unit=$consumables->purchase_unit;
	$generic_name = $consumables->generic_name;
	$quantity = $consumables->capacity;
?>
{id: '<?php echo $id; ?>', name: '<?php echo $consumable_name; ?>', generic_name: '<?php echo $generic_name; ?>', capacity: '<?php echo $quantity; ?>', retail_unit: '<?php echo $retail_unit; ?>', purchase_unit: '<?php echo $purchase_unit; ?>'},
<?php
}
?>
];

</script>
</head>
<body bgcolor="#FFFFFF" text="#000000"
	link="#FF9966" vlink="#FF9966" alink="#FFCC99">

	<?php $this->load->view('common/header_logo_block');
	$this->load->view('common/header_search');
	?>
	<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'>$success_message </div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>
	<!--Main Page-->
	<div id="main">

		<div id="leftcol">
			<div class="yelo_left">
				<div class="yelo_right">
					<div class="yelo_middle">
						<span class="head_box">Consumables Configuration</span>
					</div>
				</div>
			</div>
			<div class="yelo_body" style="padding: 8px;">
				<div class="action_headings_bar"> Service </div>
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/add_service">Add Service</a></div>
				<div class="action_items"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_service/edit">Edit Service</a></div>
				<div class="action_items"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_service/block">Block Service</a></div>
				<div class="action_headings_bar"> Test Groups </div>
				<div class="action_items"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/add_test_group">Add Test Group</a></div>
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_test_group/edit">Edit Test Group</a></div>
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_test_group/delete">Delete Test Group</a></div>
				<div class="action_headings_bar"> Maintenance and Calibration</div>
				<div class="action_items" style="font-weight: bold"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/add_maintenance">Add Maintenance</a></div>
				<div class="action_items"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_maintenance/edit">Edit Maintenance</a></div>
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_maintenance/block">Block Maintenance</a></div>
			</div>
			<div class="yelobtm_left">
				<div class="yelobtm_right">
					<div class="yelobtm_middle"></div>
				</div>
			</div>
		</div>
		<div id="rightcol">
			<div class="blue_left">
				<div class="blue_right">
					<div class="blue_middle">
						<span class="head_box">Add Maintenance</span>
					</div>
				</div>
			</div>
			<div class="blue_body" style="padding: 8px;">
				<form method="POST" id="add_maintenance_table" action="<?php echo $this->config->item('base_url').'index.php/admin/consumables_configuration/stock_maintenance/add'?>" onSubmit="return ValidateConsumable()">
					<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="data_table" >
						<?php $this->load->view('admin/add_edit_maintenance.php');?>
					</table>
					</form>
					<br />
					
			</div>
			<div class="bluebtm_left">
				<div class="bluebtm_right">
					<div class="bluebtm_middle"></div>
				</div>
			</div>
		</div>
		<br class="spacer" />


	</div>
	</div>
	<!--Body Ends-->

	<?php $this->load->view('common/footer.php'); ?>