$(document).ready(function(){
  // Following is required because refresh page refresh may not clear this
  // hidden variable
  $("#medication_row_id").val(1);
  $("#bill_amount").val(0);
  $("#bill_amount_visible").text(0);
//  $("#medications").change(compute_bill_amount);


  $('#show_medication_box').click(function() {
    $('#edit_medication_box').show();
				  });

  //   medications_list = [ {id: '101', name:'Para kdjhfkjsdhfk/sdkjhfksjhfksd/sdjfh'}, {id:'102', name: 'Pare sdkjhfsk/ skjhdfksd ()'},{id:'103',name:'Sty'}, ];
  $("#medication_name").local_autocomplete(stock_medications_list, "medication_product_id","medication_rate");

  var fields = ["name", "batch_no","expiry","quantity"];
  
  $('#add_medication').click(function() {
    var s = '<tr>';
    var total = Number($("#medication_rate").val() * $("#medication_quantity").val());
    var bill_amount = Number($("#bill_amount").val());
    var new_bill_amount = Number(total + bill_amount);
    var i = parseInt($("#medication_row_id").val());
    $("#medication_row_id").val(i+1);

    for (var k in fields) {
      var v = $("#medication_" + fields[k]).val();
      s += '<td>' + v
	+ '<input type="hidden" id="medication_' + i + '_' + fields[k] + '" name="medication[' + i + '][' + fields[k] + ']" value="' + v + '"/>'
	+ '</td>';
    }
    s += '<input type="hidden" name="medication[' + i +'][product_id]" value="' + $("#medication_product_id").val()  + '" id="medication_' + i + '_product_id"/>'
      + '<input type="hidden" name="medication[' + i +'][rate]" value="' + $("#medication_rate").val()  + '" id="medication_' + i + '_rate"/>'
      + '<input type="hidden" name="medication[' + i +'][index]" value="' + i + '"/>'
      + '<td>' + $("#medication_rate").val()  + '</td>'
      + '<td>' + $("#medication_rate").val() * $("#medication_quantity").val()  + '</td>'
      + '<td onmousedown="removeRow(this)"><a href="#">Remove</a></td>'
      + '</tr>';
 
//	compute_bill_amount();
    $("#bill_amount").val(new_bill_amount);
    $("#bill_amount_visible").text(new_bill_amount);
    $("#medications").append(s);
    $('#edit_medication_box').hide();
			     });

var compute_bill_amount = function() {
    
    var rows = parseInt($("#medication_row_id").val());
    total = 0.0;
    for (var i = 0; i < 200; i++) {
      var name = $("#medication_" + i + "_name").val();
      if (name != "") {
	var qty =  Number($("#medication_" + i + "_quantity").val());
	var rate = Number($("#medication_" + i + "_rate").val());
	var cost = qty * rate;

	total += cost;
      }
    }
    $("#bill_amount_visible").text(total);
    $("#bill_amount").val(total);
  };

/*
  for (var i = 0; i <= 200; i++) {
    $("#medication_" + i + "_name").change(compute_bill_amount);
    $("#medication_" + i + "_rate").change(compute_bill_amount);
    $("#medication_" + i + "_quantity").change(compute_bill_amount);
  }
*/

});


function removeRow(row) {	
	$(row).parent().remove();
	var i = row.parentNode.parentNode.rowIndex;

    var j = i-1;
    var total = Number(Number($("#medication_"+j+"_rate").val()) * Number($("#medication_"+j+"_quantity").val()));
    var bill_amount = Number($("#bill_amount").val());
    var new_bill_amount = Number(bill_amount - total);
    $("#bill_amount").val(new_bill_amount);
    $("#bill_amount_visible").text(new_bill_amount);
	document.getElementById('medications').deleteRow(i);
}

