<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title><?php
	echo 'Add a Product Batch';
?></title>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/datepicker_.js";
	?>"></script>
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
			echo 'Add Product Batch';
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

		<form method="post">
		<table border="0" align="center" width="">
			<tr>	
				<td><b>Product</b></td>
				<td>
				<?php 
				echo form_dropdown ( 'product_id', $products,'' );
				?>
				</td>
			</tr>

			<tr>
				<td><b>Receipt Date</b></td>
				<td><input type="text" name="receipt_date" size="10" class="datepicker"></td>
			</tr>

			<tr>
				<td><b>Batch Number</b></td>
				<td><input type="text" name="batch_number"></td>
			</tr>

			<tr>
				<td><b>Quantity</b></td>
				<td><input type="text" name="quantity"></td>
			</tr>

			<tr>
				<td><b>Expiry Date</b></td>
				<td><input type="text" name="expiry_date" size="10" class="datepicker"></td>
			</tr>

			<tr>
				<td><b>Purchase Price</b></td>
				<td><input type="text" name="purchase_price"></td>
			</tr>

			<tr>
				<td><b>Retail Price</b></td>
				<td><input type="text" name="retail_price"></td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="submit" value="Add Batch" name="submit_batch"></td>
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
