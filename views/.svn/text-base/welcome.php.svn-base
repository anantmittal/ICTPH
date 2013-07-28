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
<?php if(isset($roles_rec)){
	foreach ( $roles_rec as $key => $value ) {
		$base_url = $this->config->item('base_url').'index.php/'.$value->home_url;
       echo "<tr> <td><a href=$base_url>" .
       		ucwords($value->name)." Home".
       		"</a></td> </tr>";
    }
}
?>
</table>
<?php $this->load->view('common/footer.php'); ?>
