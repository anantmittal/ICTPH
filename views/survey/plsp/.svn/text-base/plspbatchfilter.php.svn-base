<form method="post" >
<table align="center" width="60%" border="1">
<tr>
<td><center>Filter by batch:
<select name="batch">
<?php 
foreach($batch as $batchnum=>$flag)
{
	$s=(($batchnum == $selected_batch) ? " selected=\"selected\" ": null);
	echo "<option $s value=\"".$batchnum."\">".$batchnum."</option>";
}
?>
</select>
<input type="submit" value="Submit" />
<center>
</td>
</tr>
</table>
</form>
