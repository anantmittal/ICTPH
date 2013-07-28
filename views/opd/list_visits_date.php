<?php
$this->load->helper('form');
$this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

    <title>Patient Visits</title> 
    
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
    
<body>
<form method="POST">
      <?php
$this->load->view('common/header_logo_block');
$this->load->view('common/header_search');
      ?>

<div id="main">
  <div class="hospit_box">
<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Visits for date <?php echo $date; ?></span></div></div></div>
    

<div class="green_body">
	    <table  width="100%" border="0" cellspacing="2" cellpadding="2">
	      <!-- TODO: Any additional fields required? -->
	      <tr class="head">
		<td width="5%">ID </td>
		<td width="5%">Date</td>
		<td width="10%">Location</td>
		<td width="10%">Valid</td>
		<td width="10%">Approved</td>
		<td width="5%">Policy Id</td>
		<td width="5%">Amount</td>
		<td width="10%">HPI</td>
		<td width="20%">Chief complaint</td>
		<td width="20%">Assessment</td>
	      </tr>
	      
		<input name="number" type="hidden" value="<?php echo $number;?>" />

	      <?php for ($i=0; $i< $number ; $i++) { 
			$v = $visits[$i];	
			?>
	      <tr>
		<td><a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/show/'.$v->visit_id.'/'.$v->policy_id; ?>"><?php echo $v->visit_id; ?></a>
		<input name="visit_id_<?php echo $i;?>" type="hidden"  value="<?php echo $v->visit_id;?>" /> </td>
		<td><?php echo $v->date; ?></td>
		<td><?php echo $v->locn_name; ?></td>
		<td>
	      		<select name="valid_state_<?php echo $i;?>">
			<option value="Valid" <?php if($v->valid_state == 'Valid') { echo 'selected="selected"';} ?>>Valid</option>
			<option value="Invalid" <?php if($v->valid_state == 'Invalid') { echo 'selected="selected"';} ?> >Invalid</option>
			</select>
		</td>
		<td><?php echo $v->approved; ?></td>
		<td><?php echo $v->person_id; ?></td>
		<td><?php echo $v->policy_id; ?></td>
		<td><?php echo $v->paid_amount; ?></td>
		<td><?php echo $v->hpi; ?></td>
		<td><?php echo $v->chief_complaint; ?></td>
		<td><?php echo $v->assessment; ?></td>
	      </tr>
	      <?php } ?>
	      
	<tr>	
		<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit" name="update_status" value="Update Status of Visits"> </td>
	</tr>
	    </table>
</div>
	</form>
	    
	  
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<!--	  <div class="bluebtm_left" >
	    <div class="bluebtm_right">
		<div class="bluebtm_middle"></div>
	    </div>
	  </div>-->

	<br class="spacer"/>
	
	<?php $this->load->view('common/footer'); ?>
