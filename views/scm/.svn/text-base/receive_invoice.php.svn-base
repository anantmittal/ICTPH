<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title>Invoices for Order / Goods Movement Note</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
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
<div id="main">
	<table width="100%" align="center">
		<tr>
			<td>
				<div class="blue_left">
					<div class="blue_right">
						<div class="blue_middle">
							<span class="head_box">
								<?php
									echo 'Receive Invoice Numbered : '.$invoice_txn_id.' raised on order no : '.$order_id.' placed on '.Date_util::date_display_format($order_date);
								?>
							</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">
					<form method="post" onSubmit="return validateInvoiceForm()">
						<table width="100%" cellspacing = "10px">
							<tr>
								<td valign="top" align="left">
									<strong>Received On : </strong>
									<?php 
										echo '<input name="date" id="date" type="text"
										value="'.$today_date.'"
										class="datepicker check_dateFormat" readonly="readonly" size="8"/>';
									
									?>
								</td>
						    </tr>
							<tr>
								<td valign="top" align="left">
									<strong>Invoice Number : </strong><?php echo $invoiced_number;?>
								</td>
						    </tr>
						    <tr>
								<td valign="top" align="left">
									<strong>Invoiced On : </strong><?php echo Date_util::date_display_format($invoiced_on);?>
								</td>
						    </tr>
							<tr>
								<td valign="top" align="left">
									<strong>Order From : </strong><?php echo $order_from;?>
									<strong>To : </strong><?php echo $order_to;?>
								</td>
						    </tr>
						    
							<tr><td>
							    <table width="100%" id="table_grey_border">
									<tr class="scm_head">
									  <td width="5%">SN</td>
									  <td width="35%">Generic Name</td>
									  <td width="5%">Strength</td>
									  <td width="5%">Order Unit</td>
									  <td width="20%">Brand Name</td>
									  <td width="10%">Batch</td>
									  <td width="10%">Expiry</td>
									  <td width="5%">Qty Invoiced</td>
									  <td width="5%">Amount</td>
									</tr>
									<?php
										for($i=0; $i < sizeof($order_items) ; $i++){
											echo '<tr>'."\n";
											echo '<td valign="top">'.($i+1).'</td>'."\n";
											echo '<td valign="top">'.$order_items[$i]['generic_name'].'</td>'."\n";
											echo '<td valign="top">'.$order_items[$i]['strength'].'</td>'."\n";
											echo '<td valign="top">'.$order_items[$i]['unit'].'</td>'."\n";
											echo '<td valign="top">'.$order_items[$i]['product']->name.'</td>'."\n";
											echo '<td valign="top">'.$order_items[$i]['batch_number'].'</td>'."\n";
											echo '<td valign="top">'.$order_items[$i]['expiry_date'].'</td>'."\n";
											echo '<td valign="top">'.$order_items[$i]['quantity'].'</td>'."\n";
											echo '<td valign="top">'.$order_items[$i]['amount'].'</td>'."\n";
											echo '</tr>';
										}
									?>
									<tr>
									<td colspan="7" align="right">
										<input type="hidden" name="invoice_id" value="<?php echo $invoice_txn_id; ?>" />
										<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
										<input type="hidden" name="from_id" value="<?php echo $order_from_id; ?>" />
										<input type="hidden" name="to_id" value="<?php echo $order_to_id; ?>" />
										<input type="hidden" name="bill_amount" value="<?php echo $total_amount; ?>" />
										<input type="hidden" name="type_of_good" value="Goods Received" />
										<?php if($can_receive){?>
										<input type="submit" class="submit" value="Receive Order" id="button"/>
										<?php }else{
											echo "<strong>Invoice received</strong>";
										}?>
									</td>
						       </tr> 
							      </table>
							     </td>
							  </tr> 
						</table>
					</form>
				</div>
				<div>
			  		<div class="bluebtm_left"> 
			  			<div class="bluebtm_right">
			  				<div class="bluebtm_middle" /></div>
			 			</div>
			 		</div>
	         	</div>
			</td>
		</tr>
	</table>
</div>
<?php
$this->load->view ( 'common/footer' );
?>
