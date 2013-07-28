<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type='text/javascript' src='<?php echo $this->config->item ( 'base_url' );
	?>assets/js/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css"
	href="<?php
	echo $this->config->item ( 'base_url' );
	?>assets/css/jquery.autocomplete.css" />
<script type="text/javascript">
	var cnt = 0;
$(document).ready(function(){

	$('#addrow').click(function() {
		$('#lblDate').hide();
		$('#lblPerson').hide();

		if($('#date').val() == '') {
			$('#lblDate').show();
			return;
		}

		if($('#person').val() == '') {
			$('#lblPerson').show();
			return;
		}
		var total = $('#quantity').val() * $('#rate').val();

		//@todo checking of valid product name needed here
		//product name should have product_id in it in bracket

		var product_raw = $('#product').val();
		var product_arr = product_raw.split('(');
		var prod_id = product_arr[1].split(')');


	    var row = '<tr class="approve">';
	    row += '<td onmousedown="removeRow(this)" align="center"><input type="checkbox"></td>';
	    row += '<td>&nbsp;</td>';
		row += '<td><input type="hidden" name="sales_records['+cnt+'][date]" value="'+$('#date').val()+'">'+$('#date').val()+'</td>';
		row += '<td><input type="hidden" name="sales_records['+cnt+'][person_id]" value="'+ $('#person').val()+'">'+$('#person').val()+'</td>';
		row += '<td><input type="hidden" name="sales_records['+cnt+'][health_product_id]" value="'+ prod_id[0] +'">'+product_arr[0]+'</td>';
		row += '<td align="center"><input type="hidden" name="sales_records['+cnt+'][quantity]" value="'+$('#quantity').val()+ '">'+$('#quantity').val()+'</td>';
		row += '<td align="right"><input type="hidden" name="sales_records['+cnt+'][rate]" value="'+$('#rate').val()+'">'+$('#rate').val()+'</td>';
		row += '<td align="right">' + total + '</td>';
		row += '</tr>';
		$('#followupTable tr:last').after(row);
		cnt ++;
	});

	/*$('#submit_form_data').click(function(){
		var row_data="";
		var cnt = 0;
		$('#followupTable tr').each(function(){
			var rows = $(this).children('td');

			$(rows).each(function(){
				if(cnt != 0)
				row_data += '|'+$(this).html();
			});
			if(cnt != 0)

			row_data += '~';
			cnt++;
		});
		$('#saleTableData').val('');
		$('#saleTableData').val(row_data);
		alert(row_data);
	});*/

});

function removeRow(row) {
	$(row).parent().remove();
}


//---------------------------jquery auto complete code START here---------------------------------

var actual_val;
var autocomp_url;

$().ready(function() {


	function findValueCallback(event, data, formatted){
		//$("<li>").html(!data ? "No match!" : "Marathi name: " + formatted+" English name: " + data[1]).appendTo("#result");
	}

	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	$(":text").result(findValueCallback).next().click(function(){
		$(this).prev().search();
	});

	$(".health_product").autocomplete(base_url + "index.php/common/autocomplete/health_products", { width: 260,	selectFirst: false});
	$(".health_product").result ( function(event, data, formatted) {
//		alert('data: ['+data +'] forma:   ['+ formatted + ']');
		if (data)
		     $(this).parent().next().find("input").val(data[1]);
	    });

});

//-----------------------jquery auto complete code ENDS here--------------------------




</script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/datepicker_.js";
	?>"></script>
<title>Add CHW Sale</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>


<form method="post">

<table border="0" align="center" width="60%">

	<tr>
		<td colspan="5">

		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">
		<?php
		if($type == 'edit')
				echo 'Add / Edit chw Sales';
			else echo 'Add CHW Sale'; ?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
		<table align="" width="80%">
			<tr>
				<td><b>CHW</b></td>
				<td colspan="3"><?php echo $chw_name; ?></td>
			</tr>
			</table>
		<br>
		<table align="center" width="100%" id="followupTable">
			<tr class="head">
				<td><b>Remove </b></td>
				<td><b>Edit</b></td>
				<td><b>Date</b></td>
				<td><b>Person</b></td>
				<td><b>Product</b></td>
				<td><b>Quantity</b></td>
				<td><b>Rate</b></td>
				<td><b>Total</b></td>
			</tr>
			<?php if(isset($chw_sales)) {
				foreach($chw_sales as $sale) { ?>
			<tr class="grey_bg">
				<td align="center"><input type="checkbox" name="sale_id_del[]" value="<?php echo $sale->id; ?>"> </td>
				<td align="center"><a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/edit_single_sale_record/'.$sale->id; ?>" >Edit</a>   </td>
				<td align="center"><?php echo Date_util::date_display_format($sale->date); ?></td>
				<td><?php echo $sale->person_id; ?></td>
				<td><?php echo $sale->product_name; ?></td>
				<td align="center"><?php echo $sale->quantity; ?></td>
				<td align="right"><?php echo $sale->rate; ?></td>
				<td align="right"><?php echo $sale->quantity * $sale->rate; ?></td>
			</tr>
			<?php }} ?>

		</table>

		<br>
		<table width="100%" ><tr><td align="right" >
		<!--<input type="hidden" name="saleTableData" id="saleTableData">
		-->
		<input class="submit" type="submit" name="submit_form_data" value="Submit Data" id="submit_form_data"> </td> </tr> </table>
		<br>
		<fieldset><legend>Sale Details</legend>
		<table>
			<tr>
				<td>Date</td>
				<td><input type="text" size="10" id="date" class="datepicker"></td>
				<td> <label class='error' style="display: none;" id="lblDate">Date Field is required.</label>  </td>
			</tr>
			<tr>
				<td>Person</td>
				<td><input type="text" id="person"><Br>
				@todo : need to add autocomplete functionality here.
				</td>
				<td> <label class='error' style="display: none;" id="lblPerson">Person Field is required.</label> </td>
			</tr>
			<tr>
				<td>Product</td>
				<td><input type="text" id="product" class="health_product"></td>
				<td></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><input type="text" id="quantity"></td>
				<td></td>
			</tr>
			<tr>
				<td>Rate</td>
				<td><input type="text" id="rate"></td>
				<td></td>
			</tr>
			<!--<tr>
				<td>Total</td>
				<td>Rs.<label id="total"></label>  </td>
				<td></td>
			</tr>
			--><tr>
				<td>&nbsp;</td>
				<td><input type="button" id="addrow" value="Add" class="submit"></td>
			</tr>

		</table>

		</fieldset>

		</div>
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>
		</div>
		</div>
		</td>
	</tr>
</table>
</form>


<?php
$this->load->view ( 'common/footer' );
?>
