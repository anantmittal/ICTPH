<script type="text/javascript">
  var person_id="<?php echo $person->id; ?>";
</script>

<div class="form_row">
  <div class="form_lefts">Policy ID: </div>
  <div class="form_right">
    <a href="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/search_policy_by_id/opd/'.$policy_id; ?>"><?php echo $policy_id; ?></a>
  </div>
</div>

<div class="form_row">
  <div class="form_lefts">Person ID: </div>
  <div class="form_right">
    <a href="<?php echo $this->config->item('base_url').'index.php/opd/history/overview/'.$person->id.'/'.$policy_id; ?>"><?php echo $person->id; ?></a>
  </div>
</div>

<div class="form_row">
  <div class="form_lefts">Person Name: </div>
  <div class="form_right"><?php echo ucfirst($person->full_name); ?></div>
</div>        

<div class="form_row">
  <div class="form_lefts">Date of Birth: </div>
  <div class="form_right"><?php echo $person->date_of_birth; ?></div>         
</div>


<div class="form_row">
  <div class="form_lefts">Gender:</div>
  <div class="form_right"><?php if($person->gender == 'M')echo "Male"; else echo "Female"; ?></div>
</div>


<div class="form_row">
  <div class="form_lefts">Contact:</div>
  <div class="form_right">
    <?php echo $household->contact_number; ?><br/>
  </div>
</div>
 <?php 
 	
   $visit= $this->visit->get_basic_details_for_last_two_visits($person->id); // you can use max(id)
    
    ?>
			
<div class="form_row">
 <div class="form_lefts">Last visit:</div>
<div class="form_right">
<?php  echo 'CC -'.@$visit[0]['chief_complaint'].', DD -'.@$visit[0]['diagnosis'].''; ?>
      <br/>
  </div>
</div>

<div class="form_row">
  <div class="form_lefts">Second Last visit:</div>
  <div class="form_right">
    <?php  echo 'CC -'.@$visit[1]['chief_complaint'].', DD -'.@$visit[1]['diagnosis'].''; ?><br/>
  </div>
</div>

<div class="form_row" style="display:none">
  <div class="form_lefts">Emergency contact:</div>
  <div class="form_right">Munnu Singh, 09420420420</div>
  </div>


<div class="form_rowb">
  <div></div><div></div>
</div>
