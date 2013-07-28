<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>Assign Form to Survey
</title>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>
<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/datepicker_.js";
	?>"></script>


</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>
<table width="50%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">
		<?php
			echo 'List of Forms';
		?></span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
<table border="1">
<tr><td><b>SN</b></td><td><b>ID</b></td>  <td><b>Name</b></td> <td><b>Type</b></td>   <td><b>Table Name</b></td> <td><b>Unit</b></td> <td><b>Description</b></td> </tr>
<?php
$i=1;
foreach ($forms as $form ) {
	echo '<tr>';
	echo '<td>'.$i.'</td><td><a href="'.$this->config->item('base_url').'index.php/mne/form/show/'.$form->id.'">'. $form->id.'</a></td><td>'.$form->name.'</td><td>'.$form->type.'</td><td>'.$form->table_name .'</td><td>'.$form->unit .'</td><td>'.$form->description.'</td>';
	echo '</tr>';
	$i++;
} ?>
</table>
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
