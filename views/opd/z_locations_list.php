<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>Provider Details</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<table align="center" width="50%">
<tr>
<td>ID</td>
<td>Name</td>
<td>Type</td>
<td>Affiliation</td>
<td>Street Address</td>
</tr>
<?php
foreach($p_obj as $p_row) { ?>
<tr><td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/location/edit/'.$p_row->id; ?>"/a>
<?php echo $p_row->id; ?> </td>
<td> <a href="<?php echo $this->config->item('base_url').'index.php/opd/location/edit/'.$p_row->id; ?>"/a>
<?php echo $p_row->name; ?></td>
<td><?php echo $p_row->type; ?></td>
<td><?php echo $p_row->affiliation; ?></td>
<td><?php echo $p_row->street_address; ?></td>
</tr>
<?php } ?>
</table>

<?php
$this->load->view ( 'common/footer' );
?>
