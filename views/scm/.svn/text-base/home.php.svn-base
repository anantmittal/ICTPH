<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<style>
.main_table div{
	float: left;
}
.main_table div.label{
width: 108px;
}
.main_table div.textbox{
width: 310px;
}

.main_table div.textbox1{
width: 418px;
}
</style>

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/user_autocomplete.js"; ?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
			//populate generic drug name
	    var drug_generics = [ 
	    	<?php 
	    		foreach ($generic_drug_list as $gx) {
	  				$name = $gx->generic_name.'-'.$gx->form.'-'.$gx->strength;	
			?>
			{id: '<?php echo $gx->id; ?>',name: '<?php echo $name; ?>'},
			<?php
		    }	 
	    	?>
	    ];
	        
	    $("#generic_drug").user_autocomplete(drug_generics,'hidden_generic_field');
		
			//populate branded drug name
	    var drug_brands = [ 
			<?php 
					foreach ($brand_drug_list as $b) {
							$name = $b->name;	
				?>
				{id: '<?php echo $b->id; ?>',name: '<?php echo $name; ?>'},
				<?php
			    }	 
				?>       	    
	
	    ];
	        
	    $("#brand_drug").user_autocomplete(drug_brands,'hidden_brand_field');

				//populate organizations
	    var organizations = [
				<?php 
						foreach ($organizations_list as $o) {
								$name = $o->name;	
					?>
					{id: '<?php echo $o->id; ?>',name: '<?php echo $name; ?>'},
					<?php
				    }	 
					?>
	    ];
	        
	    $("#organization_name").user_autocomplete(organizations,'hidden_organization_field');

		$("#edit_generic").validate({
			 messages: { 
				 g_id_edit: "Name required." 
		     }
		});
		$("#edit_brand").validate({
			messages: { 
				 p_id_edit: "Name required." 
		     }
		});
		$("#edit_organization").validate({
			messages: { 
				 o_id_edit: "Name required." 
		     }
		});	

		$("#generate_invoice").validate({
			messages: { 
				c_id_edit: "Id required." 
		     }
		});

		$("#receive_supply").validate({
			messages: { 
				r_id_edit: "Id required." 
		     }
		});

		$("#get_order_details").validate({
			messages: { 
				receive_id_edit: "Id required." 
		     }
		});
	});
	   
</script>


<title>SCM Home Page</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<table align="center" width="78%" border="1" cellpadding="5" class="main_table">
<tr> <td colspan=2><h3>Message: <?php echo $this->session->userdata('msg');?></h3></td></tr>
<ul>

<?php if (isset($filename))
	{
	?>
	<tr>
   <td colspan="2" > <a href="<?php echo $this->config->item('base_url').$filename;?>"> A <?php echo $filetype;?> file has been created. Click here to download. </a> </td>
       </tr>
   <?php } ?>

<tr> <td>Initiate an Order</td>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/scm/order/add';?>">Initiate an Order </a>
</td>
</tr>

<tr> <td>List Pending Orders</td>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/scm/order/list_orders';?>">List Pending Orders </a>
</td>
</tr>

<tr> <td>List log of Maintenance and Calibration</td>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/scm/order/list_maintenance';?>">List Maintenance and Calibration </a>
</td>
</tr>

<tr>
<td>Order Details</td>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/order/get_order_details';?>" method="POST" id="get_order_details">
<div class="label">Enter Order id</div>
<div class="textbox"> <input type="text" name="receive_id_edit" class="required" /></div> 
<div><input type="submit" name="submit_edit" style="width:190px" value="Get Order Details" class="submit" /></div> 
</form>
</td> 
</tr>

<tr>
<td>Generate an Invoice to service an existing order</td>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/order/create_invoice_';?>" method="POST" id="generate_invoice">
<div class="label">Enter Order id</div>
<div class="textbox"> <input type="text" name="c_id_edit" class="required" /></div> 
<div><input type="submit" name="submit_edit" style="width:190px"  value="Create Invoice" class="submit" /></div> 
</form>
</td> 
</tr>

<tr>
<td>Receive supplies against a previously placed order</td>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/order/receive_order_';?>" method="POST" id="receive_supply">
<div class="label">Enter Order id </div>
<div class="textbox"><input type="text" name="r_id_edit" class="required"/> </div>
<div><input type="submit" name="submit_edit" style="width:190px" value="Receive Order" class="submit" /></div> 
</form>
</td> 
</tr>

<tr>
<td>Get stock status of any location</td>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/product/stock_report_';?>" method="POST">
				<div class="textbox1"><?php echo form_dropdown ( 'locn_id', $scm_orgs,'' );?></div>
<input type="submit" name="submit" style="width:190px" value="Get stock status report" class="submit" /input> 
</form>
</td> 
</tr>

<tr>
<td>Add Physical Verification Report for a location</td>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/stock/physical_stock_';?>" method="POST">
				<div class="textbox1"><?php echo form_dropdown ( 'locn_id', $scm_orgs,'' );?></div>
<input type="submit" name="submit" style="width:190px" value="Add Physical Stock" class="submit" /input> 
</form>
</td> 
</tr>

<tr>
<td>Reconcile Stock with Second Physical Verification for a location</td>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/stock/reconcile_stock_';?>" method="POST">
				<div class="textbox1"><?php echo form_dropdown ( 'locn_id', $scm_orgs,'' );?></div>
<input type="submit" name="submit" style="width:190px" value="Reconcile Stock" class="submit" /input> 
</form>
</td> 
</tr>

<tr>
<td>Remove Expired Products</td>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/stock/expiry_';?>" method="POST">
				<div class="textbox1"><?php echo form_dropdown ( 'locn_id', $scm_orgs,'' );?></div>
<input type="submit" name="submit" style="width:190px" value="Remove Expired Products" class="submit" /input> 
</form>
</td> 
</tr>



<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/scm/product/add_generic';?>">Add a Generic Product </a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/product/edit_generic_';?>" method="POST" id="edit_generic">
<div class="label">Enter Generic Product</div>
<div class="textbox"><input type="text" id="generic_drug" name="g_id_edit" class="required"/><input id="hidden_generic_field" type="hidden" name="generic_value"/></div>
<div><input type="submit" name="submit_edit" style="width:190px" value="Edit Generic Drug details" class="submit" /></div> 
</form>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/scm/product/add';?>">Add a Brand to existing Generic (Drug) </a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/product/edit_';?>" method="POST" id="edit_brand">
<div class="label">Enter Brand (Drug)</div>
 <div class="textbox"> <input type="text" id="brand_drug" name="p_id_edit" class="required" /> <input id="hidden_brand_field" type="hidden" name="brand_value"/></div>
<div><input type="submit" name="submit_edit" style="width:190px" value="Edit Brand (Drug) details" class="submit" /> </div>
</form>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/scm/scm_organization/add';?>">Add an Organization Details </a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/scm/scm_organization/edit_';?>" method="POST" id="edit_organization">
<div class="label">Enter Organization </div>
<div class="textbox">  <input type="text" id="organization_name" name="o_id_edit" class="required" /><input id="hidden_organization_field" type="hidden" name="organization_value"/></div> 
<div><input type="submit" name="submit_edit" style="width:190px" value="Edit Organization details" class="submit" /></div> 
</form>
</td> </tr>

<tr> 
	<td rowspan="5" valign="top">Reports </td>
	<td>
		<a href="<?php echo $this->config->item('base_url').'index.php/scm/scm_organization/create_inventory_cost_report';?>">Total Cost of Inventory</a>
	</td> 
</tr>

<tr> 
	<td>
		<a href="<?php echo $this->config->item('base_url').'index.php/scm/scm_organization/create_expiry_report';?>">Cost of Expired drugs</a>
	</td> 
</tr>

<tr> 
	<td>
		<a href="<?php echo $this->config->item('base_url').'index.php/scm/scm_organization/create_inventory_variance_report';?>">Inventory variance report</a>
	</td> 
</tr>

<tr> 
	<td>
		<a href="<?php echo $this->config->item('base_url').'index.php/scm/scm_organization/create_maintenance_log_report';?>">Maintenance and Calibration log report</a>
	</td> 
</tr>

<tr> 
	<td>
		<a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/index';?>">General Reports</a>
	</td> 
</tr>

<!--
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/test/add';?>">Add a Test (Diagnostic) </a>
</td>

<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/opd/test/edit_';?>" method="POST">
Enter Test (Diagnostic) id <input type="text" name="t_id_edit" /input> 
<input type="submit" name="submit_edit"  value="Edit Test (Diagnostic) details" class="submit" /input> 
</form>
</td> </tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/provider/create_visit_report';?>">Create Visit Report </a>
</td>
</tr>
-->

</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>