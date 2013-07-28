
<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>Create training session report</title>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>

</head>
<script type="text/javascript">
</script>
<body>

<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>


<table align="center" width="95%" border="1"></body>
<tr><td><b>Add Training Sessin Report</b></td> </tr>
<tr><td>


<table align="left" width="100%">
<tr><td width="15%"><b>Project</b></td><td><?php echo $project_name; ?> </td> </tr>
<tr><td><b>CHW Group</b></td><td><?php echo $group_name; ?></td> </tr>
<tr><td><b>Training Session</b></td><td></td> </tr>
<tr><td><b>Description </b></td><td><?php echo $description; ?></td> </tr>
</table>



</td> </tr>
<tr><td>

<form method="post"
action="http://192.168.0.127/~pankaj.khairnar/swasth_chw/chw/index.php/chw/training_session/print_post">

<?php $criteria_cnt = count($criteria); ?>











</form>
<?php
$this->load->view ( 'common/footer' );
?>
