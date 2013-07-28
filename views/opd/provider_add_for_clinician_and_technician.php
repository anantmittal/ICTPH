<?php
$this->load->helper ( 'form' );
?>
<title>
<?php
if (isset ( $p_obj->id ))
	echo 'Edit Provider';
else
	echo 'Add New Provider';
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
<script type="text/javascript">
$(document).ready(function(){
	$("#addProviderForm").validate();

	$('#states').change(function(){
		var url = base_url + "index.php/common/autocomplete/districts";
		var selected_state_id = $('#states :selected').val();
		var selected_district_id = $('#districts').attr('selected');
		$.post(url, {id:selected_state_id},	 function(json){
				var districts_dd = '';

				$.each(json, function(i, item) {
					var dist_arr = item.split('~');
					if(dist_arr[0] == selected_district_id){
						districts_dd += '<option value="'+dist_arr[0]+'" selected="true">'+dist_arr[1]+'</option>';
					}else{
						districts_dd += '<option value="'+dist_arr[0]+'">'+dist_arr[1]+'</option>';
					}
					});
				$('#districts').html(districts_dd);
  				$("#districts").change();//.trigger('change');
		}, 'json');
	});

	$('#districts').change(function(){
		var url = base_url + "index.php/common/autocomplete/talukas";
		var selected_district_id = $('#districts :selected').val();
		var selected_taluka_id = $('#talukas').attr('selected');

		$.post(url, {id:selected_district_id},	 function(json){
				var talukas_dd = '';

				$.each(json, function(i, item) {
					var tal_arr = item.split('~');
					if(tal_arr[0] == selected_taluka_id){
						talukas_dd += '<option value="'+tal_arr[0]+'" selected="true">'+tal_arr[1]+'</option>';
					}else{
						talukas_dd += '<option value="'+tal_arr[0]+'">'+tal_arr[1]+'</option>';
					}
				});
				$('#talukas').html(talukas_dd);
  				$("#talukas").change();//.trigger('change');
		}, 'json');
	});

	$('#talukas').change(function(){
		var url = base_url + "index.php/common/autocomplete/village_cities";
		var selected_taluka_id = $('#talukas :selected').val();
		var selected_village_id = $('#village_cities').attr('selected');
		$.post(url, {id:selected_taluka_id},	 function(json){
				var vcs_dd = '';

				$.each(json, function(i, item) {
					var vcs_arr = item.split('~');
					if(vcs_arr[0] == selected_village_id){
						vcs_dd += '<option value="'+vcs_arr[0]+'" selected="true">'+vcs_arr[1]+'</option>';
					}else{
						vcs_dd += '<option value="'+vcs_arr[0]+'">'+vcs_arr[1]+'</option>';
					}
					});
				$('#village_cities').html(vcs_dd);
		}, 'json');
	});


  $("#states").change();//.trigger('change');

});

</script>
<body>
<table width="80%" align="center" id="add_provider_table">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">
		<?php
		if (isset ( $provider->id ))
			echo 'Edit Provider';
		else
			echo 'Add New Provider';
		?></span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

		<form method="post" id="addChwForm">
		<table border="0" align="center" width="100%">
			<?php
			if (isset ( $provider->id )) {
				?>
			<tr>
				<td><b>Provider ID</b></td>
				<td vcolspan="2"> <label name = "provider_id"> <?php
				echo $provider->id;
				?></label> <input type="hidden" name="provider_id"  value="<?php echo $provider->id; ?> "> </input>  </td>
			</tr>
			<?php
			}
			?>			
			<tr>
				<td width="30%"><b>State</b></td>
				<td>
				<?php
				//@todo : move this array to config file or load it from database
				//				$states = array ('1' => 'TamilNadu', '2' => 'Maharastra' );
				if (isset ( $provider->state_id ))
					$selected = & $provider->state_id;
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
				if (isset ( $provider->district_id ))
					$selected = & $provider->district_id;
				else
					$selected = '';
				?>
			<select name="district_id" selected="<?php echo $selected;?>" id="districts">
				<option value="<?php echo $selected;?>" selected="selected"> </option> 
			</select> 
				</td>
			</tr>

			<tr>
			<td><b>Taluka</b></td>
			<td>
				<?php
				if (isset ( $provider->taluka_id ))
					$selected = & $provider->taluka_id;
				else
					$selected = '';
				?>
			<select name="taluka_id" selected="<?php echo $selected;?>" id="talukas"></select>
				</td>
			</tr>

			<tr>
			<td><b>Village / City</b></td>
			<td>
			<?php
				if (isset ( $provider->village_city_id ))
					$selected = & $provider->village_city_id;
				else
					$selected = '';
				?>
			<select name="village_city_id"  id="village_cities"  selected="<?php echo $selected ?>" >
				<option> </option> 
			</select>
				</td>
			</tr>

			<tr>
				<td><b>Street Address</b><span class="mandatory">*</span></td>
				<td><input type="text" name="street_address" id="street_address" 
					value="<?php
					if (isset ( $provider->street_address ))
						echo $provider->street_address;?>">
						<label class="error" id="error_street_address" style="display:none">The Street field is required.</label>
					</td>
			</tr>

			

			<tr>
				<td><b>Qualification</b><span class="mandatory">*</span></td>
				<td><input type="text" name="qualification" id="qualification"
					value="<?php
					if (isset ( $provider->qualification ))
						echo $provider->qualification;?>">
						<label class="error" id="error_qualification" style="display:none">The Qualification field is required.</label> 
					</td>
			</tr>

			<tr>
				<td><b>Registration Number</b><span class="mandatory">*</span></td>
				<td><input type="text" name="registration_number" id="registration"
					value="<?php
					if (isset ( $provider->registration_number ))
						echo $provider->registration_number;?>">
						<label class="error" id="error_registration" style="display:none">The Registration field is required.</label>
						<label class="error" id="error_special_char_regist" style="display:none">Special characters are not allowed.</label> 
					</td>
			</tr>


			<tr>
     				<td><b>Type of Provider</b> </td>
					<?php
						$show_hew_dropdown = false;
						if (isset ( $provider->type )) {							
								$type = $provider->type;
								if($type == "HEW")
									$show_hew_dropdown = true;
						  }	
						  else {
						  		$type ='Doctor';
						  }
					?> 
     				<td><?php if(!$show_hew_dropdown) echo form_dropdown("type", array('Doctor' => 'Doctor','Nurse' => 'Nurse','Lab Technician' => 'Lab Technician'), $type, 'id="type_id"'); 
     						  if($show_hew_dropdown)  echo form_dropdown("type", array('HEW' => 'HEW'), $type, 'id="type_id"');?></td>
			</tr>
			<tr>
    			<td ><b>Locations</b><span class="mandatory">*</span></td>
    			<td >&nbsp;</td>
    			</tr>
			<?php			
     			foreach($locations as $key => $location){
     				$checked="";
     				if(isset($pla)){     					
     					foreach ( $pla as $key_provider_id => $value_provider_loc_id ) {     						
     						if($key == $value_provider_loc_id->provider_location_id){
     							$checked="checked";    							
     						}
     					}	
     				}
     				
    				echo "<tr>	<td > &nbsp; </td> <td> <input type= 'checkbox' id='$locations[$key]' name=\"provider_locations[]\" value='$key' $checked /> $locations[$key] </td> </tr>";
        		}
     		?>
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
