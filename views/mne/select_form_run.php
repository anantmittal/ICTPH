<?php
	$this->load->helper('form');
	$this->load->view ( 'common/header' );
?>
<link type="text/css" href="<?php echo $this->config->item("base_url")."assets/css/jquery-ui-1.7.2.custom.css" ?>" rel="stylesheet" />
<link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title>Select a Survey Run and Form to Fill Data</title>

</head>
<script type="text/javascript">
$(document).ready(function(){

	$('#surveys').change(function(){
		var url1 = base_url + "index.php/common/mne_autocomplete/survey_runs";
		var url2 = base_url + "index.php/common/mne_autocomplete/forms";
		var selected_survey_id = $('#surveys :selected').val();

		$.post(url1, {id:selected_survey_id},	 function(json){
				var sruns_dd = '';

				$.each(json, function(i, item) {
					var srun_arr = item.split('~');
					sruns_dd += '<option value="'+srun_arr[0]+'">'+srun_arr[1]+'</option>';
					});
				$('#sruns').html(sruns_dd);
			 }, 'json');
		$.post(url2, {id:selected_survey_id},	 function(json){
				var forms_dd = '';

				$.each(json, function(i, item) {
					var form_arr = item.split('~');
					forms_dd += '<option value="'+form_arr[0]+'">'+form_arr[1]+'</option>';
					});
				$('#forms').html(forms_dd);
			 }, 'json');
		});

  $("#surveys").change();//.trigger('change');

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
			echo 'Select Survey Run and Form To enter data into';
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
				<td><b>Survey</b></td>
				<td>
				<?php
				echo form_dropdown ( 'survey_id', $surveys,'' , 'id="surveys"' );
				?>
				</td>
			</tr>
			<tr >
			<td><b>Survey Runs</b></td>
			<td>
			<select name="srun_id" selected="" id="sruns"></select> 
				</td>
			</tr>

			<tr>
			<td><b>Forms</b></td>
			<td>
			<select name="form_id" selected="" id="forms"></select>
				</td>
			</tr>

		</table>



<input type="submit" value="Add Data" class="submit">
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
</script>
<?php
$this->load->view ( 'common/footer' );
?>
