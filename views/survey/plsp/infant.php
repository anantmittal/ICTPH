<?php $this->load->view('survey/plsp/templateheader',array('title'=>'PLSP Infant survey'));?>

<link href="<?php echo "{$this->config->item('base_url')}assets/css/expand.css";?>" rel="stylesheet" type="text/css" />
<SCRIPT LANGUAGE="JavaScript" SRC="<?php echo "{$this->config->item('base_url')}assets/js/expand.js";?>">
</SCRIPT>
<div align="center">
<h2 align="center">Infant PLSP Responses</h2>
<h2 align="center">------</h2>
<?php $x=1;?>
<?php foreach($SurveyData as $records):?>
<h4><a href="javascript:void(0)" class="dsphead"
   onclick="dsp(this)">
   <span class="dspchar">+</span> <?php echo "Record ".$x." - ";?>Expand for details </a></h4>
   <div class="dspcont">
<table border="1">
	<?php foreach($records as $key=>$value):?>
	<tr>
		<?php if(!is_array($value))
		{
			echo "<td>".$key."</td>";
			echo "<td>".$value."</td>";
		}?>
	</tr>
	<?php endforeach;?>	
</table>

</div>
<?php $x++;?>
<?php endforeach;?>
</div>
<?php $this->load->view('common/footer.php'); ?>
