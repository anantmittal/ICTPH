<?php
	$this->load->helper('form');
	$this->load->view ( 'common/header' );
?>
<link type="text/css" href="<?php echo $this->config->item("base_url")."assets/css/jquery-ui-1.7.2.custom.css" ?>" rel="stylesheet" />
<link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>
<title>Define a Survey Form</title>

<script type="text/javascript">
	function survey_click(survey_type){
//			var survey_type =  $('#survey_type').val();
//			alert(survey_type);
			if(survey_type == 'demographic') {
				$('#demographic_div').show();
				$('#geographic_div').hide();
			}
			else {
				$('#geographic_div').show();
				$('#demographic_div').hide();
			}
		};

    	function granularity_click(granularity){
//		var granularity = $('#granularity').val();
//			alert(granularity);

		if(granularity == 'household') {
			$('#area_tab').hide();
			$('#village_tab').hide();
			$('#taluka_tab').hide();
			$('#household_tab').show();
			$('#person_tab').hide();
//			$('#household').show();
		} else if(granularity == 'person') {
			$('#area_tab').hide();
			$('#village_tab').hide();
			$('#taluka_tab').hide();
			$('#household_tab').hide();
			$('#person_tab').show();

//			$('#household').hide();
//			$('#person').show();

		} else if(granularity == 'area') {
			$('#area_tab').show();
			$('#village_tab').hide();
			$('#taluka_tab').hide();
			$('#household_tab').hide();
			$('#person_tab').hide();
		}
	};

</script>

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
		if (isset ( $survey_obj->name ))
			echo 'Edit Survey Details';
		else
			echo 'Define Survey and Form';
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
				<td><b> Name </b></td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td><b>Manager</b></td>
				<td><input type="text" name="manager"></td>
			</tr>
			<tr>
				<td><b>Manager Username</b></td>
				<td><input type="text" name="username"></td>
			</tr>
<!--
			<tr>
				<td><b> Survey Type </b></td>
				<td>
				<input type="radio" value="geographic" id="survey_type" class="survey_type" name="survey_type" checked onClick="survey_click('geographic')">Geographic
				 &nbsp;
				<input type="radio" value="demographic" id="survey_type" class="survey_type" name="survey_type" onClick="survey_click('demographic')">Demographic
				</td>
			</tr>

			<tr>
				<td><b>Granularity</b></td>
				<td>
				<div id="geographic_div">
<label> <input type="radio" name="geographic_radio" value="area" id="granularity" class="granularity" onClick="granularity_click('area')" checked >Area</label> &nbsp;
<label> <input type="radio" name="geographic_radio" value="village" id="granularity" class="granularity" onClick="granularity_click('village')">Village</label> &nbsp;
<label> <input type="radio" name="geographic_radio" value="taluka" id="granularity" class="granularity" onClick="granularity_click('taluka')" >Taluka</label> &nbsp;
				</div>

				<div id="demographic_div" style="display:none;">
<label> <input type="radio" name="granularity" value="household"  id="granularity" class="granularity" checked="checked" onClick="granularity_click('household')">Household</label> &nbsp;
<label> <input type="radio" name="granularity" value="person" id="granularity" class="granularity" onClick="granularity_click('person')">Person </label>
				</div>
				</td>
			</tr>
-->
			<tr>
				<td valign="top"><b>Description</b></td>
				<td><textarea name="description" rows="3" cols="40"></textarea></td>
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
