<?php 
$this->load->helper('form');
$this->load->library('date_util');
      $this->load->view('common/header');
      ?>
      
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/admin/quick_registration.js"; ?>"></script>
<title>Quick Registration Form </title>

</head>
  
  <body>
    <?php 
    $this->load->view('common/header_logo_block');
    $this->load->view('common/header_search');
    ?>

    
    <div id="main">
      <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Quick Register a Person</span></div></div></div>
    
      <div class="blue_body">
	<form action="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/register_person'.$redirect_url; ?>" method="POST">
	  
	  <?php echo validation_errors(); ?>
	  <input type="hidden" name="policy_type" value="0"/>
	  
<!--	  Form number <input type="text" name="form_number"/>  <hr> -->
	  
	  <b>Person details</b><br>
	  
	  Name<input type="text" name="member0_name" size= 35 value="" /><br/>
	  Contact Details<input type="text" name="contact_number" size= 35 value="" />

	  Gender
	  <input type="radio" name="member0_gender" value="M">M</input>
	  <input type="radio" name="member0_gender" value="F">F</input>
	  Date of Birth</td>
	  <input id="member0_dob" type="text" size="10" value="DD/MM/YYYY" name="member0_dob"/> <?php echo form_error('date'); ?>
	  Blood Group<?php echo form_dropdown('member0_bg', $bgs, 'X', 'class="bigselect"'); ?>
	  <br />
	  Street Address<input id="street_address" type="text" size="20" value="" name="street_address"/> 
	  Village <?php echo form_dropdown("add_village", $villages, '', 'class="bigselect"'); ?>
	  Taluka <?php echo form_dropdown("add_taluka", $talukas, '', 'class="bigselect"'); ?>
	  District <?php echo form_dropdown("add_district", $districts, '', 'class="bigselect"'); ?><br/>

<!--
	  Is the member household head?
	  <input type="radio" name="household_head" value="Yes" 
	    onClick='is_head();'>Yes</input>
	  <input type="radio" name="household_head" value="No"
	    onClick='is_not_head();'>No</input>

	  <input type="hidden" name="head_of_family" id="head_of_family"><br/>
	  
	<span id="household_head_details" style="display: none;">
	  Relation to household head
	  <?php echo form_dropdown('member0_relation', $relations, ''); ?><br/>
	  <hr/>
	  
	  <br/>

	  <b>Household head details</b><br/>
	  <hr>
	  
	  Name <td colspan="2"><input type="text" name="member1_name" size= 35 value="" /><br/>
	    
	    Gender
	    <input type="radio" name="member1_gender" value="M">M</input>
	    <input type="radio" name="member1_gender" value="F">F</input>
	    Date of Birth
	    <input id="member1_dob" type="text" size="10" value="DD/MM/YYYY" name="member1_dob"/> <?php echo form_error('date'); ?>
      </span>
-->
      <div class="form_row">
	<div class="form_newbtn"><input type="submit" name="submit" id="button" value="Submit" class="submit"/></div>
      </div>
      </div>
      
      <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div></div>
    <!--Body Ends-->
    
    <?php $this->load->view('common/footer.php'); ?>
