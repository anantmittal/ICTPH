<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>Protocol History</title>
<script type="text/javascript">

function filterProtocolHistory(checkboxName){
	//Handles : If all the checkboxes are unchecked then return 
	if($("input[name='filters[]']:checked").length==0){
		alert("Atleast 1 checkbox needs to be checked");
		$('#'+checkboxName).attr('checked','checked');
		return;
	}	
	// Handles: When other checkboxes are checked and then trying to check 'All' checkbox should uncheck other checkboxes and check only 'All' checkbox 
	if(checkboxName == "all"){
		var isChecked = $('#'+checkboxName).is(':checked');
		if(isChecked){			
			$('#'+checkboxName).attr('checked','checked');
			$("input:checkbox[name^='filters']").each(function() {
				var protocolValue =  $(this).val();
				if(protocolValue != "all")
					$('#'+protocolValue).attr('checked',false);
	        });
		}	
			
	}
	// Handles : When 'All' checkbox is already checked and then trying to check some other checkbox(s) then 'All' checkbox is unchecked 
	else{
		var isChecked = $('#all').is(':checked');
		if(isChecked){			
			$('#all').attr('checked',false);
		}	
		
	}	
	var submitUrl ="<?php echo $this->config->item('base_url').'index.php/opd/visit/filter_protocol_history/';?>";	
	$('#filter_protocol_history_form').attr('action', submitUrl);
	$('#filter_protocol_history_form').submit();
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>
<div id="main">
	<div class="hospit_box">
		<div class="blue_left">
			<div class="blue_right">
				<div class="blue_middle">
					<span class="head_box">Protocol History</span>
				</div>
			</div>
		</div>
		<div class="blue_body">
			<table  width="100%" border="0" cellspacing="5" cellpadding="5" class="data_table">			
				<tr>
					<td width="12%"> <b> Name  </b></td>
					<td width="3%"> <b> : </b> </td>
					<td> <?php echo $person_rec->full_name;?></td>
				</tr>
				<tr>
					<td> <b> Age  </b></td>
					<td> <b> : </b> </td>
					<td> <?php 
							$dob = $person_rec->date_of_birth;
							$dob_array = explode("-" , $dob);
							$age = date("Y") - $dob_array[0];
							echo $age." y";
						 ?>
					
					</td>
				</tr>
				<tr>
					<td> <b> Policy  </b></td>
					<td> <b> : </b> </td>
					<td><a href="<?php echo $this->config->item('base_url').$policy_link_url.$household_rec->policy_id;?>">  <?php echo $household_rec->policy_id;?></td>
				</tr>
				
			</table>
			
			<!-- Filters -->
			<div style="text-align: center;"> <b>Filters</b></div>			
				<table align="center" cellpadding="5" class="main_table" >
				<form id ="filter_protocol_history_form" method="POST">
					<input type="hidden" value="<?php echo $person_rec->id?>" name="person_id">
					<tr>
						<?php 
						if(isset($check_all) || (isset($checked_protocols) && sizeof($checked_protocols)==0 ))
							$checked = "checked";
						else
							$checked = "";			
						?>
					
						<td><input type="checkbox" id ="all" name ="filters[]" value="all" onClick="filterProtocolHistory('all')" <?php echo $checked; ?> /> All </td>
					</tr>
					<?php 
						foreach ($all_protocols as $protocol) {
							if(isset($checked_protocols) && in_array($protocol->value , $checked_protocols))
								$checked = "checked";
							else
								$checked = "";
							echo "<tr> <td><input type=\"checkbox\" id=\"$protocol->value\" name =\"filters[]\" value=\"$protocol->value\" onClick=\"filterProtocolHistory('$protocol->value')\" $checked />  $protocol->value </td></tr>";				
					 	}
					 ?>
					 </form>
				</table>
			
			
			<table  width="100%" border="1" cellspacing="2" cellpadding="0" class="data_table" style="border: 1px solid;">
				<tr class="head">
					<td style="width: 11%;">Date</td>
					<td style="width: 11%;">Visit</td>
					<td style="width: 11%;">Protocol</td>
					<td style="width: 17%;">Details</td>
					<td style="width: 25%;">Followups</td>					
				</tr>
				
				<?php $i=0;
					foreach($followup_info_records as $followup_info_rec) { 	?>
					<tr class="row">
						<td> <?php echo $followup_info_rec->due_date; ?> </td>
						<td> <a href="<?php echo $this->config->item('base_url').$visit_link_url.$followup_info_rec->visit_id;?>"> <?php echo $followup_info_rec->visit_id; ?> </a> </td>
						<td> <?php echo $followup_info_rec->protocol; ?> </td>
						<?php $visit = $values[$i]['visit_rec'];						
							  $protocol_information_entries = $this->visit_protocol_information_entry->where('name',$followup_info_rec->protocol)->where('visit_id',$visit->id)->find_all();//$visit->related('visit_protocol_information_entries')->get();//Protocol Information
							  if(empty($protocol_information_entries)){
							  	echo "<td> No Information recorded </td>" ; 
							 }
							  else{
							  	echo "<td>";
							  	foreach ($protocol_information_entries as $protocol) {
							  		if ($protocol->status == 'Yes') {
							     			$details = $protocol->details;
							  			if($details != null){
							  				$displayer->parse_vist_json($details);
							  			}
							  		}
							  	}	
							  }		  
							  	
						
						?>
						
						<td> <a href="<?php echo $this->config->item('base_url').$link_url.$followup_info_rec->id;?>"> <?php echo $followup_info_rec->id; ?> </a> </td>
					</tr>
				<?php $i++ ; } ?>
			</table>
		</div>
			
		<div class="bluebtm_left">
			<div class="bluebtm_right">
				<div class="bluebtm_middle"></div>
			</div>
		</div>
		</div>
</div>


<?php $this->load->view('common/footer.php'); ?>
