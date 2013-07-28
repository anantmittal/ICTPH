<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>Survey Home Page</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<table align="center" width="70%" border="1" cellpadding="5">
<tr> <td colspan=2><h3>Message: <?php echo $this->session->userdata('msg');?></h3></td></tr>
<ul>

<?php if (isset($filename))
	{
	?>
	<tr>
   <td colspan="2" > <a href="<?php echo $this->config->item('base_url').$filename;?>"> A file has been created. Click here to download. </a> </td>
       </tr>
   <?php } ?>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/survey/create';?>">Create a Survey</a>
</td>
</tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/form/define/Yes';?>">Define a Sub-Form / Form Table / Form Module</a>
</td>
</tr>


<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/form/define/No';?>">Define a Form</a>
</td>
</tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/form/assign';?>">Assign Form to a Survey</a>
</td>
</tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/survey/list_';?>">List Surveys</a>
</td>
</tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/form/list_';?>">List Forms and Form Modules</a>
</td>
</tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/survey/create_run';?>">Create a Survey Run</a>
</td></tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/form/select_form_run';?>">Enter data in a Form for a Survey Run</a>
</td></tr>
<!--
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/opd/provider/edit_';?>" method="POST">
Enter Doctor id <input type="text" name="dr_id_edit" /input> 
<input type="submit" name="submit_edit"  value="Edit Doctor details" class="submit" /input> 
</form>
</td> </tr>
-->


</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>
