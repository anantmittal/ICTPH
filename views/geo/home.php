<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>

<title>Geography Home Page</title>
<style>
.main_table div{
	float: left;
}
.main_table div.label{
width: 90px;
}
.main_table div.textbox{
width: 350px;
}
</style>
<script type="text/javascript">

	

	$(document).ready(function(){
		$("#street_form_id").validate();
		$("#area_form_id").validate();
		$("#village_form_id").validate();
		$("#taluka_form_id").validate();
		$("#district_form_id").validate();
		$("#state_form_id").validate();
	});
</script>

</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<table align="center" width="70%" border="1" cellpadding="5" class="main_table">
<tr> <td colspan=2><h3>Message: <?php echo $this->session->userdata('msg');?></h3></td></tr>
<ul>


<tr> 
	<td>
	<a href="<?php echo $this->config->item('base_url').'index.php/geo/geo/add/street/village_citie';?>">Add a Street in a Village</a>
	</td>
	<td>
	<form action = "<?php echo $this->config->item('base_url').'index.php/geo/geo/edit_';?>" method="POST" id="street_form_id">
		<div class="label">Enter Street id</div>
		<div class="textbox"><input type="text" name="id_edit" class="required"/></div> 
		<input type="hidden" name="type" value="street"/> 
		<div><input type="submit" name="submit_edit"  value="Edit Street details" class="submit" /></div> 
	</form>
	</td> 
</tr>

<tr> 
	<td>
	<a href="<?php echo $this->config->item('base_url').'index.php/geo/geo/add/area/village_citie';?>">Add an Area in a Village</a>
	</td>
	<td>
	<form action = "<?php echo $this->config->item('base_url').'index.php/geo/geo/edit_';?>" method="POST" id="area_form_id">
	<div class="label">Enter Area id</div>
	<div class="textbox"><input type="text" name="id_edit" class="required"/></div> 
	<input type="hidden" name="type" value="area"/> 
	<div><input type="submit" name="submit_edit"  value="Edit Area details" class="submit" /></div> 
	</form>
	</td> 
</tr>

<tr> 
	<td>
	<a href="<?php echo $this->config->item('base_url').'index.php/geo/geo/add/village_citie/taluka';?>">Add a Village in a Taluka</a>
	</td>
	<td>
	<form action = "<?php echo $this->config->item('base_url').'index.php/geo/geo/edit_';?>" method="POST" id="village_form_id">
	<div class="label">Enter Village id</div>
	 <div class="textbox"><input type="text" name="id_edit" class="required"/> </div>
	<input type="hidden" name="type" value="village_citie"/> 
	<div><input type="submit" name="submit_edit"  value="Edit Village details" class="submit" /> </div>
	</form>
	</td> 
</tr>

<tr> 
	<td>
	<a href="<?php echo $this->config->item('base_url').'index.php/geo/geo/add/taluka/district';?>">Add a Taluka in a District</a>
	</td>
	<td>
	<form action = "<?php echo $this->config->item('base_url').'index.php/geo/geo/edit_';?>" method="POST" id="taluka_form_id">
	<div class="label">Enter Taluka id</div>
	 <div class="textbox"><input type="text" name="id_edit" class="required" /></div> 
	<input type="hidden" name="type" value="taluka"/> 
	<div><input type="submit" name="submit_edit"  value="Edit Taluka details" class="submit" /> </div>
	</form>
	</td> 
</tr>

<tr> 
	<td>
	<a href="<?php echo $this->config->item('base_url').'index.php/geo/geo/add/district/state';?>">Add a District in a State</a>
	</td>
	<td>
	<form action = "<?php echo $this->config->item('base_url').'index.php/geo/geo/edit_';?>" method="POST" id="district_form_id">
	<div class="label">Enter District id</div>
	 <div class="textbox"><input type="text" name="id_edit" class="required"/> </div>
	<input type="hidden" name="type" value="district"/> 
	<div><input type="submit" name="submit_edit"  value="Edit District details" class="submit" /> </div>
	</form>
	</td> 
</tr>

<tr> 
	<td>
	<a href="<?php echo $this->config->item('base_url').'index.php/geo/geo/add/state/null';?>">Add a State</a>
	</td>
	<td>
	<form action = "<?php echo $this->config->item('base_url').'index.php/geo/geo/edit_';?>" method="POST" id="state_form_id">
	<div class="label">Enter State id</div>
	 <div class="textbox"><input type="text" name="id_edit" class="required"/></div> 
	<input type="hidden" name="type" value="state"/> 
	<div><input type="submit" name="submit_edit"  value="Edit State details" class="submit" /></div> 
	</form>
	</td> 
</tr>

<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/sql_report/index';?>">Reports</a>
</td> </tr>

</ul>
</table>
</body>
<?php $this->load->view('common/footer.php'); ?>
