<?php $this->load->view ( 'common/header' ); ?>
<script type="text/javascript">
 $(document).ready(function($) {
	})
</script>
<title>CHW Group Members Listing</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<form action="" method="post">
<table width="500px" align="center">
<tr>
<td><b>Group Id: <?php echo $chw_group->id; ?> </b></td>
<td><b>Group Name: <?php echo $chw_group->name; ?> </b></td>
<td><b>Group Description: <?php echo $chw_group->description; ?> </b></td>
</tr>

<tr class="head">    <td><b>Remove</b></td> <td><b>CHW ID</b></td>   <td><b>Member Name</b></td> </tr>
<?php
$cnt = 0;
foreach ($members as $member) { ?>
<tr class="grey_bg">
<td align="center">
<input type="hidden" name="records[<?php echo $cnt; ?>][id]" value="<?php echo $member->id; ?>">
<input type="checkbox" name="records[<?php echo $cnt; ?>][state]" value="selected" > </td>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/show/'.$member->chw_id; ?>"/a>
<?php echo $member->chw_id; ?> </td>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/chw/chw/show/'.$member->chw_id; ?>"/a>
<?php echo $member->chw_name; ?></td>
</tr>
<?php
$cnt ++;
 } ?>
 <tr><td colspan="3"><input type="submit" name="submit" class="submit" value="Remove Selected Members" >  </td>  </tr>
</form>

<tr> <td>
<form action = "<?php echo $this->config->item('base_url').'index.php/chw/project/create/'.$chw_group->id;?>" method="POST">
<input type="submit" name="submit_add"  value="Create Project for this Group" class="submit" > 
</form>
</tr> </td>

</table>
<?php $this->load->view ( 'common/footer' ); ?>
