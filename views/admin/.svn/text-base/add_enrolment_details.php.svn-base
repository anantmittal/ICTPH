<?php $this->load->helper('form');
      $this->load->library('date_util');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title>Enrolment Form </title>

</head>

<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<!--Main Page-->
<div id="main">

  <div class="hospit_box">

<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Enroll Family</span></div></div></div>
    
<div class="green_body">

<form action="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/enroll_new_household_members/'.$household_id.'/'.$action; ?>" method="POST">

<?php echo validation_errors(); ?>

 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
   <tr class="row">
     <td>Form number</td>
     <td><input type="text" name="form_number" value="<?php echo $form_number; ?>" />
     <td>Form Date (DD/MM/YYYY) </td>
     <td>
       <input name="form_date" id="form_date" type="text" value="<?php echo $form_date;?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
<!--     <td>
	<input type="date" name="form_date_dd" value="<?php echo substr($form_date,-2); ?>" size=2 maxlength=2 />
	<input type="date" name="form_date_mm" value="<?php echo substr($form_date,5,2); ?>" size=2 maxlength=2 />
	<input type="date" name="form_date_yy" value="<?php echo substr($form_date,0,4); ?>" size=2 maxlength=4 />
	</td> -->
   </tr>

   <tr class="row">
     
     <td>Contact number</td>
     <td><input type="text" name="contact_number" value="<?php echo $contact_number; ?>"/>
   </tr>
<!-- ALA
   <tr class="row">
     <td>Street Address</td>
     <td><input type="text" name="street_address" value="<?php echo $street_address;?>"/></td>
     <td>Area<?php echo form_dropdown("add_area", $areas, '', 'class="bigselect"'); ?></td>
   </tr> -->
   <tr class="row">
     <td>Village <?php echo form_dropdown("add_village", $villages, '', 'class="bigselect"'); ?></td>
     <td>Taluka <?php echo form_dropdown("add_taluka", $talukas, '', 'class="bigselect"'); ?></td>
     <td> District <?php echo form_dropdown("add_district", $districts, '', 'class="bigselect"'); ?></td>
   </tr>

   <tr class="row">
     <td>Is SHG Member
     </td> <td>
        <input type="radio" name="is_shg" value="Yes">Yes</input>
        <input type="radio" name="is_shg" value="No">No</input>
     </td>
     <td>BPL
        <input type="radio" name="is_bpl" value="Yes">Yes</input>
        <input type="radio" name="is_bpl" value="No">No</input>
     </td>
     <td>BPL Card number
     <input type="text" name="bpl_card_number" value="<?php echo $bpl_card_number;?>"/></td>
   </tr>

   <tr class="row">
     <td>Product</td>
     <td><?php echo form_dropdown("policy_type", $policy_type_list, '', 'class="bigselect"'); ?></td>
     <td>Is HMF Member
        <input type="radio" name="is_hmf" value="Yes">Yes</input>
        <input type="radio" name="is_hmf" value="No">No</input>
     </td>
     <td>Family Size
     <input type="text" name="no_of_lives" size=2 maxlength=2 value="<?php echo $no_of_lives;?>"/></td>
   </tr>

   <tr class="row">
     <td>Receipt Date (DD/MM/YYYY)</td>
     <td>
  <input name="receipt_date" id="receipt_date" type="text" value="<?php echo $receipt_date;?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
<!--     <td>
	<input type="date" value="<?php echo substr($receipt_date,-2); ?>" name="receipt_date_dd" size=2 maxlength=2  />
	<input type="date" value="<?php echo substr($receipt_date,5,2); ?>" name="receipt_date_mm" size=2 maxlength=2  />
	<input type="date" value="<?php echo substr($receipt_date,0,4); ?>" name="receipt_date_yy" size=2 maxlength=4 />
	</td> -->
     <td>Enrollment Staff</td>
     <td><?php echo form_dropdown("staff", $staff_list, '', 'class="bigselect"'); ?></td>
   </tr>


</table>

 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
   <tr class="head">
     <td>SNo</td>
     <td>Name</td>
     <td>Pre-existing</td>
     <td>Gender</td>
     <td>Date of birth</td>
     <td>Relation</td>
     <td>Blood Group</td>
<!--     <td>RH Factor</td> -->
   </tr>

<?php 
  $i = 0;
//  foreach ($members as $member) {
//  for ($i=0, $i < 7, $i++) {
  while( $i < 7 ) {
  ?>
  <tr class="row">
    <td width="2%"> <?php echo ($i + 1)."."; ?> </td>
    <td width="30%"> 
       <input type="text" name="member<?php echo $i;?>_name" size= 35 value="" /> 
    </td>

    <td width="34%">
     <?php echo form_dropdown('member'.$i.'_ped', $peds, '', 'class="bigselect"'); ?>
      <input type="text" name="member<?php echo $i;?>_ped_other" size=14 value="" />
    </td>

    <td width="6%">
      <input type="radio" name="member<?php echo $i;?>_gender" value="M">M</input>
      <input type="radio" name="member<?php echo $i;?>_gender" value="F">F</input>
    </td>

    <td width="10%">
      <input type="text" name="member<?php echo $i;?>_dob" value="DD/MM/YYYY" size=8 maxlength=10 />
    </td>

    <td width="9%">
     <?php echo form_dropdown('member'.$i.'_relation', $relations, '', 'class="bigselect"'); ?>
    </td>

    <td width="9%">
     <?php echo form_dropdown('member'.$i.'_bg', $bgs, '', 'class="bigselect"'); ?>
    </td>
<!--    <td width="12%">
     <?php echo form_dropdown('member'.$i.'_rhf', $rhfs, '', 'class="bigselect"'); ?>
    </td> -->
  </tr>
<?php $i++; } ?>
  </table>

<table>
   <tr class="row">
      <td>Total Amount</td>
      <td><input type="text" name="amount" size=5 maxlength=5 value="<?php echo $amount;?>" /></td>
      <td>Discount</td>
      <td><input type="text" name="discount" size=5 maxlength=5 value="<?php echo $discount;?>" /></td>
      <td>Amount Collected</td>
      <td><input type="text" name="amount_collected" size=5 maxlength=5 value="<?php echo $amount_collected;?>" /></td>
     <td>Receipt number</td>
     <td><input type="text" name="receipt_number" value="<?php echo $receipt_number; ?>"/>
     <td>Expiry Date</td>
     <td>
  <input name="expiry_date" id="expiry_date" type="text" value="<?php echo $expiry_date;?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
    </tr>
  </table>

    <div class="form_row">
      <div class="form_newbtn"><input type="submit" name="submit" id="button" value="Submit" class="submit"/></div>
    </div>
    
  </div>
</form>
		  
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
