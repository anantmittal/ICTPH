<?php $this->load->view('survey/plsp/templateheader',array('title'=>$title));?>

<?php echo '<center><h3>'.$title.'</h3></center>';?>
<form method="post">
<center><table border ="1px">
	<tr>
		<td>Household ID</td>
		<td>Erroneous Relation</td>
		<td>Number of relations in the household</td>
		<td>Date</td>
		<td>Agent</td>
	</tr>
	<?foreach($self as $k=>$v)
	{	
		echo "<tr><td>";
		echo '<a href="'.base_url().'index.php/enrol/enrol/edit_household/'.$k.'">'.$k.'</a></td>';
		echo '<td>Self</td><td>'.$v[2].'</td><td>'.$v[0].'</td><td>'.$v[1].'</td></tr>';
		
	}
	foreach($wife as $k=>$v)
	{	
		echo "<tr><td>";
		echo '<a href="'.base_url().'index.php/enrol/enrol/edit_household/'.$k.'">'.$k.'</a></td>';
		echo '<td>Wife</td><td>'.$v[2].'</td><td>'.$v[0].'</td><td>'.$v[1].'</td></tr>';
		
	}
	foreach($husband as $k=>$v)
	{	
		echo "<tr><td>";
		echo '<a href="'.base_url().'index.php/enrol/enrol/edit_household/'.$k.'">'.$k.'</a></td>';
		echo '<td>Husband</td><td>'.$v[2].'</td><td>'.$v[0].'</td><td>'.$v[1].'</td></tr>';
		
	}
	

?>

</table><center>
</form>
<?php $this->load->view('common/footer.php'); ?>
