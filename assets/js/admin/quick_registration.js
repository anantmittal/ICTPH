var is_head;
var is_not_head;

$(document).ready(function(){
  $('#member_dob0').datepicker({dateFormat: 'dd/mm/yy'});
  $('#member_dob1').datepicker({dateFormat: 'dd/mm/yy'});
  
  is_head = function() {
    $("#head_of_family").val(1);
    $("#household_head_details").hide();
  }

  is_not_head = function() {
    $("#head_of_family").val(2);
    $("#household_head_details").show();
  }
		  });
