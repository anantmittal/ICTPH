<?php
$this->load->view ( 'common/header' );
?>
<title>Order Details</title>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>

<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'><span>$success_message</span></div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>

<div id="main">
  <div class="hospit_box">

		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">
		<?php
			echo 'Order No: '.$order_id.' placed on '.$order_date. ' with status '.$order_obj->order_status;;
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
			<div><a href="<?php echo $this->config->item('base_url')."index.php/scm/order/order_details_report/".$order_id;?>" ><img src = "<?php echo "{$this->config->item('base_url')}"?>assets/images/download_button.jpg" alt="Download Pdf" width="100px" height="35px"/></a></div>
		<table border="0" align="center" width="">
			<tr>
				<td><b>From:</b></td>
				<td><?php echo $order_from;?></td>
				<td><b>To:</b></td>
				<td><?php echo  $order_to;?></td>
				<td><b>Amount:</b></td>
				<td><?php echo  $bill_amount;?> </td>
			</tr>
			<tr>
				<td><b>Comment:</b></td>
				<td><?php echo $comment;?></td>
			</tr>
		</table>
		<table width="550px" align="center">
			<tr >
				<td valign="top"><strong>Transaction Details :</strong></td>
				<td>
					<table id="table_grey_border" width="100%">
						<tr class="scm_head">
		  					<td>Invoice Number</td>
		  					<td>Invoice date</td>
		  					<td>Recevie Number</td>
							<td>Receive date</td>
						</tr>
						<?php
							foreach ($transactions as $txn){
								$invoice_detail_url=$this->config->item('base_url').'index.php/scm/order/receive_order_on_invoice/'.$order_id.'/'.$txn->invoice_number;
								$receive_detail_url=$this->config->item('base_url').'index.php/scm/order/external_order_details/'.$order_id.'/'.$txn->receive_txn_id;
								echo '<tr>'."\n";
								if(empty($txn->invoice_date)){
									echo '<td>NA</td>'."\n";
								}else{
									if($txn->invoice_txn_id!=0){
										echo '<td><a href="'.$invoice_detail_url.'">'.$txn->invoice_number.'</a></td>'."\n";
									}else{
										echo '<td>'.$txn->invoice_number.'</td>'."\n";
									}
								}
								if(empty($txn->invoice_date) || $txn->invoice_date==='0000-00-00'){
									echo '<td>NA</td>'."\n";
								}else{
									echo '<td>'.Date_util::date_display_format($txn->invoice_date).'</td>'."\n";
								}
								if(empty($txn->receive_txn_id)){
									echo '<td>NA</td>'."\n";
								}else{
									if($receive_order_only){
										echo '<td><a href="'.$receive_detail_url.'">'.$txn->receive_txn_id.'</a></td>'."\n";
									}else{
										echo '<td>'.$txn->receive_txn_id.'</td>'."\n";
									}
								}
								if(empty($txn->receive_date)){
									echo '<td>NA</td>'."\n";
								}else{
									echo '<td>'.Date_util::date_display_format($txn->receive_date).'</td>'."\n";
								}
								echo '</tr>'."\n";
							} 
						?>	
					</table>
				</td>
			</tr>
			</table>
			 
   				<table width="100%" border="0" id="table_grey_border">					
					<tr class="scm_head">
	  					<td width="5%">SN</td>
	  					<td width="35%">Generic Name</td>
	  					<td width="5%">Visit Id</td>
						  <td width="5%">Strength</td>
						  <td width="5%">Retail Unit</td>
						  <td width="5%">Capacity</td>
						  <td width="5%">Qty Ordered</td>
					  	<td width="5%">Retail Rate</td>
						 <td width="5%">Retail Value</td>
					</tr>
					<tr><td  colspan="9" /></tr>
					<!--  <tr class="scm_head"><td  colspan="8" align ="center">Medications</td> </tr>-->
			<?php
			if($number_items !=0)
				echo '<tr class="scm_head"><td  colspan="9" align ="center">Medications</td> </tr>'."\n";
			for($i=0; $i < $number_items ; $i++)
			{	
				echo '<tr>'."\n";
				echo '<td>'.($i+1).'</td>'."\n";
//				echo '<td width="35%">'.$order_items[$i]['brand_name'].'</td>'."\n";
				echo '<td width="35%">'.$order_items[$i]['generic_name'].'</td>'."\n";
				echo '<td></td>'."\n";
				echo '<td>'.$order_items[$i]['strength'].'</td>'."\n";
				echo '<td>'.$order_items[$i]['unit'].'</td>'."\n";
				echo '<td>'.$order_items[$i]['capacity'].'</td>'."\n";
				echo '<td>'.$order_items[$i]['quantity'].'</td>'."\n";
				echo '<td>'.$order_items[$i]['rate'].'</td>'."\n";
				echo '<td>'.$order_items[$i]['rate']*$order_items[$i]['quantity'].'</td>'."\n";
				echo '</tr>'."\n";
				
			}
			?>
				<!--  <tr class="scm_head"><td  colspan="8" align ="center">Consumables</td> </tr>-->
				
				<?php
				if($number_items_consumable !=0)
				echo '<tr class="scm_head"><td  colspan="9" align ="center">Consumables</td> </tr>'."\n";
			for($i=0; $i < $number_items_consumable ; $i++)
			{	
				echo '<tr>'."\n";
				echo '<td>'.($i+1).'</td>'."\n";
//				echo '<td width="35%">'.$order_items[$i]['brand_name'].'</td>'."\n";
				echo '<td width="35%">'.$order_items_consumable[$i]['generic_name'].'</td>'."\n";
				echo '<td></td>'."\n";
				echo '<td>'.$order_items_consumable[$i]['strength'].'</td>'."\n";
				echo '<td>'.$order_items_consumable[$i]['unit'].'</td>'."\n";
				echo '<td>'.$order_items_consumable[$i]['capacity'].'</td>'."\n";
				echo '<td>'.$order_items_consumable[$i]['quantity'].'</td>'."\n";
				echo '<td>'.$order_items_consumable[$i]['rate'].'</td>'."\n";
				echo '<td>'.$order_items_consumable[$i]['rate']*$order_items_consumable[$i]['quantity'].'</td>'."\n";
				echo '</tr>'."\n";
				
			}
			?>
				<!--  <tr class="scm_head"><td  colspan="8" align ="center">OPD Products</td> </tr>-->
				
				<?php
				if($number_items_opd !=0)
				echo '<tr class="scm_head"><td  colspan="9" align ="center">OPD Products</td> </tr>'."\n";
			for($i=0; $i < $number_items_opd ; $i++)
			{
				$show_visit_url=$this->config->item('base_url').$show_visit_link_url.$order_items_opd[$i]['visit_id'];	
				echo '<tr>'."\n";
				echo '<td>'.($i+1).'</td>'."\n";
//				echo '<td width="35%">'.$order_items[$i]['brand_name'].'</td>'."\n";
				echo '<td width="35%">'.$order_items_opd[$i]['generic_name'].'</td>'."\n";
				echo '<td><a href="'.$show_visit_url.'">'.$order_items_opd[$i]['visit_id'].'</a></td>'."\n";
				echo '<td>'.$order_items_opd[$i]['strength'].'</td>'."\n";
				echo '<td>'.$order_items_opd[$i]['unit'].'</td>'."\n";
				echo '<td>'.$order_items_opd[$i]['capacity'].'</td>'."\n";
				echo '<td>'.$order_items_opd[$i]['quantity'].'</td>'."\n";
				echo '<td>'.$order_items_opd[$i]['rate'].'</td>'."\n";
				echo '<td>'.$order_items_opd[$i]['rate']*$order_items_opd[$i]['quantity'].'</td>'."\n";
				echo '</tr>'."\n";
				
			}
			?>
      	</table>
      	<?php if($order_valid_to_close){?>
      	
			<table width='100%'>
				<tr>
					<td><?php if($receive_order_only){?><form action = "<?php echo $this->config->item('base_url').'index.php/scm/order/receive_order/'.$order_id;?>" method="POST"><div style='float:left'><input type ='submit' class='submit' value='Receive Order'></div></form><?php }else{?><form action = "<?php echo $this->config->item('base_url').'index.php/scm/order/create_invoice/'.$order_id;?>" method="POST"><input type ='submit' class='submit' value='Create Invoice'></form><?php }?></td>
					<td><form method='POST'><div style='float:right'>
					<input type="hidden" name="order_id" value="<?php echo $order_id?>">
					<input type ='submit' class='submit' value='Close Order'></div></form></td>		
				</tr>
			</table>
		
		<?php }else{
				if($order_obj->order_status !='Closed'){?>
			<table width='100%'>
				<tr>
					<td>
						<?php if($invoice_possible){?>
							<form action = "<?php  echo $this->config->item('base_url').'index.php/scm/order/create_invoice/'.$order_id;?>" method="POST">
								<div style='float:left'>	
									<input type ='submit' class='submit' value='Create Invoice'>&nbsp;&nbsp;
								</div>
							</form>
						<?php }?>
						<form action = "<?php echo $this->config->item('base_url').'index.php/scm/order/receive_order/'.$order_id;?>" method="POST">
							<div style='float:left'>
								<input type ='submit' class='submit' value='Receive Order'>
							</div>
						</form>
					</td>
					<td><div style='float:right'>
					<strong>Not in state to close</strong></div></td>		
				</tr>
			</table>
		<?php }
			}?>
		</div>

		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></span></div>
		</div>
		</div>
			</div></div>

<?php
$this->load->view ( 'common/footer' );
?>
