<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>
<?php
if (isset ( $chw_obj->id ))
	echo 'Edit CHW';
else
	echo 'Add New CHW';
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
	$("#addChwForm").validate();

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
  $("#village_cities").change();//.trigger('change');
			 }, 'json');
		});

	$('#village_cities').change(function(){
		var url = base_url + "index.php/common/autocomplete/areas";
		var selected_vc_id = $('#village_cities :selected').val();

		$.post(url, {id:selected_vc_id},	 function(json){
				var areas_dd = '';

				$.each(json, function(i, item) {
					var areas_arr = item.split('~');
					areas_dd += '<option value="'+areas_arr[0]+'">'+areas_arr[1]+'</option>';
					});
				$('#areas').html(areas_dd);
			 }, 'json');
		});

  $("#states").change();//.trigger('change');

});

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
		if (isset ( $chw_obj->id ))
			echo 'Edit CHW';
		else
			echo 'Add New CHW';
		?></span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">


		<form method="post" id="addChwForm">
		<table border="0" align="center" width="100%">
			<?php
			if (isset ( $chw_obj->id )) {
				?>
			<tr>
				<td><b>CHW ID</b></td>
				<td vcolspan="2"><?php
				echo $chw_obj->id;
				?></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td><b>Name</b></td>
				<td><input type="text" name="name" class="required"
					value="<?php
					if (isset ( $chw_obj->name ))
						echo $chw_obj->name;
					?>"> <?php
					echo form_error ( 'name' );
					?> </td>
			</tr>
			<tr>
				<td><b>Code</b></td>
				<td><input type="text" name="code" 
					value="<?php
					if (isset ( $chw_obj->code ))
						echo $chw_obj->code;
					?>"> <?php
					echo form_error ( 'code' );
					?> </td>
			</tr>
			<tr>
				<td><b>Phone No</b></td>
				<td><input type="text" name="phone_no" 
					value="<?php
					if (isset ( $chw_obj->phone_no ))
						echo $chw_obj->phone_no;
					?>"> <?php
					echo form_error ( 'phone_no' );
					?> </td>
			</tr>
			<tr>
				<td><b>State</b></td>
				<td>
				<?php
				//@todo : move this array to config file or load it from database
				//				$states = array ('1' => 'TamilNadu', '2' => 'Maharastra' );
				if (isset ( $chw_obj->state_id ))
					$seleted = & $chw_obj->state_id;
				else
					$seleted = '1';

				echo form_dropdown ( 'state_id', $states, $seleted, 'id="states"' );
				?>
				</td>
			</tr>

			<tr>
			<td><b>District</b></td>
			<td>
				<?php

				if (isset ( $chw_obj->district_id ))
					$selected = & $chw_obj->district_id;
				else
					$selected = '1';
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

				if (isset ( $chw_obj->taluka_id ))
					$selected = & $chw_obj->taluka_id;
				else
					$selected = '1';
//				echo form_dropdown ( 'district_id', $districts_dd, $selected,'id="districts"' );
				?>
			<select name="taluka_id" selected="<?php echo $selected;?>" id="talukas"></select>
				</td>
			</tr>

			<tr>
			<td><b>Village / City</b></td>
			<td>
			<select name="village_city_id" id="village_cities"></select>
				</td>
			</tr>

<!--			<tr>
				<td valign="top"><b>Villge / City</b></td>
				<td><input type="text" name="village_city_id" class="required"
					value="<?php
					if (isset ( $chw_obj->village_city_id ))
						echo $chw_obj->village_city_id;
					?>"> this field should save id in database(I changed database
				fields number to varchar)</td>
			</tr>
-->

			<tr>
			<td><b>Hamlet / Area</b></td>
			<td>
			<select name="area_id" id="areas"></select>
				</td>
			</tr>

<!--			<tr>
				<td><b>Hamlet / Area</b></td>
				<td><input type="text" name="area_id"
					value="<?php
					if (isset ( $chw_obj->area_id ))
						echo $chw_obj->area_id;
					?>"> this field should save id in database(I changed database
				fields number to varchar)</td>

			</tr>
-->

			<tr>
				<td><b>Start Date</b></td>

				<td><input type="text" name="start_date" size="10"
					class="datepicker"
					value="<?php
					if (isset ( $chw_obj->start_date ))
						echo $chw_obj->start_date;
					?>"></td>
			</tr>



			<tr>
				<td valign="top"><b>Comment</b></td>
				<td><textarea rows="5" cols="25" name="comment"><?php
				if (isset ( $chw_obj->comment ))
					echo $chw_obj->comment;
				?></textarea></td>
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
