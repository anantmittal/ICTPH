<?php

/**
 * @todo : join with column will only show if selected table is second or higher in number.
 * @todo : remove ajax depedancy of getting table fields and bring all names while page loading
 * @todo : need to check many validation conditions whether 'group by' is selected or not and many.
 */
	$this->load->helper('form');
?>

<html>
<head>
<script type="text/javascript">
var base_url = "<?php echo $this->config->item("base_url"); ?>";
</script>

<script type="text/javascript"
src='<?php echo $this->config->item("base_url")."assets/js/jquery-1.3.2.js"; ?>'>
</script>

<script type="text/javascript"
src='<?php echo $this->config->item("base_url")."assets/js/monitoring_evaluation/define_report.js"; ?>'>
</script>

<title>Create Report Definition</title>
</head>
<body>


<table border="1" align="center" >
	<tr>
		<td>
		<form method="POST" >
<div id="form_data"> </div>
		<b>Name : </b> <input type="text" name="name"> <br>
		<b>Author :</b><input type="text" name="author"> <br><br>

			<table border="1" id="fields_table">
			<tr><td><b>Type</b></td>  <td><b>Table</b></td>  <td><b>Column</b></td>
				<td><b>Join With</b></td>  <td><b>Group By</b></td>  <td><b>Aggregate function</b></td></tr>
			</table>

		<input type="submit" value="submit">
</form>

<br>
<br>
<br>

</td>
	</tr>
	<tr>
		<td>
		<table>
			<tr> <td> <!--<input type="radio" name="type" value="table" id="type">Table<br>-->
			</td></tr>

			<tr><td>
			<?php echo form_dropdown('table_name', $tables, '', 'id="table_name"'); ?>
			 &nbsp; <input type="button" id="add_table" value="Add Table">   </td></tr>
			<tr><td> </td></tr>
		</table>
		</td>
	</tr>

	<tr>
	<td>
	  <table border="1" align="center" id="field_add_table">
	  <tr><td><b>Select</b> </td> <td><b>Column</b> </td> <td><b>Join With</b> </td> <td><b>Join Column</b> </td> <td><b>Group By</b> </td> <td><b>Aggregate function</b> </td> </tr>

	  </table>
		<input type="button" id="add_fields" value="Add Selected Fields">
	</td>

	</tr>

	<tr>
	<td>
	<br>
<br>	<table align="center" border="1" width="500px" id="filter_table">
			<tr><td><b>Field</b></td> <td><b>Comparison Func</b></td> <td><b>Value</b></td> </tr>
			</table>

			<table align="center" border="1" >
			<tr><td>
				Field <?php echo form_dropdown('cond_field', $fields, '', 'id="cond_field"'); ?>
			</td>
			<td>
			 Comparison :
			 <?php
			 	$operators = $this->config->item('comparison_operators');
			 	echo form_dropdown('operator', $operators, '', 'id="operator"');
			 ?>
			  </td>   <td>

			Value : <input type="text" id="comp_value" size="10">
			</td>  </tr>
			<tr><td colspan="3"><input type="button" value="Add Filter" id="add_filter">  </td>  </tr>

			</table>
		</td>
	</tr>
</table>
</body>
</html>