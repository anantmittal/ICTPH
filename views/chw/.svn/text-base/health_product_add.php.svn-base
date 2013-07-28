<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title><?php
if (isset ( $product_obj->name ))
	echo 'Edit Health Product';
else
	echo 'Add Health Product';
?></title>
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
		if (isset ( $product_obj->name ))
			echo 'Edit Health Product';
		else
			echo 'Add Health Product';
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

		<form method="post">
		<table border="0" align="center" width="">
		<?php
			if (isset ( $product_obj->id )) { ?>
			<tr>
				<td><b>Product ID</b></td>
				<td>
			<?php
				echo $product_obj->id ;

			?></td>

			</tr>
			<?php } ?>
			<tr>
				<td><b>Brand Name</b></td>
				<td><input type="text" name="name"
					value="<?php
					if (isset ( $product_obj->name ))
						echo $product_obj->name;
					?>"></td>
			</tr>
			<tr>
				<td><b>Generic Name</b></td>
				<td><input type="text" name="generic_name"
					value="<?php
					if (isset ( $product_obj->generic_name ))
						echo $product_obj->generic_name;
					?>"></td>
			</tr>
			<tr>
				<td><b>Description</b></td>
				<td><textarea rows="3" cols="25" name="description"><?php
				if (isset ( $product_obj->description ))
					echo $product_obj->description;
				?></textarea></td>
			</tr>
			<tr>
				<td><b>Form</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
$form = array ('tablet' => 'Tablet', 'capsule' => 'Capsule', 'drops' => 'Drops', 'cream' => 'Cream', 'syrup' => 'Syrup', 'other' => 'Other' );

if (isset ( $product_obj->form ))
	$selected = $product_obj->form;
else
	$selected = '';

echo form_dropdown ( 'form', $form, $selected );
?>

<!--<select name="form">
<option value="tablet">Tablet</option>
<option value="capsule">Capsule</option>
<option value="drops">Drops</option>
<option value="cream">Cream</option>
<option value="syrup">Syrup</option>
<option value="other">Other</option>
</select>  --></td>
			</tr>


			<tr>
				<td><b>Form of pack</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
// @todo : also check for the missing options
$pack_form = array ('bottle' => 'Bottle', 'strip' => 'Strip','tube' =>'Tube', 'other' => 'Other');

if (isset ( $product_obj->pack_form ))
	$selected = $product_obj->pack_form;
else
	$selected = '';
echo form_dropdown ( 'pack_form', $pack_form, $selected );
?>
<!--<select name="pack_form">
					<option value="bottle">Bottle</option>
					<option value="">Tablet</option>
					<option value="strip">Strip</option>
					<option value="">Capsule</option>
					<option value="tube">Tube</option>
					<option value="other">Other</option>
				</select>
	--></td>
			</tr>

			<tr>
				<td><b>Num dosages/pack</b></td>
				<td><input type="text" size="5" name="pack_num_dosages"
					value="<?php
					if (isset ( $product_obj->pack_num_dosages ))
						echo $product_obj->pack_num_dosages;
					?>"></td>
			</tr>
			<tr>
				<td><b>Sale Price/Pack</b></td>
				<td><input type="text" size="5" name="pack_sale_price"
					value="<?php
					if (isset ( $product_obj->pack_sale_price ))
						echo $product_obj->pack_sale_price;
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
