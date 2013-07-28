<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>

<script type="text/javascript">
var cnt = 0;
$(document).ready(function(){

	$('#addrow').click(function() {

	    var row = '<tr class="approve">';
	    row += '<td onmousedown="removeRow(this)" align="center"><input type="checkbox"></td>';
	    row += '<td>&nbsp;</td>';
		row += '<td><input type="hidden" name="records['+cnt+'][date]" value="'     + $('#date').val()     +'">'+ $('#date').val()     +'</td>';
		row += '<td><input type="hidden" name="records['+cnt+'][person]" value="'   + $('#person').val()   +'">'+ $('#person').val()   +'</td>';
		row += '<td><input type="hidden" name="records['+cnt+'][type]" value="'     + $('#type').val()     +'">'+ $('#type').val()     +'</td>';
		row += '<td><input type="hidden" name="records['+cnt+'][details]" value="'  + $('#details').val()  +'">'+ $('#details').val()  +'</td>';
		row += '<td><input type="hidden" name="records['+cnt+'][complaint]" value="'+ $('#complaint').val()+'">'+ $('#complaint').val()+'</td>';
		row += '<td><input type="hidden" name="records['+cnt+'][plan]" value="'     + $('#plan').val()     +'">'+ $('#plan').val()     +'</td>';
		row += '</tr>';
		cnt ++;
		/*var row = '<tr class="approve">';
	    row += '<td onmousedown="removeRow(this)" align="center"><input type="checkbox"></td>';
		row += '<td>' + $('#date').val()   + '</td>';
		row += '<td>' + $('#person').val() + '</td>';
		row += '<td>' + $('#type').val()   + '</td>';
		row += '<td>' + $('#details').val()+ '</td>';
		row += '<td>' + $('#complaint').val()+ '</td>';
		row += '<td>' + $('#plan').val()   + '</td>';
		row += '</tr>';*/

		$('#newRecordTable tr:last').after(row);
	});

	/*$('#submit_form_data').click(function(){
		var row_data="";
		var cnt = 0;

		$('#newRecordTable tr').each(function(){
			var rows = $(this).children('td');
			$(rows).each(function(){
				if(cnt != 0)
					row_data += '|'+$(this).html();
			});
			if(cnt != 0)
				row_data += '~';

			cnt++;
		});

		$('#recordsTableData').val('');
		$('#recordsTableData').val(row_data);
	});*/

});

function removeRow(row) {
	$(row).parent().remove();
}

</script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>

<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/datepicker_.js";
	?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery.validate.js";
	?>"></script>

<title>Add CHW Records</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
      $this->load->view('common/header_search');
?>


<form method="post"><!--<input type="hidden" name="records_table_data" id="recordsTableData">
-->
<table border="0" align="center" width="60%">

	<tr>
		<td colspan="5">

		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">Add CHW Records</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
		<table align="">
			<tr>
				<td><b>CHW</b></td>
				<td width="10%"></td>
				<td colspan="2"><?php
				echo $chw_name;
				?></td>
			</tr>
			<!--<tr>
				<td><b>Start Date</b></td>
				<td><input type="text" class="datepicker" name="start_date" size="10"></td>
				<td><b>End Date</b></td>
				<td><input type="text" class="datepicker" name="end_date" size="10">
					</td>
			</tr>
		-->
		</table>

		<br>
		<table align="center" width="100%" id="newRecordTable">
			<tr class="head">
				<td><b>Remove </b></td>
				<td><b>Edit</b></td>
				<td><b>Date</b></td>
				<td><b>Person</b></td>
				<td><b>Type</b></td>
				<td><b>Details</b></td>
				<td><b>Complaint</b></td>
				<td><b>Plan</b></td>
			</tr>
			<?php
			foreach ( $visit_records as $visit_record ) {
				?>
			<tr class="grey_bg">
				<td align="center">
				<input type="checkbox" name="id_to_delete[]" value="<?php echo $visit_record->id ; ?>"></td>
				<td><a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/edit_single_record/'.$visit_record->id;?>">Edit</a></td>
				<td><?php echo $visit_record->date ; ?></td>
				<td><?php echo $visit_record->person_id ; ?></td>
				<td><?php echo $visit_record->type ; ?></td>
				<td><?php echo $visit_record->details ; ?></td>
				<td><?php echo $visit_record->complaint; ?></td>
				<td><?php echo $visit_record->plan ; ?></td>
			</tr>
			<?php
			}
			?>

		</table>
		<br>
		<table width="100%">
			<tr>
				<td align="right"><input type="submit" name="submit_form_data"
					id="submit_form_data" class="submit" value="Submit Records"></td>
			</tr>
		</table>
		<br>
		<fieldset><legend><b>Sale Details</b></legend>
		<table>
			<tr>
				<td><b>Date</b></td>
				<td><input type="text" size="10" id="date" class="datepicker"></td>
			</tr>
			<tr>
				<td><b>Person</b></td>
				<td><input type="text" id="person"></td>
			</tr>
			<tr>
				<td><b>Type</b></td>
				<td><input type="text" id="type"></td>
			</tr>
			<tr>
				<td><b>Details</b></td>
				<td><input type="text" id="details"></td>
			</tr>
			<tr>
				<td><b>Complaint</b></td>
				<td><input type="text" id="complaint"></td>
			</tr>

			<tr>
				<td><b>Plan</b></td>
				<td><input type="text" id="plan"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="button" id="addrow" value="Add" class="submit"></td>
			</tr>
		</table>

		</fieldset>

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
<?php
$this->load->view ( 'common/footer' );
?>
