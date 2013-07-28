<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>Create Insurance CSV file / Html </title>

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
width:550px;
margin:auto;
border:#000000 1px solid;
}
.mainhead{background-color : #aaaaaa;}
.tablehead{background-color : #d7d7d7;}
.row{   background-color : #e7e7e7;}
.data_table tr{
	font-size:11px;
	height:25px;
	background-color:#e8e8e8;
}

.largeselect {   width:200px; }

</style>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<!--Main Page-->
<?php echo validation_errors(); ?>
<form action="create_insurance_csv" method="POST">
<table align="center" border="1">
<td colspan=2 align="center" valign="middle"><h4>Please Enter Policy End Date For getting insurance file.</h4> </td>
	<tr>
     <td><b>Policy End Date</b> </td>
     <td>
       <input name="policy_end_date" id="policy_end_date" type="text" value="<?php echo $policy_end_date; ?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
	</tr>
<!--	<tr>
     <td><b>From Date</b> </td>
     <td>
       <input name="from_date" id="from_date" type="text" value="DD/MM/YYYY" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
	</tr>
	<tr>
     <td> <b>To Date</b> </td>
     <td>
       <input name="to_date" id="to_date" type="text" value="DD/MM/YYYY" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
	</tr>
	<tr>
         <td colspan="6" align="center">From date should be oldest date and To date is latest date</td>        
	</tr> -->
	
	<tr><td colspan = 2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" name="get_csv" value="Create File"> </td>
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

<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
