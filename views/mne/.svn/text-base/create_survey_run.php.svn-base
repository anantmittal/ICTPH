<?php
	$this->load->helper('form');
	$this->load->view ( 'common/header' );
?>
<link type="text/css" href="<?php echo $this->config->item("base_url")."assets/css/jquery-ui-1.7.2.custom.css" ?>" rel="stylesheet" />
<link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title>Define a Survey Run</title>

</head>
<script type="text/javascript">
$(document).ready(function(){

	$('#geo_type').change(function(){

		var geo_type = $('#geo_type').val();
		if(geo_type == 'state')
		{
			$('#tr_states').show();
			$('#tr_districts').hide();
			$('#tr_talukas').hide();
			$('#tr_vcs').hide();
			$('#tr_areas').hide();
			$('#district_id').val(0);
			$('#taluka_id').val(0);
			$('#village_city_id').val(0);
			$('#area_id').val(0);
		}
		else if(geo_type == 'district')
		{
			$('#tr_states').show();
			$('#tr_districts').show();
			$('#tr_talukas').hide();
			$('#tr_vcs').hide();
			$('#tr_areas').hide();
			$('#taluka_id').val(0);
			$('#village_city_id').val(0);
			$('#area_id').val(0);
		}
		else if(geo_type == 'taluka')
		{
			$('#tr_states').show();
			$('#tr_districts').show();
			$('#tr_talukas').show();
			$('#tr_vcs').hide();
			$('#tr_areas').hide();
			$('#village_city_id').val(0);
			$('#area_id').val(0);
		}
		else if(geo_type == 'village_citie')
		{
			$('#tr_states').show();
			$('#tr_districts').show();
			$('#tr_talukas').show();
			$('#tr_vcs').show();
			$('#tr_areas').hide();
			$('#area_id').val(0);
		}
		else if(geo_type == 'area')
		{
			$('#tr_states').show();
			$('#tr_districts').show();
			$('#tr_talukas').show();
			$('#tr_vcs').show();
			$('#tr_areas').show();
		}
	});

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
  $("#geo_type").change();//.trigger('change');

});

</script>

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
		if (isset ( $survey_run_obj->name ))
			echo 'Edit Survey Run Details';
		else
			echo 'Define Survey Run';
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
				<td><b>Run Name</b></td>
				<td><input id="name" type="text" name="name" /></td>
			</tr>
			<tr>	
				<td><b>Survey</b></td>
				<td><?php echo form_dropdown ( 'survey_id', $surveys,'' );?></td>
			</tr>

			<tr>	
				<td><b>Geogrpahy Boundary Type</b></td>
				<td><?php echo form_dropdown ( 'geography_type', $geos,'','id="geo_type"' );?></td>
			</tr>

			<tr id="tr_states">
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
			<tr id="tr_districts">
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

			<tr id="tr_talukas">
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

			<tr id="tr_vcs">
			<td><b>Village / City</b></td>
			<td>
			<select name="village_citie_id" id="village_cities"></select>
				</td>
			</tr>

			<tr id="tr_areas">
			<td><b>Areas</b></td>
			<td>
			<select name="area_id" id="areas"></select>
				</td>
			</tr>

			<tr>
				<td><b>Start Date</b></td>
				<td><input id="datepicker" type="text" size="10" name="start_date" class="datepicker" /></td>
			</tr>

			<tr>
				<td><b>End Date</b></td>
				<td><input id="datepicker" type="text" size="10" name="end_date" class="datepicker" /></td>
			</tr>

			<tr>
				<td><b>Surveyor Type</b></td>
				<td><?php echo form_dropdown ( 'staff_type', $staff_types,'' );?></td>
			</tr>
		</table>



<input type="submit" value="Create" class="submit">
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
<script type="text/javascript">
$(document).ready(function() {

	$("#tabs").tabs();
});
</script>
<?php
$this->load->view ( 'common/footer' );
?>
