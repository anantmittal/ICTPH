
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>

<script  type="text/javascript">
//Creating javascript array from php array.
var service_list = new Array();      
	service_list = [      
	<?php
	foreach ($service_list as $service){
	$service_id = $service->id;
	$service_name = $service->name;
	?>
	{id: '<?php echo $service_id; ?>', name: '<?php echo $service_name; ?>'},
	<?php
	}
	?>
	];
	
</script>
<div align="center" >
	<span><strong>Find Service :</strong> </span><input id = "search_service" type="text" value="" />
	<input id="service_id" type="hidden"/>
	
	<input type="Submit" value="Find" name="submit" class="submit"/>

</div>