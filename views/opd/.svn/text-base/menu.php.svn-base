<!-- <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/menu.js"; ?>"></script> -->
<script type="text/javascript">
$(document).ready(function(){
	var hew = "<?php echo $hew_login ;?>";
	if(hew){
		$('#add_visit').hide();
		$('#add_lab_visit').hide();		
	}else{
		$('#add_visit').show();
		$('#add_lab_visit').show();		
	}	
});
	
</script>
  <div class="form_row; patient_box">
  <a href="<?php echo $this->config->item("base_url").'index.php/opd/history/overview/'.$person->id.'/'.$policy_id; ?>">Overview</a><br/>
  <a id="list_visits"href="<?php echo $this->config->item("base_url").'index.php/opd/visit/list_/'.$person->id.'/'.$policy_id; ?>" ?>Visits</a><br/>
  <a id="add_visit" href="<?php echo $this->config->item('base_url').'index.php/opd/visit/add/'.$person->id.'/'.$policy_id ?>">Add Visit</a><?php if(!$hew_login) echo "<br/>"; ?>
  <a id="add_lab_visit" href="<?php echo $this->config->item('base_url').'index.php/opd/lab/add_visit/'.$person->id.'/'.$policy_id ?>">Add Diagnostic Visit</a><?php if(!$hew_login) echo "<br/>"; ?>
  <a id="add_pisp" href="<?php echo $this->config->item('base_url').'index.php/plsp/queryhhform/mne_pisp_launcher/'.$person->id.'/'.$policy_id ?>">Administer PISP</a>

 <!-- <a id="add_visit" href="<?php echo $this->config->item('base_url').'index.php/opd/visit/add_basic/'.$person->id.'/'.$policy_id ?>">Add Basic Visit</a>-->

<!--
  <select id="visit_type" name="visit_type" class="">
    <option value="general" selected="selected">General</option>

    <?php // if (is_ped_eligible($person)) { ?>
    <option value="pediatric">Pediatric</option>
    <?php // } ?>

    <?php // if (is_obgyn_eligible($person)) { ?>
    <option value="obstetric">Obstetric</option>
    <?php // } ?>

  </select><br/>

  
  <a href="<?php echo $this->config->item('base_url').'index.php/opd/immunization/list_/'.$person->id.'/'.$policy_id ?>">Immunization History</a><br/>
  <a href="labs.shtml">Labs</a>
  <a href="<?php echo $this->config->item("base_url").'index.php/opd/history/overview/'.$person->id.'/'.$policy_id; ?>">Immunization</a><br/>
  <a href="<?php echo $this->config->item("base_url").'index.php/opd/history/overview/'.$person->id.'/'.$policy_id; ?>">Labs</a><br/>
  -->
  </div>

