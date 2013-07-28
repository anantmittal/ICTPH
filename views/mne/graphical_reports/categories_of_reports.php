<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>Report Home Page</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<table align="center" width="70%" border="1" cellpadding="5">
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/med_research_home';?>">1. Medical/Research Reports.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/operations_home';?>">2. Operations Reports.</a>
</td>
</tr>

</table>

<?php $this->load->view('common/footer.php'); ?>
