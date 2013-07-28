<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>Search policies by date range </title>

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
<form action="search_policies_by_date" method="POST">
<table align="center" border="1">
<td colspan=4 align="center" valign="middle"><h4>Please Enter From and To dates For searching policies.</h4> </td>
	<tr>
     <td><b>From Date</b> 
       <input name="from_date" id="from_date" type="text" value="<?php echo $from_date; ?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
     <td> <b>To Date</b> 
       <input name="to_date" id="to_date" type="text" value="<?php echo $to_date; ?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
	<td> <input type="submit" name="search_policies" value="List Policies"> </td>
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
    	  <div class="green_middle"><span class="head_box">Policies Found</span></div></div></div>
    
<div class="green_body">
 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
   <tr class="head">
     <td>SNo</td>
     <td>Policy No</td>
     <td>Form No</td>
     <td>Name of Proposer</td>
     <td>Address</td> 
     <td>Amount Collected</td>
<!--     <td>1 | 2 | 3 | 4 | 5 | 6 | 7 </td> -->
     <td>1  </td>
     <td>2  </td>
     <td>3  </td>
     <td>4  </td>
     <td>5  </td>
     <td>6  </td>
     <td>7  </td>
   </tr>
<?php 
  for ($i=0; $i < $total_results; $i++) {
  ?>
  <tr class="row">
    <td width="4%"> <?php echo ($i + 1)."."; ?> </td>
    <td width="20%" > <a href="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/edit_new_health_member/'.$values[$i]['policy_id'];?>"> <?php echo $values[$i]['policy_id']; ?>  </a> </td>
    <td width="20%" > <?php echo $values[$i]['form_number']; ?> </td>
    <td width="20%" > <?php echo $values[$i]['hof_name']; ?> </td>
    <td width="15%" > <?php echo $values[$i]['address']; ?> </td>
    <td width="7%" > <?php echo $values[$i]['amount']; ?> </td>
<!--    <td width="14%" align=center > -->
<?php	
    $image_status = $values[$i]['images_status'];  
    $image_names = $values[$i]['images_name']; 
for($j =0; $j<7; $j++) { ?>
    <td width="2%" align=center > 
<?php    if($image_status[$j]=='Y') {
        echo '<a href="'.$image_names[$j].'" >'; 
    } 
    echo $image_status[$j];  
    if($image_status[$j]=='Y') {
        echo '</a>'; 
    }?> 
  </td>
<?php  } ?>
<!--    <td width="14%" > <?php echo $values[$i]['images_string']; ?> </td>-->
  </td>
  </tr>
<?php  } ?>
  </table>
<div class="form_row"> </div>
			</div><div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div></div>
<?php } ?>


<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
