<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Data Collection Dashboard'));?>

<?php echo '<center><h3>'.$title.'</h3></center>';?>
<form method="post">
<center><table border ="1px">
	<?foreach($data as $key=>$val)
	{
		echo "<tr>";
		echo "<td>".$key."</td><td width = 200>";
		if($val[0]=='bool')
		{
			echo '<input style = "width:200px" type=checkbox name="'.$key.'"'.(($val[1]==true)?' checked':' value="1"').'/>';
		}
		else if($val[0]=='label')
		{
			echo $val[1];
			echo '<input style = "width:200px" type=hidden name="'.$key.'" value="'.$val[1].'"/>';
		}
		else if($val[0]=='link')
		{
			
			echo '<a href="'.$val[1].'">'.$key.'</a>';
		}
		else if($val[0] == 'time')
		{
			$time = date('d-F-Y, G:i:s',$val[1]);
			echo $time;
			echo '<input style = "width:200px" type=hidden name="'.$key.'" value="'.$time.'"/>';
		}
		else if($val['0']=='dropdown')
		{
			echo '<select name="'.$key.'">';
			foreach($val[2] as $v=>$n)
			{
				$strappend ='';
				if($v == $val[1])
					$strappend ='selected="selected"';
				echo '<option value="'.$v.'" '.$strappend.'>'.$n.'</option>';
			}
			echo '</select>';
		}
		else //assume string
		{
			echo '<input style = "width:200px" type=text name="'.$key.'" value="'.$val[1].'"/>';
		}
		echo "</td></tr>";
		
	}?>
<tr>
	<td colspan="1"><center><input type=submit value="Save"/></center></td><?php echo '<td colspan="1"><a href="'.base_url().'index.php/enrol/enrol/delete_'.$type.'/'.$id.'"/>Delete</a></td>';
?>
</tr>
</table></center>
</form>
<form method = "post" action = ><center>
<table>
<?php
	if(isset($audit))
	{	
		echo '</tr></table></center></form><form method = "post" action = '.base_url().'index.php/enrol/enrol/mark_for_audit/'.$project_id.'/'.$id.' ><center><table>';
		echo "<tr>";
		if($audit == 'button')
		{
			echo "<button name = 'audit' type = submit>Select for Audit</button>";
		}
	
		echo "</tr>";
	} 
?>
</table></center>
</form>
<?php $this->load->view('common/footer.php'); ?>
