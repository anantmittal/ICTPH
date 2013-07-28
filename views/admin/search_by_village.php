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
     <td>Member Names</td>
     <td>Address</td> 
     <td>Village</td>
   </tr>
<?php 
  for ($i=0; $i < $total_results; $i++) {
  ?>
  <tr class="row">
    <td width="5%"> <?php echo ($i + 1)."."; ?> </td>
    <td width="20%" > <a href="<?php echo $this->config->item('base_url').$link_url.$values[$i]['policy_id'];?>"> <?php echo $values[$i]['policy_id']; ?>  </a> </td>
    <td width="30%" > 
<!--	<?php echo $values[$i]['hof_name']; ?> -->
	      <table>
		<?php	      
	      	$j=1;
		foreach($values[$i]['persons'] as $person_rec)
	      	{ 
	echo '<tr><td>'.$j.'.</td><td>'.$person_rec->full_name.'</td><td>'.$person_rec->gender.'</td><td>'.Date_util::age($person_rec->date_of_birth).' yrs</td></tr>';
	$j++;
	      	}
	      	?>
	      </table>
     </td>
    <td width="35%" > <?php echo $values[$i]['address']; ?> </td>
    <td width="10%" > <?php echo $values[$i]['village']; ?> </td>
  </tr>
<?php  } ?>

	      <?php if ($other_actions) { ?>
	      <tr>
		<td colspan="5" align="right">
		  <?php foreach ($other_actions as $text => $url) { ?>
		  <!-- <input id="load_medications" type="button" class="submit" value="Load from Medications"> -->
		  <a href="<?php echo $this->config->item('base_url').$url; ?>" class="submit"><?php echo $text; ?></a>
		  <?php } ?>
		</td>
	      </tr>
	      <?php } ?>
  </table>
</div>

<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<?php } ?>


<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
