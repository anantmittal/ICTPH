
<?php $this->load->view('survey/plsp/templateheader',array('title'=>$title));?>
<?php echo validation_errors(); ?>

<center><h1>Date-wise enrolments</h1></center>
<?php echo '<center><h4><a href="'.base_url().'index.php/enrol/enrol/agent_date_table/'.$project_id.'/1">Print Sheet</a></h4></center>';?>

<table align="center" width="70%" border="1" cellpadding="5">

<tr>
	<td>Agent</td>
	<?php foreach($cols as $col)
		echo '<td>'.$col.'</td>';?>
</tr>

<?php foreach($rows as $key=>$val)
	{	
		echo "<tr><td>$key</td>";
		foreach($cols as $col)
		{
			echo "<td>";
			if(!array_key_exists($col." ", $val))
				echo "0";
			else
				echo $val[$col." "];
			echo "</td>";
		}
		echo "</tr>";
	}
?>
</table>


<?php $this->load->view('common/footer.php'); ?>
