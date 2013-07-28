<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>
<?php if(isset($project_id)) echo 'Edit Project - '.$name; else  echo 'New Project'; ?>
</title>
<link rel="stylesheet" type="text/css"
	href="<?php
	echo $this->config->item ( 'base_url' );
	?>assets/css/jquery.autocomplete.css" />

<script type='text/javascript'
	src='<?php
	echo $this->config->item ( 'base_url' );
	?>assets/js/jquery.autocomplete.js'></script>
<script type="text/javascript"><!--
	var prod_cnt = 1;
$(document).ready(function(){
	$('#addProdRow').click(function() {

		var product_raw = $('#product').val();

		var product_arr = product_raw.split('(');
		var prod_id = product_arr[1].split(')');

	    var row = '<tr class="approve">';
	    row += '<td align="center" onmousedown="removeRow(this)">';
	    row += '<input type="hidden" value="'+prod_id[0]+'" name="products[new_id][]">';
		row += '<input type="checkbox"></td><td>'+product_arr[0]+'</td>';
		row += '</tr>';

		$('#product').val('');
		$('#prodTable tr:last').after(row);

	});





	$('#addTestsRow').click(function() {
		var test_raw = $('#test').val();

		/*var test_arr =  test_raw.split('--');
		if(test_arr.length != 2){
			alert('Test value is not in proper format');
			return false;
		}*/

		var test_row_arr = test_raw.split('(');
		var test_id = test_row_arr[1].split(')');

	    var row = '<tr class="approve">';
	    row += '<td align="center" onmousedown="removeRow(this)">';
	    row += '<input type="hidden" value="'+test_id[0]+'" name="tests[new_id][]">';
		row += '<input type="checkbox"></td><td>'+test_row_arr[0]+'</td>';
		row += '</tr>';

		$('#test').val('');
		$('#testsTable tr:last').after(row);

	});

	$('#addDisseminationRow').click(function() {
		var dissemination_row = $('#dissemination').val();

		/*var dissemination_arr =  dissemination_row.split('--');
		if(dissemination_arr.length != 2){
			alert('Dissemination value is not in proper format');
			return false;
		}*/

		var dissemination_row_arr = dissemination_row.split('(');
		var dissemination_id = dissemination_row_arr[1].split(')');

	    var row = '<tr class="approve">';
	    row += '<td align="center" onmousedown="removeRow(this)">';
	    row += '<input type="hidden" value="'+dissemination_id[0]+'" name="disseminations[new_id][]">';
		row += '<input type="checkbox"></td><td>'+dissemination_row_arr[0]+'</td>';
		row += '</tr>';

		$('#dissemination').val('');
		$('#disseminationTable tr:last').after(row);

	});



/*	$('#submit_form_data').click(function(){
		var row_data="";
		var cnt = 0;

		$('#prodTable tr').each(function(){
			var rows = $(this).children('td');
			$(rows).each(function(){
				if(cnt != 0)
					row_data += '|'+$(this).html();
			});
			if(cnt != 0)
				row_data += '~';

			cnt++;
		});

		$('#prodTableData').val('');
		$('#prodTableData').val(row_data);

		row_data="";
		cnt = 0;
		$('#testsTable tr').each(function(){
			var rows = $(this).children('td');
			$(rows).each(function(){
				if(cnt != 0)
					row_data += '|'+$(this).html();
			});
			if(cnt != 0)
				row_data += '~';
			cnt++;
		});
		$('#testsTableData').val('');
		$('#testsTableData').val(row_data);

		row_data="";
		cnt = 0;
		$('#disseminationTable tr').each(function(){
			var rows = $(this).children('td');
			$(rows).each(function(){
				if(cnt != 0)
					row_data += '|'+$(this).html();
			});
			if(cnt != 0)
				row_data += '~';
			cnt++;
		});
		$('#disseminationTableData').val('');
		$('#disseminationTableData').val(row_data);
	});
	*/
});



function removeRow(row) {
//	var new_or_old = $('.'+row.id).val();
//	alert(new_or_old);
//	alert($(row).find(":input").val()); //working
//	if(new_or_old == 'new')
   $(row).parent().remove();
};



//---------------------------jquery auto complete code START here---------------------------------

var actual_val;
var autocomp_url;

$().ready(function() {

	 /*$("#product").focus(function () {
		 autocomp_url = base_url + "index.php/chw/test/autocomplete_product_list";
    });*/




	function findValueCallback(event, data, formatted){
		//$("<li>").html(!data ? "No match!" : "Marathi name: " + formatted+" English name: " + data[1]).appendTo("#result");
	}

	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

	$(":text").result(findValueCallback).next().click(function(){
		$(this).prev().search();
	});

    $(".memname").autocomplete(base_url + "index.php/common/autocomplete/health_products", { width: 260,	selectFirst: false});
	$(".memname").result ( function(event, data, formatted) {
//		alert('data: ['+data +'] forma:   ['+ formatted + ']');
		if (data)
		     $(this).parent().next().find("input").val(data[1]);
	    });



	$(".test").autocomplete(base_url + "index.php/common/autocomplete/tests", { width: 260,	selectFirst: false});
	$(".test").result ( function(event, data, formatted) {
		if (data)
		     $(this).parent().next().find("input").val(data[1]);
	});



	$(".dissemination").autocomplete(base_url + "index.php/common/autocomplete/disseminations", { width: 260,	selectFirst: false});
	$(".dissemination").result ( function(event, data, formatted) {
		if (data)
		     $(this).parent().next().find("input").val(data[1]);
	});

  });

//-----------------------jquery auto complete code ENDS here--------------------------


</script>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<!--<form action="project/save" method="post" >-->
<?php  echo form_open('chw/project/save'); ?>

<input type="hidden" name="chw_group_id" value="<?php echo $chw_group_id; ?>">

<?php if(isset($project_id)) { ?>
<input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
<?php } ?>

<table width="50%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">Create Project</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
		<table border="0">
			<tr>
				<td><b>CHW Group</b></td>
				<td colspan="2"><?php
				echo $chw_group_name;
				?></td>
			</tr>
			<tr>
				<td><b>Name</b></td>
				<td colspan="2">
				<input type="text" name="name" value="<?php if(isset($name)) echo $name; ?>"></td>
			</tr>
			<tr>
				<td valign="top"><b>Goal</b></td>
				<td colspan="2"><textarea rows="3" cols="30" name="goal"><?php if(isset($goal)) echo $goal; ?></textarea>
				</td>
			</tr>
			<tr>
				<td valign="top"><b>Description</b></td>
				<td colspan="2"><textarea rows="3" cols="30" name="description"><?php if(isset($description)) echo $description; ?></textarea>
				</td>
			</tr>
			<tr>
				<td valign="top"><b>Project Manager</b></td>
				<td colspan="2"><input type="text" name="project_manager" value="<?php if(isset($project_manager)) echo $project_manager; ?>">
				<input type="hidden" name="owner_id" value="1">
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr class="head">
				<td colspan="3"><b>Add Products</b></td>
			</tr>
			<tr>
				<td colspan="2" width="60%" valign="top">
				<table border="0" width="100%" id="prodTable">
					<tr class="head">
						<td width="30%"><b>Remove</b></td>
						<td width="60%"><b>Products</b></td>
					</tr>

					<?php
					  if(isset($health_products)) {
					 foreach ($health_products as $health_product) { ?>
					<tr class="approve">
						<td align="center">
						<input type="checkbox" name="products[delete_row_id][]" value="<?php echo $health_product->id; ?>" />
						</td>
						<td><?php echo $health_product->product_name; ?></td>
					</tr>
					<?php }} ?>


				</table>
				</td>
				<td valign="top" width="40%"><input type="text" name="product"
					id="product" size="15" class="memname"><br>
				<input type="button" class="submit" value="Add Product"
					id="addProdRow"></td>
			</tr>



			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr class="head">
				<td colspan="3"><b>Add Tests</b></td>
			</tr>
			<tr>
				<td colspan="2" width="60%" valign="top">
				<table border="0" width="100%" id="testsTable">
					<tr class="head">
						<td width="30%"><b>Remove</b></td>
						<td width="60%"><b>Tests</b></td>
					</tr>


					<?php
					if(isset($projects_tests)) {
					foreach ($projects_tests as $projects_test) { ?>
					<tr class="approve">
						<td align="center">
						<input type="checkbox" name="tests[delete_row_id][]" value="<?php echo $projects_test->id; ?>" />
						</td>
						<td><?php echo $projects_test->test_name; ?></td>
					</tr>
					<?php }} ?>



				</table>
				</td>
				<td valign="top" width="40%"><input type="text" size="15" id="test"
					class="test"> <br>
				<input type="button" class="submit" id="addTestsRow"
					value="Add Test"></td>
			</tr>


			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr class="head">
				<td colspan="3"><b>Dissemination</b></td>
			</tr>
			<tr>
				<td colspan="2" width="60%" valign="top">
				<table border="0" width="100%" id="disseminationTable">
					<tr class="head">
						<td width="30%"><b>Remove</b></td>
						<td width="60%"><b>Disseminations</b></td>
					</tr>



					<?php
					if(isset($projects_disseminations)) {
					foreach ($projects_disseminations as $projects_dissemination) { ?>
					<tr class="approve">
						<td align="center">
						<input type="checkbox" name="disseminations[delete_row_id][]" value="<?php echo $projects_dissemination->id; ?>" />
						</td>
						<td><?php echo $projects_dissemination->dissemination_name; ?></td>
					</tr>
					<?php }} ?>



				</table>
				</td>
				<td valign="top" width="40%"><input type="text" size="15"
					class="dissemination" id="dissemination"> <br>
				<input type="button" class="submit" id="addDisseminationRow"
					value="Add Dissemination"></td>
			</tr>

			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>


			<tr>
				<td colspan="2"></td>
				<td align="right"><input type="submit" value="Submit Values"
					class="submit" id="submit_form_data"></td>
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
</form>
<?php
$this->load->view ( 'common/footer' );
?>
