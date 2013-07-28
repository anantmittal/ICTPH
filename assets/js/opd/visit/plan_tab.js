$(document).ready(function(){

  $('#chw_followup').click(function() {
     var url = base_url + "index.php/chw/followup/add_plan/project/" + $("#chw_project").val() + "/"+$("#person_id").val();
    window.open(url,"CHW followup plan","toolbar=no,location=no,directories=no,stauts=no,menubar=no,copyhistory=no");
//    $('#add_chw_followup').show();
			   });

 $(".chw").autocomplete(base_url + "index.php/common/autocomplete/chws", { width: 260,   selectFirst: false});
 $(".chw").result ( function(event, data, formatted) {
    if (data)
          $(this).parent().next().find("input").val(data[1]);
        });

		  });
