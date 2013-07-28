
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>

<script  type="text/javascript">
//Creating javascript array from php array.
var maintenance_list = new Array();      
	maintenance_list = [      
	<?php
	foreach ($maintenance_list as $maintenance){
	$maintenance_id = $maintenance->id;
	$maintenance_name = $maintenance->name;
	?>
	{id: '<?php echo $maintenance_id; ?>', name: '<?php echo $maintenance_name; ?>'},
	<?php
	}
	?>
	];
	
</script>
<div align="center" >
	<span><strong>Find Maintenance :</strong> </span><input id = "search_maintenance" type="text" value="" />
	<input id="maintenance_id" type="hidden"/>
	
	<input type="Submit" value="Find" name="submit" class="submit"/>

</div>