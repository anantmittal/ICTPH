<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Update Blood Group of Enrolled Members </title>

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
width:550px;
margin:auto;
border:#000000 1px solid;
}
.mainhead{background-color : #aaaaaa;}
.tablehead{background-color : #d7d7d7;}
.row{   background-color : #e7e7e7;}
.data_table tr{
	font-size:11px;
	height:25px;
	background-color:#e8e8e8;
}

.largeselect {   width:200px; }

</style>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<!--Main Page-->
<div id="main">

  <div class="hospit_box">

<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Updating Blood Group</span></div></div></div>
          <div class="green_body">


    <?php echo form_open_multipart('demographic/family/add_blood_group/'.$household_id);?>
    <input type="hidden" name="family_id" value="<?php echo $household_id;?>">

<table width="600" border="0" align="center" cellpadding="0" cellspacing="2" class="data_table">
   <tr class="head">
     <td>SNo</td>
     <td>Name</td>
     <td>Blood Group</td>
<!--     <td>RH Factor</td> -->
   </tr>
  <?php 
  $i = 0;
  foreach ($members as $member) {
  ?>
  <tr>
    <td width="4%"> <?php echo ($i + 1)."."; ?> </td>
    <td width="67%" <?php if($i % 2 == 0 ) echo 'class="row"'; ?> > <?php echo $member->full_name; ?> <input type="hidden" name="member_id[<?php echo $i; ?>]" value="<?php echo $member->id;?>"> </td>
    <td width="29%">
     <?php echo form_dropdown('member'.$i.'_blood_group', $bgs, $member->blood_group, 'class="bigselect"'); ?>
    </td>
<!--    <td width="29%">
      <input type="radio" name="member<?php echo $i;?>_blood_group" value="A">A</input>
      <input type="radio" name="member<?php echo $i;?>_blood_group" value="B">B</input>
      <input type="radio" name="member<?php echo $i;?>_blood_group" value="AB">AB</input>
      <input type="radio" name="member<?php echo $i;?>_blood_group" value="O">O</input>
    </td>
    <td width="20%">
      <input type="radio" name="member<?php echo $i;?>_rh_factor" value="+ve">+ve</input>
      <input type="radio" name="member<?php echo $i;?>_rh_factor" value="-ve">-ve</input>
    </td> -->
  </tr>
<?php $i++; } ?>
</table>


<br/>
<table align="center" >
<tr>
<td width="50%" align="center">
<td width="50%" align="center"><input type="submit" value="submit" name="submit_btn" class="submit"/></td>
 </tr>
</table>
    
</form>
    <br class="spacer" /></div>
    <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div></div>
</div>
<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
