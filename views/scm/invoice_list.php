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
<div id="main">
	<table width="100%" align="center">
		<tr>
			<td>
				<div class="blue_left">
					<div class="blue_right">
						<div class="blue_middle">
							<span class="head_box">
								<?php
									echo 'Processing Order No: '.$order_id.' placed on '.Date_util::date_display_format($ordered_on);
								?>
							</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">
					<form method="post" onSubmit="return validateInvoiceForm()">
						<table width="100%" >
							<tr>
								<td valign="top" align="left">
									<strong>Please select a invoice for which order needs to be received.</strong>
								</td>
						    </tr>
							<tr><td>
							    <table width="100%" id="table_grey_border">
									<tr class="scm_head">
									  <td width="5%">SN</td>
									  <td width="20%">Invoice Number</td>
									  <td width="20%">Invoiced On</td>
									  <td width="27%">From</td>
									  <td width="28%">To</td>
									</tr>
									<?php
										for($i=0; $i < sizeof($invoices) ; $i++){
											echo '<tr>'."\n";
											echo '<td valign="top">'.($i+1).'</td>'."\n";
											echo '<td valign="top"><a href="'.$this->config->item('base_url').'index.php/scm/order/receive_order_on_invoice/'.$order_id.'/'.$invoices[$i]['invoice_id'].'">'.$invoices[$i]['invoice_no'].'</a></td>'."\n";
											echo '<td valign="top">'.Date_util::date_display_format($invoices[$i]['invoice_date']).'</td>'."\n";
											echo '<td valign="top">'.$invoices[$i]['from'].'</td>'."\n";
											echo '<td valign="top">'.$invoices[$i]['to'].'</td>'."\n";
											echo '</tr>';
										}
									?>
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
