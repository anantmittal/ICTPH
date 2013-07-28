<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>OPD Home Page</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>
</br>
<table align="center" width="70%" border="1" cellpadding="5">
<caption><center><h3>Household Member Details</h3></center></caption>
<tr>
	<th>Individual ID</th>
	<th>Full Name</th>
	<th>Gender</th>
	<th>Relation</th>
	<th>Age</th>
	<th>PLSP</th>
	<th>Action</th>
</tr>
<?php foreach($individuals as $household_member):?>
	<tr>
	<td><?php echo $household_member['individual_id'];?></td>
	<td><?php echo $household_member['full_name'];?></td>
	<td><?php echo $household_member['gender'];?></td>
	<td><?php echo $household_member['relation'];?></td>
	<td><?php echo $household_member['age'];?></td>
	<td><?php echo isset($household_member['plsp'])?("View Report (<a href=\"".$this->config->item('base_url')."index.php/plsp/report/display_report/".$household_member['individual_id']."/english/pdf\">English</a>,<a href=\"".$this->config->item('base_url')."index.php/plsp/report/display_report/".$household_member['individual_id']."/tamilcode/html\">Tamil</a>)"):"Report not available";?></td>
	<td><?php echo isset($household_member['plsp_status'])?("<a href=\"".$this->config->item('base_url')."index.php/plsp/report/edit_report_by_person_id/".$household_member['individual_id']."\">Correct Errors</a>"):"Report not available";?></td>
	</tr>
<?php endforeach;?>
</table>
<table align="center" width="70%" border="1" cellpadding="5">
	<td>
	<?php echo "<a href=\"".$this->config->item('base_url')."index.php/admin/enrolment/search_policy_by_id/opd/".$policy_id."\">View Policy</a>";?>
	</td>
	<td>Consolidated Report (
	<?php echo "<a href=\"".$this->config->item('base_url')."index.php/plsp/report/household_report/".$hhid."/english/pdf\">English</a>";?> , 
	<?php echo "<a href=\"".$this->config->item('base_url')."index.php/plsp/report/household_report/".$hhid."/tamilcode/html\">Tamil</a>";?>
	)
	</td>
	<td>
	<?php echo "<a href=\"".$this->config->item('base_url')."index.php/plsp/queryhhform/printable_top_sheet/".$hhid."\">Printable Top Sheet</a>";?>
	</td>
</table>
</br>

<?php $this->load->view('common/footer.php'); ?>
