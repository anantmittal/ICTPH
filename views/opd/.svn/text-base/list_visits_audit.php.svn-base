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
      <?php
$this->load->view('common/header_logo_block');
$this->load->view('common/header_search');
      ?>

<div id="main">
  <div class="hospit_box">
<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Visits with pending Audit</span></div></div></div>
    

<div class="green_body">
	    <table  width="100%" border="0" cellspacing="2" cellpadding="2">
	      <!-- TODO: Any additional fields required? -->
	      <tr class="head">
		<td width="5%">ID </td>
		<td width="12%">Date</td>
		<td width="18%">Location</td>
		<td width="5%">Valid</td>
		<td width="5%">Approved</td>
		<td width="5%">Audit Status</td>
		<td width="25%">Note Date and Comment</td>
		<td width="15%">Chief complaint</td>
		<td width="10%">Differential Diagnosis</td>
	      </tr>
	      
	      <?php for ($i=0; $i< $number ; $i++) { 
			$v = $visits[$i];	
			?>
	      <tr>
		<td><a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/show/'.$v->visit_id.'/'.$v->policy_id; ?>"><?php echo $v->visit_id; ?></a>
		<td><?php echo $v->date; ?></td>
		<td><?php echo $v->locn_name; ?></td>
		<td><?php echo $v->valid_state; ?></td>
		<td><?php echo $v->approved; ?></td>
		<td><?php echo $v->audit_status; ?></td>
		<td>
		  <?php 
		  $vas = $this->visit_addendum->find_all_by('visit_id',$v->visit_id);
		  foreach ($vas as $a)
		  echo Date_util::to_display($a->date).'&nbsp;&nbsp;'.$a->addendum.'<br />';
		  ?>
		</td>
		<td><?php echo $v->chief_complaint; ?></td>
		<td>
		  <?php 
		  $vds = $this->visit_diagnosis_entry->find_all_by('visit_id',$v->visit_id);
		  foreach ($vds as $d)
		  echo $d->diagnosis.", &nbsp;";
		  ?>
		</td>
	      </tr>
	      <?php } ?>
	      
	<tr>	
		<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
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
