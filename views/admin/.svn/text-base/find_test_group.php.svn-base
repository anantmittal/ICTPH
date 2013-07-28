<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/admin/find_test_group.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>

<script  type="text/javascript">
//Creating javascript array from php array.
var test_group_list = new Array();      
	test_group_list = [      
	<?php
	foreach ($test_group_list as $test_group){
	$test_group_id = $test_group->id;
	$test_group_name = $test_group->name;
	?>
	{id: '<?php echo $test_group_id; ?>', name: '<?php echo $test_group_name; ?>'},
	<?php
	}
	?>
	];
	
</script>
<div align="center" >
	<span><strong>Find Test Group :</strong> </span><input id = "search_test_group" type="text" value="" />
	<input id="test_group_id" type="hidden"/>
	
	<input type="Submit" value="Find" name="submit" class="submit"/>

</div>
