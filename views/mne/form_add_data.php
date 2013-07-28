<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title><?php echo $form->title;?></title>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/datepicker_.js";
	?>"></script>
<script src="<?php echo "{$this->config->item('base_url')}assets/js/nicEdit.js"; ?>" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(function() { nicEditors.allTextAreas(); });</script>
<script type="text/javascript">var base_url= "<?php echo $this->config->item('base_url');?>";</script>
						

</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
//$this->load->view ( 'common/header_search' );
?>
<table width="50%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">
		<?php echo $form->name;?></span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">


		<?php if($srun_id !=0)	{ 
			$validatestr = "";
			if($form->validator != "")
				$validatestr='onsubmit="return '.$form->validator.';"';
			if(!isset($action))
				$action = "";
			else
				$action = 'action="'.$action.'"';
			echo '<form method="post" id="addDataForm" '.$validatestr.' '.$action.'> ';
		 } ?>
		
		
		<?php if($runtime_form ==0)
			{
				if(!isset($prefill))
					$this->load->view('mne/forms/'.$form->table_name.'.html');
				else
					$this->load->view('mne/forms/'.$form->table_name.'.html', $prefill);
			}
		      else
			echo $form_html;
		?>
	
		<?php if($srun_id !=0)	{ ?>
		<table>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Submit"  name="submit_affiliation" class="submit" ></td>
			</tr>
		</table>
		<?php } ?>
		</form>
		</div>
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>
		</div>
		</div>
		</td>
	</tr>
</table>
<?php
$this->load->view ( 'common/footer' );
?>
