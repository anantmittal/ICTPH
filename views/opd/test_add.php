<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title><?php
if (isset ( $test_obj->name ))
	echo 'Edit Test';
else
	echo 'Add Test';
?></title>
</head>
<script>
$(document).ready(function(){
	$('#bill_type').change(function() { 
		var b_type = $('#bill_type').val();
//		alert (' v_type = ' + v_type);
		if(b_type == "Group")
		{
    			$("#group_select").show();
    			return ;
		}
		else
		{
    			$("#group_select").hide();
    			return ;
		}
	});
	$("#group_select").hide();
});
</script>

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
		if (isset ( $test_obj->name ))
			echo 'Edit Test';
		else
			echo 'Add Test';
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

		<form method="post">
		<table border="0" align="center" width="">
		
		
		<?php
			if (isset ( $test_obj->is_test_enabled ) && $test_obj->is_test_enabled!=1) { ?>
			<tr>
				
				<td colspan='2'><span style="color:#FF0000"><b>This Test is Disabled</b></span></td>

			</tr>
			
			<?php }?>
		<?php
			if (isset ( $test_obj->id )) { ?>
			<tr>
				<td><b>Test ID</b></td>
				<td>
			<?php
				echo $test_obj->id ;

			?></td>

			</tr>
			<?php } ?>
			<tr>
				<td><b>Name</b></td>
				<td><input type="text" name="name"
					value="<?php
					if (isset ( $test_obj->name ))
						echo $test_obj->name;
					?>"></td>
			</tr>
			<tr>
				<td><b>Description</b></td>
				<td><textarea rows="3" cols="25" name="description"><?php
				if (isset ( $test_obj->description ))
					echo $test_obj->description;
				?></textarea></td>
			</tr>
			
			<tr>
				<td></td>
				<td><input type="checkbox" name="test_status"
					<?php
					if (isset ( $test_obj->is_test_enabled ) && $test_obj->is_test_enabled!=1){
						?> checked="checked"><?php 
					}?>  <b>Disable Test</b></td>
			</tr>
			

			<tr>
				<td><b>Type</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
$test_types = array ('Strip' => 'Strip', 'Sample' => 'Sample', 'Refer' => 'Refer', 'Procedure'=>'Procedure');

if (isset ( $test_obj->type ))
	$selected = $test_obj->type;
else
	$selected = 'Sample';

echo form_dropdown ( 'type', $test_types, $selected );
?>

			</td>
			</tr>

		<tr>
				<td><b>Result Type</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
$testresult_types = array ('Boolean' => 'Boolean', 'Number' => 'Number');

if (isset ( $test_obj->result_type ))
	$selected = $test_obj->result_type;
else
	$selected = 'Number';

echo form_dropdown ( 'result_type', $testresult_types, $selected );
?>

			</td>
			</tr>

		<tr>
				<td><b>Bill Type</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
$testbill_types = array ('Single' => 'Single', 'Group' => 'Group');

if (isset ( $test_obj->bill_type ))
	$selected = $test_obj->bill_type;
else
	$selected = 'Single';

echo form_dropdown ( 'bill_type', $testbill_types, $selected,' id="bill_type"' );
?>

			</td>
			</tr>

		<tr id="group_select">
		<td><b>Parameters in the Group</b></td>
		<td>
	  		<?php
	  		      foreach ($tests as $t) {
				if($t->bill_type =='Single' && $t->is_test_enabled==1) {
				?>
				<input name="group[]" TYPE="CHECKBOX" VALUE="<?php echo $t->id;?>"><?php echo $t->name;?><BR>
	  		<?php }} ?>
		</td>
		</tr>

			<tr>
				<td><b>Cost per Test</b></td>
				<td><input type="text" size="5" name="cost"
					value="<?php
					if (isset ( $test_obj->cost ))
						echo $test_obj->cost;
					?>"></td>
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
