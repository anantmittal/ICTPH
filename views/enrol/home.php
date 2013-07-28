<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Data Collection Dashboard'));?>

<script
	type="text/javascript"
	src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script
	type="text/javascript"
	src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<table align="center" width="70%" border="1" cellpadding="5">
	<tr>
		<td><h2>
				<center>
					Mobile Data Collection Dashboard -
					<?php echo $name;?>
				</center>
			</h2></td>
	</tr>
	<tr>
		<td><h3>
				Message:
				<?php echo $this->session->userdata('msg');?>
			</h3></td>
	</tr>
</table>
<table align="center" width="70%" border="1" cellpadding="5">
	<tr>
		<td>Collection Statistics</td>

		<td>
			<table>
				<tr>
					<td>Agent-wise collection statistics: <a
						href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/agent_wise/'.$current_project;?>">Household</a>
						| <a
						href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/agent_wise_persons/'.$current_project;?>">Person</a>
						<?php if($tool == 'commcare')
				echo ' | <a href="'.$this->config->item('base_url').'index.php/enrol/enrol/agent_wise_rra/'.$current_project.'">RRA</a>';?>
					</td>
				</tr>
				<tr>
					<td>Village-wise completion statistics: <a
						href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/percent_complete/'.$current_project;?>">Household</a>
						| <a
						href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/village_wise_persons/'.$current_project;?>">Person</a>
						<?php if($tool == 'commcare')
				echo ' | <a href="'.$this->config->item('base_url').'index.php/enrol/enrol/percent_complete/'.$current_project.'">RRA</a>';?>
					</td>
				</tr>
				<tr>
					<td>Agent enrolment count table: <a
						href="<?php echo $this->config->item('base_url').'/index.php/enrol/enrol/agent_date_table/'.$current_project;?>">Household</a>
						<?php if($tool == 'commcare')
				echo ' | <a href="'.$this->config->item('base_url').'index.php/enrol/enrol/agent_date_table_rra/'.$current_project.'">RRA</a>';?>
					</td>
				</tr>

			</table>
		</td>
	</tr>

	<tr>
		<td>Date and Time Analysis</td>
		<td>
			<table>
				<tr>
					<td>Aggregated date-wise collection statistics <a
						href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/date_wise/'.$current_project;?>">Household</a>
						<?php if($tool == 'commcare')
				echo ' | <a href="'.$this->config->item('base_url').'index.php/enrol/enrol/date_wise/'.$current_project.'/0/rra">RRA</a>';?>
					</td>
				</tr>
				<tr>
					<form method="post">
						<td>Agent code: <select name="agent">
								<?php 
								foreach($agents as $a)
								{
									echo "<option value=\"".$a[1]."\">".$a[0]." (".$a[1].")</option>";
								}
								?>
						</select>&nbsp; <?php if($tool=='commcare')
							echo 'Data:<select name="record_type"> <option value="household">Household</option><option value="rra">RRA</option></select>';
						else
							echo '<input type="hidden" name="record_type" value="household"/>';
						?> <input type="hidden" name="action" value="date_wise"> <input
							type="submit" value="Date-wise stats for agent" />
						</td>
					</form>
				</tr>
				<tr>
					<td>Time-of-day completion statistics <a
						href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/time_of_day/'.$current_project;?>">Household</a>
						<?php if($tool == 'commcare')
				echo ' | <a href="'.$this->config->item('base_url').'index.php/enrol/enrol/time_of_day_rra/'.$current_project.'">RRA</a>';?>
					</td>
				</tr>

				<tr>
					<form method="post">
						<td>Agent code: <select name="agent">
								<?php 
								foreach($agents as $a)
								{
									echo "<option value=\"".$a[1]."\">".$a[0]." (".$a[1].")</option>";
								}
								?>
						</select>&nbsp; <?php if($tool=='commcare')
							echo 'Data:<select name="record_type"> <option value="household">Household</option><option value="rra">RRA</option></select>';
						else
							echo '<input type="hidden" name="record_type" value="household"/>';
						?> <input type="hidden" name="action" value="time_of_day"> <input
							type="submit" value="Time-wise stats for agent" />
						</td>
					</form>
				</tr>
				<tr>
					<td>Time taken to fill the forms statistics <a
						href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/time_taken_for_completion/'.$current_project;?>">Household</a>
						<?php if($tool == 'commcare')
				echo ' | <a href="'.$this->config->item('base_url').'index.php/enrol/enrol/time_taken_for_completion_rra/'.$current_project.'">RRA</a>';?>
					</td>
				</tr>
				<tr>
					<form method="post">
						<td>Agent code: <select name="agent">
								<?php 
								foreach($agents as $a)
								{
									echo "<option value=\"".$a[1]."\">".$a[0]." (".$a[1].")</option>";
								}
								?>
						</select>&nbsp; <?php if($tool=='commcare')
							echo 'Data:<select name="record_type"> <option value="household">Household</option><option value="rra">RRA</option></select>';
						else
							echo '<input type="hidden" name="record_type" value="household"/>';
						?> <input type="hidden" name="action"
							value="time_taken_for_completion"> <input type="submit"
							value="Completion Time stats for agent" />
						</td>
					</form>
				</tr>
				<td><a
					href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/worm/'.$current_project;?>">Progress
						against plan</a>
				</td>
				<tr>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Audit</td>
		<td><?php echo '<form  action ="'.base_url().'index.php/enrol/enrol/select_for_audit/'.$current_project.'" method="post"/>';?>
			Agent code: <select name="agent">
				<?php 
				foreach($agents as $a)
				{
					echo "<option value=\"".$a[1]."\">".$a[0]." (".$a[1].")</option>";
				}
				?>
		</select>&nbsp; <?php if($tool=='commcare')
			echo 'Data:<select name="record_type"> <option value="household">Household</option><option value="rra">RRA</option></select>';
		else
			echo '<input type="hidden" name="record_type" value="household"/>';
		?> Date (dd-mm-yyyy): <input name="formdate" id="formdate" type="text"
			class="datepicker_hyphen check_dateFormat" style="width: 140px;" /> <input
			type="hidden" name="action" value="select_for_audit"> <input
			type="submit" value="Select data for audit" />
			</form> <?php echo '<form  action ="'.base_url().'index.php/enrol/enrol/edit_by_card/'.$current_project.'" method="post"/>';?>
			Card number:<input type="text" name="cardnum" /><input type="submit"
			value="Edit Enrolment" />
			</form> <a
			href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/pending_audits/'.$current_project;?>">Pending
				audits</a>
		</td>
	</tr>
	<tr>
		<td rowspan="<?php echo (($tool=='odk')?3:4);?>">Synchronization</td>
		<td><a
			href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/sync_from_fusion';?>">Synchronize
				from Fusion Table</a></td>
	</tr>
	<tr>
		<td><?php echo '<form  enctype="multipart/form-data" action ="'.base_url().'index.php/enrol/enrol/upload_from_xml/'.$current_project.'" method="post"/>';?>
			XML file:<input type="file" name="xml_file" /> </br> <input type="submit" name="Upload" value="Upload data" />

			</form></td>
	</tr>
	<tr>
		<td><?php echo '<form  enctype="multipart/form-data" action ="'.base_url().'index.php/enrol/enrol/upload_from_csv/'.$current_project.'" method="post"/>';?>
			Household data file:<input type="file" name="household" /> <br />Individual
			data file:<input type="file" name="individual" /><br /> <input
			type="submit" name="Upload" value="Upload data" />

			</form></td>
	</tr>

	<?php
	if($tool == 'commcare')
	{
		echo '<tr><td>';
		echo '<form  enctype="multipart/form-data" action ="'.base_url().'index.php/enrol/enrol/upload_rra_from_csv/'.$current_project.'" method="post"/>';
		echo 'RRA data file:<input type="file" name="rra" /><br/>';
		echo '<input type="submit" name="Upload" value="Upload data"/>';
		echo '</td></tr>';
	}
	?>

	<tr>
		<td>Errors</td>
		<td><a
			href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/indi_count_mismatch/'.$current_project;?>">Mismatch
				in individual count</a><br /> <a
			href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/rra_for_missing_indi/'.$current_project;?>">RRAs
				with no individual record</a> <br /> <a
			href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/relation_duplicate_entries/'.$current_project;?>">Duplicate
				Relationship entries</a>
		</td>
	</tr>

	<tr>
		<td>Export</td>
		<td><a
			href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/export_household/'.$current_project;?>">Export
				household data</a><br /> <a
			href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/export_individual/'.$current_project;?>">Export
				individual data</a>
		</td>
	</tr>
	<tr>
		<td>Configuration</td>
		<td><a
			href="<?php echo $this->config->item('base_url').'index.php/enrol/enrol/configuration';?>">Edit
				Project Configuration</a><br />
		</td>

</table>
<?php $this->load->view('common/footer.php'); ?>
