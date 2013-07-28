<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title><?php
if (isset ( $org_obj->name ))
	echo 'Edit Organization Details';
else
	echo 'Add Organization Details';
?></title>

<script type="text/javascript">
function ValidateOrgForm(){
	clearAllErrorMessages();
	var retVal = true;
	if( $.trim($("#org_name").val())!="" ){
    	var name=$('#org_name').val();
		if (!$('#org_name').val().match(/^\s*[a-zA-Z,\s]+\s*$/)) {
			$('#validate_name').show();
			retVal= false;		
		}
	}
	if($.trim($("#org_name").val())==""){
		$('#empty_name').show();
		retVal= false;
	}
	
	if($.trim($("#org_license_no").val())=="" ){
		$('#empty_licence_name').show();
		retVal= false;
	}
	return retVal;
}

function clearAllErrorMessages(){
	$('.error').hide();
}

</script>

</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>

<table width="60%" align="center">
	<tr>
		<td>

		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">
		<?php
		if (isset ( $org_obj->name ))
			echo 'Edit Organization Details';
		else
			echo 'Add Organization Details';
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

		<form method="post" onSubmit="return ValidateOrgForm()">
		<table border="0" align="center" width="80%">
		<?php
			if (isset ( $org_obj->id )) { ?>
			<tr>
				<td><b>Organization ID</b></td>
				<td>
			<?php
				echo $org_obj->id ;

			?></td>

			</tr>
			<?php } ?>
			<tr>
				<td><b>Name</b><span style="color:#FF0000">*</span></td>
				<td><input type="text" name="name" id="org_name"
					value="<?php
					if (isset ( $org_obj->name ))
						echo $org_obj->name;
					?>" ><label class="error" id="empty_name" style="display:none"> Name field cannot be empty  </label>  <label class="error" id="validate_name" style="display:none"> Name cannot contain special characters and numbers </label></td>
					
			</tr>

			<tr>
				<td><b>Type</b></td>
				<td>
					<?php
					//@todo : Remove this array and put it in to config file
					$type_enums = array ('Marketing' => 'Marketing', 'Manufacturer' => 'Manufacturer', 'Distributor' => 'Distributor', 'Warehouse' => 'Warehouse', 'Clinic' => 'Clinic','Hospital' => 'Hospital','Pharmacy' => 'Pharmacy', 'CHW' => 'CHW' );
					
					if (isset ( $org_obj->type ))
						$selected = $org_obj->type;
					else
						$selected = 'Manufacturer';
					
					echo form_dropdown ( 'type', $type_enums, $selected );
					?>
				</td>
			</tr>
			
			<tr>
					<td><b>Origin</b></td>
					<td>	
						
						<?php
						$origin_type_enums = array ('CONSUMPTION' => 'Consumption','DISTRIBUTION' => 'Distribution', 'EXTERNAL' => 'External');
						if (isset ( $org_obj->origin ))
							$selected = $org_obj->origin;
						else
							$selected = 'Internal';
						
						echo form_dropdown ( 'origin', $origin_type_enums, $selected );
						?>
					</td>
			</tr>
			
			
			<tr>
				<td><b>Full Address</b></td>
				<td><textarea rows="5" cols="30" name="address" ><?php
				if (isset ( $org_obj->address ))
					echo $org_obj->address;
				?></textarea></td>
			</tr>

			<tr>
				<td><b>Phone No</b></td>
				<td><input type="text" size="15" name="phone_no"
					value="<?php
					if (isset ( $org_obj->phone_no ))
						echo $org_obj->phone_no;
					?>"></td>
			</tr>

			<tr>
				<td><b>License No</b><span style="color:#FF0000">*</span></td>
				<td><input type="text" size="40" name="license_no" id="org_license_no"
					value="<?php
					if (isset ( $org_obj->license_no ))
						echo $org_obj->license_no;
					?>"><label class="error" id="empty_licence_name" style="display:none"> Licence field cannot be empty  </label></td>
			</tr>

			<tr>
				<td><b>Price List</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
$pl_enums = array ('1'=> 'Default','2' => 'Doctor Retail', '3' => 'Doctor Wholesale','4' => 'Doctor Health Assistant', '5' => 'Pharmacy','6' => 'Haryana', '7' => 'SGV', '8' => 'SAST CHW', '9' => 'SAST Clinic' );

if (isset ( $org_obj->pl_id ))
	$selected = $org_obj->pl_id;
else
	$selected = '1';

echo form_dropdown ( 'pl_id', $pl_enums, $selected );
?>

</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="submit" value="Add"></td>
			</tr>
		</table>
		</form>


		</div>
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>
		</div>
		</div>
		</td>
	</tr>
</table>

<?php
$this->load->view ( 'common/footer' );
?>
