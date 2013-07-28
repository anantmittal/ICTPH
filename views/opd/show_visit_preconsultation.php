<?php
$this->load->helper('form');
$this->load->view('common/header');
?>
  <link href="<?php echo "{$this->config->item('base_url')}assets/css/site.css";?>" rel="stylesheet" type="text/css"/> 
  <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery-ui-1.7.2.custom.css";?>" rel="stylesheet" type="text/css"/>
  <link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css"/>
    
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>

<script type="text/javascript">
  var visit_id="<?php echo $visit->id; ?>";
  var username="<?php echo $this->session->userdata('username'); ?>";
</script>
<!--    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/show_overview_resp.js"; ?>"></script> -->
    
<title>Preconsultation Details</title> 
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

	  <div class="blue_left">
	    <div class="blue_right">
	      <div class="blue_middle"><span class="head_box">Preconsultation Details</span></div>
	    </div>
	  </div>
	  <div class="blue_body" style="padding:10px;">  

	    <!-- TODO - remove the hardcoded values below -->
	    <table>
	      <tr>
				<td width="10%">Date</td>
				<td width="10%"><?php echo Date_util::to_display($visit->date); ?></td>
				<td width="10%" colspan="2"/>
		  </tr>

	      <tr>
				<td>Provider:</td>
				<td><?php echo $visit->related('provider')->get()->full_name; ?></td>
				<td>Location:</td>
				<td><?php echo $visit->related('provider_location')->get()->name; ?></td>
	      </tr>

	      <?php
	      	$fv = $visit->followup_to_visit_id;
	      	if ($fv != 0) {
	      ?>
	      <tr>
				<td>Followup to:</td>
				<td colspan="3">Visit <a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/show/'.$fv; ?>">
		    	<?php echo $fv ?></a>
				</td>
	      </tr>
		  
	      <?php
	      }
	      ?>
	      
	      <tr>
				<td>Vitals:</td>
				<?php $visit_vitals = $visit->related('visit_vitals')->get();?>
				<td colspan="3"> <?php echo Utils::print_vitals($visit_vitals); ?></td>
	      </tr>
	          
	      <tr>
				<td>Vision Details:</td>
				<?php $vision_details = $visit->related('visit_visuals')->get(); ?>
				<td colspan="3"> <?php echo Utils::print_vision($vision_details); ?></td>
	      </tr>
	      
	      <tr>
				<td width="10%">Edit Preconsultation details</td>
				<td width="10%" colspan="3"/>
				<?php $edit_url = $this->config->item('base_url').'index.php/opd/visit/edit_preconsultation/'.$visit->id.'/'.$policy_id; ?>
				<input type="button" value="Edit Preconsultation Details" onClick="window.location = '<?php echo $edit_url; ?>'">
				</td>
	      </tr>

	     </table>

	  </div>
	  <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br />
	  
	  
	</div>

      </div>
    </body>
</html>
