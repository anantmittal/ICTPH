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
<a href="<?php echo $this->config->item('base_url').'index.php/hospitalization/hospital_management/add_hospital';?>">Add Hospital</a>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/hospitalization/hospital_management/list_hospitals';?>">List Hospitals</a>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/hospitalization/hospital_management/show_hospital_dues';?>">Show Hospital Dues</a>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/index';?>">Reports</a>
</td> </tr>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/hospitalization/hospital_management/edit_hospital_';?>" method="POST">
Enter Hospital id <input type="text" name="hosp_id_edit" /input> 
<input type="submit" name="submit_edit"  value="Edit Hospital details" class="submit" /input> 
</form>
</td> </tr>

</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>
