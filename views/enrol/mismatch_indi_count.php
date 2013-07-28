<?php $this->load->view('survey/plsp/templateheader',array('title'=>$title));?>

<?php echo '<center><h3>'.$title.'</h3></center>';?>
<form method="post">
<center><table border ="1px">
	<tr>
		<td>Household ID</td>
		<td>Card Number</td>
		<td>Declared count</td>
		<td>Actual count</td>
		<td>Date</td>
		<td>Agent Name</td>
	</tr>
	<?foreach($mismatch as $rec)
	{
		if($rec[3] == 0)
			$background = "red";
		else 
			$background = "";
		echo "<tr><td>";
		echo '<a href="'.base_url().'index.php/enrol/enrol/edit_household/'.$rec[0].'">'.$rec[0].'</a></td>';
		echo '<td>'.$rec[1].'</td><td>'.$rec[2].'</td><td style = "background-color:'.$background.'">'.$rec[3].'</td><td> '.$rec[4].'</td><td>'.$rec[5].'</td></tr>';
		
	}?>

</table><center>
</form>
<?php $this->load->view('common/footer.php'); ?>
