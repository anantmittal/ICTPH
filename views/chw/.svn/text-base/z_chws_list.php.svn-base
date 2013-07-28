<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>CHW Details</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<form action="<?php echo $this->config->item('base_url');?>index.php/chw/chw_group/add_members" method="post">
<table align="center" width="50%">
<tr><td>CHW ID and Names</td></tr>
<?php
foreach($chw_obj as $chw_row) { ?>
<tr><td>
 <input type="checkbox" value="<?php echo $chw_row->id; ?>" name="chw_ids[]">
<a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/show/'.$chw_row->id; ?>"/a>
<?php echo $chw_row->id; ?>
<a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/show/'.$chw_row->id; ?>"/a>
<?php echo $chw_row->name; ?></td>
</tr>
<?php } ?>
<tr><td>Name of Group    <input type="text" name="group_name"></td></tr>
<tr>
<td><input type="radio" name="group_type" value="existing">Add to Existing Group</td>
<td><input type="radio" name="group_type" value="new" checked="checked">Create New Group and Add Member(s)  </td>
</tr>
<tr><td>Description of new Group  <input type="text" name="group_desc"></td></tr>
<tr><td colspan="2"><input type="submit" class="submit" value="Submit" name="create_group"></td> </tr>
</form>
</table>

<?php
$this->load->view ( 'common/footer' );
?>
