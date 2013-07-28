<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>Show Survey Details</title>
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
<table width="70%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">Basic Survey Details</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
<table border="1" width="100%">
	<tr>
		<td>Survey Id</td>
		<td><?php echo $survey->id;?></td>
	</tr>
	<tr>
		<td>Name</td>
		<td><?php echo $survey->name;?></td>
	</tr>
	<tr>
		<td>Manager</td>
		<td><?php echo $survey->manager;?></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><?php echo $survey->description;?></td>
	</tr>
	<tr>
		<td><a href="#runs">List of Survey Runs</a></td>
		<td><a href="#forms">List of Forms</a></td>
	</tr>
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

<div id="runs">
<table width="70%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">List of Survey Runs</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
<table border="1" width="100%">
<tr><td><b>SN</b></td><td><b>ID</b></td> <td><b>Name</b></td><td><b>Geography</b></td><td><b>Start Date</b></td><td><b>End Date</b></td><td><b>Surveyor</b></td></tr>
<?php
$i=1;
foreach ($runs as $run ) {
	echo '<tr>';
	echo '<td>'.$i.'</td><td>'.$run->id.'</td><td>'.$run->name.'</td><td>'.$run->geography_type.' - '.$run->geo_name .'</td><td>'.Date_util::to_display($run->start_date).'</td><td>'.Date_util::to_display($run->end_date).'</td><td>'.$run->staff_type.'</td>';
	echo '</tr>';
	$i++;
} ?>
</table>
<table>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/survey/create_run';?>">Create a Survey Run</a>
</td></tr>
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
</div>

<div id="forms">
<table width="70%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">List of Forms</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
<table border="1" width="100%">
<tr><td><b>SN</b></td><td><b>ID</b></td> <td><b>Name</b></td><td><b>Title</b></td><td><b>Table Name</b></td><td><b>Unit</b></td><td><b>Description</b></td></tr>
<?php
$i=1;
foreach ($forms as $form ) {
	echo '<tr>';
	echo '<td>'.$i.'</td><td><a href="'.$this->config->item('base_url').'index.php/mne/form/show/'.$form->id.'"/>'.$form->id.'</a></td><td>'.$form->name.'</td><td>'.$form->title .'</td><td>'.$form->table_name.'</td><td>'.$form->unit.'</td><td>'.$form->description.'</td>';
	echo '</tr>';
	$i++;
} ?>
</table>
<table>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/mne/form/assign';?>">Assign Form to a Survey</a>
</td></tr>
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
</div>
<?php
$this->load->view ( 'common/footer' );
?>
