<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title><?php 
if (isset ( $product_obj->generic_name ))
	echo 'Edit Generic Health Product';
else
	echo 'Add Generic Health Product';
?></title>
<script  type="text/javascript">
	$(document).ready(function() {
		$('#opd_subproduct_div_1').hide(500);
		$('#opd_subproduct_div_2').hide(500);
		$('#product_type').change(function(){
			var selectedValue = "";
			var ret_price=$('#hidden_price').val();
			$("#product_type option:selected").each(function () {
                selectedValue = $(this).val();
              });
             if(selectedValue == 'OUTPATIENTPRODUCTS'){
             	$('#opd_subproduct_div_1').show(500);
				$('#opd_subproduct_div_2').show(500);
				 
             }else{
             	$('#opd_subproduct_div_1').hide(500);
				$('#opd_subproduct_div_2').hide(500);
				  
             }
             if(selectedValue == 'CONSUMABLES'){
            	 $('#retail_price').attr("disabled", "disabled");
            	 $('#retail_price').val("");
             }else{
            	 $('#retail_price').removeAttr("disabled");
            	 $('#retail_price').val(ret_price);
             }
                 
		});
		$('#product_type').change();
	});
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
		if (isset ( $product_obj->generic_name ))
			echo 'Edit Generic Health Product';
		else
			echo 'Add Generic Health Product';
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
				<td><b>Generic ID</b></td>
				<td>
			<?php
				echo $product_obj->id ;

			?></td>

			</tr>
			<?php } ?>
			
			<tr>
				<td><b>Product Type</b></td>
				<td><?php
						$product_type = $this->config->item('product_types');
						$selected_product = "";
						if(isset($product_obj)){
							$selected_product = $product_obj->product_type;
						}
						echo form_dropdown('product_type', $product_type, $selected_product,'id="product_type"');
					?>
				</td>
			</tr>
			<tr>
				<td><div id="opd_subproduct_div_1"><b>Order Type</b></div></td>
				<td><div id="opd_subproduct_div_2"><?php
					$opd_subproducts = $this->config->item('OUTPATIENTPRODUCTS');
					
					foreach($opd_subproducts as $key => $value){
						$radio = array (
										'name'        => "product_order_type",
										'value'       => "{$key}",
										);
						if(isset($product_obj)){
							if($product_obj->product_order_type ==$key){
								echo  form_radio($radio,'',true);
								echo ucwords($value);
							}else{
								echo  form_radio($radio,'');
								echo ucwords($value);
							}
						}else{
							echo  form_radio($radio,'');
							echo ucwords($value);
						}
						
					}
					?>
				</div></td>
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
$s_unit = array ('mg' => 'Mg', 'microg' => 'Micro Gm', 'ml' => 'Ml', 'conc' => 'V/V', 'mgml' => 'Mgms / Ml','lpm' => 'Lpm','other' =>'Other' ,'na' =>'N/A');
asort($s_unit);
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
$form = array ('tablet' => 'Tablet', 'capsule' => 'Capsule', 'unit' => 'Unit', 'fluid' => 'Fluid', 'ointment' => 'Ointment', 'drops' => 'Drops', 'cream' => 'Cream', 'syrup' => 'Syrup', 'proc' => 'Procedure', 'cons' => 'Consumable',
		'IV' => 'IV', 'IM' => 'IM', 'SC'=>'SC','inj' => 'Multi Mode Inj','inhaler' => 'Inhaler', 'powder' => 'Powder','other' => 'Other' );
asort($form);
if (isset ( $product_obj->form ))
	$selected = $product_obj->form;
else
	$selected = 'tablet';

echo form_dropdown ( 'form', $form, $selected );
?>

</td>
			</tr>

			<tr>
				<td><b>Capacity</b></td>
				<td><input type="text" size="15" name="capacity"
					value="<?php
					if (isset ( $product_obj->capacity ))
						echo $product_obj->capacity;
					?>"></td>
			</tr>


			<tr>
				<td><b>Purchase Unit</b></td>
				<td>
<?php
//@todo : Remove this array and put it in to config file
// @todo : also check for the missing options
$p_unit = array ('bottle' => 'Bottle', 'strip' => 'Strip','tube' =>'Tube', 'amp' => 'Ampoule', 'vial' => 'Vial','proc' => 'Procedure', 'packet' => 'Packet','other' => 'Other');
asort($p_unit);
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
$r_unit = array ('bottle' => 'Bottle', 'tablet' => 'Tablet','gms' => 'Gms','capsule' => 'Capsule','tube' =>'Tube', 'amp' => 'Ampoule', 'vial' => 'Vial','proc' => 'Procedure','packet' => 'Packet','unit' => 'Unit','mg' => 'Mg', 'microg' => 'Micro Gm', 'ml' => 'Ml', 'mgml' => 'Mgms / Ml','lpm' => 'Lpm','other' =>'Other');
asort($r_unit);
if (isset ( $product_obj->retail_unit ))
	$selected = $product_obj->retail_unit;
else
	$selected = 'tablet';
echo form_dropdown ( 'retail_unit', $r_unit, $selected );
?>
	</td>
			</tr>

			<tr>
				<td><b>Retail Price</b></td>
				<td><input type="text" size="5"  id="retail_price" name="retail_price"
					value="<?php
					if (isset ( $product_obj->retail_price ))
						echo $product_obj->retail_price;
					?>">
					<input type="hidden" size="5"  id="hidden_price" name="hidden_price"
					value="<?php
					if (isset ( $product_obj->retail_price ))
						echo $product_obj->retail_price;
					?>">
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
