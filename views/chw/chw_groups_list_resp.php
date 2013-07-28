<?php $this->load->view ( 'common/header' ); ?>
<script type="text/javascript">
 $(document).ready(function($) {
	})
</script>
<title>CHW Groups Listing</title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );

?>
<table width="500px" align="center">
<tr class="head"> <td><b>ID</b></td>   <td><b>Group Name</b></td>   <td><b>Listing</b></td> </tr>
<?php foreach ($chw_groups as $chw_group) { ?>
<tr class="grey_bg">
<td  align="center"><?php echo $chw_group->id; ?> </td>
<td><?php echo $chw_group->name; ?></td>
<td  align="center"> <a href="<?php echo  $this->config->item('base_url').'index.php/chw/chw_group/member_listing/'.$chw_group->id; ?>">Members List</a> </td>
</tr>

<?php } ?>

</table>


<?php $this->load->view ( 'common/footer' ); ?>
