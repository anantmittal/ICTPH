<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>Sughavazhvu</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<table align="center" width="70%" border="1" cellpadding="5" class="main_table">
<tr> <td><h3>Message: <?php echo $this->session->userdata('msg');?></h3></td></tr>
<ul>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/enroll_new_member';?>">Add a New Health Member</a>
</tr> </td>

<tr> <td>
<form action = "<?php echo $this->config->item('base_url').'index.php/admin/enrolment/add_member';?>" method="POST">
Enter Household Id <input type="text" name="id_add" /input> 
<input type="submit" name="submit_add"  value="Add New Member" class="submit" /input> 
</form>
</tr> </td>


<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/admin/enrolment/search_policies_by_date">Search Policies by Date</a>
</tr> </td>

<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/admin/enrolment/create_insurance_csv">Create Insurance File</a>
</tr> </td>

<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/admin/enrolment/create_report_csv">Create Report File</a>
</tr> </td>

<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/admin/enrolment/create_enrollment_csv">Create Enrollment File</a>
</tr> </td>
<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/admin/enrolment/create_idcard">Create Idcard File</a>
</tr> </td>
<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/admin/enrolment/create_sgv_idcard">Create SGV Idcard File</a>
</tr> </td>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/create_voucher';?>">Create Barcoded Voucher or ID Card</a>
</td> </tr>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/create_risk_card';?>">Create Risk cards for the Interventions</a>
</td> </tr>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/import_enrolment_data';?>">Import Enrolment Data</a>
</td> </tr>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/index';?>">Reports</a>
</td> </tr>

</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>
