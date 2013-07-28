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
<?php
if($this->config->item('machine_id') == 1000)
{ ?>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/repl/s_replicate/add_machine';?>">Add Machine</a>
</td> </tr>
<tr><td>
<form action = "<?php echo $this->config->item('base_url').'index.php/repl/s_replicate/edit_machine';?>" method="POST">
Machine Id: <input type="text" name="machine_id" /input> 
<input type="submit" name="submit_repl"  value="Edit Machine" class="submit" /input> 
</form>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/repl/s_replicate/check_status';?>">Check Status of Clients</a>
</td> </tr>
<?php } 
else 
{
?>


<tr>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/repl/replicate/start';?>" method="POST">
Username: <b><?php echo $this->session->userdata('username') ; ?></b> <input type="hidden" name="username" value="<?php echo $this->session->userdata('username') ; ?>" /input>
Password: <input type="password" name="password" /input> 
<input type="submit" name="submit_repl"  value="Replicate" class="submit" /input> 
</form>
</td> </tr>

<?php
}
?>

</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>
