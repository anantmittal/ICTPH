<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>Followup Details</title>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript">
var isDateValid = true;
$(document).ready(function(){
	var actuall_date_value = "<?php echo Date_util::date_display_format($followup_info->due_date);?>";
	$('#due_date').change(function(){
		var altered_date_value = $('#due_date').val();
		if(altered_date_value === "DD/MM/YYYY" || altered_date_value === ""){
			$("#error_followup_date").show(500);
			isDateValid = false;
		}else if(!valid_date(altered_date_value)){
			$("#error_followup_date").show(500);
			isDateValid = false;
		}else{
			var actuall_date = new Date();
			var current_date = new Date();
			if(typeof actuall_date_value !== 'undifined' && actuall_date_value !== ""){
				actuall_date = parse_date(actuall_date_value);
			}
			if(actuall_date > current_date){
				actuall_date = current_date;
			}
			var altered_date = parse_date(altered_date_value);
			if(altered_date < actuall_date){
				$("#error_followup_date").show(500);
				isDateValid = false;
			}else{
				$("#error_followup_date").hide(500);
				isDateValid = true;
			}
		}
	});
});

function parse_date(input){
	var parts = input.match(/(\d+)/g);
  	return new Date(parts[2], parts[1]-1, parts[0]); // months are 0-based
}

function valid_date(input){
	var parts = input.match(/(\d+)/g);
	if(parts.length < 3){
		return false;
	}
	return true;
}

function validateForm(){
	clearErrorFields();
	var retVal = true;
	if($('#comments_text').val()==""){
		$('#error-comment').show();
		retVal = false;
	}
	if($('#comments_text').val().length > 250){
		alert("Maximum characters allowed are 250");
		retVal = false;
	}
	$("#due_date").change();
	if(!isDateValid){
		retVal = false;
	}
	return retVal;
}

function clearErrorFields(){
	$('.error').hide();
}

</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>
<div id="main">
	<div class="hospit_box">
		<div class="green_left">
			<div class="green_right">
				<div class="green_middle">
					<span class="head_box">Followup Details</span>
				</div>
			</div>
		</div>
		<div class="green_body">
		<form  action="<?php echo $this->config->item('base_url').'index.php/opd/visit/update_followup_info/'; ?>" method="POST" onSubmit="return validateForm()">
			<table  width="100%" border="0" cellspacing="5" cellpadding="5" class="data_table">
				<tr>
					<td width="12%"> <b> Followup Id  </b></td>
					<td width="3%"> <b> : </b> </td>
					<td> <?php echo $followup_info->id;?> <input type="hidden" name="followup_id" value="<?php echo $followup_info->id;?>" /></td>					
				</tr>
				<tr>
					<td> <b> Person </b></td>
					<td> <b> : </b> </td>
					<td> <a href="<?php echo $this->config->item('base_url').$person_link_url.$followup_info->person_id;?>"> <?php echo $person_name;?></td>					
				</tr>
				<tr>
					<td> <b> Policy Id  </b></td>
					<td> <b> : </b> </td>
					<td> <?php echo $policy_id;?></td>					
				</tr>
				
				<tr>
					<td valign="top"> <b> Address  </b></td>
                    <td valign="top"> <b> : </b> </td>
                    <td valign="top"> <?php if(isset($street)) {echo $street.',';}else{echo '';}if(isset($areas)){ echo $areas.',<br/>';}else{ echo '<br/>';}?>
                    	<?php if(isset($village)) {echo $village.',';}else{echo '';}if(isset($taluka)) {echo $taluka.',<br/>';}else{ echo '<br/>';}?>
                        <?php if(isset($district)) {echo $district.'.';}?>
                    </td>                                        
                </tr>
				
				<tr>
					<td> <b> Contact Number  </b></td>
					<td> <b> : </b> </td>
					<td> <?php if(isset($contact_number)) echo $contact_number;?></td>					
				</tr>
				<tr>
					<td> <b> Visit Id  </b></td>
					<td> <b> : </b> </td>
					<td> <a href="<?php echo $this->config->item('base_url').$visit_link_url.$followup_info->visit_id;?>"> <?php echo $followup_info->visit_id;?> </td>					
				</tr>
				<tr>
					<td> <b> Protocol  </b></td>
					<td> <b> : </b> </td>
					<td> <?php echo $followup_info->protocol;?></td>
				</tr>
				<tr>
					<td> <b> Followup Task  </b></td>
					<td> <b> : </b> </td>
					<td> <?php echo $followup_info->next_action;?></td>
				</tr>
				<tr>
					<td> <b> Doctor  </b></td>
					<td> <b> : </b> </td>
					<td> <?php echo ucwords($followup_info->created_by);?></td>
				</tr>
				<tr>
					<td> <b> Assigned to  </b></td>
					<td> <b> : </b> </td>
					<td> <?php echo form_dropdown('assigned_to', $username_list,$followup_info->assigned_to,'id=usernames'); ?></td>
				</tr>
				<tr>
					<td> <b> Due date  </b></td>
					<td> <b> : </b> </td>
					<td> 
						<div style="float:left"><input id="due_date" name="due_date" type="text" readonly="readonly" size="10" value="<?php echo Date_util::date_display_format($followup_info->due_date);?>" class ="datepicker check_dateFormat" /></div>
						<div style="float:left"><label id="error_followup_date" class="error" style="display:none"> Follow up date should be in future</label></div>
					</td>
				</tr>
				<tr>
					<td> <b> Status  </b></td>
					<td> <b> : </b> </td>
					<td> <?php echo form_dropdown("state", array('OPEN' => 'OPEN','CLOSED' => 'CLOSED'), $followup_info->state, 'id="state"'); ?></td>
				</tr>
				<tr>
					<td> <b> Comments<span class="mandatory">*</span>  </b><br /> (Max 250 chars)</td>
					<td> <b> : </b> </td>
					<td> <textarea rows="3" cols="25" name="comments_text" id="comments_text"></textarea><label id="error-comment" class="error" style="display:none"> Please enter comments </td>
				</tr>
			</table>
			<div class="form_row">
				<div class="form_newbtn" style="width: 75px;">
					<input id="button" class="submit" type="submit" value="Submit" name="submit">
				</div>
			</div>
			</form>
			<br/>
			<div id="history" style="padding-left: 10px;">
				<h3> History </h3>
				<hr>
				<br/>
				
				<?php  foreach ($followup_history_recs as $followup_hist_rec) {?>
				<div class="history">
					 Updated by <?php echo ucwords($followup_hist_rec->updated_by);?> on <?php echo $followup_hist_rec->date;?> 
					<ul>
						<?php if(!empty($followup_hist_rec->updated_parameter)){ ?>
							<li style="list-style: disc outside none; margin-left: 35px;"> <b> <?php echo $followup_hist_rec->updated_parameter;?></b> changed to <i> <?php echo $followup_hist_rec->updated_value;?> </i>   </li>
							<?php if(!empty($followup_hist_rec->remarks)){ ?>
								<li style="list-style: disc outside none; margin-left: 35px;"> <?php echo $followup_hist_rec->remarks;?>    </li>
							<?php }?>
						<?php }?>
						<?php if(empty($followup_hist_rec->updated_parameter)){ ?>
							<li style="list-style: disc outside none; margin-left: 35px;"> <?php echo $followup_hist_rec->remarks;?>    </li>
						<?php }?>
					</ul>
				</div>
				<br/>
				<?php }?>
				<?php  if(sizeof($followup_history_recs) < 1) { ?>
				 	No History to display 
				<?php }?>
			</div>
		</div>
			
		<div class="greenbtm_left">
			<div class="greenbtm_right">
				<div class="greenbtm_middle"></div>
			</div>
		</div>
		</div>
</div>


<?php $this->load->view('common/footer.php'); ?>
