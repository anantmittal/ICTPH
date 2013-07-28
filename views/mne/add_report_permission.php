<html>
<head>
<title>Add Permissions to report</title>

<?php if(!isset($report_id)) { ?>
<link rel="stylesheet" type="text/css"
href="<?php echo $this->config->item('base_url'); ?>assets/css/jquery.autocomplete.css"/>

<script type="text/javascript"
src='<?php echo $this->config->item("base_url")."assets/js/jquery-1.3.2.js"; ?>'>
</script>
<script type='text/javascript' src='<?php echo $this->config->item('base_url'); ?>assets/js/jquery.autocomplete.js'></script>



<script type="text/javascript" >

var base_url = '<?php echo $this->config->item('base_url'); ?>';
//jquery auto complete code start here

$(document).ready(function() {

	function findValueCallback(event, data, formatted) {
		//$("<li>").html(!data ? "No match!" : "Marathi name: " + formatted+" English name: " + data[1]).appendTo("#result");
	}

	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

	$(":text").result(findValueCallback).next().click(function() {
		$(this).prev().search();
	});

	 $(".report_name").autocomplete( base_url + "index.php/monitoring_evaluation/report/report_values",{width: 260,	selectFirst: false});
//	 $(".username").autocomplete('http://google.com',{	width: 260,	selectFirst: false});

	$(".report_name").result (
	function(event, data, formatted) {
		if (data)
			$('#report_id').val(data[1]);
	});
});
//jquery auto complete code start here
</script>
<?php } ?>

</head>
<body>
<form method="POST">
<table align="center" width="50%" border="1">
<tr><td colspan="2" align="center"><b>Add Permissions to report</b></td> </tr>

<?php if(isset($report_id)) { ?>
<tr><td>Report ID: </td>  <td>
<input type="hidden" name="id" value="<?php echo $report_id;?>"> <?php echo $report_id;?>  </td></tr>
<tr><td>Report Name: </td>  <td>
<input type="hidden" name="name" value="<?php echo $report_name;?>">
<?php echo $report_name; ?>

</td></tr>
<?php }  else { ?>
<tr><td>Report Name: </td>  <td>
<input type="hidden" name="id" value="" id="report_id">
<input type="text" name="name" class="report_name">  </td></tr>
<?php echo form_error(''); ?>
<?php } ?>

<tr><td valign="top">Username : </td> <td><input type="text" name="username" class="username"> <br>
<?php echo form_error('username'); ?>
 </td> </tr>
<tr><td> </td> <td><input type="submit" name="submit" value="Submit">  </td> </tr>
</table>
</form>
</body>
</html>