<?php
$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title>Show Form Details</title>
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
		<div class="blue_middle"><span id='newspan' class="head_box">Basic Form Details</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
<table border="1" width="100%">
	<tr>
		<td>Form Id</td>
		<td><?php echo $form->id;?></td>
	</tr>
	<tr>
		<td>Name</td>
		<td><?php echo $form->name;?></td>
	</tr>
	<tr>
		<td>Type</td>
		<td><?php echo $form->type;?></td>
	</tr>
	<tr>
		<td>Title</td>
		<td><?php echo $form->title;?></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><?php echo $form->description;?></td>
	</tr>
	<tr>
		<td>Table Name</td>
		<td><?php echo $form->table_name;?></td>
	</tr>
	<tr>
		<td>Unit</td>
		<td><?php echo $form->unit;?></td>
	</tr>
	<tr>
		<td>Show sample html</td>
		<td><a href="<?php echo $this->config->item('base_url').'index.php/mne/form/show_form/'.$form->id;?>">Click Here</a></td>
	</tr>
	<tr>
		<td><a href="#variables">List of Variables</a></td>
		<td><a href="#surveys">This Form is part of following List of Surveys</a></td>
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

<div id="variables">
<table width="70%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">List of Variables</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
<table border="1" width="100%">
<tr><td><b>SN</b></td><td><b>ID</b></td> <td><b>Description</b></td><td><b>Screen Name</b></td><td><b>Screen Type</b></td><td><b>Var Name</b></td><td><b>Var Type</b></td><td><b>Var Details</b></td></tr>
<?php
$i=1;
foreach ($vars as $var ) {
	echo '<tr>';
	echo '<td>'.$i.'</td><td>'.$var->id.'</td><td>'.$var->description.'</td><td>'.$var->screen_name.'</td><td>'.$var->form_type .'</td><td>'.$var->variable_name.'</td><td>'.$var->data_type.'</td><td>'.$var->properties.'</td>';
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
</div>

<div id="surveys">
<table width="70%" align="center">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span id='newspan' class="head_box">List of Surveys</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
<table border="1" width="100%">
<tr><td><b>SN</b></td><td><b>ID</b></td> <td><b>Name</b></td><td><b>Manager</b></td><td><b>Username</b></td><td><b>Description</b></td></tr>
<?php
$i=1;
foreach ($surveys as $survey) {
	echo '<tr>';
	echo '<td>'.$i.'</td><td><a href="'.$this->config->item('base_url').'index.php/mne/survey/show/'.$survey->id.'"/>'.$survey->id.'</a></td><td>'.$survey->name.'</td><td>'.$survey->manager.'</td><td>'.$survey->username.'</td><td>'.$survey->description.'</td>';
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
