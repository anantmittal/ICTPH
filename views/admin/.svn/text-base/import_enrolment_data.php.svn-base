<?php $this->load->view('common/templateheader',array('title'=>'Import pre-enrolment data'));?>

<script language="javascript">
var geo_keys = { 
			<?php echo $geo_tree;?>
		     };

	$(document).ready(function(){

		  var s_district;

		  $('#s_state').change(function () { 
		    $("select option:selected").each(function () {
		      var state = $('#s_state').val();
		      var options = "";
			var state_id = geo_keys[state][0];
			var district_list = geo_keys[state][1];
		      for (var w in district_list) {
			
			options += '<option value="' + w + '">' + w + '</option>';
		      }
		      $("#s_district").html(options).change();
			});
					});

		  $('#s_district').change(function () {
		    $("select option:selected").each(function () {
		      var state = $('#s_state').val();
		      var s_district = $('#s_district').val();

		      var options = "";
			var district_map = geo_keys[state][1];
		      var taluk_map = district_map[s_district][1];
		      for (var b in taluk_map) {
			options += '<option value="' + taluk_map[b] + '">' + b + '</option>';
		      }
		      $("#s_taluka").html(options);
				     });
		    });
  
 

  var state_options = "";
  var first_state = false;

 for (var m in geo_keys) {
    if (!first_state)
      first_state = m;
    state_options += '<option value="' + m + '">' + m + '</option>';
  }
		    
  $("#s_state").html(state_options).change();//.trigger('change');
		  });
</script>

<div id="main">
<div class="hospit_box">

<div class="green_left"><div class="green_right">
<div class="green_middle"><span class="head_box">Import Enrolment Data</span></div></div></div>
<div class="green_body">
<form enctype="multipart/form-data" method="POST">
<center><table border="1px" width="60%">
<tr><td>
	<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
	<b>Choose household file</b>:</td><td> <input name="householdfile" type="file" /><br />
</td></tr>
<tr><td>
	<b>Choose individual file</b>:</td><td> <input name="individualfile" type="file" /><br />
</td></tr>
<tr><td>
	State</td><td>
	<select name="s_state" id="s_state" >
	 
	</select>
</td></tr>
<tr><td>
	District</td><td>
	<select name="s_district" id="s_district" >
	</select>
</td></tr>
<tr><td>
	Taluka</td><td>
	<select name="s_taluka" id="s_taluka" >
	</select>
</td></tr>
<tr>
	<td>RMHC</td>
	<td><select name="rmhc_location">
	<?php foreach($clinics as $rmhcname => $rmhccode)
		{
			echo '<option value='.$rmhccode.'>'.$rmhcname.'</option>';
		}
	?>
	</select></td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="Import data" />
</td>
</tr>
</table></center>
</form>

</div>
<div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
</div>
</div>
<?php $this->load->view('common/footer.php'); ?>
