<?php
 $this->load->helper('form');
$this->load->view('common/header');
?>

<meta
	http-equiv="Content-Language" content="en" />
<meta name="GENERATOR"
	content="Zend Studio" />
<meta
	http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test Groups</title>

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

<script  type="text/javascript">
function ConfirmDelete(){
	clearAllErrorMessages();
	var r=confirm("Do you want to Delete Test Group! All Tests,Consumables associated with it will be deleted");
	if (r==true)
	  {
		var retVal = true;
	  }
	else
	  {
		var retVal = false;
	  }
	
	return retVal;
}

function clearAllErrorMessages(){
	$('.error').hide();
}

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
				<div class="action_items" style="font-weight: bold"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_test_group/delete">Delete Test Group</a></div>
				<div class="action_headings_bar"> Maintenance and Calibration</div>
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/add_maintenance">Add Maintenance</a></div>
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_maintenance/edit">Edit Maintenance</a></div>
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
						<span class="head_box">Delete Test Group</span>
					</div>
				</div>
			</div>
			<div class="blue_body" style="padding: 8px;">
				<form id = "find_test_group_form_block" method="post" onSubmit="return onTestGroupServiceSubmitDelete('<?php echo $this->config->item('base_url')?>');">
								<?php $this->load->view('admin/find_test_group.php'); ?>
								
				</form>
				<form method="POST" id="add_test_group_table" action="<?php echo $this->config->item('base_url').'index.php/admin/consumables_configuration/test_groups/delete'?>" onSubmit="return ConfirmDelete()">
					<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" class="data_table" >
						
						<?php 
							if(isset($delete_test_group)){	
						?>
						<tr><td colspan="3" align="center"><strong>Delete Test Group</strong></td></tr>
						<tr>
							<td ><strong>Test Group Name</strong></td>
							<td ><strong>:</strong></td>
							<td ><input type="text" name="test_group_name" value="<?php echo $delete_test_group->name;?>" disabled/>
								<input type='hidden' name='test_group_id' id='test_group_id' value='<?php echo $delete_test_group->id;?>' />
								<input type="hidden" name="test_group_name" value="<?php echo $delete_test_group->name;?>"/>
							</td>
						</tr>
						
						<tr>
							<td colspan="3" align="right"><input type="submit" value="Delete Test Group"  id="delete_test_group"> </input></td>
						</tr>
						<?php }?>
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
