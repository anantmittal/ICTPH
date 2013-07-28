<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>Create ID File / Html </title>

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
<form method="POST">
<table align="center" border="1">
<td colspan="2" align="center" valign="middle"><h4>Please Enter From and To dates For ID Card generation file.</h4> </td>
	<tr>
     <td><b>Search By</b> </td>
     <td><?php echo form_dropdown("search_by", array('ID' => 'ID','End_Date' => 'Policy End Date'), '', 'class="bigselect"'); ?></td>
	</tr>

	<tr>
     <td><b>Search Value</b> </td>
     <td>
       <input name="search_value" id="search_value" type="text" value="<?php echo $search_value; ?>" />
     </td>

<!--	<tr>
     <td><b>Policy End Date</b> </td>
     <td>
       <input name="policy_end_date" id="policy_end_date" type="text" value="<?php echo $policy_end_date; ?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
	</tr>-->
<!--	<tr>
     <td><b>From Date</b> </td>
     <td>
       <input name="from_date" id="from_date" type="text" value="<?php echo $from_date; ?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
	</tr>
	<tr>
     <td> <b>To Date</b> </td>
     <td>
       <input name="to_date" id="to_date" type="text" value="<?php echo $to_date; ?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
	</tr>
	<tr>
         <td colspan="6" align="center">From date should be oldest date and To date is latest date</td>        
	</tr> -->
<!--	<tr>
         <td><b>Policy Valid Upto Date</b> </td> 
     <td>
       <input name="issue_date" id="issue_date" type="text" value="<?php echo $issue_date; ?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
	</tr>-->
<!--         <td><b>Policy Valid Upto Date</b> </td> 
		 <td> <input name="issue_date_dd" value="DD" size="2" maxlength="2"> </td>
		 <td> <input name="issue_date_mm" value="MM" size="2" maxlength="2"> </td>
		 <td> <input name="issue_date_yy" value="YYYY" size="4" maxlength="4"> </td> -->
<tr>	
	<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" name="get_idcard" value="Create File"> </td>
	</tr>
<?php	
	if(isset($filename))
	{ ?>
  <tr class="row">
   <td colspan="4" > <a href="<?php echo $this->config->item('base_url').'/uploads/idcard_file/'.$filename;?>"> ID Card file has been created. Click here to download. </a> </td>
  </tr>
<?php } ?>
</table>
</form>
<br><br>


<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>

