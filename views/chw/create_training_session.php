<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>
<?php if(isset($training_session))
    	echo "Edit Training Session";
       else echo "Create New Training Session";
?>
</title>
<link rel="stylesheet" type="text/css"
	href="<?php
	echo $this->config->item ( 'base_url' );
	?>assets/css/jquery.autocomplete.css" />

<script type='text/javascript'
	src='<?php
	echo $this->config->item ( 'base_url' );
	?>assets/js/jquery.autocomplete.js'></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#addTrainingRow').click(function() {
		var training = $('#training').val();
		if(training != ''){
		    var row = '<tr class="approve">';
			row += '<td>' + training  + '</td>';
			row += '<td onmousedown="removeRow(this)"><a href="#">Remove</a></td>';
			row += '</tr>';

			$('#training').val('');
			$('#trainingTable tr:last').after(row);
		}
	});

	$('#addCriteriaRow').click(function() {
		var criteria = $('#criteria').val();
		if(criteria != ''){
		    var row = '<tr class="approve">';
		    row += '<td>' + criteria  + '</td>';
		    row += '<td align="center" onmousedown="removeRow(this)"><input type="checkbox">';
		    row += '<input type="hidden" name="criteria_arr[]" value="'+criteria+'"></td>';

			row += '</tr>';

			$('#criteria').val('');
			$('#criteriaTable tr:last').after(row);
		}
	});

	//trainingTableData
	//criteriaTableData

	$('#submit_form_data').click(function(){
		var row_data="";
		var cnt = 0;
		var trainingTableData = "";
		var criteriaTableData = "";

		$('#trainingTable tr').each(function(){
			var rows = $(this).children('td');
			$(rows).each(function(){
				if(cnt != 0)
					row_data += $(this).html()+'|';
			});
			if(cnt != 0)
				row_data += '~';

			cnt++;
		});
		$('#trainingTableData').val('');
		$('#trainingTableData').val(row_data);


		row_data="";
		cnt = 0;
		$('#criteriaTable tr').each(function(){
			var rows = $(this).children('td');
			$(rows).each(function(){
				if(cnt != 0)
					row_data += $(this).html()+'|';
			});
			if(cnt != 0)
				row_data += '~';
			cnt++;
		});
		$('#criteriaTableData').val('');
		$('#criteriaTableData').val(row_data);
	}); 

});

function removeRow(row) {
	$(row).parent().remove();
}





//---------------------------jquery auto complete code START here---------------------------------

var actual_val;
var autocomp_url;

$().ready(function() {

	 /*$("#product").focus(function () {
		 autocomp_url = base_url + "index.php/chw/test/autocomplete_product_list";
});*/


	function findValueCallback(event, data, formatted){
		//$("<li>").html(!data ? "No match!" : "Marathi name: " + formatted+" English name: " + data[1]).appendTo("#result");
	}

	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

	$(":text").result(findValueCallback).next().click(function(){
		$(this).prev().search();
	});




	$(".training").autocomplete(base_url + "index.php/common/autocomplete/training_modules", { width: 260,	selectFirst: false});
	$(".training").result ( function(event, data, formatted) {
		if (data)
		     $(this).parent().next().find("input").val(data[1]);
	});



/*	$(".dissemination").autocomplete(base_url + "index.php/common/autocomplete/disseminations", { width: 260,	selectFirst: false});
	$(".dissemination").result ( function(event, data, formatted) {
		if (data)
		     $(this).parent().next().find("input").val(data[1]);
	});*/

});

//-----------------------jquery auto complete code ENDS here--------------------------




</script>
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
<form method="post">
<?php if(isset($training_session)) {?>
<input type="hidden" name="project_id" value="<?php  echo $training_session->id; ?>">
<?php } ?>
<table width="50%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">
		<?php if(isset($training_session))
				echo "Edit Training Session";
			  else
			  	echo "Create New Training Session";
       ?></span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
		<table border="0">
			<tr>
				<td><b>Project</b></td>
				<td colspan="2">
				<?php if(isset($training_session)) {
					    echo $training_session->project_name;
					  }
					  else {
						echo $project_name;
					  }
						?></td>

			</tr>

			<tr>
				<td><b>CHW Group</b></td>
				<td colspan="2">
				     <?php if(isset($training_session)) {
					    echo $training_session->chw_group_name;
					  }
					  else {
						echo $chw_group_name;
					  }
						?></td>
			</tr>
			<tr>
				<td><b>Date</b></td>
				<td colspan="2"><input type="text" name="date" size="10" class="datepicker"
				value="<?php if(isset($training_session)) {
					    echo Date_util::date_display_format($training_session->date);
					  }?>"></td>
			</tr>
			<tr>
				<td><b>Faculty</b></td>
				<td colspan="2"><input type="text" name="faculty" 
					value="<?php if(isset($training_session)) {
					    echo $training_session->faculty;
					  }?>"></td>
			</tr>
			<tr>
				<td valign="top"><b>Description</b></td>
				<td colspan="2">
				<textarea rows="3" cols="30" name="description" ><?php if(isset($training_session)) {
					    echo $training_session->description;
					  }?></textarea>
				</td>
			</tr>

			<tr>
				<td colspan="3">@todo : edit operation for training topics is not completed yet. </td>
			</tr>
			<tr class="head">
				<td colspan="3"><b>Training Topics</b></td>
			</tr>
			<tr>
				<td colspan="2" width="60%" valign="top">
				<table border="0" width="100%" id="trainingTable">
					<tr class="head">
						<td width="60%"><b>Training Topics</b></td>
						<td width="40%"><b>Remove</b></td>
					</tr>
				</table>

				</td>
				<td valign="top" width="40%" align="right">
				<input type="text" name="training"	id="training" class="training" size="26"><br>
				<input type="button" class="submit" value="Add Module/Topic"
					id="addTrainingRow"></td>
	              <input type="hidden" name="trainingTableData" id="trainingTableData" value="">
			</tr>

			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr class="head">
				<td colspan="3"><b>Assessment Criteria</b></td>
			</tr>
			<tr>
				<td colspan="2" width="60%" valign="top">
				<table border="0" width="100%" id="criteriaTable">
					<tr class="head">
						<td width="60%"><b>Criteria</b></td>
						<td width="40%"><b>Remove</b></td>
					</tr>

				<?php if(isset($criterias)) {
					foreach($criterias as $criteria ) {	?>
					<tr class="grey_bg">
						<td width="60%"><?php echo $criteria->criteria;?></td>
						<td width="40%" align="center">
						<input type="checkbox" name="criteria_id_to_del[]" value="<?php echo $criteria->id;?>" >
						</td>
					</tr>
				<?php }}?>


				</table>

				</td>
				<td valign="top" width="40%" align="right">
				<input type="text" size="26" id="criteria"> <br>
				<input type="button" class="submit" id="addCriteriaRow"
					value="Add Criteria"></td>
	              <input type="hidden" name="criteriaTableData" id="criteriaTableData" value="">
			</tr>

			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">
				<input type="submit" value="Submit" id="submit_form_data"
				class="submit"></td>
				<td>&nbsp;</td>
			</tr>
		</table>

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
</body>
<?php
$this->load->view ( 'common/footer' );
?>
