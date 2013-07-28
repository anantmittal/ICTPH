<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Cohort Configuration'));?>

<script type='text/javascript' src='<?php echo $this->config->item ( 'base_url' );
	?>assets/js/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css"
	href="<?php
	echo $this->config->item ( 'base_url' );
	?>assets/css/jquery.autocomplete.css" />
<script type="text/javascript">
	var cnt=0;
	$(document).ready(function(){
		$('.indisubmit').click(clickhandler);

	});
	function clickhandler() {
			var id;
			var edit_val = $("#"+$(this).attr("inputfield")).val();
			var textval = edit_val.split('(');
			if(textval[1] != undefined)
			{
				id = textval[1].split(')');
				textval[1] = id[0];
			}
			else
				textval[1] = 0;
			addRow($(this).attr("id"), $(this).attr("targettable"), textval[0]);
		}
	function addRow(type, tableid, text)
	{
		var row = '<tr class="approve">';
		row += '<td onmousedown="removeRow(this)" align="center"><input type="checkbox">Remove</td>';
		row += '<td><input type="hidden" name="events['+type+']['+cnt+']" value="' + text+'">'+ text+'</td>';
		row += '</tr>';
		cnt ++;

		$('#'+tableid+' tr:last').after(row);
	}
	function removeRow(row) {
		$(row).parent().remove();
	}

//---------------------------jquery auto complete code START here---------------------------------

var actual_val;
var autocomp_url;

$().ready(function() {

	function findValueCallback(event, data, formatted){
		//$("<li>").html(!data ? "No match!" : "Marathi name: " + formatted+" English name: " + data[1]).appendTo("#result");
	}

	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	$(":text").result(findValueCallback).next().click(function(){
		$(this).prev().search();
	});

	$("#person_add2").autocomplete(base_url + "index.php/common/autocomplete/persons", { width: 260,	selectFirst: false});
	$("#person_add2").result ( function(event, data, formatted) {
		if (data)
		     $(this).parent().next().find("input").val(data[1]);
	});


});

//-----------------------jquery auto complete code ENDS here--------------------------


</script>

<?php echo '<form method="post" action="'.$target.'">';?>
<?php if(isset($id)) echo '<input type="hidden" name="id" value="'.$id.'">';?>
<table border="0" align="center" width="60%">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">Cohort Configuration</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">


		<table border="0" align="center" width="80%">
			<tr>
				<td><b> Cohort Name</b></td>
				<td ><?php 
				if (isset($name)) 
					echo '<input type="text" id="chw" class="chw" name="name" value="'.$name.'">';
				else if(isset($_POST) && array_key_exists('name',$_POST))
					echo '<input type="text" id="chw" class="chw" name="name" value="'.$_POST['name'].'">';
				else
					echo '<input type="text" id="chw" class="chw" name="name">';
			?></td>
			</tr>

			<tr>
				<td><b> Description</b></td>
				<td >
				<textarea rows="3" cols="50" name="description"><?php 
				if (isset($description)) 
					echo $description;
				else if(isset($_POST) && array_key_exists('description',$_POST))
					echo $_POST['description'];
				?></textarea></td>
			</tr>
		</table>
		<br/>
		<fieldset><legend>Individuals </legend>
			<center>
			Individual ID : <input type="text" id="person_add" class="cohort_consituent">
			<input type="button" id="persons" value="Add" class="indisubmit" inputfield="person_add" targettable="indiTable">
			</center>
			<table border="0" align="center" width="70%" id="indiTable">
				<tr class="head">
					<td colspan="8" align="left">&nbsp;&nbsp; <b>Included Individuals</b></td>
				</tr>
				<tr class="head">
					<td>Action</td>
					<td><b>Individual</b></td>
				</tr>
			</table>
		<?php if(isset($persons) || isset($_POST))
		{
			$person_list = array();
			if(isset($persons))
				$person_list = $persons;
			else if(array_key_exists('events', $_POST))
				$person_list = $_POST['events']['persons'];
			echo '<script type="text/javascript">';
			foreach($person_list as $indi)
			{
				echo 'addRow("persons","indiTable","'.$indi.'");';
			}
			echo '</script>';
		}
		?>
		</fieldset>
		<br/>
		<fieldset><legend>Households </legend>
			<center>
			Household ID : <input type="text" id="household_add" class="cohort_consituent">
			<input type="button" id="households" value="Add" class="indisubmit" inputfield="household_add" targettable="householdTable">
			</center>
			<table border="0" align="center" width="70%" id="householdTable">
				<tr class="head">
					<td colspan="8" align="left">&nbsp;&nbsp; <b>Included Households</b></td>
				</tr>
				<tr class="head">
					<td>Action</td>
					<td><b>Household</b></td>
				</tr>
			</table>
		<?php if(isset($households)|| isset($_POST))
		{
			$household_list = array();
			if(isset($households))
				$household_list = $households;
			else if(array_key_exists('events', $_POST))
				$household_list = $_POST['events']['households'];
			echo '<script type="text/javascript">';
			foreach($household_list as $hh)
			{
				echo 'addRow("households","householdTable","'.$hh.'");';
			}
			echo '</script>';
		}
		?>
		</fieldset>
		<table align="right" width="100%">
			<tr>
				<td align="right" width="97%">
				<input type="submit" class="submit" id="submit_form_data" value="Submit"></td>
				</form>
				<td>&nbsp;</td>
			</tr>
		</table>
		<br/>
		<br/>
		</div>
		
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>
		</div>
		</div>
		</td>
	</tr>
	
</table>
<?php $this->load->view('common/footer.php'); ?>
