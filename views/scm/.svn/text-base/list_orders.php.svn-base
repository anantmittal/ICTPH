<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>List Pending Orders </title>

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
			<tr>	
				<?php if(isset($location_id))
				{ ?>
				<td colspan=2><b>Order from location </b></td><td><b><?php echo $scm_orgs[$from_id];?></b></td>
				<input type="hidden" name="from_id" value="<?php echo $from_id;?>" />
				<?php	}
				else { ?>
				<td>
				<b>Choose Order From Location</b></td>
				<td>
				<?php 
				echo form_dropdown ( 'from_id', $scm_orgs,$from_id );
				?>
				</td> <?php } ?>
				<td><b>Choose Order To Location</b></td>
				<td>
				<?php 
					echo form_dropdown ( 'to_id', $scm_orgs,$to_id );
				?>
				</td>
			</tr>

<tr>	
	<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" name="get_list" value="Generate List of Pending Orders"> </td>
	</tr>
</table>
</form>
<br><br>

<?php	
	if($total_results != 0)
	{ ?>
<div id="main">
  <div class="hospit_box">
<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Orders Found</span></div></div></div>
    
<div class="green_body">
 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
   <tr class="head">
     <td>SNo</td>
     <td>Order No</td>
     <td>Date</td>
     <td>From</td> 
     <td>To</td>
     <td>Comment</td>
     <td>Amount</td>
     <td>Action</td>
   </tr>
<?php 
  for ($i=0; $i < $total_results; $i++) {
  ?>
  <tr class="row">
    <td width="5%"> <?php echo ($i + 1)."."; ?> </td>
    <td width="7%" > <a href="<?php echo $this->config->item('base_url').'index.php/scm/order/show/'.$values[$i]['order_no'];?>"> <?php echo $values[$i]['order_no']; ?></a> </td>
    <td width="10%" > <?php echo $values[$i]['date']; ?> </td>
    <td width="25%" > <?php echo $values[$i]['from']; ?> </td>
    <td width="25%" > <?php echo $values[$i]['to']; ?> </td>
    <td width="10%" > <?php echo $values[$i]['comment']; ?> </td>
    <td width="8%" > <?php echo $values[$i]['bill_amount']; ?> </td>
    <?php if($values[$i]['to_origin'] == 'EXTERNAL'){
    	echo "<td width='10%'><a href='".$this->config->item('base_url')."index.php/scm/order/receive_order/".$values[$i]['order_no']."'>Receive Order</a></td>";
  	}else{
  		if(!$values[$i]['show_invoice']){
  			echo "<td width='10%'><a href='".$this->config->item('base_url')."index.php/scm/order/receive_order/".$values[$i]['order_no']."'>Receive Order</a></td>";
  		}else{
  			echo "<td width='10%'><a href='".$this->config->item('base_url')."index.php/scm/order/create_invoice/".$values[$i]['order_no']."'>Create Invoice</a></td>";
  		}
  	}?>
  </tr>
<?php  } ?>
  </table>
</div>

<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<?php } ?>

<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>

