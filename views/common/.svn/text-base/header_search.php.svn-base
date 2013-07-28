<!-- TODO - the map below should be generated from a config file -->
<script language="javascript">
//   var search_keys = { "opd":{"policy": ["id"]}, "ipd": {"hospitalisation": ["id"]} };
//   var search_key_displayed = { "opd": "OPD", "policy": "Policy", "id": "ID", "ipd": "IPD", "hospitalisation": "Hospitalisation"};

   var search_keys = { 
			"opd": {
			    "household": ["policy_id","phone_no"],
			    "visit": ["date","id"],
			    "clinic": ["id","name"],
			    "doctor": ["id","name"]
			}, 
			"hospitalization": {
			    "household": ["policy_id","name"],
			    "hospital": ["id","name"]
			}, 
			"admin": {
				"household": ["policy_id","name"]
			}, 
			"chw": {
				"household": ["policy_id","name"],
			    "project": ["id","name"],
			    "chw": ["id","name","hamlet","village","taluka","district"],
			    "chw_group": ["id","name","hamlet","village","taluka","district"],
			    "training": ["id","name"]
			} 
		     };
   var search_key_displayed = { "opd": "OPD", "phone_no" : "Phone Number","visit": "Visit", "date": "Date", "household": "Household", "admin": "Enrollment","policy_id": "Policy ID","id": "ID", "hospitalization": "IPD", "name": "Name", "hospital": "Hospital", "clinic": "Clinic", "doctor":"Provider","chw": "CHW", "project": "Project", "chw_group": "CHW Group", "training":"Training Module","hamlet": "Hamlet","village":"Village/City","taluka":"Taluka","district":"District" };
$(document).ready(function(){

  var s_in;

  $('#s_module').change(function () { 
    $("select option:selected").each(function () {
      var module = $('#s_module').val();
      var options = "";
      for (var w in search_keys[module]) {
	options += '<option value="' + w + '">' + search_key_displayed[w] + '</option>';
      }
      $("#s_in").html(options).change();
	});
			});

  $('#s_in').change(function () {
    $("select option:selected").each(function () {
      var module = $('#s_module').val();
      var s_in = $('#s_in').val();

      var options = "";
      var in_keys = search_keys[module][s_in];
      for (var b in in_keys) {
	options += '<option value="' + in_keys[b] + '">' + search_key_displayed[in_keys[b]] + '</option>';
      }
      $("#s_by").html(options);
				     });
		    });
  
  $('#s_search').click(function(){
    var module = $('#s_module').val();
    var s_in = $('#s_in').val(); 
   // alert(module+' '+s_in+' '+$('#s_by').val()+' '+$('#s_key').val());   
    $.getJSON(
      base_url + 'index.php/' + module + '/search/check/' + s_in + '/' + $('#s_by').val() + '/' + $('#s_key').val(),
      function(success) {
    	  
        if (!success) {
	  $('#error_block').addClass('error');
	  $('#error_block').html("Invalid search key - no results found");
	  $('#error_block').show();
	} else {
		
	  window.location = base_url + 'index.php/' + module + '/search/results/' + s_in + '/' + $('#s_by').val() + '/' + $('#s_key').val();
	}
      }
      );
		       }
		       );

  var module_options = "";
  var first_module = false;

  for (var m in search_keys) {
    if (!first_module)
      first_module = m;
    module_options += '<option value="' + m + '">' + search_key_displayed[m] + '</option>';
  }
		    
  $("#s_module").html(module_options).change();//.trigger('change');
		  });
</script>

<!-- <script type="text/javascript" src='<?php echo $this->config->item("base_url")."assets/js/common/header_search.js";?>'></script>-->
<!-- <script type="text/javascript" src="foo"></script> -->

<div class="search_box">
      <span class="form_head">
  <div class="search_left">

	Module
	<select name="s_module" id="s_module" >
	</select>

	Search
	<select name="s_in" id="s_in" >
	</select>
	
	By
	<select name="s_by" id="s_by" >
	</select>

	<input name="s_key" id="s_key" type="text" value="" size=11 />
	<input type="button" id="s_search" class="submit" value="Go">	
    
    </div>   
    <div class="search_right">Welcome <?php echo $this->session->userdata('username')?>, 
      <a href="<?php echo $this->config->item('base_url');?>index.php/admin/user_management/change_password">Change Password</a>,
      <a href="<?php echo $this->session->userdata('home');?>">Home</a>,
      <a href="<?php echo $this->config->item('base_url');?>index.php/session/session/logout">Logout</a></div>
      </div>
      
      </span>

      <div style="display:none;" id="error_block" ></div>
      <?php $msg_type = $this->session->flashdata('msg_type');
      //$msg_type can be 'error', 'success'

      if($msg_type != false) { ?> 
      <div class="<?php if ($msg_type === 'error') echo 'error'; else echo 'success'?>">
		<?php echo $this->session->flashdata('msg'); 
      		if($msg_type === 'success' ){
      			$filename= $this->session->flashdata('filename');
      			$filetype =$this->session->flashdata('filetype');
      			if(!empty($filename)){
      			?>
      			
      			<br /><div><a href="<?php echo $this->config->item('base_url').$filename; ?>">Download <?php echo $filetype; ?> Report</a></div>
				<?php }}
		?> 
      </div>
      <?php } ?>
      
