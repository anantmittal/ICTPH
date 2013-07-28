<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Enrolments - Audit creation'));?>
</br>

<?php 
if(!isset($pending))
	echo '<center><h3>Enrolments for '.$date.' by agent '.$agent.'</h3></center>';
else
{
	echo '<center><h2>Pending Audits</h2></center>';
	echo '<center><h4><a href="'.base_url().'index.php/enrol/enrol/pending_audits/'.$project_id.'/1">Print Sheet</a></h4></center>';
}
?>
<form method="post">
<table align="center" width="70%" border="1" cellpadding="5">
<tr>
	<th>Card Number</th>
	<th>Door number</th>
	<th>Street</th>
	<th>Village</th>
	<th>Phone</th>
	<th>Members</th>
	<th>Individual Count</th>
	<th>Respondent</th>
	<th>Audit Status</th>
</tr>
<?php foreach($forms as $row):?>
	<tr>
	<td> <?php echo '<a href="'.base_url().'index.php/enrol/enrol/edit_household/'.$row['id'].'">'.$row['cardnum'].'</a>';?></td>
	<td><?php echo $row['doornum'];?></td>
	<td><?php echo $row['street'];?></td>
	<td><?php echo $row['village'];?></td>
	<td><?php echo $row['phone'];?></td>
	<td><?php echo $row['members_num'];?></td>
	<td <?php if($row['members_num']!=$row['actual_individual_count']) echo "style=\"background-color:red\"";?>><?php echo $row['actual_individual_count'];?></td>
	<td><?php echo $row['respondent'];?></td>
	<td>
	<?php
		if(!isset($pending))
		{
			if(array_key_exists('audit_state',$row))
			{
				if($row['audit_state']['status']=='not_found')//then echo a checkbox
					echo '<input type="checkbox" name="'.$row['id'].'" value="true"> Mark for audit<br>';
				else if($row['audit_state']['status']=='pending')
					echo "Pending";
				else if($row['audit_state']['status']=='ok')
					echo "Audit status: OK";
				else if($row['audit_state']['status']=='invalid')
					echo "Audit status: Invalid";
			}
		}
		else
		{
			echo '<center><select name="'.$row['id'].'">';
			echo '<option value="ok">Approve </option>';
			echo '<option value="invalid">Reject </option>';
			echo '<option value="pending">Pending </option>';
			echo "</select></center>";
		}
	?>
	</td>
	</tr>
<?php endforeach;?>
</table>
<center><input type="submit" value="Submit" /></center>
</form>
</br>

<?php $this->load->view('common/footer.php'); ?>
