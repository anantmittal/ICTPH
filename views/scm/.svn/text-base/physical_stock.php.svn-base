<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/scm/physical_stock.js"; ?>"></script>

<title>Add Physical Stock</title>
<script type="text/javascript">
var root_url = "<?php echo $this->config->item('base_url') ?>";

var generic_name_list = new Array();      
	generic_name_list = [      
		<?php	
			foreach ($generic_names as $generic_id => $generic_name) {
		?>
		{id: '<?php echo $generic_id; ?>', name: '<?php echo $generic_name; ?>'},
		<?php	
		}
		?>
	];
	//medication
	var generic_medication_name_list = new Array();      
	generic_medication_name_list = [      
		<?php	
			foreach ($generic_medication_names as $generic_id => $generic_name) {
		?>
		{id: '<?php echo $generic_id; ?>', name: '<?php echo $generic_name; ?>'},
		<?php	
		}
		?>
	];
	//consumable
	var generic_consumable_name_list = new Array();      
	generic_consumable_name_list = [      
		<?php	
			foreach ($generic_consumable_names as $generic_id => $generic_name) {
		?>
		{id: '<?php echo $generic_id; ?>', name: '<?php echo $generic_name; ?>'},
		<?php	
		}
		?>
	];
	//opd products
	var generic_opdprod_name_list = new Array();      
	generic_opdprod_name_list = [      
		<?php	
			foreach ($generic_opd_product_names as $generic_id => $generic_name) {
		?>
		{id: '<?php echo $generic_id; ?>', name: '<?php echo $generic_name; ?>'},
		<?php	
		}
		?>
	];
	
</script>
<style type="text/css">
#search_by{
	line-height:22px;
	padding-bottom:10px;
}
#search_by div{
	line-height:22px;
	float:left;
}
#search_by .or_div{
	padding-left : 50px;
	padding-right : 50px;
}
#search_by .head{
	padding-left:30px;
	padding-right:5px;
}
#stock_table{
	border-color : #ccc;
	border-collapse : collapse;
	border : 1px solid #ccc
}
#stock_table tr td {
	padding:5px;
}
</style>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block');
$this->load->view ( 'common/header_search' );
?>
<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'><span>$success_message</span><div><a href='".$this->config->item('base_url').$filename."'>A  $filetype file has been created. Click here to download.</a></div> </div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>
<div id="page-loader" style="display: none;">
	<h3>Please wait...</h3>
	<?php echo '<img src="'.base_url().'/assets/images/common_images/loader.gif" alt="loader">';?>
	<p><small id="page-load-content">...Please wait, fetching stock details.</small></p>
</div>
			<div id="main">
				<div class="blue_left">
					<div class="blue_right">
						<div class="blue_middle"><span class="head_box">
							<?php
								echo 'Physical Stock for Location: '.$location;
							?>
						</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">
				<div id="main">
					<strong>Search By</strong>
					<br />
					<div id="search_by">
						<div class="head"><strong>Product Type : </strong></div>
						<div><?php
							$product_type = $this->config->item('product_types');
							$product_type['ALL'] =  '-- Select --';			
							echo form_dropdown('product_type', $product_type, "ALL",'id="product_type"');
						 ?>
						</div>
						<div class="or_div"><strong>OR</strong></div>
						<div class="head"><strong>Generic Name : </strong></div>
						<div><input type="text" value="" id="generic_name" size="30" style="height:20px;">
							<input id="generic_id" type="hidden"/>
							
							<input type="text" value="" id="generic_medication_name" size="30" style="height:20px;"> 
							
							<input type="text" value="" id="generic_consumable_name" size="30" style="height:20px;">
						
							<input type="text" value="" id="generic_opd_product_name" size="30" style="height:20px;">
							
						</div>
						
						<div style="padding-left:5px;"><input type="button" value="Find" id="find" onclick="getStockDetails()" class="submit">
						</div>
					</div>
					<br /><br />
					
					<form method="post">
						<table border="0" width="98%">
							<tr>
							     <td width="25%">
								     <div id="search_by">
								     	<div>
								     		<b>Date of which Physical Stock was Taken :</b>
								     	</div>
								     	<div>
								       		<input name="date" id="date" type="text" value="<?php echo $date; ?>" class="datepicker check_dateFormat"  style="width:100px;"  />
											<input type="hidden" name="location_id" value="<?php echo $location_id; ?>" id="location_id"/>
								     	</div>
								     </div>
							     	<div style="float:right;">
								    	<div style="float:left;">
								    		<b>Total Stock Value :</b>
								    	</div>
							    		<input type="hidden" name="bill_amount" id="bill_amount" size="6">
							    		<div id="bill_amount_visible" style="float:left;"></div>
							    	</div>
							    </td>
							</tr>
							<tr>
								<td>
								      <table width="100%" border="1px" id="table_grey_border">
										<tr class="scm_head">
											  <td width="2%">SN</td>
											  <td width="20%">Brand Name</td>
											  <td width="23%">Generic Name</td>
											   <td width="20%">Product Type</td>
											  <td width="5%">Strength</td>
											  <td width="5%">Batch No</td>
											  <td width="5%">Expiry</td>
											  <td width="5%">Unit of Stock</td>
											  <td width="5%">Qty Verified</td>
											  <td width="5%">Rate</td>
											  <td width="5%">Amount</td>
										</tr>
											<?php
												$i=0;
												for($i=0; $i < $number_items ; $i++)
												{
													echo '<tr>'."\n";
													echo '<td>'.($i+1).'</td>'."\n";
											//		echo '<td width="35%">'.$order_items[$i]['brand_name'].'</td>'."\n";
													echo '<td>'.$order_items[$i]['brand_name'].'</td>'."\n";
													echo '<td>'.$order_items[$i]['generic_name'].'</td>'."\n";
													echo '<td>'.ucfirst(strtolower($order_items[$i]['product_type'])).'</td>'."\n";
													echo '<td>'.$order_items[$i]['strength'].'</td>'."\n";
													echo '<td>'.$order_items[$i]['batch_number'].'</td>'."\n";
													if(isset($order_items[$i]['expiry_date'])){
														echo '<td>'.$order_items[$i]['expiry_date'].'</td>'."\n";
													}else{
														echo '<td></td>'."\n";
													}
													echo '<td>'.$order_items[$i]['unit'].'</td>'."\n";
													echo '<td><input type="text" name="quantity_'.$i.'" id="quantity_'.$i.'" value="'.round($order_items[$i]['quantity'],2).'" size="4"  onchange="update_total()"/></td>'."\n";
													echo '<input type="hidden" name="actual_quantity_'.$i.'" id="actual_quantity_'.$i.'" value="'.round($order_items[$i]['quantity'],2).'" size="4" />'."\n";
													echo '<input type="hidden" name="stock_id_'.$i.'" id="stock_id_'.$i.'" value="'.$order_items[$i]['stock_id'].'" />'."\n";
													echo '<td id="rate_'.$i.'" value="'.$order_items[$i]['rate'].'">'.$order_items[$i]['rate'].'</td>'."\n";
													echo '<td id="total_'.$i.'" ></td>'."\n";
													echo '</tr>'."\n";
												}
											?>
											<tr>
												<td colspan="11"><?php
												$i=0;
												echo '<input type="hidden" name="number_items" id="number_items" value="'.$number_items.'" />'."\n";?>
												</td>
											</tr>
	      							</table>
      							</td>
							</tr>
							<tr align=right>
								<td colspan="11">
									<b>Comment</b>
									<input type=text size=50 name="comment"/>
									<input type="submit" class="submit" value="Confirm Physical Stock">
								</td>
							</tr> 
					</table>
				</form>
				</div>
			</div>
			<div class="bluebtm_left">
				<div class="bluebtm_right">
					<div class="bluebtm_middle" /></div>
				</div>
			</div>
		</div>

<?php
$this->load->view ( 'common/footer' );
?>
