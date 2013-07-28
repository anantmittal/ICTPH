
<?php 
if (isset($short_context['patient_name'])) { ?>
<div class="form_row">
	<div class="form_lefts">Patient Name</div>
	<div class="form_right"><?php echo ucfirst($short_context['patient_name']); ?></div>         
</div>        
<?php } ?>


<?php if (isset($short_context['patient_age'])) { ?>
<div class="form_row">
	<div class="form_lefts">Patient's Age</div>
	<div class="form_right"><?php echo $short_context['patient_age']; ?></div>         
</div>
<?php } ?>

<?php if (isset($short_context['patient_dob'])) { ?>
<div class="form_row">
	<div class="form_lefts">Patient's DoB</div>
	<div class="form_right"><?php echo Date_util::date_display_format($short_context['patient_dob']); ?></div>         
</div>
<?php } ?>


<?php if (isset($short_context['patient_gender'])) { ?>
<div class="form_row">
	<div class="form_lefts">Patient's Gender</div>
	<div class="form_right"><?php if($short_context['patient_gender'] == 'M')echo "Male"; else echo "Female"; ?></div>
</div>
<?php } ?>


<?php if (isset($short_context['policy_id'])) { ?>
<div class="form_row">
	<div class="form_lefts">Policy ID</div>
	<div class="form_right"><?php echo "<a href=".$this->config->item('base_url').'index.php/hospitalization/policy_details/show_policy_details/'.$short_context['policy_id'].'>'.$short_context['policy_id'].'</a>';?></div>
</div>
<?php } ?>

<?php if (isset($short_context['backend_member_id'])) { ?>
<div class="form_row">
	<div class="form_lefts">Backend ID</div>
<!--	<div class="form_right"><?php echo "<a href=".$this->config->item('base_url').'index.php/hospitalization/backend_claim/show_member_status/'.$short_context['backend_member_id'].'>'.$short_context['backend_member_id'].'</a>';?></div> -->
	<?php $b_url = $this->config->item('base_url').'index.php/hospitalization/backend_claim/show_member_status/'.$short_context['backend_member_id'];?>
<div class="form_right"><input type="button" value="<?php echo $short_context['backend_member_id']; ?>" onClick="window.open('<?php echo $b_url; ?>');"></div>
</div>
<?php } ?>


<?php if (isset($short_context['policy_end_date'])) { ?>
<div class="form_row">
	<div class="form_lefts">Expiry Date</div>
	<div class="form_right"><?php echo $short_context['policy_end_date'];?></div>
</div>
<?php } ?>

<?php if (isset($short_context['village_name'])) { ?>
<div class="form_row">
	<div class="form_lefts">Village </div>
	<div class="form_right"><?php echo $short_context['village_name'];?></div>
</div>
<?php } ?>

<?php if (isset($short_context['hospitalization_id'])) { ?>
<div class="form_row">
	<div class="form_lefts">Hospitalization ID</div>
	<div class="form_right"><?php echo $short_context['hospitalization_id']; ?></div>
</div>
<?php } ?>

<?php if (isset($short_context['hospitalization_date'])) { ?>
<div class="form_row">
	<div class="form_lefts">Hospitalization date</div>
	<div class="form_right"><?php echo $short_context['hospitalization_date']; ?></div>
</div>
<?php } ?>


<?php if (isset($short_context['discharge_date'])) { ?>
<div class="form_row">
	<div class="form_lefts">Discharged date</div>
	<div class="form_right"><?php echo $short_context['discharge_date']; ?></div>
</div>
<?php } ?>


<?php if (isset($short_context['hospital_name'])) { ?>
<div class="form_row">
	<div class="form_lefts">Hospital Name</div>
	<div class="form_right"><?php echo ucfirst($short_context['hospital_name']); ?></div>
</div>
<?php } ?>
