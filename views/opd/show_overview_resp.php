<?php
$this->load->helper('form');
$this->load->view('common/header');
?>
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/site.css";?>" rel="stylesheet" type="text/css"/> 
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery-ui-1.7.2.custom.css";?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>
<!--
    <script type="text/javascript">
     var base_url="<?php echo $this->config->item('base_url'); ?>";
    </script>
-->
<!--    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/show_overview_resp.js"; ?>"></script> -->
    
    <script type="text/javascript">
$(document).ready(function(){
	var past_encounters = "<?php echo $past_encounters;?>";
	
	if(!past_encounters){
		$('#past_encounters').hide();
		
	}	
		
});



$(document).ready(function(){
	var diagnostic_tests = "<?php echo $diagnostic_tests;?>";
	
	if(!diagnostic_tests){
		$('#diagnostic_tests').hide();
		
	}	
		
});
$(document).ready(function(){
	var family_histories = "<?php echo $family_histories;?>";
	
	if(!family_histories){
		$('#family_history').hide();
		
	}	
		
});
	</script>
    <title>Patient Overview</title> 
    
  </head>
    
    <body>
      <?php /*>*/;
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

	  <!-- <div class="blue_left">
	    <div class="blue_right">
	      <div class="blue_middle"><span class="head_box">Illnesses</span></div>
	    </div>
	  </div>
	  <div class="blue_body" style="padding:10px;">  
	    //<?php //$this->load->view('opd/history/illness_box', $illnesses); ?>
	  </div>
	  
	  <div class="bluebtm_left" >
	    <div class="bluebtm_right"><div class="bluebtm_middle"></div></div>
	  </div>
	  <br/> -->
	 

	

	  
	  
	  <div id = "past_encounters">
	   <div class="blue_left">
	    <div class="blue_right"><div class="blue_middle"><span class="head_box">Past Encounters</span></div></div>
	  </div>

	  <div class="blue_body" style="padding:10px;">
  
	 
	    
	    <table width="100%" border="0" cellspacing="2" cellpadding="2">
	      <!-- TODO: Any additional fields required? -->
	      <tr class="head">
		<td>CC</td>
		<td width = 20%>DD</td>
		<td>Medication</td>
		<td>Services</td>
		<td>OP Products</td>
		<td>Date</td>
		 
	      </tr>
	      
	     <?php  if(isset($past_encounters)) foreach ($past_encounters as $past) { ?>
	      <tr class="head; grey_bg">
		
		<td><?php echo $past['visit_details']['chief_complaint'];?></td>
		
		<td><?php if(isset($past['diagnosis'])) foreach ($past['diagnosis'] as $d) { ?>
		<table><tr class="head; grey_bg">
		<?php echo $d['name'];?>
		</tr>
		</table>
		<?php }?>
		</td>
		
		
		<td><?php if(isset($past['medication'])) foreach ($past['medication'] as $m) { ?>
		<table><tr class="head; grey_bg">
		<?php echo $m['name'];?>
		</tr>
		</table>
		<?php }?>
		</td>
		
		<td><?php if(isset($past['service'])) foreach ($past['service'] as $s) { ?>
		<table><tr class="head; grey_bg">
		<?php echo $s['name'];?>
		</tr>
		</table>
		<?php }?>
		</td>
		<td><?php if(isset($past['opd_product'])) foreach ($past['opd_product'] as $opd_product) { ?>
		<table><tr class="head; grey_bg">
		<?php echo $opd_product['name'];?>
		</tr>
		</table>
		<?php }?>
		</td>
		<td><a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/show/'.$past['visit_details']['visit_id'].'/'.$policy_id; ?>"><?php echo $past['visit_details']['date'];?></a></td>
		</tr>
		
	   <?php }?>
	    </table>
	    
	   </div>
	  
	  <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br /> 
	  </div>
	  
	  <!--  End of Past Encounters -->
	  
	  
	  <div id = "diagnostic_tests">
	  <div class="blue_left">
	    <div class="blue_right"><div class="blue_middle"><span class="head_box">Diagnostic Tests Conducted</span></div></div>
	  </div>

	  <div class="blue_body" style="padding:10px;">
  
	    
	    
	    <table width="100%" border="0" cellspacing="2" cellpadding="2">
	      <!-- TODO: Any additional fields required? -->
	      <tr class="head">
		<td>Test</td>
		<?php if(isset($test_dates)) for($d=1;$d<=count($test_dates);$d++) { ?>
		<td><a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/show/'.$test_visit_ids{$d}.'/'.$policy_id; ?>"><?php echo $test_dates{$d}; ?></a></td>
		<?php }?>  
	      </tr>
	   
	      <?php  if(isset($diagnostic_tests)) foreach ($diagnostic_tests as $test_name => $results) { ?>
	      <tr class="head; grey_bg">
		<td><?php echo $test_name; ?></td>
		<?php for($k=1;$k<=count($test_dates);$k++) {?>
		
		<td><?php echo @$results{$k}; ?></td>
		
		<?php }?>
		
	      </tr>
	      <?php  } ?>
	   
	    </table>
	    
	  </div>
	  
	  <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br /> 
	  </div>
	  <!--  End of Diagnostic tests -->
	  <!-- 
	  <div class="blue_left"><div class="blue_right">
	      <div class="blue_middle"><span class="head_box">Birth History</span></div></div></div>
	  <div class="blue_body" style="padding:10px;">
	    Normal, spontaneous vaginal delivery, full term, no complications
	    <a href="edit-birth-history.shtml">Edit&nbsp;</a>
	  </div>
	  
	  <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br /> 
	   -->
	  <!-- Beginnning of Family History -->
	  <div id = "family_history">
	  <div class="blue_left"><div class="blue_right">
	      <div class="blue_middle"><span class="head_box">Family History</span></div></div></div>
	  <div class="blue_body" style="padding:10px;">
	    <table width="100%" border="0" cellspacing="2" cellpadding="2">
	      <!-- TODO: Any additional fields required? -->
	      <tr class="head">
	      <?php  if(isset($family_histories)) foreach ($family_histories as $f) { ?>
	      
		<td><?php echo $f;?></td>
		 <?php } ?>
	      </tr>
	          
	      
	  </table>
	  </div>

	<div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br /> 
	</div>
	
    </div>
    </body>
</html>
