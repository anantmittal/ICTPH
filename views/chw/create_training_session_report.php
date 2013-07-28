<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>Create training session report</title>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>

</head>
<script type="text/javascript">
$(document).ready(function(){
	$('.status').change(function(){
		if(this.value == 'absent') {
			$('.'+this.id).val('');
			$('.'+this.id).attr("readonly", "readonly");
		}
		else
			$('.'+this.id).removeAttr("readonly");
	});
});
</script>
<body>
<form method="post">
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>


<table align="center" width="95%" border="1"></body>
<tr><td><b>Add Training Session Report</b></td> </tr>
<tr><td>


<table align="left" width="100%">
<tr><td width="15%"><b>Project</b></td><td><?php echo $project_name; ?> </td> </tr>
<tr><td><b>CHW Group</b></td><td><?php echo $group_name; ?></td> </tr>
<tr><td><b>Training Session</b></td><td></td> </tr>
<tr><td><b>Description </b></td><td><?php echo $description; ?></td> </tr>
</table>



</td> </tr>
<tr><td>



<?php $criteria_cnt = count($criteria); ?>

<table border="0" width="100%">

<tr><td colspan="<?php echo $criteria_cnt + 3; ?>"><b>Assessment Score</b></td></tr>
<tr class="head"><td><b>CHWS</b></td>
<td><b>Present / Absent</b></td>
<?php
/*echo '<pre>';
print_r($criteria);
echo '<pre>';*/
$cnt = 1;
foreach($criteria as $criteria_arr) {
	  echo "<td><b>".$criteria_arr['criteria']."</b>";
	  echo "<input type='hidden' name='score[0][{$cnt}]' value='{$criteria_arr['id']}'>";
	  echo "</td>";
	  $cnt++;
}
?>
<td><b>Comment</b></td>
</tr>
<?php
$x_axis = 1;
foreach($chw_obj as $chw_obj_row ){
?>
<tr  class='grey_bg'><td><?php echo $chw_obj_row->name; ?></td>
<td>
<select name="score[<?php echo $x_axis; ?>][status]" class="status" id="status<?php echo $x_axis; ?>" >
<option value="present">Present </option>
<option value="absent"> Absent </option>
</select></td>
<?php for($i = 0; $i <= $criteria_cnt; $i++) { ?>
	<td align="center">
	<?php
	if($i == 0) {
		echo "<input type='hidden' name='score[{$x_axis}][chw_id]' value='{$chw_obj_row->id}'>";
		$i = 1;
	}?>
<input type="text" size="5" name="score[<?php echo $x_axis; ?>][<?php echo $i; ?>]"
class="status<?php echo $x_axis; ?>"> </td>
<?php } ?>

<td><input type="text" size="10" name="score[<?php echo $x_axis; ?>][comment]"> </td>
</tr>

<?php
$x_axis++;
 } ?>
</table>

<br>


</td> </tr>
<tr><td valign="top">
<table width="50%">
<tr><td valign="top"><B>Summary :</B> </td> <td>
<textarea name="summary" rows="4" cols="30"></textarea></td>  </tr>
</table>
</td></tr>
<tr><td><input type="submit" class="submit" value="submit"></td></tr>
</table>


</form>





<?php
$this->load->view ( 'common/footer' );
?>
