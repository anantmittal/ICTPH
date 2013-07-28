<?php $this->load->helper('form');
$this->load->view('common/header');
?>

<meta
	http-equiv="Content-Language" content="en" />
<meta name="GENERATOR"
	content="Zend Studio" />
<meta
	http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Service</title>

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
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/admin/find_service.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>
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
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_service/edit">Edit Service</a></div>
				<div class="action_items" style="font-weight: bold"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_service/block">Block Service</a></div>
				<div class="action_headings_bar"> Test Groups </div>
				<div class="action_items"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/add_test_group">Add Test Group</a></div>
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_test_group/edit">Edit Test Group</a></div>
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/find_test_group/delete">Delete Test Group</a></div>
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
						<span class="head_box">Block/Unblock Service</span>
					</div>
				</div>
			</div>
			<div class="blue_body" style="padding: 8px;">
				
					<form id = "find_service_form_block" method="post" onSubmit="return onFindServiceSubmitBlock('<?php echo $this->config->item('base_url')?>');">
								<?php $this->load->view('admin/find_service.php'); ?>
					</form>
					<form method="POST"
									action="<?php echo $this->config->item('base_url').'index.php/admin/consumables_configuration/service/block_unblock'?>"
									onSubmit="return validateAddDiagnosisForm()">
					<table width="600" border="0" align="center" cellpadding="5"
						cellspacing="1" class="data_table" id="add_diagno_table">
						
							
							
									
									<?php 
										if(isset($block_service)){
										
										if($block_service->status){
											$disabled="disabled";
										}		
										else{
											$disabled="";
										}	
									?>
									<tr><td colspan="3" align="center"><strong>Block Service</strong></td></tr>
									<tr>
										<td ><strong>Service Name</strong></td>
										<td ><strong>:</strong></td>
										<td ><input type="text" name="service_name" value="<?php echo $block_service->name;?>" disabled/>
											<input type='hidden' name='service_id' id='service_id' value='<?php echo $block_service->id;?>' />
										</td>
									</tr>
									
									<tr>
										<td colspan="3" align="right"><input type="submit" value="Block Service"  id="block_service" <?php  if(!empty($disabled)) echo ""; else echo "disabled"; ?>  > </input>
										<input type="submit" value="Unblock Service"  id="unblock_service " <?php  if(empty($disabled)) echo ""; else echo "disabled"; ?> > </input></td>
									</tr>
									<?php }?>
								

						</table>
					</form>
					<br />
					<table align="center" valign="top">
						<tr>
							<td width="50%" align="center">
							
							
						</tr>
					</table>
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
