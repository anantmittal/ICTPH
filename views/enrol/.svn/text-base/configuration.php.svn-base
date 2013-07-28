<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Data Collection Project Configuration'));?>

<table align="center" width="70%" border="1" cellpadding="5">
<tr> <td><h2><center>Data Collection Project Configuration</center></h2></td></tr>
<tr> <td><h3>Message: <?php echo $this->session->userdata('msg');?></h3></td></tr>
</table>
<br/>

<center><table border ="1px" width ="70%">
	<tr><td>User:</td><td><?php if(isset($username)) echo $username;?></td>
	</tr>
	
	<tr><td>Currently selected project:</td><td>
					<?php 
					if(isset($current_project_name) && $current_project_name!=NULL) 
						echo $current_project_name;
					else 
						echo 'None';?>							
				</td>
	</tr>
	
	<tr>
		<td>Select project</td>
		<td>
			<form method="post" action="<?php echo base_url();?>index.php/enrol/enrol/select_current_project">
			<select name="current_project">
				<?php foreach($project_list as $project_code => $project_name)
				{
					if($project_code != $current_project)
						echo '<option value='.$project_code.'>'.$project_name.'</option>';
				}?>
			</select><input type=submit value="Set as current project" <?php if(count($project_list)==0) echo 'disabled="disabled"';?>/>
			</form>
		</td>
	</tr>
	
	<tr>
		<td rowspan=2>Project Configuration</td>
		<td> <a href="<?php echo base_url();?>/index.php/enrol/enrol/project_create"/>Create new project</a></td>
	</tr>
	<tr>
		<td>
			<form method="post" action="<?php echo base_url();?>index.php/enrol/enrol/edit_project">
			<select name="project_edit">
				<?php foreach($project_list as $project_code => $project_name)
				{
					echo '<option value='.$project_code.'>'.$project_name.'</option>';
				}?>
			</select><input type=submit value="Edit project" <?php if(count($project_list)==0) echo 'disabled="disabled"';?>/>
			</form>
		</td>
	</tr>
		

</table><center>

<?php $this->load->view('common/footer.php'); ?>
