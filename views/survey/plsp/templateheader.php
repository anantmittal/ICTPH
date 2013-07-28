<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title><?php echo $title?></title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>
<?php echo validation_errors(); ?>
