<?php $this->load->view('common/header'); ?>
<title>Admit patient form</title>
</head>

<body>
<?php $this->load->view('common/header_logo_block');
$this->load->view('common/header_search');

$policy_id = $this->uri->segment(4);
$pre_auth_id = $this->uri->segment(5);
?>
<!-- Body Start -->
<div id="main">
  <!--Preauth Box End-->
  <div class="hospit_box">
    	<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">preauth entry response</span></div></div></div>

          <div class="green_body">
          		<div id="left_col">
                    <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Policy details</span></div></div></div>
        <div class="yelo_body" style="padding:8px;">
        
<?php 
$this->load->view('hospitalization/policy_context', $short_context); ?>
    	  
        <br class="spacer" /></div>
      <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
          		</div>
          		<div id="right_col">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"></div></div></div>
          <div class="blue_body">
            <div class="form_row">
              <div class="form_leftB" style="width:350px;">This Preauthorization has been approved.</div>
              <div class="form_right"><span class="search_col">
              <a  href="<?php echo $this->config->item('base_url').'index.php/hospitalization/hospitalization/add/'.$policy_id.'/'.$pre_auth_id;?>" style="text-decoration:none;" >
              <input name="submit" type="button" value="Admit Patient" class="submit" />
              </a>
              </span></div>
         	</div>
          </div>
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div>
          
          <br class="spacer" /></div>
          <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div>

<br class="spacer" /></div>


<?php $this->load->view('common/footer'); ?>
