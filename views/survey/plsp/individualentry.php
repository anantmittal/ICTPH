<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Individual Details'));?>
<form method="post">	

<table align="center" width="50%" border="1" cellpadding="3">
<tr>
	<td>Individual ID</td>
	<td><?php echo form_input('IndiId', isset($indiId)?$indiId:(isset($hhid)?$hhid:''));?></td>
</tr>
<tr>
	<td>First Name</td>
	<td><?php echo form_input('IndiFirstName',isset($firstName)?$firstName:'');?></td>
</tr>

<tr>
	<td>Last Name</td>
	<td><?php echo form_input('IndiLastName',isset($lastName)?$lastName:'');?></td>
</tr>

<tr>
	<td>Gender</td>
	<td><?php echo form_dropdown('indiGender', array('Male','Female'),isset($gender)?$gender:'Male');?></td>
</tr>
<tr>
	<td>Relationship</td>
	<td><?php echo form_input('IndiRelationship',isset($relationship)?$relationship:'');?></td>
</tr>
<tr>
	<td>Date of Birth</td>
	<td><?php echo form_input('IndiDob',isset($dob)?$dob:'');?></td>
</tr>
<tr>
	<td>Door number</td>
	<td><?php echo form_input('IndiDoorNo', isset($door_no)?$door_no:'');?></td>
</tr>
<tr>
	<td>Street</td>
	<td><?php echo form_input('IndiStreet',isset($street)?$street:'');?></td>
</tr>

<tr>
	<td>Hamlet</td>
	<td><?php echo form_input('IndiHamlet',isset($hamlet)?$hamlet:'');?></td>
</tr>
<tr>
	<td>Village</td>
	<td><?php echo form_input('IndiVillage',isset($village)?$village:'');?></td>
</tr>
<tr>
	<td>Phone</td>
	<td><?php echo form_input('IndiPhone', isset($phone)?$phone:'');?></td>
</tr>
</table>
</br>
<div align="center"><input type="submit" value="Submit" /></div>

</form>
<?php $this->load->view('common/footer.php'); ?>
