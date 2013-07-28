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
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/diagnosis_chart';?>">1. Split by diagnosis Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/chief_complaints_chart';?>">2. Split by chief complaints Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/gender_distribution_chart';?>">3. Split by gender distribution Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/eye_diagnosis_chart';?>">4. Split by eye diagnosis Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/age_distribution_chart';?>">5. Split by age distribution Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/age_distribution_by_diagnosis_cc_chart';?>">6. Split by age distribution by diagnosis/chief complaints Report.</a>
</td>
</tr>

<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/diagnosis_system_chart';?>">7. Split of diagnosis by system names Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/gender_distribution_by_diagnosis_cc_chart';?>">8. Split of gender distribution by diagnosis/chief complaints Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/risk_factor_one_chart';?>">9. CVD Risk Factor Aggregation Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/risk_factor_two_chart';?>">10. Count of CVD Risk Factor Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/risk_factor_combination_chart';?>">11. Risk Factors Combination Report.</a>
</td>
</tr>
</table>

<?php $this->load->view('common/footer.php'); ?>
