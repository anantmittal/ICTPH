<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>Project Details</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<table align="center" width="50%">
<tr><td>Project Names</td></tr>
<?php
foreach($project_obj as $project_row) { ?>
<tr><td>
 <a href="<?php echo $this->config->item('base_url').'index.php/chw/project/show/'.$project_row->id; ?>"/a>
<?php echo $project_row->name; ?></td></tr>
<?php } ?>
</table>

<?php
$this->load->view ( 'common/footer' );
?>
