<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>
<?php
if (isset ( $p_obj->id ))
	echo 'Edit Location';
else
	echo 'Add New Location';
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
<script type="text/javascript"><!--
$(document).ready(function(){
	$("#addLocationForm").validate();

	$('#states').change(function(){
		var url = base_url + "index.php/common/autocomplete/districts";
		var selected_state_id = $('#states :selected').val();

		$.post(url, {id:selected_state_id},	 function(json){
				var districts_dd = '';

				$.each(json, function(i, item) {
					var dist_arr = item.split('~');
					districts_dd += '<option value="'+dist_arr[0]+'">'+dist_arr[1]+'</option>';
					});
				$('#districts').html(districts_dd);
  $("#districts").change();//.trigger('change');
			 }, 'json');
		});

	$('#districts').change(function(){
		var url = base_url + "index.php/common/autocomplete/talukas";
		var selected_district_id = $('#districts :selected').val();

		$.post(url, {id:selected_district_id},	 function(json){
				var talukas_dd = '';

				$.each(json, function(i, item) {
					var tal_arr = item.split('~');
					talukas_dd += '<option value="'+tal_arr[0]+'">'+tal_arr[1]+'</option>';
					});
				$('#talukas').html(talukas_dd);
  $("#talukas").change();//.trigger('change');
			 }, 'json');
		});

	$('#talukas').change(function(){
		var url = base_url + "index.php/common/autocomplete/village_cities";
		var selected_taluka_id = $('#talukas :selected').val();

		$.post(url, {id:selected_taluka_id},	 function(json){
				var vcs_dd = '';

				$.each(json, function(i, item) {
					var vcs_arr = item.split('~');
					vcs_dd += '<option value="'+vcs_arr[0]+'">'+vcs_arr[1]+'</option>';
					});
				$('#village_cities').html(vcs_dd);
			 }, 'json');
		});


  $("#states").change();//.trigger('change');

});

--></script>
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
			echo 'Edit Location';
		else
			echo 'Add New Location';
		?></span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">


		<form method="post" id="addLocationForm">
		<table border="0" align="center" width="100%">
			<?php
			if (isset ( $p_obj->id )) {
				?>
			<tr>
				<td><b>Location ID</b></td>
				<td vcolspan="2"><?php
				echo $p_obj->id;
				?></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td><b>Name</b></td>
				<td><input type="text" name="name" class="required"
					value="<?php
					if (isset ( $p_obj->name ))
						echo $p_obj->name;
					?>"> <?php
					echo form_error ( 'name' );
					?> </td>
			</tr>
			<tr>
				<td><b>State</b></td>
				<td>
				<?php
				//@todo : move this array to config file or load it from database
				//				$states = array ('1' => 'TamilNadu', '2' => 'Maharastra' );
				if (isset ( $p_obj->state_id ))
					$selected = & $p_obj->state_id;
				else
					$selected = '';

				echo form_dropdown ( 'state_id', $states, $selected, 'id="states"' );
				?>
				</td>
			</tr>

			<tr>
			<td><b>District</b></td>
			<td>
				<?php

				if (isset ( $p_obj->district_id ))
					$selected = & $p_obj->district_id;
				else
					$selected = '';
//				echo form_dropdown ( 'district_id', $districts_dd, $selected,'id="districts"' );
				?>
			<select name="district_id" selected="<?php echo $selected;?>" id="districts"></select> 
			<option value="<?php echo $selected;?>" selected="selected"> </option> 
				</td>
			</tr>

			<tr>
			<td><b>Taluka</b></td>
			<td>
				<?php

				if (isset ( $p_obj->taluka_id ))
					$selected = & $p_obj->taluka_id;
				else
					$selected = '';
//				echo form_dropdown ( 'district_id', $districts_dd, $selected,'id="districts"' );
				?>
			<select name="taluka_id" selected="<?php echo $selected;?>" id="talukas"></select>
			<option value="<?php echo $selected;?>" selected="selected"> </option> 
				</td>
			</tr>

			<tr>
			<td><b>Village / City</b></td>
			<td>
			<select name="village_city_id" id="village_cities"></select>
			<option value="<?php echo $selected;?>" selected="selected"> </option> 
				</td>
			</tr>

<!--			<tr>
				<td valign="top"><b>Villge / City</b></td>
				<td><input type="text" name="village_city_id" class="required"
					value="<?php
					if (isset ( $p_obj->village_city_id ))
						echo $p_obj->village_city_id;
					?>"> this field should save id in database(I changed database
				fields number to varchar)</td>
			</tr>
-->

			<tr>
				<td><b>Street Address</b></td>
				<td><input type="text" name="street_address" 
					value="<?php
					if (isset ( $p_obj->street_address ))
						echo $p_obj->street_address;?>"> 
					</td>
			</tr>

			<tr>
				<td><b>Phone No</b></td>
				<td><input type="text" name="phone_no" 
					value="<?php
					if (isset ( $p_obj->phone_no ))
						echo $p_obj->phone_no;?>"> 
					</td>
			</tr>

			<tr>
				<td><b>Registration No</b></td>
				<td><input type="text" name="registration_no" 
					value="<?php
					if (isset ( $p_obj->registration_no ))
						echo $p_obj->registration_no;?>"> 
					</td>
			</tr>



			<tr>
     				<td><b>Type of Location</b> </td>
					<?php if (isset ( $p_obj->type ))
						{$type = $p_obj->type;}	
						else {$type ='Clinic';}
					?> 
     				<td><?php echo form_dropdown("type", array('Clinic' => 'Clinic','Hospital' => 'Hospital','Lab' => 'Lab'), $type, 'class="bigselect"'); ?></td>
			</tr>

			<tr>
     				<td><b>Affiliation of Location</b> </td>
					<?php if (isset ( $p_obj->affiliation ))
						{$type = $p_obj->affiliation;}	
						else {$type ='Owned';}
					?> 
     				<td><?php echo form_dropdown("affiliation", array('Owned' => 'Owned','Empanelled' => 'Empanelled','Franchisee' => 'Franchisee'), $type, 'class="bigselect"'); ?></td>
			</tr>

			<tr>
				<td><b>Cachment Code</b></td>
				<td><input type="text" name="cachment_code" 
					value="<?php
					if (isset ( $p_obj->cachment_code ))
						echo $p_obj->cachment_code;?>"> 
					</td>
			</tr>

			<tr>
     				<td><b>Select Supply Chain Location</b> </td>
					<?php if (isset ( $p_obj->scm_org_id))
						{$default_id = $p_obj->scm_org_id;}	
						else {$default_id ='0';}
					?> 
     				<td><?php echo form_dropdown("scm_org_id", $scm_orgs, $default_id, 'class="bigselect"'); ?></td>
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
