<?php
$this->load->helper('form');
$this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

    <title>Valid Visit Lists</title> 
    
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
#stock_table{
	border-color : #ccc;
	border-collapse : collapse;
	border : 1px solid #ccc
}
</style>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
  </head>
    
<body>
      <?php
$this->load->view('common/header_logo_block');
$this->load->view('common/header_search');
      ?>

<div id="main">
  <div class="hospit_box">
<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">List of Visits for patients on <?php echo $date;?></span></div></div></div>
    

<div class="green_body">
	    <table  width="970px" border="1px" cellspacing="2" cellpadding="2" id="stock_table">
		      <tr class="head">
					<td width="97px">Person name</td>
					<td width="68px">Age(yrs)</td>
					<td width="126px">Gender</td>
					<td width="126px">Village</td>
					<td width="78px">Policy Id</td>
					<td width="97px">Show Visits</td>
		      </tr>
		      
		      <?php for ($i=0; $i< $total_results ; $i++) { 	?>
		      <tr>
					<td><?php echo $values[$i]['person_name']; ?></td>
					<td><?php echo $values[$i]['age']; ?> </td>
					<td><?php echo $values[$i]['gender']; ?></td>
					<td><?php echo $values[$i]['village']; ?></td>
					<td><a href="<?php echo $this->config->item('base_url').$policy_details_url.$values[$i]['policy_id']; ?>"><?php echo  $values[$i]['policy_id'] ?></a></td>
					<td><a href="<?php echo $this->config->item('base_url').$show_visit_url.$values[$i]['visit_id'].'/'.$values[$i]['policy_id']; ?>">Show Visit</a></td>
		      </tr>
		      <?php } ?>
	      
	    </table>
</div>
	    
	  
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<!--	  <div class="bluebtm_left" >
	    <div class="bluebtm_right">
		<div class="bluebtm_middle"></div>
	    </div>
	  </div>-->

	<br class="spacer"/>
	
	<?php $this->load->view('common/footer'); ?>
