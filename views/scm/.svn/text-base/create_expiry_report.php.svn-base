<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title>Expired Drugs Cost Report </title>

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
		<td colspan="2" align="center"  valign="middle"><h4>Enter From and To dates For Generating Expired Drugs Cost Report.</h4> </td>
		     <tr>
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
		         <td colspan="6"  align="center">From date should be before To date </td>        
		     </tr>
					<tr>	
						<td><b>Location</b></td>
						<td>
						
						<?php 
							echo form_dropdown ( 'location_id', $locations,$location_id );
						?>
						
						</td>
					</tr>
		
		<tr>	
			<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="get_report" value="Create Report"> </td>
			</tr>
		<?php	
			if(isset($report_filename1))
			{ ?>
		   <tr class="row">
  			 <td colspan="4" > <a href="<?php echo $this->config->item('base_url').'/uploads/mne/'.$report_filename1;?>"> Report generated. Click here to download. </a> </td>
  			</tr>
		<?php }else if(isset($no_data) && $no_data){
			?>
			<tr class="row">
  			 <td colspan="4" ><h4 style="color:#f00"> No data found for the given date range.</h4> </td>
  			</tr>
			
		<?php } ?>
	</table>
</form>
<br><br>


<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>

