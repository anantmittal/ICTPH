<link href="<?php echo "{$this->config->item('base_url')}assets/css/plsp/cvd.css";?>" rel="stylesheet" type="text/css" />
<?php $this->load->view('survey/plsp/templateheader',array('title'=>'CVD Matrix'));?>
<div id="mainframe">
<?php
foreach($labels[$split] as $tabs)
{
	echo '<br/><center><h2>'.$display_strings[$split].': '.$tabs.'</h3><center>';
	//Each of this will be a table now
	echo '<center><table class="outertable" border="1px">';
	//Print the header row now
	echo '<tr><td><table><tr><td width="50%">';
	echo $display_strings[$horizontals[0]]."</td><td>";
	echo $display_strings[$horizontals[1]];
	echo "</td></tr></table></td>";
	//Now for the remaining header columns, use the outer vertical parameter
	$inner_v_cnt = count($labels[$verticals[1]]);
	foreach($labels[$verticals[0]] as $outerheader)
	{
		echo '<td><table width="100%"><tr>';
		echo '<td colspan="'.$inner_v_cnt.'"><center>'.$display_strings[$verticals[0]].' '.$outerheader."</center></td></tr><tr>";
		echo '<td colspan="'.$inner_v_cnt.'"><center>'.$display_strings[$verticals[1]].'</center></td></tr><tr>';
		foreach($labels[$verticals[1]] as $innerheader)
			echo "<td><center>".$innerheader."<center></td>";
		echo "</tr></table></td>";
	}
	echo "</tr>";//End of the header row

	//Now for each row 
	foreach($labels[$horizontals[0]] as $outerrow)
	{
		//The first TD will be a header td which in turn is a table
		echo "<tr><td><table>";
		$first_row = true;
		foreach($labels[$horizontals[1]] as $innerrow)
		{
			echo "<tr>";
			if($first_row==true)
				echo '<td width ="50%" rowspan="'.count($labels[$horizontals[1]]).'"><center>'.$outerrow.'</center></td>';
			echo '<td>'.$innerrow.'</td>';
			
			echo "</tr>";
			$first_row = false;
		}	
		echo "</table></td>";
		
		//Now actually get to creating the tables required
		foreach($labels[$verticals[0]] as $outerheader)
		{
			echo '<td><table width="100%">';
			foreach($labels[$horizontals[1]] as $innerrow)
			{
				echo "<tr>";
				foreach($labels[$verticals[1]] as $innerheader)
				{
					echo '<td class="bucket'.$style[$tabs][$outerheader][$outerrow][$innerrow][$innerheader].'">';
					if(!isset($link))
						echo $values[$tabs][$outerheader][$outerrow][$innerrow][$innerheader];
					else
						echo '<a href="'.$link."/$tabs/$outerheader/$outerrow/$innerrow/$innerheader".'">'.$values[$tabs][$outerheader][$outerrow][$innerrow][$innerheader].'</a>';
					echo "</td>";
				}
				echo "</tr>";
			}
			echo "</td></table>";
		}
		echo "</tr>";
	}
	echo "</table><center>";
	echo "<br/>";
}
?>
</div>
<?php $this->load->view('common/footer.php'); ?>
