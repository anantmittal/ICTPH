<?php $this->load->helper('form');
      $this->load->library('date_util');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title>Enrolment Form </title>
<style>
.bigselect , #street_list{
	width:207px;
}
</style>

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

$(document).ready(function(){
	$('#all_relations').hide();
	$('#all_comments').hide();
	$('#male_relations').hide();
	$('#female_relations').hide();
	$('#household_street').hide();
	
	var keepRowCount = 1;
	arrayStoreSlno.push(keepRowCount);	

	$('#card_included_y').click(function(){
		$('#card_number_value').show();
		$('#enter_card_td').show();
		$('#village_cities').show();
		$('#outside_village').hide();
		$('#name_of_outside_village').hide();
		$('#name_of_outside_village').val('');		
		$('#streets').empty();
		$('#village_cities').change();
		$('#error_outside_village').hide();
		$('#error_household_street_empty').hide();
	});
	

	$('#village_cities').change(function(){	
		var selected_vc_id = $('#village_cities :selected').val();		
		var streets_dd="";
		$.each(street_list, function(i, item) {			
			if(item.village_id == selected_vc_id){
				streets_dd += '<option value="'+item.id+'">'+item.name+'</option>';
			}
		});
		streets_dd += '<option value="others">Others</option>';
		$('#streets').html(streets_dd);
		$('#streets').change();
	});
	$('#village_cities').change();

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
	$('#streets').change();

	$('#card_included_n').click(function(){
		$('#card_number_value').hide();
		$('#enter_card_td').hide();
		$('#outside_village').show();
		$('#village_cities').hide();
		$('#name_of_outside_village').show();		
		$('#streets').empty();
		$('#streets').html('<option value="others">Others</option>');
		$('#streets').change();		
	});
	
	$('#card_included_n').click();

	// Relation listbox event for first row
	//$('#member1_relation_other').attr("disabled", true);
	$('#member1_relation').change(function() {
	    var selectedValue = $(this).find("option:selected").text();
	    if(selectedValue == "Other"){
	    	$('#member1_relation_other').show();
	    }else{
	    	$('#member1_relation_other').hide();
	    }

	});


	$('input[@name="member1_gender"]').change(function() {
		if ($('input[@name="member1_gender"]:checked').val() == 'M'){
			var maleRelations = $('#male_relations').html();
			   $('#member1_relation').html(maleRelations);
		}else if($('input[@name="member1_gender"]:checked').val() == 'F'){
			var femaleRelations = $('#female_relations').html();
			   $('#member1_relation').html(femaleRelations);
		}
	});
	$('input[@name="member1_gender"]').change();
	// If card number yes clicked disable PISP
	$('input[@name="card_included"]').change(function(){
	    if ($('input[@name="card_included"]:checked').val() == 'Y'){
	    	for (i=0; i < arrayStoreSlno.length ; i++ ){
	    		$('#member'+arrayStoreSlno[i]+'_org_id').attr("disabled", true);
	    	}
	    }
	    else{
	    	for (i=0; i < arrayStoreSlno.length ; i++ ){
	    		$('#member'+arrayStoreSlno[i]+'_org_id').attr("disabled", false);
	    	}
	    }
	});
	
	// Age radio button in first row event
	$('#member1_age_radio').change(function(){
		$('#member1_age').show();
		$('#member1_dob').hide();
		$('.row1 .ui-datepicker-trigger').hide();
	});


	// DOB radio button in first row event
	$('#member1_dob_radio').change(function(){
		$('#member1_age').hide();
		$('#member1_dob').show();
		$('.row1 .ui-datepicker-trigger').show();
	});
	
	
	// Add rows
	$("#add_button").click (function() {
		  var temp =keepRowCount++;  
		  var slno = temp+1;
		  arrayStoreSlno.push(slno);

		  var rowContent = '<tr class="row'+slno+'">'+	  
		  '<td valign="top" style="padding-top: 5px;height:64px;" >'+
		  	'<input id="member'+slno+'_name" type="text" value="" size="18" name="member'+slno+'_name">'+
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
		  	'<input id="member'+slno+'_org_id" width="10px" type="text" size="12" value="" name="member'+slno+'_org_id">'+
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
		    '<td >  <label class="error" id="error_row'+slno+'_age_dob" style="display:none"> DOB cannot be in future </label>'+ 
		    '<label class="error" id="error_row'+slno+'_age_dob_enter" style="display:none"> Enter Age/DOB </label>'+
		    '<label class="error" id="error_row'+slno+'_age_dob_numeric" style="display:none"> Age not in numeric  </label> </td>'+
		    '<td > <label class="error" id="error_row'+slno+'_relation_other" style="display:none"> Others required </label> </td> '+
		  '</tr>' ;
		  
		 $('.add_row').before(rowContent);
			
		var relations = $('#all_relations').html();
		$('#member'+slno+'_relation').html(relations);

		var comments = $('#all_comments').html();
		$('#member'+slno+'_comment').html(comments);

		// Gender event
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
		
		if ($('input[@name="card_included"]:checked').val() == 'Y'){
			$('#member'+slno+'_org_id').attr("disabled", true);
		}else{
			$('#member'+slno+'_org_id').attr("disabled", false);
		}
		
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

	var selected_streets_id = $('#streets :selected').val();	
	if($('#household_street').val()!="" && selected_streets_id == "others"  ){
		if (!$('#household_street').val().match(/^\s*[a-zA-Z0-9,\s]+\s*$/)) {
			  $('#error_household_street').show();
			  retValue = false;
		}
	}
	
	if($('input[@name="card_included"]:checked').val() == 'Y'){
		var cardNumber = $('#policy_id_value_id').val();
		if(cardNumber == ""){
			$('#error_card_num').show();
			retValue = false;
		}
		
		else if(cardNumber.length < 10){
			$('#error_card_num').show();
			retValue = false;
		}
		else if(!cardNumber.match(/^[A-Z]{3}[0-9]{7}$/)) {
			$('#error_card_num').show();
			retValue = false;
		}  	
	}

	if($('input[@name="card_included"]:checked').val() == 'N'){
		if($('#name_of_outside_village').val()==""){
			$('#error_outside_village').show();
			retValue = false;
		}	
	}	

	//Iterate over array to validate all fields
	var currentDate = new Date();
	var formattedDate = currentDate.getDate() + '/' + (currentDate.getMonth()+1) + '/' +  currentDate.getFullYear();
	for(i=0;i<arrayStoreSlno.length;i++){
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
		if ($('input[@name="member'+arrayStoreSlno[i]+'_gender"]:checked').val() != 'M' && 
				$('input[@name="member'+arrayStoreSlno[i]+'_gender"]:checked').val() != 'F'	) {
			$('#error_row'+arrayStoreSlno[i]+'_gender').show();
			retValue = false;

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
    	  <div class="green_middle"><span class="head_box">Add Household Details</span></div></div></div>
    
<div class="green_body">

<form  action="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/add_sgv/'; ?>" method="POST"
onSubmit="return validateHouseholdForm()">

<?php echo validation_errors(); ?>

 <table  width="100%" border="0" cellspacing="3" cellpadding="3" class="data_table">
<tr>
    <td width="15%"  style="height: 34px;">Include card number</td>   
    <td width="25%">
      <input type="radio" name="card_included" value="Y" id="card_included_y">Yes</input>
      <input type="radio" name="card_included" value="N" id="card_included_n" Checked >No</input>
    </td>
    <td width="15%" id="enter_card_td">Enter card number</td>
    <td id="card_number_value"><input id="policy_id_value_id" type="text" name="policy_id_value" />
    <label class="error" id="error_card_num" style="display:none">Incorrect card number format.</label>
    </td>
</tr>
    


   <tr class="row">
     <td style="height: 34px;">Contact number</td>
     <td><input type="text" name="contact_number" value="<?php echo $contact_number; ?>" size="15"/>
   </tr>
	<tr class="row">
     <td>Member Address</td>
   </tr>
   
   <tr>
     <td style="height: 34px;  padding-left: 20px;">Village</td>
     <td><?php echo form_dropdown("village_id", $villages, '', 'id="village_cities"'); ?>
     	 <?php echo form_dropdown("outside_village", $village_outside_catchment, '', 'id="outside_village"'); ?></td>
     <td><input id="name_of_outside_village" type="text" name="name_of_outside_village" />
     <label class="error" id="error_outside_village" style="display: none">Field required.</label></td>
   </tr>
   
   <tr>
   	<td colspan="4" style="padding-left:20px;">
   		<table width="84%" cellspacing="0" cellpadding="0">
			<tr>
					<td width="7%">Door No</td>
					<td width="21%"><input type="text" name="door_no" value="<?php echo $door_no; ?>" size="15"/></td>
					<td width="5%">Street </td>
					<td width="21%"><select name="street_id" id="streets" style="width: 150px"></select></td>
					<td width="6%">Hamlet</td>
					<td width="23%"><input id="household_hamlet" type="text" name="hamlet" value="<?php echo $hamlet; ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input id ="household_street" type="text" name="street" value="" size="10"/></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><input id="array_data" type="text" name="array_data" value="" style="display: none"></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><label class="error" id="error_household_street" style="display: none">Special characters are not allowed.</label>
					    <label class="error" id="error_household_street_empty" style="display: none">Other field required.</label>
					</td>
					<td>&nbsp;</td>
					<td><label class="error" id="error_household_hamlet" style="display: none">Special characters are not allowed.</label>
					</td>
					<td></td>
				</tr>
			</table>
		</td>
   </tr>
   
</table>
<div style="float:left"><label class="error" id="error_self_validation" style="display: none"></label></div>
 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table" id="add_household_table">
   <tr class="head">
     <th width="20%">Full Name</th>
     <th width="14%">Gender</th>
     <th width="18%">Age Or Date of birth</th>
     <th width="16%">Relation</th>
     <th width="14%">PLSP Id</th>
	<th width="9%">Comment</th>
   </tr>

<?php 
  $i=0;
  ?>
  <tr class="row<?php echo ($i +1);?>">
    <td valign="top" style="padding-top: 5px;height:64px;" > 
       <input type="text" name="member1_name" size= 18 value="" id="member1_name" />
       <label class="error" id="error_row1_name" style="display:none"> Name required </label>
       <label class="error" id="error_row1_name_special_char" style="display:none"> Special characters not allowed. </label>
    </td>


    <td valign="top" style="padding-top: 5px;">
    	<table>
    		<tr>
    			<td><input id ="member1_f_gender" type="radio" name="member1_gender" value="F" checked="checked">Female</input></td>
    		</tr>
    		<tr>
    			<td><input id ="member1_m_gender" type="radio" name="member1_gender" value="M">Male</input></td>
    		</tr>
    	</table>
    </td>

    <td valign="top" style="padding-top: 5px;">
    	<table>
    		<tr>
    			<td><input id ="member1_age_radio" type="radio" name="member1_age_dob_radio" value="Age">Age</input></td>
    			<td><input name="member1_age" id="member1_age" type="text" size= 3 value="" style="display:none" /></td>
    		</tr>
    		<tr>
    			<td><input id ="member1_dob_radio" type="radio" name="member1_age_dob_radio" value="DOB" checked >DOB</input></td>
    			<td><input name="member1_dob" id="member1_dob" type="text" value="DD/MM/YYYY" class ="datepicker check_dateFormat"  onfocus="clearText(this)"
    onblur="clearText(this)" style="width:98px;"/></td>
    		</tr>
    	</table>
    </td>

    <td valign="top" style="padding-top: 5px;">
    	<table>
    		<tr>
    			<td>
    				<?php echo form_dropdown('member1_relation', $relations,'','id=member1_relation'); ?>
     				<?php echo form_dropdown('all_relations', $relations,'','id=all_relations'); ?>
     				<?php echo form_dropdown('male_relations', $male_relations,'','id=male_relations'); ?>
     				<?php echo form_dropdown('female_relations', $female_relations,'','id=female_relations'); ?>
    			</td>
    		</tr>
    		<tr>
    			<td>
    				<input type="text" name="member1_relation_other" value="" size="12" id="member1_relation_other" style="display: none"></input>
    			</td>
    		</tr>
    	</table>
    </td>
	<td valign="top" style="padding-top: 5px;">
      <input type="text" name="member1_org_id" value="" width="10px" size="12" id="member1_org_id"></input>
    </td>
	<td valign="top" style="padding-top: 5px;">
     <?php echo form_dropdown('member1_comment', $comments, '','id=member1_comment'); ?>
      <?php echo form_dropdown('all_comments', $comments, '','id=all_comments'); ?>
    </td>
    <td valign="top" align="right" style="padding-top: 5px;">
    	<a href="javascript:void(0);" id="remove_button1">Remove</a> 
    </td>
  </tr>
  <tr class="row1_error">
    <td >
    </td>
    <td>
    </td>
    <td > 
    <label class="error" id="error_row1_age_dob" style="display:none"> DOB cannot be in future </label>
    <label class="error" id="error_row1_age_dob_enter" style="display:none"> Enter Age/DOB </label>
    <label class="error" id="error_row1_age_dob_numeric" style="display:none"> Age not in numeric </label>
    </td>
    <td > 
    <label class="error" id="error_row1_relation_other" style="display:none"> Others required </label> 
    </td>
  </tr>
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
