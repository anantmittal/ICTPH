<?php $this->load->view('survey/plsp/templateheader',array('title'=>'PLSP Error Reports'));?>
<?php echo '<link rel="stylesheet" type="text/css" href="'.base_url().'/assets/css/plsp/plspsummaries.css"/>';?>
<link href="<?php echo "{$this->config->item('base_url')}assets/css/expand.css";?>" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE="JavaScript" SRC="<?php echo "{$this->config->item('base_url')}assets/js/expand.js";?>">
</SCRIPT>
<?php $this->load->view('survey/plsp/plspbatchfilter',array('batch'=>$batch,'selected_batch'=>$selected_batch));?>
<?php foreach($data as $category=>$tables):?>
<div align="center">
<H3>
	<?php echo $category;?>
	<?php echo "-<a href=\"".$this->config->item('base_url')."index.php/plsp/report/error_pie/".$category."/".$selected_batch."\">Graphical view</a>";?>
</H3>
</div>
	<table align="center" width="60%" border="1">
	<tr>
		<th class="key">Error Category</th>
		<th>Individuals</th>
		<th class="count">Count</th>
	</tr>
	<?php foreach($tables as $errorType=>$individuals):?>
	<tr>
	<td><?php echo $errorType;?></td>

	<td>
	<div>
	<h4><a href="javascript:void(0)" class="dsphead"
   onclick="dsp(this)">
   <span class="dspchar">+</span> Expand for details </a></h4>
   <div class="dspcont">

	<table align="center" width="70%">
		
		<?php foreach($individuals as $key=>$value):?>
		<tr>
		<td>
		<?php echo $key ?>
		</td>
		<td><?php 
			if($errorType=="Missing IDs")
				 echo "<a href=\"".$this->config->item('base_url')."index.php/admin/enrolment/edit_add_del/".substr(trim($key),0,-2)."\">Add Individual</a>";
			else
				echo "<a href=\"../report/edit_report/".trim($value[1])."/".$category."\">Correct</a>";?></td>
		</tr>
		<?php endforeach;?>
		
		
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
