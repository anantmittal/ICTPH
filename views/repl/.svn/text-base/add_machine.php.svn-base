<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>
<?php
if (isset ( $m_obj->id ))
	echo 'Edit Machine';
else
	echo 'Add New Machine';
?>
</title>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/datepicker_.js";
	?>"></script>


</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<table width="50%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">
		<?php
		if (isset ( $m_obj->id ))
			echo 'Edit Machine';
		else
			echo 'Add New Machine';
		?></span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">


		<form method="post" action="<?php echo $this->config->item('base_url').'index.php/repl/s_replicate/add_machine' ;?>" id="addMachine">
		<table border="0" align="center" width="100%">
			<tr>
				<td><b>Machine ID</b></td>
				<?php
					if (isset ( $m_obj->id )) {
				?>
					<input type="hidden" name="id" value="<?php echo $m_obj->id ; ?>">
					<input type="hidden" name="action" value="edit">
					<td>
					<?php echo $m_obj->id; ?>
					</td>
					<? }
					else
					{ ?>
					<td><input type="text" name="id"></td>
					<input type="hidden" name="action" value="add">
					<?php } ?>
			</tr>

			<tr>
				<td><b>Machine Name</b></td>
				<td><input type="text" name="name" class="required"
					value="<?php
					if (isset ( $m_obj->name ))
						echo $m_obj->name;
					?>"> <?php
					echo form_error ( 'full_name' );
					?> </td>
			</tr>

			<tr>
				<td><b>Location </b></td>
				<td><input type="text" name="location" 
					value="<?php
					if (isset ( $m_obj->location ))
						echo $m_obj->location;?>"> 
					</td>
			</tr>

			<tr>
				<td><b>Clinic Id</b></td>
				<td><input type="text" name="clinic_id" 
					value="<?php
					if (isset ( $m_obj->clinic_id ))
						echo $m_obj->clinic_id;?>"> 
					</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Submit" class="submit"></td>
			</tr>
		</table>
		</form>
		</div>
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>
		</div>
		</div>
		</td>
	</tr>
</table>
<?php
$this->load->view ( 'common/footer' );
?>
