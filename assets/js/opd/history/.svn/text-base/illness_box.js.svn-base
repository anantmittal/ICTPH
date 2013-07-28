$(document).ready(function(){
  $('#add_illness').click(function() {
    $('#edit_illness_box').show();
			  });
  
  $("#illness_start_date").datepicker();
  
  $('#illness_submit').click(function() {
    var field_map = { name: "illness_name",
		      status: "illness_status",
		      start_date: "illness_start_date"
    };
      
    var illness_data = {};
    for (var k in field_map)
      illness_data[k] = $("#" + field_map[k]).val();
    // illness_data = {illness: "", status: "", start_date: ""};

    var f1 = function(illness_data, xml) {
      // Update the illness box to add a row for the newly addess
      // illne ss format and output result
      error = $("status", xml).text() == "error";
      msg = $("msg", xml).text();
      

      if (error) {
	$('#error_block').addClass('error');
      } else {
	$('#error_block').addClass('success');

	var color;
	if (illness_data["status"] == "Current")
	  color = "red_bg";
	else
	  color = "grey_bg";
	$("#illnesses").append('<tr class="' + color + '"><td>'
			       + illness_data["name"]
			       + '</td><td>' + illness_data["status"]
			       + '</td><td>' + illness_data["start_date"]
			       + '</td><td/><td/><td/><td/></tr>');
      }
      $('#error_block').html(msg);
      $('#error_block').show();      
    };

    var f2 = function(illness_data) {
      var f3 = function(xml) {
	return f1(illness_data, xml);
      };
      return f3;
    };

    $.post(base_url + "index.php/opd/history/add_illness/" + person_id,
	   illness_data,
	   f2(illness_data));
			     });
		  });
