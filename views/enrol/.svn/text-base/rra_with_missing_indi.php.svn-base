<?php $this->load->view('survey/plsp/templateheader',array('title'=>$title));?>

<?php echo '<center><h3>'.$title.'</h3></center>';?>
<form method="post">
<center><table border ="1px">
	<tr>
		<td>ID</td>
		<td>Agent</td>
		<td>CVD voucher</td>
		<td>Vision Voucher</td>
		<td>Date</td>
	</tr>
	<?foreach($mismatch as $rec)
	{
		echo "<tr><td>";
		echo '<a href="'.base_url().'index.php/enrol/enrol/edit_rra/'.$rec[0].'">'.$rec[0].'</a></td>';
		echo '<td>'.$rec[1].'</td><td>'.$rec[2].'</td><td>'.$rec[3].'</td><td>'.$rec[4].'</td></tr>';
		
	}?>

</table><center>
</form>
<?php $this->load->view('common/footer.php'); ?>
