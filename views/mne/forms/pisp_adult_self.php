<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://localhost/sgv/assets/css/site.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="http://localhost/sgv/assets/css/jquery-ui-1.7.1.custom.css" rel="stylesheet" />
<script type="text/javascript" >
base_url = "http://localhost/sgv/";
</script>

<title>PISP Adult Questionnaire</title>


<script type="text/javascript"
	src="http://localhost/sgv/assets/js/jquery-ui-1.7.1.custom.min.js"></script>
</head>
<script src="<?php echo base_url();?>assets/js/mne/pisp_adult.js"></script>
<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title><?php echo $title?></title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');

?>
<?php echo validation_errors(); ?>
<table width="50%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">
		PISP Adult Questionnaire</span></div>

		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

<center>
<form method="post" onsubmit="return checkform(this);">
<input type="hidden" name="svg" value="1" />
<input type="hidden" name="adult_id" value="x" />
<input type="hidden" name="date_interview" value="<?php echo date('dd/mm/yyyy');?>" />

 <br> 
<table width="60%"><tr> <td><b>Name of respondent</b></td><td><input name="name" id="name" type="text" size="100" /></td></tr>
<tr> <td><b>Gender</b></td><td><select name="gender" id="gender" ><option value="f" onclick="OnEnableDisable(femaleCtrls);">Female</option><option value="m" onclick="OnEnableDisable(maleCtrls);">Male</option><option value="o" onclick="OnEnableDisable(otherGenderCtrls);">Other</option></select></td></tr>
<tr> <td><b>Date of birth (dd/mm/yyyy)</b></td><td><input name="dob" id="dob" type="text" size="10" /></td></tr>
<tr> <td><b>Address</b></td><td><input name="address" id="address" type="text" size="100" /></td></tr>
<tr> <td><b>Highest education completed?</b></td><td><select name="education" id="education" ><option value="0">0; &lt;5</option><option value="1">10</option><option value="2">12</option><option value="3">UG</option><option value="4">PG</option></select></td></tr>
<tr> <td><b>Currently studying?</b></td><td><select name="school" id="school" ><option value="n">No</option><option value="y">Yes</option></select></td></tr>

<tr> <td><b>Marital status</b></td><td><select name="marital" id="marital" ><option value="1" onclick="OnEnableDisable(indexToggle(0,marriedfields,1));">Married</option><option value="2"  onclick="OnEnableDisable(indexToggle(0,marriedfields,1));">Widowed</option><option value="3"  onclick="OnEnableDisable(indexToggle(0,marriedfields,1));">Divorced</option><option value="4"  onclick="OnEnableDisable(indexToggle(0,marriedfields,1));">Separated</option><option value="5"  onclick="OnEnableDisable(indexToggle(0,marriedfields,1));">Deserted</option><option value="6"  onclick="OnEnableDisable(indexToggle(0,marriedfields,3));">Never married</option></select></td></tr>
<tr> <td><b>Occupation</b></td><td><select name="occupation" id="occupation" ><option value="1">Daily wage on other people's land</option><option value="2">Cultivation on own land</option><option value="3">Manual labour</option><option value="4">Self-employed non-farm work</option><option value="5">Government worker</option><option value="6">Non-government worker</option><option value="7">Student</option><option value="8">Homemaker</option><option value="9">Retired</option><option value="10">Unemployed (able to work)</option><option value="11">Unemployed (unable to work)</option></select></td></tr>

<tr> <td><b>Blood pressure </b></td><td><input name="bp" id="bp" type="text" size="7" /> mmHg</td></tr>
<tr> <td><b>Disease symptoms</b></td><td><input name="acute_nos" id="acute_nos" type="hidden" value="19" /><table border="1"><tr><td>SN</td><td></td><td>Conditions experienced in the last month</td><td>Ability affected?</td><td>Medical care sought</td><td>Still exists/persists</td></tr><tr><td>1.</td><td>Cold symptoms (runny nose congestion sneezing):</td><input name="acute_label_value0" id="acute_label_value0" type="hidden" value="1" /><td><select name="acuteacute_pastmonth0" id="acuteacute_pastmonth0" ><option value="no"  onclick="OnEnableDisable(indexToggle(0,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(0,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected0" id="acuteacute_abilityaffected0" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>

</td><td><select name="acuteacute_carelocation0" id="acuteacute_carelocation0" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>
</td><td><select name="acuteacute_persists0" id="acuteacute_persists0" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>2.</td><td>Persistent cough:</td><input name="acute_label_value1" id="acute_label_value1" type="hidden" value="2" /><td><select name="acuteacute_pastmonth1" id="acuteacute_pastmonth1" ><option value="no" onclick="OnEnableDisable(indexToggle(1,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(1,acuteids,1));">Yes</option></select>

</td><td><select name="acuteacute_abilityaffected1" id="acuteacute_abilityaffected1" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation1" id="acuteacute_carelocation1" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>
</td><td><select name="acuteacute_persists1" id="acuteacute_persists1" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>

</td></tr><tr><td>3.</td><td>Fever:</td><input name="acute_label_value2" id="acute_label_value2" type="hidden" value="3" /><td><select name="acuteacute_pastmonth2" id="acuteacute_pastmonth2" ><option value="no" onclick="OnEnableDisable(indexToggle(2,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(2,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected2" id="acuteacute_abilityaffected2"  disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation2" id="acuteacute_carelocation2"  disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists2" id="acuteacute_persists2"  disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>4.</td><td>Diarrhea:</td><input name="acute_label_value3" id="acute_label_value3" type="hidden" value="4" /><td><select name="acuteacute_pastmonth3" id="acuteacute_pastmonth3" ><option value="no" onclick="OnEnableDisable(indexToggle(3,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(3,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected3" id="acuteacute_abilityaffected3"  disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation3" id="acuteacute_carelocation3"  disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists3" id="acuteacute_persists3"  disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>5.</td><td>Weakness / Fatigue:</td><input name="acute_label_value4" id="acute_label_value4" type="hidden" value="5" /><td><select name="acuteacute_pastmonth4" id="acuteacute_pastmonth4" ><option value="no" onclick="OnEnableDisable(indexToggle(4,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(4,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected4" id="acuteacute_abilityaffected4" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation4" id="acuteacute_carelocation4" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists4" id="acuteacute_persists4" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>6.</td><td>Vomiting:</td><input name="acute_label_value5" id="acute_label_value5" type="hidden" value="6" /><td><select name="acuteacute_pastmonth5" id="acuteacute_pastmonth5" ><option value="no" onclick="OnEnableDisable(indexToggle(5,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(5,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected5" id="acuteacute_abilityaffected5" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation5" id="acuteacute_carelocation5" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists5" id="acuteacute_persists5" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>7.</td><td>Worms in stool:</td><input name="acute_label_value6" id="acute_label_value6" type="hidden" value="7" /><td><select name="acuteacute_pastmonth6" id="acuteacute_pastmonth6" ><option value="no" onclick="OnEnableDisable(indexToggle(6,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(6,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected6" id="acuteacute_abilityaffected6" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation6" id="acuteacute_carelocation6" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists6" id="acuteacute_persists6" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>8.</td><td>Difficulty in breathing:</td><input name="acute_label_value7" id="acute_label_value7" type="hidden" value="8" /><td><select name="acuteacute_pastmonth7" id="acuteacute_pastmonth7" ><option value="no" onclick="OnEnableDisable(indexToggle(7,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(7,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected7" id="acuteacute_abilityaffected7" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation7" id="acuteacute_carelocation7" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists7" id="acuteacute_persists7" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>9.</td><td>Pain in abdomen:</td><input name="acute_label_value8" id="acute_label_value8" type="hidden" value="9" /><td><select name="acuteacute_pastmonth8" id="acuteacute_pastmonth8" ><option value="no" onclick="OnEnableDisable(indexToggle(8,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(8,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected8" id="acuteacute_abilityaffected8" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation8" id="acuteacute_carelocation8" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists8" id="acuteacute_persists8" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>10.</td><td>Genital ulcers:</td><input name="acute_label_value9" id="acute_label_value9" type="hidden" value="10" /><td><select name="acuteacute_pastmonth9" id="acuteacute_pastmonth9" ><option value="no" onclick="OnEnableDisable(indexToggle(9,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(9,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected9" id="acuteacute_abilityaffected9" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation9" id="acuteacute_carelocation9" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists9" id="acuteacute_persists9" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>11.</td><td>Painful urination:</td><input name="acute_label_value10" id="acute_label_value10" type="hidden" value="11" /><td><select name="acuteacute_pastmonth10" id="acuteacute_pastmonth10" ><option value="no" onclick="OnEnableDisable(indexToggle(10,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(10,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected10" id="acuteacute_abilityaffected10" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation10" id="acuteacute_carelocation10" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists10" id="acuteacute_persists10" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>12.</td><td>Swelling of ankles:</td><input name="acute_label_value11" id="acute_label_value11" type="hidden" value="12" /><td><select name="acuteacute_pastmonth11" id="acuteacute_pastmonth11" ><option value="no" onclick="OnEnableDisable(indexToggle(11,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(11,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected11" id="acuteacute_abilityaffected11" disabled="disabled"><option value="no" onclick="OnEnableDisable(indexToggle(11,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(11,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_carelocation11" id="acuteacute_carelocation11" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists11" id="acuteacute_persists11" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>13.</td><td>Difficulty in hearing:</td><input name="acute_label_value12" id="acute_label_value12" type="hidden" value="13" /><td><select name="acuteacute_pastmonth12" id="acuteacute_pastmonth12" ><option value="no" onclick="OnEnableDisable(indexToggle(12,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(12,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected12" id="acuteacute_abilityaffected12" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation12" id="acuteacute_carelocation12" disabled="disabled" ><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists12" id="acuteacute_persists12" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>14.</td><td>Skin problems / irritation:</td><input name="acute_label_value13" id="acute_label_value13" type="hidden" value="14" /><td><select name="acuteacute_pastmonth13" id="acuteacute_pastmonth13" ><option value="no" onclick="OnEnableDisable(indexToggle(13,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(13,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected13" id="acuteacute_abilityaffected13" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation13" id="acuteacute_carelocation13" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists13" id="acuteacute_persists13" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>15.</td><td>Chest pain:</td><input name="acute_label_value14" id="acute_label_value14" type="hidden" value="15" /><td><select name="acuteacute_pastmonth14" id="acuteacute_pastmonth14" ><option value="no" onclick="OnEnableDisable(indexToggle(14,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(14,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected14" id="acuteacute_abilityaffected14" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation14" id="acuteacute_carelocation14" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists14" id="acuteacute_persists14" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>16.</td><td>Paralysis:</td><input name="acute_label_value15" id="acute_label_value15" type="hidden" value="16" /><td><select name="acuteacute_pastmonth15" id="acuteacute_pastmonth15" ><option value="no" onclick="OnEnableDisable(indexToggle(15,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(15,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected15" id="acuteacute_abilityaffected15" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation15" id="acuteacute_carelocation15" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists15" id="acuteacute_persists15" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>17.</td><td>Night sweats:</td><input name="acute_label_value16" id="acute_label_value16" type="hidden" value="17" /><td><select name="acuteacute_pastmonth16" id="acuteacute_pastmonth16" ><option value="no" onclick="OnEnableDisable(indexToggle(16,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(16,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected16" id="acuteacute_abilityaffected16" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation16" id="acuteacute_carelocation16" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists16" id="acuteacute_persists16" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>18.</td><td>Weight loss:</td><input name="acute_label_value17" id="acute_label_value17" type="hidden" value="18" /><td><select name="acuteacute_pastmonth17" id="acuteacute_pastmonth17" ><option value="no" onclick="OnEnableDisable(indexToggle(17,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(17,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected17" id="acuteacute_abilityaffected17" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation17" id="acuteacute_carelocation17" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists17" id="acuteacute_persists17" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>19.</td><td>Other pain:</td><input name="acute_label_value18" id="acute_label_value18" type="hidden" value="19" /><td><select name="acuteacute_pastmonth18" id="acuteacute_pastmonth18" ><option value="no" onclick="OnEnableDisable(indexToggle(18,acuteids,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(18,acuteids,1));">Yes</option></select>
</td><td><select name="acuteacute_abilityaffected18" id="acuteacute_abilityaffected18" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="acuteacute_carelocation18" id="acuteacute_carelocation18" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="acuteacute_persists18" id="acuteacute_persists18" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr></table></td></tr>
<tr> <td><b>Reproductive problems (Women)</b></td><td><input name="reproductive_female_nos" id="reproductive_female_nos" type="hidden" value="2" /><table border="1"><tr><td>SN</td><td></td><td>Conditions experienced in the last month</td><td>Ability affected?</td><td>Medical care sought</td><td>Still exists/persists</td></tr><tr><td>1.</td><td>Menstrual problems (pain / irregularity / heavy bleeding):</td><input name="reproductive_female_label_value0" id="reproductive_female_label_value0" type="hidden" value="20" /><td><select name="reproductive_femaleacute_pastmonth0" id="reproductive_femaleacute_pastmonth0"  class="genderfemale"><option value="no" onclick="OnEnableDisable(indexToggle(0,freproductive,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(0,freproductive,1));">Yes</option></select>
</td><td><select name="reproductive_femaleacute_abilityaffected0" id="reproductive_femaleacute_abilityaffected0" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>

</td><td><select name="reproductive_femaleacute_carelocation0" id="reproductive_femaleacute_carelocation0" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>
</td><td><select name="reproductive_femaleacute_persists0" id="reproductive_femaleacute_persists0" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr><tr><td>2.</td><td>Abnormal discharge (bad odour / change in colour):</td><input name="reproductive_female_label_value1" id="reproductive_female_label_value1" type="hidden" value="21" /><td><select name="reproductive_femaleacute_pastmonth1" id="reproductive_femaleacute_pastmonth1" class="genderfemale"><option value="no" onclick="OnEnableDisable(indexToggle(1,freproductive,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(1,freproductive,1));">Yes</option></select>

</td><td><select name="reproductive_femaleacute_abilityaffected1" id="reproductive_femaleacute_abilityaffected1" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="reproductive_femaleacute_carelocation1" id="reproductive_femaleacute_carelocation1" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>
</td><td><select name="reproductive_femaleacute_persists1" id="reproductive_femaleacute_persists1" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>

</td></tr></table></td></tr>
<tr> <td><b>Reproductive problems (Male)</b></td><td><input name="reproductive_male_nos" id="reproductive_male_nos" type="hidden" value="1" /><table border="1"><tr><td>SN</td><td></td><td>Conditions experienced in the last month</td><td>Ability affected?</td><td>Medical care sought</td><td>Still exists/persists</td></tr><tr><td>1.</td><td>Abnormal penile discharge (bad odour / change in colour):</td><input name="reproductive_male_label_value0" id="reproductive_male_label_value0" type="hidden" value="22"/><td><select name="reproductive_maleacute_pastmonth0" id="reproductive_maleacute_pastmonth0"  class="gendermale" disabled="disabled"><option value="no" onclick="OnEnableDisable(indexToggle(0,mreproductive,3));">No</option><option value="yes" onclick="OnEnableDisable(indexToggle(0,mreproductive,1));">Yes</option></select>
</td><td><select name="reproductive_maleacute_abilityaffected0" id="reproductive_maleacute_abilityaffected0" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td><td><select name="reproductive_maleacute_carelocation0" id="reproductive_maleacute_carelocation0" disabled="disabled"><option value="1">Did not seek care</option><option value="2">PHC</option><option value="3">Government Hospital</option><option value="4">Private Hospital</option><option value="5">Charitable Hospital</option><option value="6">Private Doctor (MBBS)</option><option value="7">Homoeopathic or Ayurvedic Doctor</option><option value="8">Unani</option><option value="9">Unqualified Doctor</option><option value="10">Pharmacy</option><option value="11">Other</option></select>

</td><td><select name="reproductive_maleacute_persists0" id="reproductive_maleacute_persists0" disabled="disabled"><option value="no">No</option><option value="yes">Yes</option></select>
</td></tr></table></td></tr>
<tr> <td><b>Personal illnesses</b></td><td><input name="personal_illness_nos" id="personal_illness_nos" type="hidden" value="12" /><table border="1"><tr><td>SN</td><td></td><td>Has a healthcare provider ever told you that you have?</td><td>Did you have surgery for this?</td><td>Any non-surgical treatment received?</td></tr><tr><td>1.</td><td>Heart disease:</td><input name="personal_illness_label_value0" id="personal_illness_label_value0" type="hidden" value="1" /><td><select name="personal_illnesspisp_chronic_conditions0" id="personal_illnesspisp_chronic_conditions0" ><option value="n" onclick="OnEnableDisable(indexToggle(0,personalillness,3));">No</option><option value="y"  onclick="OnEnableDisable(indexToggle(0,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery0" id="personal_illnesspisp_chronic_surgery0"  disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>

</td><td><select name="personal_illnesspisp_chronic_nonsurgical0" id="personal_illnesspisp_chronic_nonsurgical0"  disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr><tr><td>2.</td><td>High BP:</td><input name="personal_illness_label_value1" id="personal_illness_label_value1" type="hidden" value="2" /><td><select name="personal_illnesspisp_chronic_conditions1" id="personal_illnesspisp_chronic_conditions1" ><option value="n" onclick="OnEnableDisable(indexToggle(1,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(1,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery1" id="personal_illnesspisp_chronic_surgery1"  disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td><td><select name="personal_illnesspisp_chronic_nonsurgical1" id="personal_illnesspisp_chronic_nonsurgical1"  disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr><tr><td>3.</td><td>Diabetes / High blood sugar:</td><input name="personal_illness_label_value2" id="personal_illness_label_value2" type="hidden" value="3" /><td><select name="personal_illnesspisp_chronic_conditions2" id="personal_illnesspisp_chronic_conditions2" ><option value="n" onclick="OnEnableDisable(indexToggle(2,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(2,personalillness,1));">Yes</option><option value="d">Don't know</option></select>

</td><td><select name="personal_illnesspisp_chronic_surgery2" id="personal_illnesspisp_chronic_surgery2" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td><td><select name="personal_illnesspisp_chronic_nonsurgical2" id="personal_illnesspisp_chronic_nonsurgical2" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr><tr><td>4.</td><td>High cholesterol:</td><input name="personal_illness_label_value3" id="personal_illness_label_value3" type="hidden" value="4" /><td><select name="personal_illnesspisp_chronic_conditions3" id="personal_illnesspisp_chronic_conditions3" ><option value="n" onclick="OnEnableDisable(indexToggle(3,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(3,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery3" id="personal_illnesspisp_chronic_surgery3" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td><td><select name="personal_illnesspisp_chronic_nonsurgical3" id="personal_illnesspisp_chronic_nonsurgical3" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>

</td></tr><tr><td>5.</td><td>Liver disease:</td><input name="personal_illness_label_value4" id="personal_illness_label_value4" type="hidden" value="5" /><td><select name="personal_illnesspisp_chronic_conditions4" id="personal_illnesspisp_chronic_conditions4" ><option value="n" onclick="OnEnableDisable(indexToggle(4,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(4,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery4" id="personal_illnesspisp_chronic_surgery4" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td><td><select name="personal_illnesspisp_chronic_nonsurgical4" id="personal_illnesspisp_chronic_nonsurgical4" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr><tr><td>6.</td><td>Respiratory disease:</td><input name="personal_illness_label_value5" id="personal_illness_label_value5" type="hidden" value="6" /><td><select name="personal_illnesspisp_chronic_conditions5" id="personal_illnesspisp_chronic_conditions5" ><option value="n" onclick="OnEnableDisable(indexToggle(5,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(5,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery5" id="personal_illnesspisp_chronic_surgery5" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>

</td><td><select name="personal_illnesspisp_chronic_nonsurgical5" id="personal_illnesspisp_chronic_nonsurgical5" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr><tr><td>7.</td><td>Tuberculosis:</td><input name="personal_illness_label_value6" id="personal_illness_label_value6" type="hidden" value="7" /><td><select name="personal_illnesspisp_chronic_conditions6" id="personal_illnesspisp_chronic_conditions6" ><option value="n" onclick="OnEnableDisable(indexToggle(6,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(6,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery6" id="personal_illnesspisp_chronic_surgery6" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td><td><select name="personal_illnesspisp_chronic_nonsurgical6" id="personal_illnesspisp_chronic_nonsurgical6" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr><tr><td>8.</td><td>Cancer:</td><input name="personal_illness_label_value7" id="personal_illness_label_value7" type="hidden" value="8" /><td><select name="personal_illnesspisp_chronic_conditions7" id="personal_illnesspisp_chronic_conditions7" ><option value="n" onclick="OnEnableDisable(indexToggle(7,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(7,personalillness,1));">Yes</option><option value="d">Don't know</option></select>

</td><td><select name="personal_illnesspisp_chronic_surgery7" id="personal_illnesspisp_chronic_surgery7" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td><td><select name="personal_illnesspisp_chronic_nonsurgical7" id="personal_illnesspisp_chronic_nonsurgical7" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr><tr><td>9.</td><td>HIV / AIDS:</td><input name="personal_illness_label_value8" id="personal_illness_label_value8" type="hidden" value="9" /><td><select name="personal_illnesspisp_chronic_conditions8" id="personal_illnesspisp_chronic_conditions8" ><option value="n" onclick="OnEnableDisable(indexToggle(8,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(8,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery8" id="personal_illnesspisp_chronic_surgery8" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td><td><select name="personal_illnesspisp_chronic_nonsurgical8" id="personal_illnesspisp_chronic_nonsurgical8" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>

</td></tr><tr><td>10.</td><td>STD:</td><input name="personal_illness_label_value9" id="personal_illness_label_value9" type="hidden" value="10" /><td><select name="personal_illnesspisp_chronic_conditions9" id="personal_illnesspisp_chronic_conditions9" ><option value="n" onclick="OnEnableDisable(indexToggle(9,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(9,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery9" id="personal_illnesspisp_chronic_surgery9" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td><td><select name="personal_illnesspisp_chronic_nonsurgical9" id="personal_illnesspisp_chronic_nonsurgical9" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr><tr><td>11.</td><td>Trauma:</td><input name="personal_illness_label_value10" id="personal_illness_label_value10" type="hidden" value="11" /><td><select name="personal_illnesspisp_chronic_conditions10" id="personal_illnesspisp_chronic_conditions10" ><option value="n" onclick="OnEnableDisable(indexToggle(10,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(10,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery10" id="personal_illnesspisp_chronic_surgery10" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>

</td><td><select name="personal_illnesspisp_chronic_nonsurgical10" id="personal_illnesspisp_chronic_nonsurgical10" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr><tr><td>12.</td><td>Seizure disorder:</td><input name="personal_illness_label_value11" id="personal_illness_label_value11" type="hidden" value="12" /><td><select name="personal_illnesspisp_chronic_conditions11" id="personal_illnesspisp_chronic_conditions11" ><option value="n" onclick="OnEnableDisable(indexToggle(11,personalillness,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(11,personalillness,1));">Yes</option><option value="d">Don't know</option></select>
</td><td><select name="personal_illnesspisp_chronic_surgery11" id="personal_illnesspisp_chronic_surgery11" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td><td><select name="personal_illnesspisp_chronic_nonsurgical11" id="personal_illnesspisp_chronic_nonsurgical11" disabled="disabled"><option value="y">Yes</option><option value="n">No</option></select>
</td></tr></table></td></tr>
<tr> <td><b>Family history</b></td><td><input name="family_history_nos" id="family_history_nos" type="hidden" value="10" /><table border="1"><tr><td>SN</td><td></td><td>Conditions</td></tr><tr><td>1.</td><td>Heart disease:</td><input name="family_history_label_value0" id="family_history_label_value0" type="hidden" value="1" /><td><select name="family_historypisp_familycondition0" id="family_historypisp_familycondition0" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>

</td></tr><tr><td>2.</td><td>High BP:</td><input name="family_history_label_value1" id="family_history_label_value1" type="hidden" value="2" /><td><select name="family_historypisp_familycondition1" id="family_historypisp_familycondition1" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>
</td></tr><tr><td>3.</td><td>Diabetes / High blood sugar:</td><input name="family_history_label_value2" id="family_history_label_value2" type="hidden" value="3" /><td><select name="family_historypisp_familycondition2" id="family_historypisp_familycondition2" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>
</td></tr><tr><td>4.</td><td>High cholesterol:</td><input name="family_history_label_value3" id="family_history_label_value3" type="hidden" value="4" /><td><select name="family_historypisp_familycondition3" id="family_historypisp_familycondition3" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>

</td></tr><tr><td>5.</td><td>Liver disease:</td><input name="family_history_label_value4" id="family_history_label_value4" type="hidden" value="5" /><td><select name="family_historypisp_familycondition4" id="family_historypisp_familycondition4" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>
</td></tr><tr><td>6.</td><td>Respiratory disease:</td><input name="family_history_label_value5" id="family_history_label_value5" type="hidden" value="6" /><td><select name="family_historypisp_familycondition5" id="family_historypisp_familycondition5" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>
</td></tr><tr><td>7.</td><td>Tuberculosis:</td><input name="family_history_label_value6" id="family_history_label_value6" type="hidden" value="7" /><td><select name="family_historypisp_familycondition6" id="family_historypisp_familycondition6" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>

</td></tr><tr><td>8.</td><td>Cancer:</td><input name="family_history_label_value7" id="family_history_label_value7" type="hidden" value="8" /><td><select name="family_historypisp_familycondition7" id="family_historypisp_familycondition7" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>
</td></tr><tr><td>9.</td><td>HIV / AIDS:</td><input name="family_history_label_value8" id="family_history_label_value8" type="hidden" value="9" /><td><select name="family_historypisp_familycondition8" id="family_historypisp_familycondition8" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>
</td></tr><tr><td>10.</td><td>Seizure disorder:</td><input name="family_history_label_value9" id="family_history_label_value9" type="hidden" value="10" /><td><select name="family_historypisp_familycondition9" id="family_historypisp_familycondition9" ><option value="n">No</option><option value="y">Yes</option><option value="d">Don't know</option></select>

</td></tr></table></td></tr>
<tr> <td><b>Sexual and reproductive health</b></td><td><input name="reproductive_nos" id="reproductive_nos" type="hidden" value="1" /><table border="1"><tr><td></td><td> Sexual and reproductive health:</td></tr><input name="reproductive_label_value0" id="reproductive_label_value0" type="hidden" value="1" /><tr> <td><b>Are you aware of contraception methods?</b></td><td><select name="reproductivecontraception_aware0" id="reproductivecontraception_aware0" ><option value="y">Yes</option><option value="n">No</option></select></td></tr>
<tr> <td><b>Do you use any contraception methods?</b></td><td><select name="reproductivecontraception_use0" id="reproductivecontraception_use0" ><option value="y">Yes</option><option value="n">No</option></select></td></tr>
<tr> <td><b>Are you currently pregnant?</b></td><td><select name="reproductivepregnant0" id="reproductivepregnant0" class="pregnancy"><option value="n" onclick="OnEnableDisable(indexToggle(0,pregnantfields,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(0,pregnantfields,1));">Yes (Refer to RMHC)</option><option value="d">Don't know</option></select></td></tr>

<tr> <td><b>Are you receiving any antenatal care?</b></td><td><select name="reproductiveantenatal0" id="reproductiveantenatal0" disabled="disabled"><option value="n">No</option><option value="y">Yes</option></select></td></tr>
<tr> <td><b>How many times have you been pregnant?</b></td><td><input name="reproductivepregnancy_count0" id="reproductivepregnancy_count0" type="text" size="11" class="pregnancy"/></td></tr>
<tr> <td><b>How many children have you delivered?</b></td><td><input name="reproductivedeliver_count0" id="reproductivedeliver_count0" type="text" size="11" class="pregnancy"/></td></tr>
<tr> <td><b>Have you ever had miscarriages, abortions, or stillbirths?</b></td><td><select name="reproductivemiscarriage0" id="reproductivemiscarriage0" class="pregnancy"><option value="n"  onclick="OnEnableDisable(indexToggle(0,abortionfields,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(0,abortionfields,1));">Yes</option><option value="d" onclick="OnEnableDisable(indexToggle(0,abortionfields,3));">Don't know</option></select></td></tr>

<tr> <td><b>How many miscarriages, abortions, or stillbirths have you had?</b></td><td><input name="reproductivemiscarriage_count0" id="reproductivemiscarriage_count0" type="text" size="11" disabled="disabled"/></td></tr>
</table></td></tr>
<tr> <td><b>Smoking habits</b></td><td><input name="smoking_nos" id="smoking_nos" type="hidden" value="1" /><table border="1"><tr><td>1.</td><td> Smoking habits:</td></tr><input name="smoking_label_value0" id="smoking_label_value0" type="hidden" value="1" /><tr> <td><b>Have you ever chewed tobacco?</b></td><td><select name="smokingtobacco_past0" id="smokingtobacco_past0" ><option value="n" onclick="OnEnableDisable(indexToggle(0,chewingfields,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(0,chewingfields,1));">Yes</option></select></td></tr>
<tr> <td><b>Do you currently chew tobacco?</b></td><td><select name="smokingtobacco_current0" id="smokingtobacco_current0" disabled="disabled"><option value="n">No</option><option value="y">Yes</option></select></td></tr>

<tr> <td><b>Have you ever smoked tobacco?</b></td><td><select name="smokingsmoking_past0" id="smokingsmoking_past0" ><option value="n" onclick="OnEnableDisable(indexToggle(0,smokingeverfields,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(0,smokingeverfields,1));">Yes</option></select></td></tr>
<tr> <td><b>Do you currently smoke tobacco?</b></td><td><select name="smokingsmoking_current0" id="smokingsmoking_current0" disabled="disabled"><option value="n" onclick="OnEnableDisable(indexToggle(0,smokingcurrentfields,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(0,smokingcurrentfields,1));">Yes</option></select></td></tr>
<tr> <td><b>How soon after you wake up do you smoke your first cigarette?</b></td><td><select name="smokingsmoking_start_hr0" id="smokingsmoking_start_hr0" disabled="disabled"><option value="0">After 60 minutes</option><option value="1">31-60 minutes</option><option value="2">6-30 minutes</option><option value="3">Less than 5 minutes</option></select></td></tr>

<tr> <td><b>Do you find it difficult to refrain from smoking where it is forbidden?</b></td><td><select name="smokingsmoking_tempt0" id="smokingsmoking_tempt0"  disabled="disabled"><option value="n">No</option><option value="y">Yes</option></select></td></tr>
<tr> <td><b>Which cigarette would you most hate giving up?</b></td><td><select name="smokingcigarette_quit0" id="smokingcigarette_quit0" disabled="disabled"><option value="1">First in the morning</option><option value="0">Any other</option></select></td></tr>
<tr> <td><b>How many cigarettes do you smoke per day?</b></td><td><select name="smokingsmoking_count0" id="smokingsmoking_count0" disabled="disabled"><option value="0">10 or less</option><option value="1">11-20</option><option value="2">21-30</option><option value="3">More than 30</option></select></td></tr>

<tr> <td><b>Do you smoke more frequently during the first hours after awakening than during the rest of the day?</b></td><td><select name="smokingsmoking_frequency0" id="smokingsmoking_frequency0" disabled="disabled"><option value="n">No</option><option value="y">Yes</option></select></td></tr>
<tr> <td><b>Do you smoke even if you are so ill that you are in bed most of the day?</b></td><td><select name="smokingsmoking_ill0" id="smokingsmoking_ill0" disabled="disabled"><option value="n">No</option><option value="y">Yes</option></select></td></tr>
</table></td></tr>
<tr> <td><b>Alcohol consumption</b></td><td><input name="alcohol_nos" id="alcohol_nos" type="hidden" value="1" /><table border="1"><tr><td>SN</td><td></td><td>Have you ever consumed alcohol?</td><td>Do you currently consume alcohol?</td><td>How often do you consume more than (6 drink units for women and 8 drink units for men) on one occasion?</td><td>How often during the last year have you been unable to remember what happened the night before because you have been drinking?</td><td>How often during the last year have you failed to do what is normally expected of you because you have been drinking?</td><td>In the last year, has a relative, friend, or health worker been concerned about your drinking or suggested you cut down?</td></tr><tr><td>1.</td><td>Alcohol consumption:</td><input name="alcohol_label_value0" id="alcohol_label_value0" type="hidden" value="1" /><td><select name="alcoholalcohol_past0" id="alcoholalcohol_past0" ><option value="n" onclick="OnEnableDisable(indexToggle(0,alcoholeverfields,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(0,alcoholeverfields,1));">Yes</option></select>

</td><td><select name="alcoholalcohol_current0" id="alcoholalcohol_current0" disabled="disabled"><option value="n" onclick="OnEnableDisable(indexToggle(0,alcoholcurrentfields,3));">No</option><option value="y" onclick="OnEnableDisable(indexToggle(0,alcoholcurrentfields,1));">Yes</option></select>
</td><td><select name="alcoholalcohol_volume0" id="alcoholalcohol_volume0" disabled="disabled"><option value="0">Never</option><option value="1">Less than monthly</option><option value="2">Monthly</option><option value="3">Weekly</option><option value="4">Daily or almost daily</option></select>
</td><td><select name="alcoholalcohol_recollect0" id="alcoholalcohol_recollect0" disabled="disabled"><option value="0">Never</option><option value="1">Less than monthly</option><option value="2">Monthly</option><option value="3">Weekly</option><option value="4">Daily or almost daily</option></select>
</td><td><select name="alcoholalcohol_duty_fail0" id="alcoholalcohol_duty_fail0" disabled="disabled"><option value="0">Never</option><option value="1">Less than monthly</option><option value="2">Monthly</option><option value="3">Weekly</option><option value="4">Daily or almost daily</option></select>

</td><td><select name="alcoholalcohol_concern0" id="alcoholalcohol_concern0" disabled="disabled"><option value="0">Never</option><option value="1">Less than monthly</option><option value="2">Monthly</option><option value="3">Weekly</option><option value="4">Daily or almost daily</option></select>
</td></tr></table></td></tr>
<tr> <td><b>Height in centimetres</b></td><td><input name="height" id="height" type="text" size="11" /> cm</td></tr>
<tr> <td><b>Weight in kilograms</b></td><td><input name="weight" id="weight" type="text" size="11" /> kg</td></tr>
<tr> <td><b>Waist circumference in centimetres</b></td><td><input name="wc" id="wc" type="text" size="11" /> cm</td></tr>
<tr> <td><b>Visual acuity - Right eye</b></td><td><select name="va_right" id="va_right" ><option value="6">6/6</option><option value="5">5/6</option><option value="4">4/6</option><option value="3">3/6</option><option value="2">2/6</option><option value="1">1/6</option><option value="7">CF</option><option value="8">HM</option><option value="9">Blind</option></select></td></tr>

<tr> <td><b>Visual acuity - Left eye</b></td><td><select name="va_left" id="va_left" ><option value="6">6/6</option><option value="5">5/6</option><option value="4">4/6</option><option value="3">3/6</option><option value="2">2/6</option><option value="1">1/6</option><option value="7">CF</option><option value="8">HM</option><option value="9">Blind</option></select></td></tr>
</table>

Language of report
<input type="radio" name="language" value="english" checked> English
<input type="radio" name="language" value="tamilcode"> Tamil
<input type="radio" name="language" value="hindicode"> Hindi
<input type="radio" name="language" value="oriyacode"> Oriya
<input type="submit" name="submit_edit"  value="Get Report" class="submit" /input> 
<form>
<center>

				</form>
		</div>
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>

		</div>
		</div>
		</td>
	</tr>
</table>
</body>
</html>

<?php $this->load->view('common/footer.php'); ?>
