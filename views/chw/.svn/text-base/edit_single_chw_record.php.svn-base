<?php
/*echo '<pre>';
print_r($visit_record);
echo '<pre>';*/
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>


<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>

<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/datepicker_.js";
	?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery.validate.js";
	?>"></script>

<title>Add CHW Records</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<form method="post">
<input type="hidden" name="id" value="<?php echo $visit_record->id; ?>">
<table border="0" align="center" width="60%">
	<tr>
		<td colspan="5">

		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">Edit single CHW Record</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
		<table width="100%">
			<tr>
				<td align="right"></td>
			</tr>
		</table>
		<br>
		<fieldset><legend><b>Sale Details</b></legend>
		<table>
			<tr>
				<td><b>Date</b></td>
				<td><input type="text" value="<?php echo Date_util::date_display_format($visit_record->date); ?>" name="date" size="10" id="date" class="datepicker"></td>
			</tr>
			<tr>
				<td><b>Person</b></td>
				<td><input type="text" value="<?php echo $visit_record->person_id; ?>" name="person_id"></td>
			</tr>
			<tr>
				<td><b>Type</b></td>
				<td><input type="text" value="<?php echo $visit_record->type; ?>" name="type"></td>
			</tr>
			<tr>
				<td><b>Details</b></td>
				<td><input type="text" value="<?php echo $visit_record->details; ?>" name="details"></td>
			</tr>
			<tr>
				<td><b>Complaint</b></td>
				<td><input type="text" value="<?php echo $visit_record->complaint; ?>" name="complaint"></td>
			</tr>

			<tr>
				<td><b>Plan</b></td>
				<td><input type="text" value="<?php echo $visit_record->plan; ?>" name="plan"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit_form_data"
					id="submit_form_data" class="submit" value="Submit Record"></td>
			</tr>
		</table>
		</fieldset>
		</div>
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>
		</div>
		</div>
		</td>
	</tr>
</table>
</form>
<?php
$this->load->view ( 'common/footer' );
?>
