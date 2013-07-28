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
			if (isset($is_product_enabled) && $is_product_enabled==1) { ?>
					<tr>
						<td colspan="2"><span style="color:#FF0000"><b>Product <?php echo $product_obj->name;?> is disabled.</b></span></td>
		
					</tr>
			<?php } ?>
		
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
				<td>
				<?php
					if (isset ( $product_obj->generic_id ))
						$g_selected = $product_obj->generic_id;
					else
						$g_selected = 1;

					echo form_dropdown ( 'generic_id', $gxs, $g_selected );
				?>
				</td>
			</tr>
			<tr>
			<td></td><td>
			<a href="<?php echo $this->config->item('base_url').'index.php/scm/product/add_generic'; ?>">Click here to add new Generic</a>
			</td>
			</tr>
<!--
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
				<td><b>Strength</b></td>
				<td><input type="text" size="20" name="strength"
					value="<?php
					if (isset ( $product_obj->strength ))
						echo $product_obj->strength;
					?>"></td>
			</tr>

			<tr>
				<td><b>Strength Unit</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
$s_unit = array ('mg' => 'Mg', 'microg' => 'Micro Gm', 'ml' => 'Ml', 'conc' => 'V/V', 'mgml' => 'Mgms / Ml','lpm' => 'lpm','Other' );

if (isset ( $product_obj->strength_unit ))
	$selected = $product_obj->strength_unit;
else
	$selected = 'mg';

echo form_dropdown ( 'strength_unit', $s_unit, $selected );
?>

</td>
			</tr>

			<tr>
				<td><b>Form</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
$form = array ('tablet' => 'Tablet', 'capsule' => 'Capsule', 'drops' => 'Drops', 'cream' => 'Cream', 'syrup' => 'Syrup', 'proc' => 'Procedure', 'cons' => 'Consumable',
		'IV' => 'IV', 'IM' => 'IM', 'SC'=>'SC','inj' => 'Multi Mode Inj','inhaler' => 'Inhaler', 'powder' => 'Powder','other' => 'Other' );

if (isset ( $product_obj->form ))
	$selected = $product_obj->form;
else
	$selected = 'tablet';

echo form_dropdown ( 'form', $form, $selected );
?>

</td>
			</tr>


			<tr>
				<td><b>Purchase Unit</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
// @todo : also check for the missing options
$p_unit = array ('bottle' => 'Bottle', 'strip' => 'Strip','tube' =>'Tube', 'amp' => 'Ampoule', 'vial' => 'Vial','proc' => 'Procedure', 'packet' => 'Packet','other' => 'Other');

if (isset ( $product_obj->purchase_unit ))
	$selected = $product_obj->purchase_unit;
else
	$selected = 'strip';
echo form_dropdown ( 'purchase_unit', $p_unit, $selected );
?>
	</td>
			</tr>

			<tr>
				<td><b>Retail Unit</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
// @todo : also check for the missing options
$r_unit = array ('bottle' => 'Bottle', 'tablet' => 'Tablet','capsule' => 'Capsule','tube' =>'Tube', 'amp' => 'Ampoule', 'vial' => 'Vial','proc' => 'Procedure','packet' => 'Packet','other' => 'Other');

if (isset ( $product_obj->retail_unit ))
	$selected = $product_obj->retail_unit;
else
	$selected = 'tablet';
echo form_dropdown ( 'retail_unit', $r_unit, $selected );
?>
	</td>
			</tr>
-->

			<tr>
				<td><b>Num Retail Unit / Purchase Unit</b></td>
				<td><input type="text" size="5" name="retail_units_per_purchase_unit"
					value="<?php
					if (isset ( $product_obj->retail_units_per_purchase_unit ))
						echo $product_obj->retail_units_per_purchase_unit;
					?>"></td>
			</tr>

			<tr>
				<td><b>Purchase Price (Rs per purchase unit, e.g. Rs per strip)</b></td>
				<td><input type="text" size="5" name="purchase_price"
					value="<?php
					if (isset ( $product_obj->purchase_price ))
						echo $product_obj->purchase_price;
					?>"></td>
			</tr>

			<tr>
				<td><b>MRP (Rs per retail unit, e.g. Rs per tablet)</b></td>
				<td><input type="text" size="6" name="mrp"
					value="<?php
					if (isset ( $product_obj->mrp ))
						echo $product_obj->mrp;
					?>"></td>
			</tr>
<!--
			<tr>
				<td><b>Retail Price</b></td>
				<td><input type="text" size="5" name="retail_price"
					value="<?php
					if (isset ( $product_obj->retail_price ))
						echo $product_obj->retail_price;
					?>"></td>
			</tr>
-->
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
