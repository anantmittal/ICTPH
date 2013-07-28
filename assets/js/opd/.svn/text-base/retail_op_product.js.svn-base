var products_ordered_arr = new Array();

$(document)
		.ready(
				function() {
					show_hide_medications();
					$("#medication_row_id").val(1);
					$("#bill_amount").val(0);
					$("#bill_amount_visible").text(0);
					$('#product_given_out').attr("checked", false);
					//$("#opd_visit_id").attr("disabled", true);
					$("#opd_product_name").local_autocomplete(
							order_opd_products_list, "opd_product_id",
							"opd_product_rate", "opd_product_retail_unit",
							"opd_product_purchase_unit", "", "opd_product_mrp",
							"product_given_out");

					$("#opd_product_name").val('');
					$("#opd_product_quantity").val('');
					$("#opd_visit_id").val('');
					$('#opd_product_retail_unit').text('');
					$('#opd_product_purchase_unit').text('');

					var fields = [ "name", "quantity" ];

					$('#add_opd_product').click(function() {
										if ($.inArray($("#opd_product_id").val(), products_ordered_arr) !== -1) {
											alert("OP Product already added");
											return;
										}

										if ($.trim($("#opd_product_quantity").val()) != "") {
											var quantity = $('#opd_product_quantity').val();
											var bool = /^[0-9]+$/.test(quantity);
											if (!bool)
												return;
										}

										if ($.trim($("#opd_product_name").val()) == "" || $.trim($("#opd_product_quantity").val()) == "") {
											return;
										}

										$('#error_add_row').hide();

										var m = '<tr>';
										var total = Number($(
												"#opd_product_rate").val()
												* $("#opd_product_quantity")
														.val());
										var bill_amount = Number($(
												"#bill_amount").val());
										var new_bill_amount = Number(total
												+ bill_amount);
										var i = parseInt($("#medication_row_id")
												.val());
										$("#medication_row_id").val(i + 1);

										for ( var k in fields) {
											var v = $(
													"#opd_product_" + fields[k])
													.val();
											m += '<td>'
													+ v
													+ '<input type="hidden" id="medication_'
													+ i + '_' + fields[k]
													+ '" name="medication[' + i
													+ '][' + fields[k]
													+ ']" value="' + v + '"/>'
													+ '</td>';
										}
										$("#opd_product_name").val('');
										m += '<input type="hidden" name="medication['
												+ i
												+ '][product_id]" value="'
												+ $("#opd_product_id").val()
												+ '" id="medication_'
												+ i
												+ '_product_id"/>'
												+ '<input type="hidden" name="medication['
												+ i
												+ '][rate]" value="'
												+ $("#opd_product_rate").val()
												+ '" id="medication_'
												+ i
												+ '_rate"/>'
												+ '<input type="hidden" name="medication['
												+ i
												+ '][index]" value="'
												+ i
												+ '"/>'
												+ '<input type="hidden" name="medication[' + i +'][product_given]" value="' + $("#product_given_out:checked").val()  + '"/>'
												+ '<td>Opd Product<input type="hidden" id="medication_'
												+ i
												+ '_type" name="medication['
												+ i
												+ '][type]" value="Opd Product"/></td>'
												+ '<td>'
												+ $("#opd_visit_id").val()
												+ '<input type="hidden" id="medication_'
												+ i
												+ '_visit_id" name="medication['
												+ i
												+ '][visit_id]" value="'
												+ $("#opd_visit_id").val()
												+ '"/></td>'
												+ '<td>'
												+ $("#opd_product_rate").val()
												+ '</td>'
												+ '<td>'
												+ parse_round_number($(
														"#opd_product_rate")
														.val()
														* $(
																"#opd_product_quantity")
																.val())
												+ '</td>'
												+ '<td onmousedown="removeRow(this,'
												+ i
												+ ')"><a href="#" >Remove</a></td>'

												+ '</tr>';
										
										

										// compute_bill_amount();
										$("#bill_amount")
												.val(
														parse_round_number(new_bill_amount));
										$("#bill_amount_visible")
												.text(
														parse_round_number(new_bill_amount));
										$("#medications").append(m);
										show_hide_medications();
										$("#opd_visit_id").val('');
										$("#opd_product_quantity").val('');
										$("#opd_visit_id").attr("disabled",true);
										$("#opd_product_retail_unit").text('');
										$("#opd_product_purchase_unit").text('');
										$("#opd_product_mrp").text('');
										$('#edit_medication_box').hide();
										
										products_ordered_arr.push($("#opd_product_id").val());
									});

					$('#opd_product_name').change(function() {
						if ($.trim($("#opd_product_name").val()) == "") {

							$('#error_add_opd_product').show();
							return false;
						} else {
							$('#error_add_opd_product').hide();
							return true;
						}
						
					});

					$('#opd_product_quantity').change(function() {
						if ($.trim($("#opd_product_quantity").val()) == "") {
							$('#error_add_opd_quantity').show();
							$('#error_numeric_opd_quantity').hide();
							return false;
						} else {
							$('#error_add_opd_quantity').hide();
							var quantity = $('#opd_product_quantity').val();
							var bool = /^[0-9]+$/.test(quantity);
							if (!bool) {
								$('#error_numeric_opd_quantity').show();
								return false;
							} else {
								$('#error_numeric_opd_quantity').hide();
								return true;
							}
							return true;
						}
					});

					$("#opd_visit_id").val('');
					$("#product_given_out").click(function() {
						if (!$(this).is(":checked")) {
							$("#opd_visit_id").removeAttr("disabled");
							$("#opd_visit_id").val('');
						} else {
							$("#opd_visit_id").attr("disabled", true);
						}
						$("#opd_visit_id").val('');
						
					});
					$("#opd_visit_id").val('');
					
				});




function parse_round_number(num) {
	num = parseFloat(num);
	var result = Math.round(num * Math.pow(10, 2)) / Math.pow(10, 2);
	return result;
}

function ValidateForm(){
	clearAllErrorMessages();
	var retVal = true;
	var rowCount = $('#medications tr').length;	
	if(rowCount ==1){		
		$('#error_add_row').show();
		retVal = false;		
	}
	return retVal;
}

var compute_bill_amount = function() {
	var rows = parseInt($("#medication_row_id").val());
	total = 0.0;
	for ( var i = 0; i < 200; i++) {
		var name = $("#medication_" + i + "_name").val();
		if (name != "") {
			var qty = Number($("#medication_" + i + "_quantity").val());
			var rate = Number($("#medication_" + i + "_rate").val());
			var cost = qty * rate;

			total += cost;
		}
	}
	$("#bill_amount_visible").text(parse_round_number(total));
	$("#bill_amount").val(parse_round_number(total));
};

function removeRow(row, i) {
	var total = Number(Number($("#medication_" + i + "_rate").val())
			* Number($("#medication_" + i + "_quantity").val()));
	var bill_amount = Number($("#bill_amount").val());
	var new_bill_amount = Number(bill_amount - total);
	$("#bill_amount").val(parse_round_number(new_bill_amount));
	$("#bill_amount_visible").text(parse_round_number(new_bill_amount));
	$(row).parent().remove();
	show_hide_medications();
	//Remove from ordered queued array
	products_ordered_arr.splice($.inArray($("#medication_" + i + "_product_id").val(), products_ordered_arr), 1);
}
function show_hide_medications(){
	var rowCount = $('#medications tr').length;	
	if(rowCount > 1){		
		$("#medications").show(500);
	}else{
		$("#medications").hide(500);
	}
}
function clearAllErrorMessages(){
	$('.error').hide();
}
