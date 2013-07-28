<?php 
/**
 * @todo : move all javascript to js file and include that file in header page
 */
$this->load->helper('form');
$this->load->view('common/header'); ?>

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>Backend Claim Form Download</title>

</head>
<body>
<?php $this->load->view('common/header_logo_block'); 
	$this->load->view('common/header_search');
?>

<!-- Body Start -->
<div id="main">
  <!--Preauth Box End-->
  <div class="hospit_box">
    	<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Backend claim entry</span></div></div></div>
          <div class="green_body">
          		<div id="left_col">
      
  	  </div>                

       <div id="right_col">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Backend claim form download</span></div></div></div>
          <div class="blue_body">

  <div class="form_row">
    <div class="form_leftB">Backend File Created for </div>
   <div class="form_right"> <a href="<?php echo $this->config->item('base_url').'/uploads/backend_claim_forms/'.$filename;?>">  Click here to download. </a> </div>
  </div>

  <div class="form_row">
<div class="form_leftB"> <a href="<?php echo $this->config->item('base_url').'index.php/hospitalization/policy_details/show_policy_details/'.$policy_id; ?>"> <?php echo $policy_id; ?></div>
  </div>

    </div>
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div>
          </form>
          <br class="spacer" /></div>
          <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div>
<br class="spacer" /></div>
<!-- Body End -->

<?php $this->load->view('common/footer'); ?>
