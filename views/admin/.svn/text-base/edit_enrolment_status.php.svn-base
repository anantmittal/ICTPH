
<?php $this->load->helper('form');
	  $this->load->library('date_util');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>

<title>Update Enrolment Status</title>

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
    	  <div class="green_middle"><span class="head_box">Update Enrolment Status</span></div></div></div>
    
<div class="green_body">


<form action="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/update_policy_status/'.$current_rec->policy_id; ?>" method="POST">


<?php echo validation_errors(); ?>

 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
   <tr>
     <td>Policy Id</td>
     <td> <?php echo $current_rec->policy_id; ?> </td> 
     <td>Staff Id</td>
     <td> <?php echo $current_rec->staff_id; ?> </td>
   </tr>

   <tr>
     <td>Form number</td>
     <td> <?php echo $current_rec->id; ?> </td> 
     <td>Form Date</td>
     <td> <?php echo Date_util::date_display_format($current_rec->form_date); ?> </td>
   </tr>

   <tr>
     <td>Receipt number</td>
     <td> <?php echo $current_rec->receipt_number; ?> </td>
     <td>Receipt Date</td>
     <td> <?php echo Date_util::date_display_format($current_rec->receipt_date); ?> </td>
   </tr>

   <tr>
     <td>Total Premium </td>
     <td> <?php echo $current_rec->amount; ?> </td>
     <td>Total Received </td>
     <td> <?php echo $current_rec->amount_collected; ?> </td>
   </tr>

   <tr class="row">
     <td>ID card delivered to Member or Not</td>
     <td>
        <input type="radio" name="idcard_status" value="1" <?php if($current_rec->idcard_status==1){echo 'checked';} ?> >Yes</input>
        <input type="radio" name="idcard_status" value="0"<?php if($current_rec->idcard_status==0){echo 'checked';} ?> >No</input>
     </td>
     <td>Date when delivered to Member</td>
     <td>
       <input name="date_of_submission" id="date_of_submission" type="text" value="<?php echo Date_util::date_display_format($current_rec->date_of_submission);?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
<!--     <td><input type="text" name="date_of_submission_dd" value="DD" size=2 maxlength=2 />
     <input type="text" name="date_of_submission_mm" value="MM" size=2 maxlength=2 />
     <input type="text" name="date_of_submission_yy" value="YYYY" size=2 maxlength=4 /></td> -->
   </tr>

   <tr class="row">
     <td>Policy Material delivered to Member or Not</td>
     <td>
        <input type="radio" name="pm_status" value="1" <?php if($current_rec->policy_material_status==1){echo 'checked';} ?> >Yes</input>
        <input type="radio" name="pm_status" value="0" <?php if($current_rec->policy_material_status==0){echo 'checked';} ?> >No</input>
     </td>
     <td>Ack receieved from Member or Not</td>
     <td>
        <input type="radio" name="ack" value="1" <?php if($current_rec->ack==1){echo 'checked';} ?> >Yes</input>
        <input type="radio" name="ack" value="0" <?php if($current_rec->ack==0){echo 'checked';} ?> >No</input>
     </td>
   </tr>

   <tr class="row">
     <td>Backend Policy Issued</td>
     <td>
        <input type="radio" name="backend_status" value="1" <?php if($current_rec->backend_issued==1){echo 'checked';} ?> >Yes</input>
        <input type="radio" name="backend_status" value="0" <?php if($current_rec->backend_issued==0){echo 'checked';} ?> >No</input>
     </td>
     <td>Backend Policy date</td>
     <td>
       <input name="backend_date" id="backend_date" type="text" value="<?php echo Date_util::date_display_format($current_rec->backend_policy_issuedate);?>" class="datepicker check_dateFormat"  style="width:140px;"  />
     </td>
<!--     <td><input type="text" name="backend_date_dd" value="DD" size=2 maxlength=2 />
     <input type="text" name="backend_date_mm" value="MM" size=2 maxlength=2 />
     <input type="text" name="backend_date_yy" value="YYYY" size=2 maxlength=4 /></td> -->
  </tr>

   <tr class="row">
     <td>Backend Policy type</td>
     <td><input type="text" name="backend_type" value="<?php echo $current_rec->backend_policy_type; ?>"/></td>
     <td>Backend Policy id</td>
     <td><input type="text" name="backend_id"value="<?php echo $current_rec->backend_policy_number; ?>"/></td>
  </tr>
	<tr>
     <td>Backend Member id</td>
     <td><input type="text" name="backend_member_id"value="<?php echo $current_rec->backend_member_id; ?>"/></td>
     <td>
    <div class="form_row">
      <div class="form_newbtn"><input type="submit" name="submit" id="button" value="Submit" class="submit"/></div>
    </div>
     </td>
	</tr>
  </table>
    
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
