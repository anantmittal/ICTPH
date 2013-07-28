<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
<title><?php
if (isset ( $training_module_obj->name ))
	echo 'Edit Training Module';
else
	echo 'Add Training Module';
?></title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>

<script type="text/javascript"
	src="<?php
	echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js";
	?>"></script>

<script type="text/javascript">
var cnt = 0;
$(document).ready(function(){
	$('#addTopicRow').click(function() {
		var topic = $('#topic').val();
		var description = $('#t_description').val();
		var filevar = 'filename'+cnt;
		if(topic != ''){
		    var row = '<tr class="approve">';
			row += '<td><input type="hidden" name="new_topics['+cnt+'][topic]" 		value="' + topic + '">' + topic  + '</td>';
			row += '<td><input type="hidden" name="new_topics['+cnt+'][description]" 	value="' + description +'">' + description  + '</td>';
			row += '<td><input type="file" name="'+filevar+'"> </td>';
//			row += '<td>' + description + '</td>';
//			row += '<td>' + topic_file + '</td>';
//			row += '<td onmousedown="removeRow(this)"><a href="#">Remove</a></td>';
			row += '</tr>';
			
			cnt++;
			$('#topic').val('');
			$('#t_description').val('');
			$('#topicTable tr:last').after(row);
		}
	});


	$('#submit_form_data').click(function(){
		var row_data="";
		var cnt = 0;
		var topicTableData = "";

		$('#topicTable tr').each(function(){
			var rows = $(this).children('td');
			$(rows).each(function(){
				if(cnt != 0)
					row_data += $(this).html()+'|';
			});
			if(cnt != 0)
				row_data += '~';

			cnt++;
		});
		$('#topicTableData').val('');
		$('#topicTableData').val(row_data);


});

function removeRow(row) {
	$(row).parent().remove();
}
});

</script>

<table width="60%" align="center">
	<tr>
		<td>

		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">
		<?php
		if (isset ( $training_module_obj->name ))
			echo 'Edit Training Module';
		else
			echo 'Add Training Module';
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

		<form method="POST" enctype=multipart/form-data>
		<table border="0" align="center" width="">
		<?php
			if (isset ( $training_module_obj->id )) { ?>
			<tr>
				<td><b>Training Module ID</b></td>
				<td>
			<?php
				echo $training_module_obj->id ;

			?></td>

			</tr>
			<?php } ?>
			<tr>
				<td><b>Training Module Name</b></td>
				<td><input type="text" name="name"
					value="<?php
					if (isset ( $training_module_obj->name ))
						echo $training_module_obj->name;
					?>"></td>
			</tr>
			<tr>
				<td><b>Description</b></td>
				<td><textarea rows="3" cols="25" name="description"><?php
				if (isset ( $training_module_obj->description ))
					echo $training_module_obj->description;
				?></textarea></td>
			</tr>
			<tr>
				<td><b>Author</b></td>
				<td><input type="text" name="author"
					value="<?php
					if (isset ( $training_module_obj->author ))
						echo $training_module_obj->author;
					?>"></td>
			</tr>
			<tr>
				<td><b>Module File</b></td>
              			<td><input type="file" name="module_file">
				<?php
				if (isset ( $training_module_obj->filename ))
              			{	echo '<a href="'.$this->config->item('base_url').'/uploads/training/'.$training_module_obj->filename.'"><br>'.$training_module_obj->filename.'</a> <br> (If you upload new file previous file will get replaced.)';}?>
				</td>
			</tr>

			<tr class="head">
				<td colspan="3"><b>Training Topics</b></td>
			</tr>
			<tr>
				<td colspan="3">
				<table border="0" width="100%" id="existingTopicTable">
					<tr class="head">
						<td width="20%"><b>Name</b></td>
						<td width="50%"><b>Description</b></td>
						<td width="30%"><b>File</b></td>
					</tr>

					<?php
					  if(isset($topics)) {
					 foreach ($topics as $topic) { ?>
					<tr class="approve">
						<td><?php echo $topic->name; ?></td>
						<td><?php echo $topic->description; ?></td>
              					<td><?php echo '<a href="'.$this->config->item('base_url').'uploads/training/'.$topic->filename.'">'.$topic->filename.'</a>';?>
					</tr>
					<?php }} ?>

				</table>
				<table border="0" width="100%" id="topicTable">
				<tr><td>Add New Topic</td><td></td><td></td> </tr>
	              		<input type="hidden" name="topicTableData" id="topicTableData" value="">
				</table>
				<tr>
					<td valign="top" width="40%" align="left"><b>Name</b></td>
					<td colspan="2">
					<input type="text" name="topic"	id="topic" class="topic" size="26"></td>
				</tr>
				<tr>
					<td valign="top" width="40%" align="left"><b>Description</b></td>
					<td colspan="2">
					<input type="text" name="t_description"	id="t_description" class="t_description" size="26"></td>
				</tr>
<!--				<tr>
					<td><b>Topic File</b></td>
              				<td><input type="file" name="t_file" id="t_file" class="t_file">
					</td>
				</tr> -->
				<tr><td></td><td></td><td align="right"><input type="button" class="submit" value="Add Topic" id="addTopicRow"></td>
			</tr>


			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="submit" value="Submit" id="submit_form_data"></td>
			</tr>
		</table>
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
