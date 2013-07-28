<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>Open Followups</title>
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
					<span class="head_box">Open Followups</span>
				</div>
			</div>
		</div>
		<div class="green_body">
		
			<table  width="100%" border="0" cellspacing="2" cellpadding="0" class="data_table">
				<tr class="head">
					<td style="width: 20%;">Protocol</td>
					<td style="width: 11%;">Person Id</td>
					<td style="width: 11%;">Visit Id</td>
					<td style="width: 11%;">State </td>
					<td style="width: 17%;">Due date</td>
					<td style="width: 10%;">Created by</td>
					<td style="width: 20%;">Assigned to</td>
				</tr>				
				<?php foreach ($followup_info_list as $followup_rec) { 	
					$person_name=$this->person->find_by("id",$followup_rec->person_id)->full_name;
					$purple_color_style_str = "";
					$display="";
						$found_key = array_search($followup_rec->id,$followup_id_list_edited_today);
						if($found_key){
							$purple_color_style_str ='style="color:purple;"';
							$display="class='display_clr'";
							
						}
					?>
					<tr class="row"  <?php echo $purple_color_style_str ;?>>
						<td>  <a <?php echo $display;?> href="<?php echo $this->config->item('base_url').$followup_link_url.$followup_rec->id;?>"> <?php echo $followup_rec->protocol."-".$followup_rec->next_action; ?>  </a> </td>
						<td>  <a <?php echo $display;?> href="<?php echo $this->config->item('base_url').$person_link_url.$followup_rec->person_id;?>"> <?php echo $person_name; ?> </a>  </td>
						<td>  <a <?php echo $display;?> href="<?php echo $this->config->item('base_url').$visit_link_url.$followup_rec->visit_id;?>"> <?php echo $followup_rec->visit_id; ?> </a>  </td>
						<td>  <?php echo $followup_rec->state; ?>  </td>
						<td>  <?php echo $followup_rec->due_date; ?>  </td>
						<td>  <?php echo $followup_rec->created_by; ?>  </td>
						<td>  <?php echo $followup_rec->assigned_to; ?>  </td>						
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
