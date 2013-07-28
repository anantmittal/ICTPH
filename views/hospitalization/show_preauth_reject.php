<link href="<?php echo "{$this->config->item('base_url')}assets/css/site.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function(){
	$("#reject_form").validate();
});

</script>
<?php 
//	$policy_id= $this->uri->segment(4);
	$pre_auth_id= $this->uri->segment(4);
?>

<form method="POST" action="<?php echo $this->config->item('base_url').'index.php/hospitalization/preautherization/save_reject_reason'?>"  id="reject_form">

  <div class="form_row">
     <div><strong>Reason for Preautt Rejection </strong></div><br />
     <div class="form_right"><textarea cols="50" rows="8" name="reason" class="required"></textarea>
     <input type="hidden" name="pre_auth_id" value="<?php echo $pre_auth_id;?>" />
     <input type="hidden" name="policy_id" value="<?php //echo $policy_id;?>" />
     <div><br />
     <div><input type="submit" name="button" id="button" value="Submit Reason"  class="submit" />
     </div>
      
  </div>

</form>
