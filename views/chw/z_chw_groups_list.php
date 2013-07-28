<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>CHW Groups Details</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<table align="center" width="50%">
<tr><td>CHW Group Names</td></tr>
<?php
foreach($chw_group_obj as $chw_group_row) { ?>
<tr><td>
 <a href="<?php echo $this->config->item('base_url').'index.php/chw/chw_group/member_listing/'.$chw_group_row->id; ?>"/a>
<?php echo $chw_group_row->name; ?></td></tr>
<?php } ?>
</table>

<?php
$this->load->view ( 'common/footer' );
?>
