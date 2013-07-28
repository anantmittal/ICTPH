<link href="<?php echo "{$this->config->item('base_url')}assets/css/plsp/cvd.css";?>" rel="stylesheet" type="text/css" />
<link href="<?php echo "{$this->config->item('base_url')}assets/css/expand.css";?>" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE="JavaScript" SRC="<?php echo "{$this->config->item('base_url')}assets/js/expand.js";?>">
</SCRIPT>
<?php $this->load->view('survey/plsp/templateheader',array('title'=>'CVD Risk Buckets'));?>
<div align="center">
<table border="1px" width="60%">
	<tr><th>Risk grade</th><th>Count</th><th>Individuals</th></tr>

<?php foreach($buckets as $riskFactor=>$individuals):?>
	<tr>
	<td><?php echo $riskFactor+1;?></td>
	<td><?php echo count($individuals);?></td>
	<td>
	<div>
	<h4><a href="javascript:void(0)" class="dsphead"
   onclick="dsp(this)">
   <span class="dspchar">+</span> Expand for details </a></h4>
   <div class="dspcont">

	<table align="center" width="90%">
		<?php $allids="";?>
		<?php foreach($individuals as $key=>$value):?>
		<tr>
		<td><?php echo $value[1];?></td>
		<td>
		<td>Report (<?php echo "<a href=\"".base_url()."index.php/plsp/report/display_report/".trim($value[1])."/english/html\">English</a>";?>,<?php echo "<a href=\"".base_url()."index.php/plsp/report/display_report/".trim($value[1])."/tamilcode/html\">Tamil</a>";?>)</td>
		<td><?php if($value[0]!=1) echo "<a href=\"../report/edit_report/".$value[0]."/Adult\">Edit</a>"; ?></td>
		</tr>
		<?php endforeach;?>

	</table>

	</div>
	</td>
	
	</tr>
	<?php endforeach;?>
</table>
</div>
<?php $this->load->view('common/footer.php'); ?>
