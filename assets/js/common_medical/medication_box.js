$(document).ready(function(){
  // Following is required because refresh page refresh may not clear this
  // hidden variable
  $("#medication_row_id").val(1);

  $('#show_medication_box').click(function() {
    $('#edit_medication_box').toggle(500);
    $("#medication_name").val('');
	  $("#medication_duration").val('');
	  $("#opd_product_name").val('');
	  $("#opd_product_pieces").val('');
	  $('#opd_product_order_type').attr("checked", false);
	  $("#service_name").val('');
	  $("#medication_stock_qty").text('');
	  $("#op_product_stock_qty").text('');
  });

  //To Load drugs
  $("#medication_name").local_autocomplete(medications_list, "medication_product_id","medication_rate","","","medication_stock_qty");
 
  //To load opd products
  $("#opd_product_name").opd_product_autocomplete(opd_product_list, "opd_product_product_id","opd_product_rate","opd_product_order_type", "op_product_stock_qty");
  
  //To load services
  $("#service_name").local_autocomplete(service_list, "service_id","service_rate");
  
  var fields = ["name", "frequency", "duration", "duration_type","administration_route"];
  
  var medication_boxs = ["medication","opdproducts","services"];
  $("#medication_type").change(function(){
	  for (var box in medication_boxs){
		  if($(this).val() == medication_boxs[box]){
			  $("#"+medication_boxs[box]+"_box").show(500);
		  }else{
			  $("#"+medication_boxs[box]+"_box").hide(500);
		  }
	  }
	  $("#medication_name").val('');
	  $("#medication_duration").val('');
	  $("#opd_product_name").val('');
	  $("#opd_product_pieces").val('');
	  $('#opd_product_order_type').attr("checked", false);
	  $("#service_name").val('');
	  $("#medication_stock_qty").text('');
	  $("#op_product_stock_qty").text('');
  });
  //Add medications button click
  $('#add_medication').click(function() {
	  
	  //to prevent Nan values from getting added for Duration
	  if( $.trim($("#medication_duration").val())!="" ){
			var quantity=$('#medication_duration').val();
			if(isNaN(parseFloat(quantity))){
				return;
			}
		 }else{
			 return;
		 }
	  
	  if($("#medication_name").val() !=''){
		    var s = '<tr name = "medication_row">';
		    var i = parseInt($("#medication_row_id").val());
		    $("#medication_row_id").val(i+1);
		    for (var k in fields) {
		    	var v = $("#medication_" + fields[k]).val();
		    	if(fields[k] === "duration"){
		    		v = parseFloat($("#medication_" + fields[k]).val());
		    	}
		    	s += '<td>' + v
				+ '<input type="hidden" id="'+ fields[k] + '" value="' + v + '"/>'
				+ '</td>';
		    }
		    s += '<input type="hidden" value="' + $("#medication_product_id").val()  + '" id="product_id"/>'
		      + '<input type="hidden" value="' + $("#medication_rate").val()  + '" id="rate"/>'
		      + '<input type="hidden" value="' + i + '"/>'
		      + '<input type="hidden" value="' + $("#medication_type").val() + '" id="type"/>'
		      + '<td onclick="removeRow(this)"><a href="#">Remove</a></td>'
		      + '</tr>';
		 
		    $("#medications").append(s).show('slow');
		    $('#edit_medication_box').toggle(500);
	   }else{	
		   //"Please enter medication name" ;
		   $("#medication_name").val('Enter product name');
	   }
	  $("#medication_name").val('');
	  $("#medication_duration").val('');
	  $("#medication_stock_qty").text('');
	  $("#op_product_stock_qty").text('');
	  
  });
  
  //On change error display for Duration in Medication
  
  $('#medication_duration').change(function(){
		if($.trim($("#medication_duration").val()) != "" ){
			if(isNaN(parseFloat($("#medication_duration").val()))){
				$('#error_duration_quantity').show();
				return false;
			}else{
				$('#error_duration_quantity').hide();
				return true;
			}
			return true;
		}
	});
  
//Add opd product button click
  $('#add_opd_product').click(function() {
	  
	//to prevent Nan values from getting added for OPd Quantity
	  if( $.trim($("#opd_product_pieces").val())!="" ){
			var quantity=$('#opd_product_pieces').val();
			if(isNaN(parseFloat(quantity))){
				return;
			}
		 }else{
			 return;
		 }
	  
	  if($("#opd_product_name").val() !=''){
		    var s = '<tr name = "opd_product_row">';
		    var i = parseInt($("#medication_row_id").val());
		    $("#medication_row_id").val(i+1);
		    var opdProdName = $("#opd_product_name").val();
		    var numPieces = parseFloat($("#opd_product_pieces").val());	
		    s += '<td><input type="hidden" id="name" value="' + opdProdName + '"/>'+opdProdName+'</td>'
		      + '<td>&nbsp;</td>'
		      + '<td><input type="hidden" id="pieces" value="' + numPieces + '"/>'+numPieces+'</td>'
		      + '<td>&nbsp;</td>'
		      + '<td>&nbsp;</td>'
		      + '<input type="hidden" value="' + $("#opd_product_product_id").val()  + '" id="product_id"/>'
		      + '<input type="hidden" value="' + $("#opd_product_rate").val()  + '" id="rate"/>'
		      + '<input type="hidden" value="' + i + '"/>'
		      + '<input type="hidden" value="' + $("#medication_type").val() + '" id="type"/>'
		      + '<input type="hidden" value="' + $("#opd_product_order_type:checked").val()  + '" id="product_given_out"/>'
		      + '<td onclick="removeRow(this)"><a href="#">Remove</a></td>'
		      + '</tr>';
		    $("#opd_product_order_type:checked").val();
		    $("#medications").append(s).show('slow');
		    $('#edit_medication_box').toggle(500);
	   }else{	
		   //"Please enter medication name" ;
		   $("#medication_name").val('Enter product name');
	   }
	  $("#opd_product_name").val('');
	  $("#opd_product_pieces").val('');
	  $('#opd_product_order_type').attr("checked", false);
	  $("#medication_stock_qty").text('');
	  $("#op_product_stock_qty").text('');
  });
  
//On change error display for Duration in OPD Products
  
  $('#opd_product_pieces').change(function(){
		if($.trim($("#opd_product_pieces").val()) != "" ){
			if(isNaN(parseFloat($("#opd_product_pieces").val()))){
				$('#error_opd_quantity').show();
				return false;
			}else{
				$('#error_opd_quantity').hide();
				return true;
			}
			return true;
		}
	});
  
  

	//Add services button click
	$('#add_service').click(function() {
		  if($("#service_name").val() !=''){
			    var s = '<tr name = "service_row">';
			    var i = parseInt($("#medication_row_id").val());
			    $("#medication_row_id").val(i+1);
			    var serviceName = $("#service_name").val();
			    s += '<td><input type="hidden" id="name" value="' + serviceName + '"/>'+serviceName+'</td>'
			      + '<td>&nbsp;</td>'
			      + '<td>&nbsp</td>'
			      + '<td>&nbsp;</td>'
			      + '<td>&nbsp;</td>'
			      + '<input type="hidden" value="' + $("#service_id").val()  + '" id="service_id"/>'
			      + '<input type="hidden" value="' + $("#service_rate").val()  + '" id="rate"/>'
			      + '<input type="hidden" value="' + i + '"/>'
			      + '<input type="hidden" value="' + $("#medication_type").val() + '" id="type"/>'
			      + '<td onclick="removeRow(this)"><a href="#">Remove</a></td>'
			      + '</tr>';
			 
			    $("#medications").append(s).show('slow');
			    $('#edit_medication_box').toggle(500);
		   }else{	
			   //"Please enter medication name" ;
			   $("#medication_name").val('Enter product name');
		   }
		  $("#service_name").val('');
	});
});



function removeRow(row) {	
	$(row).parent().remove();
	//var i = row.parentNode.parentNode.rowIndex;
	//document.getElementById('medications').deleteRow(i);
}

