<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>HEW Home Page</title>
<script type="text/javascript">

//to load streets drop down in search household
var street_list = new Array();
	street_list = [
	<?php
	foreach ($street_lists as $street_name){
		$id = $street_name->id;
		$name = $street_name->name;
		$village_id = $street_name->village_city_id;
	?>
	{id: <?php echo $id; ?>, name: "<?php echo ucwords($name); ?>", village_id: "<?php echo $village_id; ?>"},
	<?php
	}
	?>
];

var village_list = new Array();
	village_list = [
	<?php
	foreach ($villages as $id=>$name){
		if($id==0){
		}else{
			$village_id=$id;
			$village_name=$name;
		
	?>
	{id: <?php echo $village_id; ?>, name: "<?php echo ucwords($village_name); ?>"},
	<?php }
	}
	?>
];


$(document).ready(function(){
	var size = "<?php 	$locations = $this->session->userdata('locations'); 
					echo sizeof($locations);?>";
	if(size==1){		
		var submitUrl ="<?php echo $this->config->item('base_url').'index.php/opd/visit/select_locn';?>";
		$('#provider_form').attr('action', submitUrl);
		$('#provider_form').submit();
	}

	//To populate streets based on villages chosen
	$('#village_cities').change(function(){	
		var selected_vc_id = $('#village_cities :selected').val();		
		var streets_dd="<option value='0'>All</option>";
		if(selected_vc_id=='0'){
			$.each(village_list, function(i, village) {
				$.each(street_list, function(i, street) {
					if(village.id == street.village_id){
						streets_dd += '<option value="'+street.id+'">'+street.name+'</option>';
					}
				});
			});
		}else{
			$.each(street_list, function(i, item) {			
				if(item.village_id == selected_vc_id){
					streets_dd += '<option value="'+item.id+'">'+item.name+'</option>';
				}
			});
		}
		$('#streets').html(streets_dd);
	});
	$('#village_cities').change();
	
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

<?php if (isset($filename))
	{
	?>
	<tr>
   <td colspan="2" > <a href="<?php echo $this->config->item('base_url').$filename;?>"> A file has been created. Click here to download. </a> </td>
       </tr>
   <?php } ?>

<tr> <td>Choose Location of Practice</td>
<td>
<?php 
	$locations = $this->session->userdata('locations');
	if(!$this->session->userdata('location_id'))
	{ ?>
  
<form id ="provider_form" action = "<?php echo $this->config->item('base_url').'index.php/opd/visit/select_locn';?>" method="POST">
	<?php 
		if(sizeof($locations)==1){
			$loc="";
			$val="";
			foreach ( $locations as $key=>$value ) {
       					$loc = $value;
       					$val=$key;
			}
			echo 'Selected Location is <b>'.$loc.'</b>';			
			echo "<input type=\"hidden\" name=\"provider_location_id\" value='$val'>";
		}
		else{
			echo form_dropdown ( 'provider_location_id', $locations,'' );
			echo "<input type=\"submit\" name=\"submit_locn\"  value=\"Choose Location\" class=\"submit\" /input>";
		}
	?>
				
</form>
	<?php }
	else
	{
		echo 'Selected Location is <b>'.$locations[$this->session->userdata('location_id')].'</b>';
	} ?>
</td>
</tr>

<tr> <td>Search a Household</td>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/admin/enrolment/search_policies_by_village_ex';?>" method="POST">
				<?php echo "Village ".form_dropdown ( 'village_id', $villages,'', 'id="village_cities"' );?> 
				&nbsp;&nbsp;Street&nbsp;&nbsp;<select name="street_id" id="streets" style="width: 150px"></select>
<p>Name<input type="text" name="name_value"   /input>
Address<input type="text" name="address_value"   /input> 
<input type="submit" name="submit_locn"  value="Search" class="submit" /input> </p>
</form>
</td>
</tr>

<tr> <td>Add a new Household</td>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/add_sgv';?>">Add a new Household </a>
</td>
</tr>
<tr> <td>
Followups
</td> 
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/list_followups';?>" >List All Open Followups </a></td> 
</tr>

<tr> <td>List Visits for Today</td>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/list_visit_details';?>">List Visits for Today</a>
</td>
</tr>

<tr> <td>Task Calendar</td>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/task_calendar';?>" >Task Calendar </a>
</td>
</tr>

<tr> <td>Retail OP Product</td>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/opd/retail/retails';?>">Retail OP Product </a>
</td>
</tr>

</ul>
</table>

<?php $this->load->view('common/footer.php'); ?>
