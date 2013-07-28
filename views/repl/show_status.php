<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>Status of Machines </title>

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
<br><br>

<div id="main">
  <div class="hospit_box">
<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Machines Found</span></div></div></div>
    
<div class="green_body">
<form action="<?php echo $this->config->item('base_url').'index.php/repl/s_replicate/request_repl'; ?>" method="POST">
 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
   <tr class="head">
     <td>Machine Id</td>
     <td>Name</td>
     <td>Location</td>
     <td>Clinic Id</td> 
     <td>Last Heartbeat</td>
     <td>Last Tx From Server</td>
     <td>Last Rx To Server</td>
     <td>Cur Repl</td>
     <td>Req Repl</td>
   </tr>
    <input type="hidden" name="num_rows" value="<?php echo $num_rows;?>"/> 
<?php 
  for ($i=0; $i < $num_rows; $i++) {
  ?>
  <tr class="row">
    <td width="4%"> <?php echo $values[$i]['id']; ?> </td>
    <td width="20%" > <?php echo $values[$i]['name']; ?> </td>
    <td width="19%" > <?php echo $values[$i]['location']; ?> </td>
    <td width="4%" > <?php echo $values[$i]['clinic_id']; ?> </td>
    <td width="15%" > <?php echo $values[$i]['last_heartbeat']; ?> </td>
    <td width="15%" > <?php echo $values[$i]['last_tx']; ?> </td>
    <td width="15%" > <?php echo $values[$i]['last_rx']; ?> </td>
    <td width="4%" > <?php echo $values[$i]['to_replicate']; ?> </td>
    <td width="4%" > 
	<?php if ($values[$i]['to_replicate'] == 'No') { ?> <input type="checkbox" name="check_<?php echo $i;?>" value="Yes"/> <?php } 
	else { ?>
    	<input type="hidden" name="check_<?php echo $i;?>" value="No"/> 
	<?php } ?> 
    </td>
    <input type="hidden" name="id_<?php echo $i;?>" value="<?php echo $values[$i]['id'];?>"/> 
  </tr>
<?php  } ?>

  </table>
    <div class="form_row">
      <div class="form_newbtn"><input type="submit" name="submit" id="button" value="Request Replication" class="submit"/></div>
    </div>
</form>
</div>

<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>


<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
