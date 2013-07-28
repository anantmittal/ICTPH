
<?php $this->load->view('survey/plsp/templateheader',array('title'=>$title));?>
<script type="text/javascript">
	var cnt=new Array();
	$(document).ready(function(){
		$('.dynamicadd').click(clickhandler);

	});
	function clickhandler() {
			var id;
			var itercount = $(this).attr("inputfieldcount");
			var arr_vals=new Array();
			for(var temp=0;temp<itercount;temp++)
			{
				var text_val = $("#"+($(this).attr("inputfieldprefix"))+temp).val();
				arr_vals.push(text_val);
			}
			addRow($(this).attr("id"), $(this).attr("targettable"), arr_vals);
		}
	function addRow(type, tableid, arr_vals)
	{
		if(cnt[type] == undefined)
			cnt[type]=0;
		localctr = cnt[type];
		var row = '<tr class="approve">';
		row += '<td onmousedown="removeRow(this)" align="center"><input type="checkbox">Remove</td>';
		for(var index_arr in arr_vals)
		{
			row += '<td><input type="hidden" name="tables['+type+']['+localctr+']['+index_arr+']" value="' + arr_vals[index_arr]+'">'+ arr_vals[index_arr]+'</td>';
		}
		row += '</tr>';
		localctr ++;
		cnt[type] = localctr;
		$('#'+tableid+' tr:last').after(row);
	}
	function removeRow(row) {
		$(row).parent().remove();
	}
</script>
<?php echo '<center><h3>'.$title.'</h3></center>';?>
<form method="post">
<center><table border ="0px">
<tr>
	<td>Name:</td>
	<td> <input type="text" name="name" <?php if(isset($name)) echo 'value="'.$name.'" ';?>/></td>
</tr>	
<tr>
	<td>RMHC:</td>
	<td> <select name="location_id">
			<?php foreach($locations as $rmhcname => $rmhccode)
			{
				$appendstr="";
				if(isset($location_id) && $location_id == $rmhccode)
					$appendstr = 'selected="selected"';
				echo '<option value="'.$rmhccode.'" '.$appendstr.'>'.$rmhcname.'</option>';
			}?>
		</select>
	</td>
</tr>
<tr>
	<td>Enrollment toolkit:</td>
	<td> <select name="tool">
			<?php foreach($toolkit_options as $toolname => $toolcode)
			{
				$appendstr="";
				if(isset($tool) && $tool == $toolcode)
					$appendstr = 'selected="selected"';
				echo '<option value="'.$toolcode.'" '.$appendstr.'>'.$toolname.'</option>';
			}?>
		</select>
	</td>
</tr>
<tr>
	<td>Status:</td>
	<td> <select name="status">
			<?php foreach($status_options as $statusdisp => $statuscode)
			{
				$appendstr="";
				if(isset($status) && $status == $statuscode)
					$appendstr = 'selected="selected"';
				echo '<option value="'.$statuscode.'" '.$appendstr.'>'.$statusdisp.'</option>';
			}?>
		</select>
	</td>
</tr>
<tr>
	<td>Start date (yyyy-mm-dd):</td>
	<td> <input type="text" name="start_date" <?php if(isset($start_date)) echo 'value="'.$start_date.'" ';?>/></td>
</tr>
<tr>
	<td>Planned End date (yyyy-mm-dd):</td>
	<td> <input type="text" name="target_end_date" <?php if(isset($target_end_date)) echo 'value="'.$target_end_date.'" ';?>/></td>
</tr>
<tr>
	<td>Target Enrolments(No. of households):</td>
	<td> <input type="text" name="target_enrolments" <?php if(isset($target_enrolments)) echo 'value="'.$target_enrolments.'" ';?>/></td>
</tr>
<tr>
	<td>Actual End date (yyyy-mm-dd):</td>
	<td> <input type="text" name="actual_end_date" <?php if(isset($actual_end_date)) echo 'value="'.$actual_end_date.'" ';?>/></td>
</tr>
<tr><td colspan=2><br/><br/></td></tr>
<tr>
	<td>Agents/Guides:</td>
	<td>
		
			
			Agent/Guide Name : <input type="text" id="agent_details0">
			Code : <input type="text" id="agent_details1" size=3>
			Device ID : <input type="text" id="agent_details2" size=16>
			<input type="button" id="agents" value="Add" class="dynamicadd" inputfieldprefix="agent_details" inputfieldcount="3" targettable="agentTable">
			
			<table border="0" align="center" width="100%" id="agentTable">
				<tr class="head">
					<td colspan="8" align="center">Agents or Guides</td>
				</tr>
				<tr class="head">
					<td></td>
					<td>Name</td>
					<td>Code</td>
					<td>Device ID</td>
				</tr>
			</table>
		<?php if(isset($agents) || isset($_POST))
		{
			$agent_list = array();
			if(isset($agents))
				$agent_list = $agents;
			else if(array_key_exists('tables', $_POST))
				$agent_list = $_POST['tables']['agents'];
			echo '<script type="text/javascript">';
			foreach($agent_list as $agentdetails)
			{
				echo 'addRow("agents","agentTable",["'.$agentdetails[0].'","'.$agentdetails[1].'","'.$agentdetails[2].'"]);';
			}
			echo '</script>';
		}
		?>
		

	</td>
	</tr>
	<tr><td colspan=2><br/><br/></td></tr>
	<tr>
	<td>Villages:</td>
	<td>
		
			<center>
			Village name : <input type="text" id="village_details0">
			Projected population : <input type="text" id="village_details1" size=3>
			Street field : <input type="text" id="village_details2">
			
			<input type="button" id="villages" value="Add" class="dynamicadd" inputfieldprefix="village_details" inputfieldcount="3" targettable="villageTable">
			</center>
			<table border="0" align="center" width="100%" id="villageTable">
				<tr class="head">
					<td colspan="8" align="center">Village Details</td>
				</tr>
				<tr class="head">
					<td></td>
					<td>Name</td>
					<td>Population</td>
					<td>Street Field</td>
				</tr>
			</table>
		<?php if(isset($villages) || isset($_POST))
		{
			$village_list = array();
			if(isset($villages))
				$village_list = $villages;
			else if(array_key_exists('tables', $_POST))
				$village_list = $_POST['tables']['villages'];
			echo '<script type="text/javascript">';
			foreach($village_list as $villagedetails)
			{
				echo 'addRow("villages","villageTable",["'.$villagedetails[0].'","'.$villagedetails[1].'","'.$villagedetails[2].'"]);';
			}
			echo '</script>';
		}
		?>
		

	</td>

</tr>
<tr>
	<td colspan="2"><center><input type=submit value="Save"/></center></td>
</tr>
</table><center>
</form>
<?php $this->load->view('common/footer.php'); ?>
