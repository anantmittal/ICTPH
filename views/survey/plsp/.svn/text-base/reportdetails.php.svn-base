<?php $this->load->view('survey/plsp/templateheader',array('title'=>'PLSP Report Summary'));?>
<?php echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url()."assets/css/plsp/editreport.css\"/>";?>
<?php echo "<form method=\"post\" action=\"".base_url()."index.php/plsp/report/edit_report/".$id."/".$type."\">";?>	

<table align="center" width="50%" border="1" cellpadding="3">
<?php foreach($data as $fieldName=>$tables):?>
<tr>
	<?php echo "<td class=\"".$tables[0]."\">".$fieldName."</td>";?>
	<td>
		<table>
			<?php foreach($tables[1] as $rows):?>
			<tr>
				<td class="inner"><?php echo $rows[2];?></td>
				<td><?php echo $rows[0]==1?form_input($rows[1], $rows[3]):$rows[3];?>
				</td>
			</tr>
			<?php
						if($fieldName=="Individual ID")
						{
							echo "<tr><td></td><td>";
							echo "Report (<a href=\"".$this->config->item('base_url')."index.php/plsp/report/display_report/".trim($rows[3])."/english/pdf\">English</a>";?>,<?php echo "<a href=\"".$this->config->item('base_url')."index.php/plsp/report/display_report/".trim($rows[3])."/tamilcode/html\">Tamil</a>)";
							echo "</td></tr>";
						}
					?>
			<?php endforeach;?>
		</table>
	</td>
</tr>
<?php endforeach;?>
</table>
</br>
<div align="center"><input type="submit" value="Submit" /></div>

</form>
<?php $this->load->view('common/footer.php'); ?>
