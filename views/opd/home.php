<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>OPD Home Page</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<table align="center" width="70%" border="1" cellpadding="5" class="main_table">
<tr> <td colspan=2><h3>Message: <?php echo $this->session->userdata('msg');?></h3></td></tr>
<ul>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/location/create';?>">Add a Provider Location - Clinic, Hospital, Lab</a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/opd/location/edit_';?>" method="POST">
Enter Clinic id <input type="text" name="c_id_edit" /input> 
<input type="submit" name="submit_edit"  value="Edit Clinic details" class="submit" /input> 
</form>
</td> </tr>

<!--
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/opd/provider/assign_location';?>" method="POST">
Enter Provider id <input type="text" name="p_id_assign" /input> 
<input type="submit" name="submit_assign"  value="Assign Location to Provider" class="submit" /input> 
</form>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/opd/location/assign_doctor';?>" method="POST">
Enter Location id <input type="text" name="l_id_assign" /input> 
<input type="submit" name="submit_assign"  value="Assign Provider to Location" class="submit" /input> 
</form>
</td>
-->

</tr>
<!--
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/product/add';?>">Add a Product (Drug) </a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/opd/product/edit_';?>" method="POST">
Enter Product (Drug) id <input type="text" name="p_id_edit" /input> 
<input type="submit" name="submit_edit"  value="Edit Product (Drug) details" class="submit" /input> 
</form>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/product/add_batch';?>">Add a Product Batch Received </a>
</td>
</tr>
-->
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/test/add';?>">Add a Test (Diagnostic) </a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/opd/test/edit_';?>" method="POST">
Enter Test (Diagnostic) id <input type="text" name="t_id_edit" /input> 
<input type="submit" name="submit_edit"  value="Edit Test (Diagnostic) details" class="submit" /input> 
</form>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/provider/create_visit_report';?>">Create Visit Report </a>
</td>
</tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/index';?>">Reports</a>
</td> </tr>


</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>
