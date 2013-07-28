<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Family Details</title>l
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#666666;
	margin:0px;
	padding:0px;
}
.maindiv
{
width:950px;
margin:auto;
border:#000000 1px solid;
}
.mainhead{background-color : #aaaaaa;}
.tablehead{background-color : #d7d7d7;}
.row{   background-color : #e7e7e7;}


</style>
</head>
<body>

<div class="maindiv">
<form  method="POST">  
  <table width="950" border="1" align="center"  >       
      <tr > <td colspan="8" align="center" class="mainhead"><strong>AROGYA NIDHI</strong></td>   </tr>
      <tr class="tablehead">
        <td colspan="7" align="center"><strong>ENROLMENT DISPLAY FORM</strong></td>
        <td align="center">
         <a href="<?php echo $this->config->item('base_url');?>index.php/enrolment/editEnrolledFamily/family_details/">edit</a> </td>
      </tr>
      <tr class="row">
        <td width="82"  align="left" valign="top"><b>Form No</b></td>
        <td colspan="2" align="left" valign="top"> <?php echo $form_number; ?>  </td>
        <td width="86"  align="left" valign="top"><b>Date</b></td>
        <td colspan="2" align="left" valign="top"> <?php echo $date_of_enrolment; ?> </td>
        <td width="131" align="left" valign="top"><b>SHG Member:</b></td>
        <td width="109" align="left" valign="top"> <?php echo $is_shg_member; ?>  </td>
      </tr>
      <tr  class="row">
        <td align="left" valign="top"><b>Sakhi Name</b></td>
        <td colspan="2" align="left" valign="top"> <?php echo $sakhiName; ?>     </td>
        <td align="left" valign="top"><b>Phone Number</b></td>
        <td align="left" valign="top"> <?php echo $contact_number; ?> </td>
      </tr>
      <tr class="row">
        <td align="left" valign="top">&nbsp;</td>
        <td colspan="2" align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><b>Religion</b></td>
        <td colspan="2" align="left" valign="top"> <?php echo $religion; ?> </td>
           <td align="left" valign="top"><b>Own number:</b></td>
        <td align="left" valign="top"> <?php echo $is_own_number; ?> </td>
      </tr>
      <tr  class="row">
        <td  align="left" valign="top"><b>Address</b></td>
        <td colspan="2" rowspan="2" align="left" valign="top">
          <?php echo $house_location; ?> </td>
        <td align="left" valign="top"><b>Caste</b></td>
        <td colspan="2" align="left" valign="top"> <?php echo $caste; ?>       </td>
        <td align="left" valign="top"><b>BPL Card Number:</b></td>
        <td align="left" valign="top"> <?php echo $bpl_card_number; ?> </td>      </tr>
      <tr  class="row">        <td  align="left" valign="top" class="row">&nbsp;</td>        
        <td align="left" valign="top" class="row"><b>Taluka</b></td>
        <td colspan="2" align="left" valign="top" class="row"> <?php echo $talukaName; ?>  </td>
        <td align="left" valign="top" class="row"><b>Identity Type:</b></td>
        <td align="left" valign="top" class="row"> <?php echo $id_type; ?> </td> </tr>
      <tr  class="row"> <td align="left" valign="top"><b>Village</b> </td>
        <td colspan="2" align="left" valign="top">
        <?php echo $villageName; ?>        </td>
        <td align="left" valign="top"><b>District</b></td>
        <td colspan="2" align="left" valign="top"> <?php echo $districtName; ?> </td>
        <td align="left" valign="top"><b>Identity Card Number:</b></td>
        <td align="left" valign="top"> <?php echo $id_number; ?> </td>
      </tr> <tr class="row">
        <td align="left" valign="top"><b>Annual Income</b></td>
        <td colspan="2" align="left" valign="top"> <?php echo $annual_income; ?> </td>
        <td align="left" valign="top"><b>Annual Savings</b></td>
        <td colspan="2" align="left" valign="top">  <?php echo $annual_savings; ?> </td>
        <td align="left" valign="top" ></td>
        <td align="left" valign="top"> </td>
      </tr>      
      <tr> <td colspan="1" align="left" valign="top" class="row"><b>Policy Number</b></td>  
         <td colspan="7" align="left" valign="top" class="row"><?php echo $policy_number; ?> </td>  
      </tr>
</table>
<br>
<table width="950" align="center" border="1" >
  <tr class="mainhead">
        <td colspan="9" align="left" valign="top"><strong>Member Information</strong></td>       
  </tr>  
      <tr class="tablehead">
        <td width="13%" align="center" valign="top"><div align="center"><strong>Family member name</strong></div></td>
        <td width="9%" align="center" valign="top"><div align="center"><strong>Age / DoB</strong></div></td>
        <td width="10%" align="center" valign="top"><div align="center"><strong>Gender</strong></div></td>
        <td width="12%" align="center" valign="top"><div align="center"><strong>Relation</strong></div></td>
        <td width="18%" align="center" valign="top"><div align="center"><strong>Marital Status</strong></div></td>
        <td width="12%" align="center" valign="top"><div align="center"><strong>Education</strong></div></td>
        <td width="11%" align="center" valign="top"><div align="center"><strong>Income Source</strong></div></td>
        <td width="15%" align="center" valign="top"><div align="center"><strong>Addictions</strong></div></td>        
      </tr>     
      <?php 
      foreach ($members as $member_details){ ?>
      <tr class="row">
        <td align="center"><?php echo $member_details['full_name']; ?> </td>
        <td align="center"><?php echo $member_details['date_of_birth']; ?></td>
        <td align="center"><?php echo $member_details['gender']; ?></td>
        <td align="center"><?php echo $member_details['relation']; ?></td>
        <td align="center"><?php echo $member_details['marital_status']; ?></td>
        <td align="center"><?php echo $member_details['education']; ?></td>
        <td align="center"><?php echo $member_details['income_source'];?></td>
        <td align="center"> <?php echo $member_details['addictions'];?></td>
        <!--<td align="center"> <a href="<?php //echo $member_details['person_id'];?>">Edit</a> </td>-->
      </tr>      
      <?php } ?>     
</table>
<br>
<table width="950" border="1" align="center" cellpadding="0" cellspacing="0">
<tr><td colspan="6" align="right"><a href="<?php echo $this->config->item('base_url');?>index.php/enrolment/editEnrolledFamily/family_details/">Edit Step two</a>  </td> </tr>
<tr class="mainhead">
        <td colspan="9" align="left" valign="top"><strong>Information about Illness</strong></td>   
  </tr>  <tr class="tablehead">
        <td width="195" align="center" valign="top"><strong>Family member name</strong></td>
        <td colspan="2" align="center" valign="top"><strong>Illness</strong></td>
        <td width="121" align="center" valign="top"><strong>Days hospitalised</strong></td>
        <td width="152" align="center" valign="top"><strong>Cost per annum (Rs)</strong></td>
        <td width="281" colspan="3" align="center" valign="top"><strong>Status of illness</strong></td>       
  </tr>
<?php 
foreach ($illness_info as &$member_illness_info){ ?>      
  </tr>
      <tr class='row'>
        <td width="195" align="center" valign="top"> <?php echo $member_illness_info['full_name']; ?> </strong></td>
        <td colspan="2" align="center" valign="top"><?php echo $member_illness_info['illness_name']; ?> </td>
        <td width="121" align="center" valign="top"><?php echo $member_illness_info['days_of_hospitalization']; ?> </td>
        <td width="152" align="center" valign="top"><?php echo $member_illness_info['cost_of_treatment']; ?> </td>
        <td width="281" colspan="3" align="center" valign="top"><?php echo $member_illness_info['treatment_status']; ?> </td>        
  </tr>
  <?php } ?>
</table> <br>
<table>
 <tr>
 <td width="70%">
 
 <table width="550px"  border="1" align="left" cellpadding="0" cellspacing="0">
<tr class="mainhead">
  <td colspan="5" align="left" valign="top"><strong>Chronic illnesses</strong></td>   
</tr>
<tr class="tablehead">
    <td width="" align="center" valign="top"><strong>Family member name</strong></td>
    <td colspan="" align="center" valign="top"><strong>Illness</strong></td>
    <td width="" align="center" valign="top"><strong>Cost per month (Rs)</strong></td>
    <td width="" align="center" valign="top" colspan="2"><strong>OPD visits per month</strong></td>
</tr>  
<?php foreach ($c_illness_info as &$member_illness_info){ ?>      
  </tr>
  <tr class='row'>
    <td width="" align="center" valign="top"> <?php echo $member_illness_info['full_name']; ?> </strong></td>
    <td colspan="" align="center" valign="top"><?php echo $member_illness_info['illness']; ?> </td>
    <td width="" align="center" valign="top"><?php echo $member_illness_info['cost_per_month']; ?> </td>
    <td width="" align="center" valign="top"><?php echo $member_illness_info['opd_visits_per_month']; ?> </td>
  </tr>
  <?php } ?>
</table>
</td><td>

<table width="380px" border="1" cellpadding="0" cellspacing="0">
<tr class="mainhead">
  <td colspan="3" align="left" valign="top"><strong>Surgeries advised</strong></td>   
</tr>
<tr class="tablehead">
    <td width="" align="center" valign="top"><strong>Family member name</strong></td>
    <td align="center" valign="top" colspan="2"><strong>Surgeries advised</strong></td>    
</tr>
<?php foreach ($surgeries_advised as &$member_surgeries_advised){ ?>
  </tr>
  <tr class='row'>
    <td width="" align="center" valign="top"> <?php echo $member_surgeries_advised['full_name']; ?> </strong></td>
    <td colspan="" align="center" valign="top"><?php echo $member_surgeries_advised['surgeries_advised']; ?> </td>
  </tr>
  <?php } ?>
</table>
</td>
</tr>
</table>

<br>
<table width="950" border="1" align="center" cellpadding="0" cellspacing="0">

<tr class="mainhead">
        <td colspan="9" align="left" valign="top"><strong>Reproductive and Child Health Information</strong></td>   
  </tr>
      <tr class="tablehead">
        <td align="center" valign="top"><strong>Name</strong></td>
        <td align="center" valign="top"><strong>Child Name</strong></td>
        <td align="center" valign="top"><strong>Gender</strong></td>
        <td align="center" valign="top"><strong>ANC taken</strong></td>
        <td align="center" valign="top"><strong>Pregnancy Complications</strong></td>       
        
        <td align="center" valign="top"><strong>Childbirth complications</strong></td>
        <td align="center" valign="top"><strong>Mode of delivery</strong></td>
        <td align="center" valign="top" colspan="2"><strong>Place of delivery</strong></td>
  </tr>
<?php foreach ($rch_info as &$member_rch_info){ ?>
  </tr>
      <tr class='row'>
        <td  align="center" valign="top"> <?php echo $member_rch_info['parentName']; ?> </strong></td>
        <td align="center" valign="top">  <?php echo $member_rch_info['childName']; ?> </td>
        <td  align="center" valign="top"> <?php echo $member_rch_info['gender']; ?> </td>
        <td  align="center" valign="top"> <?php echo $member_rch_info['anc_taken']; ?> </td>
        <td  align="center" valign="top"> <?php echo $member_rch_info['complications_during_pregnancy']; ?> </td>
        <td  align="center" valign="top"> <?php echo $member_rch_info['complications_during_childbirth']; ?> </td>
        <td  align="center" valign="top"> <?php echo $member_rch_info['mode_of_delivery']; ?> </td>
        <td  align="center" valign="top"> <?php echo $member_rch_info['place_of_delivery']; ?> </td>        
  </tr>
  <?php } ?>  
  <tr>
  <td colspan="8" align="right">  <a href="<?php echo $this->config->item('base_url');?>index.php/enrolment/editFamilyPhotos/family_details/">Edit step three</a>
  </td>
  </tr>
</table>
<br />
<table>
<tr>
<?php 
foreach ($members as $member_details){ ?>
 <td align="center"><img width="125" height="120" 
src="<?php echo $this->config->item('base_url').'assets/images/'.$member_details['image_name']; ?>"/> 
 <br /> <b><?php echo $member_details['full_name']  ?></b>
 </td>
 <?php } ?>
</tr>
</table>
</form>
</div>
</body>
</html>