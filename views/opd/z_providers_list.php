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
<td>Full Name</td>
<td>Type</td>
<td>Contact Number</td>
<td>Street Address</td>
<td>Registration Number</td>
</tr>
<?php
foreach($p_obj as $p_row) { ?>
<tr><td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/provider/edit/'.$p_row->id; ?>"/a>
<?php echo $p_row->id; ?> </td>
<td> <a href="<?php echo $this->config->item('base_url').'index.php/opd/provider/edit/'.$p_row->id; ?>"/a>
<?php echo $p_row->full_name; ?></td>
<td><?php echo $p_row->type; ?></td>
<td><?php echo $p_row->contact_number; ?></td>
<td><?php echo $p_row->street_address; ?></td>
<td><?php echo $p_row->registration_number; ?></td>
</tr>
<?php } ?>
</table>

<?php
$this->load->view ( 'common/footer' );
?>
