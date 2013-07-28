<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<title>External Order Details</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>

<div id="main">
	<table width="100%" align="center">
		<tr>
			<td>

				<div class="blue_left">
					<div class="blue_right">
						<div class="blue_middle">
							<span class="head_box"> <?php
							echo ' Order No: '.$order_id.' received on '.$order_date;
							?> </span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">

					<table border="0" align="center" cellpadding="5px" cellspacing="5px">
					<tr>
						<td valign="top" align="left" width='50%'>
							<table cellpadding="5">
								<tr valign="top">
									<td><b>Received Date</b></td>
									<td><?php echo $order_date?></td>
								</tr>
								<tr valign="top">
									<td><b>Order From</b></td>
									<td> <?php echo $scm_orgs[$order_from_id];	?>	</td>
								</tr>
								<tr valign="top">
									<td><b>Order To</b>
									</td>
									<td><?php echo $scm_orgs[$order_to_id];	?></td>
								</tr>
							</table>
						</td>
						<td valign="top" align="left">
							<div><strong>Details</strong></div>
							<table id="details" style="border-left: 1px solid; padding: 3px" cellpadding="5">
								<tr>
									<td><b>Invoice number </b></td>
											<td><b>:<b>
											
											</td>
											<td td width="300px"><?php echo $invoice_number;?></td>
											</tr>
											
                                         
											<tr>
												<td><b>Invoice date </b></td>
									<td><b>:<b></td>
									<td><?php echo $invoice_date;?> </td>
								</tr>
								
								<tr>
									<td>
										<b>Type of Node</b>
										</td>
										<td> <b>:<b> </td>
										<td>Purchase</td>
									</tr>
									
									<tr>
										<td>
											<b>VAT</b>
										</td>
										<td> <b>:<b> </td>
										<td><?php echo $vat_amount;?></td> 
									</tr>
									<tr>
									<td>
											<b>Shipping Cost</b>
										</td>
										<td> <b>:<b> </td>
										<td><?php echo $shipping_cost;?></td> 
									</tr>
									<tr>
									<td>
											<b>Total Value</b>
										</td>
										<td> <b>:<b> </td>
										<td ><?php echo $bill_amount;?></td>
									</tr>
								</table>
							</td>
						</tr>			
						
						<tr>
							<td colspan="2">
								<table width="100%" id="table_grey_border" class="invoice_table">
									<tr class="scm_head">
										<td width="5%">SN</td>
										<td width="20%">Generic Name</td>
										<td width="15%">Brand Name Received</td>
										<td width="7%">Product/<br />Type</td>										
										<td width="15%">Qty Received</td>
										<td width="15%">Batch No</td>
										<td width="15%">Expiry</td>
										<td width="5%">Amount</td>
									</tr>
									<?php
									$i=0;
									echo '<input type="hidden" name="number_items" id="number_items" value="'.$number_items.'" />'."\n";
									for($i=0; $i < $number_items ; $i++)
									{
										echo '<tr>'."\n";
										echo '<td valign="top">'.($i+1).'</td>'."\n";
										echo '<td valign="top" width="11%">'.$order_items[$i]['generic_name'].' - '.$order_items[$i]['strength'].'</td>'."\n";
										echo '<td valign="top">'.$order_items[$i]['product_id'].'</td>'."\n";
										echo '<td valign="top" >'.$order_items[$i]['type'].'<br />'.$order_items[$i]['opd_type'].'</td>'."\n";
										
										echo '<td valign="top">'.$order_items[$i]['quantity'].'</td>'."\n";
										echo '<td valign="top">'.$order_items[$i]['batch_number'].'</td> '."\n";
										echo '<input type="hidden"  id="product_type_'.$i.'" value="'.$order_items[$i]["type"].'" />';
										if(!empty($order_items[$i]['expiry_date']))
											echo '<td valign="top">'.$order_items[$i]['expiry_date'].'</td>'."\n";
										else{
											echo '<td valign="top"></td>'."\n";
										}
										echo '<td valign="top">'.$order_items[$i]['actual_value'].'</td>'."\n";
										echo '</tr>'."\n";
									}
									?>

								</table>
							</td>
						</tr>
						
					</table>
					
				</div>
				<div class="bluebtm_left">
					<div class="bluebtm_right">
						<div class="bluebtm_middle" /></div>
					</div>
				</div>			
			</td>
		</tr>
	</table>
</div>
	<?php
	$this->load->view ( 'common/footer' );
	?>