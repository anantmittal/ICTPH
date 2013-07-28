
<html>
<head>
<?php
$this->load->helper('form');
?>

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
<script type="text/javascript">
$(document).ready(function(){
	$('.update_btn').click(function(){
		var cur_id = this.id;
		var url = base_url + "index.php/chw/followup/update_status/";
		var event_id = $('#event_id'+cur_id).val();
		var date     = $('#date'+cur_id).val();
		var status   = $('#status'+cur_id).val();
		var note     = $('#note'+cur_id).val();
		if(date == '') {
			alert('Date field should not be empty');
			return false;
		}
		$.post(url, {event_id:event_id, on_date:date, status:status, note:note}, function(json){
				alert(json.result);
			},"json");

		});
});
</script>

</head>
<body>



<form
	action="<?php
	echo $this->config->item ( 'base_url' ) . "index.php/chw/followup/update_status";
	?> "
	method="post"><input type="hidden" name="id" value="<?php
	echo $id;
	?>">
<table width="650px">
	<tr>
		<td align="center"><b>Followup Event ID</b></td>
		<td><b>Date</b></td>
		<td><b>Status</b></td>
		<td><b>Comment</b></td>
	</tr>
<?php
$status = array('done'=>'Done','not done'=>'Not Done','in progress'=>'In Progress');

$cnt = 0;
foreach ( $events_obj as $events_obj_row ) {
	?>
<tr>
		<td align="center" valign="top">
		<?php echo $events_obj_row->id; ?>
		<input  type="hidden" name="events[<?php echo $cnt;?>][followup_event_id]" value="<?php echo $events_obj_row->id; ?>"
		id="event_id<?php echo $cnt; ?>">
		</td>
		<td valign="top"><input type="text" size="10" id="date<?php echo $cnt; ?>"
			name="events[<?php echo $cnt;?>][on_date]" class="datepicker"></td>
		<td valign="top">
		<?php
		$other_content = 'id="status'.$cnt.'"';
		echo form_dropdown("events[{$cnt}][status]", $status, $events_obj_row->last_status, $other_content); ?>
		</td>
		<td valign="top"><textarea rows="1" cols="20" id="note<?php echo $cnt; ?>"
			name="events[<?php echo $cnt;?>][note]"></textarea></td>
		<td valign="top">
			<input type="button" value="Update status" class="update_btn submit" id="<?php echo $cnt; ?>" >
		</td>
	</tr>
<?php
$cnt ++;
}
?>
<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td>
		<!--<input type="submit" value="Submit" class="submit">
		--></td>
	</tr>
</table>
</form>

</body>
</html>
