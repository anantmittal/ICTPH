<?php
$this->load->helper('form');
      $this->load->view('common/header');         
 ?>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/tabs.js"; ?>"></script>

<title>Claim Review</title> 

</head>
<?php if($panel == 'status_update'){ $tab = 'tab1';  $show_panel = 'panel1';} else { $tab = 'tab2'; $show_panel = 'panel2'; }?>
<body onload="showPanel(document.getElementById('<?php echo $tab;?>'), '<?php echo $show_panel;?>');">
<!--<body>-->
<?php $this->load->view('common/header_logo_block');
	  $this->load->view('common/header_search');
?>

<?php 
// $short_context=& Base_Model::get_short_context('hospitalization',23); 
// $short_context_policy=& Base_Model::get_short_context('policy',23); 
?>
<!--Head end-->
<!-- Body Start -->
<div id="main">
  <!--Preauth Box End-->
  <div class="hospit_box">
    	<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">claim review and status update</span></div></div></div>
          <div class="green_body">
          		<div id="left_col">
                
                    <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Policy details</span></div></div></div>
<div class="yelo_body" style="padding:8px;">			

<?php $this->load->view('hospitalization/hospitalization_context', $short_context); ?>
      
      <br class="spacer" /></div>
      <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
        <br />
                </div>
          		<div id="right_col">
        		<div class="tabs" id="tabs">
	<ul class="tab">
		<li><a href="#" onmousedown="return event.returnValue = showPanel(this, 'panel1');" onclick="return false;" id="tab1">Status Update</a></li>
        <li><a href="#" onmousedown="return event.returnValue = showPanel(this, 'panel2');" onclick="return false;" id="tab2">Hospitalization Details</a></li>
        <li><a href="#" onmousedown="return event.returnValue = showPanel(this, 'panel3');" onclick="return false;">Claim Details</a></li>
        <li><a href="#" onmousedown="return event.returnValue = showPanel(this, 'panel4');" onclick="return false;">PreAuth Details</a></li>
    </ul>   
    </div>
    
    
    
    
    
    
    
	
	  
 <div class="panel" id="panel1" style="display:<?php if($panel == 'status_update') echo 'block'; else echo 'none'; ?>">
 <form id="claim_status_update" method="POST" action="<?php echo "{$this->config->item('base_url')}index.php/hospitalization/claim/save_status";?>" >

    <div class="form_row" >
              <div class="form_leftB">Current Status </div>
              <div class="form_right"> <?php echo $old_status; ?>  </div>
            </div>

    <div class="form_row" style="height:50px;">
              <div class="form_leftB">Comments of previous reviewer</div>
              <div class="form_right"> <?php echo $old_comment; ?>  </div>
            </div>

    <div class="form_row" >
              <div class="form_leftB">Previous Reviewer </div>
              <div class="form_right"> <?php echo $old_reviewer; ?>  </div>
            </div>


           <div class="form_row">
              <div class="form_leftB">Claim processing status</div>
              <div class="form_right">
              
              
                <select name="claim_processing_status" id="claim_processing_status">
                  <option value="To be reviewed">To be reviewed</option>
                  <option value="Settled">Settled</option>
                  <option value="Pending hospital">Pending Hospital</option>
                  <option value="Pending patient">Pending patient </option>
                  </select>
                  
                  
              </div>
            </div>            
            <input type="hidden" name="claim_id" value="<?php echo $short_context['claim_id']; ?>">            
            
<!--      <div class="form_data" id="setteled_claim" style="display:none;">
      <fieldset>
      <legend>If settled, due payments</legend>
      		<div class="form_row" style="margin-top:10px;">
            	<div class="form_left">To Hospital (Rs)</div>
                <div class="form_right">
                  <input name="to_hospital" type="text" value="" size="15" />
                </div>
            </div>
            <div class="form_row">
            	<div class="form_left">To Patient (Rs)</div>
                <div class="form_right">
                  <input name="to_patient" type="text" value="" size="15" />
                </div>
            </div>    
                    
            <div class="form_row">
            	<div class="form_left">Claim Status:</div>
                <div class="form_right">
                  <select name="claim_status">
                  <option value="Approve">Approved</option>
                  <option value="Reject">Reject</option>
                   </select>
                </div>
            </div>    
            
      </fieldset>      
      </div>
-->
   
<!--        
<div class="form_row">
              <div class="form_leftB">Backend Claim processing status</div>
              <div class="form_right">
                <select name="backend_claim_status" id="backend_claim_status">
				  <option value="To be sent">To be sent</option>
                  <option value="Pending insurer"> Pending insurer</option>
                  <option value="Pending hospital">Pending hospital </option>
                  <option value="Settled">Settled</option>
                  <option value="Pending patient"> Pending patient</option>                 
                </select>
        </div>
        </div>
            
      <div class="form_data" id="setteled_backend_claim" style="display:none;">
      
      <fieldset>
      <legend>If settled, due payments</legend>
<div class="form_row" style="margin-top:10px;">
            	<div class="form_left">To Insurer (Rs)</div>

                <div class="form_right">
                  <input name="to_insurer" type="text" value="" size="15" />
                </div>
            </div>
      </fieldset>      
      </div>            
-->
    <div class="form_row" style="height:50px;">
              <div class="form_leftB">Comments</div>
              <div class="form_right">
                <textarea name="comment" cols="35" class="combo"></textarea>
             </div>
            </div>
            <div class="form_row">
        <div class="form_leftB">Claim Reviewed by</div>
              <div class="form_right">
                <input name="claim_reviewed_by" type="text" value="" size="15" class="required" />
              </div>
          </div>
           
      
        <div class="form_row">
          <div class="form_leftB">&nbsp;</div>
          <input type="image" src="<?php echo base_url(); ?>assets/images/common_images/btn_submit.gif" alt="" width="86" height="23" border="0" class="btn_submit" /></a>

        </div>
        <br class="spacer" />
      </form>  
      </div><!--end of panel1-->

      
    
    
      
      
        
      
      

 <div class="panel" id="panel2" style="display:<?php if($panel != 'status_update') echo 'block'; else echo 'none';?>">
 <div class="form_row">
             <div class="form_leftB">Date of Admission</div>
             <div class="form_right"><?php echo $hospitalization_obj->hospitalization_date; ?></div>
           </div>
                      <div class="form_row">
             <div class="form_leftB">Date of Discharge</div>

             <div class="form_right"> <?php echo $hospitalization_obj->discharge_date; ?>  </div>
           </div>
                      <div class="form_row">
             <div class="form_leftB">Chief Complaints</div>
             <div class="form_right"><?php echo $hospitalization_obj->chief_complaint; ?></div>
           </div>
                      <div class="form_row">
             <div class="form_leftB">Detail Complaints</div>
             <div class="form_right"><?php echo $hospitalization_obj->detail_complaint; ?></div>
           </div>
                      <div class="form_row">

             <div class="form_leftB">Current Diagnosis</div>
             <div class="form_right"><?php echo $hospitalization_obj->current_diagnosis;// $hospitalization_obj->hospitalization_date; ?></div>
           </div>
           <div class="form_row">
             <div class="form_leftB">Procedure (S)</div>
             <div class="form_right"><?php echo $hospitalization_obj->procedure;// $hospitalization_obj->hospitalization_date; ?></div>
           </div>

           <div class="form_row" style="height:100%; overflow:hidden;">
             <div class="form_leftB">Comments</div>
             <div class="form_right" STYLE="width:435px;" ><?php echo $hospitalization_obj->comments; ?></div>
           </div>
           
           <div class="form_row">
             <div class="form_leftB">Primary Consultant</div>
             <div class="form_right"><?php echo $hospitalization_obj->primary_physician; ?></div>

           </div><br /> 
 <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Hospital Reports</span></div></div></div>
          <div class="blue_body" style="padding: 10px;">
          <?php 
           $this->record_attachment = IgnitedRecord::factory('hospital_record_attachments');		                                             
          /* echo "<pre>";
           print_r($this->record_attachment_rec);
           echo "</pre>";           */
           ?>
            <table border="0" cellpadding="2" cellspacing="2" width="100%">
              <tbody>
              <tr class="head">
                <td width="11%">Date</td>
                <td width="10%">Type</td>
                <td width="20%">Subtype </td>
                <td width="30%">Details</td>                
                <td width="20%">Comment</td>
                <td width="">By</td>
                <td width="10%">Files</td>
              </tr>              
         <?php         
         foreach ($hospital_recs_obj as $hospital_rec) {
         	if($hospital_rec->by == '')
         	$hospital_rec->by = '--';
         	$tr = "<tr class='grey_bg'><td>{$hospital_rec->reporting_on}</td>";
         	$tr .= "<td>". ucfirst($hospital_rec->record_type)."</td>";
         	$tr .= "<td>{$hospital_rec->sub_type}</td>";
         	$tr .= "<td>";
         	echo $tr;         	
         	$rec_arr = unserialize($hospital_rec->serialize_records);
         	foreach ($rec_arr as $key=>$value) {
         		if(!is_array($value))
         			echo '<b>'.str_ireplace('_', ' ',ucfirst($key)).'</b> : '.$value.'<br>';
         		else {
         			echo '<b>'.ucfirst($key).'</b> : <br>';
         			foreach ($value as $val_key=>$val_val){
         				echo '<b style="padding-left:15px;">'.ucfirst($val_key).'</b> : '.$val_val.'<br>';
         			}
         		}
         	}

         	$tr = "</td>";         	
         	$tr .= "<td >{$hospital_rec->comment}</td>";
         	$tr .= "<td>".$hospital_rec->by."</td>";
         	$tr .= "<td >";
         	echo $tr;
         	$this->record_attachment_recs = $this->record_attachment->find_all_by('hospital_record_id',$hospital_rec->id);         	
         	/**
         	 * @todo : make below file name as a link and can open the file in other window
         	 */
         	foreach ($this->record_attachment_recs as $ra_recs){
         		 echo $ra_recs->file_name. "<br>";
         	}         	
         	$tr = "</td></tr>";
         	echo $tr;
         }
    	?>
      </tbody>
      </table>
      </div>
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div><!--end of panel2-->

    
    
    
       
    
    <div class="panel" id="panel3" style="display: none">
  
    <table border="0" cellpadding="2" cellspacing="2" width="100%">
            <tbody><tr class="head">
              <td width="12%">Type </td>
              <td width="15%">Subtype</td>
              <td width="18%">Name</td>
              <td width="8%">Qty</td>
              <td width="8%">Rate (Rs.)</td>

              <td width="10%">Total (Rs.)</td>
              <td width="10%">Claimed (Rs.)</td>
              <td width="">Comment</td>
            </tr>
       <?php foreach ($claim_cost_items_obj as $claim_cost_item) {
       	
//       	$rec = $hosp_cost_item_obj->find($claim_cost_item->hospitalization_cost_item_id);
         
      // 	$rec = $hosp_cost_item_obj->find(23);
       	
       	?>     
            <tr class="grey_bg">
              <td> <?php echo $claim_cost_item->item_type; ?> </td>
              <td><?php echo $claim_cost_item->item_subtype; ?></td>
              <td><?php echo $claim_cost_item->item_name; ?></td>
              <td> <?php echo $claim_cost_item->number_of_times; ?>  </td>

              <td> <?php echo $claim_cost_item->rate; ?> </td>
              <td><?php echo ($claim_cost_item->amount); ?></td>
              <td><?php echo $claim_cost_item->claimed_amount; ?> </td>
              <td> <?php echo $claim_cost_item->comment; ?>  </td>
            </tr>
        <?php } ?>    
          </tbody></table>
          <!--<br>
          <div class="form_row">
            <input name="button" id="button" value="Hospital Rate List" class="submit" type="submit">
          </div>   -->
    </div>  <!--end of panel3-->
    
    
    
    <div class="panel" id="panel4" style="display: none">    
  <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">PreAuth details</span></div></div></div>
          <div class="blue_body" style="padding: 10px;">
<?php /*echo "<pre>";
print_r($preauth_rec_obj);
echo "</pre>";*/ ?>
            <table border="0" cellpadding="2" cellspacing="2" width="100%">
              <tbody><tr class="head">
                <td width="11%">Date </td>
                <td width="22%">Complaints</td>
                <td width="19%">Diagnosis</td>
                <td width="18%">Procedure (S)</td>
                <td width="14%">Exp stay</td>

                <td width="16%">Amount(Rs.)</td>
              </tr>
             <?php foreach ($preauth_rec_obj as $preauth_rec){ ?>
              <tr class="grey_bg">
                <td> <?php echo date('d-m-Y', strtotime($preauth_rec->date));?> </td>
                <td><?php echo $preauth_rec->chief_complaint; ?> </td>
                <td><?php echo $preauth_rec->current_diagnosis; ?> </td>
                <td><?php echo $preauth_rec->procedure; ?> </td>
                <td><?php
                if($preauth_rec->day_care == 'yes') echo 'Day Care';
                else echo $preauth_rec->expected_stay_duration; ?> </td>
                <td><?php echo $preauth_rec->expected_cost; ?> </td>
              </tr>
              <?php } ?>
            </tbody></table>
            </div>
           <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
   </div><!--end of panel4-->
</form> 
   
          </div>
          
          <br class="spacer" /></div>
          <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div>
    
<!-- Body End -->
<?php $this->load->view('common/footer'); ?>
