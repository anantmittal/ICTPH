alert("h3");
//$(document).ready(function(){
  // search_keys
		    alert("h2");
		    
  var module;
  var s_in;

  var what_options = "";

  /*
  for (var m in search_keys) {
    what_options += '<option value="' + m + '">' + search_key_displayed[m] + '</option>';
  }
		    
  alert(what_options);
		    */
  $("#s_module").html(what_options);

  $('#s_module').change(function () { 
    $("select option:selected").each(function () {
       $("select option:selected").each(function () { 
	 var module = $(this).val();
	 var options = "";
	 for (var w in search_keys[module]) {
	   options += '<option value="' + w + '">' + search_key_displayed[w] + '</option>';
	 }
	 $("#s_what").html(options);
					});
				     });
			});

  $('#s_in').change(function () {
    $("select option:selected").each(function () {
       $("select option:selected").each(function () { 
	 s_in = $(this).val();
	 var options = "";
	 for (var w in search_keys[module][s_in]) {
	   options += '<option value="' + w + '">' + search_key_displayed[w] + '</option>';
	 }
	 $("#s_by").html(options);
					});
				     });
		      });
  
  
  $('#s_search').click(function(){
    $.getJSON(
      base_url + 'index.php/' + module + '/common/search/check/' + s_in + '/' + $('#s_by').val() + '/' + $('#s_key').text(),
      function(success) {
        if (!success) {
	  $('#error_block').addClass('error');
	  $('#error_block').html("Invalid search key - no results found");
	  $('#error_block').show();
	} else {
	  window.location = base_url + 'index.php/' + module + '/common/search/results/' + s_in + '/' + ('#s_by').val() + '/' + $('#s_key').text();
	}
      }
      );
		       }
		       );
  
//		  }
//		  );
