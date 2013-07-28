$('.granularity').click(function(){
		var granularity = $(this).val();

		if(granularity == 'household') {
			$('#household_tab').show();
			$('#person_tab').show();
			$('#household').show();
		} else if(granularity == 'person') {
			$('#household_tab').hide();
			$('#household').hide();

			$('#person_tab').show();
			$("#tabs").tabs("select", 1);

			$('#person').show();

		} else if(granularity == 'area') {
			$('#household_tab').hide();
			$('#person_tab').hide();
		}
	});

	$('.survey_type').click(function(){
			var survey_type =  $(this).val();
//			alert(survey_type);
			if(survey_type == 'demographic') {
				$('#demographic_div').show();
				$('#geographic_div').hide();
			}
			else {
				$('#geographic_div').show();
				$('#demographic_div').hide();
			}
		});