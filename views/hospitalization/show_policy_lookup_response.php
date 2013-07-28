<?php 
	  $this->load->view('common/header');
	  $this->load->view('common/header_logo_block'); 
	  $this->load->view('common/header_search');
 ?> 
 
<link href="<?php echo "{$this->config->item('base_url')}assets/css/facebox.css"; ?>" media="screen" rel="stylesheet" type="text/css"/>
<script src="<?php echo "{$this->config->item('base_url')}assets/js/facebox.js"; ?>" type="text/javascript"></script>

<script type="text/javascript">
 jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox()
})
</script>
<title>Policy Details</title>
</head>
<body>

<!--<form method="GET" action="<?php echo $this->config->item('base_url');?>index.php">-->
<div id="main">
	<div id="leftcol">
    <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Policy details</span></div></div></div>
<div class="yelo_body" style="padding:8px;">

<?php $this->load->view('hospitalization/policy_context', $short_context); ?>
        	      
      <!--<div class="form_rowb">
        
      </div>     -->
      <!--<div class="form_data">Product: Oriental UHIS scheme, individual limit of Rs 4500 for consultation, Rs 5000 for operation</div>-->
      
      
      <div class="form_rowb"> </div>
      <b>Cashless Hospitals</b>
  
	  <?php 	  
	  if($cashless_hospitals) {
	  	
	  	foreach ($cashless_hospitals as $cashless_hospital) {
	  		if($cashless_hospital->name != '')
	  		echo "<li style='margin-left:12px;'>".$cashless_hospital->name."</li>";
	  	}
	  	
	  }
	  ?>	     
      
      <br class="spacer" /></div>
      <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
        
        <br />
        
        <!--<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Recent Activity</span></div></div></div>
          <div class="green_body">
            <div class="form_data">Claim number 0000001 for Rs 8000 approved on 25/05/2009</div>

          </div>
          <div class="greenbtm_left" ><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>-->
    </div>
    <!--Right panel-->
    
    <div id="rightcol">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">PreAuthorizations</span></div></div></div>
          <div class="blue_body" style="padding:10px;">

            <div class="form_row" style="margin-bottom:10px;">
           
              <div class="form_newbtn"><a href="<?php echo $this->config->item('base_url').'index.php/hospitalization/preautherization/enter_preauth/'.$policy_id;?>"><img src="<?php echo $this->config->item('base_url');?>assets/images/common_images/btn_newpreauth.gif" alt="" width="196" height="23" border="0" /></a></div>
            </div>
            
            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr class="head">
                <td width="9%">Date </td>
                <td width="5%" >ID</td>
                <td width="13%">Status </td>
                <td width="5%">Amount</td>
                <td width="15%">Hospital</td>
                <td width="5%" >Hospitalization ID	</td>
                <td width="14%">Patient Name	</td>
                <td width="40%">Next Actions</td>
              </tr>
              <?php
             if($pre_auth_obj) {
              foreach($pre_auth_obj as $value)
              {
//              	$date = Hosp_base_controller::date_display_format($value->date);
              	$date = Date_util::date_display_format($value->date);
              	$person_detail = $person_obj->find($value->person_id);
              	$patient_name = ucwords($person_detail->full_name);             	
              	if ($value->preauth_status == 'Approved'){

				?>
					
	            <tr class="green_bg">
	            <?php 
	            	if($value->hospitalization_id == 0) $value->hospitalization_id = "NH";
	            	 echo "<td>$date</td>
	            	 <td align='center'>$value->id</td>
	            	 <td>$value->preauth_status</td>
	            	 <td>$value->expected_cost</td>
	            	 <td>$value->hospital_name</td>
	            	 <td align='center'>$value->hospitalization_id</td>
	            	 <td align='center'>$patient_name</td>
	            	 <td class='ctnt_action'>"?><?php if($value->hospitalization_id == 0){
	            	 $action = 'Approved';
	            	// $object_type = 'preautherization';
	            	 $arr = Hosp_base_controller::get_next_action($action,'preauth');
	            	 $cnt = 1;
	            	 foreach ($arr as $key=>$arr_value){
	            	 echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$value->id.'>'.$arr[$key]['text'].'</a>';
	            	 if(count($arr) != $cnt)
	            	 	echo ' | ';
	            	 	$cnt++;
	            	 }
			?>
		<br>
		<form method="POST" action="<? echo $this->config->item('base_url').'index.php/hospitalization/preautherization/update_claim_id' ;?>">
		<input name="preauth_id" type="hidden" value="<? echo $value->id; ?>" >
		<input name="insurer_claim_id" type=text size="10" >
		<input type="submit" value="Update Insurer Claim Id" > 
		</form>
			<?php
			}?>
			</td></tr> 
	            <?php }elseif (($value->preauth_status == 'Admitted')){ ?>
	            	  <tr class="green_bg">
	            <?php  
	            	 echo "<td>$date</td>
	            	 <td align='center'>$value->id</td>
	            	 <td>$value->preauth_status</td>
	            	 <td>$value->expected_cost</td>
	            	 <td>$value->hospital_name</td>
	            	 <td align='center'>$value->hospitalization_id</td>
	            	 <td align='center'>$patient_name</td>
	            	 <td class='ctnt_action'>"?><?php
	            	 $action = 'Admitted';
	            	 $arr = Hosp_base_controller::get_next_action($action,'preauth');
	            	 $cnt = 1;
	            	 foreach ($arr as $key=>$arr_value){
//	            	 echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$policy_id.'/'.$value->id.'>'.$arr[$key]['text'].'</a>';
	            	 echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$value->id.'>'.$arr[$key]['text'].'</a>';
	            	 if(count($arr) != $cnt)
	            	 	echo ' | ';
	            	 	$cnt++;
	            	 }
			if($value->hospitalization_id ==0)
			{
			?>
			<br>
			<form method="POST" action="<? echo $this->config->item('base_url').'index.php/hospitalization/preautherization/update_claim_id' ;?>">
			<input name="preauth_id" type="hidden" value="<? echo $value->id; ?>" >
			<input name="insurer_claim_id" type=text size="10" >
			<input type="submit" value="Update Insurer Claim Id" > 
			</form>
			<?php }
			else { echo '<br>Hospitalisation and Backend Claim created already'; } ?>
		</td></tr>
	         <?php }elseif (($value->preauth_status == 'Reject')){ 
	         		
	         	?>
	         			<div id="reason" style="display:none;">
  						<?php echo $this->uri->segment(5);?>
					   </div>
	            	  <tr class="red_bg">
	            <?php 
	            	 if($value->hospitalization_id == 0) $value->hospitalization_id = "--";
	            	 echo "<td>$date</td>
	            	 <td align='center'>$value->id</td>
	            	 <td>$value->preauth_status</td>
	            	 <td>$value->expected_cost</td>
	            	 <td>$value->hospital_name</td>
	            	 <td align='center'>$value->hospitalization_id</td>
	            	 <td align='center'>$patient_name</td>
	            	 <td class='ctnt_action' >"?><?php 
	            	 $action = 'Rejected';
	            	 $arr = Hosp_base_controller::get_next_action($action,'preauth');
	            	 $cnt = 1;
	            	 foreach ($arr as $key=>$arr_value){
	            	 echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$value->id.' rel=facebox>'.$arr[$key]['text'].'</a>';
	            	 if(count($arr) != $cnt)
	            	 	echo ' | ';
	            	 	$cnt++;
	            	 }?></td>
	            	 </tr>
	            	 <?php ;}elseif(($value->preauth_status == 'To be Reviewed')){
	            	 				            	 	?>
	            	 <tr class="green_bg">
	            <?php 
                     if($value->hospitalization_id == 0) $value->hospitalization_id = "--";
	            	 echo "<td>$date</td>
	            	 <td align='center'>$value->id</td>
	            	 <td>$value->preauth_status</td>
	            	 <td>$value->expected_cost</td>
	            	 <td>$value->hospital_name</td>
	            	 <td align='center'>$value->hospitalization_id</td>
	            	 <td align='center'>$patient_name</td>
	            	 <td class='ctnt_action'>"?><?php 
	            	 $action = 'To be reviewed';
	            	 $arr = Hosp_base_controller::get_next_action($action,'preauth');
	            	 $cnt = 1;
	            	 foreach ($arr as $key=>$arr_value){
	            	 if($arr[$key]['text'] == 'Reject')
	            	 {
	            	 echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$value->id. ' rel=facebox >'.$arr[$key]['text'].'</a>';
	            	 }
	            	 else 
	            	 echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$value->id. '>'.$arr[$key]['text'].'</a>';
	            	 if(count($arr) != $cnt)
	            	 	echo ' | ';
	            	 	$cnt++;
	            	 } ?>
	            	 </td>
	            	 </tr>
	            	 
	            	<?php ;}else{ ?>
	            	 <tr class="grey_bg">
	                 <?php 
	                 if($value->hospitalization_id == 0) $value->hospitalization_id = "--";
	            	 echo "<td>$date</td>
	            	 <td align='center'>$value->id</td>
	            	 <td>$value->preauth_status</td>
	            	 <td>$value->expected_cost</td>
	            	 <td>$value->hospital_name</td>
	            	 <td align='center'>$value->hospitalization_id</td>
	            	 <td align='center'>$patient_name</td>
	            	 <td class='ctnt_action'>";
	            	 $action = $value->preauth_status;
	            	 $arr = Hosp_base_controller::get_next_action($action,'preauth');
	            	 $cnt = 1;
	            	 foreach ($arr as $key=>$arr_value){
	            	 if($arr[$key]['text'] == 'Reject')
	            	 {
	            	 echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$value->id. ' rel=facebox >'.$arr[$key]['text'].'</a>';
	            	 }
	            	 else 
	            	 echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$value->id. '>'.$arr[$key]['text'].'</a>';
	            	 if(count($arr) != $cnt)
	            	 	echo ' | ';
	            	 	$cnt++;
	            	 } 
			if($value->hospitalization_id =="--" && $value->preauth_status == 'Discharged')
			{
			?>
			<br>
			<form method="POST" action="<? echo $this->config->item('base_url').'index.php/hospitalization/preautherization/update_claim_id' ;?>">
			<input name="preauth_id" type="hidden" value="<? echo $value->id; ?>" >
			<input name="insurer_claim_id" type=text size="10" >
			<input type="submit" value="Update Insurer Claim Id" > 
			</form>
			<?php }
			else { echo '<br>Hospitalisation and Backend Claim created already'; } ?>
			 </td>       	
	            	 </tr>
	            	 
	            	 <?php ;} //end of else condition
               }//end of for each
             } //end of condition for checking preauth object  
             else {
              	echo '<tr><td colspan="8" align="center"><b>---------No Records--------</b></td></tr>';
              }
             ?>
	                                       
            </table>
          </div>
          <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br />

    	
          
          
          
          
          
          
          
        <!--Hospitalizations Panel-->     
       
        <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Hospitalizations</span></div></div></div>
          <div class="blue_body" style="padding:10px;">

            <div class="form_row" style="margin-bottom:10px;">
              <div class="form_newbtn"><a href="<?php echo $this->config->item('base_url').'index.php/hospitalization/hospitalization/add/'.$policy_id.'/hosp';?>">Add Hospitalization</a></div>
		</div>

            <table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr class="head">
                <td width="9%">Date (Admission) </td>
                <td width="5%">ID</td>
				<td width="13%">Status </td>
                <td width="5%">Amount</td>
                <td width="14%">Hospital</td>
                 <td width="9%">Last Claim-ID</td>
                 <td width="14%">Patient Name</td>
                <td width="40%">Next Actions</td>
              </tr>
              <?php 
              if($hospitalizaion_obj){
				foreach($hospitalizaion_obj as $value)
				{	
//					$date = Hosp_base_controller::date_display_format($value->hospitalization_date);
					$date = Date_util::date_display_format($value->hospitalization_date);
					$person_detail = $person_obj->find($value->person_id);	
					$patient_name = ucwords($person_detail->full_name);
					$amount = 0;
					foreach ($pre_auth_obj as $preauth_value)
					{
						if($value->id == $preauth_value->hospitalization_id)
						$amount = $preauth_value->expected_cost;
					}
					
	  			  if($value->last_claim_id == 0) $value->last_claim_id = "--";		  		
				  if($value->status == 'Admitted'){ ?>
	  			   <tr class="green_bg">
				  <?php echo "<td>$date</td>
	  			  		  <td align='center'>$value->id</td>
	  			  		  <td>$value->status</td>
	  			  		  <td>$amount</td>
	  			  		  <td>$value->hospital_name</td>
	  			  		  <td align=center>$value->last_claim_id</td>
	  			  		  <td>$patient_name</td>
	  			  		   <td class='ctnt_action'>"?><?php 
				  $action = 'Admitted';
				  $arr = Hosp_base_controller::get_next_action($action,'hospitalization');
				  $cnt = 1;
				  foreach ($arr as $key => $arr_value){				  
//				  echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$policy_id.'/'.$value->id.'>'.$arr[$key]['text'].'</a>';
				  echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$value->id.'/hosp>'.$arr[$key]['text'].'</a>';
				  if(count($arr) != $cnt)
				  	echo ' | ';				  	
				  $cnt++;				   
				  }
	              ?></td>  </tr> <?php ;} else{ ?>
				  <tr class="grey_bg">
				  <?php echo "<td>$date</td>
	  			  		  <td align='center'>$value->id</td>
	  			  		  <td>$value->status</td>
	  			  		  <td></td>
	  			  		  <td>$value->hospital_name</td>
	  			  		  <td align=center>$value->last_claim_id</td>
	  			  		  <td>$patient_name</td>
	  			  		  <td class='ctnt_action'>"?><?php 
	            	 $action = 'Discharged';
	            	 $arr = Hosp_base_controller::get_next_action($action,'hospitalization');
	            	 $cnt = 1;
	            	 foreach ($arr as $key=>$arr_value){
	            	 	echo "<a href=".$this->config->item('base_url').'index.php/'.$arr[$key]['controller'].'/'.$arr[$key]['action'].'/'.$value->id.'/hosp>'.$arr[$key]['text'].'</a>';
	            	 	if(count($arr) != $cnt)
	            	 	echo ' | ';
	            	 	$cnt++;
	            	 }
	            	 ?></td> </tr> <?php ;} //end of else
				} // end of foreach
              }//end of if condition of checking $hospitalization_obj 
              else {
              	echo '<tr><td colspan="8" align="center"><b>---------No Records--------</b></td></tr>';
              }
              ?>
	 		             
            </table>
      </div>
          <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br />

       <!--Claims Panel-->       
        <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Claims</span></div></div></div>
           <div class="blue_body" style="padding:10px;">
         	<table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr class="head">
                <td width="8%">Filing Date </td>
                <td width="4%" >ID</td>
                <td width="4%" >Hosp ID</td>
                <td width="9%">Processing Status </td>
                <td width="9%">Claim By </td>
                <td width="5%">Amount Claimed</td>
                <td width="9%">Amount Settled </td>
                <td width="14%">Patient</td>
                <td width="38%">Next Actions</td>
              </tr>
              
             <?php
             	          	
          
             
                if($all_claims_obj != false){
              	foreach ($all_claims_obj as $claim_obj) {
              		
              	             		
//              	$date = Hosp_base_controller::date_display_format($claim_obj->filling_date);
              	$date = Date_util::date_display_format($claim_obj->filling_date);
              	if($claim_obj->last_backend_claim_id == 0) $claim_obj->last_backend_claim_id = "--";	
//              	if($claim_obj->processing_status == 'To be reviewed') $claim_obj->claim_status = "--";	 
              	if($claim_obj->processing_status == 'To be reviewed') $claim_obj->amount_settled = "--";	 
              	if($claim_obj->processing_status == 'Settled'){	?>
                <tr class="grey_bg">
                <td><?php echo $date;?></td>
                <td align="center"><?php echo $claim_obj->id;?></td>
                <td align="center"><?php echo $claim_obj->hospitalization_id;?></td>
                <td align="center"><?php echo $claim_obj->processing_status;?></td>
     <!--           <td ><?php echo $claim_obj->claim_status;?></td> -->
                <td align="center"><?php echo $claim_obj->claim_by; ?></td>
                <td align="center"><?php echo $claim_obj->total_claim_amount; ?></td>
                <td ><?php echo $claim_obj->amount_settled;?></td>
                <td><?php echo ucwords($claim_obj->patient_name);?></td>
                <td>
                <?php  
                	        
               	   	$next_action_arr = Hosp_base_controller::get_next_action($claim_obj->processing_status, 'claim');
                	$cnt = 1;
               	    foreach ($next_action_arr as $key => $arr_value)
                	{
                		echo "<a href=".$this->config->item('base_url').'index.php/'.$next_action_arr[$key]['controller'].'/'.$next_action_arr[$key]['action'].'/'.$claim_obj->id.' >'.$next_action_arr[$key]['text'].'</a>';
                		if(count($next_action_arr) != $cnt)
                		echo ' | ';
                		$cnt++;
                	}
                ?>
                               
                </td>
                </tr>
              <?php
              	}elseif ($claim_obj->processing_status == 'Pending hospital'){ ?>
              		
              	<tr class="green_bg">
                <td><?php echo $date;?></td>
                <td align="center"><?php echo $claim_obj->id;?></td>
                <td align="center"><?php echo $claim_obj->hospitalization_id;?></td>
                <td align="center"><?php echo $claim_obj->processing_status;?></td>
     <!--           <td align="center"><?php echo $claim_obj->claim_status;?></td>-->
                <td align="center"><?php echo $claim_obj->claim_by; ?></td>
                <td align="center"><?php echo $claim_obj->total_claim_amount; ?></td>
                <td ><?php echo $claim_obj->amount_settled;?></td>
                <td><?php echo ucwords($claim_obj->patient_name);?></td>
                <td>
                <?php  
                	        
               	   	$next_action_arr = Hosp_base_controller::get_next_action($claim_obj->processing_status, 'claim');
                	$cnt = 1;
               	    foreach ($next_action_arr as $key => $arr_value)
                	{
                		echo "<a href=".$this->config->item('base_url').'index.php/'.$next_action_arr[$key]['controller'].'/'.$next_action_arr[$key]['action'].'/'.$claim_obj->id.'>'.$next_action_arr[$key]['text'].'</a>';
                		if(count($next_action_arr) != $cnt)
                		echo ' | ';
                		$cnt++;

                	}
                ?>
                </td>
                </tr>
              	
             	<?php }
             	
             	elseif ($claim_obj->processing_status == 'Pending patient'){ ?>
              		
              	<tr class="green_bg">
                <td><?php echo $date;?></td>
                <td align="center"><?php echo $claim_obj->id;?></td>
                <td align="center"><?php echo $claim_obj->hospitalization_id;?></td>
                <td align="center"><?php echo $claim_obj->processing_status;?></td>
<!--                <td align="center"><?php echo $claim_obj->claim_status;?></td>-->
                <td align="center"><?php echo $claim_obj->claim_by; ?></td>
                <td><?php echo $claim_obj->total_claim_amount; ?></td>
                <td ><?php echo $claim_obj->amount_settled;?></td>
                <td><?php echo ucwords($claim_obj->patient_name);?></td>
                <td>
                <?php  
                	        
               	   	$next_action_arr = Hosp_base_controller::get_next_action($claim_obj->processing_status, 'claim');
                	$cnt = 1;
               	    foreach ($next_action_arr as $key => $arr_value)
                	{
                		echo "<a href=".$this->config->item('base_url').'index.php/'.$next_action_arr[$key]['controller'].'/'.$next_action_arr[$key]['action'].'/'.$claim_obj->id.'>'.$next_action_arr[$key]['text'].'</a>';
                		if(count($next_action_arr) != $cnt)
                		echo ' | ';
                		$cnt++;

                	}
                ?>
                
                
                </td>
                </tr>
              	
             	<?php }else{ ?>
              		
              	<tr class="green_bg">
                <td><?php echo $date;?></td>
                <td align="center"><?php echo $claim_obj->id;?></td>
                <td align="center"><?php echo $claim_obj->hospitalization_id;?></td>
                <td align="center"><?php echo $claim_obj->processing_status;?></td>
       <!--         <td align="center"><?php echo $claim_obj->claim_status;?></td> -->
                <td align="center"><?php echo $claim_obj->claim_by; ?></td>
                <td align="center"><?php echo $claim_obj->total_claim_amount; ?></td>
                <td ><?php echo $claim_obj->amount_settled;?></td>
                <td><?php echo ucwords($claim_obj->patient_name);?></td>
                <td>
                <?php  
                	        
               	   	$next_action_arr = Hosp_base_controller::get_next_action($claim_obj->processing_status, 'claim');
                	$cnt = 1;
               	    foreach ($next_action_arr as $key => $arr_value)
                	{
                		echo "<a href=".$this->config->item('base_url').'index.php/'.$next_action_arr[$key]['controller'].'/'.$next_action_arr[$key]['action'].'/'.$claim_obj->id.'>'.$next_action_arr[$key]['text'].'</a>';
                		if(count($next_action_arr) != $cnt)
                		echo ' | ';
                		$cnt++;

                	}
                ?>
                
                
                </td>
                </tr>
              	
             	<?php }
              	}
              	//end of foreach
              } //end of if condition
              else 
              	echo '<tr><td colspan="9" align="center"><b>---------No Records--------</b></td></tr>';
              ?>
           </table>

      </div>
          <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
 




       <!--Backend Claims Panel-->       

        <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Backend Claims</span></div></div></div>
           <div class="blue_body" style="padding:10px;">
         	<table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr class="head">
                <td width="10%">Filing Date </td>
                <td width="5%" >ID</td>
                <td width="5%" >Hosp ID</td>
                <td width="10%">Status </td>
                <td width="10%">Amount Claimed</td>
                <td width="10%">Amount Settled</td>
                <td width="15%">Claim No</td>
                <td width="35%">Next Actions</td>
              </tr>
              
             <?php
             	          	
             
                if($all_backend_claims_obj != false){
              	foreach ($all_backend_claims_obj as $backend_claim_obj) {
              		
              	             		
//              	$date = Hosp_base_controller::date_display_format($claim_obj->filling_date);
              	$date = Date_util::date_display_format($backend_claim_obj->filling_date);
              	if($backend_claim_obj->status == 'Settled'){	?>
                <tr class="grey_bg">
                <td><?php echo $date;?></td>
                <td align="center"><?php echo $backend_claim_obj->id;?></td>
                <td align="center"><?php echo $backend_claim_obj->hospitalization_id;?></td>
                <td align="center"><?php echo $backend_claim_obj->status;?></td>
                <td align="center"><?php echo $backend_claim_obj->amount_claimed; ?></td>
                <td align="center"><?php echo $backend_claim_obj->amount_settled; ?></td>
                <td align="center">
		<?php 
			$bc_url = $this->config->item('base_url').'index.php/hospitalization/backend_claim/show_bc_status/'.$backend_claim_obj->backend_member_id.'/'.$backend_claim_obj->insurer_claim_id; ?>
			<input type="button" value="<?php echo $backend_claim_obj->insurer_claim_id; ?>" onClick="window.open('<?php echo $bc_url; ?>');"> 
		</td>
                <td>
                <?php  
                	        
               	   	$next_action_arr = Hosp_base_controller::get_next_action($backend_claim_obj->status, 'backend_claim');
                	$cnt = 1;
               	    foreach ($next_action_arr as $key => $arr_value)
                	{
                		echo "<a href=".$this->config->item('base_url').'index.php/'.$next_action_arr[$key]['controller'].'/'.$next_action_arr[$key]['action'].'/'.$backend_claim_obj->id.'/bc>'.$next_action_arr[$key]['text'].'</a>';
                		if(count($next_action_arr) != $cnt)
                		echo ' | ';
                		$cnt++;
                	}
                ?>
                               
                </td>
                </tr>
              <?php
              	}else{ ?>
              		
              	<tr class="green_bg">
                <td><?php echo $date;?></td>
                <td align="center"><?php echo $backend_claim_obj->id;?></td>
                <td align="center"><?php echo $backend_claim_obj->hospitalization_id;?></td>
                <td align="center"><?php echo $backend_claim_obj->status;?></td>
                <td align="center"><?php echo $backend_claim_obj->amount_claimed; ?></td>
                <td align="center"><?php echo '--'; ?></td>
                <td align="center">
		<?php 
			if($backend_claim_obj->insurer_claim_id!='')
			{
			  $bc_url = $this->config->item('base_url').'index.php/hospitalization/backend_claim/show_bc_status/'.$backend_claim_obj->backend_member_id.'/'.$backend_claim_obj->insurer_claim_id; ?>
			  <input type="button" value="<?php echo $backend_claim_obj->insurer_claim_id; ?>" onClick="window.open('<?php echo $bc_url; ?>');"> 
		<?php	}
			else { echo 'Not in database';} ?>
		</td>
                <td>
                <?php  
                	        
               	   	$next_action_arr = Hosp_base_controller::get_next_action($backend_claim_obj->status, 'backend_claim');
                	$cnt = 1;
               	    foreach ($next_action_arr as $key => $arr_value)
                	{
                		echo "<a href=".$this->config->item('base_url').'index.php/'.$next_action_arr[$key]['controller'].'/'.$next_action_arr[$key]['action'].'/'.$backend_claim_obj->id.'/bc>'.$next_action_arr[$key]['text'].'</a>';
                		if(count($next_action_arr) != $cnt)
                		echo ' | ';
                		$cnt++;

                	}
                ?>
                </td>
                </tr>
              	
             	<?php }
              	}
              	//end of foreach
              } //end of if condition
              else 
              	echo '<tr><td colspan="9" align="center"><b>---------No Records--------</b></td></tr>';
              ?>
           </table>

      </div>
          <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
        	
  </div>
 
        	
  </div>
<br class="spacer" /></div>	
<?php 
$this->load->view('common/footer');
?>
