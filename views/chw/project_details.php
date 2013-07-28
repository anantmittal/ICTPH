
<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<link
	href="<?php
	echo "{$this->config->item('base_url')}assets/css/facebox.css";
	?>"
	media="screen" rel="stylesheet" type="text/css" />
<script
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/facebox.js";
	?>"
	type="text/javascript"></script>

<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/datepicker_.js";
	?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>
<title>
<?php echo 'Project Details for '.$name; ?>
</title>
</head>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>

<body>
<table border="0" width="95%" align="center">
	<tr>
		<td width="25%" valign="top" align="center">
		<fieldset><legend><b>Project Info</b></legend>
		<table>
			<tr>
				<td><b>CHW Group</b></td>
				<td><?php
				echo $chw_group_name;
				?></td>
			</tr>
			<tr>
				<td><b>Project Name</b></td>
				<td>
				<?php echo $name; ?></td>
			</tr>
			<tr>
				<td valign="top"><b>Goal</b></td>
				<td ><?php echo $goal; ?>
				</td>
			</tr>
			<tr>
				<td valign="top"><b>Description</b></td>
				<td><?php echo $description; ?>
				</td>
			</tr>
			<tr>
				<td valign="top"><b>Project Manager</b></td>
				<td><?php echo $project_manager; ?>
				</td>
			</tr>
			<tr>
				<form action = "<?php echo $this->config->item('base_url').'index.php/chw/project/edit/'.$project_id;?>" method="POST">
				<input type="submit" name="submit_edit"  value="Edit Project details" class="submit" /input> 
				</form>
			</tr>

			<tr>
				<form action = "<?php echo $this->config->item('base_url').'index.php/chw/followup/add_plan/project/'.$project_id;?>" method="POST">
				<input type="submit" name="submit_followup"  value="Add Followup Plan" class="submit" /input> 
				</form>
			</tr>
		</table>
		</fieldset>
		</td>

		<td valign="top">
		<fieldset><legend><b>Training Sessions</b></legend>
		<table align="center" width="100%" id="RecordTable">
			<tr class="head">
				<td><b>Id</b></td>
				<td><b>Date</b></td>
				<td><b>faculty</b></td>
				<td><b>Description</b></td>
				<td><b>Attendance (%)</b></td>
				<td><b>Overall Score</b></td>
			</tr>
			<?php
			$num = count($ts_rows);
			$cnt = 0;
			for ( $cnt=0; $cnt < $num; $cnt++ ) {
				$ts_row = $ts_rows[$cnt];	?>
			<tr class="grey_bg">
				<td><?php echo '<a href="'.$this->config->item('base_url').'index.php/chw/training_session/edit/'.$ts_row['id'].'" >'.$ts_row['id'].'</a>' ; ?></td>
				<td><?php echo $ts_row['date'] ; ?></td>
				<td><?php echo $ts_row['faculty'] ; ?></td>
				<td><?php echo $ts_row['description'] ; ?></td>
				<?php if($ts_row['attendance']!= 'NA') { ?>
					<td><?php echo $ts_row['attendance'] ; ?></td>
					<td><?php echo $ts_row['score']; ?></td>
				<?php }
				else { ?>
			<td colspan=2><a href="<?php echo $this->config->item('base_url').'index.php/chw/training_session/add_report/'.$ts_row['id'];?>" >Add Report</a></td>
				<?php } ?>
			</tr>
			<?php
			}
			?>
			<tr>
				<form action = "<?php echo $this->config->item('base_url').'index.php/chw/training_session/create/'.$chw_group_id.'/'.$project_id;?>" method="POST">
				<input type="submit" name="submit_trg"  value="Add Training Session" class="submit" /input> 
				</form>
			</tr>
		</table>
		</fieldset>
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td>
		<fieldset><legend><b>CHWs</b></legend>

		<table width="100%" border="0">
			<tr class="head">
				<td><b>ID</b></td>
				<td><b>Name</b></td>
				<td><b>Village</b></td>
				<td><b>Training Score</b></td>
				<td><b>Product Sales</b></td>
				<td><b>Total Visits</b></td>
				<td><b>Total Followups</b></td>
			</tr>
 		<?php

			foreach ( $c_rows as $c_row ) {?>
			<tr class="grey_bg">
				<td><?php echo $c_row['id'] ; ?></td>
				<td><a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/show/'.$c_row['id'];?>"> <?php echo $c_row['name'] ; ?></a></td>
				<td><?php echo $c_row['village'] ; ?></td>
				<td><?php echo $c_row['score'] ; ?></td>
				<td><?php echo $c_row['sales'] ; ?></td>
				<td><?php echo $c_row['visits'] ; ?></td>
				<td><?php echo $c_row['followups'] ; ?></td>
			</tr>
				<?php } ?>
 		</table>

		</fieldset>
		</td>
	</tr>


	<tr>
		<td> </td>
		<td>
		<fieldset><legend><b>Followups</b></legend>
		<table width="100%" border="0">
			<tr class="head">
				<td><b>id</b>
				<td><b>Date</b>
				<td><b>Patient Name</b></td>
				<td><b>Project</b></td>
				<td><b>Consumables</b></td>
				<td><b>Tests</b></td>
				<td><b>Dissemination</b></td>
				<td><b>Status</b></td>
				<td><b>Action</b></td>
			</tr>
 		</table>
		</fieldset>
		</td>
	</tr>



	<tr>
		<td></td>
		<td>
		<fieldset><legend><b>Products</b></legend>
		<table width="100%" border="0">
			<tr class="head">
				<td><b>Product Name</b></td>
				<td><b>Persons</b></td>
				<td><b>Total Qty</b></td>
				<td><b>Average Rate</b></td>
				<td><b>Total Value</b></td>
			</tr>

		<?php
		foreach ( $p_rows as $p_row ) {
		$total = $p_row->quantity * $p_row->rate;?>
		</tr>
				<td><?php echo $p_row->name ; ?></td>
				<td><?php echo $p_row->persons ; ?></td>
				<td><?php echo $p_row->quantity ; ?></td>
				<td><?php echo $p_row->rate ; ?></td>
				<td><?php echo $total ; ?></td>
		</tr>
		<?php } ?>

		</table>
		</fieldset>
		</td>
	</tr>
</table>

<?php $this->load->view ( 'common/footer' ); ?>
