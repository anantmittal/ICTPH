<?php $this->load->helper('form');
$this->load->view('common/header');
?>

<meta
	http-equiv="Content-Language" content="en" />
<meta name="GENERATOR"
	content="Zend Studio" />
<meta
	http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Diagnosis</title>

<style>
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding: 0px;
}

.maindiv {
	width: 550px;
	margin: auto;
	border: #000000 1px solid;
}

.mainhead {
	background-color: #aaaaaa;
}

.tablehead {
	background-color: #d7d7d7;
}

.row {
	background-color: #e7e7e7;
}

.data_table tr {
	font-size: 11px;
	height: 25px;
	background-color: #e8e8e8;
}

.largeselect {
	width: 200px;
}
</style>
<link
	href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css"
	rel="stylesheet" type="text/css">
<script  type="text/javascript">
//Creating javascript array from php array.
var system_list = new Array();      
system_list = [      
<?php
foreach ($diagnosis_list as $diagnosis){
	$id = $diagnosis->id;
	$value = $diagnosis->value;
	$system = $diagnosis->system_name;
?>
{id: '<?php echo $id; ?>', value: '<?php echo ucwords(addslashes($value)); ?>', system_name: '<?php echo $system; ?>'},
<?php
}
?>
];


$(document).ready(function() {
	$('#add_system_table').hide();
		$('#system_names').change(function(){			
			$("#right_inner_table").find("tr:gt(0)").remove();
			var selected_system = $('#system_names :selected').val();
			var selected_child_items = new Array();
			$.each(system_list, function(key, value) { 
				if((value.system_name == selected_system)){
					$("#system_hidden").html("<input type='hidden' name='system_name' value='"+selected_system+"' />")
				  	if(value.value!=''){
				  		$('#hide_right_table').show();
				  		$('#right_inner_table tr:last').after('<tr><td><input type="checkbox" class="checkbox" name="delete_diagonsis[]" value="' + value.value + '" />'+value.value+'</td></tr>');
				  	}else{
						$('#hide_right_table').hide();
				  	}
				  }
			});
		});
		$('#system_names').change();

		$('#system_val').click(function(){
			$('#add_system_table').show();
			$('#left_inner_table').hide();
			$('#add_diagno_table').hide();
		});

		$('#return').click(function(){
			$('#add_diagno_table').show();
			$('#add_system_table').hide();
			$('#left_inner_table').show();
			$('#error_add_system').hide();
			$('#error_validate_system').hide();
			$('#added_system').val('');
		});
});

function validateAddSystemForm(){
	$('#error_add_system').hide();
	$('#error_validate_system').hide();
	if($.trim($('#added_system').val())==''){
		$('#error_add_system').show();
		return false;
	}else if (!$('#added_system').val().match(/^\s*[a-zA-Z()\/,\s]+\s*$/)) {
		$('#error_validate_system').show();
		return false;
	}
}

function validateSystemTodelete(){
	var ret_val=true;
	var isSystemChecked =false;
	$(".cb-element1").each( function() {
		if($(this).attr("checked")){
			isSystemChecked=true;
		}else{
			
		}
	});
	if(isSystemChecked==false){
		alert('Please select atleast 1 System to delete');
		ret_val = false;
	}else{
		var r=confirm("Are you sure you want to delete System? All diagnosis values under it will be deleted. ");
		if (r==false){
			ret_val= false;
		}
	}
	if(ret_val==false)
		return false;
	
}


function toggleChecked(status) {
	$(".checkbox").each( function() {
	$(this).attr("checked",status);
	});
}

function toggleCheckedSystem(status) {
	$(".cb-element1").each( function() {
	$(this).attr("checked",status);
	});
}



</script>
</head>
<body bgcolor="#FFFFFF" text="#000000"
	link="#FF9966" vlink="#FF9966" alink="#FFCC99">

	<?php $this->load->view('common/header_logo_block');
	$this->load->view('common/header_search');
	?>
	<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'>$success_message </div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>
	<!--Main Page-->
	<div id="main">

		<div id="leftcol">
			<div class="yelo_left">
				<div class="yelo_right">
					<div class="yelo_middle">
						<span class="head_box">Visit Document Configuration</span>
					</div>
				</div>
			</div>
			<div class="yelo_body" style="padding: 8px;">
				<div class="action_items" style="font-weight: bold"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/diagnosis">Diagnosis Configuration</a></div>
				<div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/ros">ROS Configuration</a></div>
				<div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/physical_exam">Physical Exam Configuration</a></div>
				<div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/protocol_information">Protocol Information Configuration</a></div>
				<div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/chief_complaint">Chief Complaints</a></div>
			</div>
			<div class="yelobtm_left">
				<div class="yelobtm_right">
					<div class="yelobtm_middle"></div>
				</div>
			</div>
		</div>
		<div id="rightcol">
			<div class="blue_left">
				<div class="blue_right">
					<div class="blue_middle">
						<span class="head_box">Diagnosis Configuration</span>
					</div>
				</div>
			</div>
			<div class="blue_body" style="padding: 8px;">
					<table width="600" border="0" align="center" cellpadding="5"
						cellspacing="1" class="data_table" id="add_diagno_table">
						<tr><td colspan='2'><div style="float:left;padding:5px;"><a href="javascript:void(0)" id="system_val">System Configuration</a></div></td></tr>
						<tr>
							<td width="60%" valign="top">
							<form method="POST"
									action="<?php echo $this->config->item('base_url').'index.php/admin/visit_document_configuration/diagnosis/add'?>"
									onSubmit="return validateAddDiagnosisForm()">
								<table id="left_inner_table">
									<tr>
										<td><strong>System<strong></strong></td>
										<td><?php echo form_dropdown ( 'system_name', $distnict_system,'','id="system_names"' ); ?></td>
									</tr>
									<?php 
										  for ($i=1; $i < 11; $i++) {
  									?>	
									<tr>
									    <td> <?php echo $i;?>: </td>
									    <td> <input type="text" name="added_value[]" value=""/></td>
									</tr>
									<?php } ?>
									
									<tr>
											<td ><label class="error" id="error_diagno_name" style="display:none">Atleast 1 field is required.</label></td>
									</tr>
									
									<tr>
										<td width="100%" align="right" colspan="2"><input type="submit"
								value="Add" name="submit" class="submit" /></td>
									</tr>
									
								</table>
								</form>

							</td>
							
							<td width="40%" id ="hide_right_table" valign="top">
								<form method="POST"
									action="<?php echo $this->config->item('base_url').'index.php/admin/visit_document_configuration/diagnosis/delete'?>"
									onSubmit="return validateAddDiagnosisForm()" id="myform">
								<div  style="float:left;padding:5px;"><a href="javascript:void(0)" onclick="toggleChecked('checked')">Check all</a></div>
								<div  style="padding:5px;"><a href="javascript:void(0)" onclick="toggleChecked('')">Un Check all</a></div>
								<div id="system_hidden"></div>
								<table id="right_inner_table">
									<tr style="height:0px;">
									</tr>
								</table>
								<div style="padding:10px;" align="right">
									<input type="submit" value="Delete" name="submit" class="submit" /></div>
								</form>
							</td>
						</tr>

					</table>
					
						<table width="600" border="0" align="center" cellpadding="5"
							cellspacing="1" class="data_table" id="add_system_table">	
								<tr>
								
									<td colspan='2' align ='center'>
										<div style="float:left;padding:5px;"><a href="javascript:void(0)" id="return">Back</a></div>
									
									</td>
								 </tr>
								<tr>
									<td valign="top" width="60%">
										<form method="POST" action="<?php echo $this->config->item('base_url').'index.php/admin/visit_document_configuration/diagnosis/add_system'?>" onSubmit="return validateAddSystemForm()">
											<table >
													<tr><td colspan='2' align='center'><b>Add System</b></td></tr>
													<tr >
														<td><strong>System Name:<strong></strong></td>
														<td><input class="required" type="text" id="added_system" name="added_system"  value=""/><label class="error" id="error_add_system" style="display:none"> Please enter System name  </label><label class="error" id="error_validate_system" style="display:none"> System name cannot contain special characters  </label> </td>
													</tr>
													
													<tr>
														<td width="100%" align="right" colspan="2"><input id="submit_system" type="submit"
												value="Add" name="submit" class="submit" /></td>
											</tr>
										</table>
									</form>
								</td>
								<td width="40%" valign='top'>
									
									<form method="POST" action="<?php echo $this->config->item('base_url').'index.php/admin/visit_document_configuration/diagnosis/remove_system'?>" onSubmit="return validateSystemTodelete()">
										<div style="float:left;padding:5px;"><a href="javascript:void(0)" onclick="toggleCheckedSystem('checked')" align="left">Check all</a></div>
										<div style="padding:5px;"><a href="javascript:void(0)" onclick="toggleCheckedSystem('')" align="left">Un Check all</a></div>
										<table id= "system_names">
											
													<?php
				                                         foreach ($distnict_system as $system){
					                                          echo "<tr id='system_size'><td><input type='checkbox'  class='cb-element1'  name='delete_system[]' value='$system'/>";
					                                          echo ucwords(addslashes($system));
					                                          echo "</td></tr>";
				                                         }
	                                    			?>	
	                                    		
										</table>
											<div style="padding:10px;"   valign="bottom">
									<input type="submit" value="Delete System" name="submit" class="submit" /></div>
									</form>
								</td>
							</tr>
						</table>
					
					<br />
					<table align="center" valign="top">
						<tr>
							<td width="50%" align="center">
							
							
						</tr>
					</table>
			</div>
			<div class="bluebtm_left">
				<div class="bluebtm_right">
					<div class="bluebtm_middle"></div>
				</div>
			</div>
		</div>
		<br class="spacer" />


	</div>
	</div>
	<!--Body Ends-->

	<?php $this->load->view('common/footer.php'); ?>