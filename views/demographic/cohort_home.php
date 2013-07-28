<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
     <script>
     	$(document).ready(function(){
			$.ajax({
				type: "GET",
				url: "<?php echo base_url()."index.php/demographic/cohort/get_all_cohorts";?>",
				dataType: "html",
				success: function(txt) {
					var editselect = $('#editcohortlist');
					var viewselect = $('#viewcohortlist');
					editselect.append(txt);
					viewselect.append(txt);
				}
			});
		});
     </script>
<table align="center" width="70%" border="1" cellpadding="5">
	<tr><td colspan="2" align="center"><b>Cohort</b></td></tr>
	<tr>
	<td>
		<?php echo '<a href="'.base_url().'index.php/demographic/cohort/create">Add Cohort</a>';?> 
	</td>
	</tr>
	<tr>
	<form <?php echo 'action="'.base_url().'index.php/demographic/cohort/view" method="post"'; ?>>
		<td>
		View summary
		</td>
		<td>
     		<select id="viewcohortlist" name="viewcohort"></select>
		<input type="submit" name="submit_edit"  value="View" class="submit" /> 
		</td>
	</form>
	</tr>
	<form <?php echo 'action="'.base_url().'index.php/demographic/cohort/modify"  method="post"';?>>
	<tr>
	
		<td>
		Edit Cohort
		</td>
		<td>
     		<select id="editcohortlist" name="editcohort"></select>
		<input type="submit" value="Edit" class="submit"/>
		</td>
	
	</tr>
	</form>
</table>
