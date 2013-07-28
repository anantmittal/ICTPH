<?php
include_once(APPPATH.'libraries/plsp/assessment/assessment_helper.php');
$this->load->helper('form');
$this->load->view('common/header');
?>

<div id="page-loader" style="display: none;">
	<h3>Please wait...</h3>
	<?php echo '<img src="'.base_url().'/assets/images/common_images/loader.gif" alt="loader">';?>
	<p><small id="page-load-content">...Please wait, checking barcode details.</small></p>
</div>

<script src="<?php echo base_url();?>assets/js/opd/visit/visit_validator.js"></script>
<?php
	if(isset($person))
	{
		$assess = new AssessmentHelper(null,null,null);
		$age = $assess->returnAgeInYears(array('date'=>date('d-m-Y'),'dob'=>date('d-m-Y',strtotime($person->date_of_birth))));
		echo '<script> var ageofindividual='.$age.'</script>';	
	}
?>
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/site.css";?>" rel="stylesheet" type="text/css"/> 
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery-ui-1.7.2.custom.css";?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/edit_visit_req.js"; ?>"></script>
    
<script>
$(document).ready(function(){
	$('#visit_type').change(function() { 
		var v_type = $('#visit_type').val();
//		alert (' v_type = ' + v_type);
		if(v_type == "Diagnostic")
		{
//			alert (' In diag equal ' + v_type);
    			$("#tabs").tabs("disable", 1);
    			$("#tabs").tabs("disable", 2);
    			$("#tabs").tabs("disable", 4);
    			$("#tabs").tabs("disable", 5);
    			return ;
		}
		else
		{
//			alert (' In diag not equal ' + v_type);
    			$("#tabs").tabs("enable", 1);
    			$("#tabs").tabs("enable", 2);
    			$("#tabs").tabs("enable", 4);
    			$("#tabs").tabs("enable", 5);
    			return ;
		}
	});
});

function checkbox_onclick(divId){
	if($(divId+"_id").is(':checked')){
		$(divId).show(500);
	}else{
		$(divId).hide(500);
	}
}
</script>

    <title>Add Visit</title> 
    
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

  <div id="tabs">
    <ul>
      <li><a href="#visit">Visit</a></li>
      <? if($visit_type !='Diagnostic') { ?>
      		<? if(!$hew_login) { ?>
	      		<li><a href="#subjective">Subjective</a></li>
	      	<?php } ?>
	      <li><a href="#physicalexam">Physical Exam</a></li>
	  <?php } ?>
	  <? if(!$hew_login) { ?>
      	<li><a href="#lab">Lab</a></li>
     <?php } ?>
     
      <?php if ($visit_type == "obstetric") { ?>
      	<li><a href="#obstetric">Obstetric</a></li>
      <?php } ?>
      
      <?php if ($visit_type == "pediatric") { ?>
      	<li><a href="#pediatric">Pediatric</a></li> 
      <?php } ?>
	      	      
      <? if($visit_type !='Diagnostic') { ?>
      	<? if(!$hew_login) { ?>
	      <li><a href="#assessment">Assessment</a></li>
	      <li><a href="#plan">Plan</a></li>
	      <?php } ?>
	  <?php } ?>
	  <? if(!$hew_login) { ?>
      	<li><a href="#billing">Billing</a></li>
      <?php } ?>	 
    </ul> 

    <form method="POST" onsubmit="return checkvisitform(this,<?php if(!$hew_login) echo 0; else echo $hew_login;?>);">
      <input type="hidden" id="person_id" name="person_id" value="<?php echo $person->id ?>"/>
		<input type="hidden" name= "begin_time" value = "<?php echo $begin_time ;?>" />
    <div id="visit">
      <!-- Date, Provider, Location, Person -->
      <div class="form_row">
	<div class="form_left">Date:</div>
	<div class="form_right">
	  <input id="datepicker" type="text" size="10" name="datepicker" value="<?php echo date('d/m/Y');?>"/> <?php echo form_error('date'); ?>
	  <input id="date" name="date" type="hidden" value="<?php echo date('Y-m-d');?>"/>
	</div>
      </div>
	      
      <div class="form_row">
	<div class="form_left">Visit Type:</div>
	<div class="form_right">
		  <?php echo $visit_type;  ?>
		  <input id="visit_type" name="visit_type" type="hidden" value="<?php  echo $visit_type;?>"/>
		  <input  name="visit_preconsultation_id" type="hidden" value="<?php  if(isset($preconsulted_visit_id))echo $preconsulted_visit_id;?>"/>
<!--		<?php if( $visit_type == 'Followup')
	      {
		echo 'Followup'; ?>
		  <input id="visit_type" name="visit_type" type="hidden" value="Followup"/>
		<?php }
		else
		{ ?>
  		<select id="visit_type" name="visit_type" class="">
    		<option value="General" selected="selected">General</option>
    		<option value="Diagnostic">Diagnostic</option>
		</select>
		<?php } ?>
-->
	</div>
    </div>

      <div class="form_row">
	<div class="form_left">Provider:</div>
	<div class="form_right">
		  <?php echo $provider->full_name; ?>
		  <input type="hidden" name="provider_id" value="<?php echo $provider->id ?>"/>
	</div>
      </div>
	      
      <div class="form_row">
	<div class="form_left">Location:</div>
	<div class="form_right">
		  <input type="hidden" name="provider_location_id" value="<?php echo $this->session->userdata('location_id');?>" id="provider_location_id">
		  <?php 
			$locations = $this->session->userdata('locations');
			echo '<b>'.$locations[$this->session->userdata('location_id')].'</b>';
		   ?>
<!--		  <select name="provider_location_id" id="provider_location_id">
		    <?php foreach ($provider_locations as $l) { ?>
		    <option value="<?php echo $l->id; ?>"> <?php echo $l->name; ?> </option>
		    <?php } ?>
		  </select>-->
	</div>
      </div>

	
		  
	
      <?php if ($followup_to_visit_id) { ?>
      <div class="form_row">
	<div class="form_left">Followup to:</div>
	<div class="form_right">
		  <a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/show/'.$followup_to_visit_id; ?>"><?php echo $followup_to_visit_id; ?></a> <input type="hidden" name="followup_to_visit_id" value="<?php echo $followup_to_visit_id; ?>">
		  
	</div>
      </div>
      <?php } ?>
	      
            
      All tabs filled?
      <input type="submit" name="submit" align="right" value="Submit" class="submit"/>
	<?php if(isset($risk))	
	{
			echo '<br/><br/><table border="1px"><tr><th colspan="2"> Information: Known risk factors</th></tr>';
			foreach($risk as $risk_type=>$info)
				echo '<tr><td class="'.$risk_type.'"><b>'.$info[0].':</b></td><td>'.$info[1].'</td></tr>';
			echo '</table>';
		
	}?>
   </div>
<!-- id=visit completed -->

<?php 
function remove_whitespace1($name) {
	$temp_str = preg_replace('#[ ,\/()+]#s', '_', ltrim(rtrim($name)));
	return str_replace("'", "_",$temp_str);
}
?>

<? if($visit_type !='Diagnostic'){ ?>
	
    <div id="subjective">
		<?php if(!$hew_login) { $this->load->view('opd/visit/subjective_tab', $pisp);} ?>
    </div>
    
    <div id="physicalexam">
      <?php $this->load->view('opd/visit/physicalexam_tab', $pisp); ?>
    </div>
<?php } ?>
	
    <div id="lab">
      <?php if(!$hew_login) { $this->load->view('opd/visit/lab_tab'); } ?>
    </div>

 <? if($visit_type !='Diagnostic')    { ?>
    <div id="assessment">
      <?php if(!$hew_login) { $this->load->view('opd/visit/assessment_tab'); } ?>
    </div>
	  
    <div id="plan">
      <?php if(!$hew_login) { $this->load->view('opd/visit/plan_tab'); } ?>
    </div>
	<?php } ?>

    <div id="billing">
      <?php if(!$hew_login) { $this->load->view('opd/visit/billing_tab');} ?>
    </div>
    
    <?php $this->load->view('opd/visit/below_tabs'); ?>
	  </div>
	</div>
      </form>

      </div>
      <br class="spacer" />
      <br />
    </div>
      
      <?php $this->load->view('common/footer'); ?>
    </div>
