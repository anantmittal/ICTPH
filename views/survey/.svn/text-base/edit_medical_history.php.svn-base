<!DOC-TYPE ht ml PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->helper('form');?>
<script type='text/javascript' src='<?php echo $this->config->item('base_url'); ?>assets/js/utils.js'></script>
<script>
var obj;
function show(thisObj, divId)
{
  obj = thisObj;		
  document.getElementById(divId).style.display="block";
}

function fill(divId)
{
  //var final_string = "";
  var str;
  var element;
  if(divId == 'illnessDiv') {
    noIllness = 25;
    divIdInn = 'ill';
  } else if(divId == 'ciIllnessDiv') {
    noIllness = 33;
    divIdInn = 'ciIll';
  } 
  
  for(i=0;i<=noIllness; i++) {
    element = document.getElementById(divIdInn + i);         
    if(element.checked == true) {
      str = element.value;
      break;            
    }
  }
  obj.value = str;	
  document.getElementById(divId).style.display="none";
}
</script>

<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Enrollment Form</title>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="top">
  <div class="logo_box"><a href="#"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/common_images/logo.gif" width="190" height="120" alt="" /></a></div>
  <div class="logo_ikp"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/common_images/ikp-logo.gif" width="172" height="89" alt="" /></div>
</div>
<div class="search_box">
  <div class="search_left">
    <div class="search_col"><span class="form_head">Enter the ID</span></div>
    <div class="search_col">
      <input name="input" type="text" value="SSP-LUR-01-00004" />
    </div>
    <div class="search_col">
      <label>
        <select name="select" id="select">
          <option>Policy</option>
          <option>Preauth</option>
          <option>Hospitalization</option>
          <option>Claim</option>
          <option>Hospital</option>
        </select>
      </label>
    </div>
    <a href="#"><img src="<?php echo $this->config->item('base_url'); ?>assets/images/common_images/btn_search.gif" alt="" width="86" height="23" border="0" /></a></div>
  <div class="search_right">User Arvind, <a href="#">Logout</a></div>
</div>
<!--Main Page-->
<div id="main">

  <div class="hospit_box">

<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Family Medical History</span></div></div></div>
          <div class="green_body">


<?php echo validation_errors(); ?>

<div class="illness_popup" id="illnessDiv">
<table>
<!-- TODO: To take the following lists out of here and generate it in a PHP
loop, using the list from a config file -->

<tr>
<td><input type="radio" id="ill0" name="illnessradio" value="cold" checked/>cold सर्दी</td>
<td><input type="radio" id="ill1" name="illnessradio" value="cough"/>cough खोकला</td>
</tr>

<tr>
<td><input type="radio"  id="ill2" name="illnessradio" value="fever"/>fever ताप</td>
<td><input type="radio"  id="ill3" name="illnessradio" value="fever with chills"/>fever with chills हिवताप </td></tr>

<tr><td><input type="radio"  id="ill4" name="illnessradio" value="headache"/>headache डोकेदुखी </td>
<td><input type="radio" id="ill5" name="illnessradio" value="abdo pain"/>abdo pain पोटदुखी / पोटात कळ येणे</td></tr>


<tr><td><input type="radio" id="ill6" name="illnessradio" value="diarrohea"/>diarrohea	जुलाब  /संडास</td><td><input type="radio" id="ill7" name="illnessradio" value="body pain"/>body pain	अंगदुखी/मान पाठ कंबर</td></tr>



<tr><td><input type="radio" id="ill8" name="illnessradio" value="cataract"/>cataract मोती बिंदु 
</td><td><input type="radio" id="ill9" name="illnessradio" value="heart disease"/>heart disease ह्रदय विकार </td></tr>


<tr><td><input type="radio" id="ill10" name="illnessradio" value="chest pain"/>chest pain छातीचा ञास
</td><td><input type="radio" id="ill11" name="illnessradio" value="back pain"/>back pain	कंबरेचा ञास /पाठ दुखणे</td></tr>


<tr><td><input type="radio" id="ill12" name="illnessradio" value="diabetes"/>diabetes साखरी रोग / मधुमेह </td><td><input type="radio" id="ill13" name="illnessradio" value="diabetes"/>weakness अशक्‍तपणा / कमजोरी  </td></tr>


<tr><td><input type="radio" id="ill14" name="illnessradio" value="piles"/>piles मुळवेद  </td><td><input type="radio" id="ill15" name="illnessradio" value="dizziness"/>dizziness चक्‍कर  / डोक्‍यात फिरणे</td> </tr>


<tr><td><input type="radio" id="ill16" name="illnessradio" value="skin disease"/>skin disease त्‍वचा रोग  </td> <td><input type="radio" id="ill17" name="illnessradio" value="itching"/>itching खाजने </td>  
</tr>


<tr><td><input type="radio" id="ill18" name="illnessradio" value="seizures"/>seizures झटके</td><td><input type="radio" id="ill19" name="illnessradio" value="swelling"/>swelling सुजणे / शरीरात पाणी भरणे</td></tr>


<tr><td><input type="radio" id="ill20" name="illnessradio" value="pregnancy"/>pregnancy गरोदर  </td> <td><input type="radio" id="ill21" name="illnessradio" value="Ienstrual cycle "/>menstrual cycle महिना / मासिक पाळी   </td></tr>


<tr><td><input type="radio" id="ill22" name="illnessradio" value="kidney stone"/> kidney stone मुत खडा 
</td><td><input type="radio" id="ill23" name="illnessradio" value="knee problem"/>knee problem गुडघेदुखी  </td></tr>

<tr><td><input type="radio" id="ill24" name="illnessradio" value="asthma"/>asthma दमा </td>
 <td><input type="radio" id="ill25" name="illnessradio" value="other"/>Other इतर</td> 
     </tr>

</table>
<input type="button" onclick="fill('illnessDiv')" value="Add Illnesses"/>  
&nbsp; &nbsp;<input type="button" onclick="hide('illnessDiv')" value="Close"/>
</div>


<div class="ciIllness_popup"  id="ciIllnessDiv">
<table>
<tr>
<td><input type="radio" id="ciIll0" name="illnessradio" value="Tuberculosis(TB)" checked/>Tuberculosis(TB)क्षय रोग </td>
<td><input type="radio" id="ciIll1" name="illnessradio" value="Diabetes mellitus(DM)"/>Diabetes mellitus(DM)मधुमेह
 </td></tr>
<tr>
<td><input type="radio" id="ciIll2" name="illnessradio" value="Hypertension(HT)"/> Hypertension(HT)उच्‍च रक्‍तदाब </td>
<td><input type="radio" id="ciIll3" name="illnessradio" value="Cardiovascular diseases"/>Cardiovascular diseases ह्रदयविकार
</td></tr>
<tr>
<td><input type="radio" id="ciIll4" name="illnessradio" value="Cancer"/>Cancer कर्करोग</td>
<td><input type="radio" id="ciIll5" name="illnessradio" value="Backache"/>Backache पाठीचा त्रास</td>
</tr>

<tr>
<td><input type="radio" id="ciIll6" name="illnessradio" value="Asthma"/>Asthma दमा</td>
<td><input type="radio" id="ciIll7" name="illnessradio" value="Joint pain"/>Joint pain अनेकी त्रास</td>
</tr>

<tr>
<td><input type="radio" id="ciIll8" name="illnessradio" value="Other respiratory disorders"/>Other respiratory disorders इतर श्‍वसनाचे रोग </td>
<td><input type="radio" id="ciIll9" name="illnessradio" value="White discharge"/>White discharge	पांढरा पदर जाणे </td>
</tr>

<tr>
<td><input type="radio" id="ciIll10" name="illnessradio" value="Handicap/disability"/>Handicap/disability अपंगत्‍व</td>
<td><input type="radio" id="ciIll11" name="illnessradio" value="HIV/AIDS"/>HIV/AIDS एडस</td>
</tr>

<tr>
<td><input type="radio" id="ciIll12" name="illnessradio" value="Skin diseases"/>Skin diseases त्‍वचा रोग</td>
<td><input type="radio" id="ciIll13" name="illnessradio" value="Cronic renal failure"/>Cronic renal failure गुडघे दुखी</td>
</tr>

<tr>
<td><input type="radio" id="ciIll14" name="illnessradio" value="liver diseases"/>liver diseases यकत रोग</td>
<td><input type="radio" id="ciIll15" name="illnessradio" value="acidity"/>acidity पित्‍त</td>
</tr>


<tr>
<td><input type="radio" id="ciIll16" name="illnessradio" value="abdominal pain"/>abdominal pain पोटाचा त्रास</td>
<td><input type="radio" id="ciIll17" name="illnessradio" value="cough"/>cough खोकला </td>
</tr>

<tr>
<td><input type="radio" id="ciIll18" name="illnessradio" value="allergy"/>allergy एलर्जी</td>
<td><input type="radio" id="ciIll19" name="illnessradio" value="leprosy"/>leprosy महारोग</td>
</tr>

<tr>
<td><input type="radio" id="ciIll20" name="illnessradio" value="OPERATIVE PROCEDURES"/>Operative Procedures शस्‍त्राक्रिया प्रक्रिया</td>
<td><input type="radio" id="ciIll21" name="illnessradio" value="Hernia"/>Hernia हारण्‍या रोग</td>
</tr>


<tr>
<td><input type="radio" id="ciIll22" name="illnessradio" value="hydrocoele"/>hydrocoele अंडकोष</td>
<td><input type="radio" id="ciIll23" name="illnessradio" value="hysterectomy"/>hysterectomy गर्भाशयाची पिशवी काढणे</td>
</tr>

<tr>
<td><input type="radio" id="ciIll24" name="illnessradio" value="cataract"/>cataract मोतिबिंदु</td>
<td><input type="radio" id="ciIll25" name="illnessradio" value="gall bladder surgeries"/>gall bladder surgeries पित्‍ताशय शस्‍त्राक्रिया
</td>
</tr>

<tr>
<td><input type="radio" id="ciIll26" name="illnessradio" value="tonsilitis/adenoids"/>tonsilitis/adenoids घशातील गाठ</td>
<td><input type="radio" id="ciIll27" name="illnessradio" value="vasectomy"/>vasectomy पुरूष नसबंदी</td>
</tr>

<tr>
<td><input type="radio" id="ciIll28" name="illnessradio" value="tubectomy"/>tubectomy महिला नसबंदी</td>
<td><input type="radio" id="ciIll29" name="illnessradio" value="cancer surgeries"/>cancer surgeries कर्करोगशस्‍त्राक्रिया </td>
</tr>

<tr>
<td><input type="radio" id="ciIll30" name="illnessradio" value="cardiac surgeries"/>cardiac surgeries ह्रदय रोग</td>
<td><input type="radio" id="ciIll31" name="illnessradio" value="lipoma excisions"/>lipoma excisions गाठ काढणे </td>
</tr>

<tr>
<td><input type="radio" id="ciIll32" name="illnessradio" value="surgery for piles"/>surgery for piles मुळव्‍याधाची शस्‍त्राक्रिया </td>
<td><input type="radio" id="ill24" name="illnessradio" value="other"/>Other इतर</td> 
</tr>
</table>
<input type="button" onclick="fill('ciIllnessDiv')" value="Add Illnesses"/>  
&nbsp; &nbsp;<input type="button" onclick="hide('ciIllnessDiv')" value="Close"/>
</div>

<form method="POST" action="<?php echo $this->config->item('base_url').'index.php/survey/medical_history/add/'.$family_id; ?>">


 <?php if (isset($back_to)){?>
   <input type="hidden" name="back_to" value="<?php echo $back_to; ?>">
   <?php } else {  ?>
   <input type="hidden" name="back_to" value="nomal">
  <?php } ?>

<?php if(isset($family_id)){ ?>
<input type="hidden" name="family_id_for_update" value="<?php echo $family_id;?>">
<?php } ?>

  <div class="blue_left">
    <div class="blue_right">
      <div class="blue_middle"><span class="head_box">Hospitalization History</span></div>
    </div>
  </div>

  <div class="blue_body">
     <table width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">

      <tr class="head">
        <td width="195" align="center" valign="top"><div align="center"><strong>Family member name</strong></div></td>
        <td colspan="2" align="center" valign="top"><div align="center"><strong>Illness</strong></div></td>

        <td width="121" align="center" valign="top"><div align="center"><strong>Days hospitalised</strong></div></td>
        <td width="152" align="center" valign="top"><div align="center"><strong>Cost per annum (Rs)</strong></div></td>
        <td width="281" colspan="3" align="center" valign="top"><div align="center"><strong>Status of illness</strong></div>
        </td>
  </tr>

   <?php for ($i = 0; $i<7; $i++) { ?>        
      <tr class="row">
        <td align="left" valign="top" >
          <div align="center"> 
           <?php if(isset($past_hospitalizations[$i]['person_id']))
           echo form_dropdown("past_hospitalization[$i][person_id]",$member_list, $past_hospitalizations[$i]['person_id'],'class="bigselect"');  
           else 
           echo form_dropdown("past_hospitalization[$i][person_id]",$member_list, '','class="bigselect"');  ?> 
          </div></td>

        <td colspan="2" align="left" valign="top"><div align="center">
         <input name="past_hospitalizations[<?php echo $i; ?>][illness]"
	    type="text" onclick="show(this, 'illnessDiv')"
	    id="illness[<?php echo $i; ?>]" size="30" 
           value="<?php if(isset($past_hospitalizations[$i]['illness'])) echo $past_hospitalizations[$i]['illness']; ?>" />
        </div></td>

        <td align="left" valign="top"><div align="center">
          <input name="past_hospitalizations[<?php echo $i; ?>][days_of_hospitalization"
	   type="text" size="10"  
           value="<?php if(isset($past_hospitalizations[$i]['days_of_hospitalization'])) echo $past_hospitalizations[$i]['days_of_hospitalization']; ?>" />
        </div></td>

        <td align="left" valign="top"><div align="center">
          <input name="past_hospitalizations[<?php echo $i; ?>][cost_of_tretment]"
	   type="text" 
           value="<?php if(isset($past_hospitalizations[$i]['cost_of_treatment'])) echo $past_hospitalizations[$i]['cost_of_treatment']; ?>" size="10" />
        </div></td>

        <td colspan="3" align="left" valign="top"><div align="center">
          <select name="past_hospitalizations[<?php echo $i; ?>][treatment_status]"
	    class="largeselect">
          <option value="Already existing" >Already existing</option>   
	  <option value="Treated and cured in last 1 year" 
           <?php if(isset($past_hospitalizations[$i]['treatment_status'])) 
                if($past_hospitalizations[$i]['treatment_status'] == 'Treated and cured in last 1 year') echo 'selected'; ?> >
                Treated and cured in last 1 year</option>                 
          <option value="Treated and cured before 1 year" 
           <?php if(isset($past_hospitalizations[$i]['treatment_status'])) 
           if($past_hospitalizations[$i]['treatment_status'] == 'Treated and cured before 1 year') 
           echo 'selected'; ?>>Treated and cured before 1 year</option>
          </select>
        </div></td>
  </tr>        
  <?php } ?>
  
  </table>
 </div>
  <div class="bluebtm_left">
    <div class="bluebtm_right">
      <div class="bluebtm_middle"></div>
    </div>
  </div>
<br />


  <div class="blue_left">
    <div class="blue_right">
      <div class="blue_middle">
	 <span class="head_box">
	   <span align="left">Chronic Ilnesses / Surgeries Advised</span>
	 </span>
      </div>
    </div>
  </div>

  <div class="blue_body">
     <table width="58%" align="left" valign="top" border="0" cellspacing="2" cellpadding="0" class="data_table">

        <tr class="head">
          <td colspan="4">Chronic illnesses</td>
          </tr>

        <tr class="head">
          <td width="28%"><div align="center">Family member name</div></td>
          
          <td width="26%"><div align="center">Illness</div></td>
          <td width="23%"><div align="center">Cost per month (Rs)</div></td>
          <td width="23%"><div align="center">OPD visits per month</div>
            
            </td>
          </tr>
        <?php for ($i = 0; $i<5; $i++) { ?>
        <tr>
	  <td align="center">              
          <?php if(isset($chronic_illness[$i]['person_id']))
              echo form_dropdown("chronic_illness[$i][person_id]",$member_list, $chronic_illness[$i]['person_id'],'class="bigselect"');  
                else 
              echo form_dropdown("chronic_illnesses[$i][person_id]", $member_list, '','class="bigselect"'); ?>
          </td>

          <td><div align="center">
            <input name="chronic_illnesses[<?php echo $i; ?>][illness]" onclick="show(this, 'ciIllnessDiv')" type="text" 
   value="<?php if(isset($chronic_illness[$i]['illness']))
                echo  $chronic_illness[$i]['illness']; ?>" />
            </div></td>

          <td><div align="center">
            <input name="chronic_illnesses[<?php echo $i; ?>][cost_per_month]" type="text" 
                value="<?php if(isset($chronic_illness[$i]['cost_per_month']))
                             echo  $chronic_illness[$i]['cost_per_month']; ?>" size="10" />
            </div></td>

          <td><div align="center">
            <select name="chronic_illnesses[<?php echo $i; ?>][opd_visits_per_month]" class="smallselect">
                <?php for($j = 1; $j <=31; $j++) {
	                       if(isset($chronic_illness[$i]['opd_visits_per_month']))                 
	                       {
		                       if($j == $chronic_illness[$i]['opd_visits_per_month'])
		                          echo "<option value='$j' selected>$i</option>";
		                       else   
		                          echo "<option value='$j'>$j</option>";     	                       
	                       }
	                       else   
		                      echo "<option value='$j'>$j</option>"; 
                       }                          
                ?>
              </select> </div></td>

          </tr>   <?php } ?>
        </table>

      <table width="40%"  align="right" cellpadding="0" cellspacing="2" class="data_table">
        <tr class="head">
          <td colspan="2" scope="col">Surgeries advised</td>
          </tr>
        <tr class="head">
          <td width="49%">Family member name</td>
          
          <td width="51%">Surgeries advised</td>
          </tr>
        <?php for ($i=0; $i<5; $i++){ ?>
        <tr>

          <td><div align="center">
            <?php if (isset($advised_surgeries[$i]['person_id']))            
          echo form_dropdown("advised_surgeries[$i][person_id]",$member_list, $advised_surgeries[$i]['person_id'],'class="bigselect"');
          else 
              echo form_dropdown("advised_surgeries[$i][person_id]",$member_list, '','class="bigselect"'); ?>
            </div></td>

          <td><div align="center">
            <input name="advised_surgeries[<?php echo $i;?>][surgery]" type="text"  
   value="<?php if (isset($advised_surgeries[$i]['surgery']))
                	echo $advised_surgeries[$i]['surgery']; ?>" />
            </div></td>
          </tr>          
        <?php } ?>
        
        </table>
	</div>

  <div class="bluebtm_left">
    <div class="bluebtm_right">
      <div class="bluebtm_middle"></div>
    </div>
  </div>



  <div class="blue_left">
    <div class="blue_right">
      <div class="blue_middle"><span class="head_box">Reproductive and Child Health Information</span></div>
    </div>
  </div>
  <div class="blue_body">

<table width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
  <tr class="head">
    <td width="12%" align="center"><b>Name</b></td>
    <td width="12%" align="center"><b>Child Name </b></td>
    <td width="8%" align="center"><b>Gender</b></td>
    <td width="10%" align="center"><b>ANC taken</b></td>
    <td width="15%" align="center"><b>Pregnancy Complications</b></td>
    <td width="16%" align="center"><b>Childbirth complications</b></td>
    <td width="12%" align="center" valign="baseline"><b>Mode of delivery</b></td>
    <td width="15%" align="left"><b>Place of delivery</b></td>
  </tr>
  
  
  <?php for ($i=0; $i < 4; $i++){ ?>  
  <tr class="row">
    <td>
      <?php  if (isset($pregnancies[$i]['person_id'])) 
	          echo form_dropdown("pregnancies[$i][person_id]",$rch_member, $pregnancies[$i]['person_id'],'class="smallselect"');
	        else
	          echo form_dropdown("pregnancies[$i][person_id]",$rch_member, '','class="smallselect"');?>    
    </td>    

    <td>
    <?php 
    if (isset($pregnancies[$i]['childId'])) 
       echo form_dropdown("pregnancies[$i][child_id]",$childrens, $pregnancies[$i]['child_id'],'class="smallselect"');
    else 
       echo form_dropdown("pregnancies[$i][child_id]",$childrens, '','class="smallselect"');?>
    </td>

    <td align="center">
    M<input name="pregnancies[<?php echo $i;?>][gender]" type="radio" value="M" 
       <?php if (isset($pregnancies[$i]['gender']))
             if($pregnancies[$i]['gender'] == 'M') echo 'checked'; ?> /> 
             
    F<input name="pregnancies[<?php echo $i;?>][gender]" type="radio" value="F" 
       <?php if (isset($pregnancies[$i]['gender'])) 
             if($pregnancies[$i]['gender'] == 'F') echo 'checked'; ?> />
    </td>
    
    <td align="center" valign="middle">
    Yes <input name="pregnancies[<?php echo $i;?>][anc_taken]" type="radio" value="Yes" 
             <?php if (isset($pregnancies[$i]['anc_taken'])) 
                   if($pregnancies[$i]['anc_taken'] == 'Yes') echo 'checked'; ?>/>                   
      No <input name="pregnancies[<?php echo $i;?>][anc_taken]" type="radio" value="No" 
             <?php if (isset($pregnancies[$i]['anc_taken'])) 
                   if($pregnancies[$i]['anc_taken'] == 'No') echo 'checked'; ?>/>
    </td>

    <td align="center">    
    <?php if (isset($pregnancies[$i]['complications_during_pregnancy'])) 
	      echo form_dropdown("pregnancies[$i][complications_during_pregnancy]",$this->config->item('rch_preg_comp'), $pregnancies[$i]['complications_during_pregnancy'],'class="smallselect"');
	     else  
	       echo form_dropdown("pregnancies[$i][complications_during_pregnancy]", $this->config->item('rch_preg_comp'), '','class="smallselect"');
       ?>  
   </td>

   <td align="center">
   <?php if (isset($pregnancies[$i]['complications_during_childbirth'])) 
     echo form_dropdown("pregnancies[$i][complications_during_childbirth]", $this->config->item('rch_childbirth_comp'), $pregnancies[$i]['complications_during_childbirth'],'class="smallselect"');
     else 
     echo form_dropdown("pregnancies[$i][complications_during_childbirth]", $this->config->item('rch_childbirth_comp'),'','class="smallselect"');
     ?>     </td>
   
    <td align="center">
    Nor.
      <input name="pregnancies[<?php echo $i;?>][mode_of_delivery]" type="radio" value="Nor" 
     <?php if (isset($pregnancies[$i]['mode_of_delivery'])) 
            if($pregnancies[$i]['mode_of_delivery'] == 'Nor') echo 'checked'; ?> />
      
     Ces. <input name="pregnancies[<?php echo $i;?>][mode_of_delivery]" type="radio" value="Ces" 
     <?php if (isset($pregnancies[$i]['mode_of_delivery'])) 
            if($pregnancies[$i]['mode_of_delivery'] == 'Ces') echo 'checked'; ?> />
    </td>     
     
    <td align="left">
    <?php 
    if (isset($pregnancies[$i]['place_of_delivery']))             
      echo form_dropdown("pregnancies[$i][place_of_delivery]", $this->config->item('rch_place_deli'), $pregnancies[$i]['place_of_delivery'],'class="bigselect"');
    else 
      echo form_dropdown("pegnancies[$i][place_of_delivery]", $this->config->item('rch_place_deli'), '','class="bigselect"');
    ?>
    </td>
  </tr>
  <?php } ?> 
  
</table>
 </div>
  <div class="bluebtm_left" >
    <div class="bluebtm_right">
      <div class="bluebtm_middle"></div>
    </div>
  </div>  
   

<br />
<div class="form_row">
<input type="submit" name="button" id="button" value="Submit" class="submit"/>
</div>
</div></form>
<br class="spacer" /></div>
          <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<div id="footer">@ 2009 Swasth India. All right reserved.</div>
</body>
</html>
