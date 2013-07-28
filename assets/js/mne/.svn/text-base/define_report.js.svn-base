$(document).ready(function() {
	var selected_table_name = '';
	var table_cnt = 0;
	var row_cnt   = 1;
	var join_fields = Array();

	$('#add_table').click(function() {
		selected_table_name = $('#table_name :selected').val();
		var url = base_url +'index.php/monitoring_evaluation/report/table_fields';
		var selected_table = $('#table_name').val();
		var join_select    = '';
		var agg_fun_select = '';

		$.post(url, {table_name:selected_table},function(data) {
				if(data.result == 'success') {
					var cnt          = 0;
					var rows         = '';
					var total_fields = data.fields.length;
					var radio_status = '';
					var join_filds_options;

					if(row_cnt == 1) {
						radio_status = 'disabled';
					} else {
						var i = 0;
						var join_fields_length = join_fields.length;

						for(i = 0; i< join_fields_length;  i++) {
							join_filds_options += '<option value="'+ join_fields[i] +'">'+ join_fields[i] +'</option>';
						}
					}

					$('.new_row').each(function(){
						$(this).remove();
					});


					for(cnt = 0; cnt < total_fields; cnt ++) {
						join_select = '<select id="' + data.fields[cnt] + '_join_field" >'+ join_filds_options +'</select>';

						agg_fun_select = '<select id="' + data.fields[cnt] + '_aggr_fun"> <option value="false">Select Fun...</option>  <option value="identity">Identity</option>  <option value="sum">Sum</option>  <option value="min">Min</option>   <option value="max">Max</option>    <option value="avg">Average</option>  <option value="count">Count</option></select>';

						rows += '<tr id="' + data.fields[cnt] + '" class="new_row">';
						rows += '<td><input type="checkbox"  class="field_row" id="' + data.fields[cnt] + '_select"></td>';
						rows += '<td>' + data.fields[cnt] + '</td>';
						rows += '<td>&nbsp;<div id="' + data.fields[cnt] + '_join_div"  style="Display:none;"> <input type="radio" name="' + data.fields[cnt] + '_join" value="yes" ' + radio_status + '  class="join">Yes <input type="radio" name="' + data.fields[cnt] + '_join" value="no"  class="join">No </div> </td>';
						rows += '<td>&nbsp;<div id="' + data.fields[cnt] + '_join_cols" style="Display:none;">'+ join_select +'</div> </td>';
						rows += '<td>&nbsp;<div id="' + data.fields[cnt] + '_grp_by"    style="Display:none;"><input type="radio" name="' + data.fields[cnt] + '_group_by" value="yes" class="group_by">Yes   <input type="radio" name="' + data.fields[cnt] + '_group_by" value="no"  class="group_by">No </div></td>';
						rows += '<td>&nbsp;<div id="' + data.fields[cnt] + '_aggregate"    style="Display:none;">'+agg_fun_select+'</div></td>';
						rows += '</tr>';
						$(rows).insertAfter($('#field_add_table tr:last'));
						rows  = '';
					}
				}
		},'json');
	});



	$('.field_row').live('click', function(){
			 var tr_obj = $(this).closest('tr');
			 var tr_id  = $(this).closest('tr').attr('id');

			 /*$(tr_obj).children().each(function(){
			 	alert($(this).html());
			 });*/

			 var flag       = $(this).attr('checked');
			 if(flag == true) {
				$('#'+tr_id+'_join_div').show();
			 } else {
			 	$('#'+tr_id+'_join_div').hide();
			 	$('#'+tr_id+'_join_cols').hide();
			 	$('#'+tr_id+'_grp_by').hide();
			 	$('#'+tr_id+'_aggregate').hide();
			 }
	});

	$('.join').live('click', function(){
		var tr_id     = $(this).closest('tr').attr('id');
		var radio_val = $(this).val();

		if(radio_val == 'yes') {
			$('#'+tr_id+'_join_cols').show();
			$('#'+tr_id+'_grp_by').hide();
			$('#'+tr_id+'_aggregate').hide();
		} else if(radio_val == 'no') {
			$('#'+tr_id+'_join_cols').hide();
			$('#'+tr_id+'_grp_by').show();
		}
	});


	$('.group_by').live('click',function(){
		var tr_id        = $(this).closest('tr').attr('id');
		var group_by_val = $(this).val();

		if(group_by_val == 'yes') {
			$('#'+tr_id+'_aggregate').hide();
		} else if(group_by_val == 'no') {
			$('#'+tr_id+'_aggregate').show();
		}
	});


	$('#add_fields').click(function(){
		var abort         = false;
		var form_data_str = '';
		var field_cnt     = 0;
//		form_data_str = '<input type="hidden" name="form_data['+selected_table_name+'][table_name]" value="'+ selected_table_name+'">';


		$('.field_row').each(function(){
			var tr_id      = $(this).closest('tr').attr('id');
			var field_name = tr_id;
			var flag       = $(this).attr('checked');
			var row        = '';
			var join_val   = '';
			var join_field = '';
			var group_by   = '';
			var aggr_fun   = '';

			if(abort == true)
				return;


			if(flag == true) {

			  	join_val = $("input[name='"+ tr_id +"_join']:checked").val();
				row  = '<tr><td>Table</td><td>'+selected_table_name+'</td><td>'+field_name+'</td>';

				join_fields.push(selected_table_name+'.'+tr_id);

				if(join_val) {

					if(join_val == 'yes') {
						join_field = $('#'+ tr_id +"_join_field :selected").val();
						form_data_str += '<input type="hidden" name="schema_data['+selected_table_name+']['+ field_name +'][join_column]" value="'+join_field+'">';
						row += '<td>'+join_field+'</td><td>&nbsp;</td><td>&nbsp;</td>';
					} else { //if join_val == no
						row += '<td>&nbsp;</td>';
						group_by = $("input[name='"+ tr_id +"_group_by']:checked").val();

						if(group_by == 'no') {
							aggr_fun = $('#'+ tr_id + '_aggr_fun :selected').val();
							form_data_str += '<input type="hidden" name="schema_data['+selected_table_name+']['+ field_name +'][aggr_fun]" value="'+aggr_fun+'">';
							if(aggr_fun == 'false')
								row += '<td>&nbsp;</td><td>&nbsp;</td>';
							else
								row += '<td>&nbsp;</td><td>'+aggr_fun+'</td>';
						} else { //if group_by == 'yes'
							row += '<td>Yes</td><td>&nbsp;</td>';
							form_data_str += '<input type="hidden" name="schema_data['+selected_table_name+']['+ field_name +'][group_by]" value="yes">';
						}
					}

					$('#fields_table tr:last').after(row);

				} else {
					alert('Please select "Join With" for "'+ tr_id +'" Column.');
					abort = true;
					return;
				}
			}

		});

		if(abort == false) {
			$('#form_data').append(form_data_str);
			$('.new_row').each(function(){
				$(this).remove();
			});
			alert('data added')
		}
//		alert(join_fields);
		row_cnt ++;
	});

	var con_cnt = 0;
	$('#add_filter').click(function(){
		var field      = $('#cond_field :selected').val();
		var operator   = $('#operator :selected').val();
		var comp_value = $('#comp_value').val();
		var filter_row = '<tr><td>'+field+'</td><td>'+operator+'</td><td>'+comp_value+'</td>';
		$('#filter_table tr:last').after(filter_row);

		var conditions = '<input type="hidden" name="conditions['+con_cnt+'][field]" value="'+ field +'">';
			conditions += '<input type="hidden" name="conditions['+con_cnt+'][operator]" value="'+operator+'">';
			conditions += '<input type="hidden" name="conditions['+con_cnt+'][comp_value]" value="'+ comp_value +'">';
		con_cnt ++;

		$('#form_data').append(conditions);
	});
});