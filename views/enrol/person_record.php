<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Data Collection Dashboard'));?>

<?php echo '<center><h3>'.$title.'</h3></center>';?>

<?foreach($data as $person):?>
<center><table border ="1px" width="50%">
	<?foreach($person as $key=>$val)
	{
		if($key!="key" && $key!='id')
		{
			echo "<tr>";
			echo "<td width=\"30%\">".$key."</td><td>";
			echo $val;
			echo "</td></tr>";
		}
		
		if($key=='id')
			echo '<tr><td colspan="2"><a href="'.base_url().'index.php/enrol/enrol/edit_person/'.$val.'"/>Edit</a></td></tr>';
	}?>

</table><center>
<br/>
<?endforeach;?>
<?php $this->load->view('common/footer.php'); ?>
