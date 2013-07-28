
<?php $this->load->view('survey/plsp/templateheader',array('title'=>'PLSP Analysis'));?>
<?php echo validation_errors(); ?>

<form method="post">
<table align="center" width="70%" border="1" cellpadding="5">

<tr><td>
Report Type
<select name="reporttype">
  <option value="Adult">Adult</option>
  <option value="Adolescent">Adolescent</option>
  <option value="Child">Child</option>
  <option value="Infant">Infant</option>
</select>
</td></tr>
<tr><td>
Batch
<select name="batch">
<?php foreach($batches as $batch):?>
  <?php echo "<option value=\"".$batch."\">".$batch."</option>";?>
<?php endforeach;?>
</select>
</td></tr>
<tr><td><input type="submit" value="Summarize" /></td></tr>
</table>
</form>

<?php $this->load->view('common/footer.php'); ?>
