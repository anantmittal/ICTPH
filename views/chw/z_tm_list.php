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
<tr>
<td>Training Module Names</td>
<td>Description </td>
</tr>
<?php
foreach($tm_obj as $tm_row) { ?>
<tr><td>
 <a href="<?php echo $this->config->item('base_url').'index.php/chw/training_module/edit/'.$tm_row->id; ?>"/a>
<?php echo $tm_row->name; ?></td>
<td><?php echo $tm_row->description; ?></td>
</tr>
<?php } ?>
</table>

<?php
$this->load->view ( 'common/footer' );
?>
