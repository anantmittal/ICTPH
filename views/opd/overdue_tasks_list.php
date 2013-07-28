<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>Overdue Tasks</title>
<script type="text/javascript">
$(document).ready(function(){
	
});	
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>
<div id="main">
	<div class="hospit_box">
		<div class="green_left">
			<div class="green_right">
				<div class="green_middle">
					<span class="head_box">Overdue Tasks</span>
				</div>
			</div>
		</div>
		<div class="green_body">
			<table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
				<tr class="head">
					<td style="width: 11%;">Followup name</td>
					<td style="width: 11%;">Patient name</td>
					<td style="width: 11%;">Visit Id</td>
					<td style="width: 17%;">Due date</td>
					<td style="width: 25%;">Created by</td>
					<td style="width: 25%;">Assigned to</td>
				</tr>
				
				<?php for ($i=0; $i < $total_results; $i++) { 	?>
					<tr class="row">
						<td> <a href="<?php echo $this->config->item('base_url').$link_url.$values[$i]['followup_id'];?>"> <?php echo $values[$i]['followup_name']; ?> </a> </td>
						<td> <a href="<?php echo $this->config->item('base_url').$person_link_url.$values[$i]['person_id'];?>"> <?php echo $values[$i]['person_name']; ?> </a> </td>
						<td> <a href="<?php echo $this->config->item('base_url').$visit_link_url.$values[$i]['visit_id'];?>"> <?php echo $values[$i]['visit_id']; ?> </a> </td>
						<td> <?php echo $values[$i]['due_date']; ?> </td>
						<td> <?php echo $values[$i]['created_by']; ?> </td>
						<td> <?php echo $values[$i]['assigned_to']; ?> </td>
					
					</tr>
				<?php  } ?>
			</table>
		</div>
			
		<div class="greenbtm_left">
			<div class="greenbtm_right">
				<div class="greenbtm_middle"></div>
			</div>
		</div>
		</div>
</div>


<?php $this->load->view('common/footer.php'); ?>
