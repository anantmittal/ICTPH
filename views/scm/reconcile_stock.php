<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title>Reconcile Stock of a location with Second Physical Check</title>
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
			echo 'Reconcile Stock for Location: '.$location;
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

		<form method="post">
		<table border="0" align="center" width="">
<tr>
     <td><b>Second Date of which Physical Stock was Taken</b> </td>
     <td>
       <input name="date" id="date" type="text" value="<?php echo $date; ?>" class="datepicker check_dateFormat"  style="width:100px;"  />
	<input type="hidden" name="location_id" value="<?php echo $location_id; ?>" />
     </td>
</tr>

<tr>
      <table width="100%" border="0">
	<tr class="scm_head">
	  <td width="2%">SN</td>
	  <td width="28%">Brand Name</td>
	  <td width="30%">Generic Name</td>
	  <td width="10%">Strength</td>
	  <td width="5%">Batch No</td>
	  <td width="5%">Expiry</td>
	  <td width="5%">Unit of Stock</td>
	  <td width="5%">Qty Physically Verified</td>
	  <td width="5%">Existing Delta</td>
	  <td width="5%">Final Delta</td>
	</tr>
<?php
	$i=0;
	echo '<input type="hidden" name="number_items" id="number_items" value="'.$number_items.'" />'."\n";
	for($i=0; $i < $number_items ; $i++)
	{
		echo '<tr>'."\n";
		echo '<td>'.($i+1).'</td>'."\n";
//		echo '<td width="35%">'.$order_items[$i]['brand_name'].'</td>'."\n";
		echo '<td>'.$order_items[$i]['brand_name'].'</td>'."\n";
		echo '<td>'.$order_items[$i]['generic_name'].'</td>'."\n";
		echo '<td>'.$order_items[$i]['strength'].'</td>'."\n";
		echo '<td>'.$order_items[$i]['batch_number'].'</td>'."\n";
		if(isset($order_items[$i]['expiry_date'])){
			echo '<td>'.$order_items[$i]['expiry_date'].'</td>'."\n";
		}else{
			echo '<td></td> '."\n";
		}
		echo '<td>'.$order_items[$i]['unit'].'</td>'."\n";
		echo '<td>'.$order_items[$i]['quantity'].'</td>'."\n";
		echo '<td>'.$order_items[$i]['delta'].'</td>'."\n";
		echo '<td><input type="text" name="delta_'.$i.'" id="delta_'.$i.'" value="'.$order_items[$i]['delta'].'" size="5" /></td>'."\n";
		echo '<input type="hidden" name="stock_id_'.$i.'" id="stock_id_'.$i.'" value="'.$order_items[$i]['stock_id'].'" />'."\n";
		echo '<input type="hidden" name="ph_stock_id_'.$i.'" id="ph_stock_id_'.$i.'" value="'.$order_items[$i]['ph_stock_id'].'" />'."\n";
		echo '</tr>'."\n";
	}
?>

      </table>
</tr>   
<tr><td>
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>
		</div>
		</div>
</td></tr>

	<tr align=right>
		<td>
		<b>Comment</b>
		<input type=text size=50 name="comment"/>
		<input type="submit" class="submit" value="Reconcile Stock"></td>
	</tr>
		</table>
		</form>


		</div>
		</td>
	</tr>
</table>

<?php
$this->load->view ( 'common/footer' );
?>
