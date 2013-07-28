<?php
if(isset($short_context['policy_id'])) {  ?>
<div class="form_row">
	<div class="form_lefts">Policy ID</div>
	<div class="form_right">
<?php echo "<a href=".$this->config->item('base_url').'index.php/hospitalization/policy_details/show_policy_details/'.$short_context['policy_id'].'>'.$short_context['policy_id'].'</a>';?>
	</div>
</div>
<?php } ?>

<?php if(isset($short_context['backend_member_id'])) {  ?>
<div class="form_row">
	<div class="form_lefts">Backend Id</div>
<!--	<div class="form_right"><?php echo $short_context['backend_member_id'];?></div>-->
	<?php $b_url = $this->config->item('base_url').'index.php/hospitalization/backend_claim/show_member_status/'.$short_context['backend_member_id'];?>
<div class="form_right"><input type="button" value="<?php echo $short_context['backend_member_id']; ?>" onClick="window.open('<?php echo $b_url; ?>');"></div>
</div>
<?php } ?>

<?php if(isset($short_context['policy_status'])) {  ?>
<div class="form_row">
	<div class="form_lefts">Policy Status</div>
	<div class="form_right"><?php echo $short_context['policy_status'];?></div>
</div>
<?php } ?>

<?php if(isset($short_context['policy_type'])) {  ?>
<div class="form_row">
	<div class="form_lefts">Policy type</div>
	<div class="form_right"><?php echo $short_context['policy_type'];?></div>
</div>
<?php } ?>

<?php if(isset($short_context['policy_limit'])) {  ?>
<div class="form_row">
	<div class="form_lefts">Policy Limit</div>
	<div class="form_right"><?php echo $short_context['policy_limit'];?></div>
</div>
<?php } ?>

<?php if(isset($short_context['policy_end_date'])) {  ?>
<div class="form_row">
	<div class="form_lefts">Policy End Date</div>
	<div class="form_right"><?php echo $short_context['policy_end_date'];?></div>
</div>
<?php } ?>


<?php if(isset($short_context['village_name'])) {  ?>
<div class="<?php if(!isset($short_context['hospital_name'])) echo 'form_rowb'; else echo 'form_row'; ?>">
	<div class="form_lefts">Village </div>
	<div class="form_right"><?php echo ucfirst($short_context['village_name']);?></div>
</div>
<?php } ?>

<?php if(isset($short_context['preauthorization_id'])){ ?> 
<div class="form_row">
  	<div class="form_lefts">Preautherization ID</div>
    <div class="form_right"><?php echo $short_context['preauthorization_id']; ?> </div>
</div>
<?php } ?>

<?php if(isset($short_context['patient_name'])){ ?> 
<div class="form_row">
  	<div class="form_lefts">Patient Name </div>
    <div class="form_right"><?php echo ucfirst($short_context['patient_name']); ?> </div>
</div>
<?php } ?>



<?php if (isset($short_context['patient_age'])) { ?>
<div class="form_row">
	<div class="form_lefts">Patient's Age</div>
	<div class="form_right"><?php echo $short_context['patient_age']; ?></div>         
</div>
<?php } ?>


<?php if (isset($short_context['patient_gender'])) { ?>
<div class="form_row">
	<div class="form_lefts">Patient's Gender</div>
	<div class="form_right"><?php if($short_context['patient_gender'] == 'M')echo "Male"; else echo "Female"; ?></div>
</div>
<?php } ?>

<?php if(isset($short_context['hospital_name'])){ ?> 
 <div class="form_rowb">
  	<div class="form_lefts">Hospital</div>
    <div class="form_right"><?php echo ucfirst($short_context['hospital_name']); ?> </div>
</div>
<?php } ?>    

<?php if(isset($short_context['used_amount'])) {  ?>
<div class="form_row">
	<div class="form_lefts">Used Amount</div>
	<div class="form_right">Rs <?php echo $short_context['used_amount']; ?></div>
</div>
<?php } ?>


<?php if(isset($short_context['blocked_amount'])) {  ?>
<div class="form_row">
	<div class="form_lefts">Blocked Amount</div>
	<div class="form_right">Rs <?php echo $short_context['blocked_amount']; ?></div>
</div>
<?php } ?>

<?php if(isset($short_context['available_amount'])) {  ?>
<div class="form_row">
	<div class="form_lefts">Available Amount</div>
	<div class="form_right">Rs <?php echo $short_context['available_amount']; ?></div>
</div>
<?php } ?>
