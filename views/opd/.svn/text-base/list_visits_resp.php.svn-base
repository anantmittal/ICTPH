<?php
$this->load->helper('form');
$this->load->view('common/header');
?>
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/site.css";?>" rel="stylesheet" type="text/css"/> 
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery-ui-1.7.2.custom.css";?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>
<!--    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/show_overview_resp.js"; ?>"></script> -->
 
    <title>Patient Visits</title> 
    
  </head>
    
    <body>
      <?php
$this->load->view('common/header_logo_block');
$this->load->view('common/header_search');
      ?>

      <!--Head end-->
      <!-- Body Start -->
      <div id="main">
	
	<div id="leftcol">

	  <div class="yelo_left">
	    <div class="yelo_right">
	      <div class="yelo_middle"><span class="head_box">Patient Details</span></div>
	    </div>
	  </div>

	  <div class="yelo_body" style="padding:8px;">
	    <?php $this->load->view('opd/patient_context', $person, $household); ?>
	    <?php $this->load->view('opd/menu', $person); ?>
	  </div>

	  <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
	  
	</div>
      
	<div id="rightcol">

	  <div class="blue_left">
	    <div class="blue_right">
	      <div class="blue_middle"><span class="head_box">Visits</span></div>
	    </div>
	  </div>
	  <div class="blue_body" style="padding:10px;">  


	    <table id="illnesses" width="100%" border="0" cellspacing="2" cellpadding="2">
	      <!-- TODO: Any additional fields required? -->
	      <tr class="head">
		<td width="5%">ID </td>
		<td width="5%">Date</td>
		<td width="15%">Provider</td>
		<td width="15%">Location</td>
		<td width="5%">Bill Paid</td>
		<td width="20%">Chief complaint</td>
		<td width="15%">Differential Diagnosis</td>
		<td width="10%">Next action(s)</td>
	      </tr>
	      
	      <?php foreach ($visits as $v) { ?>
	      <tr>
		<td><a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/show/'.$v->id.'/'.$policy_id; ?>"><?php echo $v->id; ?></a></td>
		<td><?php echo $v->date; ?></td>
		<td><?php echo $v->related('provider')->get()->full_name; ?></td>
		<td><?php echo $v->related('provider_location')->get()->name; ?></td>
		<td><?php echo $v->bill_paid; ?></td>
		<td><?php echo $v->chief_complaint; ?></td>
		<td><?php 
		  foreach ($v->related('visit_diagnosis_entries')->get() as $d)
		  	echo $d->diagnosis.", &nbsp;";
		//$echo v->assessment; ?></td>
		<td>
		  <a href="<?php
		    echo $this->config->item('base_url').'index.php/opd/visit/show/'.$v->id.'/'.$policy_id; ?>">
		    Show</a>
		  <?php if(!$hew_login) {?><a href="<?php
		    echo $this->config->item('base_url').'index.php/opd/visit/add_followup_visit/'.$v->id.'/'.$policy_id; ?>">
		    Add followup visit</a>
		  <?php }?>
		</td>
	      </tr>
	      <?php } ?>
	      
	    </table>
	    
	  </div>
	  
	  <div class="bluebtm_left" >
	    <div class="bluebtm_right"><div class="bluebtm_middle"></div></div>
	  </div>
	</div>

	<br class="spacer"/>
	
	<?php $this->load->view('common/footer'); ?>
    </body>
</html>
