<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>Generate <?php echo $report->name; ?> Report </title>

</head>

<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<!--Main Page-->
<form method="POST">
<table align="center" border="1">
<tr>
<td colspan=2 align="center"><h3><?php echo $report->name; ?> Report</h3>
<p><?php echo $report->body;?></p>
</td>
</tr>
<?php 
	foreach($variables as $variable)
	{ ?>
	<tr>
     		<td><b><?php echo $variable->name; ?></b> </td>
     		<td>
		<?php if($variable->type == 'Text')
		{ ?>
       			<input name="<?php echo $variable->alias;?>" type="text"  value='"text"'/>
		<?php } 
		else 
		{ ?>
		       <input name="<?php echo $variable->alias;?>" id="<?php echo $variable->alias;?>" type="text" value="DD/MM/YYYY" class="datepicker check_dateFormat"  style="width:140px;"  />
		
		<? }
		?>
		</td>
	</tr>
	<?php }?>
	<tr>
     		<td><b>Email Address</b> </td>
     		<td><input type="text" name="email_address" size=50> </td>
	</tr>

<tr>	
	<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" name="get_report" value="Generate Report"> </td>
</tr>
<?php	
	if(isset($filename))
	{ ?>
  <tr >
   <td>Email Status:</td>
   <td><?php echo $mail_sent;?></td>
  </tr>
  <tr >
   <td colspan="2" > <a href="<?php echo $this->config->item('base_url').$filename;?>"><?php echo $report->name;?> Report file has been created. Click here to download. </a> </td>
  </tr>
<?php } ?>
</table>
</form>

<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
