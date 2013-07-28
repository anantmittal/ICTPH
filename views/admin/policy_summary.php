<?php /**/;
$this->load->helper('form');
$this->load->library('Date_util');
$this->load->view('common/header');
?>
    <meta http-equiv="Content-Language" content="en" />
    <meta name="GENERATOR" content="Zend Studio" />
    
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
    <title>Policy details</title>
    
    <link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
  </head>
    
    <body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
  <?php /**/;
$this->load->view('common/header_logo_block');
$this->load->view('common/header_search');
      ?>
      
      <?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'><span>$success_message</span></div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>
      <div id="main">
	<div class="blue_left">
	  <div class="blue_right">
	    <div class="blue_middle"><span class="head_box">Policy Details</span></div>
	  </div>
	</div>
	<div class="blue_body" style="padding:10px;">  
	  
	  <div class="form_row">
	    <div class="form_left">Policy ID:</div>
	    <div class="form_right"><?php echo $household->policy_id; ?></div>
	  </div>
	    
	  <div class="form_row">
	    <div class="form_left">Address:</div>
	    <div class="form_right"><?php echo $household->street_address; ?></div>
	  </div>
	    
	  <div class="form_row">
	    <div class="form_left">Area:</div>
	    <div class="form_right"><?php echo $area; ?></div>
	  </div>
	    
	  <div class="form_row">
	    <div class="form_left">Village:</div>
	    <div class="form_right"><?php echo $village; if(!empty($is_village_outside)) echo " -" .$is_village_outside; ?></div>
	  </div>
	    
	  <div class="form_row">
	    <div class="form_left">Contact Details:</div>
	    <div class="form_right"><?php echo $household->contact_number; ?></div>
	  </div>
	    
	  <!--  <div class="form_row">
	    <div class="form_left">Backend Policy Type:</div>
	    <div class="form_right"><?php echo $policy->backend_policy_type; ?></div>
	  </div>
	    
	  <div class="form_row">
	    <div class="form_left">Backend Policy ID:</div>
	    <div class="form_right"><?php echo $policy->backend_policy_number; ?></div>
	  </div>

	  <div class="form_row">
	    <div class="form_left">Backend Member ID:</div>
	    <div class="form_right"><?php echo $policy->backend_member_id; ?></div>
	  </div>

	  <div class="form_row">
	    <div class="form_left">End date:</div>
	    <div class="form_right"><?php echo $policy->policy_end_date; ?></div>
	  </div> -->
	  
	  <div class="form_row">
		  <?php /**/;
		  foreach ($policy_url_prefixes as $d=>$url) {
		  ?>
		  <a href='<?php echo $this->config->item("base_url").'index.php'.$url.$household->policy_id; ?>'><?php echo $d; ?></a>
		  <?php } ?>
	  </div>
	  
	  <!-- TODO - remove the hardcoded values below -->
	  <table class="grid" width="100%">
	    <table class="grid" width="100%">
	      <tr class="head">
		<td width="20%">Name</td>
		<td width="10%">DOB</td>
		<td width="10%">Age</td>
		<td width="5%">Gender</td>
		<td width="20%">Image</td>
		<td width="35%">Actions</td>
	      </tr>
	      
	      <?php /**/;
//	      foreach ($family->related('persons')->get() as $p) {
	      foreach ($persons as $p) {
	      ?>
	      <tr class="gridrow">
		<!-- TODO - Add photos here -->
		<td class="gridcell"><?php echo $p->full_name; ?></td>
		<td class="gridcell"><?php echo Date_util::to_display($p->date_of_birth); ?></td>
		<td class="gridcell"><?php 					
									$diff = abs(strtotime(date("Y-m-d")) - strtotime($p->date_of_birth));
									$years = floor($diff / (365*60*60*24));
									$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
									echo $years."yr(s)<br />".$months."month(s)";										    
							?></td>
		<td class="gridcell"><?php echo $p->gender; ?></td>
<?php                        $base_len = strlen($this->config->item('base_path'));
                        $image_link = $this->config->item('base_url').substr($p->image_name,$base_len); ?> 
		<td class="gridcell"> <a href="<?php echo $image_link; ?>"><img src="<?php echo $image_link; ?>" alt="" width="40" height="40" border="0" /></a> </td>
<!--		<td class="gridcell"> <a href='<?php 
			$base_len = strlen($this->config->item('base_path'));
                        echo $this->config->item('base_url').substr($p->image_name,$base_len); ?> '> <?php echo $p->image_name; ?> </a> </td> -->
		<td class="gridcell">
		  <?php /**/;
		  foreach ($member_url_prefixes as $d=>$url) {
		  ?>
		  <a href='<?php echo $this->config->item("base_url").'index.php'.$url.$p->id.'/'.$household->policy_id; ?>'><?php echo $d; ?></a> |
		  <?php } ?>
		</td>
	      </tr>
	      <?php } ?>
	    </table>
	</div>

	<div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
      </div>
    </body>
</html>
