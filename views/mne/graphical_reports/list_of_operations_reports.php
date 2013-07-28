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

<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/avg_time_visit_chart';?>">1. Average time taken for each visit report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/avg_time_pisp_chart';?>">2. Average time taken for each pisp report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/avg_patient_visit_chart';?>">3. Average number of patients report.</a>
</td>
</tr>

<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/avg_bill_amounts_chart';?>">4. Average bill amounts per patient report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/cost_med_serv_tests_chart';?>">5. Cost of medication/services/lab tests dispensed/conducted report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/avg_cost_med_serv_tests_chart';?>">6. Average Cost of medication/services/lab tests dispensed/conducted per visit report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/diagnostic_tests_billed_free_chart';?>">7. Diagnostic tests split by billed vs free report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/number_new_cards_chart';?>">8. Number of new cards created in each clinic report.</a>
</td>
</tr>

<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/opd_products_chart';?>">9. Split of opd products report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/repeated_visits_chart';?>">10. Repeated number of visits report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/number_patients_by_doctor_chart';?>">11. Number OF Patients Seen By Each Doctor Report.</a>
</td>
</tr>
<tr> <td> <a href="<?php echo $this->config->item('base_url').'index.php/mne/graphical_reports/inventory_consumed_chart';?>">12. Inventory consumed in Clinics Report.</a>
</td>
</tr>

</table>

<?php $this->load->view('common/footer.php'); ?>
