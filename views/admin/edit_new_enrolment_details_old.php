<?php $this->load->helper('form');
	  $this->load->library('Date_util');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<title>Enrolment Form </title>

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
    	  <div class="green_middle"><span class="head_box">Enroll Family</span></div></div></div>
    
<div class="green_body">

<form action="<?php if($action=="add") { echo $this->config->item('base_url').'index.php/admin/enrolment/enroll_new_household_members/'.$household->id.'/'.$action; } else {  echo $this->config->item('base_url').'index.php/admin/enrolment/enroll_new_household_members/'.$policy_number.'/'.$action;} ?>" method="POST">

<?php echo validation_errors(); ?>

 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
<tr>
   <?php if($policy_number != NULL){ echo '<td> Policy Number </td> <td> '.$policy_number.' </td>  <input type="hidden" name="policy_number" value="'.$policy_number.'"> ';} ?> 
     <td>Expiry Date (DD/MM/YYYY)</td>
     <td>
  <input name="expiry_date" id="expiry_date" type="text" value="<?php echo $expiry_date;?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
</tr>
   <tr>
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

   <tr>
     <td>Receipt number</td>
     <td><input type="text" name="receipt_number" value="<?php echo $receipt_number; ?>"/>
     <td>Receipt Date (DD/MM/YYYY)</td>
     <td>
  <input name="receipt_date" id="receipt_date" type="text" value="<?php echo $receipt_date;?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
<!--     <td>
	<input type="date" value="<?php echo substr($receipt_date,-2); ?>" name="receipt_date_dd" size=2 maxlength=2  />
	<input type="date" value="<?php echo substr($receipt_date,5,2); ?>" name="receipt_date_mm" size=2 maxlength=2  />
	<input type="date" value="<?php echo substr($receipt_date,0,4); ?>" name="receipt_date_yy" size=2 maxlength=4 />
	</td> -->
   </tr>

   <tr class="row">
     <td>Member ID</td>
    <td><?php echo $household->id; ?></td>
     <td>Member Address</td>
    <td><?php echo $street_address; ?></td>
<!--    <td><?php echo $household->street_address; ?></td> -->
   </tr>

   <tr class="row">
     <td>SHG Member</td>
     <td>
        <input type="radio" name="is_shg" value="Yes" <?php if($is_shg=="Yes"){echo "checked";} ?> >Yes</input>
        <input type="radio" name="is_shg" value="No" <?php if($is_shg=="No"){echo "checked";} ?> >No</input>
     </td>
   </tr>

   <tr class="row">
     <td>HMF Member</td>
     <td>
        <input type="radio" name="is_hmf" value="Yes" <?php if($is_hmf=="Yes"){echo "checked";} ?> >Yes</input>
        <input type="radio" name="is_hmf" value="No" <?php if($is_hmf=="No"){echo "checked";} ?> >No</input>
     </td>
     <td>Contact Number</td>
     <td><input type="text" name="contact_number" value="<?php echo $contact_number;?>"/></td>
   </tr>


   <tr class="row">
     <td>BPL</td>
     <td>
        <input type="radio" name="is_bpl" value="Yes" <?php if($is_bpl=="Yes"){echo "checked";} ?> >Yes</input>
        <input type="radio" name="is_bpl" value="No" <?php if($is_bpl=="No"){echo "checked";} ?> >No</input>
     </td>
     <td>BPL Card number</td>
     <td><input type="text" name="bpl_card_number" value="<?php echo $bpl_card_number;?>"/></td>
   </tr>

</table>

 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
   <tr class="head">
     <td>SNo</td>
     <td>Name</td>
     <td>Pre-Existing</td>
     <td>Gender</td>
     <td>Date of birth</td>
     <td>Relation</td>
     <td>Blood Group</td>
<!--     <td>RH Factor</td> -->
   </tr>

<?php 
  $i = 0;
  foreach ($members as $member) {
  ?>
  <tr class="row">
    <td width="4%"> <?php echo ($i + 1)."."; ?> </td>
    <td width="25%" > <?php echo $member->full_name; ?> </td>
    <td width="26%" > <?php echo $member->addictions; ?> </td>
    <td width="5%"> <?php echo $member->gender ?></td>
    <td width="10%"> <?php echo Date_util::date_display_format($member->date_of_birth) ?></td>
    <td width="10%"> <?php echo $member->relation ?></td>
    <td width="10%"> <?php echo $member->blood_group ?></td>
<!--    <td width="10%"> <?php echo $member->rh_factor ?></td> -->
  </tr>
<?php $i++; } ?>
  </table>

   <tr class="row">
     <td>Enrollment Staff</td>
     <td><?php echo form_dropdown("staff", $staff_list, $staff_id, 'class="bigselect"'); ?></td>
     <td>Product</td>
     <td><?php echo form_dropdown("policy_type", $policy_type_list, $scheme_id, 'class="bigselect"'); ?></td>
      <td>Total Amount</td>
      <td><input type="text" name="amount" value="<?php echo $amount;?>" /></td>
      <td>Amount Collected</td>
      <td><input type="text" name="amount_collected" value="<?php echo $amount_collected;?>" /></td>
    </tr>
  </table>

    <div class="form_row">
      <div class="form_newbtn"><input type="submit" name="submit" id="button" value="Submit" class="submit"/></div>
    </div>
    
  </div>
  <div class="bluebtm_left" >
    <div class="bluebtm_right">
      <div class="bluebtm_middle"></div>
    </div>
  </div>

</form>
		  
<br class="spacer" /></div>
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>
