<script>
$(document).ready(function(){
	var hew = "<?php echo $hew_login ;?>";
	if(hew){		
		$('#visit_td').attr("width","8%");
	}
    	var visit_type = $("#visit_type").val(); 
	$('#show_visit').click(function() { // bind click event to link
    		$("#tabs").tabs('select', 0); // switch to third tab
    			return false;
	});
	$('#show_sub').click(function() { // bind click event to link
    		$("#tabs").tabs('select', 1); // switch to third tab
    			return false;
	});
	$('#show_pe').click(function() { // bind click event to link
		if(hew)
			$("#tabs").tabs('select', 1); // switch to third tab
		else	
			$("#tabs").tabs('select', 2); // switch to third tab
    			return false;
	});
	$('#show_lab').click(function() { // bind click event to link
		if(visit_type == 'Diagnostic')
	    		$("#tabs").tabs('select', 1); 
		else
	    		$("#tabs").tabs('select', 3); 
//    		$("#tabs").tabs('select', lab_index); // switch to third tab
    			return false;
	});
	$('#show_ass').click(function() { // bind click event to link
    		$("#tabs").tabs('select', 4); // switch to third tab
    			return false;
	});
	$('#show_plan').click(function() { // bind click event to link
    		$("#tabs").tabs('select', 5); // switch to third tab
    			return false;
	});
	$('#show_billing').click(function() { // bind click event to link
		if(visit_type == 'Diagnostic')
	    		$("#tabs").tabs('select', 2); 
		else
	    		$("#tabs").tabs('select', 6); 
    		return false;
	});
		
});
</script>

<table width="100%">
      <tr>
	<td id="visit_td"><a href='#' id="show_visit">Visit</a></td> 
<? if($visit_type !='Diagnostic'){ ?>
	<? if(!$hew_login) { ?> <td><a href='#' id="show_sub">Subjective</a></td> <?php } ?>
	<td><a href='#' id="show_pe">Physical Exam</a></td> 
<?php } ?>
	<? if(!$hew_login) { ?> <td><a href='#' id="show_lab">Lab</a></td> <?php } ?>
<? if($visit_type !='Diagnostic'){ ?>
	<? if(!$hew_login) { ?> <td><a href='#' id="show_ass">Assessment</a></td> 
	<td><a href="#" id="show_plan">Plan</a></td> <?php } ?>
<?php } ?>
	<? if(!$hew_login) { ?> <td><a href="#" id="show_billing">Billing</a></td>  <?php } ?>
     </tr>
</table>
