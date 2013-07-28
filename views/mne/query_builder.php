<html>
<head>
<script type="text/javascript"
	src='<?php
	echo $this->config->item ( "base_url" ) . "assets/js/jquery-1.3.2.js";
	?>'>
</script>
<script type="text/javascript"><!--
$(document).ready(function(){
	$('#select1').change(function(){
		var table = $(this).val();
		var options = '';
		if(table == 'default'){
			alert('select table');
			$('#select3').html(options);
			return;
		}

		var i = 0 ;
		for (i = 1; i <= 5; i++ ){
			options += '<option value="'+ table +'.field'+ i +'">'+ table +'.field'+  i  +'</option>';
		}
		$('#select3').html(options);
	});

	$('#select2').change(function(){
		var table = $(this).val();
		var options = '';
		var i = 0 ;

		if(table == 'default'){
			alert('select table');
			$('#select4').html(options);
			return;
		}
		for (i = 1; i <= 5; i++ ){
			options += '<option value="'+ table +'.field'+ i +'">'+ table +'.field'+  i  +'</option>';
		}
		$('#select4').html(options);
	});
});
</script>

</head>
<body>

<table border="0">
<tr>
<td>
		<select name="select1" id="select1">
		<option value="default">default</option>
		<option value="tableA">tableA </option>
		<option value="tableB">tableB </option>
		<option value="tableC">tableC </option>
		<option value="tableD">tableD </option>
		<option value="tableF">tableE </option>
		</select>
		JOIN
</td>

<td>
		<select name="select2" id="select2">
		<option value="default">default</option>
		<option value="tableA">tableA </option>
		<option value="tableB">tableB </option>
		<option value="tableC">tableC </option>
		<option value="tableD">tableD </option>
		<option value="tableF">tableE </option>
		</select>
		ON
</td>

<td>
		<select name="select3" id="select3"></select>
		AND
</td>

<td>
		<select name="select4" id="select4"></select>
</td>
</tr>
</table>

</body>
</html>
