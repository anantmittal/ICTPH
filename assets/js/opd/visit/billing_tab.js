$(document).ready(
		function() {
			$("#load_to_billing").click(function() {
				/*
				 * Trying to remove the hard code of medicated and test items
				 * */

				//TO clear cost table before adding new rows
				$("#cost_table tr:gt(0)").remove();
				$("#test_cost_table tr:gt(0)").remove();
				
				var i = 1;
				var product_ids = {};
				var total = 0;
				
				//To populate medication costs
				$("tr[name^=medication_row]").each(function() {
					var id = $(this).find('#product_id').val();
					if (id != undefined) {
						var type = $(this).find('#type').val();
						var name = $(this).find('#name').val();
						var freq = $(this).find('#frequency').val();
						var dur = $(this).find('#duration').val();
						var rate = $(this).find('#rate').val();
						var dur_type = $(this).find('#duration_type').val();
						var freq_num = 1;
						if (freq == 'TID') {
							freq_num = 3;
						} else if (freq == 'BID') {
							freq_num = 2;
						}
						var qty = 1;
						var route = $(this).find('#administration_route').val();
						if (route == "Oral Solid") {
							qty = freq_num * dur;
						}

						product_ids[i-1] = id;
						total += update_cost_table(id,name,qty,rate,type,i,freq,dur,route,dur_type);
					} 
					i++;
				});
				
				//To populate OP Products costs
				$("tr[name^=opd_product_row]").each(function() {
					var id = $(this).find('#product_id').val();
					if (id != undefined) {
						var type = $(this).find('#type').val();
						var name = $(this).find('#name').val();
						var qty = $(this).find('#pieces').val();
						var prod_given = $(this).find('#product_given_out').val();
						var rate = $(this).find('#rate').val();
						
						product_ids[i-1] = id;
						total += update_cost_table(id,name,qty,rate,type,i,'','','','',prod_given);
					} 
					i++;
				});
				
				//To populate Service costs
				$("tr[name^=service_row]").each(function() {
					var id = $(this).find('#service_id').val();
					if (id != undefined) {
						var type = $(this).find('#type').val();
						var name = $(this).find('#name').val();
						var qty = 1;
						var rate = $(this).find('#rate').val();
						
						product_ids[i-1] = id;
						total += update_cost_table(id,name,qty,rate,type,i);
					} 
					i++;
				});
				var s = '<tr>'
						+'<td><b>Total</b></td>'
						+'<td></td>'
						+'<td></td>'
						+'<td id="cost_items_medications_total">'+parse_round_number(total)+'</td>'
						+'</tr>';
				$("#cost_table").append(s).show('slow');

				//For test we need to start total as zero
				total = 0;
				//To populate tests
				$("input:radio[name^='tests']:checked").each(function() {
					var result='';
					if($(this).val() != "NA"){
						var element_id = $(this).attr('id');
						var elements = element_id.split("_");
						if(elements.length == 4){ //Array length less than 4 will the subtype and which it is not taken care in billing section
							var row_index = elements[1];
							var id = $("#tests_" + row_index + "_id").val();
							var name = $("#tests_" + row_index + "_name").val();
							var rate = $("#tests_" + row_index + "_cost").val();
							if($("#tests_" + row_index + "_test_type").val()=='radio'){
								result = $("input:radio[name='tests["+row_index+"][result]']:checked").val();
							}else{
								result = $("#tests_" + row_index + "_result").val();
							}
							var type="test";
							var qty = 1;
							product_ids[i-1] = id;
							total += update_cost_table(id,name,qty,rate,type,i,'','','','','',result);
							i++;
						}
						
					}
					
				});
				
				var s = '<tr>'
					+'<td><b>Total</b></td>'
					+'<td></td>'
					+'<td id="cost_items_tests_total">'+parse_round_number(total)+'</td>'
					+'</tr>';
				$("#test_cost_table").append(s).show('slow');
				compute_total();
			});

			var update_cost_table = function(id,name,qty,rate,type,index,freq,dur,route,dur_type,prod_given,result){
				
				var cost = qty * rate;
				var s ='<tr id="cost_items_'+index+'_row">';
						s+='<td>'
							+'<span id="cost_items_'+index+'_name_visible">'+name+'</span>'
							+'<input type="hidden" id="cost_items_'+index+'_name" name="'+type+'[' + index + '][name]" value="'+name+'"/>'
							+'<input type="hidden" id="cost_items_'+index+'_type" name="'+type+'[' + index + '][type]" value="'+type+'" />'
							+'<input type="hidden" id="cost_items_'+index+'_subtype" name="'+type+'[' + index + '][subtype]" value="'+name+'"/>'
							+'<input type="hidden" id="cost_items_'+index+'_index" name="'+type+'[' + index + '][index]" value="'+index+'"/>'
							+'<input type="hidden" id="cost_items_'+index+'_prod_status" name="'+type+'[' + index + '][product_given_out]" value="'+prod_given+'"/>'
							+'<input type="hidden" id="cost_items_'+index+'_id" value="'+id+'" />'	
							+'<input type="hidden" id="cost_items_'+index+'_rate" name="'+type+'[' + index + '][rate]" value="'+rate+'"/>';
						if(type === "services"){
							s += '<input type="hidden" id="cost_items_'+index+'_id" name="'+type+'[' + index + '][service_id]" value="'+id+'" />';
						}else{
							s += '<input type="hidden" id="cost_items_'+index+'_id" name="'+type+'[' + index + '][product_id]" value="'+id+'" />'
							+'<input type="hidden" id="cost_items_'+index+'_result" name="'+type+'[' + index + '][result]" value="'+result+'" />';
						}
						
						//Special case for medication we need to store this values also.	
						if(freq != null ||  freq != undefined ){
							s+='<input type="hidden" id="cost_items_'+index+'_freq" name="'+type+'[' + index + '][frequency]" value="'+freq+'"/>';
						}
						if(dur != null ||  dur != undefined ){
							s+='<input type="hidden" id="cost_items_'+index+'_dur" name="'+type+'[' + index + '][duration]" value="'+dur+'"/>';
						}
						if(route != null ||  route != undefined ){
							s+='<input type="hidden" id="cost_items_'+index+'_route" name="'+type+'[' + index + '][administration_route]" value="'+route+'"/>';
						}
						if(dur_type != null ||  dur_type != undefined ){
							s+='<input type="hidden" id="cost_items_'+index+'_dur_type" name="'+type+'[' + index + '][duration_type]" value="'+dur_type+'"/>';
						}
						
						s+='</td>'
						+'<td>';
						if(type !== "services"){
							if(type === "test"){
								s+='<input type="text" name="'+type+'[' + index + '][number]" id="cost_items_'+index+'_number" value="'+qty+'" onChange="update_test_table();"/>';
							}else{
								s+='<input type="text" name="'+type+'[' + index + '][number]" id="cost_items_'+index+'_number" value="'+qty+'" onChange="update_medication_table();"/>';
							}
						}else{
							s+='<input type="hidden" name="'+type+'[' + index + '][number]" id="cost_items_'+index+'_number" value="1" />';
							s+='&nbsp;';
						}
						
						s+='</td>'
						+'<td id="cost_items_'+index+'_rate_visible">'
						+rate+'</td>';
						if(type !== "test"){
							s+='<td id="cost_items_'+index+'_total">'+parse_round_number(cost)+'</td>';
						}
						s+='</tr>';
				if(type === "test"){
					$("#test_cost_table").append(s).show('slow');
				}else{
					$("#cost_table").append(s).show('slow');
				}
				return cost;
			};
			
			$("#cost_items_consultation").change(compute_total);
			$("#cost_items_tests_total").change(compute_total);
			$("#cost_items_medications_total").change(compute_total);
		});

function parse_round_number(num) {
	num = parseFloat(num);
	var result = Math.round(num * Math.pow(10, 2)) / Math.pow(10, 2);
	return result;
}

function compute_total() {
	var total = Number($("#cost_items_consultation").val()) + Number($("#cost_items_medications_total").text())
			+ Number($("#cost_items_tests_total").text());
	$("#cost_items_total").text(parse_round_number(total));
	$("#paid_amount").val(parse_round_number(total));
}

//on medication qty change
function update_medication_table(){
	var total = 0;
	$('#cost_table tr').not(':first').not(':last').each(function(){
		var row_id = $(this).attr("id");
		total = total + update_medication_test_tables(row_id);
	});
	$("#cost_items_medications_total").text(parse_round_number(total));
	compute_total();
}
//on test qty change
function update_test_table(){
	var total = 0;
	$('#test_cost_table tr').not(':first').not(':last').each(function(){
		var row_id = $(this).attr("id");
		total = total + update_medication_test_tables(row_id);
	});
	$("#cost_items_tests_total").text(total);
	compute_total();
}

//Common method for both test and medication table update.
function update_medication_test_tables(row_id){
	var row_id_arr = row_id.split("_");
	var index =  row_id_arr[2];
	var updated_qty = 1;
	var type = $("#cost_items_"+index+"_type").val();
	if(type !== "service"){
		if(isNaN(parseFloat($("#cost_items_"+index+"_number").val()))){
			alert($("#cost_items_"+index+"_number").val()+ " is not a valid number!");
			$("#cost_items_"+index+"_number").val("0");
			$("#cost_items_"+index+"_number").focus();
			updated_qty = 0;
		}else{
			updated_qty = parseFloat($("#cost_items_"+index+"_number").val());
		}
		
	}
	var rate = $("#cost_items_"+index+"_rate").val();
	var cost = updated_qty * rate;
	if(type !== "test"){
		$("#cost_items_"+index+"_total").text(parse_round_number(cost));
	}
	return cost;
}
