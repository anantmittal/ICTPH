<?php $this->load->helper('form');
      $this->load->library('date_util');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title>Enrolment Form </title>

<script type="text/javascript">
var street_list = new Array(); 
street_list = [      
<?php
foreach ($street_lists as $street_name){
	$id = $street_name->id;
	$name = $street_name->name;
	$village_id = $street_name->village_city_id;
?>
{id: <?php echo $id; ?>, name: "<?php echo ucwords($name); ?>", village_id: "<?php echo $village_id; ?>"},
<?php
}
?>
];
var arrayStoreSlno = new Array();
function onGenderChange(radioObj,selectboxId) {
	if(radioObj.checked){
		if($(radioObj).val() == 'M'){
			var maleRelations = $('#male_relations').html();
			$('#'+selectboxId).html(maleRelations);
		}else if($(radioObj).val() == 'F'){
			var femaleRelations = $('#female_relations').html();
			$('#'+selectboxId).html(femaleRelations);
		}
	}
}
$(document).ready(function(){	
	 var numberOfRowsPopulated = "<?php echo sizeof($members)?>";
	// Events for already populated rows , push i to arrayslno
	 for(var i=1;i <= numberOfRowsPopulated;i++){		
		 arrayStoreSlno.push(i);
	 }
	 
	 $('#streets').change(function(){
			var selected_streets_id = $('#streets :selected').val();		
			$('#household_street').val(selected_streets_id);
			if(selected_streets_id == "others"){
				$('#household_street').val("");
				$('#household_street').show();
			}else{
				$('#household_street').hide();
			}
	});
	var streets_dd="";
	var stree_slected = "<?php echo $street;?>";
	var found_street_in_village = false;
	$.each(street_list, function(i, item) {
		if(item.village_id == <?php echo $village_id_of_city;?>){
			if(item.name == stree_slected){
				found_street_in_village = true;
				streets_dd += '<option value="'+item.id+'" selected="selected">'+item.name+'</option>';
			}else{
				streets_dd += '<option value="'+item.id+'">'+item.name+'</option>';				
			}
		}
	});
	if(!found_street_in_village){
		streets_dd += '<option value="others" selected="selected">Others</option>';
		$('#streets').html(streets_dd);
		$('#streets').change();
		$('#household_street').val(stree_slected);
	}else{
		streets_dd += '<option value="others">Others</option>';
		$('#streets').html(streets_dd);
		$('#streets').change();
	}
	//$('#streets').html(streets_dd);
	//$('#streets').change();
	
	 
	$('#all_relations').hide();
	$('#all_comments').hide();
	$('#male_relations').hide();
	$('#female_relations').hide();
	 
	// Add rows
	$("#add_button").click (function() {
		var temp =numberOfRowsPopulated++;		  
		  var slno = temp+1;
		  arrayStoreSlno.push(slno);
		  var rowContent = '<tr class="row'+slno+'">'+
		    	'<td valign="top" style="padding-top: 20px;" >'+
   		
   				'</td>'+ 
  				'<td>'+ 
     				'<input id="member'+slno+'_name" type="text" name="member'+slno+'_name" size=18 value=""></input>'+     		
     				'<label class="error" id="error_row'+slno+'_name" style="display:none"> Name required </label>'+
     				'<label class="error" id="error_row'+slno+'_name_special_char" style="display:none"> Special characters not allowed. </label>'+
     			'</td>'+
     			 '<td valign="top" style="padding-top: 5px;">'+
     		  	'<table>'+
         			'<tr>'+
         				'<td> <input type="radio" value="F" name="member'+slno+'_gender" checked="checked" > Female </td>'+
     		  		'</tr>'+
     		   	 	'<tr>'+
     		    		'<td> <input type="radio" value="M" name="member'+slno+'_gender"> Male </td>'+
     		  	 	'</tr>'+
     		    '</table>'+ 	
     		  '</td>'+
     		  '<td valign="top" style="padding-top: 5px;">'+
 		  	  '<table>'+
 				'<tr>'+
 					'<td> <input id ="member'+slno+'_age_radio" type="radio" name="member'+slno+'_age_dob_radio" value="Age">Age</input> </td>'+
 					'<td> <input name="member'+slno+'_age" id="member'+slno+'_age" type="text" size= 3 value="" style="display:none" /> </td>'+
 				'</tr>'+
 				'<tr>'+
 					'<td><input id ="member'+slno+'_dob_radio" type="radio" name="member'+slno+'_age_dob_radio" value="DOB" checked >DOB</input> </td>'+	
 	      			'<td><input name="member'+slno+'_dob" id="member'+slno+'_dob" type="text" value="DD/MM/YYYY" class ="datepicker check_dateFormat" onfocus="clearText(this)"	onblur="clearText(this)" style="width:98px;" /> </td>'+
 	      		'</tr>'+
 	       	'</table>'+	      
 	      '</td>'+

 	     '<td valign="top" style="padding-top: 5px;">'+
		  	'<table>'+
				'<tr>'+
					'<td> <select id="member'+slno+'_relation" name="member'+slno+'_relation"> </td>'+
				'</tr>'+
				'<tr>'+
					'<td> <input id="member'+slno+'_relation_other" type="text" size="12" value="" name="member'+slno+'_relation_other" style="display:none;"> </td>'+
				'</tr>'+	
		   	'</table>'+
		  '</td>'+
		  '<td valign="top" style="padding-top: 5px;">'+
		  	'<input id="member'+slno+'_org_id" width="10px" type="text" size="12" value="" <?php if(empty($is_village_outside)) echo "disabled" ;?> name="member'+slno+'_org_id">'+
		  '</td>'+
		  '<td valign="top" style="padding-top: 5px;">'+
		  	'<select id="member'+slno+'_comment" name="member'+slno+'_comment">'+
		  '</td>'+
		  '<td valign="top" align="right" style="padding-top: 5px;">'+		  
	    	'<a href="javascript:void(0);" id="remove_button'+slno+'">Remove </a>'+
	      '</td>'+
		  '</tr>'+	
		  '<tr class="row'+slno+'_error">'+
		  '<td >   </td> '+
		    '<td >   </td> '+
		    '<td >   </td> '+
		    '<td >  <label class="error" id="error_row'+slno+'_age_dob" style="display:none"> DOB cannot be in future </label>'+ 
		    '<label class="error" id="error_row'+slno+'_age_dob_enter" style="display:none"> Enter Age/DOB </label>'+
		    '<label class="error" id="error_row'+slno+'_age_dob_numeric" style="display:none"> Age not in numeric </label>'+
		    '</td>'+
		    '<td > <label class="error" id="error_row'+slno+'_relation_other" style="display:none"> Others required </label> </td> '+
		  '</tr>' ;


		  $('.add_row').before(rowContent);

		  var relations = $('#all_relations').html();
		  $('#member'+slno+'_relation').html(relations);

		  var comments = $('#all_comments').html();
		  $('#member'+slno+'_comment').html(comments);

		  //Gender event	
		  $('input[@name="member'+slno+'_gender"]').change(function(){
			    if ($('input[@name="member'+slno+'_gender"]:checked').val() == 'M'){
				   var maleRelations = $('#male_relations').html();
				   $('#member'+slno+'_relation').html(maleRelations);				   
			    }else{
			       var femaleRelations = $('#female_relations').html();
				   $('#member'+slno+'_relation').html(femaleRelations);
			    }
		});
		$('input[@name="member'+slno+'_gender"]').change();

		//Relation listbox event		
		$('#member'+slno+'_relation').change(function() {
		    var selectedValue = $(this).find("option:selected").text();
		    if(selectedValue == "Other"){
		    	$('#member'+slno+'_relation_other').show();
		    }else{
		    	$('#member'+slno+'_relation_other').hide();
		    }

		});
			
			//Age radio button event
			$('#member'+slno+'_age_radio').change(function(){
				$('#member'+slno+'_age').show();
				$('#member'+slno+'_dob').hide();
				$('.row'+slno+' .ui-datepicker-trigger').hide();
			});


			// DOB radio button event
			$('#member'+slno+'_dob_radio').change(function(){
				$('#member'+slno+'_age').hide();
				$('#member'+slno+'_dob').show();
				$('.row'+slno+' .ui-datepicker-trigger').show();
			});
		  	
		  //datepicker event
		  $(function() {
				$(".datepicker").datepicker({
				dateFormat: 'dd/mm/yy',
				showOn: 'button',
				buttonImage: base_url+'/assets/images/common_images/img_datepicker.gif',
				buttonImageOnly: true});
			});

		// remove event
			$('#remove_button'+slno).click(function() {
				//keepRowCount --;			
				arrayStoreSlno = $.grep(arrayStoreSlno, function(value) {
	   			 return value != slno;
				});
				$('.row'+slno).remove();
				$('.row'+slno+'_error').remove();
		  	});
	});	
	
});

function registerEventsForPopulatedRowsAge(radioId,ageTextId,dateBoxId,rowClass){	
	//Age radio button event
	$('#'+radioId).change(function(){		
		$('#'+ageTextId).show();
		$('#'+dateBoxId).hide();
		$('.'+rowClass+' .ui-datepicker-trigger').hide();
	});
}

function registerEventsForPopulatedRowsDob(radioId,dateBoxId,ageTextId,rowClass){
	//DOB radio button event
	$('#'+radioId).change(function(){
		$('#'+ageTextId).hide();
		$('#'+dateBoxId).show();
		$('.'+rowClass+' .ui-datepicker-trigger').show();
	}); 
}

function relation_listner (memberRelationId,memberRelationOtherId,checkBoxId){	
	    var selectedValue = $('#'+memberRelationId).find("option:selected").text();
	    if(selectedValue == "Other"){	    	
	    	$('#'+memberRelationOtherId).show();
	    }else{
	    	$('#'+memberRelationOtherId).hide();
	    }

	    checkBoxListner(checkBoxId,memberRelationId);	
}

function checkBoxListner(checkBoxId,memberRelationId){	
	if($('#'+checkBoxId).attr("checked")==true){
		 var selectedValue = $('#'+memberRelationId).find("option:selected").text();
		 if(selectedValue == "Self"){
			 alert("Cannot delete a person with relation self, please update the relation ");
			 $('#'+checkBoxId).attr("checked",false);
		 }	 
	}
}


function validateHouseholdForm(){
	clearAllErrorMessages();
	var retValue = true;
	if($('#household_hamlet').val()!=""){
		if (!$('#household_hamlet').val().match(/^\s*[a-zA-Z0-9,\s]+\s*$/)) {
			  $('#error_household_hamlet').show();
			  retValue = false;
		}		
	}

	if($('#household_street').val() == ""){			
			$('#error_household_street_empty').show();
			retValue = false;		
	}
	
	if($('#household_street').val()!=""){
		if (!$('#household_street').val().match(/^\s*[a-zA-Z0-9,\s]+\s*$/)) {
			  $('#error_household_street').show();
			  retValue = false;
		}
	}


	//Iterate over array to validate all fields
	var currentDate = new Date();
	var formattedDate = currentDate.getDate() + '/' + (currentDate.getMonth()+1) + '/' +  currentDate.getFullYear();
	for(i=0;i<arrayStoreSlno.length;i++){		
		//alert(arrayStoreSlno[i]);	
		if($('#member'+arrayStoreSlno[i]+'_name').val() == ""){			
			$('#error_row'+arrayStoreSlno[i]+'_name').show();
			retValue = false;
		}
		if($('#member'+arrayStoreSlno[i]+'_name').val() != ""){
			if (!$('#member'+arrayStoreSlno[i]+'_name').val().match(/^\s*[a-zA-Z0-9,\s]+\s*$/)) {
				$('#error_row'+arrayStoreSlno[i]+'_name_special_char').show();		
				  retValue = false;
			}
		}
		if($('#member'+arrayStoreSlno[i]+'_age').val() == "" && $('#member'+arrayStoreSlno[i]+'_dob').val() == "DD/MM/YYYY" ){			
			$('#error_row'+arrayStoreSlno[i]+'_age_dob_enter').show();
	         retValue = false;			
		}
		if($('#member'+arrayStoreSlno[i]+'_age').val() !="" ) {			
			var age = $('#member'+arrayStoreSlno[i]+'_age').val();
			var bool = /^[0-9]+$/.test(age);
			if(!bool){
				$('#error_row'+arrayStoreSlno[i]+'_age_dob_numeric').show();
				retValue = false;
			}	
		}
		if ($('input[@name="member'+arrayStoreSlno[i]+'_age_dob_radio"]:checked').val() == 'DOB') {
			var uiDate = $('#member'+arrayStoreSlno[i]+'_dob').val();
			 if (Date.parse(uiDate) > Date.parse(formattedDate)) {
				 $('#error_row'+arrayStoreSlno[i]+'_age_dob').show();
		         retValue = false;
		     }
			
		}
		if($('#member'+arrayStoreSlno[i]+'_relation :selected').val() == "Other"){
			if($('#member'+arrayStoreSlno[i]+'_relation_other').val() == ""){
				$('#error_row'+arrayStoreSlno[i]+'_relation_other').show();				
				retValue = false;
			}	
		}	
	}	

	// Relation self validation (not more than 1 self and atleast 1 self)
	var selfCount = 0;
	for(i=0;i<arrayStoreSlno.length;i++){		
		var val = $('#member'+arrayStoreSlno[i]+'_relation :selected').val();		
		if(val == "Self"){
			selfCount++;
		}
	}

	if(selfCount == 0){
		$("#error_self_validation").html("Atleast 1 Self relation is required");
		$("#error_self_validation").show();
		retValue = false;
	}

	if(selfCount >1 ){
		$("#error_self_validation").html("Cannot have more than one Self relation");
		$("#error_self_validation").show();
		retValue = false;
	}

	if(retValue){
		var arrayValues="";
		for(i=0;i<arrayStoreSlno.length;i++){
			arrayValues += arrayStoreSlno[i]+",";
		}
		arrayValues = arrayValues.substring(0, arrayValues.length-1);
		$('#array_data').val(arrayValues);	
	}

	if(retValue){		
		var arrayValues="";
		for(i=0;i<arrayStoreSlno.length;i++){
			arrayValues += arrayStoreSlno[i]+",";
		}
		arrayValues = arrayValues.substring(0, arrayValues.length-1);
		$('#array_data').val(arrayValues);
	}
	

	return retValue;
}

function clearAllErrorMessages(){
	$('.error').hide();	
	for(i=0;i<arrayStoreSlno.length;i++){
		$('#error_row'+arrayStoreSlno[i]).empty();
	}	
}

function clearText(field){
	   if (field.defaultValue == field.value) {field.value = '';field.style.color= '#000000';}
	   else if (field.value == '') {field.value = field.defaultValue;field.style.color= '#000000'}
}

</script>	
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'><span>$success_message</span></div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>


<!--Main Page-->
<div id="main">

  <div class="hospit_box">

<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Edit Household Details</span></div></div></div>
    
<div class="green_body">

<form action="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/edit_add_del/'.$policy_number; ?>" method="POST"
onSubmit="return validateHouseholdForm()">

<?php echo validation_errors(); ?>

 <table  width="100%" border="0" cellspacing="3" cellpadding="3" class="data_table">
<tr>
   	<td style="height: 34px;" width="15%" ><b>Number</td> 
	<td  width="25%"><b><?php echo $policy_number; ?></b></td> 
     	<input type="hidden" name="policy_number" value="<?php echo $policy_number;?>"/>
    <td width="15%"></td>
	<td></td> 

</b>
</tr>
	<tr class="row">     
     <td style="height: 34px;"><b>Village</b></td>
     <td><b><?php echo $village;  if(!empty($is_village_outside)) echo " -" .$is_village_outside; ?></b></td>
   </tr>
   <tr class="row">     
     <td style="height: 34px;">Contact number</td>
     <td><input type="text" name="contact_number" value="<?php echo $contact_number; ?>" size="15" /></td>
   </tr>

   <tr class="row" colspan="3">
     <td style="height: 34px;">Member Address</td>
   </tr>
   <tr>
   <td style="padding-left:20px;height: 34px;" colspan="4">
   	<table width="84%">
   	<tr>
	     <td >Door No<input type="text" name="door_no" value="<?php echo $door_no; ?>"/></td>
	     <td>Street<select name="street_id" id="streets" style="width: 150px"></td>
	     <td>Hamlet<input type="text" id="household_hamlet" name="hamlet" value="<?php echo $hamlet; ?>"/></td>
     </tr>
     <tr>
     	 <td>&nbsp;</td>
	     <td><input id ="household_street" type="text" name="street" value="" size="10"/></td>
	     <td>&nbsp;</td>
     </tr>
     <tr>
		<td><input id="array_data" type="text" name="array_data" value="" style="display: none"></td>		
		
		<td><label class="error" id="error_household_street" style="display: none">Special characters are not allowed.</label>
		    <label class="error" id="error_household_street_empty" style="display: none">Other field required.</label>
		</td>		
		<td><label class="error" id="error_household_hamlet" style="display: none">Special characters are not allowed.</label>
		</td>		
	</tr>
    </table>
    </td>
   </tr>   
	<tr>
		<td>
				<?php echo form_dropdown('all_relations', $relations,'','id=all_relations'); ?>
     			<?php echo form_dropdown('male_relations', $male_relations,'','id=male_relations'); ?>
     			<?php echo form_dropdown('female_relations', $female_relations,'','id=female_relations'); ?>
     			<?php echo form_dropdown('all_comments', $comments, '','id=all_comments'); ?>
     	</td>			
	
	</tr>

</table>
<div style="float:left"><label class="error" id="error_self_validation" style="display: none"></label></div>
 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table" id="edit_add_household_table">
   <tr class="head">     
     <td width="2%">Delete</td>
     <td width="20%">FirstName LastName</td>
     <td width="14%">Gender</td>
     <td width="20%">Age Or Date of birth</td>
     <td width="16%">Relation</td>     
     <td width="14%">PLSP Id</td>
	<td width="9%">Comment</td>
   </tr>

<?php 
  $i = 1;
  foreach ($members as $member) {
  ?>
   <tr class="row<?php echo $i ;?>">
    	<td valign="top" style="padding-top: 20px;" >
     		<input id ="member<?php echo $i ;?>_del" type=checkbox name="member<?php echo $i ;?>_del" value="Yes" <?php if(in_array($member->id, $deleted_members)){echo "disabled=true checked";}?>
     		onchange="checkBoxListner('member<?php echo $i ;?>_del','member<?php echo $i;?>_relation');"/>
     	</td> 
    	<td> 
       		<input id="member<?php echo $i ;?>_name" type="text" name="member<?php echo $i ;?>_name" size=18 value="<?php echo $member->full_name; ?>" <?php if(in_array($member->id, $deleted_members)){echo "disabled=true";}?>></input> 
       		<input type="hidden" name="member<?php echo $i ;?>_id" value="<?php echo $member->id; ?>" />
       		<label class="error" id="error_row<?php echo $i ;?>_name" style="display:none"> Name required </label>
       		<label class="error" id="error_row<?php echo $i ;?>_name_special_char" style="display:none"> Special characters not allowed. </label>
    	</td>

    <td valign="top" style="padding-top: 5px;">
    	<table>
    		<tr>
    			<td> <input type="radio" onclick="onGenderChange(this,'member<?php echo $i;?>_relation');" name="member<?php echo $i;?>_gender" value="F" <?php if($member->gender == 'F'){echo "Checked";} ?> <?php if(in_array($member->id, $deleted_members)){echo "disabled=true";}?> >Female</input> </td>    			
    		</tr>
    		<tr>
    			<td> <input type="radio" onclick="onGenderChange(this,'member<?php echo $i;?>_relation');" name="member<?php echo $i;?>_gender" value="M" <?php if($member->gender == 'M'){echo "Checked";} ?> <?php if(in_array($member->id, $deleted_members)){echo "disabled=true";}?> >Male</input> </td>
    		</tr>
    	</table>		
    </td>
   <td valign="top" style="padding-top: 5px;">
   		<table>
    		<tr>
    			<td><input id ="member<?php echo $i;?>_age_radio" type="radio" name="member<?php echo $i;?>_age_dob_radio" value="Age" <?php if(in_array($member->id, $deleted_members)){echo "disabled=true";}?>
    			onclick="registerEventsForPopulatedRowsAge('member<?php echo $i;?>_age_radio','member<?php echo $i;?>_age','member<?php echo $i;?>_dob','row<?php echo $i ;?>')">Age</input></td>
    			<td><input name="member<?php echo $i;?>_age" id="member<?php echo $i;?>_age" type="text" size= 3 value="" <?php if(in_array($member->id, $deleted_members)){echo "disabled=true";}?> style="display:none" /></td>
    		</tr>
    		<tr>
    			<td><input id ="member<?php echo $i;?>_dob_radio" type="radio" name="member<?php echo $i;?>_age_dob_radio" value="DOB" <?php if(in_array($member->id, $deleted_members)){echo "disabled=true";}?>
    			onclick="registerEventsForPopulatedRowsDob('member<?php echo $i;?>_dob_radio','member<?php echo $i;?>_dob','member<?php echo $i;?>_age','row<?php echo $i ;?>')" checked >DOB</input></td>
    			<td><input id = "member<?php echo $i;?>_dob" type="text" name="member<?php echo $i;?>_dob" value="<?php echo Date_util::date_display_format($member->date_of_birth);?>" onfocus="clearText(this)"
    				class =" <?php if(!in_array($member->id, $deleted_members)){echo "datepicker check_dateFormat";}?>  " onblur="clearText(this)" <?php if(in_array($member->id, $deleted_members)){echo "disabled=true";}?> style="width:98px;"/></td>
    		</tr>
    	</table>
    </td>

    <td valign="top" style="padding-top: 5px;">
    	<table>
    		<tr>
    			<td> <?php 
    				$otherTextBox = "";
    				if(in_array($member->id, $deleted_members)){
    					$js = " id=member".$i."_relation onChange=relation_listner('member".$i."_relation','member".$i."_relation_other','member".$i."_del') disabled";
    				}else{
    					$js = " id=member".$i."_relation onChange=relation_listner('member".$i."_relation','member".$i."_relation_other','member".$i."_del')";
    				}
    			$actuall_relations = $relations;
    			if($member->gender == 'F'){
    				$actuall_relations = $female_relations;
    			}else if($member->gender == 'M'){
    				$actuall_relations = $male_relations;
    			}
    			if (!array_key_exists($member->relation ,$actuall_relations)) {
    				echo form_dropdown('member'.$i.'_relation', $actuall_relations, 'Other',$js);
    				$otherTextBox = "";
    			}else{
	    			echo form_dropdown('member'.$i.'_relation', $actuall_relations, $member->relation,$js);
	    			$otherTextBox = 'style="display:none"';
	    		}	    		
	    		?>
    			</td>
    		</tr>
    		<tr>
    			<td>	
    				<input id="member<?php echo $i;?>_relation_other" type="text" name="member<?php echo $i;?>_relation_other" value="<?php if (!array_key_exists($member->relation ,$relations)) echo $member->relation; ?>" size="12" id="member<?php echo $i;?>_relation_other" 
    				<?php  echo $otherTextBox ?>></input>
    			</td>
    		</tr>
    	</table> 
    </td>
    <td valign="top" style="padding-top: 5px;">    
      <input type="text" size="12" width="10px" name="member<?php echo $i;?>_org_id" value="<?php echo $member->organization_member_id ; ?>" disabled  ></input>
      <input type="hidden" size="12" width="10px" name="member<?php echo $i;?>_org_id" value="<?php echo $member->organization_member_id ; ?>" ></input>
    </td>
	
	<td valign="top" style="padding-top: 5px;">
     	<?php 
     	if(in_array($member->id, $deleted_members)){
     		$js = "disabled";
     	}else{
     		$js = "";
     	}
     	echo form_dropdown('member'.$i.'_comment', $comments, $member->comment,$js); 
     	
     	?> 
    </td>
  </tr>
  <tr class="row<?php echo $i ;?>_error">
  <td >
  </td>
  <td>
  </td>
  <td>
  </td>
  <td >
  <label class="error" id="error_row<?php echo $i ;?>_age_dob" style="display:none"> DOB cannot be in future </label>
  <label class="error" id="error_row<?php echo $i ;?>_age_dob_enter" style="display:none"> Enter Age/DOB </label>
  <label class="error" id="error_row<?php echo $i ;?>_age_dob_numeric" style="display:none"> Age not in numeric </label>
  </td>
  <td >
  <label class="error" id="error_row<?php echo $i ;?>_relation_other" style="display:none"> Others required </label>
  </td>
  </tr>
<?php $i++; 
  }
?>
	<tr class="add_row">
  		<td>
  			<a href="javascript:void(0);" id="add_button">Add</a>  	 
  		</td>
  	</tr> 
</table>

    <div class="form_row">
      <div class="form_newbtn" style="width: 75px;"><input type="submit" name="submit" id="button" value="Submit" class="submit"/></div>
    </div>
    
  </div>
</form>
		  
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
