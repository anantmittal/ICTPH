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
<ul>

<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/diagnosis">Visit Document Configuration</a>
</tr> </td>
<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/admin/consumables_configuration/add_service/">Consumables Configuration</a>
</tr> </td>
</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>
