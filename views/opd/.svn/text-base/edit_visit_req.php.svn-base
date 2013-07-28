<?php
include_once(APPPATH.'libraries/plsp/assessment/assessment_helper.php');
$this->load->helper('form');
$this->load->view('common/header');
?>
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/site.css";?>" rel="stylesheet" type="text/css"/> 
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery-ui-1.7.2.custom.css";?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css"/>
	<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
	
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/edit_visit_req.js"; ?>"></script>
    
    <script>
		function checkbox_onclick(divId){
			if($(divId+"_id").is(':checked')){
				$(divId).show();
			}else{
				$(divId).hide();
			}
		}

		function followUpIsInFuture(){	
			var retVal = false;
			var date = new Date();
			var month = date.getMonth() + 1;
			var current_date = date.getDate() + '/' + month + '/' + date.getFullYear();
			$("input:text[name^='followup_protocol_date']").each(function() {
				var value =  $(this).val();
				if(value != "DD/MM/YYYY" && Date.parse(value) < Date.parse(current_date) || value == ""){
					retVal = true;
				}
		    });
			
			return retVal;
		}
		
		function validateEditVisitForm(){
			if(followUpIsInFuture()){
				alert("Follow up date should be in future");
				$("#tabs").tabs('select', 3);
				return false;
			}
		}
		
    </script>
    
    <title>Edit Visit No: <?php echo $visit_obj->id;?></title> 
    
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
	      <li><a href="#subjective">Subjective</a></li>
	      <li><a href="#physicalexam">Physical Exam</a></li>
	      
	      <?php if ($visit_type == "obstetric") { ?>
	      <li><a href="#obstetric">Obstetric</a></li> 
	      <?php } ?>
	      
	      <?php if ($visit_type == "pediatric") { ?>
	      <li><a href="#pediatric">Pediatric</a></li> 
	      <?php } ?>
	      	      
	      <li><a href="#assessment">Assessment</a></li>

	    </ul> 

	    <form method="POST" onsubmit="return validateEditVisitForm()">
	      <input type="hidden" id="person_id" name="person_id" value="<?php echo $person->id ?>"/>

	    <div id="visit">
	      <!-- Visit Id,Date, Provider, Location, Person -->
	      <div class="form_row">
		<div class="form_left">Visit Id:</div>
		<div class="form_right"><?php echo $visit_obj->id;?>
		</div>
	      </div>

	      <div class="form_row">
		<div class="form_left">Date:</div>
		<div class="form_right">
	 		<?php echo Date_util::to_display($visit_obj->date);?>
		</div>
	      </div>
	      
	      <div class="form_row">
		<div class="form_left">Visit Type:</div>
		<div class="form_right">
	<?php if( $visit_type == 'Followup')
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


	    </div>

	
	    <div id="subjective">
	      <?php $this->load->view('opd/visit/subjective_tab'); ?>
	    </div>
	  
	    <div id="physicalexam">
	      <?php $this->load->view('opd/visit/physicalexam_tab'); ?>
	    </div>
	  
	    <?php //if (is_obgyn_eligible($person)) { ?>
	    <?php if ($visit_type == "obstetric") { ?>
	    <div id="obstetric">
	      <?php $this->load->view('opd/visit/obstetric_tab'); ?>
	    </div>
	    <?php } ?>
	  
	    <?php // if (is_ped_eligible($person)) { ?>
	    <?php if ($visit_type == "pediatric") { ?>
	    <div id="pediatric">
	      <?php $this->load->view('opd/visit/pediatric_tab'); ?>
	    </div>
	    <?php } ?>
	    
	    <div id="assessment">
	      <?php $this->load->view('opd/visit/assessment_tab'); ?>
	    </div>
	  
	  </div>
	</div>
      </form>

      </div>
      <br class="spacer" />
      <br />
    </div>
      <?php 
function remove_whitespace1($name) {
	$temp_str = preg_replace('#[ ,\/()+]#s', '_', ltrim(rtrim($name)));
	return str_replace("'", "_",$temp_str);
}
?>
      <?php $this->load->view('common/footer'); ?>
    </div>
