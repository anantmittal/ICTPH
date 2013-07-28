<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title><?php
	echo 'Add Stock Details';
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
			echo 'Add Stock Details';
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

		<form method="post">
		<table border="0" align="center" width="">
<tr>
     <td><b>Date</b> </td>
     <td>
       <input name="date" id="date" type="text" value="<?php echo $date; ?>" class="datepicker check_dateFormat"  style="width:100px;"  />
     </td>
     <td><b>Total Value</b></td>
         <input type="hidden" name="bill_amount" id="bill_amount">
         <td id="bill_amount_visible"></td>
	<td><b>Stock For</b></td>
	<td>
		<?php 
		if($this->session->userdata('location_id'))
		{ ?>
		<input type="hidden" name="from_id" value="<?php echo $from_id;?>" />
		<?php echo $scm_orgs[$from_id];	
		}
		else
		{
		echo form_dropdown ( 'from_id', $scm_orgs,$from_id );
		}
		?>
	</td>
<!--	<td><b>Expiry To</b></td>
	<td>
		<?php 
		echo form_dropdown ( 'to_id', $scm_orgs,$to_id );
		?>
	</td>-->
</tr>


    <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
      <script  type="text/javascript">
	// Have to assign the medications_list while inline - it should be
	// be available on document load
	var stock_medications_list = new Array();      
	stock_medications_list = [      
	<?php
	foreach ($opd_product_list as $opd_product) {
	$product = $opd_product->related('product')->get();
	$name = $product->name;
//	if (isset($product->generic_name) && !($product->generic_name===""))
//	  $name = $name.' ( '.$product->generic_name.' ) ';

//	if (isset($product->strength) && !($product->strength === "")
//	    && isset($product->strength_unit) && !($product->strength_unit === ""))
//	  $name = $name.' -'.$product->strength.' '.$product->strength_unit;
	  $rate = $product->purchase_price;
	?>
	{id: '<?php echo $product->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>'},
	<?php
	}
	?>
	];
      </script>
      
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/scm/add_stock_item.js"; ?>"></script>
<tr>
	  <td></td>
	  <td></td>
	  <td></td>
	  <td>
	  <input id="show_medication_box" type="button" value="Add Item"/>
	  <input id="medication_row_id" type="hidden" value="1"/>
	  </td>
</tr>      
<tr>
      <table id="medications" width="100%" border="0" cellspacing="2" cellpadding="2">
	<tr class="head">
	  <td width="30%">Drug</td>
	  <td width="20%">Batch No</td>
	  <td width="20%">Expiry</td>
	  <td width="10%">Qty</td>
	  <td width="5%">Rate</td>
	  <td width="5%">Total</td>
	  <td width="10%">Remove</a></td>
	</tr>
      </table>
</tr>   

<tr>      
<td>     
	 <div id="edit_medication_box" style="display:none;">
	<div class="blue_left"><div class="blue_right"><div class="blue_middle"><span class="head_box">Add Item</span></div></div></div>
	
	<div class="blue_body" style="padding:10px;">
	  
	  <div class="form_data">
	    <fieldset>
	      <legend>Details</legend>

	      <div class="form_row" style="margin-top:10px;">
		<div class="form_left">Name of medicine</div>
		<div class="form_right"><input id="medication_name" type="text" value="" />
			<input id="medication_product_id" type="hidden"/> 
			<input id="medication_rate" type="hidden" /></div>
	      </div>

	      <div class="form_row">
		<div class="form_left">Batch No</div>
		<div class="form_right">
		  <input name="medication_batch_no" id="medication_batch_no" type="text" size="10" />
		</div>
	      </div>
	      
	      <div class="form_row">
		<div class="form_left">Expiry</div>
		<div class="form_right">
		  <input name="medication_expiry" id="medication_expiry" type="text" size="10" />
		</div>
	      </div>
	      
	      <div class="form_row">
		<div class="form_left">Quantity</div>
		<div class="form_right">
		  <input name="medication_quantity" id="medication_quantity" type="text" size="5" />
		</div>
	      </div>
	      
	      <div class="form_row">
		<div class="form_right">
		  <div class="form_newbtn" align="right">
		    <input id="add_medication" type="button" value="Add"/>
		  </div>
		</div>
	      </div>

	  </div>

	</div>

	<div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>

      </div>
</td>
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
		<input type="submit" class="submit" value="Add"></td>
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
