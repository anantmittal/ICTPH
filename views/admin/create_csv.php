<html>
<head>
<style>
.error
{
color:red;
font-weight:bold;
}
</style>
<title>Create CSV file / Html </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<?php echo validation_errors(); ?>
<form action="create_csv" method="POST">
<table align="center" border="1">
<tr>
<td colspan="4" align="center" valign="middle"><h4>Please Enter From and To dates of "Data Entry" For getting csv file.</h4> </td>
	</tr>
	<tr>
         <td><b>Date From</b></td> <td><input name="dateFrom" value="<?php echo set_value('dateFrom'); ?>" size="10">eg.(yyyy-mm-dd)</td>
         <td><b>Date To</b></td> <td><input name="dateTo" value="<?php echo set_value('dateTo'); ?>" size="10">eg.(yyyy-mm-dd)</td>
	</tr>
	<tr>
         <td colspan="4" align="center">From date should be oldest date and To date is latest date</td>        
	</tr>
	<tr>
         <td colspan="4"><input type="radio" name="op_type" value="csv" >Output In CSV Format &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type="radio" name="op_type" value="html" checked>Output In HTML Format</td> 
         
	</tr>
	
	<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" name="get_csv" value="Get Output"> </td>
	<td align="center" colspan="2">
	<a href="<?php echo $this->config->item('base_url');?>index.php/enrolment/addEnrolledFamily">Add new family</a> </td>
	</tr>
</table>
</form>
<br><br>

<?php	
	if(isset($values))
	{ ?>
<table border="1" cellpadding="5" cellspacing="0" align="center">
<tr><td><b>SNo</b></td><td><b>Family <br> Member No</b></td><td><b>Policy Number</b></td><td><b>Full Name</b></td><td><b>Relation</b></td><td><b>Date Of Birth</b></td><td><b>Gender</b></td><td><b>AgeApprox</b></td><td><b>Age</b></td> </tr>
	<?php
		foreach ($values as &$val)
		{
			echo "<tr><td>{$val['0']}</td> <td>{$val['1']}</td>  <td>{$val['policy_number']}</td> 
			      <td>{$val['full_name']}</td> <td>{$val['relation']}</td> <td>{$val['date_of_birth']}</td> <td>{$val['gender']}</td> 
			      <td>{$val['AgeApprox']}</td> <td>{$val['age']}</td> </tr>";
		}
	}
echo "</table>";
	?>


</body>
</html>