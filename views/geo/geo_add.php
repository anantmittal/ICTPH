<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>
<?php
if (isset ( $obj->id ))
	echo 'Edit '.$type;
else
	echo 'Add New '.$type;
?>
</title>
<style>
	#states{
		width:162px;
	}
</style>


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
				$('#village_cities').change();
		}, 'json');
	});

	$('#village_cities').change(function(){
		var url = base_url + "index.php/common/autocomplete/areas";
		var selected_vc_id = $('#village_cities :selected').val();
		var selected_areas_id = $('#areas').attr('selected');
		$.post(url, {id:selected_vc_id},	 function(json){
				var areas_dd = '';
				$.each(json, function(i, item) {
					var areas_arr = item.split('~');
					if(areas_dd[0]==selected_areas_id){
					     areas_dd += '<option value="'+areas_arr[0]+'" selected="true">'+areas_arr[1]+'</option>';
					}else{
						areas_dd += '<option value="'+areas_arr[0]+'">'+areas_arr[1]+'</option>';
					}
					});
				$('#areas').html(areas_dd);
				
		 }, 'json');	
	});

  $("#states").change();
  $("#validateForm").validate();     //validating form
});

function validateGeoForm(){
	var ret = true;
	if($('#code_id').val() == -1){
		alert("Code cannot be -1");
		ret= false;
	}
	return ret;
}

</script>
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
		if (isset ( $obj->id ))
			echo 'Edit '.$type;
		else
			echo 'Add New '.$type;
		?></span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">


		<form method="post" id="validateForm" onSubmit="return validateGeoForm();">
		<table border="0" align="center" width="100%">
			
			<?php
			if (isset ( $obj->id )) {
				?>
			<tr>
				<td><b><?php echo $type; ?> ID</b></td>
				<td vcolspan="2"><?php
				echo $obj->id;
				?></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td width="20%"><b>New Name of <?php echo $type;?></b></td>
				<td width="80%"><input type="text" name="name" class="required" 
					value="<?php
					if (isset ( $obj->name ))
						echo $obj->name;
					?>"> <?php
					echo form_error ( 'name' );
					?> 
				</td>
				
			</tr>
			<tr>
				<td><b>New Code of <?php echo $type;?></b></td>
				<td><input type="text" name="code" class="required1" id="code_id"
					value="<?php
					if (isset ( $obj->code ))
						echo $obj->code;
					?>"> <?php
					echo form_error ( 'code' );
					?> 
				</td>
			</tr>

<?php if ($type != 'state'){ ?>
			<tr>
				<td><b>State</b></td>
				<td>
				<?php
				//@todo : move this array to config file or load it from database
				//				$states = array ('1' => 'TamilNadu', '2' => 'Maharastra' );
				if (isset ( $chw_obj3->state_id ))
					$seleted = $chw_obj3->state_id;
				else
					$seleted = '1';

				echo form_dropdown ( 'state_id', $states, $seleted, 'id="states"' );
				?>
				</td>
			</tr>
	<?php if($type != 'district') { ?>
			<tr>
			<td><b>District</b></td>
			<td>
				<?php

				if (isset ( $chw_obj2->district_id ))
					$selected = $chw_obj2->district_id;
				else
					$selected = '1';
//				echo form_dropdown ( 'district_id', $districts_dd, $selected,'id="districts"' );
				?>
			<select name="district_id" selected="<?php echo $selected;?>" id="districts" style="width:162px"></select> 
			 
				</td>
			</tr>

	<?php if($type != 'taluka') { ?>
			<tr>
			<td><b>Taluka</b></td>
			<td>
				<?php

				if (isset ( $chw_obj1->taluka_id ))
					$selected = $chw_obj1->taluka_id;
				else
					$selected = '1';
//				echo form_dropdown ( 'district_id', $districts_dd, $selected,'id="districts"' );
				?>
			<select name="taluka_id" selected="<?php echo $selected;?>" id="talukas" style="width:162px"></select>
				</td>
			</tr>

	<?php if($type != 'village_citie') { ?>
			<tr>
			<td><b>Village / City</b></td>
			<td>
			<?php

				if (isset ( $chw_obj4->village_city_id ))
					$selected = $chw_obj4->village_city_id;
				else
					$selected = '1';
//				echo form_dropdown ( 'district_id', $districts_dd, $selected,'id="districts"' );
				?>
			<select name="village_city_id" selected="<?php echo $selected;?>" id="village_cities" style="width:162px"></select>
				</td>
			</tr>
    <?php }}}}?>

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
