<?php $this->load->view('survey/plsp/templateheader',array('title'=>'PLSP High Risk Individuals'));?>
<?php echo '<link rel="stylesheet" type="text/css" href="'.base_url().'/assets/css/plsp/plspsummaries.css"/>';?>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/expand.css";?>" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE="JavaScript" SRC="<?php echo "{$this->config->item('base_url')}assets/js/expand.js";?>">
</SCRIPT>
<?php $this->load->view('survey/plsp/plspbatchfilter',array('batch'=>$batch,'selected_batch'=>$selected_batch));?>
<?php foreach($data as $category=>$tables):?>
<div align="center">
<H3>
	<?php echo $category;?>
	<?php echo "-<a href=\"".$this->config->item('base_url')."index.php/plsp/report/highrisk_chart/".$category."/".$selected_batch."\">Graphical view</a>";?>
</H3>
</div>
	<table align="center" width="60%" border="1">
	<tr>
		<th class="key">Risk Factor</th>
		<th>Individuals</th>
		<th  class="count">Count</th>
	</tr>
	<?php foreach($tables as $riskFactor=>$individuals):?>
	<tr>
	<td><?php echo $riskFactor;?></td>

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
		<td>
		<?php echo $key ?>
		</td>
		<td>Report (<?php echo "<a href=\"./display_report/".trim($key)."/english/pdf\">English</a>";?>,<?php echo "<a href=\"./display_report/".trim($key)."/tamilcode/html\">Tamil</a>";?>)</td>
		<td><?php echo "<a href=\"".$this->config->item('base_url')."index.php/plsp/queryhhform/display_household/".substr(trim($key),0,-2)."\">View Household</a>";?></td>
		<td><?php if($value[0]!=1) echo "<a href=\"../report/edit_report/".$value[1]."/".$category."\">Correct Error(s)</a>"; ?></td>
		<?php $allids=($value[0]==1)?($allids."-".trim($key)):$allids;?>
		</tr>
		<?php endforeach;?>
		<tr><td></td>
			<td>Consolidated Report</td><td>(<?php echo "<a href=\"./consolidated_report/".$allids."/english/pdf\">English</a>";?>, <?php echo "<a href=\"./consolidated_report/".$allids."/".$category."/tamilcode/html\">Tamil</a>";?>)</td></tr>

		
	</table>

	</div>
	</td>
	<td><?php echo count($individuals);?></td>
	</tr>
	<?php endforeach;?>
	</table>
</br>
<?php endforeach;?>
<?php $this->load->view('common/footer.php'); ?>
