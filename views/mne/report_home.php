<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>Monitoring and Evaluation Home Page</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<table align="center" width="70%" border="1" cellpadding="5">
<tr> <td colspan=2><h3>Message: <?php echo $this->session->userdata('msg');?></h3></td></tr>
<ul>

<?php if($allow_define) { ?>
<tr> <td >
<a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/define';?>">Define a SQL Report</a>
</td>
<?php } ?>

<?php
if(isset($reports))
{
//echo 'num reports '.$num_reports;
	foreach($reports as $key=>$val)
	{?>
		<tr> <td>
		<div style="float:left"><a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/generate/'.$key;?>">Run <?php echo $val;?>  Report</a></div>
		<?php if($allow_define) { ?>
		<div style="float:right"><a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/edit_report/'.$key;?>">Edit </a></div><?php }?>
		</td>
		
		<!-- Edit Report-->
		<!-- <td align="right">
		
		</td> -->

<?php	}
}?>
<!--
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/form/define';?>">Define a Form</a>
</td>


<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/form/define';?>">Add a Survey and Define Forms</a>
</td>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/survey/list_';?>">List Surveys</a>
</td>

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
