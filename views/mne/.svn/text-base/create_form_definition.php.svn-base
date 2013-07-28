<?php
	$this->load->helper('form');
	$this->load->view ( 'common/header' );
?>
<link type="text/css" href="<?php echo $this->config->item("base_url")."assets/css/jquery-ui-1.7.2.custom.css" ?>" rel="stylesheet" />
<link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>
<title>Define a Form</title>

</head>
<body>

<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>


<table align="center"  width="60%">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">
		<?php
		if (isset ( $form_obj->name ))
			echo 'Edit Form Details';
		else
			echo 'Define a Form';
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

	<table border="0" align="center" width="">
	<tr>
		<td>
		<form method="POST" action="">
			<tr>
				<td><b>Form Name </b></td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td><b>Form Title</b></td>
				<td><input type="text" name="title"></td>
			</tr>
			<tr>
				<td><b>Table Name </b></td>
				<td><input type="text" name="table_name"></td>
			</tr>
			<tr>
				<td><b>Unit of Form </b></td>
				<td>
					<input type="radio" name="unit" value="household">Household &nbsp;
					<input type="radio" name="unit" value="person">Person &nbsp;
					<input type="radio" value="geography" name="unit">Geography &nbsp;
					<input type="radio" value="other" name="unit">Other &nbsp;
				</td>
			</tr>
			<tr>
				<td valign="top"><b>Description</b></td>
				<td><textarea name="description" rows="3" cols="40"></textarea></td>
			</tr>
		</table>

			<?php
			$this->load->view('mne/define_form');
			?>
<input type="submit" value="Submit">
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
