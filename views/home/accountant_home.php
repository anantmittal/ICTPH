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

<!--
<?php if (isset($filename))
	{
	?>
	<tr>
   <td colspan="2" > <a href="<?php echo $this->config->item('base_url').$filename;?>"> A <?php echo $filetype;?> file has been created. Click here to download. </a> </td>
       </tr>
   <?php } ?>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/provider/create_visit_report';?>">Create Visit Summary Report</a>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/scm/product/stock_report';?>">Create Stock Report</a>
</td> </tr>

-->
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/index';?>">Reports</a>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/admin/user_management/change_password">Change Password</a>
</tr> </td>


<tr> <td>
<a href="<?php echo $this->config->item('base_url');?>index.php/session/session/logout">Logout</a>
</tr> </td>

</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>
