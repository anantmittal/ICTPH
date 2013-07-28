<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#get_list').click(function() {
			hideErrorMessages();
			var x=$('#from_date').val();
			var y=$('#to_date').val();
			var date3 = /^[0-9D]{2}[\/ ]?[0-9M]{2}[\/ ]?[0-9Y]{4}$/;
			if(date3.test(x) && date3.test(y)){
				if(x!='DD/MM/YYYY' && y!='DD/MM/YYYY'){
					var from_date=x.split("/");
					var formatted_from_date=Date.parse(from_date[1]+"/"+from_date[0]+"/"+from_date[2]);
	
					var to_date=y.split("/");
					var formatted_to_date=Date.parse(to_date[1]+"/"+to_date[0]+"/"+to_date[2]);
					
					if(formatted_from_date<=formatted_to_date){
					}else{
						$('#date_validate').show();
						$('.success').hide();
						return false;
					}
				}else{
				}
			}else{
				$('#date_format').show();
				$('.success').hide();
				return false;
			}

		});

	});
	function hideErrorMessages(){
		$('.error').hide();
	}
</script>
<title>List Maintenance and Calibration </title>

<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#666666;
	margin:0px;
	padding:0px;
}
.maindiv
{
width:550px;
margin:auto;
border:#000000 1px solid;
}
.mainhead{background-color : #aaaaaa;}
.tablehead{background-color : #d7d7d7;}
.row{   background-color : #e7e7e7;}
.data_table tr{
	font-size:11px;
	height:25px;
	background-color:#e8e8e8;
}

.largeselect {   width:200px; }

</style>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>
<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'>$success_message </div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>
	

<!--Main Page-->
<?php echo validation_errors(); ?>
<form method="POST">
<table align="center" >
	<tr><td colspan='4'><b>Filter By:</b></td></tr>
	<tr>
		<td>
		<b>From Date</b>
			<input name="from_date" id="from_date" type="text" value="DD/MM/YYYY" class="datepicker check_dateFormat"  style="width:100px;"  />
		</td> 
	
		<td>
		<b>To Date</b>
			<input name="to_date" id="to_date" type="text" value="DD/MM/YYYY" class="datepicker check_dateFormat"  style="width:100px;"  />
		</td>
	  	
		
		<td>
		<b>Location</b>
		
		<?php 
		if(isset($provider_location_id)){
			$selected=$provider_location_id;
		}else{
			$selected='';
		}
		echo form_dropdown ( 'provider_location_id', $provider_locs,$selected );
		?>
		
		</td>
	
		<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="submit"  id="get_list" name="get_list" value="Generate Maintenance List "> </td>
	</tr>
	<tr>
		<td colspan='4'>
	  		<b><label class="error" id="date_format" style="display:none"> Enter Date in correct format </label></b>
			<b><label class="error" id="date_validate" style="display:none">To Date should not be before From Date </label></b>
	  	</td>
	  	
	</tr>
</table>
</form>
<br><br>

<?php	
	if($total_results != 0)
	{ ?> 
	
<div id="main">
  <div class="hospit_box">
<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Maintenance Lists</span></div></div></div>
   
<div class="green_body">
 <table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
   <tr class="head">
     <td>SNo</td>
     <td>Maintenance Name</td>
     <td>Date</td>
     <td>Location</td> 
     <td>User</td>
     <td>Comment</td>
    
   </tr>
<?php 
  for ($i=0; $i < $total_results; $i++) {
  ?>
  <tr class="row">
    <td width="5%"> <?php echo ($i + 1)."."; ?> </td>
    <td width="10%" >  <?php echo $values[$i]['maintenance_name']; ?></a> </td>
    <td width="10%" > <?php echo $values[$i]['date']; ?> </td>
    <td width="15%" > <?php echo $values[$i]['location']; ?> </td>
    <td width="15%" > <?php echo $values[$i]['provider']; ?> </td>
    <td width="30%" > <?php echo $values[$i]['comment']; ?> </td>
  </tr>
<?php  } ?>
  </table>
</div>

<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
			</div></div>
<?php } ?>
<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>

