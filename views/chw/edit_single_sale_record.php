<?php
/*echo '<pre>';
print_r($visit_record);
echo '<pre>';*/
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>


<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>

<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/datepicker_.js";
	?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery.validate.js";
	?>"></script>
<script type='text/javascript' src='<?php echo $this->config->item ( 'base_url' );
	?>assets/js/jquery.autocomplete.js'></script>

<link rel="stylesheet" type="text/css"
	href="<?php
	echo $this->config->item ( 'base_url' );
	?>assets/css/jquery.autocomplete.css" />
<script type="text/javascript">
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

<title>Edit single CHW Sales Record</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<form method="post">
<input type="hidden" name="id" value="<?php echo $sale['id']; ?>">
<table border="0" align="center" width="60%">
	<tr>
		<td colspan="5">

		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">Edit single CHW Sales Record</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
		<table width="100%">
			<tr>
				<td align="right"></td>
			</tr>
		</table>
		<br>
		<fieldset><legend>Sale Details</legend>
		<table>
			<tr>
				<td>Date</td>
				<td><input type="text" maxlength="10" size="10" id="date" name="date" value="<?php echo $sale['date']; ?>" class="datepicker"></td>
				<td> <label class='error' style="display: none;" id="lblDate">Date Field is required.</label>  </td>
			</tr>
			<tr>
			<td>Person</td>
				<td><input type="text" name="person_id" value="<?php echo $sale['person_id']; ?>"><Br>
				@todo : need to add autocomplete functionality here.
				</td>
				<td> <label class='error' style="display: none;" id="lblPerson">Person Field is required.</label> </td>
			</tr>
			<tr>
				<td>Product</td>
				<td><input type="text" name="product" value="<?php echo $sale['product']; ?>" class="health_product"></td>
				<td></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><input type="text" name="quantity" value="<?php echo $sale['quantity']; ?>"></td>
				<td></td>
			</tr>
			<tr>
				<td>Rate</td>
				<td><input type="text" name="rate" value="<?php echo $sale['rate']; ?>"></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" id="addrow" value="Update Record" class="submit"></td>
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
