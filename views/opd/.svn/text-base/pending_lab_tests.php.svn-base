<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript">
var base_url = "<?php echo $this->config->item('base_url').'index.php/opd/lab/list_pending_lab_tests/' ?>" ;
$(document).ready(function(){
	$('#location_id').change(function(){
		var location_id=$('#location_id').val();
		var location_name=$('#location_id option:selected').text();
		document.forms["post_location"].action = base_url + location_id + "/" + location_name;
		document.forms["post_location"].submit();
	});
});

</script>

<title>Pending Lab Tests</title>

<style type="text/css">
#search_by{
	line-height:22px;
	padding-bottom:10px;
}
#search_by div{
	line-height:22px;
	float:left;
}
#search_by .or_div{
	padding-left : 50px;
	padding-right : 50px;
}
#search_by .head{
	padding-left:30px;
	padding-right:5px;
}
#stock_table{
	border-color : #ccc;
	border-collapse : collapse;
	border : 1px solid #ccc
}
#stock_table tr td {
	padding:5px;
}
</style>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block');
$this->load->view ( 'common/header_search' );
?>
<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'><span>$success_message</span><div><a href='".$this->config->item('base_url').$filename."'>A  $filetype file has been created. Click here to download.</a></div> </div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>
			<div id="main">
				<div class="blue_left">
					<div class="blue_right">
						<div class="blue_middle"><span class="head_box">
							<?php
								echo 'Pending Lab Tests';
								if(!empty($location_name) && $location_name != "" && $location_name !== 'All'){
									echo ' for '.urldecode($location_name);
								}
							?>
						</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding: 10px;">
				<div id="main">
					<form method="post" id="post_location">
						<table border="0" width="98%">
							<tr>
								<td><b>Location:<?php 
								echo form_dropdown('location', $unique_provider_location,$location_id, 'id="location_id"');
								?></b></td>
							
							</tr>
							<tr>
								<td>
								      <table width="100%" border="1px" id="stock_table">
										<tr class="scm_head">
											  <td width="3%">Sl/no</td>
											  <td width="20%">Visit Id</td>
											  <td width="30%">Test Name</td>
											   <td width="24%">Bar Code</td>
											  <td width="10%">Date</td>
											   <td width="13%">No. of hours since sample was taken</td>
											  
										</tr>
										<?php
												$slno=1;
												for($i=0; $i < $total_results ; $i++)
												{
													echo '<tr>'."\n";
													$visit_url=$this->config->item('base_url').$show_visit_url.$values[$i]['visit_id'];
													echo '<td valign="top">'.$slno.'</td>'."\n";
													echo '<td valign="top"><a href="'.$visit_url.'">'.$values[$i]['visit_id'].'</td></a>'."\n";
													echo '<td valign="top">';
													for($j=0;$j<$total_tests;$j++){
														if(isset($values[$i][$j]['test_name']))
															echo $values[$i][$j]['test_name'].'<br />';
													}
													echo '</td>'."\n";
													echo '<td valign="top">';
													for($k=0;$k<$total_bar_codes;$k++){
														if(isset($values[$i][$k]['bar_code']))
															echo '<a href="'.$visit_url.'">'. $values[$i][$k]['bar_code'].'</a><br />';
													}
													echo '</td>'."\n";
													echo '<td valign="top">'.$values[$i]['visit_date'].'</td>'."\n";
													echo '<td valign="top">'.$values[$i]['hours_since_visit'].'</td>'."\n";
													$slno++;
													
												}
											?>
	      							</table>
      							</td>
							</tr>
							
					</table>
				</form>
				</div>
			</div>
			<div class="bluebtm_left">
				<div class="bluebtm_right">
					<div class="bluebtm_middle" /></div>
				</div>
			</div>
		</div>

<?php
$this->load->view ( 'common/footer' );
?>
