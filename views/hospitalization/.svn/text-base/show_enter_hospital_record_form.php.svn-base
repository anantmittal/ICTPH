<?php 
/**
 * @todo : factored out js.
 * 
 */
$this->load->view('common/header'); ?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/ajaxfileupload.js"?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/add_hospital_report.js"; ?>"></script>
<!--<script type="text/javascript" src="<?php //echo "{$this->config->item('base_url')}assets/js/claim.js"; ?>"></script>-->

<title>Hospital record entry</title>
</head>

<body>
<iframe id="post_response" src="" name="post_response" style="display:none;"></iframe>
<?php $this->load->view('common/header_logo_block'); 
$this->load->view('common/header_search'); ?>

<!--Head end-->

<!-- Body Start -->
<div id="main" style="width:980px;">
  
    
<div class="hospit_box">
    	<!--<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Hospital record entry</span></div> 
    	</div>
  </div>-->
          <!--<div class="green_body">-->
          		<div id="left_col">
                
                    <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Policy details</span></div></div></div>
<div class="yelo_body" style="padding:8px;">

<?php $short_context['short_context'] = &$short_context;
 	 $this->load->view('hospitalization/hospitalization_context', $short_context); ?>

      <br class="spacer" /></div>
      <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>        
        <br />
                </div>
          		<div id="right_col">
    <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box"> Hospital Record</span>
    	  </div></div></div>
          <div class="blue_body" style="padding: 10px;">
             <div class="form_row">
              <div class="form_leftB">Record Date</div>
              <div class="form_right">
              <input name="report_date" id="report_date_head" type="text" class="datepicker required " value="" />&nbsp;
              (Date Format : DD/MM/YYYY)
            </div>
            </div>
            <div class="form_row">
              <div class="form_leftB">Report Type</div>
              <div class="form_right">
                <select name="report_type" id="report_type">
                  <option value="note">Note</option>
                  <option value="diagnostic report">Diagnostic report</option>
                  <option value="vital signs">Vital signs</option>
                  <option value="medication administration">Medication administration</option>
                  <option value="other">Other</option>
                </select>
              </div>
            </div>
            
            <div class="form_data" id="form_data" style="display: none">
            <fieldset>
		      <legend>Report Details - Specific to Event Type/ Sub-Type</legend>
		      		<div class="form_row" style="margin-top:10px;">
		
		            	<div class="form_left">Report Sub-type</div>
		                <div class="form_right">
		                  <select name="select2" id="select2">
		                    <option>ComboBox</option>
		                 </select>
		                </div>
		            </div>
		      </fieldset>
             <div class="form_row">
              <div class="form_leftB">&nbsp;</div>
              <div class="form_right"> <input type="image" src="<?php echo $this->config->item('base_url');?>assets/images/common_images/btn_submit.gif" alt="" width="86" height="23" border="0" class="btn_submit" /></div>
            </div> <!--end of <div class="form_row">-->
         </div> <!--end of <div class="form_data">-->



 <!-- Diagnostic Report Panel-->
 <div class="diagnostic_report to_hide" id="diagnostic_report" style="display: none">
 <form method="POST" enctype="multipart/form-data" action="<?php echo "{$this->config->item('base_url')}index.php/hospitalization/hospitalization/save_hospital_record/".$short_context['hospitalization_id']; ?>" target="post_response" onsubmit="javascript:flag=true;">  
 <input type="hidden" name="report_date" class="report_date"  value="">
<input type="hidden" name="report_type" value="diagnostic report">
             <div class="form_row">
               <div class="form_leftB">Diagnostic Type</div>
               <div class="form_right">
                 <select name="diagnostic_type" id="diagnostic_type">
                 <option value="Lab Test">Lab Test</option>
                   <option value="Blood Pathology Report" >Blood Pathology Report</option>
                   <option value="Urine Pathology Report">Urine Pathology Report</option>
                   <option value="X-ray Report">X-ray Report</option>
                   <option value="Ultrasound Report">Ultrasound Report</option>
                   <option value="CT Scan Report">CT Scan Report</option>
                   <option value="MRI Report">MRI Report</option>
                   <option value="EKG">EKG</option>
                   <option value="Endoscopy Report">Endoscopy Report</option>
                   <option value="Surgical Pathology Report">Surgical Pathology Report</option>
                   <option value="Microbiology Report">Microbiology Report</option>                   
                 </select>
               </div>
             </div>             
      
      <div class="form_data" id="Lab_Test">
      <fieldset>
      <legend>Details</legend>
      		<div class="form_row" style="margin-top:10px;height:50px">
            	<div class="form_left">Text</div>
                <div class="form_right">
                  <textarea name="lab_test_text" id="lab_test_text" cols="35" class="combo"></textarea>
                </div>
            </div>
            <div class="form_row">
            	<div class="form_left">Lab Name</div>
                <div class="form_right">
                  <input name="lab_name" id="lab_name" type="text" value="" />
                </div>
            </div>
             <div class="form_row">
            	<div class="form_left">Upload File</div>
                <div class="form_right">                               
			    <table id="diagnostic_report_table" border="0">
	              	<tr><td><input type="file" name="diagnostic_report_file0"></td> 
	              	<td><a href="#" id="diagnostic_report_add_file">Add file</a></td> </tr>
	            </table>              
               </div>
            </div>
              
            <div class="form_row" style="clear:both;">
            	<div class="form_left">Comment</div>
                <div class="form_right">
                  <textarea name="comment" cols="25" rows="3"></textarea>
                </div>
            </div>
                      
     </fieldset>           
      </div>      
   <div class="form_data" id="Diagnostic_Type_other" style="display: none"  >      
      <fieldset>
      <legend>Details</legend>
    <div class="form_row" style="margin-top:10px;">
            	<div class="form_left">Test</div>
                <div class="form_right">
                  <input name="diagnostic_type_text" id="diagnostic_type_text" type="text" value="" />
                </div>
            </div>

            <div class="form_row">
            	<div class="form_left">Value</div>
                <div class="form_right">
                  <input name="value" id="value" type="text" value="" class="required" />
                </div>
            </div>
            
            <div class="form_row">
            	<div class="form_left">Conducted by</div>

                <div class="form_right">
                  <input name="by" id="conducted_by" type="text" value="" class="required" />
                </div>
            </div>            
            <div class="form_row" style="clear:both;">
              <div class="form_left">Comment</div>
              <div class="form_right">
              <textarea name="comment" cols="25" rows="3"></textarea>
              </div>
            </div>
            
            
      </fieldset>
      </div>
      <input type="submit" name="submit" class="submit" value="Submit" />
      </form>
      </div>
 <!--End Diagnostic Report Panel-->      
      
 
 
 
      
 
   <!--Vital signs box-->
      <div class="vital_signs to_hide" id="vital_signs" style="display: none">
 <form method="POST" enctype="multipart/form-data" action="<?php echo "{$this->config->item('base_url')}index.php/hospitalization/hospitalization/save_hospital_record/".$short_context['hospitalization_id']; ?>" target="post_response" onsubmit="javascript:flag=true;">
 <input type="hidden" name="report_date" class="report_date"  value="">
<input type="hidden" name="report_type" value="vital signs">
        <div class="form_data">
          
          <fieldset>
            <legend>Details</legend>
            <div class="form_row" style="margin-top:10px;">

              <div class="form_left">Pulse (/min)</div>
              <div class="form_right">
                <input name="min_pulse" id="min_pulse" type="text" value="" size="10" />
              </div>
            </div>
            <div class="form_row">
              <div class="form_left">BP</div>
              <div class="form_right">

                Systolic <input name="systolic" id="systolic" type="text" value="" size="10" /> Diastolic
                <input name="diastolic" id="diastolic" type="text" value="" size="10" />
              </div>
            </div>
            
            <div class="form_row">
              <div class="form_left">Respiratory rate (/min)</div>
              <div class="form_right">
                <input name="respiratory_rate" id="respiratory_rate" type="text" value="" size="10" />

              </div>
            </div>
            
            <div class="form_row">
              <div class="form_left">Temperature (F)</div>
              <div class="form_right">
                <input name="temperature" id="temperature" type="text" value="" size="10" />
              </div>
            </div>

            
            <div class="form_row">
              <div class="form_left">Pulse ox (%)</div>
              <div class="form_right">
                <input name="ox_pulse" id="ox_pulse" type="text" value="" size="10" />
              </div>
            </div>
            <div class="form_row">
              <div class="form_left">Capillary refill</div>
              <div class="form_right">
                <input name="capillary_refill"  type="radio" value="normal" checked="checked" />&nbsp;Normal
               <input name="capillary_refill"  type="radio" value="delayed" />&nbsp;Delayed
              </div>
            </div>
            <div class="form_row">
              <div class="form_left">Recorded by</div>
              <div class="form_right">
                <input name="by" id="by" type="text" value="" />
              </div>
            </div>
            
            <div class="form_row">
              <div class="form_left">Comment</div>
              <div class="form_right">
                <textarea name="comment" cols="25" rows="3"></textarea>
              </div>
            </div>
     </fieldset>
   </div>
            <input type="submit" name="submit" class="submit" id="submit_btn" value="Submit" />
</form>
</div>
 <!-- end Vital signs box-->

 
 

<!--Note panel start-->
<div class="note_panel to_hide" id="note" style="display: block">          
<form method="POST" enctype="multipart/form-data" action="<?php echo "{$this->config->item('base_url')}index.php/hospitalization/hospitalization/save_hospital_record/".$short_context['hospitalization_id']; ?>" target="post_response" onsubmit="javascript:flag=true;">
<input type="hidden" name="report_date" class="report_date"  value="">
<input type="hidden" name="report_type" value="note">
             <div class="form_row">
               <div class="form_leftB">Note  Type</div>
               <div class="form_right">
                 <select name="note_type" id="note_type">
                   <option value="Admission Note">Admission Note</option>
                   <option value="Nursing Progress Note">Nursing Progress Note</option>
                   <option value="Doctor Progress Note">Doctor Progress Note</option>
                   <option value="Surgery Note">Surgery Note</option>
                   <option value="Discharge Note">Discharge Note</option>
                   <option value="Death Note">Death Note</option>
                 </select>
               </div>
             </div>
      <div class="form_data">
      <fieldset>
      <legend>Details</legend>
	    <div class="form_row" style="margin-top:10px;height:50px;">
            	<div class="form_left">Note</div>
                <div class="form_right">
                  <textarea name="note" id="test" cols="35" class="combo"></textarea>
                </div>
            </div>

	    <div class="form_row">
       	    <div class="form_left">Written  by</div>
                <div class="form_right">
                  <input name="by" id="by" type="text" value="" />
                </div>
                
            </div>
            <div class="form_row">
              <div class="form_left">Upload File</div>
              <div class="form_right" >
              <table id="note_files_table">
              	<tr><td><input type="file" name="note_report_file0" id="note_report_file"/></td> <td><a href="#" id="note_add_file">Add file</a> </td> </tr>
              </table>
              </div>
            </div>

             <!--<div class="form_row" style="clear:both;">
              <div class="form_left">Comment</div>
              <div class="form_right" >             
              <textarea name="comment" rows="3" cols="25" ></textarea>             
              </div>
            </div>-->
      </fieldset>      
      </div>

      <input type="submit" name="submit" class="submit" value="Submit" />
      </form>
      </div>      
  <!--      Note panel end-->





<!--  Medication Admin Panel    -->    
	<div class="medication_admin to_hide" id="medication_administration"  style="display: none">
<form method="POST" enctype="multipart/form-data" action="<?php echo "{$this->config->item('base_url')}index.php/hospitalization/hospitalization/save_hospital_record/".$short_context['hospitalization_id']; ?>" target="post_response" onsubmit="javascript:flag=true;">      
<input type="hidden" name="report_date" class="report_date" value="">
<input type="hidden" name="report_type" value="medication administration">
      <div class="form_row">
        <div class="form_leftB">Medication  Type</div>

        <div class="form_right">
          <select name="medication_type" id="medication_type">
            <option value="fluid">Fluid</option>
            <option value="perinatal_medication">Perinatal Medication</option>
            <option value="oral_medication">Oral Medication</option>
            <option value="oxygen">Oxygen</option>
          </select>
        </div>
      </div>
      <div class="form_data">
        <fieldset>
        <legend>Details</legend>
          <div class="form_row" style="margin-top:10px;">
            <div class="form_left">Name of medicine</div>
            <div class="form_right"><input name="name_of_medicine" id="name_of_medicine" type="text" value="" /></div>
          </div>
          <div class="form_row">
            <div class="form_left">Dosage&nbsp;</div>

            <div class="form_right"></div>
          </div>
          <div class="form_row">
            <div class="form_left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Amount</div>
            <div class="form_right">
              <input name="amount" id="amount" type="text" value="" size="5" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit
              <select name="unit" id="unit">
                <option value="mg">mg</option>
                <option value="microg">microg</option>
                <option value="ml">mL</option>
                <option value="lpm">Lpm</option>

              </select>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Frequency
              <select name="frequency" id="frequency">
                <option value="od">OD</option>
                <option value="bid">BID</option>
                <option value="tid">TID</option>
                <option value="once">Once</option>
              </select>
            </div>
          </div>
          <div class="form_row">
            <div class="form_left">Route of Administration</div>

            <div class="form_right">
              <select name="route_of_administration" id="route_of_administration">
                <option value="oral">Oral</option>
                <option value="sc">SC</option>
                <option value="pr">PR</option>
                <option value="iv">IV</option>
                <option value="im">IM</option>
                
              </select>
            </div>
          </div>
          
          <div class="form_row">
            <div class="form_left">Duration</div>

            <div class="form_right">
              <input name="duration"  id="duration" type="text" value="" size="5" />
              &nbsp;	
              <select name="duration_format" id="duration_format">
                <option value="hours">hours</option>
                <option value="once">once</option>
                <option value="days">days</option>
              </select>
            </div>
          </div>
          
          
          
          <div class="form_row">
            <div class="form_left">Comment</div>
            <div class="form_right">          
              <textarea name="comment" cols="35" class="combo"></textarea>
            </div>
          </div>
          
     	  
     	  
        </fieldset>
      </div>
      <input type="submit" name="submit" class="submit" id="submit_btn" value="Submit" />
      </form>
    </div>
    <!--  End of Medication Admin Panel    -->        

    
    
    <!--  Other Panel start -->        
    <div class="other to_hide" id="other" style="display: none">      
    <form method="POST" enctype="multipart/form-data" action="<?php echo "{$this->config->item('base_url')}index.php/hospitalization/hospitalization/save_hospital_record/".$short_context['hospitalization_id']; ?>" target="post_response" onsubmit="javascript:flag=true;">      
<input type="hidden" name="report_date" class="report_date" value="">
<input type="hidden" name="report_type" value="other">
     <fieldset>
        <legend>Details</legend>
      <div class="form_row" style="height:50px;">
        <div class="form_leftB">Medication   Type</div>
        <div class="form_right">
          <textarea name="other_medication_type" id="other_medication_type" cols="35" class="combo"></textarea>
        </div>
     </div>
      <div class="form_row">
        <div class="form_leftB">Upload File</div>
        <div class="form_right">
		 <table id="other_file_table">
              	<tr>
              		<td><input type="file"  name="other_file0" id="other_file0"/></td> 
              		<td><a href="#" id="other_add_file">Add file</a></td> 
              	</tr>
         </table>          
        </div>
    <div class="form_row" style="height:50px;">
    <div class="form_leftB">Comment : </div>
      <div class="form_right">
          <textarea name="comment" id="" cols="35" class="combo"></textarea>
        </div>
     </div>
        </fieldset>
        <input type="submit" name="submit" class="submit" id="submit_btn" value="Submit" />
      </div>
      </form>    
<!--<div class="form_data"></div>
    </div>-->
    <!--  End Other Panel    -->        
    
    
<br>

<!--</div>-->

	<!--<div class="form_row">
        <div class="form_leftB">Comments</div>
        <div class="form_right">
          <textarea name="comments" id="comments" cols="40" class="combo"></textarea>
        </div>
      </div>
    <br />
    <br />
 <input type="submit" name="submit" class="button submit" id="submit_btn" value="Submit" />  -->

    <br>
    
          </div>

          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div>
      </div></div>           
   
          </div>
          
          <br class="spacer" /></div>
        <!--  <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div>-->
  
    <!--</form> -->
<br class="spacer" /></div>
<!-- Body End -->
<?php $this->load->view('common/footer'); ?>
