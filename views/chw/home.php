<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>CHW Home Page</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<table align="center" width="70%" border="1" cellpadding="5" class="main_table">
<tr> <td colspan=2><h3>Message: <?php echo $this->session->userdata('msg');?></h3></td></tr>
<ul>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/create';?>">Add a CHW</a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/chw/chw/edit_';?>" method="POST">
Enter CHW id <input type="text" name="id_edit" /input> 
<input type="submit" name="submit_edit"  value="Edit CHW details" class="submit" /input> 
</form>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/search_by_name/ALL';?>">Add a Group</a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/chw/chw_group/view';?>" method="POST">
Enter CHW Group id <input type="text" name="id_list" /input> 
<input type="submit" name="submit_edit"  value="View CHW Group details" class="submit" /input> 
</form>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/chw/training_module/add';?>">Add a Training Module</a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/chw/training_module/edit_';?>" method="POST">
Enter Training Module id <input type="text" name="tmid_edit" /input> 
<input type="submit" name="submit_edit"  value="Edit Training Module details" class="submit" /input> 
</form>
</td> </tr>


<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/chw/health_product/add';?>">Add a Health Product</a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/chw/health_product/edit_';?>" method="POST">
Enter Health Product id <input type="text" name="hid_edit" /input> 
<input type="submit" name="submit_edit"  value="Edit Health Product details" class="submit" /input> 
</form>
</td> </tr>

<tr> <td>
<form action = "<?php echo $this->config->item('base_url').'index.php/chw/test/add';?>" method="POST">
Name of Test  <input type="text" name="test_name" /input> </td>
<td>Description of Test<input type="text" name="test_desc" /input> 
<input type="submit" name="submit_test"  value="Add Test" class="submit" /input> 
</form>
</td>

<!--
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/chw/test/edit';?>" method="POST">
Old Name <input type="text" name="test_old" /input> 
New Name <input type="text" name="test_new" /input> 
<input type="submit" name="submit_test_edit"  value="Change Test Name" class="submit" /input> 
</form>
</td> -->
</tr>

<tr> <td>
<form action = "<?php echo $this->config->item('base_url').'index.php/chw/dissemination/add';?>" method="POST">
Name of Dissemination<input type="text" name="c_name" /input> </td> <td>
Description of Dissemination<input type="text" name="c_desc" /input> 
<input type="submit" name="submit_dissemination"  value="Add Dissemination" class="submit" /input> 
</form>
</td>
<!--
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/chw/dissemination/edit';?>" method="POST">
Old Name <input type="text" name="c_old" /input> 
New Name <input type="text" name="c_new" /input> 
<input type="submit" name="submit_c_edit"  value="Change Dissemination Name" class="submit" /input> 
</form>
</td>-->
</tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/plsp/search/home';?>">PLSP Home</a>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/index';?>">Reports</a>
</td> </tr>

</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>
