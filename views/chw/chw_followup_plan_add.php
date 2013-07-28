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


//		var health_product_row =
		var id;

		var product_val = $('#consumable').val();
		var product = product_val.split('(');
		if(product[1] != undefined)
		{
			id = product[1].split(')');
			product[1] = id[0];
		}
		else
			product[1] = 0;



		var test_val           = $('#tests').val();
		var test = test_val.split('(');
		if(test[1] != undefined)
		{
			id = test[1].split(')');
			test[1] = id[0];
		}
		else
			test[1] = 0;


		var dissemination_val = $('#dissemination').val();
		var dissemination = dissemination_val.split('(');
		if(dissemination[1] != undefined)
		{
			id = dissemination[1].split(')');
			dissemination[1] = id[0];
		}
		else
			dissemination[1] = 0;

	    var row = '<tr class="approve">';
	    row += '<td onmousedown="removeRow(this)" align="center"><input type="checkbox"></td>';
		row += '<td><input type="hidden" name="events['+cnt+'][date]"          value="' +$('#date').val()+'">' + $('#date').val()+'</td>';
		row += '<td><input type="hidden" name="events['+cnt+'][health_product_id]" value="' + product[1]     +'">' + product[0]      + '</td>';
		row += '<td><input type="hidden" name="events['+cnt+'][test_id]"       value="' + test[1]        + '">'+ test[0]         + '</td>';
		row += '<td><input type="hidden" name="events['+cnt+'][dissemination_id]" value="' + dissemination[1]  +'">' + dissemination[0]   +'</td>';

		row += '</tr>';
		cnt ++;

		$('#followupTable tr:last').after(row);
	});

/*	$('#submit_form_data').click(function(){
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
		$('#followupTable_data').val('');
		$('#followupTable_data').val(row_data);
		var chw_data = $('#chw');
		var project_data = $('#project');
		$('#chw').val(chw_data);
		$('#project').val(project_data);
	});*/

});

function removeRow(row) {
	$(row).parent().remove();
}





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

	$(".health_product").autocomplete(base_url + "index.php/common/autocomplete/health_products", { width: 260,	selectFirst: false});
	$(".health_product").result ( function(event, data, formatted) {
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

	$(".chw").autocomplete(base_url + "index.php/common/autocomplete/chws", { width: 260,	selectFirst: false});
	$(".chw").result ( function(event, data, formatted) {
		if (data)
		     $(this).parent().next().find("input").val(data[1]);
	});

	$(".project").autocomplete(base_url + "index.php/common/autocomplete/projects", { width: 260,	selectFirst: false});
	$(".project").result ( function(event, data, formatted) {
		if (data)
		     $(this).parent().next().find("input").val(data[1]);
	});

	$(".person").autocomplete(base_url + "index.php/common/autocomplete/persons", { width: 260,	selectFirst: false});
	$(".person").result ( function(event, data, formatted) {
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
<title>Add CHW FollowUp Plan</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_search' );
?>


<form method="post">
<table border="0" align="center" width="60%">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">Add CHW FollowUp Plan</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">


		<table border="0" align="center" width="80%">
			<tr>
				<td><b> CHW</b></td>
				<td ><?php if (isset($chw_name)) {echo $chw_name;} 
					else{?>
				<input type="text" id="chw" class="chw" name="chw">
				<?php	}
			?></td>
			</tr>
			<tr>
				<td><b> Person</b></td>
				<td >
				<?php if (isset($person_name)) {echo $person_name;} 
					else{?>
				<input type="text" id="person" class="person" name="person">
				<?php	}?>
				</td>
			</tr>
			<tr>
				<td><b> Project</b></td>
				<td ><?php if (isset($project_name)) {echo $project_name;} 
					else{?>
				<input type="text" id="project" class="project" name="project">
				<?php	}
				?></td>
			</tr>
			<tr>
				<td><b> Start Date</b></td>
				<td><input name="start_date" id="start_date" type="text" size="10"
					value="" class="datepicker" />
					<!--<input type="hidden" name="followupTable_data" id="followupTable_data">
					--></td>
				<td><b> End Date </b></td>
				<td><input type="text" size="10" name="end_date" id="end_date"
					class="datepicker"></td>
			</tr>
			<tr>
				<td valign="top"><b> Summary</b></td>
				<td colspan="3">
				<textarea rows="3" cols="44" name="summary"></textarea>
				</td>
			</tr>
		</table>
		<Br>
		<table border="0" align="center" width="100%" id="followupTable">
		<tr class="head">
				<td colspan="8" align="left">&nbsp;&nbsp; <b>Followups</b></td>
			</tr>
			<tr class="head">
				<td>Remove</td>
				<td><b>Date</b></td>
				<td><b>Health Product</b></td>
				<td><b>Tests</b></td>
				<td><b>Dissemination</b></td>
			</tr>
		</table>

		<table align="right" width="100%">
			<tr>
				<td align="right" width="97%">
				<input type="submit" class="submit" id="submit_form_data" value="Submit"></td>
				</form>
				<td>&nbsp;</td>
			</tr>
		</table>
		<br>
		<fieldset><legend>Add Follow Up </legend>
		<table>
			<tr>
				<td>Date</td>
				<td><input type="text" size="10" id="date" class="datepicker"></td>
			</tr>
			<tr>
				<td>Health Product</td>
				<td><input type="text" id="consumable" class="health_product">
				</td>
			</tr>
			<tr>
				<td>Tests</td>
				<td><input type="text" id="tests" class="test"></td>
			</tr>
			<tr>
				<td>Dissemination</td>
				<td><input type="text" id="dissemination" class="dissemination"></td>
			</tr>
			<tr>
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


<?php
$this->load->view ( 'common/footer'); ?>
-->
