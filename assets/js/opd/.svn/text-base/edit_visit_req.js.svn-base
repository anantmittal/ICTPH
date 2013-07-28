var enable;
var toggle;

// TODO - having disable getting assigned a function makes the HTML complain
// about the function not being defined. Unsure why this is happening
function disable (name) {
  $("#" + name).find("input").each(function (i) {
				     $(this).attr("disabled", "disabled");
				   });
}

$(document).ready(function(){
    $('#tabs').tabs();
    $('#datepicker').datepicker({dateFormat: 'dd/mm/yy', altField: "#date", altFormat: "yy-mm-dd"});

    // TODO - date not being stoerd in the right foramt. Have to figure out
    // why
    // TODO - There is nothing about these functions that should restrict
    // them only to edit_visit_req. Factor these out to a common set of
    // javascript functions, if such functions doesnt already exist

    
    enable = function (name) {
      $("#" + name).find("input").each(function (i) {
					 $(this).attr("disabled", false);
				       });
    };
		  });
