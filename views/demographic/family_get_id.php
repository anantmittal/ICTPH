<html>
<head>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/js/jquery.js"></script>
<script type='text/javascript' src='<?php echo $this->config->item('base_url'); ?>assets/js/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url'); ?>assets/css/jquery.autocomplete.css" />

<script>
//jquery auto complete code start here

    function add_family_id(famObj)
    {
        document.getElementById('family_id').value = famObj.value;
    }
    
	var base_url = "<?php echo $this->config->item('base_url'); ?>";
	var actual_val;
	$().ready(function() 
	{
		function findValueCallback(event, data, formatted) 
		{			
			
			//$("<li>").html(!data ? "No match!" : "Marathi name: " + formatted+" English name: " + data[1]).appendTo("#result");	
			document.getElementById('family_id').value = data[1];
		}
		function formatResult(row) 
		{
		return row[0].replace(/(<.+?>)/gi, '');
		}
		$(":text").result(findValueCallback).next().click(function() 
		{		
			$(this).prev().search();
		});
	          
	    $(".memname").autocomplete(base_url+"index.php/common/get_family_head_list",
		{
			width: 260,
			selectFirst: false
		});
	
		$(".memname").result(
		    function(event, data, formatted) 
		    {	    	
			  if (data)
			     $(this).parent().next().find("input").val(data[1]);}
	          );     
	          
	});
//jquery auto-complete code ends here
</script>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#666666;
	margin:0px;
	padding:0px;
}
.maindiv
{
width:50%;
margin:auto;
border:#000000 1px solid;
}
.mainhead{background-color : #aaaaaa;}
.tablehead{background-color : #d7d7d7;}
.row{   background-color : #e7e7e7;}
.smallselect {   width:100px; }
.bigselect {   width:150px; }
.largeselect {   width:200px; }

</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<p style="padding:10px 0px 0px 50px; margin:auto;"><?php echo validation_errors(); ?></p>

<div class="maindiv" align="center">
<form method="POST" action="">
 <table width="90%">
 	<tr class="tablehead">
 		<td colspan="2"><b>Please Enter the family householder name (in Marathi)</b></td>
 	</tr>
 	<tr>
 		<!--<td width="" class="row"><b>Family Householder name</b></td><td><input type="text" name="family_id" size="10"></td>-->
 		<td width="" class="row"><b>Family Head Name :</b></td>
 		<td><input class="memname" type="text" name="family_head_name" size="20">
 		<input id="family_id" name="family_id" type="hidden"></td>
 	</tr>
 		<tr>
 		<!--<td width="" class="row"><b>Family Id</b></td><td><input type="text" name="family_id" size="10"></td>-->
 		<td align="center" > <b>OR</b> </td>
 		<td>&nbsp;</td>
 	</tr>
 	<tr>
 		<!--<td width="" class="row"><b>Family Id</b></td><td><input type="text" name="family_id" size="10"></td>-->
 		<td width="" class="row"><b>Family Id :</b></td>
 		<td><input name="fam_id" id="fam_id" type="text" size="10" onblur="add_family_id(this)"></td>
 	</tr>
 	<tr>
 		<td></td><td><input type="submit" value="submit"> </td>
 	</tr>
 </table> 
 </form>
</div>
</body>
</html>
