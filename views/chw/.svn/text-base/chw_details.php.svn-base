
<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>

<script type="text/javascript"	src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js";?>"></script>
<script type="text/javascript"	src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";?>"></script>
<title>CHW Details</title>
</head>

<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<table border="0" width="95%" align="center">
	<tr>
		<td width="25%" valign="top" align="center">
		<fieldset><legend><b>CHW Info</b></legend>
		<table>
			<tr>
				<td><b>ID</b></td>
				<td><?php
				echo $id;
				?></td>
			</tr>
			<tr>
				<td><b>Name</b></td>
				<td><?php
				echo $name;
				?></td>
			</tr>
			<tr>
				<td><b>State</b></td>
				<td><?php
				echo $state_name;
				?></td>
			</tr>
			<tr>
				<td><b>District</b></td>
				<td><?php
				echo $district_name;
				?></td>
			</tr>
			<tr>
				<td><b>Village/City</b></td>
				<td><?php
				echo $village_city;
				?></td>
			</tr>
			<tr>
				<td><b>Hamlet/Area</b></td>
				<td><?php
				echo $area_id;
				?></td>
			</tr>
			<tr>
				<td><b>Start Date</b></td>
				<td><?php
				echo $start_date;
				?></td>
			</tr>
			<tr>
				<form action = "<?php echo $this->config->item('base_url').'index.php/chw/chw/edit/'.$id;?>" method="POST">
				<input type="submit" name="submit_edit"  value="Edit CHW details" class="submit" /input> 
				</form>
			</tr>
		</table>
		</fieldset>
		</td>

		<td valign="top">
		<fieldset><legend><b>Visit Records</b></legend>
		<table align="center" width="100%" id="RecordTable">
			<tr class="head">
				<td><b>Date</b></td>
				<td><b>Person</b></td>
				<td><b>Type</b></td>
				<td><b>Details</b></td>
				<td><b>Complaint</b></td>
				<td><b>Plan</b></td>
				<td><b>Edit</b></td>
			</tr>
			<?php
			foreach ( $visit_records as $visit_record ) {
				?>
			<tr class="grey_bg">
				<td><?php echo $visit_record->date ; ?></td>
				<td><?php echo $visit_record->person_id ; ?></td>
				<td><?php echo $visit_record->type ; ?></td>
				<td><?php echo $visit_record->details ; ?></td>
				<td><?php echo $visit_record->complaint; ?></td>
				<td><?php echo $visit_record->plan ; ?></td>
				<td><a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/edit_single_record/'.$visit_record->id;?>">Edit</a></td>
			</tr>
			<?php
			}
			?>

		<tr>
			<form action = "<?php echo $this->config->item('base_url').'index.php/chw/chw/add_records/'.$id;?>" method="POST">
			<input type="submit" name="submit_records"  value="Add Visit Records" class="submit" /input> 
			</form>
		</tr>
		</table>
		</fieldset>

<!-- Followups
		<fieldset><legend><b>Followups</b></legend>
		<table width="100%" border="0">
			<tr class="head">
				<td><b>Id</b>
				<td><b>Patient Name</b></td>
				<td><b>Project</b></td>
				<td><b>Type</b></td>
				<td><b>Name</b></td>
				<td><b>Date</b></td>-->
<!--				<td><b>Consumables</b></td>
				<td><b>Tests</b></td>
				<td><b>Dissemination</b></td>-->
<!--				<td><b>Status</b></td>
				<td><b>Action</b></td>
			</tr>
<?php
/*echo '<pre>';
print_r($followups);
echo '<pre>';*/


$i=0;
foreach ( $followups as $followup_row ) {
//		$date = Date_util::date_display_format($followup_row['event'][0]['date']);
//		$date = Date_util::date_display_format($followup_row['start_date']);
   foreach($followup_row['event'] as $followup_event)
   {
	$row = "<tr  valign='top' class='grey_bg'><td>{$followup_row['followup_id']}</td><td valign='top'>{$followup_row['person_name']}({$followup_row['alt_id']})</td> ";
	$row .= "<td valign='top'>{$followup_row['project_name']}</td>";
//	$row .= " <td valign='top'>{$followup_row['products']}</td> ";
//	$row .= "<td valign='top'>{$followup_row['tests']}</td><td valign='top'>{$followup_row['disseminations']}</td> ";
	$row .= " <td valign='top'>{$followup_event['type']}</td> ";
	$row .= " <td valign='top'>{$followup_event['type_name']}</td> ";
	$row .= " <td valign='top'>{$followup_event['date']}</td> ";
	$row .= "<td valign='top'>{$followup_event['last_status']}</td>";
	$row .= '<td valign="top">
		<form action="'.$this->config->item ( 'base_url' ) . 'index.php/chw/followup/update_status" method="post" >
		<input  type="hidden" name="event_id" value="'.$followup_event['id'].'"/>
		<input  type="text" size="10" name="on_date" class="datepicker"/>
		<select name="status">
		<option value="done">Done</option>
		<option value="not done">Not Done</option>
		<option value="in progress">In Progress</option>
		</select>
		<input type="text" size="8" name="note"/>
		<input type="submit" value="Update status" class="submit" />
		</form></td></tr>';
	echo $row;
	$i++;
	$row = '';
   }
}
$i=0;

?>
		<tr>
			<form action = "<?php echo $this->config->item('base_url').'index.php/chw/followup/add_plan/chw/'.$id;?>" method="POST">
			<input type="submit" name="submit_followup"  value="Add Followup Plan" class="submit" /input> 
			</form>
		</tr>
 </table>
		</fieldset>

-->
		<!--
		<div id="update_form" style="display: none;">
		<input type="hidden" id="followup_id" value="">
		<table width="100%" width="1" align="center">
			<tr>
				<td colspan="2"><b>Update Status</b></td>
			</tr>
			<tr>
				<td><b>Date</b></td>
				<td><input type="text" size="10" name="date" id="update_date"	class="datepicker"></td>
			</tr>
			<tr>
				<td><b>Status</b></td>
				<td><select id="status">
					<option value="pending">Pending</option>
					<option value="done">Done</option>
				</select></td>
			</tr>
			<tr>
				<td valign="top"><b>Comment</b></td>
				<td><textarea rows="3" cols="20" id="comment" name="comment"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="button" value="submit" id="submit"
					class="submit"></td>
			</tr>
		</table>
		</div>-->





		<br>
		<fieldset><legend><b>Training Session</b></legend>

		<table width="100%" border="0">
			<tr class="head">
				<td><b>Select</b></td>
				<td><b>Date</b></td>
				<td><b>Project</b></td>
				<td><b>Session Details</b></td>
				<td><b>Attendance</b></td>
				<td><b>Remark</b></td>
				<td><b>Overall Score</b></td>
			</tr>
		<form action ="<?php echo$this->config->item('base_url').'index.php/chw/chw/training_summary/'.$id ;?>">;
 <?php

	$i=0;
	foreach ( $report_score_obj as $report_row ) {
		$display_date = Date_util::date_display_format($report_row->date);
		echo '<tr class="grey_bg"> <td><input type="checkbox" name="training_'.$i.'" value="'.$report_row->training_session_id.'"/> </td><td>'.$display_date.'</td> <td><a href="'.$this->config->item('base_url').'index.php/chw/project/show/'.$report_row->project_id.'">'.$report_row->project_name.'</a></td>';
		echo '<td><a href="'.$this->config->item('base_url').'index.php/chw/training_session/show/'.$report_row->training_session_id.'">'.$report_row->description.'</a></td><td>'.$report_row->attendance.'</td><td>'.$report_row->remark.'</td><td align="right">'.round ( $report_row->avg_score, 2 ) . "</td></tr>";
	  $i++;
	}
		echo '<input type="hidden" name="chw_id" value="'.$id.'"/>';
		echo '<input type="hidden" name="no_of_reports" value="'.$i.'"/>';
		echo '<input type="submit" name="submit_report" value="Generate Report"/>';

	?>
	</form>
 </table>

		</fieldset>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
		<fieldset><legend><b>Sales</b></legend>
		<table width="100%" border="0">
			<tr class="head">
				<td><b>Date</b></td>
				<td><b>Person</b></td>
				<td><b>Health Product</b></td>
				<td><b>Qty</b></td>
				<td><b>Rate</b></td>
				<td><b>Total</b></td>
			</tr>

<?php
foreach ( $chw_sales_obj as $obj_row ) {
	$total = $obj_row->quantity * $obj_row->rate;
	$display_date = Date_util::date_display_format($obj_row->date);
	$row = "<tr class='grey_bg'><td>{$display_date}</td> <td>{$obj_row->person_id}</td><td>{$obj_row->health_product_name}</td>";
	$row .= "<td align='right'>{$obj_row->quantity}</td> <td align='right'>{$obj_row->rate}</td>   <td align='right'>{$total}</td></tr>";
	echo $row;
} ?>

		<tr>
			<form action = "<?php echo $this->config->item('base_url').'index.php/chw/chw/add_sales/'.$id;?>" method="POST">
			<input type="submit" name="submit_sales"  value="Add Product Sales" class="submit" /input> 
			</form>
		</tr>
</table>
		</fieldset>
		</td>
	</tr>
</table>

<?php $this->load->view ( 'common/footer' ); ?>
