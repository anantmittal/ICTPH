<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>Assign Doctor to Location
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
		if (isset ( $p_obj->id ))
			echo 'Edit Doctor';
		else
			echo 'Add New Doctor';
		?></span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">


		<form method="post" id="addProvLocn">
		<table border="0" align="center" width="100%">
			<tr>	
				<td><b>Provider</b></td>
				<td>
				<?php 
				echo form_dropdown ( 'provider_id', $providers,'' );
				?>
				</td>
			</tr>

			<tr>	
				<td><b>Location</b></td>
				<td>
				<?php 
				echo form_dropdown ( 'provider_location_id', $locations,'' );
				?>
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Submit"  name="submit_affiliation" class="submit"></td>
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
